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
         * This method shows the login page.
         * 
         * Once a client is directed to this page, the session variables will be all cleared.
         * 
         * @param bool $with_success_bar This parameter decides whether the login page should contain a success bar for password changing, or not. The default is false.
         * @param string $email_address The email address where the new password was sent.
         * 
         * @return void
        */
        public function Login($with_success_bar = false, $email_address = "") {
            session_unset();
            session_destroy();

            $forgotten_password_page = false;

            include(ROOT_DIRECTORY . "/views/loginForm.view.php");
        }

        /**
         *
         * This method shows the forgotten password page.
         * 
         * Once a client is directed to this page, the session variables will be all cleared.
         * 
         * @return void
        */
        public function ForgottenPassword() {
            session_unset();
            session_destroy();

            $forgotten_password_page = true;

            include(ROOT_DIRECTORY . "/views/loginForm.view.php");
        }

        /**
         *
         * This method authenticates the client.
         * 
         * Post variable shouldn't be renamed, else the client will be redirected to the page.
         * If there is no error, that is, the user provided an existing and valid neptun code, and the correct password corresponding to this neptun code, then they will be redirected to the notifications page.
         * 
         * @return void
        */
        public function ValidateLogin() {
            if(isset($_POST['neptun_code']) && isset($_POST['user_password'])){ //Handling malicious user's activities, like overwriting the name of inputs
                // Simulating a user with the UserHandler class, this user will have a neptun code, a password and the database
                $this->user_handler = new UserHandler($_POST['neptun_code'], $_POST['user_password']);
                
                // Validating the user
                $this->ValidateUser();

                // If there is no error, then the user gets redirected to the notifications page, else to the login page
                if(count($this->incorrect_parameters) === 0){
                    // The user gets logged in with the given neptun_code
                    $_SESSION["neptun_code"] = $_POST['neptun_code'];
                    
                    if($_POST['neptun_code'] !== "admin"){
                        // Redirecting the user to the notifications page
                        header("Location: ./index.php?site=notifications");
                    }else{
                        // Redirecting the user to the demonstrator handling page
                        header("Location: ./index.php?site=demonstratorHandling");
                    }
                }else{
                    $this->Login();
                }
            }else{
                $this->Login();
            }
        }

        /**
         *
         * This method sends the user a new password if they have forgotten the previous.
         * 
         * Post variable shouldn't be renamed, or else the client will be redirected to the page.
         * If there is no error, that is, the user provided an existing and valid neptun code, then they will receive a new password via email (to their given email address) and will be redirected to the login page.
         * 
         * @return void
        */
        public function ValidateForgottenPassword(){
            if(isset($_POST['neptun_code'])){ // Handling malicious user's activities, like overwriting the name of the input
                // Simulating a user with the UserHandler class, this user will have a neptun code, a password and the database
                $this->user_handler = new UserHandler($_POST['neptun_code']);
                
                // Validating the user
                $this->ValidateUser(true);

                // If there is no error, then the user gets redirected to the login page
                if(count($this->incorrect_parameters) === 0){
                    // The user will be sent a new password via email to their given email address
                    $new_password = $this->GenerateNewPassword();
                    $neptun_code = $_POST['neptun_code'];

                    // Updating the password 
                    $login_model = new LoginModel();
                    $login_model->UpdatePassword($neptun_code, $new_password);
                    
                    $actual_time = date(' Y. M. d. (D) H:i:s');
                    $email_address = $login_model->GetEmailAddressOfUser(($neptun_code))["email_address"];
                    $title = "Új jelszó a dimaasz alkalmazásban";
                    $message = "
                    <h1>Új jelszó igénylése $actual_time időpontban a $neptun_code netunkódhoz tartozó felhasználónak</h1>\n
                    <label>A rendszerben a $neptun_code netunkódhoz tartozó felhasználó jelszava megváltozott az $actual_time időpontban. Az új jelszó: <b>$new_password</b>.</label>\n
                    <label>Kérjük az új jelszóval való belépést követően változtassa meg a jelszavát a \"Kilépés\" feliratú gomb mellett található kis ikonra kattintva!</label>\n
                    ";
                    
                    // Sending email to the user's address
                    mail($email_address, $title, $message, "Content-Type: text/html");

                    // Redirecting the user to the login page
                    $this->Login(true, $email_address);
                }else{
                    $this->ForgottenPassword();
                }
            }else{
                $this->ForgottenPassword();
            }
        }

        /**
         *
         * This method validates the user's form.
         * 
         * This method is not defined in the FormValidator class, only the signature is given there.
         * Here a valid form should satisfy the conditions related to neptun codes and passwords.
         * If the neptun code is not valid (not given, or not in the database), then there is no sense in validating the password.
         * 
         * @param bool $only_neptun_code This parameter decides whether the user validation should only include neptun code validation, or if it should validate the password too. The default is false.
         * 
         * @return void
        */
        public function ValidateUser($only_neptun_code = false){
            $this->NeptunCodeValidator();
            if(count($this->GetIncorrectParameters()) === 0 && !$only_neptun_code){ // Check the password input only if the neptun code was valid
                $this->PasswordValidator();
            }
        }

        /**
         *
         * This method validates the user's given neptun code.
         * 
         * If the input is not the original place holder string or the empty string, i.e., the user actually typed something in the input, then we check if their neptun code exists, or not.
         * If their neptun code exists, then the input was valid, and the correct parameters will be updated with the neptun_code - given neptun code key-value pair.
         * If there was a problem with the input, then the incorrect parameters will be extended with an id that starts with the wrong_1 prefix, and continues with the specific problem.
         * 
         * @return void
        */
        private function NeptunCodeValidator() {
            if(trim($this->user_handler->GetNeptunCode())!="Neptun kód" && trim($this->user_handler->GetNeptunCode())!=""){
                if(!$this->user_handler->IsUserNameUsed()){ // No such neptun code can be found in the database
                    array_push($this->incorrect_parameters, "wrong_1_no_neptun_code");
                }else{ // Everyting was correct
                    $this->correct_parameters["neptun_code"] = $this->user_handler->GetNeptunCode();
                }
            }else{ // No neptun code was given
                array_push($this->incorrect_parameters, "wrong_1_no_data");
            }
        }

        /**
         *
         * This method validates the user's given password.
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
                if(!$this->user_handler->IsSamePassword()){ // Passwords were not the same
                    array_push($this->incorrect_parameters, "wrong_2_not_same");
                }
            }else{ // No password was given
                array_push($this->incorrect_parameters, "wrong_2_no_password");
            }
        }

        /**
         * 
         */
        private function GenerateNewPassword() {
            $small_letters = ["a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z"];
            $numbers = [0,1,2,3,4,5,6,7,8,9];
            $special_characters = [",", "-", ".", "?", "!"];

            $random_small_letter = $small_letters[mt_rand(0,count($small_letters)-1)];
            $random_capital_letter = strtoupper($small_letters[mt_rand(0,count($small_letters)-1)]);
            $random_number = $numbers[mt_rand(0,count($numbers)-1)];
            $random_special_character = $special_characters[mt_rand(0,count($special_characters)-1)];

            $new_password = $random_capital_letter . $random_number . $random_small_letter . $random_special_character;
            $new_length = mt_rand(4,8);
            for($counter = 0; $counter < $new_length; $counter++){
                $type = mt_rand(0,3);
                $new_character = "";
                switch($type){
                    case 0:{
                        $new_character = $small_letters[mt_rand(0,count($small_letters)-1)];
                    };break;
                    case 1:{
                        $new_character = strtoupper($small_letters[mt_rand(0,count($small_letters)-1)]);   
                    };break;
                    case 2:{
                        $new_character = $numbers[mt_rand(0,count($numbers)-1)];
                    };break;
                    case 3:{
                        $new_character = $special_characters[mt_rand(0,count($special_characters)-1)];
                    };break;
                    default;break;
                }
                $new_password .= $new_character;
            }

            return $new_password;
        }
    }

?>