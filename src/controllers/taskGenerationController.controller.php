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
            // Users, who are not logged in won't see this page, they will be redirected to the login page
            if(isset($_SESSION["neptun_code"])){
                $this->SetMembers();

                // Only teachers can see this page, others will be redirected to the notifications page
                if(     count($this->approved_teacher_groups) != 0){
                    $_SESSION["previous_controller"] = "TaskGenerationController";

                    // Setting the preview to default, if not set
                    if(!isset($_SESSION["preview"]) || !isset($_SESSION["exam_type"])){
                        $_SESSION["preview"] = [];
                    }
                    
                    include(ROOT_DIRECTORY . "/views/taskGenerationPage.view.php");
                }else{
                    header("Location: ./index.php?site=notifications");
                }
            }else{
                header("Location: ./index.php?site=login");
            }
        }

        /**
         * This method shows the page for printing the generated tasks
         * 
         * @return void
         */
        public function PrintPage(){
            if(isset($_SESSION["preview"]) && $_SESSION["preview"] !== []){
                $_SESSION["previous_controller"] = "TaskGenerationController";

                include(ROOT_DIRECTORY . "/views/printPage.view.php");
            }else{
                header("Location: ./index.php?site=notifications");
            }
        }

        /**
         * This method creates the preview of the page containing the printable form of the requested amount of subtasks for a task-subtask pair and also the solutions for these tasks.
         * 
         * The method also handles malicious user activities, like overwriting form html tags' names.
         * The method will create a small, or big test, or a set of tasks for the seminar based on the session's exam type parameter.
         * 
         * @return void
         */
        public function CreatePreview(){
            if(isset($_SESSION["neptun_code"])){
                $this->SetMembers();
                if(
                        isset($_SESSION["group"])
                    &&  isset($_SESSION["exam_type"])
                    &&  in_array($_SESSION["subject"], $this->approved_teacher_subjects)
                ){
                    $_SESSION["preview"] = $_POST;
                    $_SESSION["preview_tasks"] = [];
    
                    if($_SESSION["exam_type"] === "small"){ // Generate small test tasks based on the selected amount, selected main topic and subtopic index
                        $main_topic = $_POST["main_topic"]??"";
                        if(is_numeric($main_topic) && intval($main_topic) < 9 && 0 <= intval($main_topic)){
                            $subtopic_index = $_POST["main_topic_$main_topic" . "_subtopic"]??"";
                            if($subtopic_index === "" && isset( $_POST["main_topic_$main_topic" . "_subtopic_0"])){
                                $subtopic_index = "0";
                            }
                            $subtask_count = $_POST["task_quantity"]??"";

                            if(is_numeric($subtask_count) && is_numeric($subtopic_index)){
                                array_push($_SESSION["preview_tasks"], $this->GenerateTask($main_topic, $subtopic_index, $subtask_count));
                            }   
                        }
                    }else if($_SESSION["exam_type"] === "seminar"){ // Generate set of tasks for a seminar based on the selected main topic index, subtopic indices, and amounts/ subtopic
                        $main_topic = $_POST["main_topic"]??"";
                        if(is_numeric($main_topic) && intval($main_topic) < 9 && 0 <= intval($main_topic)){
                            foreach($_POST as $key => $value){
                                if(is_string($key) && is_numeric(strpos($key, "main_topic_$main_topic" . "_subtopic_")) && !is_numeric(strpos($key, "_task_quantity"))){
                                    $subtopic_index = explode("main_topic_$main_topic" . "_subtopic_",$key)[1]??"";
                                    if($subtopic_index === "" && isset($_POST["main_topic_$main_topic" . "_subtopic_0"])){
                                        $subtopic_index = "0";
                                    }
                                    $subtask_count = $_POST["main_topic_$main_topic" . "_subtopic_" . $subtopic_index . "_task_quantity"]??"";

                                    if(is_numeric($subtask_count) && is_numeric($subtopic_index)){
                                        array_push($_SESSION["preview_tasks"], $this->GenerateTask($main_topic, $subtopic_index, $subtask_count));
                                    }
                                }
                            }
                        }                        
                    }else if($_SESSION["exam_type"] === "big"){ // Generate set of tasks for a big test based on the selected main topic - subtopic indeices pairs, and overall amounts
                        $subtask_count = $_POST["task_quantity"]??4;

                        foreach($_POST as $outer_key => $value){
                            if(is_string($outer_key) && is_numeric(strpos($outer_key, "main_topic_"))){
                                $main_topic = explode("main_topic_", $outer_key)[1]??"";
                                foreach($_POST as $inner_key => $value){
                                    if(is_string($inner_key) && is_numeric(strpos($inner_key, "main_topic_$main_topic" . "_subtopic_"))){
                                        $subtopic_index = explode("main_topic_$main_topic" . "_subtopic_",$inner_key)[1]??"";
                                        
                                        if(is_numeric($subtask_count) && is_numeric($subtopic_index)){
                                            array_push($_SESSION["preview_tasks"], $this->GenerateTask($main_topic, $subtopic_index, $subtask_count));
                                        }
                                    }
                                }
                            }
                        }
                    }
    
                    $subject = $_SESSION["subject"];
                    $exam_type = $_SESSION["exam_type"];
                    header("Location: ./index.php?site=taskGeneration&" . "subject=$subject&" . "examType=$exam_type");
                }else{
                    header("Location: ./index.php?site=notifications");
                }
            }else{
                header("Location: ./index.php?site=login");
            }
        }

        /**
         * This method creates the given number of tasks for a task-subtask pair.
         * 
         * The task generation depends on the current subject and then the task-subtask pair.
         * 
         * @param string $main_task_index The index of the selected main task.
         * @param string $subtask_index The index of the selected subtask.
         * @param string $subtask_count The number of tasks to be generated.
         * 
         * @return array Returns an associative array containing the tasks' descriptions and printable solutions. These variables contain html tags.
         */
        private function GenerateTask($main_task_index, $subtask_index, $subtask_count){
            $task = array("task_descriptions" => "", "task_solutions" => "");
            
            if($_SESSION["subject"] == "i"){
                $dimat_subtasks = new DimatiSubtaskGenerator();
            }else{
                $dimat_subtasks = new DimatiiSubtaskGenerator();
            }

            // The subtask count must be smaller than 20
            if($subtask_count > 20){
                $subtask_count = 20;
            }

            $subtask = $dimat_subtasks->CreateSubtask($main_task_index, $subtask_index, $subtask_count);
            $task["descriptions"] = $subtask["descriptions"];
            $task["printable_solutions"] = $subtask["printable_solutions"];

            return $task;
        }
    }

?>