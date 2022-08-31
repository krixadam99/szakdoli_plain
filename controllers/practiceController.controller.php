<?php
    
    class PracticeController extends MainContentController{
        private $solution_counter;
        private $count_correct;
        private $dimat_helper_functions;
        private $solutions;
        
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
         * Function that compares the given answers with the solutions for Discrete mathematics I. subject 1st topic's tasks
         * 
         * There are 10 tasks for this topic
         * This function will extract the set elements from each input, then compare each set with the predetermined one
         * If the 2 sets are identical, then the student has a plus point
         * Finally, for each input we will determine the original answer (string), the cleaned answer (string), the real solution (string) and if the answer was correct
         * 
         * @return void
        */
        private function CheckSetSolution(){
            $real_solutions = $_SESSION["solution"];
            foreach($real_solutions as $index => $real_solution){
                $given_answer = $this->solutions[$this->solution_counter]??"";
                $given_solutions = $this->ExtractSolutionFromInput($given_answer);
                $real_solution = $_SESSION["solution"]["solution_" . $this->solution_counter];

                $was_correct = false;
                if($this->CompareSets($given_solutions, $real_solution)){
                    $this->count_correct += 1;
                    $was_correct = true;
                }

                $_SESSION["answers"]["answer_" . $this->solution_counter] = 
                    array(
                        "answer" => $given_answer, 
                        "answer_text" => $this->CreatePrintableSet($given_solutions),
                        "solution_text" => $this->CreatePrintableSet($real_solution),
                        "correct" => $was_correct
                    );

                $this->solution_counter++;
            }
        }

        /**
         * 
         * Function that compares the given answers with the solutions for Discrete mathematics I. subject 2nd topic's tasks
         * 
         * There are 10 tasks for this topic
         * This function will extract the set elements from each input, then compare each set with the predetermined one
         * If the 2 sets are identical, then the student has a plus point
         * Finally, for each input we will determine the original answer (string), the cleaned answer (string), the real solution (string) and if the answer was correct
         * 
         * @return void
        */
        private function CheckRelationSolution(){
            foreach($this->solutions as $index => $value){
                $was_correct = false;
                if($this->solution_counter == 2 || $this->solution_counter == 3){
                    $first_relation = $this->ParseRelation($value, false);
                    $second_relation = $_SESSION["solution"]["solution_" . $this->solution_counter];
                    $was_correct = $this->CompareRelations($first_relation, $second_relation);         
                }else{
                    $given_solution = array_map("trim", explode(",", $value));
                    $real_solution = $_SESSION["solution"]["solution_" . $this->solution_counter];
                    $was_correct = $this->CompareRelations($given_solution, $real_solution);
                }

                if($was_correct){
                    $this->count_correct += 1;
                }

                $_SESSION["answers"]["answer_" . $this->solution_counter] = 
                    array(
                        "answer" => $value,
                        "solution" => $_SESSION["solution"]["solution_" . $this->solution_counter],
                        "correct" => $was_correct
                    );
                $this->solution_counter++;
            }
        }

        private function CheckCompositionSolution(){
            //Parsing the answers
            $first_answer_relation = $this->ParseRelation($this->solutions["solution_0"], false);
            $second_answer = $this->ParseSelectSolutions(1);
            $third_answer_relation = $this->ParseRelation($this->solutions["solution_2"], false);

            //Checking the first answer
            $first_solution_relation =  $_SESSION["solution"]["solution_0"]; 
            $was_correct = $this->CompareRelations($first_answer_relation, $first_solution_relation);
            if($was_correct){
                $this->count_correct += 1;
            }
            $_SESSION["answers"]["answer_0"] = 
                array(
                    "answer" => $this->solutions["solution_0"],
                    "solution" => $first_solution_relation,
                    "correct" => $was_correct
                );
            $this->solution_counter++;

            //Checking the second answer
            $real_solution_1 = $_SESSION["solution"]["solution_1"];
            $this->solution_counter++;
            if($this->CheckIfSelectsEqual($real_solution_1, $second_answer, 1)){
                $this->count_correct += 1;
            }
            
            //Checking the third answer
            $real_solution_2 = $_SESSION["solution"]["solution_2"];
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
            $first_answer = $this->ParseSelectSolutions(0);
            $second_answers = [$this->ParseSelectSolutions(1),$this->ParseSelectSolutions(2),$this->ParseSelectSolutions(3)];

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
            
            $first_equal = count(array_merge(array_diff($first_relation_first_components,$second_relation_first_components), array_diff($second_relation_first_components,$first_relation_first_components))) == 0;
            $second_equal = count(array_merge(array_diff($first_relation_second_components,$second_relation_second_components), array_diff($second_relation_second_components,$first_relation_second_components))) == 0;

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
                            "solution" => $solution,
                            "correct" => $solution === $answer
                        );
                }else{
                    $all_correct = false;
                    break;
                }
            }
            return $all_correct;
        }

        private function ParseSelectSolutions($solution_number){
            $answer = [];
            foreach($this->solutions as $index => $value){
                if(is_int(strpos($index, "solution_" . $solution_number))){
                    array_push($answer, $value);
                }
            }
            return $answer;
        }

        private function ParseRelation($values, $with_domain_image = true){
            $pairs = explode("(", $values);
            $first_array = [];
            $second_array = [];
            $third_array = [];
            foreach($pairs as $pair_counter => $pair){
                if($pair_counter > 0){
                    $pair = str_replace("),", "", $pair);
                    $pair = str_replace(")", "", $pair);
                    $pair = str_replace("}", "", $pair);
                    $pair = str_replace("{", "", $pair);
                    $pair = str_replace(";", ",", $pair);
                    $pair = str_replace(".", ",", $pair);
                    $pair = array_map("trim", explode(",",$pair));

                    if($with_domain_image){
                        array_push($first_array, $pair[0]);
                        if(count($pair)>1){
                            array_push($second_array, $pair[1]);
                        }else{
                            array_push($second_array, []);
                        }
                    }else{
                        if(count($pair)>1){
                            array_push($third_array, [$pair[0], $pair[1]]);
                        }else{
                            array_push($first_array, [$pair[0], ""]);
                        }
                    }
                }
            }

            if($with_domain_image){
                return [$first_array, $second_array];
            }else{
                return $third_array;
            }
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
    }

?>