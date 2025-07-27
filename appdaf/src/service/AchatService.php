<?php

namespace App\Service;

use App\Core\Abstract\Singleton;
use App\Repository\ClientRepository;
use App\Repository\AchatRepository;
use App\Repository\JournalRepository;
use App\Entity\Journal;
use App\Entity\Achat;
use App\Entity\StatusEnum;
use App\Repository\IClientRepository;
use App\Repository\IAchatRepository;
use App\Repository\IJournalRepository;
use DateTime;

class AchatService extends Singleton implements IAchatService {

    private IClientRepository $clientRepository;
    private IAchatRepository $achatRepository;
    private IJournalRepository $journalRepository;

    public function __construct(IClientRepository $clientRepository, IAchatRepository $achatRepository, IJournalRepository $journalRepository) {
        $this->clientRepository = $clientRepository;
        $this->achatRepository = $achatRepository;
        $this->journalRepository = $journalRepository;
    }
     public function getClientByCompteur($compteurnumero) {
        return $this->clientRepository->findByCompteur($compteurnumero);
    }
   
    public function acheter($compteurnumero, $montant) {
        $client = $this->clientRepository->findByCompteur($compteurnumero);
        if (!$client) {
            throw new \Exception('Le numéro de compteur non retrouvé', 404);
        }
        if (method_exists($client, 'getSoldePrincipal') && $client->getSoldePrincipal() < $montant) {
            throw new \Exception('Solde insuffisant sur le compte principal', 402);
        }
        $resultatTranche = $this->calculerTranche($montant);
        $tranche = $resultatTranche['tranche'];
        $prixkwh = $resultatTranche['prixkwh'];
        $nombrekwh = $montant / $prixkwh;
        $reference = $this->genererReference();
        $coderecharge = $this->genererCodeRecharge();
        $dateachat = new DateTime();
        $achat = new Achat(
            0,
            $reference,
            $compteurnumero,
            $coderecharge,
            $nombrekwh,
            $montant,
            $tranche,
            $prixkwh,
            $dateachat,
            StatusEnum::success
        );
        $this->achatRepository->insert($achat);
        // Journalisation de l'achat
        $journal = new Journal(
            0,
            $dateachat,
            '', // localisation à compléter si disponible
            $_SERVER['REMOTE_ADDR'] ?? '',
            StatusEnum::success,
            $compteurnumero,
            $coderecharge,
            $montant,
            $nombrekwh
        );
        $this->journalRepository->insert($journal);
        return $achat;
    }

    // Exemple de logique de tranches (à adapter)
    public function calculerTranche($montant) {
        if ($montant <= 1000) {
            return ['tranche' => 1, 'prixkwh' => 50];
        } elseif ($montant <= 5000) {
            return ['tranche' => 2, 'prixkwh' => 75];
        } else {
            return ['tranche' => 3, 'prixkwh' => 100];
        }
    }

    public function genererReference() {
        return 'REF-' . strtoupper(uniqid());
    }

    public function genererCodeRecharge() {
        return rand(100000000000, 999999999999);
    }
}
