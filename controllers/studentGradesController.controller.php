<?php
    /**
     * This is a controller class which is responsible for showing the students' grades' page.
     * 
     * This controller extends the MainContentController, from which it inherits members that are related to a logged in user.
     * If someone navigates to the students' grades' page, although they are not logged in, then this controller redirects them to the login page.
     * If someone navigates to the students' grades' page, however they are not a teacher, then this controller redirects them to the notifications page.
    */
    class StudentGradesController extends MainContentController{
        /**
         * 
         * The contructor of the StudentGradesController class.
         * 
         * It will call the MainContentController class's constructor with which it will assign default values to the inherited members.
         * 
         * @return void
         */
        public function __construct(){
            parent::__construct();
        }
        
        /**
         *
         * This method is responsible for showing the students' grade page 
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