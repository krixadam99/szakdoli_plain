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
    }

?>