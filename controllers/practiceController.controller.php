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
         * There are 10 main tasks for this topic
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
         * There are 6 main tasks for this topic
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
         * This function compares the given answers with the solutions for Discrete mathematics I. subject 3rd topic's tasks.
         * 
         * There are 3 main tasks for this topic.
         * This function will extract the relation elements from the first and third inputs.
         * It will extract the select values from the select elements
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
            // TODO...
            $real_solution_2 = $real_solutions[2];
            $this->solution_counter++;
            $personal_set =  $real_solution_2[0];
            $characteristics =  $real_solution_2[1]; 
            $all_correct = true;
            foreach($characteristics as $characteristic => $is_true){
                $is_answer_true = false;
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

        /**
         * 
         * This function compares the given answers with the solutions for Discrete mathematics I. subject 4th topic's tasks.
         * 
         * There are 2 main tasks for this topic.
         * 
         * @return void
        */
        private function CheckFunctionSolution(){
            //Parsing the answers;
            $real_solutions = array_values($this->real_solutions);

            $first_answer = $this->ParseSelectSolutions(0,2);
            $second_answers = [$this->ParseSelectSolutions(3,5),$this->ParseSelectSolutions(6,8),$this->ParseSelectSolutions(9,11)];

            //Checking the first answers
            $real_solution_0 = $real_solutions[0];
            $this->solution_counter++;
            if($this->CheckIfSelectsEqual($real_solution_0, $first_answer, 0)){
                $this->count_correct += 1;
            };

            $real_solution_1 = $real_solutions[1];
            $this->solution_counter++;
            $answer_counter = 1;
            foreach($real_solution_1 as $index => $solution){
                if($this->CheckIfSelectsEqual($solution, $second_answers[$answer_counter-1], $answer_counter)){
                    $this->count_correct += 1;
                };
                $answer_counter++;
            }
        }

        /**
         * 
         * This function compares the given answers with the solutions for Discrete mathematics I. subject 5th topic's tasks.
         * 
         * There are 3 main tasks for this topic.
         * 
         * @return void
        */
        private function CheckComplexSolution(){
            $this->solution_counter = 0;
            foreach($this->real_solutions as $index => $real_solution){
                $given_answer = $this->solutions[$this->solution_counter]??"";
                $given_solution = $this->ExtractSolutionFromInput($given_answer);
                $was_correct = false;
                if(is_numeric($real_solution)){ // Numeric solution
                    if(isset($given_solution[0]) && is_numeric($given_solution[0])){
                        $answer_text = $given_solution[0];
                        $was_correct = round($real_solution,2) == round($given_solution[0],2);
                    }else{
                        $answer_text = "";
                    }
                    $solution_text = $real_solution;
                }else if(is_array($real_solution)){
                    if(count($real_solution) == 2){
                        if(!is_array($real_solution[0])){ // 2nd task, complex numbers as ordered pairs
                            $real_part = $real_solution[0];
                            $imaginary_part = $real_solution[1];

                            if(isset($given_solution[0])){
                                $was_correct = round($real_part,2) == round($given_solution[0],2);
                            }
                            if(isset($given_solution[1])){
                                $was_correct = $was_correct && round($imaginary_part,2) == round($given_solution[1],2);
                            }

                            $solution_text = $this->CreatePrintableComplexNumber($real_solution, false);
                            $answer_text = $this->CreatePrintableComplexNumber($given_solution, false);
                        }else{ // 3rd task, discriminator was not 0
                            $solution_text = $this->CreatePrintableComplexNumber($real_solution[0], false);
                            $solution_text = $solution_text . ", " . $this->CreatePrintableComplexNumber($real_solution[1], false);
                        }
                    }else{ // 3rd task, discriminator was 0
                        $real_solution = $real_solution[0][0];
                        $solution_text = $real_solution;

                    }
                }

                $_SESSION["answers"]["answer_" . $this->solution_counter] = 
                        array(
                            "answer" => $given_answer,
                            "answer_text" => $answer_text,
                            "solution_text" => $solution_text,
                            "correct" => $was_correct
                        );

                if($was_correct){
                    $this->count_correct++;
                }

                $this->solution_counter++;
            }
        }

        private function CheckComplexTrigonometricSolution(){
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

        /**
         * 
         * This method compares two sets and returns whether they are the same, or not.
         * 
         * @param array $first_set The first set.
         * @param array $second_set The second set.
         * 
         * @return bool Returns whether the two sets are the same, i.e., contains the same elements with multiplicity, or not.
        */
        private function CompareSets($first_set,$second_set){
            return count(array_merge(array_diff($first_set,$second_set), array_diff($second_set,$first_set))) == 0;
        }

        /**
         * 
         * This method compares two relations and returns whether they are the same, or not.
         * 
         * Firstly, the relations must be converted into an array form consisting of two array, where the ordered pairs' first elements are in the first, and the second elements are in the second array.
         * The first arrays, and then the second arrays will be compared to each other.
         * 
         * @param array $first_relation The first relation consisting elements of the form [element, element].
         * @param array $second_relation The second relation consisting elements of the form [element, element].
         * 
         * @return bool Returns whether the two relations are the same, i.e., contains the same ordered pairs with multiplicity, or not.
        */
        private function CompareRelations($first_relation, $second_relation){
            [$first_relation_first_components, $first_relation_second_components] = $this->dimat_helper_functions->GetRelationTwoArrayForm($first_relation);
            [$second_relation_first_components, $second_relation_second_components] = $this->dimat_helper_functions->GetRelationTwoArrayForm($second_relation);
            
            $first_equal = $this->CompareSets($first_relation_first_components, $second_relation_first_components);
            $second_equal = $this->CompareSets($first_relation_second_components, $second_relation_second_components);

            return $first_equal && $second_equal;
        }

        /**
         * 
         * This method compares the values of two select elements.
         * 
         * @param array $real_solution The real solutions for the subtask.
         * @param array $given_answer The given answers for the subtask.
         * @param array $answer_counter If the selects are under the same subtask, then this determines the subtask's number.
         * 
         * @return bool Returns whether the given answers and real solutions are all the same, or not.
        */
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
                            "anser_text" => $given_answers[$index],
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

        /**
         * 
         * This method parses the values of HTML select elements.
         * 
         * It will take the solution array containing all of the user's answers, and return the part of it determined by the starting and ending index (inclusicely).
         * 
         * @param int $select_start The index of the first HTML select element.
         * @param int $select_end The index of the last HTML select element.
         * 
         * @return array Returns an indexed array containing the values of the HTML select elements.
        */
        private function ParseSelectSolutions($select_start, $select_end){
            $answer = [];
            for($counter = $select_start; $counter <= $select_end; $counter++){
                if(isset($this->solutions[$counter])){
                    array_push($answer, $this->solutions[$counter]);
                }
            }
            return $answer;
        }

        /**
         * 
         * This method converts a plain array of elements into an array consisting of ordered pairs, i.e., elements of form [element, element].
         * 
         * The values will be iterated through with double step.
         * 
         * @param array $values An indexed array of elements.
         * 
         * @return array Returns an indexed array containing ordered pairs.
        */
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

        /**
         * 
         * This method extracts the values from the student's answer.
         * 
         * Firstly, each non alphanumeric characters will be replaced by the '|' character.
         * Then the string will be split by the '|' character.
         * Finally, only the numbers and letters from the English alphabet will be kept in this array.
         * 
         * @param string $input The original content of the input element.
         * 
         * @return array Returns an indexed array with the extracted elements.
        */
        private function ExtractSolutionFromInput($input){
            $input = preg_replace("/[^a-zA-Z0-9-]/", "|", $input);
            $values = explode("|", $input);
            $return_values = [];
            foreach($values as $index => $value){
                if(ctype_alnum($value)){
                    if(!is_numeric($value) && strlen($value) == 1 || is_numeric($value)){
                        array_push($return_values, $value);
                    }
                }else{
                    if(is_int(strpos($value,"-"))){//It was negative
                        if(is_numeric(str_replace("-", "", $value))){
                            array_push($return_values, "-" . str_replace("-", "", $value));
                        }
                    }
                }
            }
            return $return_values;
        }

        /**
         * 
         * This method creates a printable version of the given set.
         * 
         * @param array $set The set which the function will convert into a string.
         * 
         * @return string Returns a printable version of the given set.
        */
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

        /**
         * 
         * This method creates a printable version of the given relation.
         * 
         * @param array $relation The relation which the function will convert into a string, the relation must consist ordered pairs of the form [element, element].
         * 
         * @return string Returns a printable version of the given relation.
        */
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

        /**
         * 
         * This method creates a printable version of the complex number.
         * 
         * @param array $complex_numner The complex number which the function will convert into a string, the complex number either contains a real and imaginary part, or the length of the number and its argument.
         * @param bool $is_trigonometric This parameter determines whether the complex number is of trigonometric form, or not.
         * 
         * @return string Returns a printable version of the given complex number.
        */
        private function CreatePrintableComplexNumber($complex_number, $is_trigonometric = false){
            $printable_complex_number = "";
            if(!$is_trigonometric){
                if(isset($complex_number[0])){
                    $printable_complex_number = $printable_complex_number . $complex_number[0];
                }
                if(isset($complex_number[1])){
                    if($complex_number[1] > 0){
                        $printable_complex_number = $printable_complex_number . " + " . $complex_number[1] . "*i";
                    }else if($complex_number[1] < 0){
                        $printable_complex_number = $printable_complex_number . " - " . abs($complex_number[1]) . "*i";
                    }
                }
            }else{
                $printable_complex_number = $printable_complex_number . round($complex_number[0],2) . "*(cos(" . round($complex_number[1],2) . ") + i*sin(" . round($complex_number[1],2) . "))";
            }
            return $printable_complex_number;
        }
    }

?>