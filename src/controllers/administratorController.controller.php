<?php
    /**
     * This is a controller class which is responsible for showing the administrator's page.
     * 
     * This controller extends the MainContentController, from which it inherits members that are related to a logged in user.
     * If someone navigates to this page, although they are not logged in, then this controller redirects them to the login page. 
     * Non-administrator, authenticated users will be redirected to the notifications page.
     * On this page, essential informations are displayed.
     * If the user is the administrator, then their pending teachers will be displayed on this page.
    */
    class AdministratorController extends MainContentController{
        private $pending_teachers;
        private $administrator_model;
        
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
            $this->pending_teachers = [];
            $this->administrator_model = new AdministratorModel();
        }
        
        /**
         *
         * This method shows the demonstrator handling page.
         * 
         * It also sets the members, which it inherited from the MainContentController, and are related to a logged in user.
         * If a client types the page name in the searchbar of the browser, but not logged in, then they will be redirected to the login page.
         * Non-administrator, authenticated users will be redirected to the notifications page.
         *  
         * @return void
        */
        public function DemonstratorHandling(){
            if(isset($_SESSION["neptun_code"])){
                $this->SetMembers();
                if($this->is_administrator){ // Only the administrator(s) can see this page 
                    $_SESSION["previous_controller"] = "AdministratorController";
                    $this->pending_teachers = $this->administrator_model->GetPendingTeachers();
                    include(ROOT_DIRECTORY . "/views/demonstratorHandlingPage.view.php");
                }else{
                    header("Location: ./index.php?site=notifications");
                }
            }else{
                header("Location: ./index.php?site=login");
            }
        }

        /**
         *
         * This method finalizes teachers' pending requests.
         * 
         * Only the administrator can finalize a pending teacher, anyone else sending a POST request with the right action will be redirected to the login page.
         * For each record there can be 3 possibilities: deny, accept or do nothing.
         *  
         * @return void
        */
        public function FinalizePending(){    
            if(isset($_SESSION["neptun_code"])){  
                $this->SetMembers();              
                if($this->is_administrator){
                    // Processing the user inputs
                    $decision_array = array();
                    foreach($_POST as $key => $value){
                        if(is_string($key)){
                            $parts = explode(":", $key);
                            $neptun = $parts[0]??"neptun";
                            $id = $parts[1]??"id";
                            if($value === "Elutas??t??s"){
                                $decision = "DENIED";
                            }elseif($value === "Elfogad??s"){
                                $decision = "APPROVED";
                            }else{
                                $decision = "PENDING";
                            }
                            
                            $decision_array[$neptun][$id] = $decision;
                        }
                    }
                    
                    // Comparing the new pending values to the old ones
                    $original_user_information = $this->administrator_model->GetPendingTeachers();
                    $query_array = array();

                    // Iterate through the pending teachers' array
                    foreach($original_user_information as $index => $pending_status){
                        $neptun = $pending_status["neptun_code"];
                        
                        // Can edit only those teachers, that have pending status
                        if(isset($decision_array[$neptun])){
                            $id = $pending_status["subject_id"] . "_" . $pending_status["group_number"]; 
                            $decision = "PENDING";
                            if(isset($decision_array[$neptun][$id])){
                                $decision = $decision_array[$neptun][$id];
                            }

                            // Create the query array, which contains no external (i.e., user given) information
                            array_push($query_array, array("neptun_code" => $neptun, "group_number" => $pending_status["group_number"], "subject_id" => $pending_status["subject_id"], "application_request_status" => $decision));
                        }
                    }

                    $this->administrator_model->UpdatePendingTeachers($query_array);
    
                    header("Location: ./index.php?site=demonstratorHandling");
                }else{
                    header("Location: ./index.php?site=login"); 
                }
            }else{
                header("Location: ./index.php?site=login");
            }
        }
    }

?>