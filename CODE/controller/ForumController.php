<?php
namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\CategorieManager;
use Model\Managers\SujetManager;
use Model\Managers\MessageManager;
// use Model\Entities\User;


class ForumController extends AbstractController implements ControllerInterface {

    public function index() {
        
        // créer une nouvelle instance de CategoryManager
        $categorieManager = new CategorieManager();
        // récupérer la liste de toutes les catégories grâce à la méthode findAll de Manager.php (triés par nom)
        $categories = $categorieManager->findAll(["libelle", "DESC"]);

        // le controller communique avec la vue "listCategories" (view) pour lui envoyer la liste des catégories (data)
        return [
            "view" => VIEW_DIR."forum/listCategories.php",
            "meta_description" => "Liste des catégories du forum",
            "data" => [
                "categories" => $categories
            ]
        ];
    }

    public function listSujetsByCategorie($id) {

        $sujetManager = new SujetManager();
        $categorieManager = new CategorieManager();
        $categorie = $categorieManager->findOneById($id);
        $sujets = $sujetManager->findSujetsByCategorie($id);

        return [
            "view" => VIEW_DIR."forum/listSujets.php",
            "meta_description" => "Liste des sujets par catégorie : ".$categorie,
            "data" => [
                "categorie" => $categorie,
                "sujets" => $sujets
            ]
        ];
    }

    public function listMessagesBySujet($id) {

        $messageManager = new MessageManager();
        $sujetManager = new SujetManager();
        $sujet = $sujetManager->findOneById($id);
        $messages = $messageManager->findMessagesBySujet($id);

        return [
            "view" => VIEW_DIR."forum/listMessages.php",
            "meta_description" => "Liste des messages par sujet : ".$sujet,
            "data" => [
                "sujet" => $sujet,
                "messages" => $messages
            ]
        ];
    }

    // 
    public function ajoutMessageBySujet($id) { // pas modifié pour le moment


        // on applique les filtres aux données récupérées :

        $texte = filter_input(INPUT_POST, "newTexte", FILTER_SANITIZE_FULL_SPECIAL_CHARS); // 'newTexte' récup de notre formulaire de listMessages.php
        $user = 2; // on prend l'utilisateur 2 pour le moment
        $id = filter_input(INPUT_GET,"id", FILTER_SANITIZE_NUMBER_INT); // dans l'url : id = $sujet->getId()



        $data = [
            'texte' => $texte,
            'user_id' => 2,
            'sujet_id' => $id
            ];


        $messageManager = new MessageManager();
        $sujetManager = new SujetManager();
        $message = $messageManager->add($data); // et pas addMessage !! 

        header("Location: index.php?ctrl=forum&action=listMessagesBySujet&id=$id"); exit;
        
    }

    public function newTopic($id) { // pas modifié pour le moment


        // on applique les filtres aux données récupérées :
    
        $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $texte = filter_input(INPUT_POST, "firstPost", FILTER_SANITIZE_FULL_SPECIAL_CHARS); // 'newTexte' récup de notre formulaire de listMessages.php
        $user = 2; // on prend l'utilisateur 2 pour le moment
        $id = filter_input(INPUT_GET,"id", FILTER_SANITIZE_NUMBER_INT); // dans l'url : id = $categorie->getId()
    
    
    
        $messageManager = new MessageManager();
        $sujetManager = new SujetManager();
        
        $data1 = [
            'titre' => $title,
            // 'statut' => 1,
            'user_id' => 2,
            'categorie_id' => $id
            ];
            
        
        $sujetId = $sujetManager->add($data1);



        $data2 = [
            'texte' => $texte,
            'user_id' => 2,
            'sujet_id' => $sujetId
            ];


        $message = $messageManager->add($data2); // et pas addMessage !! 
    
        
        
        header("Location: index.php?ctrl=forum&action=listMessagesBySujet&id=$sujetId"); exit;
            
    }


}



