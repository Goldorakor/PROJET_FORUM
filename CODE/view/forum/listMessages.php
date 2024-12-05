<?php
    $sujet = $result["data"]['sujet']; 

    $messages = $result["data"]['messages']; 
?>

<h1>Liste des messages du sujet : "<?= $sujet ?>"</h1>

<?php
if(isset($messages)) {
    foreach($messages as $message) { ?>
        <?php var_dump($message); ?>
        <p>de <?= $message->getUser() ?> créé le <?= $message->getDateCreation()->formatDate() ?></p>
        <p><?= $message->getTexte() ?><?php } 
} else {
    echo("Ce message est vide pour le moment.");
}?>