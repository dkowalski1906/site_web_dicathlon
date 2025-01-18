<?php

echo('

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>validation reservation</title>
    <link rel="stylesheet" href="'.base_url().'CSS/style.css">
</head>
<body>
    <header id="header">
            <a href="'.base_url().'index.php" class="logo">
                <img src="'.base_url().'ressources/logo_fonce.png" alt="Logo dicathlon" class="logo">
            </a>

            <a class="profil" href="'.base_url().'index.php/profil/profil">');
            if (isset($_SESSION["loggedin"])){
                echo($_SESSION["nom_utilisateur"]." est connecté");
            }
            else {
                echo("Se connecter");
            }
            echo('<img src="'.base_url().'ressources/icons/profil.svg" class="profil">
            </a>

');

echo('
    </header>
');

?>