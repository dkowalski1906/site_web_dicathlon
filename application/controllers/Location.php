<?php 
    class Location extends CI_Controller{ 
        public function __construct(){ 
            parent::__construct(); 
            $this->load->model('location_model');
            $this->load->model('produit_model');
            $this->load->library('session');
        } 

        //vérification du choix de l'intervalle de dates

        public function confirmation($step){ 
            $this->load->helper('form'); 
            $this->load->library('form_validation');

            $this->form_validation->set_rules('date_debut','Date de début','required');
            $this->form_validation->set_rules('date_fin','Date de fin','callback_verif_connection|callback_verif_date_coherence|callback_verif_date_dispo|callback_verif_duree_location');

            if($this->form_validation->run()===FALSE){ 
                $data['un_produit']=$this->produit_model->un_produit($this->session->userdata('id_product'));
                $data['content']='info_produits';
            } 
            else {

                //si on est à l'étape de confirmation => on ajoute la location à la BDD et on charge la page de profil

                if ($step == 2){
                    $date_debut=$this->input->post('date_debut');
                    $date_fin=$this->input->post('date_fin');
                    $prix=$this->input->post('prix');

                    $this->location_model->add_location($date_debut, $date_fin, $this->session->userdata('id_product'), $this->session->userdata('id_user'), $prix);
                    $data['tab_location_user'] = $this->location_model->user_rent($this->session->userdata('id_user'));

                    $data['content']='profil';
                }

                //si on est à la page du choix des dates => on passe à la page de confirmation

                else {

                    $data['date_debut']=$this->input->post('date_debut');
                    $data['date_fin']=$this->input->post('date_fin');

                    //prix fixe

                    $tab_produit_prix = $this->produit_model->un_produit($this->session->userdata('id_product'));
                    foreach($tab_produit_prix as $element) {
                        $prix_fixe = $element->prix_location;
                    }

                    //prix variable

                    $date_debut_s = $this->input->post('date_debut');
                    $date_fin_s = $this->input->post('date_fin');
                    $date_fin = strtotime($date_fin_s);
                    $date_debut = strtotime($date_debut_s);

                    //si < à 3 jours => gratuit

                    if (($date_fin - $date_debut) < 259200) {
                        $prix_var = 0;
                    }

                    //si entre 4 et 7 jours => 4% du montant en plus

                    if ((($date_fin - $date_debut) >= 259200)&&(($date_fin - $date_debut) < 691200)) {
                        $prix_var = $prix_fixe * 0.04;
                    }     

                    //si entre 8 et 14 jours => 2% du montant en plus

                    if ((($date_fin - $date_debut) >= 691200)&&(($date_fin - $date_debut) < 1296000)) {
                        $prix_var = $prix_fixe * 0.02;
                    }

                    //si entre 15 et 30 jours => 1% du montant en plus

                    if (($date_fin - $date_debut) >= 1296000) {
                        $prix_var = $prix_fixe * 0.01;
                    }
                    

                    $data['prix_total'] = $prix_fixe + $prix_var;
                    $data['content']='confirmation';
                }

                
            }
           
            $data['tab_location']=$this->location_model->date_dispo($this->session->userdata('id_product'));

            $this->load->vars($data); 
            $this->load->view('template');
        }

        //vérification de si l'utilisateur est connecté

        public function verif_connection(){ 

            if(isset($_SESSION["loggedin"]) && ($_SESSION["loggedin"] === true)){
                if(isset($_SESSION["loggedin"]) && ($_SESSION["type"] === 'client')){
                    return true;
                }
                else {
                    $this->form_validation->set_message('verif_connection' ,  'Vous devez être client pour choisir une location'); 
                    return false;
                }
 
            }
            else {
                $this->form_validation->set_message('verif_connection' ,  'Vous devez créer un compte pour choisir une location.'); 
                return false;
            }
        }


        //vérification de la cohérence des dates rentrées

        public function verif_date_coherence($date_fin){ 
            $date_debut=$this->input->post('date_debut');
            $date_fin = strtotime($date_fin);
            $date_debut = strtotime($date_debut);
            $currentDate = date('Y-m-d');
            $currentDate = strtotime($currentDate);

            //vérification si la date de début est après la date d'aujourd'hui

            if ($currentDate < $date_debut){

                //vérification si la date de retour est après la date de début

                if ($date_fin < $date_debut){
                    $this->form_validation->set_message('verif_date_coherence' ,  'La date de fin de location doit être après la date de début de location.'); 
                    return false;
                }
                else {
                    return true;
                }
            }
            else {
                $this->form_validation->set_message('verif_date_coherence' ,  'La date de début de location doit être après la date d\'aujourd\'hui'); 
                return false;
            }
        }



        //vérification de la disponibilité du produit

        public function verif_date_dispo($date_fin){ 

            //variables

            $date_debut=$this->input->post('date_debut');
            $date_fin_new = strtotime($date_fin);
            $date_debut_new = strtotime($date_debut);
            $flag = true;

            //parcours des locations

            $tab_location=$this->location_model->date_dispo($this->session->userdata('id_product'));
            foreach($tab_location as $element) {
                $date_debut_ex = $element->date_debut;
                $date_fin_ex = $element->date_retour_prevue;
                $date_debut_ex = strtotime($date_debut_ex);
                $date_fin_ex = strtotime($date_fin_ex);

                //vérification des dates de dispos

                if (!(($date_fin_new < $date_debut_ex) || ($date_debut_new > $date_fin_ex))) {
                    $flag = false;
                }
            }

            if ($flag === true) {
                return true;
            }
            else {
                $this->form_validation->set_message('verif_date_dispo' ,  'Ce produit est déjà loué sur cette période'); 
                return false;
            }
            
        }  

        //vérification de la durée du produit

        public function verif_duree_location($date_fin) {

            //variables

            $date_debut=$this->input->post('date_debut');
            $date_fin_new = strtotime($date_fin);
            $date_debut_new = strtotime($date_debut);

            if (($date_fin_new - $date_debut_new) > 2592000) {
                $this->form_validation->set_message('verif_duree_location' ,  'La location ne peut pas dépasser 30 jours'); 
                return false;
            }

            else {
                return true;
            }

        }
            
        
    }

?>