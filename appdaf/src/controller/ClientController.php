<?php

namespace App\Controller;

use App\Service\ClientService;
use App\Entity\Client;
use Exception;

class ClientController {
    private $clientService;

    public function __construct(ClientService $clientService) {
        $this->clientService = $clientService;
    }

    // Créer un client
    public function creer($request) {
        try {
            $client = new Client(
                0,
                $request['nom'] ?? '',
                $request['prenom'] ?? '',
                $request['adresse'] ?? '',
                $request['telephone'] ?? 0,
                $request['numerocompteur'] ?? '',
                $request['soldePrincipal'] ?? 0.0
            );
            $result = $this->clientService->create($client);
            if ($result) {
                echo json_encode([
                    'data' => $client->toArray(),
                    'statut' => 'success',
                    'code' => 201,
                    'message' => 'Client créé avec succès'
                ]);
            } else {
                echo json_encode([
                    'data' => null,
                    'statut' => 'error',
                    'code' => 500,
                    'message' => 'Erreur lors de la création du client'
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                'data' => null,
                'statut' => 'error',
                'code' => 500,
                'message' => $e->getMessage()
            ]);
        }
    }

    // Rechercher un client par numéro de compteur
    public function chercherParCompteur($numerocompteur) {
        if (!$numerocompteur) {
            echo json_encode([
                'data' => null,
                'statut' => 'error',
                'code' => 400,
                'message' => 'Le numéro de compteur est obligatoire'
            ]);
            return;
        }
        $client = $this->clientService->getByCompteur($numerocompteur);
        if ($client) {
            echo json_encode([
                'data' => $client->toArray(),
                'statut' => 'success',
                'code' => 200,
                'message' => 'Client trouvé'
            ]);
        } else {
            echo json_encode([
                'data' => null,
                'statut' => 'error',
                'code' => 404,
                'message' => 'Client non trouvé'
            ]);
        }
    }
}
