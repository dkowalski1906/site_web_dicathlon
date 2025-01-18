<ul> 
    <?php 

echo('
<head>
<link rel="stylesheet" href="'.base_url().'CSS/product.css">
</head>
');

    //revenir en arrière

    echo('
    <div class="placement_retour">
        <a class="shop placement_bouton_retour" href="'.base_url().'index.php/produit/index">Retour</a>
    </div>
    ');

    //si c'est un agent -> suppression du produit

    if(isset($_SESSION["loggedin"]) && (($_SESSION["type"] === 'agent')||($_SESSION["type"] === 'admin'))){
        echo validation_errors();
        echo form_open("produit/supprimer_produit");
        echo('
        <input type="input"name="verif"hidden/><br/> 
        <input class="shop placement_bouton_suppr" type="submit"name="submit"value="Supprimer ce produit"/>
        </form>
        ');
    }

    //si c'est un utilisateur non connecté

    if(!(isset($_SESSION["loggedin"]) && ($_SESSION["loggedin"] === true))){
        echo('
        <a class="shop placement_bouton_suppr" href="'.base_url().'index.php/profil/creation_profil_verif/client">Créer un compte</a>
        ');
    }

    //affichage des détails du produit

    echo('
        <div class="boite-produit">
        <img class="produit" src="'.base_url().'ressources/thumbnails/1.png" alt="">

        <div class="description">
    ');
        foreach($un_produit as $element) {
            echo("
                <h1 class='nom-produit'>".$element->type."</h1>
                <h2 class='marque'>".$element->marque."</h2>
                <h2 class='modele'>".$element->modele."</h2>
                <ul>
                    <li>".$element->description."</li>
                    <li>État du produit : ".$element->etat."</li>
                    <li>Prix fixe de la location : ".$element->prix_location." €</li>
                </ul>
            ");
        }

    //parcours des locations existantes et affichage des dates

    foreach($tab_location as $element) {
        echo('<p>Produit non-disponible entre ');
        echo($element->date_debut.' et ');
        echo($element->date_retour_prevue.'</p>');
    }

    // choix de l'intervalle de date à partir d'un calendrier

    echo validation_errors();
    echo form_open('location/confirmation/1');
    echo('
    <label for="title">Date de début</label> 
    <input type="date"name="date_debut"/>

    <label for="title">Date de fin</label> 
    <input type="date"name="date_fin"/><br/> 

    <input class="shop" type="submit"name="submit"value="Valider"/>
    </form>
    </div>
    </div>
    ');


    ?>
</ul>