<?php

namespace App\Repository;

use App\Entity\Achat;
use App\Core\Abstract\AbstractRepository;
use PDOException;

class AchatRepository extends AbstractRepository implements IAchatRepository{




    public function genererReference() {
        return 'REF-' . strtoupper(uniqid());
    }

    public function genererCodeRecharge() {
        return rand(100000000000, 999999999999);
    }

    public function insert($entity = null) {
        if (!$entity instanceof Achat) {
            return 0;
        }
        try {
            $query = "INSERT INTO achat (reference, compteurnumero, coderecharge, nombrekwh, montant, tranche, prixkwh, dateachat, statut) VALUES (:reference, :compteurnumero, :coderecharge, :nombrekwh, :montant, :tranche, :prixkwh, :dateachat, :statut)";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([
                'reference' => $entity->getReference(),
                'compteurnumero' => $entity->getCompteurnumero(),
                'coderecharge' => $entity->getCoderecharge(),
                'nombrekwh' => $entity->getNombrekwh(),
                'montant' => $entity->getMontant(),
                'tranche' => $entity->getTranche(),
                'prixkwh' => $entity->getPrixkwh(),
                'dateachat' => $entity->getDateachat() instanceof \DateTime ? $entity->getDateachat()->format('Y-m-d H:i:s') : $entity->getDateachat(),
                'statut' => $entity->getStatut()->value,
            ]);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

   





}