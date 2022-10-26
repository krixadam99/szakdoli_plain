<?php
    /**
     * This is a controller class which is responsible for showing the notifications' page.
     * 
     * This controller extends the MainContentController, from which it inherits members that are related to a logged in user.
     * If someone navigates to the navigations page, although they are not logged in, then this controller redirects them to the login page.
     * On this page, essential informations are displayed.
     * If the user is the administrator, then their pending teachers will be displayed on this page.
    */
    class NotificationsController extends MainContentController{
        /**
         * 
         * The contructor of the NotificationsController class.
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
         * This method shows the notifications page.
         * 
         * It also sets the members, which it inherited from the MainContentController, and are related to a logged in user.
         * If a client types the page name in the searchbar of the browser, but not logged in, then they will be redirected to the login page.
         *  
         * @return void
        */
        public function Notifications(){
            if(isset($_SESSION["neptun_code"])){
                $this->SetMembers();
                if(!$this->is_administrator){
                    include(ROOT_DIRECTORY . "/views/notificationPage.view.php");
                }else{
                    header("Location: ./index.php?site=demonstratorHandling");
                }
            }else{
                header("Location: ./index.php?site=login");
            }
        }
    }

?>