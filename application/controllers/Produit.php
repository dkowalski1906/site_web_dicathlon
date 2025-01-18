<?php 
    class Produit extends CI_Controller{ 
        public function __construct(){ 
            parent::__construct(); 
            $this->load->model('produit_model');
            $this->load->model('location_model');
            $this->load->library('session');
            $this->load->helper('url');
            $this->load->library('upload');
        } 

        //affichage de tous les produits
        
        public function index(){ 
            $data['produit']=$this->produit_model->get_produits();
            $data['content']='index'; 
            $this->load->vars($data); 
            $this->load->view('template');
        }

        //affichage des détails d'un produit en fonction de l'ID

        public function un_produit($id){ 
            $this->load->helper('form'); 
            $this->load->library('form_validation');
            $data['un_produit']=$this->produit_model->un_produit($id);
            $data['content']='info_produits';
            $this->session->set_userdata('id_product', $id);
            $data['tab_location']=$this->location_model->date_dispo($this->session->userdata('id_product'));
                
            
            $this->load->vars($data); 
            $this->load->view('template');
        }

        //si c'est un agent -> afficher un lien vers page de création de produit

        public function creer_produit(){ 
            $this->load->helper('form'); 
            $this->load->library('form_validation');
            $data['content']='creation_produit'; 
            $this->load->vars($data); 
            $this->load->view('template');
        }

        //si c'est un agent -> ajout du produit à la base de donnée

        public function ajout_produit(){ 
            $this->load->helper('form'); 
            $this->load->library('form_validation');
            $this->form_validation->set_rules('type','type','required');
            $this->form_validation->set_rules('desc','description','required');
            $this->form_validation->set_rules('marque','marque','required');
            $this->form_validation->set_rules('modele','modèle','required');
            $this->form_validation->set_rules('prix','prix','required');
            $this->form_validation->set_rules('etat','état','required');

            if($this->form_validation->run()===FALSE){ 
                $data['content']='creer_produit'; 
            } 
            else{ 
                $type=$this->input->post('type');
                $desc=$this->input->post('desc');
                $marque=$this->input->post('marque');
                $modele=$this->input->post('modele');
                $prix=$this->input->post('prix');
                $etat=$this->input->post('etat');

                $this->produit_model->add_product($type, $desc, $marque, $modele, $prix, $etat);
                $data['content']='index';
            }

            $data['produit']=$this->produit_model->get_produits();
            $this->load->vars($data); 
            $this->load->view('template');
        }

        //si c'est un agent -> suppression du produit de la base de données

        public function supprimer_produit(){ 
            $this->load->helper('form'); 
            $this->load->library('form_validation');
            $this->form_validation->set_rules('verif','verif','callback_verif_location_produit');

            if($this->form_validation->run()===FALSE){ 
                $data['content']='info_produits';
            } 

            else {
                $this->produit_model->delete_product($this->session->userdata('id_product'));
                $data['content']='index';
            }
            $data['un_produit']=$this->produit_model->un_produit($this->session->userdata('id_product'));
            $data['tab_location']=$this->location_model->date_dispo($this->session->userdata('id_product'));
            $data['produit']=$this->produit_model->get_produits();
            $this->load->vars($data);
            $this->load->view('template');
        }

        //vérification de si la location n'a pas encore démarrée

        public function verif_location_produit(){
            $tab = $this->produit_model->product_rent($this->session->userdata('id_product'));


            foreach($tab as $element){
                $this->form_validation->set_message('verif_location_produit' ,  'Vous ne pouvez pas supprimer ce produit si il est ou sera en location.'); 
                return false;
            }
            return true;
        }
    }
    

?>