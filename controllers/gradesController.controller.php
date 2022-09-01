<?php
    /**
     * This is a controller class which is responsible for showing the student's grades' page.
     * 
     * This controller extends the MainContentController, from which it inherits members that are related to a logged in user.
     * If someone navigates to the grades page, although they are not logged in, then this controller redirects them to the login page.
     * If someone navigates to the grades page, however they are not a student, then this controller redirects them to the notifications page.
    */
    class GradesController extends MainContentController{
        /**
         * 
         * The contructor of the GradesController class.
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
         * This method is responsible for showing a student's grades' page.
         * 
         * It also sets the members, which it inherited from the MainContentController, and are related to a logged in user.
         * If a client types the page name in the searchbar of the browser, but not logged in, then they will be redirected to the login page.
         * If a user is logged in, but is not a student, i.e., is not assigned to any group, then they will be redirected to the notifications page (every user has this, regardless their status).
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