<?php
echo ('
<head>
    <link rel="stylesheet" href="' . base_url() . 'CSS/valid-reservation.css">
</hd>
');
    //revenir en arrière

    echo('
    <div class="placement_retour">
        <a class="shop placement_bouton_retour" href="'.base_url().'index.php/produit/un_produit/'.$this->session->userdata('id_product').'">Retour</a>
    </div>
    ');

    //affichage détails de la location

    echo('
    <div class="placement_conf">
    <div class="confirmation main">
    <h1>Confirmation de commande</h1>
    <ul class="confirmation list">
        <li>
            <p class="dd titre">Date de début</p>
            <p class="dd value">2'.$date_debut.'</p>
        </li>
        <li>
            <p class="df titre">Date de fin</p>
            <p class="df value">'.$date_fin.'</p>
        </li>
        <li>
            <p class="prix titre">Prix final</p>
            <p class="prix value">'.$prix_total.'</p>
        </li>  
        <li>
    ');

        //formulaire caché pour confirmer

        echo validation_errors();
        echo form_open('location/confirmation/2');
        echo('
        <input type="date"name="date_debut" value="'.$date_debut.'" hidden/>
        <input type="date"name="date_fin" value="'.$date_fin.'" hidden/>
        <input type="number"name="prix" value="'.$prix_total.'" hidden/> 
        <input class="shop" type="submit"name="submit"value="Confirmer la location"/>
        </li>
    </ul>
    </div>
    </div>
    ');

?>