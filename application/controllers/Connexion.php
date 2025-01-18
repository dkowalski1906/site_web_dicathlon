<?php 

    class Connexion extends CI_Controller{ 
        public function __construct(){ 
            parent::__construct(); 
            $this->load->model('utilisateur_model');
            $this->load->model('produit_model');
            $this->load->library('session');
        }

        //aller sur la page de connexion
    
        public function connexion(){ 
            $this->load->helper('form'); 
            $this->load->library('form_validation');
            $data['content']='connexion'; 
            $this->load->vars($data); 
            $this->load->view('template');
        }

        //vérification du formulaire

        public function connexion_verif(){ 
            $this->load->helper('form'); 
            $this->load->library('form_validation');
            $this->form_validation->set_rules('mdp','Mot de passe','callback_verif_login');

            if($this->form_validation->run()===FALSE){ 
                $data['content']='connexion'; 
            } 

            else{
                $nom_utilisateur=$this->input->post('nom_utilisateur');
                $tab_mdp_bdd=$this->utilisateur_model->check_password($nom_utilisateur);
                foreach($tab_mdp_bdd as $element) {
                    $_SESSION["loggedin"] = true;
                    $_SESSION["id"] = $element->id;
                    $_SESSION["nom_utilisateur"] = $element->login;
                    $_SESSION["type"] = $element->type_utilisateur;
                    $this->session->set_userdata('id_user', $element->id);
                }
                $data['content']='index';
                $data['produit']=$this->produit_model->get_produits();
            }

            
            $this->load->vars($data); 
            $this->load->view('template');
            
        }

        //vérification login

        public function verif_login(){ 
            $nom_utilisateur=$this->input->post('nom_utilisateur');
            $mdp=$this->input->post('mdp');

            //vérification du nom d'utilisateur
            $verif_username = false;
            $tab_utilisateur=$this->utilisateur_model->check_username();
            foreach($tab_utilisateur as $element) {
                if ($element->login === $nom_utilisateur){
                    $verif_username = true;
                }
            }

            if (($nom_utilisateur != '')&&($verif_username === true)){

                //vérification du mot de passe

                $tab_mdp_bdd=$this->utilisateur_model->check_password($nom_utilisateur);
                $mdp_bdd = $tab_mdp_bdd[0]->password;

                $hashed_mdp_rentre = md5($mdp);
                $login_verif = false;
                if ($hashed_mdp_rentre === $mdp_bdd){
                    return true;
                }
                else{
                    $this->form_validation->set_message('verif_login' ,  'Votre mot de passe est incorrect'); 
                    return false;
                }
            }  
            else {
                $this->form_validation->set_message('verif_login' ,  'Votre nom d\'utilisateur est incorrect'); 
                return false;
            }
        }

        //se déconnecter
    
        public function deconnexion(){ 
            unset($_SESSION['loggedin']);
            unset($_SESSION['id']);
            unset($_SESSION['nom_utilisateur']);
            unset($_SESSION['type']);

            session_destroy();

            $data['content']='index';
            $data['produit']=$this->produit_model->get_produits();
            $this->load->vars($data); 
            $this->load->view('template');
        }

        
    }
    

?>