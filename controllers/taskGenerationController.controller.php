<?php
    
    class TaskGenerationController extends MainContentController{
        public function __construct(){
            parent::__construct();
        }
        
        public function TaskGeneration(){
            //Users, who are not logged in won't see this page, they will be redirected to the login page
            if(isset($_SESSION["neptun_code"])){
                $this->SetMembers();

                //Only teachers can see this page,others will be redirected to the notifications page
                if(count($this->GetApprovedTeacherGroups()) != 0){
                    include(ROOT_DIRECTORY . "/views/taskGenerationPage.view.php");
                }else{
                    header("Location: ./index.php?site=notifications");
                }
            }else{
                header("Location: ./index.php?site=login");
            }
        }
    }

?>