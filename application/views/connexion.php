<?php

    //revenir en arrière

    echo('
    <div class="placement_retour">
        <a class="shop placement_bouton_retour" href="'.base_url().'index.php/profil/profil">Retour</a>
    </div>
    ');

    //lformulaire pour se connecter

    echo('    
    <div class="formaccount">
        <h1 class="formaccount">Je me connecte</h1>
    ');
    echo validation_errors();
    echo form_open('connexion/connexion_verif', $attributes = 'class="formaccount"');
    echo('
    <label for="title">Nom d\'utilisateur</label> 
    <input type="input" name="nom_utilisateur"/>

    <label for="title">Mot de passe</label> 
    <input type="password" name="mdp"/>

    <input type="submit" name="submit" class="shop" value="Se connecter"/> 
    </form>
    ');

    //lien vers la page de création de profil

    echo('
    <a class="shop" href="'.base_url().'index.php/profil/creation_profil_verif/client">Créer un compte</a>
    </div>
    ');

?>