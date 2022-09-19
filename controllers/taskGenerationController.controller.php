<?php
    /**
     * This is a controller class which is responsible for showing the task generation page.
     * 
     * This controller extends the MainContentController, from which it inherits members that are related to a logged in user.
     * If someone navigates to the task generation page, although they are not logged in, then this controller redirects them to the login page.
     * If someone navigates to the task generation page, however they are not a teacher, then this controller redirects them to the notifications page.
    */
    class TaskGenerationController extends MainContentController{
        /**
         * 
         * The contructor of the TaskGenerationController class.
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
         * This method is responsible for showing the task generation page.
         * 
         * It also sets the members, which it inherited from the MainContentController, and are related to a logged in user.
         * If a client types the page name in the searchbar of the browser, but not logged in, then they will be redirected to the login page.
         * If a client types the page name in the searchbar of the browser, but is not a teacher, then they will be redirected to the notifications page.
         *  
         * @return void
        */
        public function TaskGeneration(){
            //Users, who are not logged in won't see this page, they will be redirected to the login page
            if(isset($_SESSION["neptun_code"])){
                // Setting the preview to default, if not set
                if(!isset($_SESSION["preview"]) || !isset($_SESSION["exam_type"])){
                    $_SESSION["preview"] = [];
                }
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

        /**
         * 
         */
        public function CreatePreview(){
            if(isset($_SESSION["neptun_code"])){
                $_SESSION["preview"] = $_POST;
                $_SESSION["preview_tasks"] = [];

                $task_counter = 0;
                foreach($_POST as $key => $value){
                    if(is_string($key) &&  is_numeric(strpos($key, "_main_topic"))){
                        $main_task_index = $value;
                        if(isset($_POST[explode("_main_topic",$key)[0] . "_subtopic"]) && isset($_POST[explode("_main_topic",$key)[0] . "_task_quantity"])){
                            $subtask_index = $_POST[explode("_main_topic",$key)[0] . "_subtopic"];
                            $subtask_count = $_POST[explode("_main_topic",$key)[0] . "_task_quantity"];
                            if(is_numeric($subtask_count) && intval($subtask_count) > 0){
                                array_push($_SESSION["preview_tasks"], $this->GenerateTask($main_task_index, $subtask_index, intval($subtask_count)));
                            }
                        }
                    }
                }

                $subject = $_SESSION["subject"]??"";
                $exam_type = $_SESSION["exam_type"]??"";
                header("Location: ./index.php?site=taskGeneration&" . "subject=$subject&" . "exam_type=$exam_type");
            }else{
                header("Location: ./index.php?site=login");
            }
        }

        /**
         * 
         */
        private function GenerateTask($main_task_index, $subtask_index, $subtask_count){
            $task = array("task_descriptions" => "", "task_solutions" => "");
            $new_task = [];

            if($_SESSION["subject"] == "i"){
                switch($main_task_index){
                    case "0":{

                    }break;
                    case "1":{

                    }break;
                    case "2":{

                    }break;
                    case "3":{

                    }break;
                    case "4":{

                    }break;
                    case "5":{

                    }break;
                    case "6":{

                    }break;
                    case "7":{

                    }break;
                    case "8":{

                    }break;
                    case "9":{

                    }break;
                    default:break;
                };
            }elseif($_SESSION["subject"] == "ii"){
                $dimat_ii_subtasks = new DimatiiSubtasks();
                switch($main_task_index){
                    case "0":{
                        switch($subtask_index){
                            case "0": $new_task = $dimat_ii_subtasks->CreateDivisionPairsSubtask($subtask_count);break;
                            case "1": $new_task = $dimat_ii_subtasks->CreatePrimeFactorizationSubtask($subtask_count); break;
                            case "2": $new_task = $dimat_ii_subtasks->CreateDivisorCountSubtask($subtask_count);break;
                            case "3": $new_task = $dimat_ii_subtasks->CreateCongruentNumbersSubtask($subtask_count);break;
                            default:break;
                        }
                    }break;
                    case "1":{
                        switch($subtask_index){
                            case "0": $new_task = $dimat_ii_subtasks->CreateCompleteResidueSystemSubtask($subtask_count);break;
                            case "1": $new_task = $dimat_ii_subtasks->CreateReducedResidueSystemSubtask($subtask_count); break;
                            case "2": $new_task = $dimat_ii_subtasks->CreateEulerPhiFunctionSubtask($subtask_count);break;
                            default:break;
                        }
                    }break;
                    case "2":{
                        switch($subtask_index){
                            case "0": $new_task = $dimat_ii_subtasks->CreateEucleidanAlgorithmSubtask($subtask_count);break;
                            case "1": ; break;
                            default:break;
                        }
                    }break;
                    case "3":{
                        switch($subtask_index){
                            case "0": $new_task = $dimat_ii_subtasks->CreateLinearCongruenceSubtask($subtask_count);break;
                            case "1": ; break;
                            default:break;
                        }
                    }break;
                    case "4":{
                        switch($subtask_index){
                            case "0": $new_task = $dimat_ii_subtasks->CreateDiophantineEquationSubtask($subtask_count);break;
                            case "1": $new_task = $dimat_ii_subtasks->CreateNumberDivisionWithConditionsSubtask($subtask_count); break;
                            default:break;
                        }
                    }break;
                    case "5":{

                    }break;
                    case "6":{

                    }break;
                    case "7":{

                    }break;
                    case "8":{

                    }break;
                    case "9":{

                    }break;
                    default:break;
                };
            }
            
            $task["task_description"] = $new_task["task_text"];
            $task["task_solution"] = $new_task["solution_text"];

            return $task;
        }
    }

?>