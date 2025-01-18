<?php
echo('
<head>
<link rel="stylesheet" href="'.base_url().'CSS/index.css">
<script src="'.base_url().'JS/header.js"></script>
</head>
');

//bandeau JS

echo('
<main id="main">
    <div class="bandeau">
        <p>RÉSERVER MON MATÉRIEL - </p>
        <p>RÉSERVER MON MATÉRIEL - </p>
        <p>RÉSERVER MON MATÉRIEL - </p>
        <p>RÉSERVER MON MATÉRIEL - </p>
        <p>RÉSERVER MON MATÉRIEL - </p>
        <p>RÉSERVER MON MATÉRIEL - </p>
        <p>RÉSERVER MON MATÉRIEL - </p>
        <p>RÉSERVER MON MATÉRIEL - </p>
    </div>
</main>
');

//si c'est un agent -> bouton créer un produit

if(isset($_SESSION["loggedin"]) && (($_SESSION["type"] === 'agent')||($_SESSION["type"] === 'admin'))){
    echo('
    <ul id="filtres">

        <a href="'.base_url().'index.php/produit/creer_produit">
            <li>
                <button class="shop">Créer un produit</button>
            </li>
        </a>
    </ul>
    ');
}
     

//boucle pour parcourirs tous les éléments et les afficher

echo('
<ul id="liste-produits">
');
foreach($produit as $element) {
    echo('
        <li class="produit boite">
            <a href="'.base_url().'index.php/produit/un_produit/'.$element->id.'">
            <img class="produit thumbnail" src="'.base_url().'ressources/thumbnails/1.png" alt="">
            <p>'.$element->type.'</p>
            </a>
        </li>
    ');
}
?>
</ul>