<?php
    /**
     * This is a controller class which is responsible for showing the practice page.
     * 
     * This controller extends the MainContentController, from which it inherits members that are related to a logged in user.
     * If someone navigates to the practice page, although they are not logged in, then this controller redirects them to the login page.
     * If someone navigates to the practice page, however they are not a student, then this controller redirects them to the notifications page.
    */
    class DimatiiTaskEvaluator extends TaskEvaluator{
        /**
         * 
         * The contructor for DimatiiTaskEvaluator class.
         * 
         * The inherated members will all be set here.
         * 
         * @param array $given_answers An associative array containing the user's given solutions.
         * 
         * @return void
         */
        public function __construct($given_answers){
            $this->subject_id = "ii";
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
         * This private method compares the given answers with the solutions for Discrete mathematics II. subject's 1st topic's tasks related to division (with whole numbers), congruences and greatest common divisors.
         * 
         * @return void
        */
        private function CheckFirstTaskSolution(){
            // Check first subtask
            for($first_subtask_counter = 0; $first_subtask_counter < 2; $first_subtask_counter++){
                $this->EvaluateInputsWithNumbers($this->real_solutions["divide_pairs_solution"][$first_subtask_counter][0], "solution_" . "0_" . $first_subtask_counter . "_0", "0_" . $first_subtask_counter . "_0");
                $this->EvaluateInputsWithNumbers($this->real_solutions["divide_pairs_solution"][$first_subtask_counter][1], "solution_" . "0_" . $first_subtask_counter . "_1", "0_" . $first_subtask_counter . "_1");
                $this->solution_counter += 2;
            }

            // Check second subtask
            for($second_subtask_counter = 0; $second_subtask_counter < 2; $second_subtask_counter++){
                $answer_text = PrintServices::CreatePrintablePrimeFactorization($this->real_solutions["prime_factorization_solution"][$second_subtask_counter]);
                $this->EvaluateInputsWithRelations($this->real_solutions["prime_factorization_solution"][$second_subtask_counter], "solution_" . "1_" . $second_subtask_counter, "1_" . $second_subtask_counter, true, true, $answer_text);
                $this->solution_counter += 1;
            }

            // Check third subtask
            for($third_subtask_counter = 0; $third_subtask_counter < 2; $third_subtask_counter++){
                $this->EvaluateInputsWithNumbers($this->real_solutions["positive_divisor_count_solution"][$third_subtask_counter], "solution_" . "2_" . $third_subtask_counter, "2_" . $third_subtask_counter);
                $this->solution_counter += 1;
            }

            // Check fourth subtask
            for($fourth_subtask_counter = 0; $fourth_subtask_counter < 2; $fourth_subtask_counter++){
                $congruence = $this->real_solutions["congruence"][$fourth_subtask_counter];
                $this->EvaluateNumberAndCongruence($congruence[0], $congruence[1], "solution_" . "3_" . $fourth_subtask_counter, "3_" . $fourth_subtask_counter);
                $this->solution_counter += 1;
            }
        }

        /**
         * 
         * This private method compares the given answers with the solutions for Discrete mathematics II. subject's 2nd topic's tasks related to complete and reduced residue systems.
         * 
         * @return void
        */
        private function CheckSecondTaskSolution(){
            // Check first and second subtasks:
            $this->real_solutions = array_values($this->real_solutions);
            for($subtask_counter = 0; $subtask_counter < 2; $subtask_counter++){
                $this->EvaluateInputsWithSets($this->real_solutions[$subtask_counter], "solution_" . $subtask_counter, $subtask_counter);
                $this->solution_counter += 1;
            }

            // Check third subtask:
            for($third_subtask_counter = 0; $third_subtask_counter < 2; $third_subtask_counter++){
                $this->EvaluateInputsWithNumbers($this->real_solutions[2][$third_subtask_counter], "solution_2_" . $third_subtask_counter, "2_" . $third_subtask_counter);
                $this->solution_counter += 1;
            }
        }

        /**
         * 
         * This private method compares the given answers with the solutions for Discrete mathematics II. subject's 3rd topic's tasks related to eucleidan algorithm.
         * 
         * @return void
        */
        private function CheckThirdTaskSolution(){
            // Check first, second and third subtasks:
            for($subtask_counter = 0; $subtask_counter < 3; $subtask_counter++){
                $solution_steps = $this->real_solutions["eucleidan_algorithm"][$subtask_counter];
                $actual_gcd = $this->real_solutions["gcd"][$subtask_counter];
                $actual_lsm = $this->real_solutions["lcm"][$subtask_counter];
                
                foreach($solution_steps as $step_counter => $step){
                    foreach($step as $substep_counter => $sub_step){
                        if($substep_counter === 1){
                            $multiplicand = $solution_steps[$step_counter][1];
                            $multiplier = $solution_steps[$step_counter][2];
                            $given_answer_raw_multiplicand = $this->given_answers["solution_" . $subtask_counter . "_" . $step_counter . "_" . $substep_counter]??"";
                            $given_answer_raw_multiplier = $this->given_answers["solution_" . $subtask_counter . "_" . $step_counter . "_" . $substep_counter + 1]??"";
                            $given_answer_multiplicand = $this->ExtractSolutionFromInputOnlyNumbers($given_answer_raw_multiplicand)[0]??"";
                            $given_answer_multpilier = $this->ExtractSolutionFromInputOnlyNumbers($given_answer_raw_multiplier)[0]??"";
                            
                            $was_correct = false;
                            if($this->AreSetsEqual([$multiplicand, $multiplier],[$given_answer_multiplicand, $given_answer_multpilier])){
                                $this->correct_answer_counter += 2;
                                $was_correct = true;
                            }

                            $this->SetSessionAnswer(
                                $subtask_counter . "_" . $step_counter . "_" . $substep_counter, 
                                $given_answer_raw_multiplicand,
                                $given_answer_multiplicand, 
                                $multiplicand,
                                $was_correct
                            );
                            $this->SetSessionAnswer(
                                $subtask_counter . "_" . $step_counter . "_" . $substep_counter + 1, 
                                $given_answer_raw_multiplier,
                                $given_answer_multpilier, 
                                $multiplier,
                                $was_correct
                            );

                            $this->solution_counter += 2;
                        }else if($substep_counter === 0 || $substep_counter === 3){
                            $id = $subtask_counter . "_" . $step_counter . "_" . $substep_counter;
                            $this->EvaluateInputsWithNumbers($sub_step, "solution_" . $id, $id);

                            $this->solution_counter += 1;
                        }
                    }
                    //$this->solution_counter += 4;
                }

                for($step_counter = 0; $step_counter < 2; $step_counter++){
                    $id = $subtask_counter . "_" . count($solution_steps) + $step_counter;
                    if($step_counter === 0){
                        $this->EvaluateInputsWithNumbers($actual_gcd, "solution_" . $id, $id);
                    }else{
                        $this->EvaluateInputsWithNumbers($actual_lsm, "solution_" . $id, $id);
                    }
                    
                    $this->solution_counter += 1;
                }
            }
        }

        /**
         * 
         * This private method compares the given answers with the solutions for Discrete mathematics II. subject's 4th topic's tasks related to linear congruences.
         * 
         * @return void
        */
        private function CheckFourthTaskSolution(){
            // Check first, second and third subtasks:
            for($subtask_counter = 0; $subtask_counter < 3; $subtask_counter++){
                $real_solution_pair = $this->real_solutions["solutions"][$subtask_counter];
                $this->EvaluatePairsOfCongruences([$real_solution_pair[1],$real_solution_pair[2]], ["solution_" . $subtask_counter . "_0", "solution_" . $subtask_counter . "_1"],[$subtask_counter . "_0", $subtask_counter . "_1"]);
                
                $this->solution_counter += 1;
            }
        }

        /**
         * 
         * This private method compares the given answers with the solutions for Discrete mathematics II. subject's 5th topic's tasks related to linear diophantine equations.
         * 
         * @return void
        */
        private function CheckFifthTaskSolution(){
            // Check first and second subtasks:
            $answer_counter = 0;
            for($subtask_counter = 0; $subtask_counter < 2; $subtask_counter++){
                $real_solution_congruences = $this->real_solutions["diophantine_equations"][$subtask_counter];
                $x_congruence = $real_solution_congruences[0];
                $y_congruence = $real_solution_congruences[1];
                
                for($step_counter = 0; $step_counter < 3; $step_counter++){
                    $congruence = [];
                    if($step_counter < 2){
                        $congruence = [$x_congruence[1], $x_congruence[2]];
                    }else{
                        $congruence = $y_congruence;
                    }
                    $this->EvaluatePairsOfCongruences($congruence, ["solution_" .  $subtask_counter . "_" . $step_counter . "_0", "solution_" . $subtask_counter . "_" . $step_counter . "_1"],[$subtask_counter . "_" . $step_counter . "_0", $subtask_counter . "_" . $step_counter . "_1"]);

                    $this->solution_counter += 1;
                }

                $answer_counter += 1;
            }

            // Check third subtask:
            $given_number_first_raw = $this->given_answers["solution_" .  $answer_counter . "_0"]??"";
            $given_number_second_raw = $this->given_answers["solution_" .  $answer_counter . "_1"]??"";
            $given_number_first = $this->ExtractSolutionFromInputOnlyNumbers($given_number_first_raw)[0]??"";
            $given_number_second = $this->ExtractSolutionFromInputOnlyNumbers($given_number_second_raw)[0]??"";

            $real_solution_first_number = $this->real_solutions["diophantine_equations"][2][0];
            $real_solution_second_number = $this->real_solutions["diophantine_equations"][2][1];

            $first_number = $real_solution_first_number[1]*$real_solution_second_number[1];
            $second_number = $real_solution_second_number[0]*$real_solution_first_number[2];

            $was_correct = false;
            if(is_numeric($given_number_first) && is_numeric($given_number_second)){
                $was_correct = $this->IsCongruent(intval($given_number_first), $first_number, $real_solution_second_number[1])
                            && $this->IsCongruent(intval($given_number_second), $second_number, $real_solution_first_number[2])
                            || $this->IsCongruent(intval($given_number_second), $first_number, $real_solution_second_number[1])
                            && $this->IsCongruent(intval($given_number_first), $second_number, $real_solution_first_number[2])
                            && intval($given_number_first) + intval($given_number_second) == $first_number + $second_number;
            }
            
            if($was_correct){
                $this->correct_answer_counter += 1;
            }

            $this->solution_counter += 1;
            $this->SetSessionAnswer("2_0", $given_number_first_raw, $given_number_first, $first_number . " + " . $real_solution_second_number[1] .  "k (k \u{2208} \u{2124})", $was_correct);
            $this->SetSessionAnswer("2_1", $given_number_second_raw, $given_number_second, $second_number . " + " . $real_solution_first_number[2] .  "k (k \u{2208} \u{2124})", $was_correct);
        }

        /**
         * 
         * This private method compares the given answers with the solutions for Discrete mathematics II. subject's 6th topic's tasks related to chinese remainder theorem.
         *  
         * @return void
        */
        private function CheckSixthTaskSolution(){
            // Check first subtask:
            $first_solution = $this->real_solutions["first_crt_solution"]["solution"];
            $this->EvaluateNumberAndCongruence($first_solution[1], $first_solution[2], "solution_0", "0");
            $this->solution_counter += 1;

            // Check second subtasks:
            $real_solution_steps = $this->real_solutions["second_crt_solution"]["steps"];
            for($step_counter = 0; $step_counter < count($real_solution_steps); $step_counter++){
                $real_solution_congruences = $real_solution_steps[$step_counter];
                $congruence = [$real_solution_congruences[1], $real_solution_congruences[2]];
                
                $this->EvaluatePairsOfCongruences($congruence, ["solution_" . "1_" . $step_counter . "_0", "solution_" . "1_" . $step_counter . "_1"],["1_" . $step_counter . "_0", "1_" . $step_counter . "_1"]);
                $this->solution_counter += 1;
            }
        }

        /**
         * 
         * This private method compares the given answers with the solutions for Discrete mathematics II. subject's 7th topic's tasks related to Horner scheme.
         * 
         * @return void
        */
        private function CheckSeventhTaskSolution(){
            $this->real_solutions = array_values($this->real_solutions);

            $quotient_relation = [];
            $residue_relation = [];
            for($subtask_counter = 0; $subtask_counter < 3; $subtask_counter++){
                if($subtask_counter < 2){
                    $horner_table = $this->real_solutions[$subtask_counter];
                }else{
                    $horner_table = $this->real_solutions[$subtask_counter][1];
                    
                    $this->EvaluateInputsWithNumbers($this->real_solutions[$subtask_counter][0][0], "solution_" . $subtask_counter . "_0", $subtask_counter . "_0");
                    $this->solution_counter += 1;
                }

                foreach($horner_table as $row_counter => $row_values){
                    $degree = count($row_values) - 2;
                    foreach($row_values as $cell_counter => $cell_value){
                        $this->EvaluateInputsWithNumbers($cell_value,"solution_" . $subtask_counter . "_" . $row_counter . "_" . $cell_counter, $subtask_counter . "_" . $row_counter . "_" . $cell_counter);            
                        $this->solution_counter += 1;
                        
                        if($subtask_counter === 2 && $degree - $cell_counter >= 0){
                            array_push($quotient_relation, [$cell_value, $degree - $cell_counter]);
                        }else if($subtask_counter === 2 && $degree - $cell_counter < 0){
                            array_push($residue_relation, [$cell_value, 0]);
                        }
                    }
                }
            }

            $this->EvaluateInputsWithRelations($quotient_relation, "solution_2_1", "2_1", true, false, "", "polynomial");  
            $this->EvaluateInputsWithRelations($residue_relation, "solution_2_2", "2_2", true, false, "", "polynomial");  
        }

        /**
         * 
         * This private method compares the given answers with the solutions for Discrete mathematics II. subject's 8th topic's tasks related to polynomial division and multiplication.
         * 
         * @return void
        */
        private function CheckEigthTaskSolution(){
            $real_solutions = array_values($this->real_solutions);

            $this->EvaluateInputsWithRelations($real_solutions[0][0], "solution_0_0", "0_0", true, false, "", "polynomial");
            $this->EvaluateInputsWithRelations($real_solutions[0][1], "solution_0_1", "0_1", true, false, "", "polynomial");
            $this->EvaluateInputsWithRelations($real_solutions[1], "solution_1_0", "1_0", true, false, "", "polynomial");  
            $this->solution_counter += 3;
        }

        /**
         * 
         * This private method compares the given answers with the solutions for Discrete mathematics II. subject's 9th topic's tasks.
         * 
         * @return void
        */
        private function CheckNinethTaskSolution(){
            $base_polynomial_expressions = $this->real_solutions["Lagrange_interpolation"]["base_polynomial_expressions"];
            $lagrange_interpolation_polynomial = $this->real_solutions["Lagrange_interpolation"]["polynomial_expression"];

            $answer_counter = 0;
            foreach($base_polynomial_expressions as $point_counter => $base_polynomial_expression){
                $this->EvaluateInputsWithRelations($base_polynomial_expression, "solution_0_$answer_counter", "0_" . $answer_counter, true, false, "", "polynomial");
                $this->solution_counter += 1;
                $answer_counter++;
            }
            $this->EvaluateInputsWithRelations($lagrange_interpolation_polynomial, "solution_0_$answer_counter", "0_" . $answer_counter, true, false, "", "polynomial");
            $this->solution_counter += 1;

            
            $table_data = $this->real_solutions["Newton_interpolation"]["table_data"];
            foreach($table_data as $column_counter => $column_data){
                foreach($column_data as $row_counter => $cell_data){
                    $id = "1_" . $column_counter . "_" . $row_counter;
                    $this->EvaluateInputsWithNumbers($cell_data, "solution_" . $id, $id);
                    $this->solution_counter += 1;
                }                
            }

            $newton_interpolation_polynomial = $this->real_solutions["Newton_interpolation"]["polynomial_expression"];
            $id = "1_" . count($table_data);
            $this->EvaluateInputsWithRelations($newton_interpolation_polynomial, "solution_" . $id, $id, true, false, "", "polynomial");
            $this->solution_counter += 1;
        }
    }
?>