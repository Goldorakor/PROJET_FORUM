<?php
namespace Controller;

use App\AbstractController;
use App\ControllerInterface;
use App\Session;
use Model\Managers\UserManager;
use Model\Managers\CategorieManager;
use Model\Managers\SujetManager;
use Model\Managers\MessageManager;
use Model\Managers\Manager;



class SecurityController extends AbstractController {
    // contiendra les méthodes liées à l'authentification : register, login et logout


    public function index() {
        
        return [
            "view" => VIEW_DIR."register.php",
            "meta_description" => "Formulaire d'inscription"
        ];
        

    }


    // on se sert de case "register" du Projet_HASH_prepaForum/traitement.php 
    public function register () {


        // on s'assure que le formulaire de register.php a bien été envoyé
        if($_POST["submit"]) {

            // connexion à la base de données
            // $pdo = new PDO("mysql:host=localhost; dbname=php_hash_colmar; charset=utf-8", "root", "");

            // filtrer la saisie des champs du formulaire d'inscription
            $pseudo = filter_input(INPUT_POST, "pseudonyme", FILTER_SANITIZE_FULL_SPECIAL_CHARS); // "peudonyme" = nom de l'élément que je souhaite filtrer
            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL);
            $pass1 = filter_input(INPUT_POST, "pass1", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $pass2 = filter_input(INPUT_POST, "pass2", FILTER_SANITIZE_FULL_SPECIAL_CHARS);


            $data = [
                'pseudonyme' => $pseudo,
                'email' => $email,
                'password' => password_hash($pass1, PASSWORD_DEFAULT) // on hache avant d'envoyer en BDD !! 
                ];


            if($pseudo && $email && $pass1 && $pass2) {
                // var_dump("ok"); die;  si les filtres passent, on affichera ok. sinon page blanche

                $userManager = new UserManager();
                $user = $userManager->findOneById($id);

                /*$requete = $pdo->prepare("SELECT * FROM user WHERE email = :email");
                $requete->execute([":email" => $email]);
                $user = $requete->fetch();
                */


                // si utilisateur existe (autrement dit, si $requete->fetch() nous renvoie bien une ligne), on ne veut pas l'inscrire dans notre BDD
                if($user) {
                    header("Location: index.php?ctrl=forum&action=index"); exit; // Location: index.php?ctrl=security&action=login
                } else {
                    // var_dump("utilisateur inexistant"); die;
                    // insertion de l'utilisateur en base de données car il n'existe pas encore
                    if(($pass1 == $pass2) AND (strlen($pass1) >= 5)) {


                        $userManager = new UserManager();
                        $user = $userManager->add($data); // définie un peu plus haut.

                        /* $insertUser = $pdo->prepare("INSERT INTO user (pseudonyme, email, password) VALUES (:pseudo, :email, :password)");
                        $insertUser->execute([
                            ":pseudonyme" => $pseudo,
                            ":email" => $email,
                            ":password" => password_hash($pass1, PASSWORD_DEFAULT), // on envoie le mot de passe haché pour stocker en BDD !   
                        ]);
                        */

                        header("Location: index.php?ctrl=forum&action=index"); exit; // on emmène l'utilisateur sur la liste des catégories
                        
                        
                        
                        /*return [
                            "view" => VIEW_DIR."forum/listCategories.php",
                            "meta_description" => "Formulaire d'inscription",
                            "data" => [
                                "user" => $user
                            ]
                        ];
                        */
                        

                        // header("Location: index.php?ctrl=forum&action=index"); exit;  Location: index.php?ctrl=security&action=login  yyyyyyyyyyyyyyyy si on est bien enregistré, on est naturellement redirigé vers login, pour pouvoir se 'loguer' sur le site
                    } else {
                        // message "Les mots de passe ne sont pas identiques ou mot de passe trop court ! -> l'utilisateur doit refaire la manipulation d'enregistrement
                        header("Location: index.php?ctrl=security&action=register"); exit;
                    }

                }

            } else {
                // problème de saisie dans les champs du formulaire -> l'utilisateur doit refaire la manipulation d'enregistrement
                header("Location: index.php?ctrl=security&action=register"); exit;
            }
                
        }

        // par défaut, j'affiche le formulaire d'inscription
        header("Location: index.php?ctrl=security&action=register"); exit;
        

    }




    public function login () {}




    public function logout () {}




}

