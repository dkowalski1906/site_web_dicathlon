<?php 
    class Location_model extends CI_Model{ 
        public function __construct(){ 
            parent::__construct(); 
            $this->load->database(); 
        }

        //ajout d'une location

        public function add_location($date_debut, $date_fin, $id_product, $id_user, $prix){ 

            $data=array( 
                'date_debut'=>$date_debut,
                'date_retour_prevue'=>$date_fin, 
                'produit_id'=>$id_product, 
                'utilisateur_id'=>$id_user,
                'prix_total'=>$prix
            ); 
            return
            $this->db->insert('location',$data);
        }

        //récupérer toutes les locations pour un produit et vérification disponibilité du produit

        public function date_dispo($id_product){
            $query=$this->db->get_where('location', array('produit_id' => $id_product));
            return $query->result(); 
        }

        //récupérer toutes les locations pour finaliser les locations

        public function date_dispo_agent(){
            $this->db->select('location.id AS big_id, produit.id AS id_product, utilisateur.id AS id_user, produit.type, utilisateur.login, location.date_debut, location.date_retour_prevue, location.date_retour_effective, location.prix_total, location.id');
            $this->db->from('location');
            $this->db->join('produit', 'produit.id = location.produit_id');
            $this->db->join('utilisateur', 'utilisateur.id = location.utilisateur_id');
            $query = $this->db->get();
            return $query->result(); 
        }

        //ajout de données dans location pour finaliser la location

        public function finalization($id, $date_retour_effective, $date_debut, $date_retour_prevue, $id_product, $id_user, $prix) {
            $data = array(
                'date_retour_effective' => $date_retour_effective,
                'date_debut' => $date_debut,
                'date_retour_prevue' => $date_retour_prevue,
                'produit_id' => $id_product,
                'utilisateur_id' => $id_user,
                'prix_total' => $prix
            );
            
            $this->db->where('id', $id);
            $this->db->update('location', $data);
        }

        //récupérer les locations d'un utilisateur

        public function user_rent($id_user){
            $this->db->select('*');
            $this->db->from('location');
            $this->db->where(array('utilisateur_id' => $id_user));
            $query = $this->db->get();
            return $query->result();
        }

        //annulation location

        public function cancel_rent($id){ 
            return
            $this->db->delete('location', array('id' => $id));
        }

    }
?>