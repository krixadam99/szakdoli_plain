<?php
    /**
     * This is a controller class which is responsible for showing the practice page.
     * 
     * This controller extends the MainContentController, from which it inherits members that are related to a logged in user.
     * If someone navigates to the practice page, although they are not logged in, then this controller redirects them to the login page.
     * If someone navigates to the practice page, however they are not a student, then this controller redirects them to the notifications page.
    */
    class PracticeController extends MainContentController{
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
        }
        
        public function Practice(){
            if(isset($_SESSION["neptun_code"])){
                $this->SetMembers();
                if($this->GetApprovedStudentSubject() != ""){
                    $_SESSION["is_new_task"] = true;
                    $_SESSION["answers"] = "";
                    $_SESSION["solution"] = "";
                    $_SESSION["definitions"] = "";
                    $_SESSION["task"] = "";
                    
                    if(isset($_SESSION["topic"]) 
                        && intval($_SESSION["topic"]) <= 9
                        && 0 <= intval($_SESSION["topic"])
                    ){
                        $this->GenerateTask($this->GetApprovedStudentSubject(), $_SESSION["topic"]);
                    }
                    
                    include(ROOT_DIRECTORY . "/views/practicePage.view.php");
                }else{
                    header("Location: ./index.php?site=notifications");
                }
            }else{
                header("Location: ./index.php?site=login");
            }
        }

        
        public function PracticeAnswers(){
            if(isset($_SESSION["neptun_code"])){
                $this->SetMembers();
                if($this->GetApprovedStudentSubject() != ""){
                    include(ROOT_DIRECTORY . "/views/practicePage.view.php");
                }else{
                    header("Location: ./index.php?site=notifications");
                }
            }else{
                header("Location: ./index.php");
            }
        }

        public function HandInSolution(){
            if(isset($_SESSION["neptun_code"]) && $_SESSION["is_new_task"]){
                $_SESSION["is_new_task"] = false;
                if(count($_POST) != 0){
                    $this->SetMembers();
                    $practice_number = intval($_SESSION["topic"]) + 1;
                    $previous_point = floatval($this->GetPracticeResults()["practice_" . $practice_number]);

                    if($this->GetApprovedStudentSubject() === "i"){
                        $task_evaluator = new DimatiTaskEvaluator(array_values($_POST));
                    }else if($this->GetApprovedStudentSubject() === "ii"){
                        $task_evaluator = new DimatiiTaskEvaluator($_POST);
                    }else{
                        header("Location: ./index.php?site=practiceShowAnswers");
                    }

                    $task_evaluator->CheckSolution($_SESSION["topic"]);
                    $update_point = round($task_evaluator->GetUpdatePoint(),2);
                    $model = new PracticeModel();
                    $model->UpdatePracticeScore($_SESSION["neptun_code"], $practice_number, $previous_point, $update_point);

                    header("Location: ./index.php?site=practiceShowAnswers&topic=" . $_SESSION["topic"]);
                }else{
                    header("Location: ./index.php?site=practiceShowAnswers");
                }
            }else{
                header("Location: ./index.php");
            }
        }

        private function GenerateTask($subject, $topic_number){
            if($subject == "i"){
                $dimat_i_tasks = new DimatiTasks($topic_number);
                $dimat_i_tasks->PracticePageTaskGeneration();
                $_SESSION["task"] = $dimat_i_tasks->GetTaskDescription();
                $_SESSION["solution"] = $dimat_i_tasks->GetTaskSolutions();
                $_SESSION["definitions"] = $dimat_i_tasks->GetDefinitions();
            }else if($subject == "ii"){
                $dimat_ii_tasks = new DimatiiTasks($topic_number);
                $dimat_ii_tasks->PracticePageTaskGeneration();
                $_SESSION["task"] = $dimat_ii_tasks->GetTaskDescription();
                $_SESSION["solution"] = $dimat_ii_tasks->GetTaskSolutions();
                $_SESSION["definitions"] = $dimat_ii_tasks->GetDefinitions();
            }
        }
    }

?>