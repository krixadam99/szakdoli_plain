<?php
    /**
     * This is a controller class which is responsible for showing the administrator's page.
     * 
     * This controller extends the MainContentController, from which it inherits members that are related to a logged in user.
     * If someone navigates to the navigations page, although they are not logged in, then this controller redirects them to the login page.
     * On this page, essential informations are displayed.
     * If the user is the administrator, then their pending teachers will be displayed on this page.
    */
    class AdministratorController extends MainContentController{
        /**
         * 
         * The contructor of the AdministratorController class.
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
        public function DemonstratorHandling(){
            if(isset($_SESSION["neptun_code"]) && $_SESSION["neptun_code"] === "admin"){
                $this->SetMembers();
                include(ROOT_DIRECTORY . "/views/demonstratorHandlingPage.view.php");
            }else{
                header("Location: ./index.php?site=login");
            }
        }

        /**
         *
         * This method finalizes teachers' pending requests.
         * 
         * Only the administrator can finalize a pending, anyone else sending a POST request with the right action will be redirected to the login page.
         * For each record there can be 3 possibilities: deny, accept or nothing.
         *  
         * @return void
        */
        public function FinalizePending(){    
            if(isset($_SESSION["neptun_code"]) && $_SESSION["neptun_code"] == "admin"){
                $notification_model = new NotificationModel("szakdoli");
                
                // Processing the user inputs
                $decision_array = array();
                foreach($_POST as $key => $value){
                    //Protection should be added here...
                    $parts = explode(":", $key);
                    $neptun = $parts[0]??"neptun";
                    $id = $parts[1]??"id";
                    if($value === "-"){
                        $decision = "1";
                    }elseif($value === "ELFOGADÁS"){
                        $decision = "0";
                    }else{
                        $decision = "-1";
                    }
                    
                    $decision_array[$neptun][$id] = $decision;
                }
                
                // Comparing the new pending values to the older ones
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
                header("Location: ./index.php?site=demonstratorHandling");
            }else{
                header("Location: ./index.php?site=login");
            }
        }
    }

?>