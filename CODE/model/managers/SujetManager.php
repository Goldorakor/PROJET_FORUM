<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class SujetManager extends Manager {

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\Sujet";
    protected $tableName = "sujet";

    public function __construct(){
        parent::connect();
    }

    // récupérer tous les sujets d'une catégorie spécifique (par son id)
    public function findSujetsByCategorie($id) {

        $sql = "SELECT * 
                FROM $this->tableName t 
                WHERE t.categorie_id = :id
                ORDER BY t.dateCreation DESC"; // je rajoute cette ligne pour trier les sujets en fonction de l'ancienneté, les plus récents étant affichés en premier dans notre liste
       
        // la requête renvoie plusieurs enregistrements --> getMultipleResults
        return  $this->getMultipleResults(
            DAO::select($sql, ['id' => $id]), 
            $this->className
        );
    }

    public function add($data) {
        //$keys = ['username' , 'password', 'email']
        $keys = array_keys($data);
        //$values = ['Squalli', 'dfsyfshfbzeifbqefbq', 'sql@gmail.com']
        $values = array_values($data);
        //"username,password,email"
        $sql = "INSERT INTO ".$this->tableName." 
                (".implode(',', $keys).") 
                VALUES
                ('".implode("','",$values)."')";
                //"'Squalli', 'dfsyfshfbzeifbqefbq', 'sql@gmail.com'"
        /*
            INSERT INTO user (username,password,email) VALUES ('Squalli', 'dfsyfshfbzeifbqefbq', 'sql@gmail.com') 
        */
        try{
            return DAO::insert($sql);
        }
        catch(\PDOException $e) {
            echo $e->getMessage();
            die();
        }
    }

    // peut-être inutile car on a déjà public function getStatut() dans Sujet.php
    public function getStatutBySujet($id) {

        $sql = "SELECT statut 
                FROM $this->tableName t 
                WHERE t.sujet_id = :id";
       
        // si la requête renvoie plusieurs enregistrements --> getMultipleResults()  - sinon getOneOrNullResult()
        return  $this->getOneOrNullResult(
            DAO::select($sql, ['id' => $id], false), // false car un seul résultat
            $this->className
        );
    }

    public function changeStatutBySujet($id, $statut) {

        $sql = "UPDATE $this->tableName t
                SET statut = :statut
                WHERE t.sujet_id = :id";
    
        return DAO::update($sql, ['statut' => $statut,'id' => $id]); // public static function update($sql, $params) dans DAO.php -> 2 paramètres ici
    }

    /*
    public function changeStatutBySujet2($id) {

        if $this->className->getStatut = 0 {

            $sql = "UPDATE $this->tableName t
                SET statut = 1
                WHERE t.sujet_id = :id";
        } else {

            $sql = "UPDATE $this->tableName t
                SET statut = 0
                WHERE t.sujet_id = :id";
        }
    
        return DAO::update($sql, ['id' => $id]); // public static function update($sql, $params) dans DAO.php -> 2 paramètres ici
    }
    */

    // L'opération XOR est supportée par la plupart des moteurs SQL majeurs.
    // l'opération XOR avec 1 inverse la valeur binaire d'une colonne
    public function changeStatutBySujet3($id) {

        $sql = "UPDATE $this->tableName t
                SET statut = statut XOR 1
                WHERE t.sujet_id = :id"; 
    
        return DAO::update($sql, ['id' => $id]); // public static function update($sql, $params) dans DAO.php -> 2 paramètres ici
    }

    // CASE est une construction SQL standard et fonctionne partout. : on choisit cette méthode par défaut
    public function changeStatutBySujet4($id) {

        $sql = "UPDATE $this->tableName t
                SET statut = CASE WHEN statut = 1 THEN 0 ELSE 1 END
                WHERE t.id_".$this->tableName." = :id"; //  id_".$this->tableName." = :id
    
        return DAO::update($sql, ['id' => $id]); // public static function update($sql, $params) dans DAO.php -> 2 paramètres ici
    }

}