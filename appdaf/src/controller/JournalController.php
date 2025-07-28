<?php

namespace App\Controller;

use App\Service\JournalService;
use Exception;

class JournalController {
    private $journalService;

    public function __construct(JournalService $journalService) {
        $this->journalService = $journalService;
    }

    public function historique($request = []) {
        // Création d'un journal de recherche
        $journal = new \App\Entity\Journal(
            0, // id
            new \DateTime(), // dateheure
            '', // localisation
            $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1', // adresseIP
            $request['numerocompteur'] ?? '', // numerocompteur
            '', // coderecharge
            0.0, // montantrecharge
            0.0, // nombreKwt
            \App\Entity\StatusEnum::success // status
        );
        
        $this->journalService->enregistrer($journal);
        echo json_encode([
            'statut' => 'success',
            'code' => 200,
            'message' => 'Recherche journalisée avec succès'
        ]);
    }
}
