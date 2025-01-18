<ul>
<?php 
 
    echo ('
    <head>
        <link rel="stylesheet" href="' . base_url() . 'CSS/create-account.css">
    </hd>
    ');

    //retour

    echo('
    <div class="placement_retour">
        <a class="shop placement_bouton_retour" href="'.base_url().'index.php/profil/profil">Retour</a>
    </div>
    ');
    
    
    //création de profil

    echo('    
    <div class="formaccount">
        <h1 class="formaccount">'.$titre.'</h1>
    ');

    echo validation_errors();
    echo form_open('profil/creation_profil_verif/'.$type, $attributes = 'class="formaccount"');
    echo('
    <label>Nom</label> 
    <input type="input" class="formaccount" name="nom"/>
    <label>Prénom</label> 
    <input class="formaccount" type="input"name="prenom"/> 
    <label>Date de naissance</label> 
    <input class="formaccount" type="date"name="ddn"/> 
    <label>Nom d\'utilisateur</label> 
    <input class="formaccount" type="input"name="nom_utilisateur"/> 
    <label>Adresse mail</label> 
    <input type="email" class="formaccount" name="mail"/>
    <label>Mot de passe</label> 
    <input class="formaccount" type="password" name="mdp"/>

    <input type="submit" name="submit" class="shop" value="Créer compte"/> 
    </form>
    </div>
    ');

?>
</ul>