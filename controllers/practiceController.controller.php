<?php
    /**
     * This is a controller class which is responsible for showing the practice page.
     * 
     * This controller extends the MainContentController, from which it inherits members that are related to a logged in user.
     * If someone navigates to the practice page, although they are not logged in, then this controller redirects them to the login page.
     * If someone navigates to the practice page, however they are not a student, then this controller redirects them to the notifications page.
    */
    class PracticeController extends MainContentController{
        private $solution_counter;
        private $count_correct;
        private $dimat_helper_functions;
        private $solutions;
        private $real_solutions;
        
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
            $this->count_correct = 0;
            $this->solution_counter = 0;
            $this->dimat_helper_functions = new DimatHelperFunctions();
        }
        
        public function Practice(){
            if(isset($_SESSION["neptun_code"])){
                $this->SetMembers();
                if($this->GetApprovedStudentSubject() != ""){
                    $_SESSION["new_task"] = "new_task_given";
                    $_SESSION["answers"] = "";
                    $_SESSION["solution"] = "";
                    $_SESSION["definitions"] = "";
                    $_SESSION["task"] = "";
                    
                    if(isset($_SESSION["topic"]) && $_SESSION["topic"] != ""){
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
            if(isset($_SESSION["neptun_code"]) && $_SESSION["new_task"] != ""){
                if(count($_POST) != 0){
                    $this->SetMembers();
                    $this->solutions = array_values($_POST);
                    $practice_number = intval($_SESSION["topic"]) + 1;
                    $previous_point = floatval($this->GetPracticeResults()["practice_" . $practice_number]);
                    
                    $this->CheckSolution($this->GetApprovedStudentSubject(), $_SESSION["topic"]);
                    $update_point = $this->GetUpdatePoint();
                    $model = new PracticeModel();
                    $model->UpdatePracticeScore($_SESSION["neptun_code"], $practice_number, $previous_point, $update_point);
                    
                    $_SESSION["new_task"] = "";
                    header("Location: ./index.php?site=practiceShowAnswers&topic=" . $_SESSION["topic"]);
                }else{
                    $_SESSION["new_task"] = "";
                    header("Location: ./index.php?site=practiceShowAnswers");
                }
            }else{
                header("Location: ./index.php");
            }
        }

        private function GenerateTask($subject, $topic_number){
            if($subject == "i"){
                $dimat_i_tasks = new DimatiTasks($topic_number);
                $_SESSION["task"] = $dimat_i_tasks->GetTaskDescription();
                $_SESSION["solution"] = $dimat_i_tasks->GetTaskSolution();
                $_SESSION["definitions"] = $dimat_i_tasks->GetDefinitions();
            }else if($subject == "ii"){
                $dimat_i_tasks = new DimatiTasks($topic_number);
                $_SESSION["task"] = $dimat_i_tasks->GetTaskDescription();
                $_SESSION["solution"] = $dimat_i_tasks->GetTaskDescription();
                $_SESSION["definitions"] = $dimat_i_tasks->GetTaskDescription();
            }
        }

        private function CheckSolution($subject, $topic_number){
            $_SESSION["answers"] = [];
            $this->solution_counter = 0;
            $this->count_correct = 0;
            $this->real_solutions = $_SESSION["solution"];
            if($subject == "i"){
                switch($topic_number){
                    case "0":{
                        $this->CheckSetSolution();
                    };
                    break;
                    case "1":{
                        $this->CheckRelationSolution();
                    };
                    break;
                    case "2":{
                        $this->CheckCompositionSolution();
                    };
                    break;
                    case "3":{
                        $this->CheckFunctionSolution();
                    };
                    break;
                    case "4":{
                        $this->CheckComplexSolution();
                    };
                    break;
                    case "5":{
                        $this->CheckComplexTrigonometricSolution();
                    };
                    break;
                    case "6":{
                    };
                    break;
                    case "7":{
                    };
                    break;
                    case "8":{
                    };
                    break;
                    case "9":{
                    };
                    break;
                    default:break;
                }
            }else if($subject == "ii"){

            }
        }

        /**
         * 
         * This function returns the score with which the student's practice task point should be updated
         * 
         * @return float The score which should be added to the student's practice task point
        */
        public function GetUpdatePoint(){
            if($this->solution_counter != 0){
                return $this->count_correct/$this->solution_counter;
            }else{
                return 0;
            }
        }

        /**
         * 
         * This function compares the given answers with the solutions for Discrete mathematics I. subject 1st topic's tasks
         * 
         * There are 10 tasks for this topic
         * This function will extract the set elements from each input, then compare each set with the predetermined one
         * If the 2 sets are identical, then the student has a plus point
         * Finally, for each input we will determine the original answer (string), the cleaned answer (string), the real solution (string) and if the answer was correct
         * 
         * @return void
        */
        private function CheckSetSolution(){
            foreach($this->real_solutions as $index => $real_solution){
                $given_answer = $this->solutions[$this->solution_counter]??"";
                $given_solution = $this->ExtractSolutionFromInput($given_answer);
                $was_correct = false;
                if($this->CompareSets($given_solution, $real_solution)){
                    $this->count_correct += 1;
                    $was_correct = true;
                }

                $_SESSION["answers"]["answer_" . $this->solution_counter] = 
                    array(
                        "answer" => $given_answer, 
                        "answer_text" => $this->CreatePrintableSet($given_solution),
                        "solution_text" => $this->CreatePrintableSet($real_solution),
                        "correct" => $was_correct
                    );

                $this->solution_counter++;
            }
        }

        /**
         * 
         * This function compares the given answers with the solutions for Discrete mathematics I. subject 2nd topic's tasks
         * 
         * There are 6 tasks for this topic
         * This function will extract the relation elements from the third and fourth input, then compare each relation with the predetermined one
         * From the first, second, fifth and sixth input it will extract the set elements, then compare each set with the predetermined one
         * If the 2 sets, or 2 relations are identical, then the student has a plus point
         * Finally, for each input we will determine the original answer (string), the cleaned answer (string), the real solution (string) and if the answer was correct
         * 
         * @return void
        */
        private function CheckRelationSolution(){
            foreach($this->real_solutions as $index => $real_solution){
                $given_answer = $this->solutions[$this->solution_counter]??"";
                $given_solution = $this->ExtractSolutionFromInput($given_answer);
                $was_correct = false;
                if($this->solution_counter == 2 || $this->solution_counter == 3){
                    $first_relation = $this->CreateRelation($given_solution);
                    $answer_text = $this->CreatePrintableRelation($first_relation);
                    $solution_text = $this->CreatePrintableRelation($real_solution);
                    $was_correct = $this->CompareRelations($real_solution, $first_relation);         
                }else{
                    $was_correct = $this->CompareSets($given_solution, $real_solution);
                    $answer_text = $this->CreatePrintableSet($given_solution);
                    $solution_text = $this->CreatePrintableSet($real_solution);
                }

                if($was_correct){
                    $this->count_correct += 1;
                }

                $_SESSION["answers"]["answer_" . $this->solution_counter] = 
                    array(
                        "answer" => $given_answer,
                        "answer_text" => $answer_text,
                        "solution_text" => $solution_text,
                        "correct" => $was_correct
                    );
                $this->solution_counter++;
            }
        }

        /**
         * 
         * This function compares the given answers with the solutions for Discrete mathematics I. subject 3rd topic's tasks
         * 
         * There are 3 tasks for this topic
         * This function will extract the relation elements from the first and third inputs
         * ...
         * 
         * @return void
        */
        private function CheckCompositionSolution(){
            //Parsing the answers
            $real_solutions = array_values($this->real_solutions);

            $first_answer_relation = [];
            if(isset($this->solutions[0])){
                $values = $this->ExtractSolutionFromInput($this->solutions[0]);
                $first_answer_relation = $this->CreateRelation($values);
            }

            $second_answer = $this->ParseSelectSolutions(1,9);

            $third_answer_relation = [];
            if(isset($this->solutions[2])){
                $values = $this->ExtractSolutionFromInput($this->solutions[2]);
                $first_answer_relation = $this->CreateRelation($values);
            }

            //Checking the first answer
            $first_solution_relation =  $real_solutions[0]; 
            $was_correct = $this->CompareRelations($first_answer_relation, $first_solution_relation);
            if($was_correct){
                $this->count_correct += 1;
            }
            $_SESSION["answers"]["answer_0"] = 
                array(
                    "answer" => $this->solutions[0],
                    "anser_text" => $this->CreatePrintableRelation($first_answer_relation),
                    "solution_text" =>$this->CreatePrintableRelation($real_solutions[0]),
                    "correct" => $was_correct
                );
            $this->solution_counter++;

            //Checking the second answer
            $real_solution_1 = $real_solutions[1];
            $this->solution_counter++;
            if($this->CheckIfSelectsEqual($real_solution_1, $second_answer, 1)){
                $this->count_correct += 1;
            }
            
            //Checking the third answer
            $real_solution_2 = $real_solutions[2];
            $this->solution_counter++;
            $personal_set =  $real_solution_2[0];
            $characteristics =  $real_solution_2[1]; 
            $all_correct = true;
            foreach($characteristics as $characteristic => $is_true){
                $is_answer_true = "";
                switch($characteristic){
                    case "Reflexív":{
                        $is_answer_true = $this->dimat_helper_functions->IsReflexiveRelation($personal_set, $third_answer_relation);
                    };
                    break;
                    case "Irreflexív":{
                        $is_answer_true = $this->dimat_helper_functions->IsIrreflexiveRelation($personal_set, $third_answer_relation);
                    };
                    break;
                    case "Szimmetrikus":{
                        $is_answer_true = $this->dimat_helper_functions->IsSymmetricRelation($personal_set, $third_answer_relation);
                    };
                    break;
                    case "Antiszimmetrikus":{
                        $is_answer_true = $this->dimat_helper_functions->IsAntisymmetricRelation($personal_set, $third_answer_relation);
                    };
                    break;
                    case "Asszimetrikus":{
                        $is_answer_true = $this->dimat_helper_functions->IsAssymmetricRelation($personal_set, $third_answer_relation);
                    };
                    break;
                    case "Tranzitív":{
                        $is_answer_true = $this->dimat_helper_functions->IsTransitiveRelation($personal_set, $third_answer_relation);
                    };
                    break;
                    default:break;
                }
                if(is_bool($is_answer_true)){
                    if($is_true){
                        $all_correct = $all_correct && $is_answer_true === true;
                        $_SESSION["answers"]["answer_2_" . $characteristic] = array(
                                "correct" => $is_answer_true === true
                            );
                    }else{
                        $all_correct = $all_correct && $is_answer_true === false;
                        $_SESSION["answers"]["answer_2_" . $characteristic] = 
                            array(
                                "correct" => $is_answer_true === false
                            );
                    }
                }
            }

            if($all_correct = true){
                $this->count_correct += 1;
            }
        }

        private function CheckFunctionSolution(){
            //Parsing the answers;
            $first_answer = $this->ParseSelectSolutions(0,2);
            $second_answers = [$this->ParseSelectSolutions(3,5),$this->ParseSelectSolutions(6,8),$this->ParseSelectSolutions(9,11)];

            //Checking the first answers
            $real_solution_0 = $_SESSION["solution"]["solution_0"];
            $this->solution_counter++;
            if($this->CheckIfSelectsEqual($real_solution_0, $first_answer, 0)){
                $this->count_correct += 1;
            };

            $real_solution_1 = $_SESSION["solution"]["solution_1"];
            $this->solution_counter++;
            $answer_counter = 1;
            foreach($real_solution_1 as $index => $solution){
                if($this->CheckIfSelectsEqual($solution, $second_answers[$answer_counter-1], $answer_counter)){
                    $this->count_correct += 1;
                };
                $answer_counter++;
            }
        }

        private function CheckComplexSolution(){
            $this->solution_counter = 0;
            foreach($this->solutions as $index => $given_answer){
                $real_solution = $_SESSION["solution"]["solution_" . $this->solution_counter];
                $was_correct = false;
                if(is_numeric($real_solution) && is_numeric($given_answer)){
                    $was_correct = round($real_solution,2) == round($given_answer,2);
                }else if(is_array($real_solution)){
                    $parts = array_map("trim",explode(";",$given_answer));
                    if(count($real_solution) == 2 && is_array($real_solution[0])){
                        $first_complex_number = array_map("trim",explode(";",$parts[0]));
                        $second_complex_number = array_map("trim",explode(";",$parts[1]));
                        $first_complex_number_real = $real_solution[0];
                        $second_complex_number_real = $real_solution[1];
                        
                        $was_correct = round($first_complex_number_real[0],2) == round($first_complex_number[0],2)
                            && round($first_complex_number_real[1],2) == round($first_complex_number[1],2)
                            && round($second_complex_number_real[0],2) == round($second_complex_number[0],2)
                            && round($second_complex_number_real[1],2) == round($second_complex_number[1],2);
                    }else if(count($real_solution) == 2 && is_numeric($real_solution[0])){
                        $parts = array_map("trim",explode(",",$given_answer));
                        if(count($parts)==2 && is_numeric($parts[0]) && is_numeric($parts[1])){
                            $was_correct = round($real_solution[0],2) == round($parts[0],2)
                                && round($real_solution[1],2) == round($parts[1],2);
                        }
                    }
                }

                $_SESSION["answers"]["answer_" . $this->solution_counter] = 
                        array(
                            "answer" => $given_answer,
                            "solution" => $real_solution,
                            "correct" => $was_correct
                        );

                if($was_correct){
                    $this->count_correct++;
                }

                $this->solution_counter++;
            }
        }

        public function CheckComplexTrigonometricSolution(){
            $this->solution_counter = 0;
            foreach($this->solutions as $index => $given_answer){
                $real_solution = $_SESSION["solution"]["solution_" . $this->solution_counter]??"";
                $was_correct = false;

                if($real_solution != ""){
                    
                }

                $_SESSION["answers"]["answer_" . $this->solution_counter] = 
                        array(
                            "answer" => $given_answer,
                            "solution" => $real_solution,
                            "correct" => $was_correct
                        );

                if($was_correct){
                    $this->count_correct++;
                }

                $this->solution_counter++;
            }
        }

        private function CompareSets($first_set,$second_set){
            return count(array_merge(array_diff($first_set,$second_set), array_diff($second_set,$first_set))) == 0;
        }

        private function CompareRelations($first_relation, $second_relation){
            [$first_relation_first_components, $first_relation_second_components] = $this->dimat_helper_functions->GetRelationTwoArrayForm($first_relation);
            [$second_relation_first_components, $second_relation_second_components] = $this->dimat_helper_functions->GetRelationTwoArrayForm($second_relation);
            
            $first_equal = count(array_merge(array_diff($first_relation_first_components, $second_relation_first_components), array_diff($second_relation_first_components, $first_relation_first_components))) == 0;
            $second_equal = count(array_merge(array_diff($first_relation_second_components, $second_relation_second_components), array_diff($second_relation_second_components, $first_relation_second_components))) == 0;

            return $first_equal && $second_equal;
        }

        private function CheckIfSelectsEqual($real_solutions, $given_answers, $answer_counter){
            $all_correct = true;
            foreach($real_solutions as $index => $solution){
                if(isset($given_answers[$index])){
                    $answer = false;
                    switch($given_answers[$index]){
                        case "Igen":$answer=true;break;
                        case "Nem":$answer=false;break;
                        default:$answer="";break;
                    }
                    $all_correct = $all_correct && $solution === $answer;
                    $_SESSION["answers"]["answer_" . $answer_counter . "_" . $index] = 
                        array(
                            "answer" => $given_answers[$index],
                            "solution_text" => $solution,
                            "correct" => $solution === $answer
                        );
                }else{
                    $all_correct = false;
                    break;
                }
            }
            return $all_correct;
        }

        private function ParseSelectSolutions($select_start, $select_end){
            $answer = [];
            for($counter = $select_start; $counter < $select_end; $counter++){
                if(isset($this->solutions[$counter])){
                    array_push($answer, $this->solutions[$counter]);
                }
            }
            return $answer;
        }

        private function CreateRelation($values){
            $relation = [];
            for($pair_counter = 0; $pair_counter < count($values); $pair_counter += 2){
                if(isset($values[$pair_counter+1])){
                    array_push($relation, [$values[$pair_counter], $values[$pair_counter+1]]);
                }else{
                    array_push($relation, [$values[$pair_counter], "invalid_pair"]);
                }
            }

            return $relation;
        }

        private function ExtractSolutionFromInput($input){
            $input = preg_replace("/[^a-zA-Z0-9]/", "|", $input);
            $values = explode("|", $input);
            $return_values = [];
            foreach($values as $index => $value){
                if(ctype_alnum($value)){
                    if(!is_numeric($value) && strlen($value) == 1 || is_numeric($value)){
                        array_push($return_values, $value);
                    }
                }
            }
            return $return_values;
        }

        private function CreatePrintableSet($set){
            $printable_set = "{";
            $is_first_element = true;
            foreach($set as $index => $element){
                if($is_first_element){
                    $printable_set = $printable_set . $element;
                    $is_first_element = false;
                }else{
                    $printable_set = $printable_set . ", " . $element;
                }
            }
            $printable_set = $printable_set . "}";
            return $printable_set;
        }

        private function CreatePrintableRelation($relation){
            $printable_relation = "{";
            for($relation_counter = 0; $relation_counter < count($relation); $relation_counter++){
                if($relation_counter != 0){
                    $printable_relation = $printable_relation . ", ";
                }
                $printable_relation = $printable_relation . "(" . $relation[$relation_counter][0] . ", " . $relation[$relation_counter][1] . ")";
            }
            $printable_relation = $printable_relation . "}";
            return $printable_relation;
        }
    }

?>