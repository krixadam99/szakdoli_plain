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

        public abstract function CheckSolution($topic_number);

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
         * @param array $real_solution The real solutions for the subtask.
         * @param array $given_answer The given answers for the subtask.
         * @param array $answer_counter If the selects are under the same subtask, then this determines the subtask's number.
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
         * @param int $select_start The index of the first HTML select element.
         * @param int $select_end The index of the last HTML select element.
         * 
         * @return array Returns an indexed array containing the values of the HTML select elements.
        */
        protected function ParseSelectSolutions($select_start, $select_end){
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
            $input = preg_replace("/[^0-9-]/", "|", $input);
            $values = explode("|", $input);
            $return_values = [];
            foreach($values as $index => $value){
                if(is_numeric($value)){
                    array_push($return_values, $value);
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
        protected function CreatePrintableSet($set){
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
        protected function CreatePrintableRelation($relation){
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
        protected function CreatePrintableComplexNumber($complex_number, $is_trigonometric = false){
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
            
            $was_correct =  $given_answer == $real_value;
            if($was_correct){
                $this->correct_answer_counter += 1;
            }

            $this->SetSessionAnswer($answer_id, $given_answer_raw, $given_answer, $real_value, $was_correct);
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
         * @param string $answer_id The id of the view's input for which the method sets attributes like the value, class. It also sets the correct answer for that input.
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
         * 
         * @return void
         */
        protected function EvaluateInputsWithSets($real_value, $input_name, $answer_id){
            $given_answer_raw = $this->given_answers[$input_name]??"";
            $given_answer = $this->ExtractSolutionFromInputOnlyNumbers($given_answer_raw);
            
            $answer_text = $this->CreatePrintableSet($given_answer);
            $solution_text = $this->CreatePrintableSet($real_value);
            $was_correct = $this->AreSetsEqual($given_answer, $real_value);
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
         * 
         * @return void
         */
        protected function EvaluateInputsWithRelations($real_value, $answer_counter, $answer_id){
            $given_answer_raw = $this->given_answers[$answer_counter]??"";
            $given_answer = $this->CreateRelation($this->ExtractSolutionFromInputOnlyNumbers($given_answer_raw));
            
            $answer_text = $this->CreatePrintableRelation($given_answer);
            $solution_text = $this->CreatePrintableRelation($real_value);
            
            $was_correct = $this->AreRelationsEqual($given_answer, $real_value);
            if($was_correct){
                $this->correct_answer_counter += 1;
            }

            $this->SetSessionAnswer($answer_id, $given_answer_raw, $answer_text, $solution_text, $was_correct);
        }
    }

?>