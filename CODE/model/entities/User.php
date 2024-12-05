<?php
namespace Model\Entities;

use App\Entity;

/*
    En programmation orientée objet, une classe finale (final class) est une classe que vous ne pouvez pas étendre, c'est-à-dire qu'aucune autre classe ne peut hériter de cette classe. En d'autres termes, une classe finale ne peut pas être utilisée comme classe parente.
*/

final class User extends Entity {

    private $id;
    private $pseudonyme;
    private $email;
    private $password;
    private $dateInscription;


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
     * Get the value of pseudonyme
     */ 
    public function getPseudonyme() {
        return $this->pseudonyme;
    }

    /**
     * Set the value of pseudonyme
     *
     * @return  self
     */ 
    public function setPseudonyme($pseudonyme) {
        $this->pseudonyme = $pseudonyme;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail() {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email) {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword() {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password) {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of dateInscription
     */ 
    public function getDateInscription() {
        return $this->dateInscription;
    }

    /**
     * Set the value of DateInscription
     *
     * @return  self
     */ 
    public function setDateInscription($dateInscription) {
        $this->dateInscription = $dateInscription;

        return $this;
    }

    public function __toString() {
        return $this->pseudonyme;
    }
}