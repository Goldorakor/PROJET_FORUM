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

}