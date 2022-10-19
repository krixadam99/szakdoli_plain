<?php
    /**
     * This is a controller class which is responsible for showing the registration page.
     * 
     * This controller extends the FormValidator abstract class, from which it inherits the members ($correct_parameters and $incorrect_parameters).
    */
    class RegistrationController extends FormValidator{        
        private $dimat_i_groups;
        private $dimat_ii_groups;
        private $user_handler;
        
        /**
         * 
         */
        public function Registration() {
            $registration_model = new RegistrationModel();
            $this->dimat_i_groups = $registration_model->GetDataFromDatabase("SELECT DISTINCT subject_group FROM user_groups WHERE subject_id = \"i\" AND is_teacher = 1 AND application_request_status  = \"APPROVED\"", MYSQLI_NUM);
            $this->dimat_ii_groups = $registration_model->GetDataFromDatabase("SELECT DISTINCT subject_group FROM user_groups WHERE subject_id = \"ii\" AND is_teacher = 1 AND application_request_status  = \"APPROVED\"", MYSQLI_NUM);
            
            include(ROOT_DIRECTORY . "/views/registrationForm.view.php");
        }

        /**
         * 
         */
        public function ValidateRegistration() {
            if( isset($_POST['neptun_code']) 
                && isset($_POST['user_password'])
                && isset($_POST['user_password_again'])
                && isset($_POST['user_email'])
                && isset($_POST['subject_id'])
                && isset($_POST['user_status'])
            ){ // Do not let the post variable names to be overwritten
                $group = "0";

                // Initial checkings
                if($_POST["user_status"] == "Demonstrátor"){
                    if(isset($_POST["teacher_group"])){
                        $group = $_POST["teacher_group"];
                    }
                }else if($_POST["user_status"] == "Diák"){
                    if($_POST["subject_id"] == "Diszkrét matematika I."){
                        if(isset($_POST["student_group_i"])){
                            $group = $_POST["student_group_i"]??0;
                        }
                    }else if($_POST["subject_id"] == "Diszkrét matematika II."){
                        if(isset($_POST["student_group_ii"])){
                            $group = $_POST["student_group_ii"]??0;
                        }
                    }
                }

                $this->user_handler = new UserHandler($_POST['neptun_code'], $_POST['user_password'], $_POST["user_password_again"], $_POST["user_email"], $_POST["subject_id"], $_POST["user_status"], $group);
                $this->ValidateUser();   
                
                if(count($this->GetIncorrectParameters()) == 0){ // Everything was correct 
                    $_SESSION["neptun_code"] = $_POST['neptun_code'];
                    
                    $registration_model = new RegistrationModel();
                    $registration_model->Register($_POST['neptun_code'], $_POST['user_password'],  $_POST["user_password_again"], $_POST["user_email"], $this->user_handler->GetSubjectId(), $_POST["user_status"], $group);
                    
                    header("Location: ./index.php?site=notifications");
                }else{ // There were errors 
                    $this->Registration();
                }                
            }else{ // There was at least one post variable which name was overwritten
                $this->Registration();
            }
        }

        /**
         *
         * This private method validates the user's given neptun code.
         * 
         * If the input is not the original place holder string or the empty string, i.e., the user actually typed something in the input, then we check if their neptun code is valid , or not.
         * A valid neptun code should containe 6 characters, should only contain letters and numbers and it should not be in use. 
         * If the input was valid, then the correct parameters will be updated with the neptun_code - given neptun code key-value pair.
         * If there was a problem with the input, then the incorrect parameters will be extended with an id that starts with the wrong_1 prefix, and continues with the specific problem (no data, length, invalid characters, already in use).
         * 
         * @return void
        */
        private function NeptunCodeValidator() {
            $neptun_code = $this->user_handler->GetNeptunCode();
            if(trim($neptun_code)!="" && trim($neptun_code)!="Neptun kód"){
                if(strlen($neptun_code)==6){
                    if(preg_match("/^([a-zöüóőúéáűíA-ZÖÜÓŐÚÉÁŰÍ0-9]{6})*$/", $neptun_code)){
                        if($this->user_handler->IsUserNameUsed()){ // Neptun code is already in use
                            array_push($this->incorrect_parameters, "wrong_1_already_in_use");
                        }else{ // Everyting was correct
                            $this->correct_parameters["neptun_code"] = $neptun_code;
                        }
                    }else{ // Illegal characters in username
                        array_push($this->incorrect_parameters, "wrong_1_invalid_characters");
                    }
                }else{ //Neptun code' size is not 6
                    array_push($this->incorrect_parameters, "wrong_1_length");
                }
            }else{//No neptun code given
                array_push($this->incorrect_parameters, "wrong_1_no_data");
            }
        }
    
        /**
         *
         * This private method validates the user's given email address.
         * 
         * If the input is not the original place holder string or the empty string, i.e., the user actually typed something in the input, then we check if their email address is of the correct form.
         * Additionally, we should check whether the email address is not present in the database yet. 
         * If the input was valid, then the correct parameters will be updated with the user_email - given email address key-value pair.
         * If there was a problem with the input, then the incorrect parameters will be extended with an id that starts with the wrong_2 prefix, and continues with the specific problem (no email, wrong format, already in use).
         * 
         * @return void
        */
        private function EmailAddressValidator() {
            $user_email = $this->user_handler->GetUserEmail();
            
            if(trim($user_email)!="Email cím" && trim($user_email)!= ""){
                if(filter_var($user_email, FILTER_VALIDATE_EMAIL)){
                    if($this->user_handler->IsEmailAddressUsed()){ // The email address is already in use
                        array_push($this->incorrect_parameters, "wrong_2_already_in_use");
                    }else{ // Everyting was correct
                        $this->correct_parameters["user_email"] = $user_email;
                    }
                }else{ // Wrong format for the email address
                    array_push($this->incorrect_parameters, "wrong_2_wrong_format");
                }
            }else{ // Email address is not given
                array_push($this->incorrect_parameters, "wrong_2_no_email");
            }
    
        }
        
        /**
         *
         * This private method validates the user's selected subject name.
         * 
         * If the input was "Diszkrét matematika I.", then the correct parameters will be updated with the subject_id - "0" address key-value pair.
         * If the input was "Diszkrét matematika II.", then the correct parameters will be updated with the subject_id - "1" address key-value pair.
         * Else the incorrect parameters will be extended with an id that starts with the wrong_3 prefix, and continues with the specific problem (no subject name, no such subject).
         * 
         * @return void
        */
        private function SubjectNameValidator() {
            $subject_id = $this->user_handler->GetSubjectName();
    
            if(isset($subject_id)){
                if($subject_id == "Diszkrét matematika I."){ // The subject name was "Diszkrét matematika I."
                    $this->user_handler->SetSubjectName("i");
                    $this->correct_parameters["subject_id"] = "0";
                }elseif($subject_id == "Diszkrét matematika II."){ // The subject name was "Diszkrét matematika II."
                    $this->user_handler->SetSubjectName("ii");
                    $this->correct_parameters["subject_id"] = "1";
                }else{ // The subject name was not "Diszkrét matematika I." or "Diszkrét matematika II.", but a maliciously set value
                    array_push($this->incorrect_parameters, "wrong_3_no_such_subject");        
                }
            }else{ // No subject name given
                array_push($this->incorrect_parameters, "wrong_3_no_subject_id");
            }
        }
    
        /**
         *
         * This private method validates the user's selected status.
         * 
         * If the input was "Diák", then the correct parameters will be updated with the user_status - "Diák" address key-value pair.
         * If the input was "Demonstrátor", then the correct parameters will be updated with the user_status - "Demonstrátor" address key-value pair.
         * Else the incorrect parameters will be extended with an id that starts with the wrong_4 prefix, and continues with the specific problem (no user status, no such status).
         * 
         * @return void
        */
        private function UserStatusValidator() {
            $user_status = $this->user_handler->GetUserStatus();
    
            if(isset($user_status)){
                if($user_status === "Diák" || $user_status === "Demonstrátor"){
                    $this->correct_parameters["user_status"] = $user_status;
                }else{ // The user status is neither "Diák", nor "Demonstrátor"
                    array_push($this->incorrect_parameters, "wrong_4_no_such_status");      
                }
            }else{ // No user status given
                array_push($this->incorrect_parameters, "wrong_4_no_user_status");
            }
        }
    
        /**
         *
         * This private method validates the user's selected group.
         * 
         * If there is no selected element, or the selected group has no assigned teacher, then the incorrect parameters will be extended with an id that starts with the wrong_6 prefix, and continues with the specific problem (no subject group, no such group).
         * 
         * @return void
        */
        private function SubjectGroupValidator() {
            $subject_id = $this->user_handler->GetSubjectName();
            $user_status = $this->user_handler->GetUserStatus();
            $subject_group = $this->user_handler->GetSubjectGroup();
    
            if(isset($subject_group)){
                if($user_status == "Diák"){
                    if($subject_id == "i" || $subject_id == "ii"){
                        $is_correct = $this->user_handler->IsGroupNumberCorrect();
                        if($is_correct){ 
                            $this->correct_parameters["subject_group"] = $subject_group;
                        }else{ // There is no teacher assigned to the group which the user selected
                            array_push($this->incorrect_parameters, "wrong_5_no_such_group");
                        }
                    }else{ // The selected subject's name is not correct
                        $this->correct_parameters["subject_group"] = 0;
                    }
                }else{ // The user is a teacher
                    if(is_numeric($subject_group) && intval($subject_group) < 31 && intval($subject_group) > 1){
                        $this->correct_parameters["subject_group"] = $subject_group;
                    }else{ // The selected element's text is either not a number, or is not between 1 and 30
                        array_push($this->incorrect_parameters, "wrong_5_no_such_group"); 
                    }
                }
            }else{ // No subject group was given
                array_push($this->incorrect_parameters, "wrong_5_no_subject_group"); 
            }
        }
    
        /**
         *
         * This private method validates the user's given password.
         * 
         * If the input is not the original place holder string or the empty string, i.e., the user actually typed something in the input, then we check if the given password is valid.
         * The password is valid if it is longer than 7 characters, has at least one small letter, big letter, number and one of the following characters: "-", ",", ".", "?", "!".
         * If there was a problem with the input, then the incorrect parameters will be extended with an id that starts with the wrong_6 prefix, and continues with the specific problem (no password, length, complexity).
         * The correct parameters will not be extended here.
         * 
         * @return void
        */
        private function PasswordValidator() {
            $user_password = $this->user_handler->GetUserPassword();
    
            if(isset($user_password) && trim($user_password)!="Jelszó"){
                if(strlen($user_password) >= 8){
                    if(    !preg_match("/[a-z]/", $user_password) 
                        || !preg_match("/[A-Z]/", $user_password) 
                        || !preg_match("/[0-9]/", $user_password) 
                        || !preg_match("/[\-\,\.\?\!]/", $user_password)
                    ){ // The password is not complex enough (doesn't contain a small letter,  big letter,  number, or one of the following characters: "-", ",", ".", "?", "!")
                        array_push($this->incorrect_parameters, "wrong_6_complexity");
                    }
                }else{ // The password is not long enough (smaller than 8 characters)
                    array_push($this->incorrect_parameters, "wrong_6_length");
                }
            }else{ // No password was given
                array_push($this->incorrect_parameters, "wrong_6_no_password");
            }
        }
    
        /**
         *
         * This private method validates the user's repeated given password.
         * 
         * If the input is not the original place holder string or the empty string, i.e., the user actually typed something in the input, then we check if the given repeated password is the same as the previously given.
         * If there was a problem with the input, then the incorrect parameters will be extended with an id that starts with the wrong_7 prefix, and continues with the specific problem (no password validate, not same).
         * The correct parameters will not be extended here.
         * 
         * @return void
        */
        private function PasswordAgainValidator() {
            $user_password = $this->user_handler->GetUserPassword();
            $user_password_again = $this->user_handler->GetUserPasswordAgain();
    
            if(isset($user_password_again) && trim($user_password_again)!="Jelszó megerősítése"){
                if($user_password != $user_password_again){ // The password was not the same as the previously given
                    array_push($this->incorrect_parameters, "wrong_7_not_same");
                }
            }else{ // The password was not repeated
                array_push($this->incorrect_parameters, "wrong_7_no_password_validate");
            }
        }
    
        /**
         *
         * This method validates the user's registration form.
         * 
         * This method is not defined in the FormValidator class, only the signature is given there.
         * Here a valid form should satisfy the conditions related to neptun code, email address, subject name, subject group, user status and password.
         * If the neptun code is not valid (not given, or not in the database), then there is no sense in validating the password.
         *  
         * @return void
        */
        private function ValidateUser(){
            $this->NeptunCodeValidator();
            $this->EmailAddressValidator();
            $this->SubjectNameValidator();
            $this->UserStatusValidator();
            $this->SubjectGroupValidator();
            $this->PasswordValidator();
            $this->PasswordAgainValidator();
        }
    }

?>