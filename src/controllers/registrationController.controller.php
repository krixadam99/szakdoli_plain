<?php
    /**
     * This is a controller class which is responsible for showing the registration page.
     * 
     * This controller extends the FormValidator abstract class, from which it inherits the members ($correct_parameters and $incorrect_parameters) and the ValidateInputs() method.
    */
    class RegistrationController extends FormValidator{        
        private $dimat_i_groups;
        private $dimat_ii_groups;
        private $registration_model;

        /**
         * 
         * The contructor of the RegistrationController class.
         * 
         * It will call the FormValidator class's constructor with which it will assign default values to the inherited members.
         * 
         * @return void
         */
        public function __construct(){
            $this->registration_model = new RegistrationModel();
        }
        
        /**
         *
         * This method shows the registration page.
         * 
         * @return void
        */
        public function Registration() {
            // Fetching the possible group numbers for Discrete mathematics I. and Discrete mathematics II.
            $this->dimat_i_groups = $this->registration_model->GetDataFromDatabase("SELECT DISTINCT group_number FROM subject_groups JOIN user_status USING(subject_group_id) WHERE subject_id = \"i\" AND group_number != 0 AND is_teacher = 1 AND application_request_status  = \"APPROVED\"");
            $this->dimat_ii_groups = $this->registration_model->GetDataFromDatabase("SELECT DISTINCT group_number FROM subject_groups JOIN user_status USING(subject_group_id) WHERE subject_id = \"ii\" AND group_number != 0 AND is_teacher = 1  AND application_request_status  = \"APPROVED\"");
            
            $_SESSION["form_generated_token"] = bin2hex(random_bytes(24));
            $this->form_token = $_SESSION["form_generated_token"];
            include(ROOT_DIRECTORY . "/views/registrationForm.view.php");
        }

        /**
         * This method validates the user's registration request.
         * 
         * If everything was correct, then their request will be approved, otherwise, they will be redirected to the registration page with the correct error parameters.
         * 
         * @return void
         */
        public function ValidateRegistration() {
            // Fetch all of the neptun codes from the users table
            $neptun_codes_array = $this->registration_model->GetNeptunCodes();
            $neptun_codes = [];
            foreach($neptun_codes_array as $neptun_code_counter => $neptun_code_array){
                array_push($neptun_codes, $neptun_code_array["neptun_code"]);
            }

            // Fetch all of the email addresses from the users table
            $email_addresses_array = $this->registration_model->GetEmailAddresses();
            $email_addresses = [];
            foreach($email_addresses_array as $email_address_counter => $email_address_array){
                array_push($email_addresses, $email_address_array["email_address"]);
            }

            // Setting the subject id based on the selected subject
            if(isset($_POST["subject_id"])){
                if($_POST["subject_id"] == "Diszkrét matematika I."){
                    $subject_id = "i";
                }else if($_POST["subject_id"] == "Diszkrét matematika II."){
                    $subject_id = "ii";
                }
            }else{
                $subject_id = "INVALID NAME ATTRIBUTE";
            }

            // Setting the subject group based on the selected group
            $group = "INVALID NAME ATTRIBUTE";
            $group_name_attribute = "";
            $possible_group_numbers = [];
            if(     isset($_POST["user_status"])
                &&  isset($_POST["subject_id"])
            ){
                if($_POST["user_status"] == "Demonstrátor"){
                    $group = $_POST["teacher_group"];
                    if(isset($_POST["teacher_group"])){
                        $group_name_attribute = "teacher_group";

                        // Teacher's group can be a number between 1 and 30 (inclusively)
                        for($counter = 1; $counter < 30; $counter++) array_push($possible_group_numbers, $counter);
                    }
                }else if($_POST["user_status"] == "Diák"){
                    if($_POST["subject_id"] == "Diszkrét matematika I."){
                        $group_name_attribute = "student_group_i";
                        if(isset($_POST["student_group_i"])){
                            $group = $_POST["student_group_i"]??"0";
                            if($group === "-") $group  = "0";
                            
                            // Discrete mathematics I. group can be one of the groups having at least one teacher with approved status/ group and have "i" id
                            $dimat_i_groups = $this->registration_model->GetDataFromDatabase("SELECT DISTINCT group_number FROM subject_groups JOIN user_status USING(subject_group_id) WHERE subject_id = \"i\" AND group_number != 1 AND is_teacher = 1 AND application_request_status  = \"APPROVED\"");
                            foreach($dimat_i_groups as $key => $group_number){
                               array_push($possible_group_numbers, $group_number["group_number"]);
                            }
                            array_push($possible_group_numbers, "0");
                        }
                    }else if($_POST["subject_id"] == "Diszkrét matematika II."){
                        $group_name_attribute = "student_group_ii";   
                        if(isset($_POST["student_group_ii"])){
                            $group = $_POST["student_group_ii"]??"0";
                            if($group === "-") $group  = "0";

                            // Discrete mathematics II. group can be one of the groups having at least one teacher with approved status/ group and have "ii" id
                            $dimat_ii_groups = $this->registration_model->GetDataFromDatabase("SELECT DISTINCT group_number FROM subject_groups JOIN user_status USING(subject_group_id) WHERE subject_id = \"ii\" AND group_number != 1 AND is_teacher = 1 AND application_request_status  = \"APPROVED\"");
                            foreach($dimat_ii_groups as $key=>$group_number){
                               array_push($possible_group_numbers, $group_number["group_number"]);
                            }
                            array_push($possible_group_numbers, "0");
                        }
                    }
                }
            }

            // Validating the form
            // The neptun code should be a string, not the placeholder, or the empty string, it should be of length 6, contain only numbers and (english) alphabet characters, finally it should be unique
            // The email address should be a string, not the placeholder, or the empty string, it should be of email format, finally it should be unique
            // The subject id should be a string, and either "i" (Discrete mathematics II.), or "ii" (Discrete mathematics II.)
            // The user status a string, and it should be either "Diák", or "Demonstrátor"
            // The group number a string, and it should be a valid number
            // The password should be a string, not the placeholder, or the empty string, the length should be greater than 7, it should contain at leaset 1 number, 1 small and capital english alphabet character, and at least 1 of the ",", "-", ".", "?", "!" characters
            // The reassuring password should be a string, not the placeholder, or the empty string, and it should be the same as the original password
            $this->ValidateInputs(
                [
                    "neptun_code:neptun kód" => array($_POST["neptun_code"]??"INVALID NAME ATTRIBUTE" => [
                        "type" => "string",
                        "not_placeholder" => ["", "Neptun kód..."],
                        "length" => ["==", 6],
                        "preg_match" => ["/[0-9a-zA-Z]{6}/"], // No need for sanitazing
                        "unique" => $neptun_codes
                    ]),
                    "user_email:email cím" => array($_POST["user_email"]??"INVALID NAME ATTRIBUTE" => [
                        "type" => "string",
                        "not_placeholder" => ["", "Email cím..."],
                        "filter_var" => FILTER_VALIDATE_EMAIL, // No need for sanitazing
                        "unique" => $email_addresses
                    ]),
                    "subject_id:tárgy" => array($subject_id => [
                        "type" => "string",
                        "in_array" => ["i", "ii"] // No need for sanitazing
                    ]),
                    "user_status:felhasználói státusz" => array($_POST["user_status"]??"INVALID NAME ATTRIBUTE" => [
                        "type" => "string",
                        "in_array" => ["Diák", "Demonstrátor"] // No need for sanitazing
                    ]),
                    "$group_name_attribute:csoport" => array($group => [
                        "in_array" => $possible_group_numbers // No need for sanitazing
                    ]),
                    "user_password:jelszó" => array($_POST["user_password"]??"INVALID NAME ATTRIBUTE" => [
                        "type" => "string",
                        "not_placeholder" => ["","Jelszó..."],
                        "length" => [">=", 8],
                        "preg_match" => ["/[a-z]/", "/[A-Z]/", "/[0-9]/", "/[\-\,\.\?\!]/"] // No need for sanitazing
                    ]),
                    "user_password_again:megerősítő jelszó" => array($_POST["user_password_again"]??"INVALID NAME ATTRIBUTE" => [
                        "type" => "string",
                        "not_placeholder" => ["","Jelszó megerősítése..."],
                        "is_same" => $_POST["user_password"]??"INVALID NAME ATTRIBUTE",
                    ])
                ]
            );


            
            if(count($this->GetIncorrectParameters()) == 0){ // Everything was correct 
                $_SESSION["neptun_code"] = strtoupper($_POST['neptun_code']);
                
                $this->registration_model->Register($_POST['neptun_code'], $_POST['user_password'], $_POST["user_email"], $subject_id, $_POST["user_status"], $group);
                
                header("Location: ./index.php?site=notifications");
            }else{ // At least one of the inputs was incorrect
                $this->Registration();
            }  
        }
    }
?>