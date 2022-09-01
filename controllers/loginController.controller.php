<?php
    /**
     * This is a controller class which is responsible for showing the login page.
     * 
     * This controller extends the FormValidator abstract class, from which it inherits the members ($correct_parameters and $incorrect_parameters).
    */
    class LoginController extends FormValidator{        
        private $user_handler;
        
        /**
         *
         * This function is responsible for showing the login page.
         * 
         * Once a client is directed to this page, the session variables will be all cleared.
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
         * This function is responsible for authenticating the client.
         * 
         * Post variable must not be renamed, else the client will be redirected to the page.
         * If there is no error, that is, the user provided an existing and valid neptun code, and the correct password corresponding to this neptun code, then they will be redirected to the notifications page.
         * 
         * @return void
        */
        public function ValidateLogin(){
            if(isset($_POST['neptun_code']) && isset($_POST['user_password'])){ //Handling malicious user's activities, like overwriting the name of inputs
                //Simulating a user with the UserHandler class, this user will have a neptun code, a password and the database
                $this->user_handler = new UserHandler("szakdoli", $_POST['neptun_code'], $_POST['user_password']);
                
                //Validating the user
                $this->ValidateUser();

                //If there is no error, then the user gets redirected to the notifications page, else to the login page
                if(count($this->GetIncorrectParameters()) == 0){
                    //The user gets logged in with the given neptun_code
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

        /**
         *
         * This function is responsible for validating the user's form.
         * 
         * This method is not defined in the FormValidator class, only the signature is given there.
         * Here a valid form should satisfy the conditions related to neptun codes and passwords.
         * If the neptun code is not valid (not given, or not in the database), then there is no sense in validating the password.
         * 
         * @return void
        */
        public function ValidateUser(){
            $this->NeptunCodeValidator();
            if(count($this->GetIncorrectParameters()) == 0){ //Check the password input only if the neptun code was valid
                $this->PasswordValidator();
            }
        }

        /**
         *
         * This function is responsible for validating the user's given neptun code.
         * 
         * If the input is not the original place holder string or the empty string, i.e., the user actually typed something in the input, then we check if their neptun code exists, or not.
         * If their neptun code exists, then the input was valid, and the correct parameters will be updated with the neptun_code - given neptun code key-value pair.
         * If there was a problem with the input, then the incorrect parameters will be extended with an id that starts with the wrong_1 prefix, and continues with the specific problem.
         * 
         * @return void
        */
        private function NeptunCodeValidator() {
            if(trim($this->user_handler->GetNeptunCode())!="Neptun kód" && trim($this->user_handler->GetNeptunCode())!=""){
                if(!$this->user_handler->IsUserNameUsed()){//No such neptun code can be found in the database
                    $this->SetIncorrectParameter("wrong_1_no_neptun_code");
                }else{ //Everyting was correct
                    $this->SetCorrectParameter("neptun_code", $this->user_handler->GetNeptunCode());
                }
            }else{ //No neptun code was given
                $this->SetIncorrectParameter("wrong_1_no_data");
            }
        }

        /**
         *
         * This function is responsible for validating the user's given password.
         * 
         * If the input is not the original place holder string or the empty string, i.e., the user actually typed something in the input, then we check if the given password is identical to the one that belongs to the given (pre-validated) neptun code.
         * If the two passwords are the same, then the input was valid.
         * If there was a problem with the input, then the incorrect parameters will be extended with an id that starts with the wrong_2 prefix, and continues with the specific problem.
         * The correct parameters will not be extended here.
         * 
         * @return void
        */
        private function PasswordValidator() {
            if(trim($this->user_handler->GetUserPassword())!="Jelszó" && trim($this->user_handler->GetUserPassword()) != ""){
                if(!$this->user_handler->IsSamePassword()){//Passwords were not the same
                    $this->SetIncorrectParameter("wrong_2_not_same");
                }
            }else{//No password was given
                $this->SetIncorrectParameter("wrong_2_no_password");
            }
        }
    }

?>