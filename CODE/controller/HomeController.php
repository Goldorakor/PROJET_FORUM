<?php
namespace Controller;

use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\MembreManager;

class HomeController extends AbstractController implements ControllerInterface {

    public function index(){
        return [
            "view" => VIEW_DIR."home.php",
            "meta_description" => "Page d'accueil du forum"
        ];
    }
        
    public function users(){
        $this->restrictTo("ROLE_USER");

        $manager = new MembreManager();
        $membres = $manager->findAll(['register_date', 'DESC']);

        return [
            "view" => VIEW_DIR."security/membres.php", // ou membre.php ?? 
            "meta_description" => "Liste des utilisateurs du forum",
            "data" => [ 
                "membres" => $membres 
            ]
        ];
    }
}
