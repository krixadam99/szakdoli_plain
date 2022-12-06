<?php
    /**
     * This class extends the task evaluator abstract class, and is responsible for evaluating the tasks related to discrete mathematics I..
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
            $this->correct_answer_counter = 0;
            $this->real_solutions = $_SESSION["solution"];
            $this->given_answers = $given_answers;
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
            $subtask_counter = 0;
            $task_counter = 0;
            foreach($this->real_solutions as $solution_array_key => $real_solution){
                if($subtask_counter % 5 === 0 && $subtask_counter !== 0){
                    $subtask_counter = 0;
                    $task_counter += 1;
                }
                $id = $task_counter . "_" . $subtask_counter;
                $this->EvaluateInputsWithSets($real_solution, $solution_array_key, $id, false);
                $this->solution_counter++;
                $subtask_counter++;
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
            $subtask_counter = 0;
            $task_counter = 0;
            foreach($this->real_solutions as $solution_array_key => $real_solution){
                if($subtask_counter % 6 === 0 && $subtask_counter !== 0){
                    $subtask_counter = 0;
                    $task_counter += 1;
                }
                $id = $task_counter . "_" . $subtask_counter;
                
                if($subtask_counter == 2 || $subtask_counter == 3){
                    $this->EvaluateInputsWithRelations($real_solution, $solution_array_key, $id, false);
                }else{
                    $this->EvaluateInputsWithSets($real_solution, $solution_array_key, $id, false);
                }
                $this->solution_counter++;
                $subtask_counter++;
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
            $dimat_helper_functions = new DimatiHelperFunctions();
            
            $subtask_counter = 0;
            $task_counter = 0;
            foreach($this->real_solutions["first_subtasks"] as $solution_array_key => $real_solution){
                $id = $task_counter . "_" . $subtask_counter;
                $this->EvaluateInputsWithRelations($real_solution, $solution_array_key, $id, false);
                $this->solution_counter++;
                $subtask_counter++;
            }

            $subtask_counter = 0;
            $task_counter = 1;
            foreach($this->real_solutions["second_subtasks"] as $solution_array_key => $real_solution){
                $id = $task_counter . "_" . $subtask_counter;
                $second_answers = $this->ParseSelectSolutions("solution_$id", 0,8);

                if($this->CheckIfSelectsEqual($real_solution, $second_answers, $id)){
                    $this->correct_answer_counter += 1;
                }

                $this->solution_counter++;
                $subtask_counter++;
            }

            $subtask_counter = 0;
            $task_counter = 2;
            foreach($this->real_solutions["third_subtasks"] as $solution_array_key => $real_solution){
                $id = $task_counter . "_" . $subtask_counter;
                $given_answer_raw = $this->given_answers["solution_$id"]??"";
                $given_answer = $this->CreateRelation($this->ExtractSolutionFromInput($given_answer_raw));
                
                $personal_set = $_SESSION["task"]["characteristics"]["sets"][$subtask_counter];
                $characteristics = $_SESSION["task"]["characteristics"]["characteristics"][$subtask_counter];

                $are_elements_from_personal_set = count(array_diff($this->ExtractSolutionFromInput($given_answer_raw), $personal_set)) === 0;
                $correct_array = [];
                foreach($characteristics as $characteristic => $is_true){
                    $is_answer_true = false;
                    switch($characteristic){
                        case "Reflexív":{
                            $is_answer_true = $dimat_helper_functions->IsReflexiveRelation($personal_set, $given_answer);
                        };
                        break;
                        case "Irreflexív":{
                            $is_answer_true = $dimat_helper_functions->IsIrreflexiveRelation($personal_set, $given_answer);
                        };
                        break;
                        case "Szimmetrikus":{
                            $is_answer_true = $dimat_helper_functions->IsSymmetricRelation($personal_set, $given_answer);
                        };
                        break;
                        case "Antiszimmetrikus":{
                            $is_answer_true = $dimat_helper_functions->IsAntisymmetricRelation($personal_set, $given_answer);
                        };
                        break;
                        case "Asszimetrikus":{
                            $is_answer_true = $dimat_helper_functions->IsAssymmetricRelation($personal_set, $given_answer);
                        };
                        break;
                        case "Tranzitív":{
                            $is_answer_true = $dimat_helper_functions->IsTransitiveRelation($personal_set, $given_answer);
                        };
                        break;
                        default:break;
                    }
                    
                    $correct_array = array_merge($correct_array, array($characteristic => $is_answer_true === $is_true && $are_elements_from_personal_set));
                }
                
                $possible_relations = "<label class=\"task_label\">";
                foreach($real_solution as $relation_counter => $relation){
                    if($relation_counter > 1){
                        break;
                    }
                    
                    if($relation_counter !== 0){
                        $possible_relations = $possible_relations . "; ";
                    }
                    $possible_relations = $possible_relations . PrintServices::CreatePrintableRelation("",$relation,false);
                }
                $possible_relations = $possible_relations . "</label>";
    
                $is_correct = false;
                if(!in_array(false, array_values($correct_array))){
                    $this->correct_answer_counter += 1;
                    $is_correct = true;
                }
                $this->SetSessionAnswer($id, $given_answer_raw, PrintServices::CreatePrintableRelation("",$given_answer,false), $possible_relations, $is_correct);
                $_SESSION["answers"]["answer_$id"] = array_merge($_SESSION["answers"]["answer_$id"], array("correct_array" => $correct_array));
                
                $this->solution_counter++;
                $subtask_counter++;
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
            $subtask_counter = 0;
            $task_counter = 0;
            foreach($this->real_solutions["first_subtasks"] as $solution_array_key => $real_solution){
                $id = $task_counter . "_" . $subtask_counter;
                $first_answer = $this->ParseSelectSolutions("solution_$id", 0, 0);
                
                if($this->CheckIfSelectsEqual($real_solution, $first_answer, $id)){
                    $this->correct_answer_counter += 1;
                }
                
                $this->solution_counter++;
                $subtask_counter++;
            }

            $subtask_counter = 0;
            $task_counter = 1;
            foreach($this->real_solutions["second_subtasks"] as $solution_array_key => $real_solutions){
                $id = $task_counter . "_" . $subtask_counter;
                $second_answers = $this->ParseSelectSolutions("solution_$id", 0,2);
                if($this->CheckIfSelectsEqual($real_solutions, $second_answers, $id)){
                    $this->correct_answer_counter += 1;
                }
                
                $this->solution_counter++;
                $subtask_counter++;
            }
            
        }

        /**
         * 
         * This private method compares the given answers with the solutions for Discrete mathematics I. subject 5th topic's tasks.
         * 
         * There are 2 main tasks for this topic.
         * 
         * @return void
        */
        private function CheckFifthTaskSolution(){
            $subtask_counter = 0;
            $task_counter = 0;
            foreach($this->real_solutions[0] as $solution_array_key => $real_solution){
                if($subtask_counter % 4 === 0 && $subtask_counter !== 0){
                    $subtask_counter = 0;
                    $task_counter += 1;
                }

                $id = "0_" . $task_counter . "_" . $subtask_counter;
                if($subtask_counter < 3){
                    $this->EvaluateInputsWithNumbers($real_solution, $solution_array_key, $id);
                }else{
                    $this->EvaluateInputsWithSets($real_solution, $solution_array_key, $id, true, "algebraic");
                }
                $this->solution_counter++;
                $subtask_counter++;
            }

            $subtask_counter = 0;
            $task_counter = 0;
            foreach($this->real_solutions[1] as $solution_array_key => $real_solution){
                if($subtask_counter % 4 === 0 && $subtask_counter !== 0){
                    $subtask_counter = 0;
                    $task_counter += 1;
                }

                $id = "1_" . $task_counter . "_" . $subtask_counter;
                $this->EvaluateInputsWithSets($real_solution, $solution_array_key, $id, true, "algebraic");
                $this->solution_counter++;
                $subtask_counter++;
            }
        }

        /**
         * 
         * This private method compares the given answers with the solutions for Discrete mathematics I. subject 6th topic's tasks.
         * 
         * There are 2 main tasks for this topic.
         * 
         * @return void
        */
        private function CheckSixthTaskSolution(){
            $subtask_counter = 0;
            $task_counter = 0;
            foreach($this->real_solutions[0] as $solution_array_key => $real_solution){
                if($subtask_counter % 2 === 0 && $subtask_counter !== 0){
                    $subtask_counter = 0;
                    $task_counter += 1;
                }

                $id = "0_" . $task_counter . "_" . $subtask_counter;
                
                $this->EvaluateInputsWithSets($real_solution, $solution_array_key, $id, true, "trigonometric");
                $this->solution_counter++;
                $subtask_counter++;
            }

            $subtask_counter = 0;
            $task_counter = 0;
            foreach($this->real_solutions[1] as $solution_array_key => $real_solution){
                if($subtask_counter % 2 === 0 && $subtask_counter !== 0){
                    $subtask_counter = 0;
                    $task_counter += 1;
                }

                $id = "1_" . $task_counter . "_" . $subtask_counter;
                $this->EvaluateInputsWithSets($real_solution, $solution_array_key, $id, true, "trigonometric");
                $this->solution_counter++;
                $subtask_counter++;
            }
        }

        /**
         * 
         * This private method compares the given answers with the solutions for Discrete mathematics I. subject 7th topic's tasks.
         * 
         * @return void
        */
        private function CheckSeventhTaskSolution(){
            $subtask_counter = 0;
            $task_counter = 0;
            foreach($this->real_solutions[0] as $solution_array_key => $real_solution){
                if($subtask_counter % 2 === 0 && $subtask_counter !== 0){
                    $subtask_counter = 0;
                    $task_counter += 1;
                }

                $id = "0_" . $task_counter . "_" . $subtask_counter;
                
                $this->EvaluateInputsWithSets($real_solution, $solution_array_key, $id, true, "trigonometric");
                $this->solution_counter++;
                $subtask_counter++;
            }

            $subtask_counter = 0;
            $task_counter = 0;
            foreach($this->real_solutions[1] as $solution_array_key => $real_solution){
                if($subtask_counter % 2 === 0 && $subtask_counter !== 0){
                    $subtask_counter = 0;
                    $task_counter += 1;
                }

                $real_solution_set = [];
                array_push($real_solution_set, $real_solution["size"]??"");
                $real_solution_set = array_merge($real_solution_set, $real_solution["arguments"]??[]);

                $id = "1_" . $task_counter . "_" . $subtask_counter;
                $this->EvaluateInputsWithSets($real_solution_set, $solution_array_key, $id, true, "trigonometric_multiple_arguments");
                $this->solution_counter++;
                $subtask_counter++;
            }
        }

        /**
         * 
         * This private method compares the given answers with the solutions for Discrete mathematics I. subject 8th topic's tasks.
         * 
         * @return void
        */
        private function CheckEigthTaskSolution(){
            $subtask_counter = 0;
            foreach($this->real_solutions[0] as $solution_array_key => $real_solution){
                $id = "0_" . $subtask_counter;
                $this->EvaluateInputsWithNumbers($real_solution, $solution_array_key, $id);
                $this->solution_counter++;
                $subtask_counter++;
            }

            $subtask_counter = 0;
            foreach($this->real_solutions[1] as $solution_array_key => $real_solution){
                $id = "1_" . $subtask_counter;

                $relation_form = [];
                for($coefficient_counter=0; $coefficient_counter < count($real_solution); $coefficient_counter++) { 
                    array_push($relation_form,[$real_solution[$coefficient_counter], count($real_solution) - 1 - $coefficient_counter]);
                }

                $this->EvaluateInputsWithRelations($relation_form, $solution_array_key, $id, false, false, "", "polynomial");
                $this->solution_counter++;
                $subtask_counter++;
            }
        }

        /**
         * 
         * This private method compares the given answers with the solutions for Discrete mathematics I. subject 9th topic's tasks.
         * 
         * @return void
        */
        private function CheckNinethTaskSolution(){
            $subtask_counter = 0;
            $task_counter = 0;

            foreach($this->real_solutions[0] as $solution_array_key => $real_solution){
                $id = $task_counter . "_" . $subtask_counter;
                $first_answers = $this->ParseSelectSolutions("solution_$id", 0 + $subtask_counter, 0 + $subtask_counter);

                if($this->CheckIfSelectsEqual([$real_solution], $first_answers, $id)){
                    $this->correct_answer_counter += 1;
                }

                $this->solution_counter++;
                $subtask_counter++;
            }

            $subtask_counter = 0;
            $task_counter = 1;
            foreach($this->real_solutions[1] as $solution_array_key => $real_solution){
                $id = $task_counter . "_" . $subtask_counter;
                $first_answers = $this->ParseSelectSolutions("solution_$id", 2 + $subtask_counter,2 + $subtask_counter);

                if($this->CheckIfSelectsEqual([$real_solution], $first_answers, $id)){
                    $this->correct_answer_counter += 1;
                }

                $this->solution_counter++;
                $subtask_counter++;
            }

            $subtask_counter = 0;
            $task_counter = 2;
            foreach($this->real_solutions[2] as $solution_array_key => $real_solution){
                $id = $task_counter . "_" . $subtask_counter;
                $first_answers = $this->ParseSelectSolutions("solution_$id", 4 + $subtask_counter,4 + $subtask_counter);

                if($this->CheckIfSelectsEqual([$real_solution], $first_answers, $id)){
                    $this->correct_answer_counter += 1;
                }

                $this->solution_counter++;
                $subtask_counter++;
            }

            $subtask_counter = 0;
            $task_counter = 3;
            foreach($this->real_solutions[3] as $solution_array_key => $real_solution){
                $id = $task_counter . "_" . $subtask_counter;
                $first_answers = $this->ParseSelectSolutions("solution_$id", 6 + $subtask_counter,6 + $subtask_counter);

                if($this->CheckIfSelectsEqual([$real_solution], $first_answers, $id)){
                    $this->correct_answer_counter += 1;
                }

                $this->solution_counter++;
                $subtask_counter++;
            }
        }
    }
?>