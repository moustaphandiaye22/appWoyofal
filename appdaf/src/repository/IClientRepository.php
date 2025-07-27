<?php

namespace App\Repository;
use App\Entity\Client;

interface IClientRepository {
    public function findByCompteur($numerocompteur);
    public function exists($numerocompteur);
    public function insert(Client $client);
}
