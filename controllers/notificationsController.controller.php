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
         * This function is responsible for showing the notifications page.
         * 
         * It also sets the members, which it inherited from the MainContentController, and are related to a logged in user.
         * If a client types the page name in the searchbar of the browser, but not logged in, then they will be redirected to the login page.
         *  
         * @return void
        */
        public function Notifications(){
            if(isset($_SESSION["neptun_code"])){
                $this->SetMembers();
                include(ROOT_DIRECTORY . "/views/notificationPage.view.php");
            }else{
                header("Location: ./index.php?site=login");
            }
        }

        /**
         *
         * This function is responsible for finalizing teachers' pending requests.
         * 
         * Only the administrator can finalize a pending, anyone else sending a POST request with the right action will be redirected to the login page.
         * For each record there can be 3 possibilities: deny, accept or nothing.
         * The administrator is also able to remove a teacher from the accepted teachers (TODO).
         *  
         * @return void
        */
        public function FinalizePending(){    
            if(isset($_SESSION["neptun_code"]) && $_SESSION["neptun_code"] == "admin"){
                $notification_model = new NotificationModel("szakdoli");
                
                $decision_array = array();
                foreach($_POST as $key => $value){
                    //Protection should be added here...
                    $parts = explode(":", $key);
                    $neptun = $parts[0];
                    $id = $parts[1];
                    $decision = $value=="ELFOGADÁS"?"0":"-1";
                    
                    $decision_array[$neptun][$id] = $decision;
                }
                
                $original_user_information = $notification_model->GetPendingTeachers();
                $query_array = array();
                foreach($original_user_information as $index => $pending_status){
                    $neptun = $pending_status["neptun_code"];
                    
                    if(isset($decision_array[$neptun])){
                        $id = $pending_status["subject_name"] . "_" . $pending_status["subject_group"]; 
                        $decision = "1";   
                        if(isset($decision_array[$neptun][$id])){
                            $decision = $decision_array[$neptun][$id];
                        }   
                        array_push($query_array, array("neptun_code" => $neptun, "user_status" => "teacher", "subject_group" => $pending_status["subject_group"], "subject_name" => $pending_status["subject_name"], "pending_status" => $decision));
                    }
                }
            
                $notification_model->UpdatePendingData($query_array);
                $this->Notifications();
            }else{
                header("Location: ./index.php?site=login");
            }
        }
    }

?>