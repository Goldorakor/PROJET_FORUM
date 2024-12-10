<?php
    $categorie = $result["data"]['categorie']; 
    $sujets = $result["data"]['sujets']; 
?>

<h1>Liste des sujets de la catégorie <?= $categorie ?></h1>

<?php 
    if(isset($_SESSION["user"])) { $user = $_SESSION["user"]; } else { $user = NULL; } 
    //var_dump($user); 
    // var_dump($sujets);
?>

<?php

if(isset($sujets)) {
    foreach($sujets as $sujet) { //var_dump($sujet);?>

    <p><a href="index.php?ctrl=forum&action=listMessagesBySujet&id=<?= $sujet->getId() ?>"><?= $sujet ?></a> par <?= $sujet->getUser() ?> créé le <?= $sujet->getDateCreation() ?>
        <?php if ($sujet->getStatut() == 0) { ?>
            <i class="fa-solid fa-lock"></i>
        <?php } ?> </p>

    <?php 
        if((isset($user))  AND  (($sujet->getUser()->getId()) == ($user->getId()))) {  // sans (isset($user)), cela ne fonctionne pas ?> 

            <p><a href="index.php?ctrl=forum&action=verouillerDeverouillerSujet&id=<?= $sujet->getId() ?>">vérrouiller-dévérouiller</a></p>
        
        <?php }
    ?>


    <?php } 
} else {
    echo("Cette section est vide pour le moment.");
}?>


<?php if (isset($user)) { ?>

    <h3>Créer un sujet contenant un message</h3>
    <!-- formulaire pour créer un sujet de discussion et y ajouter un premier message -->
    <form action="index.php?ctrl=forum&action=newTopic&id=<?= $categorie->getId() ?>" method="POST">
        <label for="title">Nouveau sujet :</label><br>
        <input type="text" id="title" name="title"><br><br>
        <label for="firstPost">Nouveau message :</label><br>
        <textarea id="firstPost" name="firstPost"></textarea><br><br>
        <input type="submit" name="submit" value="Submit">
    </form>

<?php } else { ?>

    <p>Vous devez être connecté pour créer un nouveau sujet de discussion.</p>

<?php } ?>

<!-- 
définition requête http : un message envoyé par un client (généralement un navigateur web) à un serveur web, dans le but de demander une ressource ou d'effectuer une action sur celle-ci 
-->