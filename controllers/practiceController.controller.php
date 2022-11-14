<?php
    /**
     * This is a controller class which is responsible for showing the practice page.
     * 
     * This controller extends the MainContentController, from which it inherits members that are related to a logged in user.
     * If someone navigates to the practice page, although they are not logged in, then this controller redirects them to the login page.
     * If someone navigates to the practice page, however they are not a student, then this controller redirects them to the notifications page.
    */
    class PracticeController extends MainContentController{
        private $task_evaluator;
        private $practice_model;

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
            if(isset($_SESSION["neptun_code"])){
                $this->SetMembers();
                if($this->approved_student_subject != ""){
                    $_SESSION["is_new_task"] = true;
                    
                    unset($_SESSION["answers"]);
                    unset($_SESSION["solution"]);
                    unset($_SESSION["definitions"]);
                    unset($_SESSION["task"]);
                    
                    if(isset($_SESSION["topic"]) 
                        && intval($_SESSION["topic"]) <= 8
                        && 0 <= intval($_SESSION["topic"])
                    ){
                        $this->GenerateTask($this->approved_student_subject, $_SESSION["topic"]);
                    }else{
                        header("Location: ./index.php?site=notifications");
                    }
                    
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
            if(isset($_SESSION["neptun_code"])){
                $this->SetMembers();
                if($this->approved_student_subject != ""){
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
                    $_SESSION["is_new_task"] = false;
                    if(count($_POST) != 0){
                        $this->SetMembers();
                        
                        $practice_number = intval($_SESSION["topic"]) + 1;
                        $practice_points = $this->GetPracticeResults($_SESSION["neptun_code"]);
                        $previous_point = floatval($practice_points["practice_task_" . $practice_number]??0);
                        if($this->approved_student_subject === "i"){
                            $task_evaluator = new DimatiTaskEvaluator($_POST);
                        }else if($this->approved_student_subject === "ii"){
                            $task_evaluator = new DimatiiTaskEvaluator($_POST);
                        }else{
                            header("Location: ./index.php?site=practiceShowAnswers");
                        }
                        $task_evaluator->CheckSolution($_SESSION["topic"]);
                        $update_point = round($task_evaluator->GetUpdatePoint(),2);
                        $this->practice_model->UpdatePracticeScore($_SESSION["neptun_code"], $practice_number, $previous_point, $update_point);
    
                        header("Location: ./index.php?site=practiceShowAnswers&topic=" . $_SESSION["topic"]);
                    }else{
                        header("Location: ./index.php?site=practiceShowAnswers");
                    }
                }else{
                    header("Location: ./index.php?site=notifications");
                }
            }else{
                header("Location: ./index.php");
            }
        }

        /**
         *
         * This method generates tasks for the logged in student to practice.
         * 
         * The task generation depends on the subject's id and the topic's number.
         * 
         * @return void
        */
        private function GenerateTask($subject, $topic_number){
            if($subject == "i"){
                $dimat_i_tasks = new DimatiTasks($topic_number);
                $dimat_i_tasks->PracticePageTaskGeneration();
                $_SESSION["task"] = $dimat_i_tasks->GetTaskDescriptions();
                $_SESSION["solution"] = $dimat_i_tasks->GetTaskSolutions();
                $_SESSION["definitions"] = $dimat_i_tasks->GetDefinitions();
            }else if($subject == "ii"){
                $dimat_ii_tasks = new DimatiiTasks($topic_number);
                $dimat_ii_tasks->PracticePageTaskGeneration();
                $_SESSION["task"] = $dimat_ii_tasks->GetTaskDescriptions();
                $_SESSION["solution"] = $dimat_ii_tasks->GetTaskSolutions();
                $_SESSION["definitions"] = $dimat_ii_tasks->GetDefinitions();
                $_SESSION["solution_texts"] = $dimat_ii_tasks->GetSolutionTexts();
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
            $practice_results = $this->practice_model->GetPracticeResults($neptun_code)[0]??[];
            foreach($practice_results as $key => $value){
                if(is_int(strpos($key, "practice_task"))){
                    $practice_points[$key] = $value;
                }
            } 
            return $practice_points;
        }
    }

?>