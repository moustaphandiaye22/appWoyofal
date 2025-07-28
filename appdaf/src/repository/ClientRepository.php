<?php

namespace App\Repository;

use App\Entity\Client;
use App\Core\Abstract\AbstractRepository;
use PDOException;

class ClientRepository extends AbstractRepository  implements IClientRepository {

    public function __construct() {
        parent::__construct();
    }

    public function findByCompteur($numerocompteur) {
        $query = "SELECT * FROM client WHERE numerocompteur = :numerocompteur";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':numerocompteur', $numerocompteur);
        $stmt->execute();
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $data ? Client::toObject($data) : null;
    }

    public function exists($numerocompteur) {
        $query = "SELECT COUNT(*) FROM client WHERE numerocompteur = :numerocompteur";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':numerocompteur', $numerocompteur);
        $stmt->execute();
        return (bool) $stmt->fetchColumn();
    }

    public function insert($entity = null) {
        if (!$entity instanceof Client) {
            return 0;
        }
        try {
            $query = "INSERT INTO client (nom, prenom, adresse, telephone, numerocompteur, solde_principal) VALUES (:nom, :prenom, :adresse, :telephone, :numerocompteur, :soldePrincipal)";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([
                'nom' => $entity->getNom(),
                'prenom' => $entity->getPrenom(),
                'adresse' => $entity->getAdresse(),
                'telephone' => $entity->getTelephone(),
                'numerocompteur' => $entity->getNumerocompteur(),
                'soldePrincipal' => $entity->getSoldePrincipal(),
            ]);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function selectAll() {
        // À implémenter selon la logique métier
        return [];
    }

    public function update($entity = null) {
        // À implémenter selon la logique métier
        return 0;
    }

    public function delete($entity = null) {
        // À implémenter selon la logique métier
        return 0;
    }

    public function selectById($id = null) {
        // À implémenter selon la logique métier
        return null;
    }

    public function selectBy(array $filtre) {
        // À implémenter selon la logique métier
        return [];
    }

}






