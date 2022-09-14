<?php
    /**
     * This class extends the task evaluator abstract class, and is responsible for evaluating the tasks related to discrete mathematics I..
     * 
     * 
    */
    class DimatiTaskEvaluator extends TaskEvaluator{
        /**
         * 
         * The contructor for DimatiTaskEvaluator class.
         * 
         * The inherated members will all be set here.
         * 
         * @param array $given_answers An associative array containing the user's given solutions.
         * 
         * @return void
         */
        public function __construct($given_answers){
            $this->subject_id = "i";
            $this->solution_counter = 0;
            $this->count_correct = 0;
            $this->real_solutions = $_SESSION["solution"];
            $this->given_answers = array_values($given_answers);
        }
        
        /**
         * This method will make the comparison between the given and real answers. The right method will be chosen by the topic number.
         * 
         * @param string $topic_number A numeric string between 0-9. The function will chosse the right comparing method based on this variable.
         * 
         * @return void
         */
        public function CheckSolution($topic_number){
            $_SESSION["answers"] = [];
            $this->topic_number = $topic_number;
            
            switch($topic_number){
                case "0":{
                    $this->CheckFirstTaskSolution();
                };
                break;
                case "1":{
                    $this->CheckSecondTaskSolution();
                };
                break;
                case "2":{
                    $this->CheckThirdTaskSolution();
                };
                break;
                case "3":{
                    $this->CheckFourthTaskSolution();
                };
                break;
                case "4":{
                    $this->CheckFifthTaskSolution();
                };
                break;
                case "5":{
                    $this->CheckSixthTaskSolution();
                };
                break;
                case "6":{
                    $this->CheckSeventhTaskSolution();
                };
                break;
                case "7":{
                    $this->CheckEigthTaskSolution();
                };
                break;
                case "8":{
                    $this->CheckNinethTaskSolution();
                };
                break;
                case "9":{
                    $this->CheckTenthTaskSolution();
                };
                break;
                default:break;
            }
        }

        /**
         * 
         * This private method compares the given answers with the solutions for Discrete mathematics I. subject 1st topic's tasks
         * 
         * There are 10 main tasks for this topic
         * This method will extract the set elements from each input, then compare each set with the predetermined one
         * If the 2 sets are identical, then the student has a plus point
         * Finally, for each input we will determine the original answer (string), the cleaned answer (string), the real solution (string) and if the answer was correct
         * 
         * @return void
        */
        private function CheckFirstTaskSolution(){
            foreach($this->real_solutions as $index => $real_solution){
                $given_answer = $this->given_answers[$this->solution_counter]??"";
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
         * This private method compares the given answers with the solutions for Discrete mathematics I. subject 2nd topic's tasks
         * 
         * There are 6 main tasks for this topic
         * This method will extract the relation elements from the third and fourth input, then compare each relation with the predetermined one
         * From the first, second, fifth and sixth input it will extract the set elements, then compare each set with the predetermined one
         * If the 2 sets, or 2 relations are identical, then the student has a plus point
         * Finally, for each input we will determine the original answer (string), the cleaned answer (string), the real solution (string) and if the answer was correct
         * 
         * @return void
        */
        private function CheckSecondTaskSolution(){
            foreach($this->real_solutions as $index => $real_solution){
                $given_answer = $this->given_answers[$this->solution_counter]??"";
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
         * This private method compares the given answers with the solutions for Discrete mathematics I. subject 3rd topic's tasks.
         * 
         * There are 3 main tasks for this topic.
         * This method will extract the relation elements from the first and third inputs.
         * It will extract the select values from the select elements
         * 
         * @return void
        */
        private function CheckThirdTaskSolution(){
            //Parsing the answers
            $real_solutions = array_values($this->real_solutions);

            $first_answer_relation = [];
            if(isset($this->given_answers[0])){
                $values = $this->ExtractSolutionFromInput($this->given_answers[0]);
                $first_answer_relation = $this->CreateRelation($values);
            }

            $second_answer = $this->ParseSelectSolutions(1,9);

            $third_answer_relation = [];
            if(isset($this->given_answers[2])){
                $values = $this->ExtractSolutionFromInput($this->given_answers[2]);
                $first_answer_relation = $this->CreateRelation($values);
            }


            //Checking the first answer
            $first_solution_relation = $real_solutions[0]; 
            $was_correct = $this->CompareRelations($first_answer_relation, $first_solution_relation);
            if($was_correct){
                $this->count_correct += 1;
            }
            $_SESSION["answers"]["answer_0"] = 
                array(
                    "answer" => $this->given_answers[0],
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
         * This private method compares the given answers with the solutions for Discrete mathematics I. subject 4th topic's tasks.
         * 
         * There are 2 main tasks for this topic.
         * 
         * @return void
        */
        private function CheckFourthTaskSolution(){
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
            foreach($real_solution_1 as $index => $given_answers){
                if($this->CheckIfSelectsEqual($given_answers, $second_answers[$answer_counter-1], $answer_counter)){
                    $this->count_correct += 1;
                };
                $answer_counter++;
            }
        }

        /**
         * 
         * This private method compares the given answers with the solutions for Discrete mathematics I. subject 5th topic's tasks.
         * 
         * There are 3 main tasks for this topic.
         * 
         * @return void
        */
        private function CheckFifthTaskSolution(){
            $this->solution_counter = 0;
            foreach($this->real_solutions as $index => $real_solution){
                $given_answer = $this->given_answers[$this->solution_counter]??"";
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

        /**
         * 
         * This private method compares the given answers with the solutions for Discrete mathematics I. subject 6th topic's tasks.
         * 
         * There are 3 main tasks for this topic.
         * 
         * @return void
        */
        private function CheckSixthTaskSolution(){
            $this->solution_counter = 0;
            foreach($this->given_answers as $index => $given_answer){
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
         * This private method compares the given answers with the solutions for Discrete mathematics I. subject 7th topic's tasks.
         * 
         * @return void
        */
        private function CheckSeventhTaskSolution(){
        }

        /**
         * 
         * This private method compares the given answers with the solutions for Discrete mathematics I. subject 8th topic's tasks.
         * 
         * @return void
        */
        private function CheckEigthTaskSolution(){
        }

        /**
         * 
         * This private method compares the given answers with the solutions for Discrete mathematics I. subject 9th topic's tasks.
         * 
         * @return void
        */
        private function CheckNinethTaskSolution(){
        }

        /**
         * 
         * This private method compares the given answers with the solutions for Discrete mathematics I. subject 10th topic's tasks.
         * 
         * @return void
        */
        private function CheckTenthTaskSolution(){
        }
    }
?>