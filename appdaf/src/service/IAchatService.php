<?php

namespace App\Service;

interface IAchatService {
    public function acheterCredit(string $numeroCompteur, float $montant): array;
}
