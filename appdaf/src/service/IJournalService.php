<?php
namespace App\Service;
use App\Repository\JournalRepository;
use App\Entity\Journal;

interface IJournalService {
    public function enregistrer(Journal $journal);
}