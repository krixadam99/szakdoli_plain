<?php
    /**
     * This is a controller class which is responsible for showing the student handling page.
     * 
     * This controller extends the MainContentController, from which it inherits members that are related to a logged in user.
     * If someone navigates to the student handling page, although they are not logged in, then this controller redirects them to the login page.
     * If someone navigates to the student handling page, however they are not a teacher, then this controller redirects them to the notifications page.
    */
    class StudentHandlingController extends MainContentController{
        private $student_handler_model;
        
        /**
         * 
         * The contructor of the StudentHandlingController class.
         * 
         * It will call the MainContentController class's constructor with which it will assign default values to the inherited members.
         * 
         * @return void
        */
        public function __construct(){
            parent::__construct();
            $this->student_handler_model = new StudentHandlingModel();
        }
        
        /**
         *
         * This method is responsible for showing the student handler page.
         * 
         * If a client types the page name in the searchbar of the browser, but not logged in, then they will be redirected to the login page.
         * If a user is logged in, but is not a teacher, i.e., has no assigned group, then they will be redirected to the notifications page (every user has this, regardless their status).
         * 
         * @return void
         */
        public function StudentHandling(){
            // Users, who are not logged in won't see this page, they will be redirected to the login page
            if(isset($_SESSION["neptun_code"])){
                $this->SetMembers();

                // Only teachers can see this page, others will be redirected to the notifications page
                if(count($this->approved_teacher_groups) != 0){
                    
                    // Fetching all the students belonging to the subject id - group number pair
                    $all_students = [];
                    foreach($this->approved_teacher_groups as $group_counter => $group_id_pair){
                        $pending_students_per_subject_group = $this->student_handler_model->GetStudents($group_id_pair["subject_id"], $group_id_pair["subject_group"]);
                        array_push($all_students, array("subject_id" => $group_id_pair["subject_id"], "subject_group" => $group_id_pair["subject_group"], "users" => array_values($pending_students_per_subject_group)));
                    }

                    include(ROOT_DIRECTORY . "/views/studentHandlingPage.view.php");
                }else{
                    header("Location: ./index.php?site=notifications");
                }
            }else{
                header("Location: ./index.php?site=login");
            }
        }

        /**
         *
         * This method is responsible for handling students' requests.
         * 
         * Only teachers can handle students. And they can only modify the data of their students.
         * Pending students can be either deined, accepted or ignored.
         * Denied students can be accepted and accepted students can be denied.
         * Accepted students has "ACCEPTED" as their pending request.
         * Denied students has "DENIED" as their pending request.
         * Pending students has "PENDING" as their pending request.
         * 
         * @return void
        */
        public function HandleStudents(){
            //Neptun code, subject group and subject name must be set in the session, otherwise we cannot move forward
            if(isset($_SESSION["neptun_code"])){
                $this->SetMembers();
                if(
                        isset($_SESSION["group"]) && isset($_SESSION["subject"])
                    &&  in_array(["subject_id" => $_SESSION["subject"],"subject_group" => $_SESSION["group"]], $this->approved_teacher_groups)
                ){ // Only teachers can handle students
                    
                    $current_subject = $_SESSION["subject"];
                    $current_group = $_SESSION["group"];
                
                    // Processing the user inputs
                    $decision_array = array();
                    foreach($_POST as $key => $value){
                        if(is_string($key)){
                            $neptun = $key;
                            $decision = "";
                            $id = $current_subject . "_" . $current_group;
                            if($value != "-"){
                                if($value == "ELFOGADÁS" || $value == "VISSZAVÉTEL"){
                                    $decision = "APPROVED";
                                }else if($value == "ELUTASÍTÁS" || $value == "TÖRLÉS"){
                                    $decision = "DENIED";
                                }
                                $decision_array[$neptun][$id] = $decision;
                            }
                        }
                    }
                    
                    // Getting the students belonging to the user
                    $original_user_information = $this->student_handler_model->GetStudents($_SESSION["subject"], $_SESSION["group"]);
                    $query_array = array();

                    // Iterate through the user's students' array
                    foreach($original_user_information as $index => $original_record){
                        $neptun = $original_record["neptun_code"];
                        
                        // Can edit only those students, who belong to one of their groups
                        if(isset($decision_array[$neptun])){
                            $id = $current_subject . "_" . $current_group; 
                            $decision = "APPROVED";
                            if(isset($decision_array[$neptun][$id])){
                                $decision = $decision_array[$neptun][$id];

                                // Create the query array, which contains no external (i.e., user given) information
                                array_push($query_array, array("neptun_code" => $neptun, "user_status" => "student", "group_number" => $current_group, "subject_id" => $current_subject, "application_request_status" => $decision));
                            }
                        }
                    }
    
                    $this->student_handler_model->UpdatePendingStudents($query_array);
                    
                    header("Location: ./index.php?site=studentHandling&group=" . $_SESSION["group"] . "&subject=" . $_SESSION["subject"]);
                }else{
                    header("Location: ./index.php?site=notifications");
                }
            }else{
                header("Location: ./index.php");
            }
        }
    }

?>