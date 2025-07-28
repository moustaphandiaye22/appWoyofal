<?php
// Tableau de routes sans le préfixe /api
return [
    // Health Check
    [
        'method' => 'GET',
        'path' => '/health',
        'action' => function() {
            header('Content-Type: application/json');
            echo json_encode([
                'data' => ['status' => 'ok', 'timestamp' => date('Y-m-d H:i:s')],
                'statut' => 'success',
                'code' => 200,
                'message' => 'Appwoyofal API is running'
            ]);
        }
    ],
    // Routes AppWoyofal
    // Création d'un client
    [
        'method' => 'POST',
        'path' => '/clients',
        'controller' => 'ClientController',
        'action' => 'creer'
    ],
    // Recherche client par numéro de compteur
    [
        'method' => 'GET',
        'path' => '/client/{compteur}',
        'controller' => 'ClientController',
        'action' => 'chercherParCompteur'
    ],
    // Achat woyofal
    [
        'method' => 'POST',
        'path' => '/achat',
        'controller' => 'AchatController',
        'action' => 'acheter'
    ],
    // Historique des achats (journal)
    [
        'method' => 'GET',
        'path' => '/journal',
        'controller' => 'JournalController',
        'action' => 'historique'
    ],
   
];




