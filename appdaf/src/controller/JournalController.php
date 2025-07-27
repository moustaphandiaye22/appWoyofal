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
        $journal = new \App\Entity\Journal();
        if (isset($request['numerocompteur'])) {
            $journal->setNumerocompteur($request['numerocompteur']);
        }
        $journal->setDateheure(new \DateTime());
        $journal->setStatus('recherche');
        // Ajouter d'autres champs si besoin
        $this->journalService->enregistrer($journal);
        return json_encode([
            'statut' => 'success',
            'code' => 200,
            'message' => 'Recherche journalisée avec succès'
        ]);
    }
}
