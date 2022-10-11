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
        private $group_addition_model;

        /**
         * 
         */
        public function __construct(){
            parent::__construct();

            $this->error_parameters = [];
            $this->success_parameters = [];
            $this->group_addition_model = new GroupAdditionModel();
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
                $this->SetMembers();

                $group_addition_conditions = MainContentController::GroupAdditionChecker($this->GetPendingStudentGroups(), $this->GetApprovedStudentSubject(), $this->GetApprovedTeacherSubjects());
                $can_apply_to_group = $group_addition_conditions[1];
                $can_add_group = $group_addition_conditions[2];
                
                $this->dimat_i_groups = $this->group_addition_model->GetDataFromDatabase("SELECT DISTINCT subject_group FROM user_groups WHERE subject_name = \"i\" AND is_teacher = 1 AND application_request_status  = \"APPROVED\"", MYSQLI_NUM);
                $this->dimat_ii_groups = $this->group_addition_model->GetDataFromDatabase("SELECT DISTINCT subject_group FROM user_groups WHERE subject_name = \"ii\" AND is_teacher = 1 AND application_request_status  = \"APPROVED\"", MYSQLI_NUM);
                
                include(ROOT_DIRECTORY . "/views/groupAdditionPage.view.php");
            }else{
                header("Location: ./index.php?site=login");
            }
        }

        /**
         * 
         */
        public function ValidateGroupAddition() {
            if( 
                    isset($_POST['subject_name'])
                &&  isset($_POST['user_status'])
            ){  // Do not let the post variable names to be overwritten
                // Initial checkings

                $group = 0;
                if($_POST['user_status'] === "Demonstrátor"){
                    if(isset($_POST["teacher_group"])){
                        $group = $_POST["teacher_group"];
                    }
                }else if($_POST['user_status']=== "Diák"){
                    if($_POST["subject_name"] == "Diszkrét matematika I."){
                        if(isset($_POST["student_group_i"])){
                            $group = $_POST["student_group_i"]??0;
                        }
                    }else if($_POST["subject_name"] == "Diszkrét matematika II."){
                        if(isset($_POST["student_group_ii"])){
                            $group = $_POST["student_group_ii"]??0;
                        }
                    }
                }

                $this->user_handler = new UserHandler("", "", "", "", $_POST["subject_name"], $_POST['user_status'], $group);
                $this->ValidateUser();   
                
                
                if(count($this->error_parameters) === 0){ // Everything was correct 
                    if(    $_POST['user_status'] === "Demonstrátor" 
                        && !in_array($this->GetApprovedTeacherGroups(),[$group, $_POST["subject_name"]])
                        || $_POST['user_status'] === "Diák"
                    ){
                        $this->group_addition_model->UpdateUserGroups($_SESSION['neptun_code'], $this->user_handler->GetSubjectName(), $_POST["user_status"], $group);
                    }
                    
                    header("Location: ./index.php?site=notifications");
                }else{ // There were errors 
                    $this->GroupAddition();
                }                
            }else{ // There was at least one post variable which name was overwritten
                $this->GroupAddition();
            }
        }

        /**
         *
         * This private method validates the user's selected status.
         * 
         * If the input was "Diák", then the correct parameters will be updated with the user_status - "Diák" address key-value pair.
         * If the input was "Demonstrátor", then the correct parameters will be updated with the user_status - "Demonstrátor" address key-value pair.
         * Else the incorrect parameters will be extended with an id that starts with the wrong_1 prefix, and continues with the specific problem (no user status, no such status).
         * 
         * @return void
        */
        private function UserStatusValidator() {
            $user_status = $this->user_handler->GetUserStatus();
    
            if(isset($user_status)){
                if($user_status === "Diák" || $user_status === "Demonstrátor"){
                    $this->success_parameters["user_status"] = $user_status;
                }else{ // The user status is neither "Diák", nor "Demonstrátor"
                    array_push($this->error_parameters, "wrong_1_no_such_status");      
                }
            }else{ // No user status given
                array_push($this->error_parameters, "wrong_1_no_user_status");
            }
        }

        /**
         *
         * This private method validates the user's selected subject name.
         * 
         * If the input was "Diszkrét matematika I.", then the correct parameters will be updated with the subject_name - "0" address key-value pair.
         * If the input was "Diszkrét matematika II.", then the correct parameters will be updated with the subject_name - "1" address key-value pair.
         * Else the incorrect parameters will be extended with an id that starts with the wrong_1 prefix, and continues with the specific problem (no subject name, no such subject).
         * 
         * @return void
        */
        private function SubjectNameValidator() {
            $subject_name = $this->user_handler->GetSubjectName();
    
            if(isset($subject_name)){
                if($subject_name == "Diszkrét matematika I."){ // The subject name was "Diszkrét matematika I."
                    $this->user_handler->SetSubjectName("i");
                    $this->success_parameters["subject_name"] = "0";
                }elseif($subject_name == "Diszkrét matematika II."){ // The subject name was "Diszkrét matematika II."
                    $this->user_handler->SetSubjectName("ii");
                    $this->success_parameters["subject_name"] = "1";
                }else{ // The subject name was not "Diszkrét matematika I." or "Diszkrét matematika II.", but a maliciously set value
                    array_push($this->error_parameters, "wrong_2_no_such_subject");        
                }
            }else{ // No subject name given
                array_push($this->error_parameters, "wrong_2_no_subject_name");
            }
        }
    
        /**
         *
         * This private method validates the user's selected group.
         * 
         * If there is no selected element, or the selected group has no assigned teacher, then the incorrect parameters will be extended with an id that starts with the wrong_2 prefix, and continues with the specific problem (no subject group, no such group).
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
                            $this->success_parameters["subject_group"] = $subject_group;
                        }else{ // There is no teacher assigned to the group which the user selected
                            array_push($this->error_parameters, "wrong_3_no_such_group");
                        }
                    }else{ // The selected subject's name is not correct
                        $this->success_parameters["subject_group"] = 0;
                    }
                }else{ // The user is a teacher
                    if(is_numeric($subject_group) && intval($subject_group) < 31 && intval($subject_group) > 1){
                        $this->correct_parameters["subject_group"] = $subject_group;
                    }else{ // The selected element's text is either not a number, or is not between 1 and 30
                        array_push($this->error_parameters, "wrong_3_no_such_group"); 
                    }
                }
            }else{ // No subject group was given
                array_push($this->error_parameters, "wrong_3_no_subject_group"); 
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
            $this->UserStatusValidator();
            $this->SubjectNameValidator();
            $this->SubjectGroupValidator();
        }
    }

?>