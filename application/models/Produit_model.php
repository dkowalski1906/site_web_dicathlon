<?php 
    class Produit_model extends CI_Model{ 
        public function __construct(){ 
            parent::__construct(); 
            $this->load->database(); 
        } 

        //tableau d'objets produit

        public function get_produits(){ 
            $query=$this->db->get('produit'); 
            return $query->result(); 
        }

        //tableau d'un objet produit choisi en fonction de l'ID

        public function un_produit($id){ 
            $query=$this->db->get_where('produit', array('id' => $id));
            return $query->result(); 
        }

        //ajout d'un produit

        public function add_product($type, $desc, $marque, $modele, $prix, $etat){ 
            $data=array( 
                'type'=>$type,
                'description'=>$desc, 
                'marque'=>$marque, 
                'modele'=>$modele,
                'prix_location'=>$prix,
                'etat'=>$etat,
            ); 
            return
            $this->db->insert('produit',$data);
        }

        //supression d'un produit

        public function delete_product($id){ 
            return
            $this->db->delete('produit', array('id' => $id));
        }

        //récupérer les locations d'un produit

        public function product_rent($id_product){
            $this->db->select('*');
            $this->db->from('location');
            $this->db->where(array('produit_id' => $id_product));
            $query = $this->db->get();
            return $query->result();
        }

    }
    /*manger du thon*/

?>



