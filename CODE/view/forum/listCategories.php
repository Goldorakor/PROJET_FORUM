<?php
    $categories = $result["data"]['categories']; 
?>

<h1>Liste des catégories</h1>

<?php
foreach($categories as $categorie ) { ?>
    <p><a href="index.php?ctrl=forum&action=listSujetsByCategorie&id=<?= $categorie->getId() ?>"><?= $categorie->getLibelle() ?></a></p>
<?php }


  
