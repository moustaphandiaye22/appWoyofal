<?php


namespace App\Repository;
use App\Entity\Journal;

interface IJournalRepository {
    public function insert(Journal $journal);
}
