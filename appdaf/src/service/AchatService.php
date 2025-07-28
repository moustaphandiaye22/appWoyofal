<?php

namespace App\Service;

use App\Entity\Achat;
use App\Entity\Client;
use App\Entity\StatusEnum;
use App\Repository\IAchatRepository;
use App\Service\IClientService;
use App\Service\IJournalService;
use App\Entity\Journal;

class AchatService implements IAchatService {
    private IAchatRepository $achatRepository;
    private IClientService $clientService;
    private IJournalService $journalService;
    
    // Configuration des tranches (prix par kWh)
    private const TRANCHES = [
        1 => ['max' => 150, 'prix' => 96.85],    // Première tranche: 0-150 kWh
        2 => ['max' => 250, 'prix' => 101.36],   // Deuxième tranche: 151-250 kWh  
        3 => ['max' => PHP_INT_MAX, 'prix' => 118.45] // Troisième tranche: 251+ kWh
    ];

    public function __construct(IAchatRepository $achatRepository, IClientService $clientService, IJournalService $journalService) {
        $this->achatRepository = $achatRepository;
        $this->clientService = $clientService;
        $this->journalService = $journalService;
    }

    public function acheterCredit(string $numeroCompteur, float $montant): array {
        $journal = new Journal(
            0,
            new \DateTime(),
            '',
            $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
            $numeroCompteur,
            '',
            $montant,
            0.0,
            StatusEnum::echec
        );

        try {
            // Vérifier l'existence du compteur
            if (!$this->clientService->exists($numeroCompteur)) {
                $this->journalService->enregistrer($journal);
                return [
                    'data' => null,
                    'statut' => 'error',
                    'code' => 404,
                    'message' => 'Le numéro de compteur non retrouvé'
                ];
            }

            // Récupérer le client
            $client = $this->clientService->getByCompteur($numeroCompteur);
            
            // Vérifier la disponibilité du montant
            if ($client->getSoldePrincipal() < $montant) {
                $this->journalService->enregistrer($journal);
                return [
                    'data' => null,
                    'statut' => 'error', 
                    'code' => 400,
                    'message' => 'Solde insuffisant dans le compte principal'
                ];
            }

            // Calculer les kWh et la tranche
            $calculTranche = $this->calculerTrancheEtKwh($montant);
            
            // Générer le code de recharge (8 chiffres aléatoires)
            $codeRecharge = $this->genererCodeRecharge();
            
            // Générer la référence
            $reference = 'WOY' . date('YmdHis') . rand(100, 999);

            // Créer l'achat
            $achat = new Achat(
                0,
                $reference,
                $numeroCompteur,
                $codeRecharge,
                $calculTranche['kwh'],
                $montant,
                $calculTranche['tranche'],
                $calculTranche['prix_unitaire'],
                new \DateTime(),
                StatusEnum::success
            );

            // Sauvegarder l'achat
            $this->achatRepository->insert($achat);

            // Mettre à jour le journal avec succès
            $journal->setStatus(StatusEnum::success);
            $journal->setCoderecharge($codeRecharge);
            $journal->setNombreKwt($calculTranche['kwh']);
            $this->journalService->enregistrer($journal);

            // Retourner la réponse de succès
            return [
                'data' => [
                    'compteur' => $numeroCompteur,
                    'reference' => $reference,
                    'code' => $codeRecharge,
                    'date' => (new \DateTime())->format('Y-m-d H:i:s'),
                    'tranche' => $calculTranche['tranche'],
                    'prix' => $calculTranche['prix_unitaire'],
                    'nbreKwt' => $calculTranche['kwh'],
                    'client' => $client->getNom() . ' ' . $client->getPrenom()
                ],
                'statut' => 'success',
                'code' => 200,
                'message' => 'Achat effectué avec succès'
            ];

        } catch (\Exception $e) {
            $this->journalService->enregistrer($journal);
            return [
                'data' => null,
                'statut' => 'error',
                'code' => 500,
                'message' => 'Erreur interne du serveur: ' . $e->getMessage()
            ];
        }
    }

    private function calculerTrancheEtKwh(float $montant): array {
        $kwh_total = 0;
        $montant_restant = $montant;
        $tranche_atteinte = 1;

        // Tranche 1: 0-150 kWh à 96.85 FCFA/kWh
        $cout_tranche1 = 150 * self::TRANCHES[1]['prix']; // 150 * 96.85 = 14527.5 FCFA
        if ($montant <= $cout_tranche1) {
            // Reste dans la tranche 1
            $kwh_total = $montant / self::TRANCHES[1]['prix'];
            $tranche_atteinte = 1;
            $prix_unitaire = self::TRANCHES[1]['prix'];
        } else {
            $kwh_total += 150; // Consomme les 150 kWh de la tranche 1
            $montant_restant -= $cout_tranche1;
            
            // Tranche 2: 151-250 kWh (100 kWh) à 101.36 FCFA/kWh
            $cout_tranche2 = 100 * self::TRANCHES[2]['prix']; // 100 * 101.36 = 10136 FCFA
            if ($montant_restant <= $cout_tranche2) {
                // S'arrête dans la tranche 2
                $kwh_total += $montant_restant / self::TRANCHES[2]['prix'];
                $tranche_atteinte = 2;
                $prix_unitaire = self::TRANCHES[2]['prix'];
            } else {
                $kwh_total += 100; // Consomme les 100 kWh de la tranche 2
                $montant_restant -= $cout_tranche2;
                
                // Tranche 3: 251+ kWh à 118.45 FCFA/kWh
                $kwh_total += $montant_restant / self::TRANCHES[3]['prix'];
                $tranche_atteinte = 3;
                $prix_unitaire = self::TRANCHES[3]['prix'];
            }
        }

        return [
            'kwh' => round($kwh_total, 2),
            'tranche' => $tranche_atteinte,
            'prix_unitaire' => round($prix_unitaire, 2)
        ];
    }

    private function genererCodeRecharge(): string {
        return str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT);
    }
}
