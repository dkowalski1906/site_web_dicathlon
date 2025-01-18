<?php 

    class Profil extends CI_Controller{ 
        public function __construct(){ 
            parent::__construct(); 
            $this->load->model('location_model');
            $this->load->model('utilisateur_model');
            $this->load->model('produit_model');
            $this->load->library('session');
        }

        //aller sur la page de profil

        public function profil(){ 
            $this->load->helper('form'); 
            $data['content']='profil'; 
            $data['tab_location_agent'] = $this->location_model->date_dispo_agent();
            $data['tab_location_user'] = $this->location_model->user_rent($this->session->userdata('id_user'));
            $this->load->vars($data); 
            $this->load->view('template');
        }
    


        //création profil client

        public function creation_profil_verif($type){ 
            $this->load->helper('form'); 
            $this->load->library('form_validation');

            $this->form_validation->set_rules('nom','Nom','required');
            $this->form_validation->set_rules('prenom','Prenom','required');
            $this->form_validation->set_rules('ddn','Date de naissance','required|callback_age_verif');
            $this->form_validation->set_rules('nom_utilisateur','Nom d\'utilisateur','required|callback_login_unique');
            $this->form_validation->set_rules('mdp','Mot de passe','required');
            $this->form_validation->set_rules('mail','Mail','required|callback_mail_unique');

            if($this->form_validation->run()===FALSE){
                $data['type'] = $type;
                $data['content']='creation_profil'; 

                if ($type === 'client'){
                    $data['titre'] = 'Créer un compte';
                }
                else {
                    $data['titre'] = 'Créer un compte agent';
                }
            } 
            else{ 
                $nom=$this->input->post('nom');
                $prenom=$this->input->post('prenom');
                $ddn=$this->input->post('ddn');
                $nom_utilisateur=$this->input->post('nom_utilisateur');
                $mdp_s=$this->input->post('mdp');
                $mdp = md5($mdp_s);
                $mail=$this->input->post('mail');

                if ($type === 'client'){
                    $this->utilisateur_model->add_profil($nom, $prenom, $ddn, $nom_utilisateur, $mdp, $mail);
                }
                else {
                    $this->utilisateur_model->add_profil_agent($nom, $prenom, $ddn, $nom_utilisateur, $mdp, $mail);
                }

                $data['type'] = $type;
                $data['content']='profil';
            }
            $data['tab_location_agent'] = $this->location_model->date_dispo_agent();
            $data['tab_location_user'] = $this->location_model->user_rent($this->session->userdata('id_user'));
            $this->load->vars($data); 
            $this->load->view('template');
        }



         //modification info du profil (sauf login)

         public function modif_profil_verif(){ 
            $this->load->helper('form'); 
            $this->load->library('form_validation');

            $this->form_validation->set_rules('nom','Nom','required');
            $this->form_validation->set_rules('prenom','Prenom','required');
            $this->form_validation->set_rules('ddn','Date de naissance','required|callback_age_verif');
            $this->form_validation->set_rules('mdp','Mot de passe','required');
            $this->form_validation->set_rules('mail','Mail','required');


            if($this->form_validation->run()===FALSE){ 
                $data['content']='modif_profil'; 
            } 
            else{ 
                $nom=$this->input->post('nom');
                $prenom=$this->input->post('prenom');
                $ddn=$this->input->post('ddn');
                $mdp_s=$this->input->post('mdp');
                $mdp = md5($mdp_s);
                $mail=$this->input->post('mail');
                $type=$this->input->post('type');

                $this->utilisateur_model->update_profil($this->session->userdata('id_user'), $nom, $prenom, $ddn, $mdp, $mail, $type);
                $data['content']='profil';
            }

            $data['tab_user'] = $this->utilisateur_model->get_user($this->session->userdata('id_user'));

            $data['tab_location_agent'] = $this->location_model->date_dispo_agent();
            $data['tab_location_user'] = $this->location_model->user_rent($this->session->userdata('id_user'));
            $this->load->vars($data); 
            $this->load->view('template');
        }



        //vérification de la majorité

        public function age_verif($inputDate){
            $inputDate_strtotime = strtotime($inputDate);
            $currentDate = date('Y-m-d');
            $currentDate_strtotime = strtotime($currentDate);
            $age = $currentDate_strtotime - $inputDate_strtotime;

            if ($age < 567993600) {
                $this->form_validation->set_message('age_verif' ,  'Vous devez avoir au moins 18 ans pour vous inscrire.'); 
                return false;
            }
            else {
                return true; 
            }
        }

        //vérification unicité mail et login

        public function mail_unique($mail_rentre){
            $tab = $this->utilisateur_model->verif_unique();
            $result = false;
            foreach ($tab as $element){
                if ($mail_rentre === $element->email) {
                    $result = true;
                }
            }
            if($result === true) {
                $this->form_validation->set_message('mail_unique' ,  'Cet email existe déjà.'); 
                return false;
            }
            else {
                return true;
            }
        }

        public function login_unique($login_rentre){
            $tab = $this->utilisateur_model->verif_unique();
            $result = false;
            foreach ($tab as $element){
                if ($login_rentre === $element->login) {
                    $result = true;
                }
            }
            if($result === true) {
                $this->form_validation->set_message('login_unique' ,  'Ce login existe déjà.'); 
                return false;
            }
            else {
                return true;
            }
        }



        //finalisation des locations

        public function finalisation(){ 
            $this->load->helper('form');

            //récupération des paramètre de la table location existante

            $id=$this->input->post('id');
            $data['id'] = $id;
            $date_debut=$this->input->post('date_debut');
            $date_retour_prevue=$this->input->post('date_retour_prevue');
            $id_user=$this->input->post('id_user');
            $id_product=$this->input->post('id_product');
            $prix=$this->input->post('prix');
            $date_retour_effective = date('Y-m-d');

            $tab_prix_base = $this->produit_model->un_produit($id_product);
            foreach ($tab_prix_base as $element) {
                $prix_base = $element->prix_location;
            }

            //vérification dépasement date retour prévue ou 30 jours

            $date_retour_prevue_s = strtotime($date_retour_prevue); 
            $date_retour_effective_s = strtotime($date_retour_effective);

            if ($date_retour_effective_s > $date_retour_prevue_s ){
                $prix = $prix + (0.2 * $prix_base);
            }
            
            $this->location_model->finalization($id, $date_retour_effective, $date_debut, $date_retour_prevue, $id_product, $id_user, $prix);
            $data['content']='profil'; 
            $data['tab_location_agent'] = $this->location_model->date_dispo_agent();
            $data['tab_location_user'] = $this->location_model->user_rent($this->session->userdata('id_user'));
            $this->load->vars($data); 
            $this->load->view('template');
        }

        //supprimer compte

        public function supprimer(){
            
            //vérification -> si l'utilisateur n'a plus de locations

            $this->load->helper('form'); 
            $this->load->library('form_validation');
            $this->form_validation->set_rules('verif','verif','callback_verif_sans_location');

            if($this->form_validation->run()===FALSE){ 
                $data['content']='profil'; 
            } 

            else {

                //déconnexion
                unset($_SESSION['loggedin']);
                unset($_SESSION['id']);
                unset($_SESSION['nom_utilisateur']);
                unset($_SESSION['type']);
                session_destroy();

                //suppression
                $this->utilisateur_model->delete_account($this->session->userdata('id_user'));
                $this->utilisateur_model->delete_location($this->session->userdata('id_user'));
            }

            $data['tab_location_agent'] = $this->location_model->date_dispo_agent();
            $data['tab_location_user'] = $this->location_model->user_rent($this->session->userdata('id_user'));
            $this->load->helper('form'); 
            $data['content']='profil'; 
            $this->load->vars($data); 
            $this->load->view('template');
        }




        //vérification -> si l'utilisateur n'a plus de locations

        public function verif_sans_location(){
            $tab = $this->location_model->user_rent($this->session->userdata('id_user'));

            foreach($tab as $element){
                $this->form_validation->set_message('verif_sans_location' ,  'Vous ne pouvez pas supprimer votre compte si vous avez une location.'); 
                return false;
            }
            return true;
        }




        //annuler la location

        public function annuler_location($id){ 

            $this->load->helper('form'); 
            $this->load->library('form_validation');
            $this->form_validation->set_rules('date_debut','date de début','callback_verif_annulation_location');

            if($this->form_validation->run()===FALSE){ 
                $data['content']='profil'; 
            } 
            else{ 
            $this->location_model->cancel_rent($id);
            }

            $data['tab_location_agent'] = $this->location_model->date_dispo_agent();
            $data['tab_location_user'] = $this->location_model->user_rent($this->session->userdata('id_user'));
            $data['content']='profil'; 

            $this->load->vars($data); 
            $this->load->view('template');
            
        }

        //vérification de si la location n'a pas encore démarrée

        public function verif_annulation_location($date_debut){
            $currentDate = date('Y-m-d');
            $currentDate_s = strtotime($currentDate);
            $date_debut_s = strtotime($date_debut);

            if ($currentDate_s > $date_debut_s) {
                $this->form_validation->set_message('verif_annulation_location' ,  'La location a déjà commencée.'); 
                return false;
            }
            else {
                return true;
            }
        }
    }
?>