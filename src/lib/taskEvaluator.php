<?php
    /**
     * This is an abstract class, which represents the task evaluators.
     * 
     * Each task evaluator object contains a solution counter, correct answer members, topic number, subject id and the real solutions.
    */
    abstract class TaskEvaluator {
        protected $solution_counter;
        protected $correct_answer_counter;
        protected $topic_number;
        protected $subject_id;
        protected $real_solutions;
        protected $given_answers;

        /**
         * 
         * This method returns the number of subtasks per task.
         * 
         * @return int Returns a non-negative whole number, the number of subtasks per taks.
        */
        public function GetSolutionCounter(){ return $this->solution_counter; }

        /**
         * 
         * This method returns the number of correct answers per task.
         * 
         * @return int Returns a non-negative whole number, the number of correct answers per taks.
        */
        public function GetCorrectAnswerCounter(){ return $this->correct_answer_counter; }

        /**
         * 
         * This method returns the id of the actual topic.
         * 
         * @return int Returns a non-negative whole number. This is the id of the actual topic.
        */
        public function GetTopicNumber(){ return $this->topic_number; }

        /**
         * 
         * This method returns the id of the actual subject.
         * 
         * @return string Returns the actual subject's id which is a string that can either be "i", or "ii".
        */
        public function GetSubjectId(){ return $this->subject_id; }

        /**
         * 
         * This method returns the real solutions for the actual task.
         * 
         * @return array Returns an associative array containing the real solutions for the actual task.
        */
        public function GetRealSolutions(){ return $this->real_solutions; }

        /**
         * 
         * This method returns the given answers for the actual task.
         * 
         * @return array Returns an associative array containing the given answers for the actual task.
        */
        public function GetGivenAnswers(){ return $this->given_answers; }

        /**
         * 
         * This method assigns a new value to the solution counter.
         * 
         * @param int $solution_counter A non-negative whole value which will be assigned to the class's $solution_counter member.
         * 
         * @return void
        */
        public function SetSolutionCounter($solution_counter){ $this->solution_counter = $solution_counter; }
        
        /**
         * 
         * This method assigns a new value to the correct answers counter.
         * 
         * @param int $correct_answer_counter A non-negative whole value which will be assigned to the class's $correct_answer_counter member.
         * 
         * @return void
        */
        public function SetCorrectAnswerCounter($correct_answer_counter){ $this->correct_answer_counter = $correct_answer_counter; }

        /**
         * 
         * This method assigns a new value to the topic number member.
         * 
         * @param int $topic_number A non-negative whole value which will be assigned to the class's $topic_number member.
         * 
         * @return void
        */
        public function SetTopicNumber($topic_number){ $this->topic_number = $topic_number; }

        /**
         * 
         * This method assigns a new value to the subject id member.
         * 
         * @param string $subject_id A string value which will be assigned to the class's $subject_id member.
         * 
         * @return void
        */
        public function SetSubjectId($subject_id){ $this->subject_id = $subject_id; }

        /**
         * 
         * This method assigns a new value to the real solutions member.
         * 
         * @param array $real_solutions An array which will be assigned to the class's $real_solutions member.
         * 
         * @return void
        */
        public function SetRealSolutions($real_solutions){ $this->real_solutions = $real_solutions; }

        /**
         * 
         * This method assigns a new value to the given answers member.
         * 
         * @param array $given_answers An array which will be assigned to the class's $topic_number member.
         * 
         * @return void
        */
        public function SetGivenAnswers($given_answers){ $this->given_answers = $given_answers; }

        /**
         * This virtual method will use if-else statements to evaluate the user's given answers for the practice tasks' questions.
         * 
         * @param string $topic_number The number of the current topic.
         */
        protected abstract function CheckSolution($topic_number);

        /**
         * This protected method sets the session's answers parameter.
         * 
         * @param string $id The number of the current topic.
         * @param array $given_answer The given answer's raw form.
         * @param string $given_solution The given solution's printable version.
         * @param string $real_solution The real solution's printable version.
         * @param bool $was_correct Whether the given answer was correct,or not.
         * 
         * @return void
         */
        protected function SetSessionAnswer($id, $given_answer, $given_solution, $real_solution, $was_correct){
            $_SESSION["answers"]["answer_" . $id] = 
            array(
                "answer" => $given_answer, 
                "answer_text" => $given_solution,
                "solution_text" => $real_solution,
                "correct" => $was_correct
            );
        }

        /**
         * 
         * This method returns the score with which the student's practice task point should be updated
         * 
         * @return float The score which should be added to the student's practice task point
        */
        public function GetUpdatePoint(){
            if($this->solution_counter != 0){
                return $this->correct_answer_counter/$this->solution_counter;
            }else{
                return 0;
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
        protected function AreSetsEqual($first_set,$second_set){
            $tmp_first_set = [];
            foreach($first_set as $element){
                if(is_int($element) || is_float($element)){
                    $element = round($element, 2);
                }
                array_push($tmp_first_set, $element);
            }
            $first_set = $tmp_first_set;

            $tmp_second_set = [];
            foreach($second_set as $element){
                if(is_int($element) || is_float($element)){
                    $element = round($element, 2);
                }
                array_push($tmp_second_set, $element);
            }
            $second_set = $tmp_second_set;



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
        protected function AreRelationsEqual($first_relation, $second_relation){
            $dimati_helper_functions = new DimatiHelperFunctions();
            [$first_relation_first_components, $first_relation_second_components] = $dimati_helper_functions->GetRelationTwoArrayForm($first_relation);
            [$second_relation_first_components, $second_relation_second_components] = $dimati_helper_functions->GetRelationTwoArrayForm($second_relation);
            
            $first_equal = $this->AreSetsEqual($first_relation_first_components, $second_relation_first_components);
            $second_equal = $this->AreSetsEqual($first_relation_second_components, $second_relation_second_components);

            return $first_equal && $second_equal;
        }

        /**
         * 
         * This method compares the values of two select elements.
         * 
         * @param array $real_solutions The real solutions for the subtask.
         * @param array $given_answers The given answers for the subtask.
         * @param string $answer_counter If the selects are under the same subtask, then this determines the subtask's number.
         * 
         * @return bool Returns whether the given answers and real solutions are all the same, or not.
        */
        protected function CheckIfSelectsEqual($real_solutions, $given_answers, $answer_counter){
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
         * @param string $prefix The prefix of the select element name.
         * @param int $select_start The index of the first HTML select element.
         * @param int $select_end The index of the last HTML select element.
         * 
         * @return array Returns an indexed array containing the values of the HTML select elements.
        */
        protected function ParseSelectSolutions($prefix, $select_start, $select_end){
            $answer = [];
            $subtask_counter = 0;
            for($counter = $select_start; $counter <= $select_end; $counter++){
                array_push($answer, $this->given_answers[$prefix . "_" . $subtask_counter]??"");
                $subtask_counter++;
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
        protected function CreateRelation($values){
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
        protected function ExtractSolutionFromInput($input){
            $input = preg_replace("/[^a-zA-Z0-9-]/", "|", $input);
            $values = explode("|", $input);
            $return_values = [];
            foreach($values as $index => $value){
                if(ctype_alnum($value)){
                    if(!is_numeric($value) && strlen($value) == 1 || is_numeric($value)){
                        array_push($return_values, $value);
                    }
                }else{
                    if(is_int(strpos($value,"-"))){ // It was negative
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
         * This method extracts the values from the student's answer.
         * 
         * Firstly, each non-numeric characters will be replaced by the '|' character.
         * Then the string will be split by the '|' character.
         * Finally, only the numbers will be kept in this array.
         * 
         * @param string $input The original content of the input element.
         * 
         * @return array Returns an indexed array with the extracted elements.
        */
        protected function ExtractSolutionFromInputOnlyNumbers($input){
            $input = preg_replace("/-[ ]*/", "-", $input);
            $input = preg_replace("/[^0-9.-]/", "|", $input);
            $values = explode("|", $input);
            $return_values = [];
            
            foreach($values as $index => $value){
                if(is_numeric($value)){
                    array_push($return_values, floatval($value));
                }else{
                    if(is_numeric(str_replace("-", "", $value))){ // It was a negative sign
                        array_push($return_values, -1*floatval(str_replace("-", "", $value)));
                    }
                }
            }
            return $return_values;
        }

        /**
         * This protected method checks if a number is congruent with another one for a given modulo.
         * 
         * @param int $number A whole number, that we want to check if congruent with anohter one.
         * @param int $remainder A whole number, with thich we wish to compare the first number, if they are congruent for the given modulo.
         * @param int $modulo A positive whole number, for which we will compare the first two given arguments if they are congruent, or not.
         * 
         * @return bool Returns if the first two arguments are congruent modulo the third argument, or not.
         */
        protected function IsCongruent($number, $remainder, $modulo){
            if($modulo > 0){
                $b = $number - $remainder;
                while($b < 0){
                    $b += $modulo;
                }
                return $b % $modulo === 0;
            }else{
                return false;
            }
        }

       /**
         * This protected method compares the content of an input with the real value for that input. The given key is the required element's key in the user's given asnwers' array.
         * 
         * The content here will be extracted from the input (even if its value is "", i.e., the user's answer array didn't contain the given name as a key), then will be compared with the correct value.
         * 
         * @param int $real_value A whole number, the real value for the input.
         * @param string $input_name A string, the key of the element in the user's given answers' array.
         * @param string $answer_id The id of the view's input for which the method sets attributes like the value, class. It also sets the correct answer for that input.
         *  
         * @return void
         */
        protected function EvaluateInputsWithNumbers($real_value, $input_name, $answer_id){
            $given_answer_raw = $this->given_answers[$input_name]??"";
            $given_answer = $this->ExtractSolutionFromInputOnlyNumbers($given_answer_raw)[0]??"";
            
            if(is_int($real_value) || is_float($real_value)){
                $real_value = round($real_value,2);
            }

            $was_correct =  $given_answer == $real_value;
            if($was_correct){
                $this->correct_answer_counter += 1;
            }

            $this->SetSessionAnswer($answer_id, $given_answer_raw, $given_answer, $real_value, $was_correct);
        }

       /**
         * This protected method compares the content of an input with the real value for that input. The given key is the first required element's key in the user's given asnwers' array.
         * 
         * The content here will be extracted from the input (even if its value is "", i.e., the user's answer array did not contain an element with the given key), then will be converted into set form.
         * For showing the answer and the real solution, the method creates a printable form of the sets.
         * The sets will be compared by the inherited method named AreSetsEqual.
         * 
         * @param array $real_value An indexed array containing the set's elements.
         * @param string $input_name A string, the key of the element in the user's given answers' array.
         * @param string $answer_id The id of the view's input for which the method sets attributes like the value, class. It also sets the correct answer for that input.
         * @param bool $only_numbers Let only numbers to be evaluated. The default is true.
         * @param string $print_config Configuring the printing. The default is "".
         * 
         * @return void
         */
        protected function EvaluateInputsWithSets($real_value, $input_name, $answer_id, $only_numbers = true, $print_config = ""){
            $given_answer_raw = $this->given_answers[$input_name]??"";
            if($only_numbers){
                $given_answer = $this->ExtractSolutionFromInputOnlyNumbers($given_answer_raw);
            }else{
                $given_answer = $this->ExtractSolutionFromInput($given_answer_raw);
            }


            switch($print_config){
                case "algebraic":{
                    $answer_text = PrintServices::CreatePrintableComplexNumberAlgebraic("", $given_answer, false);
                    $solution_text = PrintServices::CreatePrintableComplexNumberAlgebraic("", $real_value, false);
                };break;
                case "trigonometric":{
                    $answer_text = PrintServices::CreatePrintableComplexNumberTrigonometric("", $given_answer, true, false);
                    $solution_text = PrintServices::CreatePrintableComplexNumberTrigonometric("", $real_value, true, false);
                };break;
                case "trigonometric_multiple_arguments":{
                    $answer_text = "";
                    $given_answer_size = $given_answer[0]??0;
                    for($argument_counter = 1; $argument_counter < count($given_answer); ++$argument_counter){
                        $answer_text .= "<br>" . PrintServices::CreatePrintableComplexNumberTrigonometric("", [$given_answer_size,  $given_answer[$argument_counter]], true, false);
                    }

                    $solution_text = "";
                    $real_value_size = $real_value[0];
                    for($argument_counter = 1; $argument_counter < count($real_value); ++$argument_counter){
                        $solution_text .= "<br>" . PrintServices::CreatePrintableComplexNumberTrigonometric("", [$real_value_size,  $real_value[$argument_counter]], true, false);
                    }
                };break;
                default:{
                    $answer_text = PrintServices::CreatePrintableSet("", $given_answer, false);
                    $solution_text = PrintServices::CreatePrintableSet("", $real_value, false);
                }break;
            }
            $was_correct = $this->AreSetsEqual($given_answer, $real_value) && $given_answer_raw !== "Megold??som...";
            if($was_correct){
                $this->correct_answer_counter += 1;
            }

            $this->SetSessionAnswer($answer_id, $given_answer_raw, $answer_text, $solution_text, $was_correct);
        }

        /**
         * This protected method compares the content of an input with the real value for that input. The given key is the first required element's key in the user's given asnwers' array.
         * 
         * The content here will be extracted from the input (even if its value is "", i.e., the user's answer array did not contain an element with the given key), then will be converted into relation form.
         * For showing the answer and the real solution, the method creates a printable form of the relations.
         * The relations will be compared by the inherited method named AreRelationsEqual.
         * 
         * @param array $real_value An indexed array containing oredered pairs, i.e., [first element, second element] pairs.
         * @param string $input_name A string, the key of the element in the user's given answers' array.
         * @param string $answer_id The id of the view's input for which the method sets attributes like the value, class. It also sets the correct answer for that input.
         * @param bool $only_numbers Let only numbers to be evaluated. The default is true.
         * @param bool $use_own_text Send back an alternative solution text. The default is false.
         * @param string $answer_text The orinigally made printable text. The default is "".
         * @param string $print_config Configuring the printing. The default is "".
         * 
         * @return void
         */
        protected function EvaluateInputsWithRelations($real_value, $answer_counter, $answer_id, $only_numbers = true, $use_own_text = false, $solution_text = "", $print_config = ""){
            $given_answer_raw = $this->given_answers[$answer_counter]??"";
            if($only_numbers){
                $given_answer = $this->CreateRelation($this->ExtractSolutionFromInputOnlyNumbers($given_answer_raw));
            }else{
                $given_answer = $this->CreateRelation($this->ExtractSolutionFromInput($given_answer_raw));
            }

            switch($print_config){
                case "polynomial":{
                    $answer_text = PrintServices::CreatePrintablePolynomialByPairs($given_answer);
                    if(!$use_own_text){
                        $solution_text = PrintServices::CreatePrintablePolynomialByPairs($real_value);
                    }
                };break;
                default:{
                    $answer_text = PrintServices::CreatePrintableRelation("", $given_answer, false);
                    if(!$use_own_text){
                        $solution_text = PrintServices::CreatePrintableRelation("", $real_value, false);
                    }
                }break;
            }
            
            $was_correct = $this->AreRelationsEqual($given_answer, $real_value);
            if($was_correct){
                $this->correct_answer_counter += 1;
            }

            $this->SetSessionAnswer($answer_id, $given_answer_raw, $answer_text, $solution_text, $was_correct);
        }

        /**
         * This protected method compares the content of an input with the real value for that input. The given key is the required element's key in the user's given asnwers' array.
         * 
         * The content here will be extracted from the input (even if its value is "", i.e., the user's answer array didn't contain the given name as a key).
         * Here, only the residues will be compared. The residues (the first argument and the given number indexed element of the user's given answers' array) will be compared by the IsCongruent method.
         * 
         * @param int $real_value_residue A whole number, the real value for the residue.
         * @param int $real_value_modulo A positive whole number, the real value for the modulo.
         * @param string $input_name A string, the key of the element in the user's given answers' array.
         * @param string $answer_id The id of the view's input for which the method sets attributes like the value, class. It also sets the correct answer for that input.
         *  
         * @return void
         */
        protected function EvaluateNumberAndCongruence($real_value_residue, $real_value_modulo, $input_name, $answer_id){
            $given_number_raw = $this->given_answers[$input_name]??"";
            $given_number = $this->ExtractSolutionFromInputOnlyNumbers($given_number_raw)[0]??"";
            
            $was_correct = $this->IsCongruent(intval($given_number), $real_value_residue, $real_value_modulo) && is_numeric($given_number);
            if($was_correct){
                $this->correct_answer_counter += 1;
            }

            $this->SetSessionAnswer($answer_id, $given_number_raw, $given_number, $real_value_residue . " + " . $real_value_modulo .  "k (k \u{2208} \u{2124})", $was_correct);
        }

       /**
         * This protected method compares the content of a pair of inputs with the real values for those inputs. The given key is the first required element's key in the user's given asnwers' array.
         * 
         * The contents here will be extracted from the inputs (even if its value is "", i.e., the user's answer array did not contain an element with the given key).
         * The modulos (the second element of the first argument and the given number + 1 indexed element of the user's given answers' array) will be compared.
         * Then, the residues (the first element of the first argument and the given number indexed element of the user's given answers' array) will be compared by the IsCongruent method.
         * 
         * @param array $congruence An indexed array containing two elements, the resiude and the modulo.
         * @param array $input_names An array containing the keys of the required inputs' values found in the user's given answers' (associative) array.
         * @param array $answer_ids The id of the view's input for which the method sets attributes like the value, class. It also sets the correct answer for that input.
         * 
         * @return void
         */
        protected function EvaluatePairsOfCongruences($congruence, $input_names, $answer_ids){
            $given_answer_pair_raw = [$this->given_answers[$input_names[0]]??"", $this->given_answers[$input_names[1]]??""];
            $given_answer_pair = [$this->ExtractSolutionFromInputOnlyNumbers($given_answer_pair_raw[0])[0]??"",$this->ExtractSolutionFromInputOnlyNumbers($given_answer_pair_raw[1])[0]??""];
                
            $was_correct_modulo = $given_answer_pair[1] == $congruence[1] && is_numeric($congruence[1]) && is_numeric($given_answer_pair[1]);
            $was_correct_residue = $this->IsCongruent(intval($given_answer_pair[0]), $congruence[0], $congruence[1]) && is_numeric($given_answer_pair[0]);
            if($was_correct_residue && $was_correct_modulo){
                $this->correct_answer_counter += 1;
            }
            
            $this->SetSessionAnswer($answer_ids[0], $given_answer_pair_raw[0], $given_answer_pair[0], $congruence[0], $was_correct_residue);
            $this->SetSessionAnswer($answer_ids[1], $given_answer_pair_raw[1], $given_answer_pair[1], $congruence[1], $was_correct_modulo);
        }
    }

?>