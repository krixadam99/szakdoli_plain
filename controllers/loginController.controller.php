<?php

    class LoginController extends FormValidator{        
        private $error_parameters;
        private $valid_parameters;
        private $user_handler;

        public function __construct(){
            $this->error_parameters = array();
            $this->valid_parameters = array();
        }
        
        /**
         *
         * This function is responsible for showing the login page 
         * 
         * Once a client is directed to this page, the session variables will be all cleared
         * 
         * @return void
        */
        public function Login(){
            session_unset();
            session_destroy();
            include(ROOT_DIRECTORY . "/views/loginForm.view.php");
        }

        /**
         *
         * This function is responsible for authenticating the client
         * 
         * Post variable must not be renamed, else the client will be redirected to the page
         * If there is no error, that is, the user provided an existing and valid neptun code, and the correct password corresponding to this neptun code, then they will be redirected to the notifications page
         * 
         * @return void
        */
        public function ValidateLogin(){
            if(isset($_POST['neptun_code']) && isset($_POST['user_password'])){
                $this->user_handler = new UserHandler("szakdoli", $_POST['neptun_code'], $_POST['user_password']);
                
                //Validating the user
                $this->ValidateUser();
                
                //Setting the valid and incorrect parameters
                $this->error_parameters = $this->GetErrorParameters();
                $this->valid_parameters = $this->GetValidParameters();

                //If there is no error, then the user gets redirected to the notifications page, else to the login page
                if(count($this->error_parameters) == 0){
                    //
                    $_SESSION["neptun_code"] = $_POST['neptun_code'];
                    
                    //Redirecting the user to the notifications page
                    header("Location: ./index.php?site=notifications");
                }else{
                    $this->Login();
                }
            }else{
                $this->Login();
            }
        }

        public function ValidateUser(){
            $this->NeptunCodeValidator();
            $this->PasswordValidator();
        }

        private function NeptunCodeValidator() {
            if(trim($this->user_handler->GetNeptunCode())!="Neptun kód" && trim($this->user_handler->GetNeptunCode())!=""){
                if(!$this->user_handler->IsUserNameUsed()){//No such user is found
                    $this->SetErrorParameters("wrong_1_no_neptun_code");
                }else{
                    $this->SetValidParameters("neptun_code", $this->user_handler->GetNeptunCode());
                }
            }else{//No username is given
                $this->SetErrorParameters("wrong_1_no_data");
            }
        }
    
        private function PasswordValidator() {
            if(trim($this->user_handler->GetUserPassword())!="Jelszó" && trim($this->user_handler->GetUserPassword()) != ""){
                if(!$this->user_handler->IsSamePassword()){//Password is not same
                    $this->SetErrorParameters("wrong_2_not_same");
                }
            }else{//No password is given
                $this->SetErrorParameters("wrong_2_no_password");
            }
        }
    }

?>