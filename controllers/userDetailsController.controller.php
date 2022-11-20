<?php
    /**
     * This is a controller class which is responsible for showing the group addition page.
     * 
     * This controller extends the MainContentController, from which it inherits its members.
    */
    class UserDetailsController extends MainContentController {        
        private $user_handler;
        private $error_parameters;
        private $success_parameters;
        private $user_detail_model;

        /**
         * The contructor of the GroupAdditionController class.
         * 
         * It will call the MainContentController class's constructor with which it will assign default values to the inherited members.
         * 
         * @return void
         */
        public function __construct(){
            parent::__construct();
            $this->error_parameters = [];
            $this->success_parameters = [];

            $this->user_detail_model = new UserDetailsModel();
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
                // The administrator cannot see this page
                if(!$this->is_administrator){
                    $group_addition_conditions = MainContentController::GroupAdditionChecker($this->GetPendingStudentGroups(), $this->GetApprovedStudentSubject(), $this->GetApprovedTeacherSubjects());
                    $can_apply_to_group = $group_addition_conditions[1]??false;
                    $can_add_group_for_dimat_i = $group_addition_conditions[2]??false;
                    $can_add_group_for_dimat_ii = $group_addition_conditions[3]??false;
                    
                    $this->dimat_i_groups = $this->user_detail_model->GetDataFromDatabase("SELECT DISTINCT group_number FROM subject_group JOIN user_status USING(subject_group_id) WHERE subject_id = \"i\" AND group_number != 0 AND is_teacher = 1 AND application_request_status  = \"APPROVED\"", MYSQLI_NUM);
                    $this->dimat_ii_groups = $this->user_detail_model->GetDataFromDatabase("SELECT DISTINCT group_number FROM subject_group JOIN user_status USING(subject_group_id) WHERE subject_id = \"ii\" AND group_number != 0 AND is_teacher = 1  AND application_request_status  = \"APPROVED\"", MYSQLI_NUM);
                    
                    include(ROOT_DIRECTORY . "/views/userDetailsPage.view.php");
                }else{
                    header("Location: ./index.php?site=demonstratorHandling");
                }
            }else{
                header("Location: ./index.php?site=login");
            }
        }

        /**
         *
         * This method is responsible for showing the personal information editing page.
         * 
         * If a client types the page name in the searchbar of the browser, but not logged in, then they will be redirected to the login page.
         * 
         * @return void
        */
        public function PersonalInformation() {
            //Users, who are not logged in won't see this page, they will be redirected to the login page
            if(isset($_SESSION["neptun_code"])){
                $this->SetMembers();
                // The administrator cannot see this page
                if(!$this->is_administrator){
                    $user_details_editing = true;
                    $user_details = $this->user_detail_model->GetUserDetails($_SESSION["neptun_code"]);

                    include(ROOT_DIRECTORY . "/views/userDetailsPage.view.php");
                }else{
                    header("Location: ./index.php?site=demonstratorHandling");
                }
            }else{
                header("Location: ./index.php?site=login");
            }
        }

        /**
         * This method validates the group application request of a user.
         * 
         * This method validates the data sent by the user. 
         * If everything (the group number - subject name pair exists, and the status is valid) was correct, then the data will be saved, otherwise, the user will be redirected to the group addition page with the appropriate error messages.
         * 
         * @return void
         */
        public function ValidateGroupAddition() {
            if(isset($_SESSION["neptun_code"])){    
                $this->SetMembers();
                $group_addition_conditions = MainContentController::GroupAdditionChecker($this->GetPendingStudentGroups(), $this->GetApprovedStudentSubject(), $this->GetApprovedTeacherSubjects());
                $can_apply_to_group = $group_addition_conditions[1]??false;
                $can_add_group_for_dimat_i = $group_addition_conditions[2]??false;
                $can_add_group_for_dimat_ii = $group_addition_conditions[3]??false;
                
                if(isset($_POST["subject_id"])){
                    if($_POST["subject_id"] == "Diszkrét matematika I."){
                        $subject_id = "i";
                    }else if($_POST["subject_id"] == "Diszkrét matematika II."){
                        $subject_id = "ii";
                    }
                }else{
                    $subject_id = "INVALID NAME ATTRIBUTE";
                }
    
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
                            for($counter = 1; $counter < 30; $counter++) array_push($possible_group_numbers, $counter);
                        }
                    }else if($_POST["user_status"] == "Diák"){
                        if($_POST["subject_id"] == "Diszkrét matematika I."){
                            $group_name_attribute = "student_group_i";
                            if(isset($_POST["student_group_i"])){
                                $group = $_POST["student_group_i"]??"0";
                                if($group === "-") $group  = "0";
                                
                                $dimat_i_groups = $this->user_detail_model->GetDataFromDatabase("SELECT DISTINCT group_number FROM subject_group JOIN user_status USING(subject_group_id) WHERE subject_id = \"i\" AND group_number != 0 AND is_teacher = 1 AND application_request_status  = \"APPROVED\"", MYSQLI_NUM);
                                foreach($dimat_i_groups as $key=>$group_number){
                                   array_push($possible_group_numbers, $group_number[0]);
                                }
                                array_push($possible_group_numbers, "0");
                            }
                        }else if($_POST["subject_id"] == "Diszkrét matematika II."){
                            $group_name_attribute = "student_group_ii";   
                            if(isset($_POST["student_group_ii"])){
                                $group = $_POST["student_group_ii"]??"0";
                                if($group === "-") $group  = "0";
    
                                $dimat_ii_groups = $this->user_detail_model->GetDataFromDatabase("SELECT DISTINCT group_number FROM subject_group JOIN user_status USING(subject_group_id) WHERE subject_id = \"ii\" AND group_number != 0 AND is_teacher = 1 AND application_request_status  = \"APPROVED\"", MYSQLI_NUM);
                                foreach($dimat_ii_groups as $key=>$group_number){
                                   array_push($possible_group_numbers, $group_number[0]);
                                }
                                array_push($possible_group_numbers, "0");
                            }
                        }
                    }

                    $cannot_advance = false;
                    if($can_apply_to_group){
                        if(!$can_add_group_for_dimat_i){
                            if($_POST["subject_id"] == "Diszkrét matematika I."){
                                $cannot_advance = true;
                            }
                        }

                        if(!$can_add_group_for_dimat_ii){
                            if($_POST["subject_id"] == "Diszkrét matematika II."){
                                $cannot_advance = true;
                            }
                        }

                        if(!$can_add_group_for_dimat_i && !$can_add_group_for_dimat_ii){
                            if($_POST["user_status"] == "Demonstrátor"){
                                $cannot_advance = true;
                            }
                        }
                    }else{
                        if($_POST["user_status"] == "Diák"){
                            $cannot_advance = true;
                        }else{
                            if(!$can_add_group_for_dimat_i){
                                if($_POST["subject_id"] == "Diszkrét matematika I."){
                                    $cannot_advance = true;
                                }
                            }
    
                            if(!$can_add_group_for_dimat_ii){
                                if($_POST["subject_id"] == "Diszkrét matematika II."){
                                    $cannot_advance = true;
                                }
                            }
                        }
                    }
                }
    
                $this->ValidateInputs(
                    [
                        "subject_id:tárgy" => array($subject_id => [
                            "in_array" => ["i", "ii"]
                        ]),
                        "user_status:felhasználói státusz" => array($_POST["user_status"]??"INVALID NAME ATTRIBUTE" => [
                            "in_array" => ["Diák", "Demonstrátor"]
                        ]),
                        "$group_name_attribute:csoport" => array($group => [
                            "in_array" => $possible_group_numbers
                        ]),
                        
                    ]
                );
                
                if(
                       count($this->error_parameters) === 0
                    && !$cannot_advance
                ){ // Everything was correct 
                    if(    $_POST['user_status'] === "Demonstrátor"
                        || $_POST['user_status'] === "Diák"
                    ){
                        $this->user_detail_model->UpdateUserGroups($_SESSION['neptun_code'], $subject_id, $_POST["user_status"], $group);
                    }
                    
                    header("Location: ./index.php?site=notifications");
                }else{ // There were errors 
                    $this->GroupAddition();
                }
            }else{
                header("Location: ./index.php?site=login");
            }
        }

        /**
         * This method validates the user details edition request.
         * 
         * This method validates the data sent by the user. 
         * If everything (email address and password) was correct, then the data will be saved, otherwise, the user will be redirected to the group addition page with the appropriate error messages.
         * 
         * @return void
         */
        public function ValidateNewPersonalInformation() {
            if(isset($_SESSION["neptun_code"])){
                $this->ValidateInputs(
                    [
                        "user_email" => array($_POST["user_email"]??"INVALID" => [
                            "not_placeholder" => "",
                            "filter_var" => FILTER_VALIDATE_EMAIL
                        ]),
                        "user_password:jelszó" => array($_POST["user_password"]??"INVALID NAME ATTRIBUTE" => [
                            "not_placeholder" => ["","Jelszó..."],
                            "length" => [">=", 8],
                            "preg_match" => ["/[a-z]/", "/[A-Z]/", "/[0-9]/", "/[\-\,\.\?\!]/"]
                        ]),
                        "user_password_again:megerősítő jelszó" => array($_POST["user_password_again"]??"INVALID NAME ATTRIBUTE" => [
                            "not_placeholder" => ["","Jelszó megerősítése..."],
                            "is_same" => $_POST["user_password"]??"INVALID NAME ATTRIBUTE",
                        ])
                    ]
                );
        
                if(count($this->incorrect_parameters) === 0){ // Everything was correct 
                    $this->user_detail_model->UpdateUserDetails($_SESSION["neptun_code"], $_POST["user_email"], $_POST["user_password"]);
                    header("Location: ./index.php?site=notifications");
                }else{ // There were errors 
                    $this->PersonalInformation();
                }  
            }else{
                header("Location: ./index.php?site=login");
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
         * If the input was "Diszkrét matematika I.", then the correct parameters will be updated with the subject_id - "0" address key-value pair.
         * If the input was "Diszkrét matematika II.", then the correct parameters will be updated with the subject_id - "1" address key-value pair.
         * Else the incorrect parameters will be extended with an id that starts with the wrong_1 prefix, and continues with the specific problem (no subject name, no such subject).
         * 
         * @return void
        */
        private function SubjectNameValidator() {
            $subject_id = $this->user_handler->GetSubjectId();
    
            if(isset($subject_id)){
                if($subject_id == "Diszkrét matematika I."){ // The subject name was "Diszkrét matematika I."
                    $this->user_handler->SetSubjectId("i");
                    $this->success_parameters["subject_id"] = "0";
                }elseif($subject_id == "Diszkrét matematika II."){ // The subject name was "Diszkrét matematika II."
                    $this->user_handler->SetSubjectId("ii");
                    $this->success_parameters["subject_id"] = "1";
                }else{ // The subject name was not "Diszkrét matematika I." or "Diszkrét matematika II.", but a maliciously set value
                    array_push($this->error_parameters, "wrong_2_no_such_subject");        
                }
            }else{ // No subject name given
                array_push($this->error_parameters, "wrong_2_no_subject_id");
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
            $subject_id = $this->user_handler->GetSubjectId();
            $user_status = $this->user_handler->GetUserStatus();
            $subject_group = $this->user_handler->GetSubjectGroup();
    
            if(isset($subject_group)){
                if($user_status == "Diák"){
                    if($subject_id == "i" || $subject_id == "ii"){
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
        private function ValidateUser(){
            $this->UserStatusValidator();
            $this->SubjectNameValidator();
            $this->SubjectGroupValidator();
        }
    }

?>