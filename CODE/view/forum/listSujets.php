<?php
    $categorie = $result["data"]['categorie']; 

    $sujets = $result["data"]['sujets']; 
?>

<h1>Liste des sujets de la catégorie <?= $categorie ?></h1>

<?php
if(isset($sujets)) {
    foreach($sujets as $sujet) { ?>
    <p><a href="index.php?ctrl=forum&action=listMessagesBySujet&id=<?= $sujet->getId() ?>"><?= $sujet ?></a> par <?= $sujet->getUser() ?> créé le <?= $sujet->getDateCreation() ?></p> <?php } 
} else {
    echo("Cette section est vide pour le moment.");
}?>


<h3>Créer un sujet contenant un message</h3>
<!-- formulaire pour créer un sujet de discussion et y ajouter un premier message -->
<form action="index.php?ctrl=forum&action=newTopic&id=<?= $categorie->getId() ?>" method="POST">
    <label for="title">Nouveau sujet :</label><br>
    <input type="text" id="title" name="title"><br><br>
    <label for="firstPost">Nouveau message :</label><br>
    <textarea id="firstPost" name="firstPost"></textarea><br><br>
    <input type="submit" name="submit" value="Submit">
</form>

<!-- 
définition requête http : un message envoyé par un client (généralement un navigateur web) à un serveur web, dans le but de demander une ressource ou d'effectuer une action sur celle-ci 
-->