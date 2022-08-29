<?php
    
    class StudentHandlingController extends MainContentController{
        public function __construct(){
            parent::__construct();
        }
        
        /**
         *
         * This function is responsible for showing the student handler page 
         * 
         * If a client types the page name in the searchbar of the browser, but not logged in, then they will be redirected to the login page
         * If a user is logged in, but is not a teacher, i.e., has no assigned group, then they will be redirected to the notifications page (every user has this, regardless their status)
         * 
         * @return void
         */
        public function StudentHandling(){
            //Users, who are not logged in won't see this page, they will be redirected to the login page
            if(isset($_SESSION["neptun_code"])){
                $this->SetMembers();
                
                //Only teachers can see this page, others will be redirected to the notifications page
                if(count($this->GetApprovedTeacherGroups()) != 0){
                    include(ROOT_DIRECTORY . "/views/studentHandlingPage.view.php");
                }else{
                    header("Location: ./index.php?site=notifications");
                }
            }else{
                header("Location: ./index.php?site=login");
            }
        }

        public function HandleStudents(){
            //Neptun code, subject group and subject name must be set in the session, otherwise we cannot move forward
            if(isset($_SESSION["neptun_code"]) && isset($_SESSION["group"]) && isset($_SESSION["subject"])){
                $current_subject = $_SESSION["subject"];
                $current_group = $_SESSION["group"];
            
                $student_handler_model = new StudentHandlingModel($_SESSION["neptun_code"]);
            
                $decision_array = array();
                foreach($_POST as $key => $value){
                    $neptun = $key;
                    $decision = "";
                    $id = $current_subject . "_" . $current_group;
                    if($value != "-"){
                        if($value == "ELFOGADÁS" || $value == "VISSZAVÉTEL"){
                            $decision = "0";
                        }else if($value == "ELUTASÍTÁS" || $value == "TÖRLÉS"){
                            $decision = "-1";
                        }
                        $decision_array[$neptun][$id] = $decision;
                    }
                }
                
                $original_user_information = $student_handler_model->GetStudents($_SESSION["subject"], $_SESSION["group"]);
                $query_array = array();
                foreach($original_user_information as $index => $original_record){
                    $neptun = $original_record["neptun_code"];
                    
                    if(isset($decision_array[$neptun])){
                        $id = $current_subject . "_" . $current_group; 
                        $decision = "1";
                        if(isset($decision_array[$neptun][$id])){
                            $decision = $decision_array[$neptun][$id];
                            array_push($query_array, array("neptun_code" => $neptun, "user_status" => "student", "subject_group" => $current_group, "subject_name" => $current_subject, "pending_status" => $decision));
                        }
                    }
                }

            
                $student_handler_model->UpdatePendingData($query_array);
                $this->StudentHandling();
            }else{
                header("Location: ./index.php");
            }
        }
    }

?>