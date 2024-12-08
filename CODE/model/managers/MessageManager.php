<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class MessageManager extends Manager {

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\Message";
    protected $tableName = "message";

    public function __construct(){
        parent::connect();
    }

    // récupérer tous les messages d'un sujet spécifique (par son id)
    public function findMessagesBySujet($id) {

        $sql = "SELECT * 
                FROM $this->tableName t 
                WHERE t.sujet_id = :id
                ORDER BY t.dateCreation DESC"; // je rajoute cette ligne pour trier les messages en fonction de l'ancienneté, les plus récents étant affichés en premier dans notre liste
       
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

}