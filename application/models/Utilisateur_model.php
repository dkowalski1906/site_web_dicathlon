<?php 
    class Utilisateur_model extends CI_Model{ 
        public function __construct(){ 
            parent::__construct(); 
            $this->load->database(); 
        }

        //ajout d'un profil client

        public function add_profil($nom, $prenom, $ddn, $nom_utilisateur, $mdp, $mail){ 
            $data=array( 
                'nom'=>$nom,
                'prenom'=>$prenom, 
                'ddn'=>$ddn, 
                'login'=>$nom_utilisateur,
                'password'=>$mdp,
                'email'=>$mail,
                'type_utilisateur'=>'client'
            ); 
            return
            $this->db->insert('utilisateur',$data);
        }

        //ajout d'un profil agent

        public function add_profil_agent($nom, $prenom, $ddn, $nom_utilisateur, $mdp, $mail){ 
            $data=array( 
                'nom'=>$nom,
                'prenom'=>$prenom, 
                'ddn'=>$ddn, 
                'login'=>$nom_utilisateur,
                'password'=>$mdp,
                'email'=>$mail,
                'type_utilisateur'=>'agent'
            ); 
            return
            $this->db->insert('utilisateur',$data);
        }

        //modification d'un profil

        public function update_profil($id, $nom, $prenom, $ddn, $mdp, $mail, $type){ 
            $data=array( 
                'nom'=>$nom,
                'prenom'=>$prenom, 
                'ddn'=>$ddn, 
                'password'=>$mdp,
                'email'=>$mail,
                'type_utilisateur'=>$type
            ); 
            $this->db->where('id', $id);
            $this->db->update('utilisateur', $data);
        }


        //vérification du nom d'utilisateur

        public function check_username(){ 
            $query=$this->db->get('utilisateur');
            return $query->result(); 
        }

        //vérification du mot de passe

        public function check_password($nom_utilisateur){ 
            $query=$this->db->get_where('utilisateur', array('login' => $nom_utilisateur));
            return $query->result(); 
        }

        //récupérer informations d'un utilisateur

        public function get_user($id){ 
            $query=$this->db->get_where('utilisateur', array('id' => $id));
            return $query->result(); 
        }

        //vérification mail unique

        public function verif_unique(){ 
            $query=$this->db->get('utilisateur');
            return $query->result(); 
        }

        //supression d'un compte et des location liées au compte

        public function delete_account($id){ 
            return
            $this->db->delete('utilisateur', array('id' => $id));
        }

        public function delete_location($id){ 
            return
            $this->db->delete('location', array('utilisateur_id' => $id));
        }
    }
?>