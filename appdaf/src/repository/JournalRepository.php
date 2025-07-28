<?php
namespace App\Repository;

use App\Entity\Journal;
use App\Core\Abstract\AbstractRepository;
use PDOException;

class JournalRepository extends AbstractRepository  implements IJournalRepository {

    public function insert(Journal $journal) {
        try {
            $query = "INSERT INTO journal (dateheure, localisation, adresseIP, status, numerocompteur, coderecharge, montantrecharge, nombreKwt) VALUES (:dateheure, :localisation, :adresseIP, :status, :numerocompteur, :coderecharge, :montantrecharge, :nombreKwt)";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([
                'dateheure' => $journal->getDateheure()->format('Y-m-d H:i:s'),
                'localisation' => $journal->getLocalisation(),
                'adresseIP' => $journal->getAdresseIP(),
                'status' => $journal->getStatus()->value,
                'numerocompteur' => $journal->getNumerocompteur(),
                'coderecharge' => $journal->getCoderecharge(),
                'montantrecharge' => $journal->getMontantrecharge(),
                'nombreKwt' => $journal->getNombreKwt(),
            ]);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }



}

             
