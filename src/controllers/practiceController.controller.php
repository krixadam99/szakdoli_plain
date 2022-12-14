<?php
    /**
     * This is a controller class which is responsible for showing the practice page.
     * 
     * This controller extends the MainContentController, from which it inherits members that are related to a logged in user.
     * If someone navigates to the practice page, although they are not logged in, then this controller redirects them to the login page.
     * If someone navigates to the practice page, however they are not a student, then this controller redirects them to the notifications page.
    */
    class PracticeController extends MainContentController{
        private $practice_model;
        private $task_evaluator;
        private $dimat_task;

        /**
         * 
         * The contructor of the PracticeController class.
         * 
         * It will call the MainContentController class's constructor with which it will assign default values to the inherited members.
         * 
         * @return void
         */
        public function __construct(){
            parent::__construct();
            $this->practice_model = new PracticeModel();
        }
        
        /**
         *
         * This method shows the practice page.
         * 
         * It also sets the members, which it inherited from the MainContentController, and are related to a logged in user.
         * If a client types the page name in the searchbar of the browser, but not logged in, then they will be redirected to the login page.
         * If a logged in user navigated to the practice page, but isn't a student, that is, has no approved subject to practice, then they will be redirected to the notifications page.
         * Session variables for answers, solution, definitions and task will be unset here, and if the topic number is correct (between 0 and 8 inclusively), then will be set by the GenerateTask method.
         * 
         * @return void
        */
        public function Practice(){
            // Users, who are not logged in won't see this page, they will be redirected to the login page
            if(isset($_SESSION["neptun_code"])){
                $this->SetMembers();

                // If the user is not a student, then the method redirects them to the notifications page
                if($this->approved_student_subject != ""){
                    $_SESSION["previous_controller"] = "PracticeController";
                    $_SESSION["is_new_task"] = true;
                    
                    unset($_SESSION["answers"]);
                    unset($_SESSION["solution"]);
                    unset($_SESSION["definitions"]);
                    unset($_SESSION["task"]);
                    
                    // The practice task's topic must be an integer and between 0 and 8
                    if(    isset($_SESSION["topic"]) 
                        && intval($_SESSION["topic"]) <= 8
                        && 0 <= intval($_SESSION["topic"])
                    ){
                        $this->GenerateTask($this->approved_student_subject, $_SESSION["topic"]);
                    }else{
                        header("Location: ./index.php?site=notifications");
                    }
                    
                    // Fetching the practice task points of the user
                    $practice_results = $this->GetPracticeResults($_SESSION["neptun_code"]);

                    include(ROOT_DIRECTORY . "/views/practicePage.view.php");
                }else{
                    header("Location: ./index.php?site=notifications");
                }
            }else{
                header("Location: ./index.php?site=login");
            }
        }

        /**
         *
         * This method shows the answers for the sent task page.
         * 
         * It also sets the members, which it inherited from the MainContentController, and are related to a logged in user.
         * If a client types the page name in the searchbar of the browser, but not logged in, then they will be redirected to the login page.
         * If a logged in user navigated to the practice page, but isn't a student, that is, has no approved subject to practice, then they will be redirected to the notifications page.
         * 
         * @return void
        */
        public function PracticeAnswers(){
            // Users, who are not logged in won't see this page, they will be redirected to the login page
            if(isset($_SESSION["neptun_code"])){
                $this->SetMembers();

                // If the user is not a student, then the method redirects them to the notifications page
                if($this->approved_student_subject != ""){
                    $_SESSION["previous_controller"] = "PracticeController";
                    
                    // Fetching the practice task points of the user
                    $practice_results = $this->GetPracticeResults($_SESSION["neptun_code"]);
                    
                    include(ROOT_DIRECTORY . "/views/practicePage.view.php");
                }else{
                    header("Location: ./index.php?site=notifications");
                }
            }else{
                header("Location: ./index.php");
            }
        }

        /**
         *
         * This method evaluates the student's answers for the generated tasks and then updates the database with the correct point. 
         *
         * @return void
        */
        public function HandInSolution(){
            if(isset($_SESSION["neptun_code"])){
                if(isset($_SESSION["is_new_task"]) && $_SESSION["is_new_task"]){
                    // The task is not a new one
                    $_SESSION["is_new_task"] = false;
                    if(count($_POST) != 0){
                        $illegal_format_for_input = false;
                        foreach($_POST as $key => $value){
                            if(!is_string($value)){
                                $illegal_format_for_input = true;
                                break;
                            }
                        }

                        if(!$illegal_format_for_input){
                            $this->SetMembers();
                        
                            // Evaluating the user's answers, and updating the actual practice task point
                            $practice_number = intval($_SESSION["topic"]) + 1;
                            $practice_points = $this->GetPracticeResults($_SESSION["neptun_code"]);
                            $previous_point = floatval($practice_points["practice_task_" . $practice_number]??0);
                            if($this->approved_student_subject === "i"){
                                $this->task_evaluator = new DimatiTaskEvaluator($_POST);
                            }else if($this->approved_student_subject === "ii"){
                                $this->task_evaluator = new DimatiiTaskEvaluator($_POST);
                            }else{
                                header("Location: ./index.php?site=practiceShowAnswers");
                            }
                            $this->task_evaluator->CheckSolution($_SESSION["topic"]);
                            $update_point = round($this->task_evaluator->GetUpdatePoint(),2);
                            $this->practice_model->UpdatePracticeScore($_SESSION["neptun_code"], $practice_number, $previous_point, $update_point);
        
                            header("Location: ./index.php?site=practiceShowAnswers&topic=" . $_SESSION["topic"]);
                        }else{
                            header("Location: ./index.php?site=practiceShowAnswers");
                        }
                    }else{
                        header("Location: ./index.php?site=practiceShowAnswers");
                    }
                }else{
                    header("Location: ./index.php?site=notifications");
                }
            }else{
                header("Location: ./index.php?site=login");
            }
        }

        /**
         *
         * This method generates tasks for the logged in student to practice.
         * 
         * The task generation depends on the subject's id and the topic's number.
         * 
         * @param string $subject The id of the subject. Can be either "i", or "ii".
         * @param string $topic_number The chosen topic's number. It is between 0 and 8 (inclusively).
         * 
         * @return void
        */
        private function GenerateTask($subject, $topic_number){
            if($subject == "i"){ // The user is a student of Discrete mathematics I. 
                $this->dimat_task = new DimatiTasks($topic_number);
                $this->dimat_task->PracticePageTaskGeneration();

                $_SESSION["task"] = $this->dimat_task->GetTaskDescriptions();
                $_SESSION["solution"] = $this->dimat_task->GetTaskSolutions();
            }else if($subject == "ii"){ // The user is a student of Discrete mathematics II. 
                $this->dimat_task = new DimatiiTasks($topic_number);
                $this->dimat_task->PracticePageTaskGeneration();

                $_SESSION["task"] = $this->dimat_task->GetTaskDescriptions();
                $_SESSION["solution"] = $this->dimat_task->GetTaskSolutions();
                $_SESSION["solution_texts"] = $this->dimat_task->GetSolutionTexts();
            }
        }

        /**
         * This private method returns the practice points for the user based on the database.
         *
         * @param string neptun_code The neptun code of the user.
         * 
         * @return array Returns an array containing the user's practice points for his actual subject group.
        */
        private function GetPracticeResults($neptun_code){
            $practice_points = [];
            $practice_results = $this->practice_model->GetPracticeResults($neptun_code);
            foreach($practice_results as $task_counter => $row){
                $practice_points[$row["task_type"]] = $row["task_point"];
            }     
            return $practice_points;
        }
    }

?>