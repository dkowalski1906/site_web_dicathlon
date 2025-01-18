<h1>Profil</h1>

<?php

    echo('
    <div class="placement_bouton_prof">
    ');

    //si on est connecté => on peut se déconnecter
    //si on est déconnecté => on peut se connecter

    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true){
        echo('
            <a class="shop shop_2" href="'.base_url().'index.php/connexion/deconnexion">Déconnexion</a>
        ');
    }     
    else {
        echo('
            <a class="shop shop_2" href="'.base_url().'index.php/connexion/connexion">Connexion</a>
        ');
    } 

    //lien vers la page de création de profil
    
    echo('
        <a class="shop shop_2"href="'.base_url().'index.php/profil/creation_profil_verif/client">Créer un compte</a>
    ');

    //si admin -> lien vers page de création agent

    if(isset($_SESSION["loggedin"]) && ($_SESSION["type"] === 'admin')){
        echo('
        <a class="shop shop_2" href="'.base_url().'index.php/profil/creation_profil_verif/agent">Créer un compte agent</a>
        ');
    }

    //lien vers la page de modification

    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true){
        echo('
        <a class="shop shop_2" href="'.base_url().'index.php/profil/modif_profil_verif">Modifier mes informations</a>
        ');
    }

    //bouton suppression de compte

    if(isset($_SESSION["loggedin"]) && ($_SESSION["type"] === 'client')){
        echo validation_errors();
        echo form_open('profil/supprimer/'.$this->session->userdata("id_user"));
        echo('
        <input type="number" name="verif" value="5"hidden/>
        <input class="shop shop_2" type="submit"name="submit"value="Supprimer mon compte"/>
        </form>
        ');
    }

    echo('
    </div>
    ');

    //message de bienvenue

    if(isset($_SESSION["loggedin"]) && ($_SESSION["loggedin"] == 'true')){    
        echo('
        <div class="utilisateur">
            <h2>Bonjour '.$_SESSION["nom_utilisateur"].'</h2>
        </div>
        ');
    }

    //si c'est un agent on parcours toutes les location qui ne sont pas encore finalisées <=> celles qui n'ont pas de date de retour effective

    if(isset($_SESSION["loggedin"]) && (($_SESSION["type"] === 'agent')||($_SESSION["type"] === 'admin'))){

        echo('
        <div class="admin">
            <h2>Gérer les réservations</h2>
        ');

        foreach($tab_location_agent as $element) {
            if($element->date_retour_effective === null){

                //affichage des infos

                echo('
                <div class="resa-clients">
                <ul class="confirmation list">
                    <li>
                        <span class="dd titre">ID du produit</span>
                        <span class="dd value">'.$element->type.'</span>
                    </li> 
                    <li>
                        <span class="dd titre">Nom locataire</span>
                        <span class="dd value">'.$element->login.'</span>
                    </li>
                    <li>
                        <span class="dd titre">Date de début</span>
                        <span class="dd value">'.$element->date_debut.'</span>
                    </li>
                    <li>
                        <span class="df titre">Date de fin</span>
                        <span class="df value">'.$element->date_retour_prevue.'</span>
                    </li>
                    <li>
                        <span class="prix titre">Prix</span>
                        <span class="prix value">'.$element->prix_total.'</span>
                    </li>

                </ul>
                ');


                //on reprend toutes les données de la location dans un formulaire
                echo form_open('profil/finalisation');
                echo('
                <input type="number"name="id"value="'.$element->big_id.'" hidden/>
                <input type="input"name="date_debut"value="'.$element->date_debut.'" hidden/>
                <input type="input"name="date_retour_prevue"value="'.$element->date_retour_prevue.'" hidden/>
                <input type="number"name="id_user"value="'.$element->id_user.'" hidden/>
                <input type="number"name="id_product"value="'.$element->id_product.'" hidden/>
                <input type="number"name="prix"value="'.$element->prix_total.'" hidden/>
                
                <input class="boutons final" type="submit"name="submit"value="Finaliser la location"/>
                </form>
                </div>
                ');
            }
        }

        echo('
        </div>
        ');
    }

    //affichage des locations pour chaque utilisateur

    if(isset($_SESSION["loggedin"]) && ($_SESSION["type"] === 'client')){
        
    echo('
        <div class="client">
        <h2>Mes réservations</h2>
    ');
    foreach($tab_location_user as $element) {

        echo('
        <div class="mareservation">
            <ul class="confirmation list">
                <li>
                    <span class="dd titre">ID du produit</span>
                    <span class="dd value">'.$element->produit_id.'</span>
                </li>
                <li>
                    <span class="dd titre">Date de début</span>
                    <span class="dd value">'.$element->date_debut.'</span>
                </li>
                <li>
                    <span class="df titre">Date de fin</span>
                    <span class="df value">'.$element->date_retour_prevue.'</span>
                </li>
                <li>
                    <span class="prix titre">Prix</span>
                    <span class="prix value">'.$element->prix_total.'</span>
                </li>
            </ul>
        ');


        echo validation_errors();
        echo form_open('profil/annuler_location/'.$element->id);
        echo('
        <input type="number"name="id"value="'.$element->id.'" hidden/>
        <input type="date"name="date_debut"value="'.$element->date_debut.'" hidden/>
        <input class="boutons final" type="submit"name="submit"value="Annuler la location"/>
        </form>
        ');
        
    
    echo('
        </div>
        ');
    }
    echo('
        </div>
        ');
}

    


?>