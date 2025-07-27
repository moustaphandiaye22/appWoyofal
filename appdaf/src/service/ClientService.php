<?php

namespace App\Service;
use App\Repository\ClientRepository;
use App\Entity\Client;
use App\Core\Abstract\Singleton;
use App\Repository\IClientRepository;

class ClientService extends Singleton implements IClientService {
    private IClientRepository $clientRepository;

    public function __construct(IClientRepository $clientRepository) {
        $this->clientRepository = $clientRepository;
    }

    public function getByCompteur($numerocompteur) {
        return $this->clientRepository->findByCompteur($numerocompteur);
    }

    public function exists($numerocompteur) {
        return $this->clientRepository->exists($numerocompteur);
    }

    public function create(Client $client) {
        return $this->clientRepository->insert($client);
    }
}