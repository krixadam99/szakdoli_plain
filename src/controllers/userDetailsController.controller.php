<?php
    /**
     * This is a controller class which is responsible for showing the group addition page.
     * 
     * This controller extends the MainContentController, from which it inherits its members.
    */
    class UserDetailsController extends MainContentController {        
        private $user_details_model;

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

            $this->user_details_model = new UserDetailsModel();
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
                    $_SESSION["previous_controller"] = "UserDetailsController";

                    $group_addition_conditions = MainContentController::GroupAdditionChecker($this->GetPendingStudentGroups(), $this->GetApprovedStudentSubject(), $this->GetApprovedTeacherSubjects());
                    $can_apply_to_group = $group_addition_conditions[1]??false;
                    $can_add_group_for_dimat_i = $group_addition_conditions[2]??false;
                    $can_add_group_for_dimat_ii = $group_addition_conditions[3]??false;

                    if(!$group_addition_conditions[0]){
                        header("Location: ./index.php?site=notifications");
                    }
                    
                    $this->dimat_i_groups = $this->user_details_model->GetDataFromDatabase("SELECT DISTINCT group_number FROM subject_groups JOIN user_status USING(subject_group_id) WHERE subject_id = \"i\" AND group_number != 0 AND is_teacher = 1 AND application_request_status  = \"APPROVED\"");
                    $this->dimat_ii_groups = $this->user_details_model->GetDataFromDatabase("SELECT DISTINCT group_number FROM subject_groups JOIN user_status USING(subject_group_id) WHERE subject_id = \"ii\" AND group_number != 0 AND is_teacher = 1  AND application_request_status  = \"APPROVED\"");
                    
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
                    $_SESSION["previous_controller"] = "UserDetailsController";

                    $user_details_editing = true;
                    $user_details = $this->user_details_model->GetUserDetails($_SESSION["neptun_code"]);

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

                if(!$group_addition_conditions){
                    header("Location: ./index.php?site=notifications");
                    exit();
                }
                
                $subject_id = "INVALID NAME ATTRIBUTE";
                // Setting the subject id based on the selected subject
                if(isset($_POST["subject_id"])){
                    if($_POST["subject_id"] == "Diszkrét matematika I."){
                        $subject_id = "i";
                    }else if($_POST["subject_id"] == "Diszkrét matematika II."){
                        $subject_id = "ii";
                    }
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

                                // Discrete mathematics II. group can be one of the groups having at least one teacher with approved status/ group and have "i" id
                                $dimat_i_groups = $this->user_details_model->GetDataFromDatabase("SELECT DISTINCT group_number FROM subject_groups JOIN user_status USING(subject_group_id) WHERE subject_id = \"i\" AND group_number != 0 AND is_teacher = 1 AND application_request_status  = \"APPROVED\"");
                                foreach($dimat_i_groups as $key=>$group_number){
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
                                $dimat_ii_groups = $this->user_details_model->GetDataFromDatabase("SELECT DISTINCT group_number FROM subject_groups JOIN user_status USING(subject_group_id) WHERE subject_id = \"ii\" AND group_number != 0 AND is_teacher = 1 AND application_request_status  = \"APPROVED\"");
                                foreach($dimat_ii_groups as $key=>$group_number){
                                   array_push($possible_group_numbers, $group_number["group_number"]);
                                }
                                array_push($possible_group_numbers, "0");
                            }
                        }
                    }

                    // Checking if the user is elligible to apply to the given subject with the given status 
                    if($can_apply_to_group){
                        if(!$can_add_group_for_dimat_i){
                            if($_POST["subject_id"] == "Diszkrét matematika I."){
                                $this->incorrect_parameters["subject_id"] = "Nem lehet a tárgy Diszkrét matematika I.!";
                            }
                        }

                        if(!$can_add_group_for_dimat_ii){
                            if($_POST["subject_id"] == "Diszkrét matematika II."){
                                $this->incorrect_parameters["subject_id"] = "Nem lehet a tárgy Diszkrét matematika II.!";
                            }
                        }

                        if(!$can_add_group_for_dimat_i && !$can_add_group_for_dimat_ii){
                            if($_POST["user_status"] == "Demonstrátor"){
                                $this->incorrect_parameters["user_status"] = "Nem lehet a státusz demonstrátor!";
                            }
                        }
                    }else{
                        if($_POST["user_status"] == "Diák"){
                            $this->incorrect_parameters["user_status"] = "Nem lehet a státusz diák!";
                        }else{
                            if(!$can_add_group_for_dimat_i){
                                if($_POST["subject_id"] == "Diszkrét matematika I."){
                                    $this->incorrect_parameters["subject_id"] = "Nem lehet a tárgy Diszkrét matematika I.!";
                                }
                            }
    
                            if(!$can_add_group_for_dimat_ii){
                                if($_POST["subject_id"] == "Diszkrét matematika II."){
                                    $this->incorrect_parameters["subject_id"] = "Nem lehet a tárgy Diszkrét matematika II.!";
                                }
                            }
                        }
                    }
                }
    
                // Validating the form
                // The subject id should be a string, and either "i" (Discrete mathematics II.), or "ii" (Discrete mathematics II.)
                // The user status a string, and it should be either "Diák", or "Demonstrátor"
                // The group number a string, and it should be a valid number
                $this->ValidateInputs(
                    [
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
                        
                    ]
                );
                
                if(
                      count($this->incorrect_parameters) === 0
                ){ // Everything was correct 
                    if(    $_POST['user_status'] === "Demonstrátor"
                        || $_POST['user_status'] === "Diák"
                    ){
                        $this->user_details_model->UpdateUserGroups($_SESSION['neptun_code'], $subject_id, $_POST["user_status"], $group);
                    }
                    
                    header("Location: ./index.php?site=notifications");
                }else{ // There is at least one incorrect input
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
                // Fetch all of the email addresses from the users table
                $email_addresses_array = $this->user_details_model->GetEmailAddresses();
                $email_addresses = [];
                foreach($email_addresses_array as $email_address_counter => $email_address_array){
                    array_push($email_addresses, $email_address_array["email_address"]);
                }

                // Validating the form
                // The email address should be a string, not the placeholder, or the empty string, it should be of email format, finally it should be unique
                // The password should be a string, not the placeholder, or the empty string, the length should be greater than 7, it should contain at leaset 1 number, 1 small and capital english alphabet character, and at least 1 of the ",", "-", ".", "?", "!" characters
                // The reassuring password should be a string, not the placeholder, or the empty string, and it should be the same as the original password
                $this->ValidateInputs(
                    [
                        "user_email:email cím" => array($_POST["user_email"]??"INVALID NAME ATTRIBUTE" => [
                            "type" => "string",
                            "not_placeholder" => "",
                            "filter_var" => FILTER_VALIDATE_EMAIL, // No need for sanitazing
                            "unique" => $email_addresses
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
                            "is_same" => $_POST["user_password"]??"INVALID NAME ATTRIBUTE"
                        ])
                    ]
                );
                
                $email_can_be_modified = false;
                if(!isset($this->incorrect_parameters["user_email"])){
                    $email_can_be_modified = true;
                }

                $password_can_be_modified = false;
                if(!isset($this->incorrect_parameters["user_password"]) && !isset($this->incorrect_parameters["user_password_again"])){
                    $password_can_be_modified = true;
                }
        
                if($email_can_be_modified || $password_can_be_modified){ // Everything was correct 
                    $new_email = "";
                    if($email_can_be_modified){
                        $new_email = $_POST["user_email"];
                    }

                    $new_password = "";
                    if($password_can_be_modified){
                        $new_password = $_POST["user_password"];
                    }
                    
                    $this->user_details_model->UpdateUserDetails($_SESSION["neptun_code"], $new_email, $new_password);
                    header("Location: ./index.php?site=notifications");
                }else{ // There is at least one incorrect input
                    $this->PersonalInformation();
                }  
            }else{
                header("Location: ./index.php?site=login");
            }
        }
    }

?>