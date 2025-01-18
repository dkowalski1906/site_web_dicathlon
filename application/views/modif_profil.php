<?php

//revenir en arrière

echo('
<div class="placement_retour">
    <a class="shop placement_bouton_retour" href="'.base_url().'index.php/profil/profil">Retour</a>
</div>
');

//modification de profil

    foreach($tab_user as $element){
       echo('    
       <div class="formaccount">
       <h1 class="formaccount">Modifier mes informations</h1>
        ');
        echo validation_errors();
        echo form_open('profil/modif_profil_verif', $attributes = 'class="formaccount"');
        echo('
        <label>Nom</label> 
        <input class="formaccount" type="input"name="nom" value="'.$element->nom.'"/>
        <label>Prénom</label> 
        <input class="formaccount" type="input"name="prenom" value="'.$element->prenom.'"/>

        <label>Date de naissance</label> 
        <input class="formaccount" type="date"name="ddn" value="'.$element->ddn.'"/>

        <label>Mot de passe</label> 
        <input class="formaccount" type="password"name="mdp"/>

        <label>Adresse mail</label> 
        <input class="formaccount" type="email" name="mail" value="'.$element->email.'"/>

        <input type="input" name="type" value="'.$element->type_utilisateur.'"hidden/>

        <input class="shop" type="submit" name="submit"value="Modifier"/> 
        </form>
        </div>
    ');
    }

?>