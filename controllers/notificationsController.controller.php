<?php
    
    class NotificationsController extends MainContentController{
        public function __construct(){
            parent::__construct();
        }
        
        public function Notifications(){
            if(isset($_SESSION["neptun_code"])){
                $this->SetMembers();
                include(ROOT_DIRECTORY . "/views/notificationPage.view.php");
            }else{
                header("Location: ./index.php?site=login");
            }
         }

        public function FinalizePending(){    
            if(isset($_SESSION["neptun_code"]) && $_SESSION["neptun_code"] == "admin"){
                $notification_model = new NotificationModel("szakdoli");
                
                $decision_array = array();
                foreach($_POST as $key => $value){
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
                header("Location: ./index.php");
            }
        }
    }

?>