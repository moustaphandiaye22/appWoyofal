<?php

namespace App\entity;

use App\Core\Abstract\AbstractEntity;

class Achat extends    AbstractEntity {
    private int $id;
    private string $reference;
    private int $compteurnumero;
    private string $coderecharge;
    private float $nombrekwh;
    private float  $montant;
    private int  $tranche;
    private float $prixkwh;
    private \DateTime $dateachat;
    private  string $statut;


    public function __construct($id=0, $reference= '', $compteurnumero=0, $coderecharge='', $nombrekwh=0.0, $montant=0.0, $tranche=0, $prixkwh=0.0, $dateachat = null, $statut=StatusEnum::success)
    {
        $this->id = $id;
        $this->reference = $reference;
        $this->compteurnumero = $compteurnumero;
        $this->coderecharge = $coderecharge;
        $this->nombrekwh = $nombrekwh;
        $this->montant = $montant;
        $this->tranche = $tranche;
        $this->prixkwh = $prixkwh;
        if ($dateachat instanceof \DateTime) {
            $this->dateachat = $dateachat;
        } elseif (is_string($dateachat) && !empty($dateachat)) {
            $this->dateachat = new \DateTime($dateachat);
        } else {
            $this->dateachat = new \DateTime();
        }
        $this->statut =$statut;
    }
    public function getId(){
        return $this->id;
    }
    public function getReference(){
        return $this->reference;
    }
    public function getCompteurnumero(){
        return $this->compteurnumero;
    }
    public function getCoderecharge(){
        return $this->coderecharge;
    }
    public function getNombrekwh(){
        return $this->nombrekwh;
    }
    public function getMontant(){
        return $this->montant;
    }
    public function getTranche(){
        return $this->tranche;
    }
    public function getPrixkwh(){
        return $this->prixkwh;
    }
    public function getDateachat(){
        return $this->dateachat;
    }
    public function getStatut(){
        return $this->statut;
    }
    public function setId($id){
        $this->id = $id;
    }
    public function setReference($reference){
        $this->reference = $reference;
    }
    public function setCompteurnumero($compteurnumero){
        $this->compteurnumero = $compteurnumero;
    }
    public function setCoderecharge($coderecharge){
        $this->coderecharge = $coderecharge;
    }
    public function setNombrekwh($nombrekwh){
        $this->nombrekwh = $nombrekwh;
    }
    public function setMontant($montant){
        $this->montant = $montant;
    }
    public function setTranche($tranche){
        $this->tranche = $tranche;
    }
    public function setPrixkwh($prixkwh){
        $this->prixkwh = $prixkwh;
    }
    public function setDateachat($dateachat){
        if ($dateachat instanceof \DateTime) {
            $this->dateachat = $dateachat;
        } elseif (is_string($dateachat) && !empty($dateachat)) {
            $this->dateachat = new \DateTime($dateachat);
        }
    }
    public function setStatut($statut){
        $this->statut = $statut;
    }
    public function toArray(): array
    { 
        return [
            'id' => $this->getId(),
            'reference' => $this->getReference(),
            'compteurnumero' => $this->getCompteurnumero(),
            'coderecharge' => $this->getCoderecharge(),
            'nombrekwh' => $this->getNombrekwh(),
            'montant' => $this->getMontant(),
            'tranche' => $this->getTranche(),
            'prixkwh' => $this->getPrixkwh(),
            'dateachat' => $this->getDateachat() instanceof \DateTime ? $this->getDateachat()->format('Y-m-d H:i:s') : $this->getDateachat(),
            'statut' => $this->getStatut(),
        ];
    }
    public static function toObject(array $tableau): static
    {
        return new static(
            $tableau['id'] ?? 0,
            $tableau['reference'] ?? '',
            $tableau['compteurnumero'] ?? 0,
            $tableau['coderecharge'] ?? '',
            $tableau['nombrekwh'] ?? 0.0,
            $tableau['montant'] ?? 0.0,
            $tableau['tranche'] ?? 0,
            $tableau['prixkwh'] ?? 0.0,
            $tableau['dateachat'] ?? null,
            $tableau['statut'] ?? StatusEnum::success
        );
    }
    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

}
