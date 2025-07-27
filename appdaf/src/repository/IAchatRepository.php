<?php

namespace App\Repository;

interface IAchatRepository {
    public function insert($achat);
    public function genererReference();
    public function genererCodeRecharge();
}
