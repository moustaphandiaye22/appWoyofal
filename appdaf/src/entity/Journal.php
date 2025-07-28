<?php

namespace App\Entity;

use App\Core\Abstract\AbstractEntity;
use App\Entity\StatusEnum;

class Journal extends AbstractEntity{

    private int $id;
    private \DateTime $dateheure;
    private string $localisation;
    private string $adresseIP;
    private StatusEnum $status;
    private string $numerocompteur;
    private string $coderecharge;
    private float $montantrecharge;
    private float $nombreKwt;

    public function __construct($id=0, $dateheure=null, $localisation='', $adresseIP='', $numerocompteur='', $coderecharge='', $montantrecharge=0.0, $nombreKwt=0.0, StatusEnum $status = StatusEnum::success)
    {
        $this->id = $id;
        if ($dateheure instanceof \DateTime) {
            $this->dateheure = $dateheure;
        } elseif (is_string($dateheure) && !empty($dateheure)) {
            $this->dateheure = new \DateTime($dateheure);
        } else {
            $this->dateheure = new \DateTime();
        }
        $this->localisation = $localisation;
        $this->adresseIP = $adresseIP;
        $this->status = $status;
        $this->numerocompteur = $numerocompteur;
        $this->coderecharge = $coderecharge;
        $this->montantrecharge = $montantrecharge;
        $this->nombreKwt = $nombreKwt;
    }
    
    public function getId(){
        return $this->id;   
    }   
    public function getLocalisation(){
        return $this->localisation;
    }
    
    public function getDateheure(){
        return $this->dateheure;
    }
    public function getAdresseIP(){
        return $this->adresseIP;
    }
    public function getStatus(){
        return $this->status;
    }
    public function getNumerocompteur(){
        return $this->numerocompteur;
    }
    public function getCoderecharge(){
        return $this->coderecharge;
    }
    public function getMontantrecharge(){
        return $this->montantrecharge;
    }
    public function getNombreKwt(){
        return $this->nombreKwt;
    }
    public function setId($id){
        $this->id = $id;
    }
    public function setDateheure($dateheure){
        if ($dateheure instanceof \DateTime) {
            $this->dateheure = $dateheure;
        } elseif (is_string($dateheure) && !empty($dateheure)) {
            $this->dateheure = new \DateTime($dateheure);
        }
    }
    public function setLocalisation( $localisation){
        $this->localisation = $localisation;
    }
    public function setAdresse($adresseIP){
        $this->adresseIP = $adresseIP;
    }
    public function setStatus($status){
        if ($status instanceof StatusEnum) {
            $this->status = $status;
        } elseif (is_string($status)) {
            $this->status = StatusEnum::from($status);
        }
    }
    public function setNumerocompteur($numerocompteur){
        $this->numerocompteur = $numerocompteur;
    }
    public function setCoderecharge($coderecharge){
        $this->coderecharge = $coderecharge;
    }
    public function setMontantrecharge($montantrecharge){
        $this->montantrecharge = $montantrecharge;
    }
    public function setNombreKwt($nombreKwt){
        $this->nombreKwt = $nombreKwt;
    }
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'dateheure' => $this->getDateheure() instanceof \DateTime ? $this->getDateheure()->format('Y-m-d H:i:s') : $this->getDateheure(),
            'localisation' => $this->getLocalisation(),
            'adresseIP' => $this->getAdresseIP(),
            'status' => $this->status->value,
            'numerocompteur' => $this->getNumerocompteur(),
            'coderecharge' => $this->getCoderecharge(),
            'montantrecharge' => $this->getMontantrecharge(),
            'nombreKwt' => $this->getNombreKwt(),
        ];
    }
    public function toJson(): string
    {
        return json_encode($this->toArray());
    }
    public static function toObject(array $tableau): static
    {
        $status = isset($tableau['status']) ? StatusEnum::from($tableau['status']) : StatusEnum::success;
        return new static(
            $tableau['id'] ?? 0,
            $tableau['dateheure'] ?? null,
            $tableau['localisation'] ?? '',
            $tableau['adresseIP'] ?? '',
            $status,
            $tableau['numerocompteur'] ?? '',
            $tableau['coderecharge'] ?? '',
            $tableau['montantrecharge'] ?? 0.0,
            $tableau['nombreKwt'] ?? 0.0
        );
    }

}
