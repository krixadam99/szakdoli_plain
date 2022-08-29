<?php
    
    class StudentGradesController extends MainContentController{
        public function __construct(){
            parent::__construct();
        }
        
        /**
         *
         * This function is responsible for showing the students' grade page 
         * 
         * If a client types the page name in the searchbar of the browser, but not logged in, then they will be redirected to the login page
         * If a user is logged in, but is not a teacher, i.e., has no assigned group, then they will be redirected to the notifications page (every user has this, regardless their status)
         * 
         * @return void
        */
        public function StudentGrades(){
            //Users, who are not logged in won't see this page, they will be redirected to the login page
            if(isset($_SESSION["neptun_code"])){
                $this->SetMembers();

                //Only teachers can see this page, others will be redirected to the notifications page
                if(count($this->GetApprovedTeacherGroups()) != 0){
                    include(ROOT_DIRECTORY . "/views/studentGradesPage.view.php");
                }else{
                    header("Location: ./index.php?site=notifications");
                }
            }else{
                header("Location: ./index.php?site=login");
            }
        }
    }

?>