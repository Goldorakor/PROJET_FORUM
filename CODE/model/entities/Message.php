<?php
namespace Model\Entities;

use App\Entity;

/*
    En programmation orientée objet, une classe finale (final class) est une classe que vous ne pouvez pas étendre, c'est-à-dire qu'aucune autre classe ne peut hériter de cette classe. En d'autres termes, une classe finale ne peut pas être utilisée comme classe parente.
*/

final class Message extends Entity {

    private $id;
    private $texte;
    private $membre;
    private $sujet;
    private $dateCreation;

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
     * Get the value of texte
     */ 
    public function getTexte() {
        return $this->texte;
    }

    /**
     * Set the value of texte
     *
     * @return  self
     */ 
    public function setTexte($texte) {
        $this->texte = $texte;
        return $this;
    }

    /**
     * Get the value of membre
     */ 
    public function getMembre() {
        return $this->membre;
    }

    /**
     * Set the value of membre
     *
     * @return  self
     */ 
    public function setMembre($membre) {
        $this->membre = $membre;
        return $this;
    }

    /**
     * Get the value of sujet
     */ 
    public function getSujet() {
        return $this->sujet;
    }

    /**
     * Set the value of sujet
     *
     * @return  self
     */ 
    public function setCategorie($sujet) {
        $this->sujet = $sujet;
        return $this;
    }

    /**
     * Get the value of dateCreation
     */ 
    public function getDateCreation() {
        return $this->dateCreation;
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

    /* je ne sais pas quoi retourner pour le __toString() de cette table, je le supprime pour le moment.
    public function __toString() {
        return $this->;
    }
    */
}