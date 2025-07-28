<?php

namespace App\Controller;

use App\Service\IAchatService;

class AchatController {
    private IAchatService $achatService;

    public function __construct(IAchatService $achatService) {
        $this->achatService = $achatService;
    }

    public function acheter($request = []) {
        $numeroCompteur = $request['numerocompteur'] ?? null;
        $montant = (float) ($request['montant'] ?? 0);
        
        if (!$numeroCompteur || !$montant) {
            echo json_encode([
                'data' => null,
                'statut' => 'error',
                'code' => 400,
                'message' => 'Le numéro de compteur et le montant sont obligatoires'
            ]);
            return;
        }

        $result = $this->achatService->acheterCredit($numeroCompteur, $montant);
        echo json_encode($result);
    }
}
