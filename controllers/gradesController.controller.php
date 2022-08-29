<?php
    
    class GradesController extends MainContentController{
        public function __construct(){
            parent::__construct();
        }
        
        /**
         *
         * This function is responsible for showing a student's grades page 
         * 
         * If a client types the page name in the searchbar of the browser, but not logged in, then they will be redirected to the login page
         * If a user is logged in, but is not a student, i.e., is not assigned to any group, then they will be redirected to the notifications page (every user has this, regardless their status)
         * 
         * @return void
        */
        public function Grades(){
            //Users, who are not logged in won't see this page, they will be redirected to the login page
            if(isset($_SESSION["neptun_code"])){
                $this->SetMembers();

                //Only students can see this page, otherwise, the user will be redirected to the notifications page
                if($this->GetApprovedStudentSubject() != ""){
                    include(ROOT_DIRECTORY . "/views/gradesPage.view.php");
                }else{
                    header("Location: ./index.php?site=notifications");
                }
            }else{
                header("Location: ./index.php?site=login");
            }
        }
    }

?>