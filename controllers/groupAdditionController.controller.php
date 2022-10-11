<?php
    /**
     * This is a controller class which is responsible for showing the group addition page.
     * 
     * This controller extends the MainContentController, from which it inherits its members.
    */
    class GroupAdditionController extends MainContentController {        
        private $user_handler;
        private $error_parameters;
        private $success_parameters;

        /**
         * 
         */
        public function __construct(){
            parent::__construct();
        }

        /**
         *
         * This method is responsible for showing a group addition page.
         * 
         * If a client types the page name in the searchbar of the browser, but not logged in, then they will be redirected to the login page.
         * 
         * @return void
        */
        public function GroupAddition() {
            //Users, who are not logged in won't see this page, they will be redirected to the login page
            if(isset($_SESSION["neptun_code"])){
                if(isset($_SESSION["action"])){
                    $this->SetMembers();
                    $group_addition_conditions = MainContentController::GroupAdditionChecker($this->GetPendingStudentGroups(), $this->GetApprovedStudentSubject(), $this->GetApprovedTeacherSubjects());
            
                    $can_apply_to_group = $group_addition_conditions[1];
                    $can_add_group = $group_addition_conditions[2];
                    
                    $main_model = new MainModel();
                    $this->dimat_i_groups = $main_model->GetDataFromDatabase("SELECT DISTINCT subject_group FROM user_groups WHERE subject_name = \"i\" AND is_teacher = 1 AND pending_status  = \"0\"", MYSQLI_NUM);
                    $this->dimat_ii_groups = $main_model->GetDataFromDatabase("SELECT DISTINCT subject_group FROM user_groups WHERE subject_name = \"ii\" AND is_teacher = 1 AND pending_status  = \"0\"", MYSQLI_NUM);
                    

                    if($_SESSION["action"] === "addAsStudent" && $can_apply_to_group){
                        $status = "student";
                        include(ROOT_DIRECTORY . "/views/groupAdditionPage.view.php");
                    }else if($_SESSION["action"] === "addAsDemonstrator" && $can_add_group){
                        $status = "teacher";
                        include(ROOT_DIRECTORY . "/views/groupAdditionPage.view.php");
                    }else{
                        header("Location: ./index.php?site=notifications");
                    }


                }else{
                    header("Location: ./index.php?site=notifications");
                }
            }else{
                header("Location: ./index.php?site=login");
            }
        }

        /**
         * 
         */
        public function ValidateGroupAddition() {
            if( isset($_POST['subject_name'])
                && isset($_POST['subject_group'])
            ){ // Do not let the post variable names to be overwritten
                $group = "0";

                // Initial checkings
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

                $this->user_handler = new UserHandler($_POST['neptun_code'], $_POST['user_password'], $_POST["user_password_again"], $_POST["user_email"], $_POST["subject_name"], $_POST["user_status"], $group);
                $this->ValidateUser();   
                
                
                if(count($this->GetIncorrectParameters()) == 0){ // Everything was correct 
                    $_SESSION["neptun_code"] = $_POST['neptun_code'];
                    
                    $registration_model = new RegistrationModel();
                    $registration_model->Register($_POST['neptun_code'], $_POST['user_password'],  $_POST["user_password_again"], $_POST["user_email"], $this->user_handler->GetSubjectName(), $_POST["user_status"], $group);
                    
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
         * This private method validates the user's selected subject name.
         * 
         * If the input was "Diszkrét matematika I.", then the correct parameters will be updated with the subject_name - "0" address key-value pair.
         * If the input was "Diszkrét matematika II.", then the correct parameters will be updated with the subject_name - "1" address key-value pair.
         * Else the incorrect parameters will be extended with an id that starts with the wrong_3 prefix, and continues with the specific problem (no subject name, no such subject).
         * 
         * @return void
        */
        private function SubjectNameValidator() {
            $subject_name = $this->user_handler->GetSubjectName();
    
            if(isset($subject_name)){
                if($subject_name == "Diszkrét matematika I."){ // The subject name was "Diszkrét matematika I."
                    $this->user_handler->SetSubjectName("i");
                    $this->correct_parameters["subject_name"] = "0";
                }elseif($subject_name == "Diszkrét matematika II."){ // The subject name was "Diszkrét matematika II."
                    $this->user_handler->SetSubjectName("ii");
                    $this->correct_parameters["subject_name"] = "1";
                }else{ // The subject name was not "Diszkrét matematika I." or "Diszkrét matematika II.", but a maliciously set value
                    array_push($this->incorrect_parameters, "wrong_3_no_such_subject");        
                }
            }else{ // No subject name given
                array_push($this->incorrect_parameters, "wrong_3_no_subject_name");
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
            $subject_name = $this->user_handler->GetSubjectName();
            $user_status = $this->user_handler->GetUserStatus();
            $subject_group = $this->user_handler->GetSubjectGroup();
    
            if(isset($subject_group)){
                if($user_status == "Diák"){
                    if($subject_name == "i" || $subject_name == "ii"){
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
         * This method validates the user's group addition form.
         * 
         * This method is not defined in the FormValidator class, only the signature is given there.
         * Here a valid form should satisfy the conditions related to neptun code, email address, subject name, subject group, user status and password.
         * If the neptun code is not valid (not given, or not in the database), then there is no sense in validating the password.
         *  
         * @return void
        */
        public function ValidateUser(){
            $this->SubjectNameValidator();
            $this->SubjectGroupValidator();
        }
    }

?>