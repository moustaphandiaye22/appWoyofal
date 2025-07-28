<?php

namespace App\Entity;

use App\Core\Abstract\AbstractEntity;

class Client extends AbstractEntity {
    private int $id;
    private string $nom;
    private string $prenom;
    private string $adresse;
    private int $telephone;
    private string $numerocompteur;
    private float $soldePrincipal;


    public function __construct($id=0, $nom=' ', $prenom='', $adresse=' ', $telephone=0, $numerocompteur='', $soldePrincipal=0.0)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->adresse = $adresse;
        $this->telephone = $telephone;
        $this->numerocompteur = $numerocompteur;
        $this->soldePrincipal = $soldePrincipal;
    }

    public function getSoldePrincipal(): float
    {
        return $this->soldePrincipal;
    }

    public function setSoldePrincipal(float $solde): void
    {
        $this->soldePrincipal = $solde;
    }

        public function getId(){
            return $this->id;
        }
        public function getNom(){
            return $this->nom;
        }
        public function getPrenom(){
            return $this->prenom;
        }
        public function getAdresse(){
            return $this->adresse;
        }
        public function getTelephone(){
            return $this->telephone;
        }
        public function getNumerocompteur(){
            return $this->numerocompteur;
        }
        public function setId( $id){
            $this->id = $id;
        }
        public function setNom( $nom){
            $this->nom = $nom;
        }
        public function setPrenom( $prenom){
            $this->prenom = $prenom;
        }
        public function setAdresse( $adresse){
            $this->adresse = $adresse;
        }
        public function setTelephone( $telephone){
            $this->telephone = $telephone;
        }
        public function setNumerocompteur( $numerocompteur){
            $this->numerocompteur = $numerocompteur;
        }
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'nom' => $this->getNom(),
            'prenom' => $this->getPrenom(),
            'adresse' => $this->getAdresse(),
            'telephone' => $this->getTelephone(),
            'numerocompteur' => $this->getNumerocompteur(),
            'soldePrincipal' => $this->getSoldePrincipal(),
        ];  
    }
    public static function toObject(array $tableau): static
    {
        return new static(
            $tableau['id'] ?? 0,
            $tableau['nom'] ?? '',
            $tableau['prenom'] ?? '',
            $tableau['adresse'] ?? '',
            $tableau['telephone'] ?? 0,
            $tableau['numerocompteur'] ?? '',
            $tableau['soldePrincipal'] ?? $tableau['solde_principal'] ?? 0.0
        );
    }
        public function toJson(): string
        {
            return json_encode($this->toArray());
        }


        




}