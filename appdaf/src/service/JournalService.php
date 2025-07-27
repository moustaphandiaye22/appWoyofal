<?php

namespace App\Service;

use App\Repository\JournalRepository;
use App\Entity\Journal;
use App\Repository\IJournalRepository;

class JournalService implements IJournalService {
    private IJournalRepository $journalRepository;

    public function __construct(IJournalRepository $journalRepository) {
        $this->journalRepository = $journalRepository;
    }

    public function enregistrer(Journal $journal) {
        return $this->journalRepository->insert($journal);
    }

    
}
