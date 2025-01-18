<ul>
    <?php

      //revenir en arrière

      echo('
      <div class="placement_retour">
          <a class="shop placement_bouton_retour" href="'.base_url().'index.php/produit/index">Retour</a>
      </div>
      ');

      //formulaire pour créer un produit

      echo('    
        <div class="formaccount">
        <h1 class="formaccount">Créer un produit</h1>
      ');
      echo validation_errors();
      echo form_open('produit/ajout_produit', $attributes = 'class="formaccount"');
      echo ('
      <label>Type</label> 
      <input class="formatccount" type="input"name="type"/><br/> 

      <label>Description</label> 
      <input class="formatccount" type="input"name="desc"/><br/> 

      <label>Marque</label> 
      <input class="formatccount" type="input"name="marque"/><br/> 

      <label>Modèle</label> 
      <input class="formatccount" type="input"name="modele"/><br/> 

      <label>Prix de location par mois</label> 
      <input class="formatccount" type="number"name="prix"/><br/> 

      <label>État du produit</label> 
      <input class="formatccount" type="input"name="etat"/><br/>

      <input class="formatccount" type="submit"name="submit"value="Créer produit"/> 
      </form>
      </div>
      ');

    ?>
</ul>