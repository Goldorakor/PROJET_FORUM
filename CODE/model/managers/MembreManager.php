<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class MembreManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\Membre";
    protected $tableName = "membre";

    public function __construct(){
        parent::connect();
    }
}