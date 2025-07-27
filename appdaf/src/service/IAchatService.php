<?php

namespace App\Service;

interface IAchatService {
    public function getClientByCompteur($compteurnumero);
    public function acheter($compteurnumero, $montant);
    public function calculerTranche($montant);
    public function genererReference();
    public function genererCodeRecharge();

}
