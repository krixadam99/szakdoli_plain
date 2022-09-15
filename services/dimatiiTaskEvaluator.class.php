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
         * This private method compares the given answers with the solutions for Discrete mathematics II. subject 1st topic's tasks related to division (with whole numbers), congruences and greatest common divisors.
         * 
         * @return void
        */
        private function CheckFirstTaskSolution(){
            $was_correct = false;
            
            // Check first subtask
            $first_solution = $this->real_solutions["divide_pairs_solution"];
            for($first_subtask_counter = 0; $first_subtask_counter < 2; $first_subtask_counter++){
                $given_answer_pair_raw = [$this->given_answers[$first_subtask_counter*2]??"", $this->given_answers[$first_subtask_counter*2 + 1]??""];
                $given_answer_pair = [$this->ExtractSolutionFromInput($given_answer_pair_raw[0])[0],$this->ExtractSolutionFromInput($given_answer_pair_raw[1])[0]];
                
                $was_correct = false;
                if($given_answer_pair == $first_solution[0]){
                    $this->correct_answer_counter += 1;
                    $was_correct = true;
                }
                
                $this->solution_counter += 2;
                $this->SetSessionAnswer("0_$first_subtask_counter" . "_0", $given_answer_pair_raw[0], $given_answer_pair[0], $first_solution[$first_subtask_counter][0], $was_correct);
                $this->SetSessionAnswer("0_$first_subtask_counter" . "_1", $given_answer_pair_raw[1], $given_answer_pair[1], $first_solution[$first_subtask_counter][1], $was_correct);
            }

            // Check second subtask
            $second_solution = $this->real_solutions["prime_factorization_solution"];
            for($second_subtask_counter = 0; $second_subtask_counter < 2; $second_subtask_counter++){
                $given_answer_raw = $this->given_answers[$second_subtask_counter + 4]??"";
                $given_answer_factorization = $this->CreateRelation($this->ExtractSolutionFromInput($given_answer_raw));
                $answer_text = $this->CreatePrintableRelation($given_answer_factorization);
                $solution_text = $this->CreatePrintableRelation($second_solution[$second_subtask_counter]);
                
                $was_correct = false;
                if($this->CompareRelations($given_answer_factorization, $second_solution[$second_subtask_counter])){
                    $this->correct_answer_counter += 1;
                    $was_correct = true;
                }

                $this->solution_counter += 1;
                $this->SetSessionAnswer("1_" . $second_subtask_counter, $given_answer_raw, $answer_text, $solution_text, $was_correct);
            }

            // Check third subtask
            $third_solution = $this->real_solutions["positive_divisor_count_solution"];
            for($third_subtask_counter = 0; $third_subtask_counter < 2; $third_subtask_counter++){
                $given_answer_raw = $this->given_answers[$third_subtask_counter + 6]??"";
                $given_answer_division_count = $this->ExtractSolutionFromInput($given_answer_raw)[0]??"";
                
                $was_correct = false;
                if($given_answer_division_count == $third_solution[$third_subtask_counter]){
                    $this->correct_answer_counter += 1;
                    $was_correct = true;
                }

                $this->solution_counter += 1;
                $this->SetSessionAnswer("2_" . $third_subtask_counter, $given_answer_raw, $given_answer_division_count, $third_solution[$third_subtask_counter], $was_correct);
            }

            // Check fourth subtask
            $fourth_solution = $this->real_solutions["congruence"];
            for($fourth_subtask_counter = 0; $fourth_subtask_counter < 2; $fourth_subtask_counter++){
                $given_answer_raw = $this->given_answers[$fourth_subtask_counter + 8]??"";
                $given_answer_congruence = $this->ExtractSolutionFromInput($given_answer_raw)[0]??"";
                
                $a = $fourth_solution[$fourth_subtask_counter][0];
                $modulo = abs($fourth_solution[$fourth_subtask_counter][1]);
                $solution_text = $a . " + " . $modulo . "k (k \u{2208} \u{2124})";

                $sub = $a - intval($given_answer_congruence);
                while($sub < 0){
                    $sub += $modulo;
                }
                $was_correct = false;
                if($sub % $modulo === 0){
                    $this->correct_answer_counter += 1;
                    $was_correct = true;
                }

                $this->solution_counter += 1;
                $this->SetSessionAnswer("3_" . $fourth_subtask_counter, $given_answer_raw, $given_answer_congruence, $solution_text, $was_correct);
            }

            // Check fifth subtask
        }

        /**
         * 
         * This private method compares the given answers with the solutions for Discrete mathematics II. subject 2nd topic's tasks related to complete and reduced residue systems.
         * 
         * @return void
        */
        private function CheckSecondTaskSolution(){
            // Check first and second subtasks:
            $first_solution = $this->real_solutions["crs_systems"];
            $second_solution = $this->real_solutions["rrs_systems"];
            for($subtask_counter = 0; $subtask_counter < 2; $subtask_counter++){
                $given_answer_raw = $this->given_answers[$subtask_counter]??"";
                $given_answer = $this->ExtractSolutionFromInput($given_answer_raw);
                
                $was_correct = false;
                $solution_text = "";
                if($subtask_counter === 0){
                    $solution_text = $this->CreatePrintableSet($first_solution);
                    $was_correct = $this->CompareSets($given_answer, $first_solution);
                }else{
                    $solution_text = $this->CreatePrintableSet($second_solution);
                    $was_correct = $this->CompareSets($given_answer, $second_solution);
                }
                if($was_correct){
                    $this->correct_answer_counter += 1;
                }

                $this->solution_counter += 1;
                $this->SetSessionAnswer($subtask_counter, $given_answer_raw, $this->CreatePrintableSet($given_answer), $solution_text, $was_correct);
            }

            // Check third subtask:
            $third_solution = $this->real_solutions["rrs_size_numbers"];
            for($third_subtask_counter = 0; $third_subtask_counter < 2; $third_subtask_counter++){
                $given_answer_raw = $this->given_answers[$third_subtask_counter + 2]??"";
                $given_answer_rrs_size = $this->ExtractSolutionFromInput($given_answer_raw)[0]??"";
                
                $was_correct = false;
                if($given_answer_rrs_size == $third_solution[$third_subtask_counter]){
                    $this->correct_answer_counter += 1;
                    $was_correct = true;
                }

                $this->solution_counter += 1;
                $this->SetSessionAnswer("2_" . $third_subtask_counter, $given_answer_raw, $given_answer_rrs_size, $third_solution[$third_subtask_counter], $was_correct);
            }
        }

        /**
         * 
         * This private method compares the given answers with the solutions for Discrete mathematics II. subject 3rd topic's tasks related to eucleidan algorithm.
         * 
         * @return void
        */
        private function CheckThirdTaskSolution(){
            // Check first, second and third subtasks:
            $answer_counter = 0;
            for($subtask_counter = 0; $subtask_counter < 3; $subtask_counter++){
                $solution_steps = $this->real_solutions["eucleidan_algorithm"][$subtask_counter];
                $actual_gcd = $this->real_solutions["gcd"][$subtask_counter];
                $actual_lsm = $this->real_solutions["lcm"][$subtask_counter];
                
                foreach($solution_steps as $step_counter => $step){
                    foreach($step as $substep_counter => $sub_step){
                        if($substep_counter === 1){
                            $multiplicand = $solution_steps[$step_counter][1];
                            $multiplier = $solution_steps[$step_counter][2];
                            $given_answer_raw_multiplicand = $this->given_answers[$answer_counter]??"";
                            $given_answer_raw_multiplier = $this->given_answers[$answer_counter + 1]??"";
                            $given_answer_multiplicand = $this->ExtractSolutionFromInput($given_answer_raw_multiplicand)[0]??"";
                            $given_answer_multpilier = $this->ExtractSolutionFromInput($given_answer_raw_multiplier)[0]??"";
                            
                            $was_correct = false;
                            if($given_answer_multpilier == $multiplicand && $given_answer_multiplicand == $multiplier || $given_answer_multpilier == $multiplier && $given_answer_multiplicand == $multiplicand){
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
                                $multiplicand,
                                $was_correct
                            );

                            $this->solution_counter += 2;
                            $answer_counter += 2;
                        }else if($substep_counter === 0 || $substep_counter === 3){
                            $this->EvaluateInputsWithNumbers($sub_step, $answer_counter, $subtask_counter . "_" . $step_counter . "_" . $substep_counter);

                            $this->solution_counter += 1;
                            $answer_counter++;
                        }
                    }
                    $this->solution_counter += 4;
                }

                for($step_counter = 0; $step_counter < 2; $step_counter++){
                    if($step_counter === 0){
                        $this->EvaluateInputsWithNumbers($actual_gcd, $answer_counter, $subtask_counter . "_" . count($solution_steps) + $step_counter);
                    }else{
                        $this->EvaluateInputsWithNumbers($actual_lsm, $answer_counter, $subtask_counter . "_" . count($solution_steps) + $step_counter);
                    }
                    
                    $this->solution_counter += 1;
                    $answer_counter++;
                }
            }
        }

        /**
         * 
         * This private method compares the given answers with the solutions for Discrete mathematics II. subject 4th topic's tasks related to linear congruences.
         * 
         * @return void
        */
        private function CheckFourthTaskSolution(){
            // Check first, second and third subtasks:
            for($subtask_counter = 0; $subtask_counter < 3; $subtask_counter++){
                $real_solution_pair = $this->real_solutions["solutions"][$subtask_counter];
                $this->EvaluatePairsOfCongruences([$real_solution_pair[1],$real_solution_pair[2]], [$subtask_counter*2, $subtask_counter*2 + 1],[$subtask_counter . "_0", $subtask_counter . "_1"]);
                
                $this->solution_counter += 1;
            }
        }

        /**
         * 
         * This private method compares the given answers with the solutions for Discrete mathematics II. subject 5th topic's tasks related to linear diophantine equations.
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
                    $this->EvaluatePairsOfCongruences($congruence, [$answer_counter, $answer_counter + 1],[$subtask_counter . "_" . $step_counter . "_0", $subtask_counter . "_" . $step_counter . "_1"]);

                    $this->solution_counter += 1;
                    $answer_counter += 2;
                }
            }

            // Check third subtask:
            $given_number_first_raw = $this->given_answers[$answer_counter]??"";
            $given_number_second_raw = $this->given_answers[$answer_counter + 1]??"";
            $given_number_first = $this->ExtractSolutionFromInput($given_number_first_raw)[0]??"";
            $given_number_second = $this->ExtractSolutionFromInput($given_number_second_raw)[0]??"";

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
         * This private method compares the given answers with the solutions for Discrete mathematics II. subject 6th topic's tasks related to chinese remainder theorem.
         *  
         * @return void
        */
        private function CheckSixthTaskSolution(){
            // Check first subtask:
            $first_solution = $this->real_solutions["first_crt_solution"]["solution"];
            $this->EvaluateNumberAndCongruence($first_solution[1], $first_solution[2], 0, "0");
            $this->solution_counter += 1;

            // Check second and third subtasks:
            $answer_counter = 1;
            $real_solution_steps = $this->real_solutions["second_crt_solution"]["steps"];
            for($step_counter = 0; $step_counter < count($real_solution_steps); $step_counter++){
                $real_solution_congruences = $real_solution_steps[$step_counter];
                $congruence = [$real_solution_congruences[1], $real_solution_congruences[2]];
                
                $this->EvaluatePairsOfCongruences($congruence, [$answer_counter, $answer_counter + 1],["1_" . $step_counter . "_0", "1_" . $step_counter . "_1"]);
                $this->solution_counter += 1;
                $answer_counter += 2;
            }
        }

        /**
         * 
         * This private method compares the given answers with the solutions for Discrete mathematics II. subject 7th topic's tasks related to Horner scheme.
         * 
         * @return void
        */
        private function CheckSeventhTaskSolution(){
            $this->real_solutions = array_values($this->real_solutions);
            $answer_counter = 0;
            for($subtask_counter = 0; $subtask_counter < 3; $subtask_counter++){
                if($subtask_counter < 2){
                    $horner_table = $this->real_solutions[$subtask_counter];
                }else{
                    $horner_table = $this->real_solutions[$subtask_counter][1];
                    
                    $this->EvaluateInputsWithNumbers($this->real_solutions[$subtask_counter][0][0], $answer_counter, $subtask_counter . "_0");
                    $this->solution_counter += 1;
                    $answer_counter += 1;
                }

                foreach($horner_table as $row_counter => $row_values){
                    foreach($row_values as $cell_counter => $cell_value){
                        $this->EvaluateInputsWithNumbers($cell_value, $answer_counter, $subtask_counter . "_" . $row_counter . "_" . $cell_counter);            
                        $this->solution_counter += 1;
                        $answer_counter += 1;
                    }
                }
            }
        }

        /**
         * 
         * This private method compares the given answers with the solutions for Discrete mathematics II. subject 8th topic's tasks.
         * 
         * @return void
        */
        private function CheckEigthTaskSolution(){
        }

        /**
         * 
         * This private method compares the given answers with the solutions for Discrete mathematics II. subject 9th topic's tasks.
         * 
         * @return void
        */
        private function CheckNinethTaskSolution(){
        }

        /**
         * 
         * This private method compares the given answers with the solutions for Discrete mathematics II. subject 10th topic's tasks.
         * 
         * @return void
        */
        private function CheckTenthTaskSolution(){
        }

        /**
         * This private method checks if a number is congruent with another one for a given modulo.
         * 
         * @param int $number A whole number, that we want to check if congruent with anohter one.
         * @param int $remainder A whole number, with thich we wish to compare the first number, if they are congruent for the given modulo.
         * @param int $modulo A positive whole number, for which we will compare the first two given arguments if they are congruent, or not.
         * 
         * @return bool Returns if the first two arguments are congruent modulo the third argument, or not.
         */
        private function IsCongruent($number, $remainder, $modulo){
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
         * 
         */
        private function EvaluateInputsWithNumbers($real_value, $answer_counter, $answer_id){
            $given_answer_raw = $this->given_answers[$answer_counter]??"";
            $given_answer = $this->ExtractSolutionFromInput($given_answer_raw)[0]??"";
            
            $was_correct =  $given_answer == $real_value;
            if($was_correct){
                $this->correct_answer_counter += 1;
            }

            $this->SetSessionAnswer($answer_id, $given_answer_raw, $given_answer, $real_value, $was_correct);
        }

        /**
         * 
         */
        private function EvaluateNumberAndCongruence($real_value_residue, $real_value_modulo, $answer_counter, $answer_id){
            $given_number_raw = $this->given_answers[$answer_counter]??"";
            $given_number = $this->ExtractSolutionFromInput($given_number_raw)[0]??"";
            
            $was_correct = $this->IsCongruent(intval($given_number), $real_value_residue, $real_value_modulo);
            if($was_correct){
                $this->correct_answer_counter += 1;
            }

            $this->SetSessionAnswer("0", $given_number_raw, $given_number, $real_value_residue . " + " . $real_value_modulo .  "k (k \u{2208} \u{2124})", $was_correct);
        }

        /**
         * 
         */
        private function EvaluatePairsOfCongruences($congruence, $answer_counters, $answer_ids){
            $given_answer_pair_raw = [$this->given_answers[$answer_counters[0]]??"", $this->given_answers[$answer_counters[1]]??""];
            $given_answer_pair = [$this->ExtractSolutionFromInput($given_answer_pair_raw[0])[0]??"",$this->ExtractSolutionFromInput($given_answer_pair_raw[1])[0]??""];
                
            $was_correct_modulo = $given_answer_pair[1] == $congruence[1] && is_numeric($congruence[1]) && is_numeric($given_answer_pair[1]);
            $was_correct_residue = $this->IsCongruent(intval($given_answer_pair[0]), $congruence[0], $congruence[1]) && is_numeric($given_answer_pair[0]);
            if($was_correct_residue && $was_correct_modulo){
                $this->correct_answer_counter += 1;
            }
            
            $this->SetSessionAnswer($answer_ids[0], $given_answer_pair_raw[0], $given_answer_pair[0], $congruence[0], $was_correct_residue);
            $this->SetSessionAnswer($answer_ids[1], $given_answer_pair_raw[1], $given_answer_pair[1], $congruence[1], $was_correct_modulo);
        }

        /**
         * 
         */
        private function EvaluateInputsWithSets($real_value, $answer_counter, $answer_id){
        }

        /**
         * 
         */
        private function EvaluateInputsWithRelations($real_value, $answer_counter, $answer_id){
        }
    }
?>