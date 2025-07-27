<?php

// Debug : Affichage d'informations système si ?debug=1
if (isset($_GET['debug'])) {
    echo "<h2>Debug Information</h2>";
    echo "<p><strong>Current directory:</strong> " . getcwd() . "</p>";
    echo "<p><strong>__DIR__:</strong> " . __DIR__ . "</p>";
    echo "<p><strong>Expected autoload path:</strong> " . __DIR__ . '/../vendor/autoload.php' . "</p>";
    echo "<p><strong>Autoload exists:</strong> " . (file_exists(__DIR__ . '/../vendor/autoload.php') ? 'YES' : 'NO') . "</p>";
    if (is_dir(__DIR__ . '/../vendor')) {
        echo "<p><strong>Vendor directory contents:</strong></p><ul>";
        foreach (scandir(__DIR__ . '/../vendor') as $file) {
            if ($file !== '.' && $file !== '..') {
                echo "<li>$file</li>";
            }
        }
        echo "</ul>";
    } else {
        echo "<p><strong>Vendor directory:</strong> NOT FOUND</p>";
    }
    echo "<p><strong>Root directory contents:</strong></p><ul>";
    foreach (scandir(__DIR__ . '/..') as $file) {
        if ($file !== '.' && $file !== '..') {
            echo "<li>$file</li>";
        }
    }
    echo "</ul>";
    exit;
}

// Vérification et chargement de l'autoloader Composer
$autoloadPath = __DIR__ . '/../vendor/autoload.php';
if (!file_exists($autoloadPath)) {
    http_response_code(500);
    die("❌ Error: Composer autoload file not found at: $autoloadPath<br>" .
        "Please run 'composer install' to install dependencies.<br>" .
        "Ajoutez ?debug=1 à l'URL pour plus d'informations.");
}
require_once $autoloadPath;

// Chargement des variables d'environnement (.env)
if (class_exists('Dotenv\\Dotenv')) {
    try {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
        $dotenv->load();
    } catch (Throwable $e) {
        // .env absent ou erreur de chargement : valeurs par défaut
    }
}

// Définir les headers CORS pour l'API
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

try {
    // Initialisation du conteneur IoC et du routeur
    \App\Core\App::initialize();
    \App\Core\Router::resolve();
} catch (Throwable $e) {
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode([
        'data' => null,
        'statut' => 'error',
        'code' => 500,
        'message' => 'Erreur interne du serveur: ' . $e->getMessage()
    ]);
}