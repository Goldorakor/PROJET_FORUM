<?php
namespace Model\Entities;

use App\Entity;

/*
    En programmation orientée objet, une classe finale (final class) est une classe que vous ne pouvez pas étendre, c'est-à-dire qu'aucune autre classe ne peut hériter de cette classe. En d'autres termes, une classe finale ne peut pas être utilisée comme classe parente.
*/

final class Sujet extends Entity {

    private $id;
    private $titre;
    private $user;
    private $categorie;
    private $dateCreation;
    private $statut;

    public function __construct($data) {         
        $this->hydrate($data);        
    }

    /**
     * Get the value of id
     */ 
    public function getId() {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Get the value of titre
     */ 
    public function getTitre() {
        return $this->titre;
    }

    /**
     * Set the value of titre
     *
     * @return  self
     */ 
    public function setTitre($titre) {
        $this->titre = $titre;
        return $this;
    }

    /**
     * Get the value of user
     */ 
    public function getUser() {
        return $this->user;
    }

    /**
     * Set the value of user
     *
     * @return  self
     */ 
    public function setUser($user) {
        $this->user = $user;
        return $this;
    }

    /**
     * Get the value of categorie
     */ 
    public function getCategorie() {
        return $this->categorie;
    }

    /**
     * Set the value of categorie
     *
     * @return  self
     */ 
    public function setCategorie($categorie) {
        $this->categorie = $categorie;
        return $this;
    }

    /**
     * Get the value of dateCreation
     */ 
    public function getDateCreation() {
        $dateObjet = new \DateTime ($this->dateCreation);
        $result = $dateObjet->format("d-m-Y H:i:s");
        return $result;
    }

    /**
     * Set the value of dateCreation
     *
     * @return  self
     */ 
    public function setDateCreation($dateCreation) {
        $this->dateCreation = $dateCreation;
        return $this;
    }

    /**
     * Get the value of statut
     */ 
    public function getStatut() {
        return $this->statut;
    }

    /**
     * Set the value of statut
     *
     * @return  self
     */ 
    public function setStatut($statut) {
        $this->statut = $statut;
        return $this;
    }

    public function __toString() {
        return $this->titre;
    }

}