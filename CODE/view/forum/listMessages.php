<?php
    $sujet = $result["data"]['sujet']; 

    $messages = $result["data"]['messages']; 
?>

<h1>Liste des messages du sujet : "<?= $sujet ?>"</h1>

<?php
if(isset($messages)) { // count($messages) > 0 -> il y a au moins un message
    foreach($messages as $message) { ?>
        <p>de <?= $message->getUser() ?> créé le <?= $message->getDateCreation() ?></p>
        <p><?= $message->getTexte() ?><?php } 
    } else {
        echo("Ce message est vide pour le moment.");
} ?>

<h3>Envoyer un message</h3>
<!-- formulaire pour ajouter un message à ce sujet de discussion -->
<form action="index.php?ctrl=forum&action=ajoutMessageBySujet&id=<?= $sujet->getId() ?>" method="POST">
    <label for="newTexte">Nouveau message :</label><br>
    <textarea id="newTexte" name="newTexte"></textarea><br><br>
    <input type="submit" name="submit" value="Submit">
</form>




<!-- index.php?ctrl=forum&action=listMessagesBySujet&id=   = $sujet->getId() -->