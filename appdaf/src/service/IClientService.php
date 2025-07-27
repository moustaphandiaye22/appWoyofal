<?php

namespace App\Service;

use App\Repository\ClientRepository;
use App\Entity\Client;

interface IClientService {
    public function getByCompteur($numerocompteur);
    public function exists($numerocompteur);
    public function create(Client $client);
}