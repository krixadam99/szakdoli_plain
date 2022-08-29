<?php

    class RegistrationController extends FormValidator{        
        private $dimat_i_groups;
        private $dimat_ii_groups;
        private $user_handler;

        public function __construct(){
            $this->error_parameters = array();
            $this->valid_parameters = array();
        }
        
        public function Registration(){
            if(!defined('ACESS_TOKEN')){
                die('DIRECT ACCESS IS NOT PERMITTED!');
            }

            $registration_model = new RegistrationModel("szakdoli");
            $this->dimat_i_groups = $registration_model->GetDataFromDatabase("SELECT DISTINCT subject_group FROM status_pending WHERE subject_name = \"i\" AND user_status = \"teacher\" AND pending_status  = \"0\"", MYSQLI_NUM);
            $this->dimat_ii_groups = $registration_model->GetDataFromDatabase("SELECT DISTINCT subject_group FROM status_pending WHERE subject_name = \"ii\" AND user_status = \"teacher\" AND pending_status  = \"0\"", MYSQLI_NUM);
            
            include(ROOT_DIRECTORY . "/views/registrationForm.view.php");
        }

        public function ValidateRegistration(){
            if( isset($_POST['neptun_code']) 
                && isset($_POST['user_password'])
                && isset($_POST['user_password_again'])
                && isset($_POST['user_email'])
                && isset($_POST['subject_name'])
                && isset($_POST['user_status'])
            ){
                $group = "0";

                if($_POST["user_status"] == "Demonstrátor"){
                    if(isset($_POST["teacher_group"])){
                        $group = $_POST["teacher_group"];
                    }
                }else if($_POST["user_status"] == "Diák"){
                    if($_POST["subject_name"] == "Diszkrét matematika I."){
                        if(isset($_POST["student_group_i"])){
                            $group = $_POST["student_group_i"];
                        }
                    }else if($_POST["subject_name"] == "Diszkrét matematika II."){
                        if(isset($_POST["student_group_ii"])){
                            $group = $_POST["student_group_ii"];
                        }
                    }
                }

                $this->user_handler = new UserHandler("szakdoli", $_POST['neptun_code'], $_POST['user_password'], $_POST["user_password_again"], $_POST["user_email"], $_POST["subject_name"], $_POST["user_status"], $group);
                $this->ValidateUser();
                $this->error_parameters = $this->GetErrorParameters();
                $this->valid_parameters = $this->GetValidParameters();         
                
                if(count($this->error_parameters) == 0){
                    $_SESSION["neptun_code"] = $_POST['neptun_code'];
                    
                    $registration_model = new RegistrationModel("szakdoli");
                    $registration_model->Register($_POST['neptun_code'], $_POST['user_password'],  $_POST["user_password_again"], $_POST["user_email"], $_POST["subject_name"], $_POST["user_status"], $group);
                    
                    header("Location: ./index.php?site=notifications");
                }else{
                    $this->Registration();
                }                
            }else{
                $this->Registration();
            }
        }

        private function NeptunCodeValidator() : void {
            $neptun_code = $this->user_handler->GetNeptunCode();
            if(trim($neptun_code)!="" && trim($neptun_code)!="Neptun kód"){
                if(strlen($neptun_code)==6){
                    if(!$this->user_handler->IsUserNameUsed($neptun_code)){
                        if(!preg_match("/^([a-zöüóőúéáűíA-ZÖÜÓŐÚÉÁŰÍ0-9]{6})*$/", $neptun_code)){//Illegal characters in username
                            $this->SetErrorParameters("wrong_1_invalid_characters");
                        }else{
                            $this->SetValidParameters("neptun_code", $neptun_code);
                        }
                    }else{//Neptun code is already in use
                        $this->SetErrorParameters("wrong_1_user_set");
                    }
                }else{
                    $this->SetErrorParameters("wrong_1_length");
                }
            }else{//No neptun code given
                $this->SetErrorParameters("wrong_1_no_data");
            }
        }
    
        private function EmailAddressValidator() : void {
            $user_email = $this->user_handler->GetUserEmail();
            
            if(trim($user_email)!="E-mail cím" && trim($user_email)!= ""){
                if(!filter_var($user_email, FILTER_VALIDATE_EMAIL)){//Wrong format for the email address
                    $this->SetErrorParameters("wrong_2_wrong_format");
                }else{
                    $this->SetValidParameters("user_email", $user_email);
                }
            }else{//Email address is not given
                $this->SetErrorParameters("wrong_2_no_email");
            }
    
        }
        
        private function SubjectNameValidator() : void {
            $subject_name = $this->user_handler->GetSubjectName();
    
            if(isset($subject_name)){
                if($subject_name == "Diszkrét matematika I."){
                    $this->user_handler->SetSubjectName("i");
                    $this->SetValidParameters("subject_name", "0");
                }elseif($subject_name == "Diszkrét matematika II."){
                    $this->user_handler->SetSubjectName("ii");
                    $this->SetValidParameters("subject_name", "1");
                }elseif($subject_name == "Diszkrét matematika modellek és alkalmazásaik"){
                    $this->user_handler->SetSubjectName("dimmoa");
                    $this->SetValidParameters("subject_name", "2");
                }else{//Malicious user input value
                    $this->SetErrorParameters("wrong_3_no_such_subject");           
                }
            }else{//No subject name given
                $this->SetErrorParameters("wrong_3_no_subject_data");
            }
        }
    
        private function UserStatusValidator() : void {
            $user_status = $this->user_handler->GetUserStatus();
    
            if(isset($user_status)){
                if($user_status == "Diák" || $user_status == "Demonstrátor"){
                    $this->SetValidParameters("user_status", $user_status);
                }else{
                    $this->SetErrorParameters("wrong_4_no_such_status");      
                }
            }else{//No subject name given
                $this->SetErrorParameters("wrong_4_no_user_status");
            }
        }
    
        private function SubjectGroupValidator() : void {
            $subject_name = $this->user_handler->GetSubjectName();
            $user_status = $this->user_handler->GetUserStatus();
            $subject_group = $this->user_handler->GetSubjectGroup();
    
            if(isset($subject_group)){
                if($user_status == "Diák"){
                    if($subject_name == "dimat_i" || $subject_name == "dimat_ii"){
                        $is_correct = $this->user_handler->IsGroupNumberCorrect();
                        if($is_correct){
                            $this->SetValidParameters("subject_group", $subject_group);
                        }else{
                            $this->SetErrorParameters("wrong_5_no_such_group");
                        }
                    }else{
                        $this->SetValidParameters("subject_group", 0);
                    }
                }else{
                    $this->SetValidParameters("subject_group", $subject_group);
                }
            }else{//No subject name given
                $this->SetErrorParameters("wrong_5_no_subject_group");
            }
        }
    
        private function PasswordValidator() : void {
            $user_password = $this->user_handler->GetUserPassword();
    
            if(isset($user_password) && trim($user_password)!="Jelszó"){
                if(strlen($user_password) >= 8){
                    if(!preg_match("/[a-z]/", $user_password) || !preg_match("/[A-Z]/", $user_password) || !preg_match("/[0-9]/", $user_password) || !preg_match("/[\-\,\.\?\!]/", $user_password)){
                        $this->SetErrorParameters("wrong_6_complexity");
                    }
                }else{
                    $this->SetErrorParameters("wrong_6_length");
                }
            }else{
                $this->SetErrorParameters("wrong_6_no_password");
            }
        }
    
        private function PasswordAgainValidator() : void {
            $user_password = $this->user_handler->GetUserPassword();
            $user_password_again = $this->user_handler->GetUserPasswordAgain();
    
            if(isset($user_password_again) && trim($user_password_again)!="Jelszó megerősítése"){
                if($user_password != $user_password_again){
                    $this->SetErrorParameters("wrong_7_not_same");
                }
            }else{
                $this->SetErrorParameters("wrong_7_no_password_validate");
            }
        }
    
        public function ValidateUser(){
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