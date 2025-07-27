<?php

namespace App\Controller;

use App\Service\AchatService;
use Exception;

class AchatController {
    private $achatService;

    public function __construct(AchatService $achatService) {
        $this->achatService = $achatService;
    }

    // Exemple d'action pour traiter l'achat (à adapter selon votre routeur)
    public function acheter($request) {
        $compteurnumero = $request['compteurnumero'] ?? null;
        $montant = $request['montant'] ?? null;
        if (!$compteurnumero || !$montant) {
            return json_encode([
                'data' => null,
                'statut' => 'error',
                'code' => 400,
                'message' => 'Le numéro de compteur et le montant sont obligatoires'
            ]);
        }
        try {
            $achat = $this->achatService->acheter($compteurnumero, $montant);
            $client = $this->achatService->getClientByCompteur($achat->getCompteurnumero());
            return json_encode([
                'data' => [
                    'compteur' => $achat->getCompteurnumero(),
                    'reference' => $achat->getReference(),
                    'code' => $achat->getCoderecharge(),
                    'date' => $achat->getDateachat()->format('Y-m-d H:i:s'),
                    'tranche' => $achat->getTranche(),
                    'prix' => $achat->getPrixkwh(),
                    'nbreKwt' => $achat->getNombrekwh(),
                    'client' => $client ? ($client->getNom() . ' ' . $client->getPrenom()) : ''
                ],
                'statut' => 'success',
                'code' => 200,
                'message' => 'Achat effectué avec succès'
            ]);
        } catch (Exception $e) {
            $code = $e->getCode() ?: 500;
            $message = $e->getMessage();
            return json_encode([
                'data' => null,
                'statut' => 'error',
                'code' => $code,
                'message' => $message
            ]);
        }
    }
}
