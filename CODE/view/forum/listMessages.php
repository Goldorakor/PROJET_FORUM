<?php
use App\Session;

    $sujet = $result["data"]['sujet']; 
    $messages = $result["data"]['messages'];

    // $user = Session::getUser(); // on a besoin de récupérer les informations de l'utilisateur pour la suite (ne fonctionne ps bien)
    if(isset($_SESSION["user"])) { $user = $_SESSION["user"]; } else { $user = NULL; } // peut être écrit avec un opérateur ternaire
?>

<h1>Liste des messages du sujet : "<?= $sujet ?>"</h1> <!--  -->

<?php
if(isset($messages)) { // count($messages) > 0 -> il y a au moins un message
    foreach($messages as $message) { ?>
        <p>de <?= $message->getUser() ?> créé le <?= $message->getDateCreation() ?></p>
        <p><?= $message->getTexte() ?><?php } 
    } else {
        echo("Ce message est vide pour le moment.");
} ?>



<?php if ((isset($user)) AND ($sujet->getStatut() == 1)) { ?>

    <h3>Envoyer un message</h3>
<!-- formulaire pour ajouter un message à ce sujet de discussion -->
<form action="index.php?ctrl=forum&action=ajoutMessageBySujet&id=<?= $sujet->getId() ?>" method="POST">
    <label for="newTexte">Nouveau message :</label><br>
    <textarea id="newTexte" name="newTexte"></textarea><br><br>
    <input type="submit" name="submit" value="Submit">
</form>

<?php } else if ((isset($user)) AND ($sujet->getStatut() == 0)) { ?>

    <p>Ce sujet est vérouillé, il est impossible d'envoyer un nouveau message.</p>

<?php } else { ?>

    <p>Vous devez être connecté pour envoyer un message.</p>

<?php } ?>


<!-- index.php?ctrl=forum&action=listMessagesBySujet&id=   = $sujet->getId() -->

