<?php
    /**
     * This is a controller class which is responsible for showing the login page.
     * 
     * This controller extends the FormValidator abstract class, from which it inherits the members ($correct_parameters and $incorrect_parameters) and the ValidateInputs() method.
    */
    class LoginController extends FormValidator{        
        private $login_model;

        /**
         * 
         * The contructor of the LoginController class.
         * 
         * It will call the FormValidator class's constructor with which it will assign default values to the inherited members.
         * 
         * @return void
         */
        public function __construct(){
            $this->login_model = new LoginModel();
        }
        
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
            session_start();
            
            $_SESSION["previous_controller"] = "LoginController";
            $_SESSION["form_generated_token"] = bin2hex(random_bytes(24));
            $this->form_token = $_SESSION["form_generated_token"];

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
            session_start();

            $_SESSION["previous_controller"] = "LoginController";
            $_SESSION["form_generated_token"] = bin2hex(random_bytes(24));
            $this->form_token = $_SESSION["form_generated_token"];

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
            // Fetch all of the neptun codes from the users table
            $neptun_codes_array = $this->login_model->GetNeptunCodes();
            $neptun_codes = [];
            foreach($neptun_codes_array as $neptun_code_counter => $neptun_code_array){
                array_push($neptun_codes, $neptun_code_array["neptun_code"]);
            }
            
            // Validate the neptun code, where as valid neptun code is a string, not the place holder, or the empty string, and is in use
            $this->ValidateInputs(
                [
                    "neptun_code:neptun kód" => array($_POST["neptun_code"]??"INVALID NAME ATTRIBUTE" => [
                        "not_placeholder" => ["", "Neptun kód..."],
                        "in_array" => $neptun_codes
                    ])
                ]
            );

            // Validate the password only when the neptun code is valid
            if(isset($this->correct_parameters["neptun_code"])){
                // A valid password is a string, not the place holder, and is the same as the password, that belongs to the given user
                $this->ValidateInputs(
                    [
                        "user_password:jelszó"  => array($_POST["user_password"]??"INVALID NAME ATTRIBUTE" => [
                            "not_placeholder" => ["","Jelszó..."],
                            "is_same_password" => $this->login_model->GetPasswordOfUser($_POST["neptun_code"])["user_password"],
            
                        ])
                    ]
                );
            }

            // Every input was correct
            if(count($this->incorrect_parameters) === 0){
                // The user gets logged in with the given neptun_code
                $_SESSION["neptun_code"] = strtoupper($_POST['neptun_code']);
                
                if($this->login_model->IsAdministrator($_POST['neptun_code'])){
                    // Redirecting the user to the notifications page
                    header("Location: ./index.php?site=notifications");
                }else{
                    // Redirecting the user to the demonstrator handling page
                    header("Location: ./index.php?site=demonstratorHandling");
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
            // Fetch all of the neptun codes from the users table
            $neptun_codes_array = $this->login_model->GetNeptunCodes();
            $neptun_codes = [];
            foreach($neptun_codes_array as $neptun_code_counter => $neptun_code_array){
                array_push($neptun_codes, $neptun_code_array["neptun_code"]);
            }
            
            // Validate the neptun code, where as valid neptun code is a string, not the place holder, or the empty string, and is in use
            $this->ValidateInputs(
                [
                    "neptun_code" => array($_POST["neptun_code"]??"INVALID NAME ATTRIBUTE" => [
                        "not_placeholder" => ["", "Neptun kód..."],
                        "in_array" => $neptun_codes
                    ])
                ]
            );

            // If there is no error, then the user gets redirected to the login page
            if(count($this->incorrect_parameters) === 0){
                // The user will be sent a new password via email to their given email address
                $new_password = $this->GenerateNewPassword();
                $neptun_code = $_POST['neptun_code'];

                // Updating the password 
                $this->login_model->UpdatePassword($neptun_code, $new_password);
                
                // Create the email
                $actual_time = date(' Y. M. d. (D) H:i:s');
                $email_address = $this->login_model->GetEmailAddressOfUser(($neptun_code))["email_address"];
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
        }

        /**
         * This private method generates a new password.
         * 
         * The method will pick a random capital letter (english alphabet), a number between 0 and 9, a random small letter (english alphabet) and a random special character from the array of ([',', '-', '.', '?', '!']).
         * Then it will pick 4-8 characters randomly from these four types (english alphabet capital and small letter, number between 0 and 9, and special character from the array of [',', '-', '.', '?', '!']).
         * Finally, the method returns a permutation of the concatenated string.
         *  
         * @return string Returns a permutation of the generated password.
         */
        private function GenerateNewPassword() {
            // Possible alphabet letters, numbers and special characters
            $small_letters = ["a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z"];
            $numbers = [0,1,2,3,4,5,6,7,8,9];
            $special_characters = [",", "-", ".", "?", "!"];

            // It picks a random capital letter (english alphabet), a number between 0 and 9, a random small letter (english alphabet) and a random special character from the array of ([',', '-', '.', '?', '!']).
            $random_small_letter = $small_letters[mt_rand(0,count($small_letters)-1)];
            $random_capital_letter = strtoupper($small_letters[mt_rand(0,count($small_letters)-1)]);
            $random_number = $numbers[mt_rand(0,count($numbers)-1)];
            $random_special_character = $special_characters[mt_rand(0,count($special_characters)-1)];
            $new_password = $random_capital_letter . $random_number . $random_small_letter . $random_special_character;

            // It picks also 4-8 characters randomly from these four types (english alphabet capital and small letter, number between 0 and 9, and special character from the array of [',', '-', '.', '?', '!']).
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

            // Returns a permutation of the concatenated string
            return str_shuffle($new_password);
        }
    }

?>