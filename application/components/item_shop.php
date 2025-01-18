<?php
    class ItemShop {
        public $item_id;
        public $type;
        public $description;
        public $marque;
        public $modele;
        public $prix_location;
        public $etat;
        public function __construct($id, $t, $desc, $ma, $mo, $prix, $status ){
            $item_id = $id;
            $type = $t;
            $description = $desc;
            $marque = $ma;
            $modele= $mo;
            $prix_location = $prix;
            $etat = $status;
        }
        /* public function {

        } */
    } 


?>