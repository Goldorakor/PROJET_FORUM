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


    public function index() {  // pour accéder à notre formulaire d'enregistrement - si besoin que index() serve à autre chose, on créera une méthode exprès pour accéder à ce formulaire
        
        return [
            "view" => VIEW_DIR."register.php",
            "meta_description" => "Formulaire d'inscription"
        ];  

    }

    public function afficheLogin() {  // pour accéder à notre formulaire de connexion
        
        return [
            "view" => VIEW_DIR."login.php",
            "meta_description" => "Formulaire de connexion"
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

                    // header("Location: index.php?ctrl=forum&action=index"); exit; // plus tard, remettre -> Location: index.php?ctrl=security&action=login
                    $this->redirectTo("forum", "index");

                } else {
                    // var_dump("utilisateur inexistant"); die;


                    // insertion de l'utilisateur en base de données car il n'existe pas encore

                    $pattern = "/^(?=(?:.*[A-Z]){2,})(?=.*[a-z])(?=.*[\W_])(?=.*[0-9]).{12,}$/"; // le format attendu pour notre mot de passe


                    if(($pass1 == $pass2) AND (preg_match($pattern, $pass1))) {


                        $userManager = new UserManager();
                        $user = $userManager->add($data); // définie un peu plus haut.

                        /* $insertUser = $pdo->prepare("INSERT INTO user (pseudonyme, email, password) VALUES (:pseudo, :email, :password)");
                        $insertUser->execute([
                            ":pseudonyme" => $pseudo,
                            ":email" => $email,
                            ":password" => password_hash($pass1, PASSWORD_DEFAULT), // on envoie le mot de passe haché pour stocker en BDD !   
                        ]);
                        */

                        // header("Location: index.php?ctrl=forum&action=index"); exit; // on emmène l'utilisateur sur la liste des catégories
                        $this->redirectTo("security", "login");
                        
                        
                        
                        /*return [
                            "view" => VIEW_DIR."forum/listCategories.php",
                            "meta_description" => "Formulaire d'inscription",
                            "data" => [
                                "user" => $user
                            ]
                        ];
                        */
                        

                        // header("Location: index.php?ctrl=forum&action=index"); exit;  Location: index.php?ctrl=security&action=login : si on est bien enregistré, on est naturellement redirigé vers login, pour pouvoir se 'loguer' sur le site
                    } else {
                        // message "Les mots de passe ne sont pas identiques ou mot de passe trop court ! -> l'utilisateur doit refaire la manipulation d'enregistrement
                        echo "Le mot de passe doit comporter au moins 2 majuscules, 1 minuscule, 1 chiffre, 1 caractère spécial et plus de 12 caractères en tout";
                        // header("Location: index.php?ctrl=security&action=index"); exit;
                        $this->redirectTo("security", "index");
                    }

                }

            } else {
                // problème de saisie dans les champs du formulaire -> l'utilisateur doit refaire la manipulation d'enregistrement
                // header("Location: index.php?ctrl=security&action=index"); exit;
                $this->redirectTo("security", "index");
            }
                
        }

        // par défaut, j'affiche le formulaire d'inscription
        // header("Location: index.php?ctrl=security&action=index"); exit;
        $this->redirectTo("security", "index");
        

    }


    public function login () {


        // on s'assure que le formulaire de login.php a bien été envoyé
        if($_POST["submit"]) {

            // connexion à la base de données
            // $pdo = new PDO("mysql:host=localhost; dbname=php_hash_colmar; charset=utf-8", "root", "");

            // // filtrer la saisie des champs du formulaire de connexion (faille XSS)
            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL); // contre faille XSS
            $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS); // contre faille XSS - Pa@ssWord123! pour nos tests

            // je vérifie que les filtres sont valides
            if($email AND $password) {

                // exactement la même situation que register()
                $userManager = new UserManager();
                // $user = $userManager->findOneById($id);
                $user = $userManager->findOneByEmail($email); // méthode ajoutée à la classe UserManager

                /*
                $requete = $pdo->prepare("SELECT * FROM user WHERE email = :email");
                $requete->execute([":email" => $email]); // requête préparée pour lutrer contre l'injection SQL
                $user = $requete->fetch();
                */


                // var_dump($user); die; -> on vérifie que tout fonctionne bien : on récupère un tableau avec les infos de l'utilisateur s'il existe ou on récupère un false si l'utilisateur n'existe pas.

                // est-ce que l'utilisateur existe ou non
                if($user) {

                    // on récupère le password de la BDD, stocké sous forme sécurisée
                    $hash = $user->getPassword(); // $hash = $user["password"] n'est pas valable puisque je manipule des objets et non des tableaux

                    // le if dessous renvoie un booléern : true si ça matche, false si ça ne matche pas
                    if(password_verify($password, $hash)) { // on compare $password (mot de passe saisi dans le formulaire) et $hash (stocké en base de données)

                        $_SESSION["user"] = $user; // je stocke en session l'intégralité des données du user -> l'utilisateur est donc connecté

                        $this->redirectTo("forum", "index"); // $this->redirectTo("forum", "index"); est peut être préférable que $this->redirectTo("home", "index");
                        // header("location : home.php"); exit;  dans forum : ("location : index.php?ctrl=home&action=index&id=x") -> controlleur s'appelle home et la méthode s'apelle index et l'id a le numéro x
                        // quand tout se passe bien, il nous redirige sur la page d'accueil - c'est le seul cas sinon partout ailleurs, il nous redirige sur login.php

                    } else {

                        $this->redirectTo("security", "afficheLogin");
                        // header("location : login.php"); exit;
                        // message utilisateur inconnu ou mot de passe incorrect -> assez vague pour ne pas aider un hacker ! 
                    }

                } else {

                    $this->redirectTo("security", "afficheLogin");
                    // header("location : login.php"); exit;
                    // message utilisateur inconnu ou mot de passe incorrect -> assez vague pour ne pas aider un hacker !
                }

            }

        }

        // header("location : login.php"); exit; -> version projet hash
        $this->redirectTo("security", "afficheLogin");


    }


    public function logout () {

        /*
        Les fonctions session_unset() et session_destroy() sont utilisées pour gérer la session en PHP. 
        Elles sont souvent utilisées ensemble pour réinitialiser ou terminer une session utilisateur.

        
        session_unset()
        Cette fonction vide toutes les variables de session. Cela signifie qu'elle supprime les données associées à la session en cours, mais sans détruire la session elle-même.
        La session reste active, et son identifiant (session_id) reste valide.

        - Elle agit uniquement sur les données stockées dans $_SESSION.
        - La session elle-même (identifiant, fichier de session) reste intacte.


        session_destroy()
        Cette fonction détruit complètement la session. Elle supprime le fichier de session sur le serveur et rend l'identifiant de session invalide.
        Après l'appel à session_destroy(), la session n'est plus utilisable.

        - Pour que la session soit réellement détruite, il faut d'abord la démarrer avec session_start().
        - Elle ne vide pas automatiquement les variables dans $_SESSION. Ces variables restent accessibles dans le script courant, mais elles ne sont plus liées à une session active.
        - Si on veut vraiment tout supprimer, on utilise session_unset() avant session_destroy().


        Conclusion : 
        session_unset() : vide les variables de session, mais conserve la session et son identifiant.
        session_destroy() : détruit la session sur le serveur et rend son identifiant invalide, mais les variables restent dans le script.

        On peut les utiliser ensemble pour une suppression complète des données de session et pour déconnecter un utilisateur proprement. 
        */

        // Vide toutes les données de la session
        session_unset();

        // Détruit la session
        session_destroy();

        // Redirige vers la page d'accueil
        $this->redirectTo("forum", "index");
    }


}

