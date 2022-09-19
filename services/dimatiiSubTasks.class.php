<?php

    class DimatiiSubTasks {
        private $dimat_helper_functions;

        /**
         * 
         * The contructor for DimatiiSubTasks class.
         * 
         * @return void
         */
        public function __construct(){
            $this->dimat_helper_functions = new DimatiiHelperFunctions();
        }
        
        /**
         * This public method will create division pairs for for the first subtask of the first task of Discrete Mathematics II.
         * 
         * @param int $number_of_pairs The number of pairs which is a positive whole number.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        public function CreateDivisionPairsSubtask($number_of_pairs){
            $division_pairs = $this->dimat_helper_functions->CreatePairsOfNumbers($number_of_pairs, -1000, 1000);
            $task_description = "Add meg a következő osztások eredményét az egész számok körében!\n";
            $solutions = $this->dimat_helper_functions->DetermineQuotientAndResidue($division_pairs);
            $task_solution = "Megoldás:\n";
            
            for($division_counter = 0; $division_counter < $number_of_pairs; $division_counter++){
                $task_description = $task_description . "<label class=\"task_description\">". $division_pairs[$division_counter][0] . "/" . $division_pairs[$division_counter][1] . "</label>";
                $task_solution = $task_solution . "<label class=\"task_solution\">". $division_pairs[$division_counter][0] . " = " . $solutions[$division_counter][0] . " * " . $division_pairs[$division_counter][1] . " + " . $solutions[$division_counter][1] . "</label>";
                
                if($division_counter !== count($division_pairs) - 1){
                    $task_description = $task_description . "\n";
                    $task_solution = $task_solution . "\n";
                }
            }
            
            return array("data" => $division_pairs , "task_text" => $task_description, "solution" => $solutions, "solution_text" => $task_solution);
        }

        /**
         * This public method will create distinct numbers for the second subtask of the first task of Discrete Mathematics II.
         * 
         * @param int $number_of_numbers The number of numbers which is a positive whole number.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        public function CreatePrimeFactorizationSubtask($number_of_numbers){
            $prime_factorization_numbers = $this->dimat_helper_functions->CreateDistinctNumbers($number_of_numbers, 100, 1000);
            $solutions = $this->dimat_helper_functions->DeterminePrimeFactorization($prime_factorization_numbers);
            $task_solution = "Megoldás:\n";
            $task_description = "Add meg a következő számok prímfelbontását!\n";

            for($index = 0; $index < $number_of_numbers; $index++){
                $task_description = $task_description . "<label class=\"task_description\">". $prime_factorization_numbers[$index] . " prímfelbontása" . "</label>";
                
                $number = intval($prime_factorization_numbers[$index]);
                $actual_text = "<table class=\"prime_factorization_table\">";
                foreach($solutions[$index] as $factor_index => $factor){
                    for($exp_counter = 0; $exp_counter < $factor[1]; $exp_counter++){
                        $actual_text = $actual_text . "<tr><td>" . $number . "</td><td>". $factor[0] . "</td></tr>";
                        $number /= intval($factor[0]);
                    }
                }
                $actual_text = $actual_text . "</table>";
                $task_solution = $task_solution . $actual_text;
                
                if($index !== count($prime_factorization_numbers) - 1){
                    $task_description = $task_description . "\n";
                    $task_solution = $task_solution . "\n";
                }
            }
            
            return array("data" => $prime_factorization_numbers , "task_text" => $task_description, "solution" => $solutions, "solution_text" => $task_solution);
        }

        /**
         * This public method will create distinct numbers for the third subtask of the first task of Discrete Mathematics II.
         * 
         * @param int $number_of_numbers The number of numbers which is a positive whole number.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        public function CreateDivisorCountSubtask($number_of_numbers){
            $positive_divisor_count_numbers = $this->dimat_helper_functions->CreateDistinctNumbers($number_of_numbers, 100, 1000);
            $prima_factorizations = $this->dimat_helper_functions->DeterminePrimeFactorization($positive_divisor_count_numbers);
            $solutions = $this->dimat_helper_functions->DetermineNumberOfDivisors($positive_divisor_count_numbers);
            $task_solution = "Megoldás:\n";
            $task_description = "Add meg a következő számok osztóinak számát!\n";

            for($index = 0; $index < $number_of_numbers; $index++){
                $task_description = $task_description . "<label class=\"task_description\">d(". $positive_divisor_count_numbers[$index] . ") = " . "</label>";
                
                $number = intval($positive_divisor_count_numbers[$index]);
                $actual_text = "<table class=\"prime_factorization_table\">";
                $multplication_form = "";
                $exponential_form = "";
                foreach($prima_factorizations[$index] as $factor_index => $factor){
                    for($exp_counter = 0; $exp_counter < $factor[1]; $exp_counter++){
                        $actual_text = $actual_text . "<tr><td>" . $number . "</td><td>". $factor[0] . "</td></tr>";
                        $number /= intval($factor[0]);
                    }

                    if($factor_index !== 0){
                        $multplication_form = $multplication_form . " * ";
                        $exponential_form = $exponential_form . " * ";
                    }
                    $exponential_form = $exponential_form . "( " . $factor[1] ." + 1)";
                    $multplication_form = $multplication_form . $factor[0] . "<span class=\"exp\">" . $factor[1] . "</span>";
                }
                $actual_text = $actual_text . "</table>";
                $task_solution = $task_solution . $actual_text . "<label>d(" 
                    . $positive_divisor_count_numbers[$index] . ") = "
                    . $multplication_form . " = " . $exponential_form . " = "
                    . $solutions[$index] . "</label>";
                
                if($index !== count($positive_divisor_count_numbers) - 1){
                    $task_description = $task_description . "\n";
                    $task_solution = $task_solution . "\n";
                }
            }
            
            return array("data" => $positive_divisor_count_numbers , "task_text" => $task_description, "solution" => $solutions, "solution_text" => $task_solution);
        }

        /**
         * This public method will create distinct pair of numbers for the fourth subtask of the first task of Discrete Mathematics II.
         * 
         * @param int $number_of_numbers The number of pairs which is a positive whole number.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        public function CreateCongruentNumbersSubtask($number_of_pairs){
            $congruences = $this->dimat_helper_functions->CreatePairsOfNumbers($number_of_pairs, -1000, 1000, false, true);
            $task_solution = "Megoldás:\n";
            $task_description = "Adj meg a következő kongruenciák esetén olyan számot, amellyel igaz állítást kapsz!\n";

            for($index = 0; $index < $number_of_pairs; $index++){
                $task_description = $task_description . "<label class=\"task_description\">". $congruences[$index][0] . " \u{2261} x (mod " . $congruences[$index][1] . ")</label>";
                $task_solution = $task_solution . "<label class=\"task_solutionn\">". 
                    $congruences[$index][0] . " \u{2261} x (mod " . $congruences[$index][1] . ") \u{2194} " .
                    $congruences[$index][1] . " \u{2223} ". $congruences[$index][0] . " - x" . " \u{2194} " . 
                    "x = " . $congruences[$index][0] . " + " . $congruences[$index][1] . "*k (k \u{2208} \u{2124})</label>";
                
                if($index !== count($congruences) - 1){
                    $task_description = $task_description . "\n";
                    $task_solution = $task_solution . "\n";
                }
            }
            
            return array("data" => $congruences , "task_text" => $task_description, "solution" => $task_solution, "solution_text" => $task_solution);
        }

        /**
         * This public method will create distinct numbers for the first subtask of the second task of Discrete Mathematics II.
         * 
         * @param int $number_of_numbers The number of numbers which is a positive whole number.
         * @param int $lower The lower bound of the range from which the modulos will be picked randomly. The default value is 2.
         * @param int $upper The upper bound of the range from which the modulos will be picked randomly. The default value is 25.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        public function CreateCompleteResidueSystemSubtask($number_of_numbers, $lower = 2, $upper = 25){
            $modulos = $this->dimat_helper_functions->CreateDistinctNumbers($number_of_numbers, $lower, $upper);
            $solutions = [];
            $task_solution = "Megoldás:\n";
            $task_description = "Adjad meg a következő teljes maradékrendszerek maradékosztályait azok 1-1 reprezentatív elemének megadásával!\n";

            for($index = 0; $index < $number_of_numbers; $index++){
                $task_description = $task_description . "<label class=\"task_description\">\u{2124}/<span class=\"bottom\">". $modulos[$index] . "</span>\u{2124}</label>";
                $solution = $this->dimat_helper_functions->DetermineCompleteResidueSystem($modulos[$index]);
                array_push($solutions, $solution);

                $set= "";
                foreach($solution as $counter => $representative_element){
                    if($counter !== 0){
                        $set = $set . ", ";
                    }
                    $set = $set . "<label class=\"task_solutionn\" style=\"border-top:1px solid black\">". $representative_element . "</label>"; 
                }
                $task_solution = $task_solution . "{" . $set . "}";

                if($index !== count($modulos) - 1){
                    $task_description = $task_description . "\n";
                    $task_solution = $task_solution . "\n";
                }
            }
            
            return array("data" => $modulos , "task_text" => $task_description, "solution" => $solutions, "solution_text" => $task_solution);
        }

        /**
         * This public method will create distinct numbers for the second subtask of the second task of Discrete Mathematics II.
         * 
         * The subtask is about giving the residue classes by representative elements of the created reduced residue systems.
         * 
         * @param int $number_of_numbers The number of numbers which is a positive whole number.
         * @param int $lower The lower bound of the range from which the modulos will be picked randomly. The default value is 2.
         * @param int $upper The upper bound of the range from which the modulos will be picked randomly. The default value is 15.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        public function CreateReducedResidueSystemSubtask($number_of_numbers, $lower = 2, $upper = 15){
            $modulos = $this->dimat_helper_functions->CreateDistinctNumbers($number_of_numbers, $lower, $upper);
            $solutions = [];
            $task_solution = "Megoldás:\n";
            $task_description = "Adjad meg a következő redukált maradékrendszerek maradékosztályait azok 1-1 reprezentatív elemének megadásával!\n";

            for($index = 0; $index < $number_of_numbers; $index++){
                $task_description = $task_description . "<label class=\"task_description\">(\u{2124}/<span class=\"bottom\">". $modulos[$index] . "</span>\u{2124})*</label>";
                $solution = $this->dimat_helper_functions->DetermineReducedResidueSystem($modulos[$index]);
                array_push($solutions, $solution);

                $set= "";
                foreach($solution as $counter => $representative_element){
                    if($counter !== 0){
                        $set = $set . ", ";
                    }
                    $set = $set . "<label class=\"task_solutionn\" style=\"border-top:1px solid black\">". $representative_element . "</label>"; 
                }
                $task_solution = $task_solution . "{" . $set . "}";

                if($index !== count($modulos) - 1){
                    $task_description = $task_description . "\n";
                    $task_solution = $task_solution . "\n";
                }
            }
            
            return array("data" => $modulos , "task_text" => $task_description, "solution" => $solutions, "solution_text" => $task_solution);
        }

        /**
         * This public method will create distinct numbers for the third subtask of the second task of Discrete Mathematics II.
         * 
         * The subtask is about giving the size of a reduced residue systems by the Euler's phi function.
         * 
         * @param int $number_of_numbers The number of numbers which is a positive whole number.
         * @param int $lower The lower bound of the range from which the modulos will be picked randomly. The default value is 2.
         * @param int $upper The upper bound of the range from which the modulos will be picked randomly. The default value is 15.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        public function CreateEulerPhiFunctionSubtask($number_of_numbers, $lower = 1000, $upper = 5000){
            $modulos = $this->dimat_helper_functions->CreateDistinctNumbers($number_of_numbers, $lower, $upper);
            $solutions = [];
            $task_solution = "Megoldás:\n";
            $task_description = "Adjad meg a következő redukált maradékrendszerek maradékosztályait azok 1-1 reprezentatív elemének megadásával!\n";

            for($index = 0; $index < $number_of_numbers; $index++){
                $task_description = $task_description . "<label class=\"task_description\">|(\u{2124}/<span class=\"bottom\">". $modulos[$index] . "</span>\u{2124})|*</label>";
                $solution = $this->dimat_helper_functions->DetermineEulerPhiValue($modulos[$index]);
                array_push($solutions, $solution["solution"]);
                
                $phi_part = "";
                $multiplication_part = "";
                foreach($solution["prime_factorization"] as $pair_counter => $factor){
                    if($pair_counter !== 0){
                        $phi_part = $phi_part . " * ";
                        $multiplication_part = $multiplication_part . " * ";
                    }
                    $phi_part = $phi_part . "\u{03C6}(" . $factor[0] . "<span class=\"exp\">" . $factor[1] . "</span>)"; 
                    $multiplication_part = $multiplication_part . $factor[0] . "<span class=\"exp\">(" . $factor[1] - 1 . ")</span> * (" .  $factor[0] . " - 1)"; 
                }
                $task_solution = $task_solution . "<label class=\"task_solution\">|(\u{2124}/<span class=\"bottom\">".
                                 $modulos[$index] . "</span>\u{2124})|* = ". 
                                 $phi_part . " = " .
                                 $multiplication_part . " = " .
                                 $solution["solution"]  . "</label>";

                if($index !== count($modulos) - 1){
                    $task_description = $task_description . "\n";
                    $task_solution = $task_solution . "\n";
                }
            }
            
            return array("data" => $modulos , "task_text" => $task_description, "solution" => $solutions, "solution_text" => $task_solution);
        }

        /**
         * This public method will create pairs of numbers for the first subtask of the third task of Discrete Mathematics II.
         * 
         * The subtask is about giving the gcd for each pair with the Eucleidan algorithm. Additionally, the lcm for these pairs will also be determined.
         * 
         * @param int $number_of_numbers The number of numbers which is a positive whole number.
         * @param int $lower The lower bound of the range from which the pairs will be picked randomly. The default value is 30.
         * @param int $upper The upper bound of the range from which the pairs will be picked randomly. The default value is 200.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        public function CreateEucleidanAlgorithmSubtask($number_of_numbers, $lower = 30, $upper = 200){
            $gcd_pairs = $this->dimat_helper_functions->CreatePairsOfNumbers($number_of_numbers, $lower, $upper);
            $task_solution = "Megoldás:\n";
            $task_description = "Adjad meg a következő párok esetén a legnagyobb közös osztót és a legkisebb közös többszöröst!\n";

            $eucleidan_algorithm = [];
            $gcd_array = [];
            $lcm_array = [];
            foreach($gcd_pairs as $index => $pair){
                $algorithm = $this->dimat_helper_functions->DetermineGCDWithEucleidan($pair);
                array_push($eucleidan_algorithm, $algorithm["steps"]);
                array_push($gcd_array, $algorithm["solution"]);
                if($algorithm["solution"] !== 0){
                    array_push($lcm_array, ($pair[0]*$pair[1])/$algorithm["solution"]);
                }else{
                    array_push($lcm_array, "inf");
                }
            }

            for($index = 0; $index < count($gcd_pairs); $index++){
                $actual_gcd = $gcd_array[$index];
                $actual_lcm = $lcm_array[$index];
                $actual_steps = $eucleidan_algorithm[$index];
                $first_number = $gcd_pairs[$index][0];
                $second_number = $gcd_pairs[$index][1];

                $task_description = $task_description . "<label class=\"task_description\">(" . $first_number . ", " . $second_number . ")</label>";
                $task_solution = $task_solution . "<table class=\"eucleidan_solution_table\">";
                $task_solution = $task_solution . "<tr><td>i</td><td>r<span class=\"bottom\">i-2</span><td>=</td><td>q<span class=\"bottom\">i</span></td><td> * </td><td>r<span class=\"bottom\">i-1</span><td>+</td><td>r<span class=\"bottom\">i</span></td></tr>";
                foreach($actual_steps as $step_counter => $actual_step){
                    $task_solution = $task_solution . "<tr><td>" . $step_counter + 1 . ".</td><td>" . $actual_step[0] .  "</td><td>=</td><td>" . $actual_step[1] . "</td><td>*</td><td>" . $actual_step[2] . "</td><td>+</td><td>" . $actual_step[3] .  "</td></tr>";
                }
                $task_solution = $task_solution . "</table>";
                $task_solution = $task_solution . "<label class=\"task_solution\">LNKO(" . $first_number . ", " . $second_number . ") = " . $actual_gcd . "</label><br>";
                $task_solution = $task_solution . "<label class=\"task_solution\">LKKT(" . $first_number . ", " . $second_number . ") = " . $first_number  . " * " . $second_number . "/ " . $actual_gcd  . " = " . $actual_lcm . "</label>";


                if($index !== count($gcd_pairs) - 1){
                    $task_description = $task_description . "\n";
                    $task_solution = $task_solution . "\n";
                }
            }
            
            return array("data" => $gcd_pairs , "task_text" => $task_description, "solution" => [$eucleidan_algorithm, $gcd_array, $lcm_array], "solution_text" => $task_solution);
        }

        /**
         * This public method will create triplets of numbers for the first subtask of the fourth task of Discrete Mathematics II.
         * 
         * The subtask is about giving the solution of a linear congruence.
         * 
         * @param int $number_of_numbers The number of numbers which is a positive whole number.
         * @param int $lower The lower bound of the range from which the triplets will be picked randomly. The default value is -30.
         * @param int $upper The upper bound of the range from which the triplets will be picked randomly. The default value is 30.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        public function CreateLinearCongruenceSubtask($number_of_triplets, $lower = -30, $upper = 30){
            $triplets = $this->dimat_helper_functions->CreateSolvableLinearCongruences($number_of_triplets, true, $lower, $upper);
            $task_solution = "Megoldás:\n";
            $task_description = "Adjad meg a következő lineáris kongruenciák megoldását!\n";

            $linear_congrences_algorithm = [];
            $solutions = [];
            foreach($triplets as $index => $triplet){
                $algorithm = $this->dimat_helper_functions->DetermineLinearCongruenceSolution($triplet);
                array_push($linear_congrences_algorithm, $algorithm["steps"]);
                array_push($solutions, $algorithm["solution"]);
            }

            for($index = 0; $index < count($triplets); $index++){
                $actual_solution = $triplets[$index];
                $actual_steps = $linear_congrences_algorithm[$index];
                $first_number = $triplets[$index][0];
                $second_number = $triplets[$index][1];
                $third_number = $triplets[$index][2];

                $task_description = $task_description . "<label class=\"task_description\">" . $first_number . "*x \u{2261} " . $second_number . " mod(" . $third_number . ")</label>";
                
                for($step_counter = 0; $step_counter < count($actual_steps) - 1; $step_counter++){
                    $previous_step = $actual_steps[$step_counter];
                    $next_step = $actual_steps[$step_counter + 1];
                    
                    $previous_a = $previous_step[0];
                    $previous_b = $previous_step[1];
                    $previous_mod = $previous_step[2];
                    $helper_previous_a = $previous_step[3];
                    $helper_previous_b = $previous_step[4];
                    $helper_previous_mod = $previous_step[2];
                    $new_a = $next_step[0];
                    $new_b = $next_step[1];
                    $new_mod = $next_step[2];
                    $helper_new_a = $next_step[3];
                    $helper_new_b = $next_step[4];
                    $helper_new_mod = $next_step[2];

                    if($previous_a >= $helper_previous_a){
                        $task_solution = $task_solution . 
                            "<label class=\"task_solution\">" . $previous_a . "*x \u{2261} " . $previous_b . " mod(" . $previous_mod . ") - " . 
                            $helper_previous_a . "*x \u{2261} " . $helper_previous_b . " mod(" . $helper_previous_mod . ") \u{2192} " . 
                            $new_a . "*x \u{2261} " . $new_b . " mod(" . $new_mod . ");   " . 
                            $helper_new_a . "*x \u{2261} " . $helper_new_b . " mod(" . $helper_new_mod . ")</label><br>";
                    }else{
                        $task_solution = $task_solution . 
                            "<label class=\"task_solution\">" . $helper_previous_a . "*x \u{2261} " . $helper_previous_b . " mod(" . $helper_previous_mod . ") - " . 
                            $previous_a . "*x \u{2261} " . $previous_b . " mod(" . $previous_mod . ") \u{2192} " . 
                            $helper_new_a . "*x \u{2261} " . $helper_new_b . " mod(" . $helper_new_mod . ");   " . 
                            $new_a . "*x \u{2261} " . $new_b . " mod(" . $new_mod . ")</label><br>";
                    }

                    if($new_a == 1 || $new_a == 0 || $helper_new_a == 1 || $helper_new_a == 0){
                        break;
                    }
                }
                
                $final_step = $actual_steps[count($actual_steps) - 1];
                if($final_step[0] === 0){
                    $final_a = $final_step[3];
                    $final_b = $final_step[4];

                }else{
                    $final_a = $final_step[0];
                    $final_b = $final_step[1];
                }
                $final_modulo = $final_step[2];
                $final_modulo = $final_modulo / $this->dimat_helper_functions->DetermineGCDWithIteration([$final_modulo, $final_a]);
                $final_b /= $final_a;
                if($final_b < 0){
                    while($final_b <= 0){
                        $final_b += $final_modulo;
                    }
                }else{
                    while($final_b - $final_modulo >= 0){
                        $final_b -= $final_modulo;
                    }
                }
                
                $task_solution =  $task_solution . $this->CreateModuloEquivalence("x", $final_b, $final_modulo, "Végeredmény:");


                if($index !== count($triplets) - 1){
                    $task_description = $task_description . "\n";
                    $task_solution = $task_solution . "\n";
                }
            }
            
            return array("data" => $triplets , "task_text" => $task_description, "solution" => [$linear_congrences_algorithm, $solutions], "solution_text" => $task_solution);
        }

        /**
         * This public method will create triplets of numbers, solution, task and solution texts for the first subtask of the fifth task of Discrete Mathematics II.
         * 
         * The subtask is about giving the solution of diophantine equations.
         * 
         * @param int $number_of_numbers The number of numbers which is a positive whole number.
         * @param int $lower The lower bound of the range from which the triplets will be picked randomly. The default value is -50.
         * @param int $upper The upper bound of the range from which the triplets will be picked randomly. The default value is 50.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        public function CreateDiophantineEquationSubtask($number_of_triplets, $lower = -50, $upper = 50){
            $triplets = $this->dimat_helper_functions->CreateSolvableLinearCongruences($number_of_triplets, true, $lower, $upper);
            $task_solution = "";
            $task_description = "";

            $diophantine_algorithm = [];
            $diophantine_solutions = [];
            $diophantine_equations = [];
            foreach($triplets as $equation_counter => $triplet){
                // Triplet in the form of $triplet[0]*x \equiv $triplet[1] (mod $triplet[2]) -> $triplet[0]*x - $triplet[1] = $triplet[2]*y
                // Equation in the form of $triplet[0]*x + $triplet[2]*y = $triplet[1]
                $actual_diophantine_equation = [$triplet[0], $triplet[2], $triplet[1]];
                $algorithm_steps = $this->dimat_helper_functions->DetermineDiophantineEquationSolution($actual_diophantine_equation);
                array_push($diophantine_algorithm, $algorithm_steps["steps"]);
                array_push($diophantine_solutions, $algorithm_steps["solution"]);
                array_push($diophantine_equations, $actual_diophantine_equation);
            }

            for($index = 0; $index < count($triplets); $index++){
                $diophantine_equation = $diophantine_equations[$index];
                $steps = $diophantine_algorithm[$index];
                $solution = $diophantine_solutions[$index];
                
                $task_description = $task_description . "<label class=\"task_description\"> Add meg a " . $diophantine_equation[0] . " * x " . $this->PlusMinus($diophantine_equation[1]) . abs($diophantine_equation[1]) . " * y = " . $diophantine_equation[2] . " lineáris diofantikus egyenlet megoldását!</label>";
                $task_solution = $task_solution . $this->CreateDiophantineSolutionText("x", "y", $diophantine_equation, $steps, $solution);

                if($index !== count($triplets) - 1){
                    $task_description = $task_description . "\n";
                    $task_solution = $task_solution . "\n";
                }
            }
            
            return array("data" => $diophantine_equations , "task_text" => $task_description, "solution" => $diophantine_solutions, "solution_text" => $task_solution);
        }

        /**
         * This public method will create triplets of numbers, solution, task and solution texts for the second subtask of the fifth task of Discrete Mathematics II.
         * 
         * The subtask is about giving the solution for a number division, where the numbers have conditions dividorwise.
         * 
         * @param int $number_of_numbers The number of numbers which is a positive whole number.
         * @param int $lower The lower bound of the range from which the triplets will be picked randomly. The default value is -50.
         * @param int $upper The upper bound of the range from which the triplets will be picked randomly. The default value is 50.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        public function CreateNumberDivisionWithConditionsSubtask($number_of_triplets){
            $triplets = [];
            $task_solution = "";
            $task_description = "";

            for($counter = 0; $counter < $number_of_triplets; $counter++){
                $b = mt_rand(200,1000);
                $c = mt_rand(2, 100);
                $a = mt_rand(2, 100);
                while($a === $c 
                    || $b % $this->dimat_helper_functions->DetermineGCDWithIteration([$a,$c]) !== 0
                    || in_array([$a,$b,$c], $triplets)){
                    $c = mt_rand(2, 100);
                    $a = mt_rand(2, 100);
                }
                array_push($triplets, [$a,$b,$c]);
            }

            $diophantine_algorithm = [];
            $diophantine_solutions = [];
            $diophantine_equations = [];
            foreach($triplets as $equation_counter => $triplet){
                // Triplet in the form of $triplet[0]*x \equiv $triplet[1] (mod $triplet[2]) -> $triplet[0]*x - $triplet[1] = $triplet[2]*y
                // Equation in the form of $triplet[0]*x + $triplet[2]*y = $triplet[1]
                $actual_diophantine_equation = [$triplet[0], $triplet[2], $triplet[1]];
                $algorithm_steps = $this->dimat_helper_functions->DetermineDiophantineEquationSolution($actual_diophantine_equation);
                array_push($diophantine_algorithm, $algorithm_steps["steps"]);
                array_push($diophantine_solutions, $algorithm_steps["solution"]);
                array_push($diophantine_equations, $actual_diophantine_equation);
            }

            for($index = 0; $index < count($triplets); $index++){
                $diophantine_equation = $diophantine_equations[$index];
                $steps = $diophantine_algorithm[$index];
                $solution = $diophantine_solutions[$index];
                $task_description = $task_description . "<label class=\"task_description\"> Bontsd fel a " . $diophantine_equation[2] . " számot úgy két szám összegére, hogy az egyik osztható " . $diophantine_equation[0] . " , a másik pedig a " . $diophantine_equation[1] . " számmal!</label>";
                $task_solution = $task_solution .  $this->CreateDiophantineSolutionText("x", "y", $diophantine_equation, $steps, $solution);
                $task_solution = $task_solution . "Az első szám így: x * " .  $diophantine_equation[0]  .  ", a második szám pedig: y * " .  $diophantine_equation[1] . " (például:" . $diophantine_equation[0]*$solution[0][1] . " és " . $diophantine_equation[1]*$solution[1][0] . ")<br>";
                
                if($index !== count($triplets) - 1){
                    $task_description = $task_description . "\n";
                    $task_solution = $task_solution . "\n";
                }
            }
            
            return array("data" => $diophantine_equations , "task_text" => $task_description, "solution" => $diophantine_solutions, "solution_text" => $task_solution);
        }

        /**
         * This public method will create linear congruence systems, solution, task and solution texts for the first subtask of the sixth task of Discrete Mathematics II.
         * 
         * The subtask is about giving the solution for congruence systems.
         * 
         * @param int $number_of_congruence_systems The number of congruence systems which is a positive whole number. The default value is 1.
         * @param int $number_of_congruences_per_system The number of congruences per system which is a positive whole number. The default value is 3.
         * @param int $lower The lower bound of the range from which the triplets representing congruences will be picked randomly. The default value is -50.
         * @param int $upper The upper bound of the range from which the triplets representing congruences will be picked randomly. The default value is 50.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        public function CreateCRTSubtask($number_of_congruence_systems = 1, $number_of_congruences_per_system = 3, $lower = -50, $upper = 50){
            $congruence_systems = [];
            $solutions = [];
            $task_solution = "";
            $task_description = "";

            for($counter = 0; $counter < $number_of_congruence_systems; $counter++){
                $new_congruence_system = $this->dimat_helper_functions->CreateSolvableLinearCongruencesForCRT($number_of_congruences_per_system, $lower, $upper);
                while(in_array($new_congruence_system, $congruence_systems)){
                    $new_congruence_system = $this->dimat_helper_functions->CreateSolvableLinearCongruencesForCRT($number_of_congruences_per_system, $lower, $upper);
                }
                array_push($congruence_systems, $new_congruence_system);
                
                $actual_solution = $this->dimat_helper_functions->DetermineLinearCongruenceSystemSolution($new_congruence_system);
                array_push($solutions, $actual_solution);
                $steps = $actual_solution["steps"];
                $detailed_steps = $actual_solution["detailed_steps"];
                
                $task_description = $task_description . "<label class=\"task_description\"> Add meg a következő lineáris kongruenciarendszer megoldását!</label><br>";
                $task_solution = $task_solution . "<b>1. lépés: lineáris kongruenciák egyszerűsítése</b><br>";
                for($coungruence_counter = 0; $coungruence_counter < count($new_congruence_system); $coungruence_counter++){
                    $task_description = $task_description . "<label class=\"task_description\">" . $this->CreateCongruenceText("x", $new_congruence_system[$coungruence_counter]) . "</label><br>";
                    $task_solution = $task_solution . $coungruence_counter + 1 . ". lineáris kongruencia megoldása:<br>" . $this->CreateCongruenceSolutionText("x", $detailed_steps[$coungruence_counter]) . "<br>";
                }

                $merged_counter = 0;
                for($congruence_counter = 0; $congruence_counter < $number_of_congruences_per_system;){
                    if($congruence_counter === 0){
                        $task_solution = $task_solution . "<div class=\"paragraph\"><b>2. lépés: 1. és 2. kongruencia egyesítése</b></div>";
                        $first_congruence = $steps[0];
                        $second_congruence = $steps[1];
                        $congruence_counter += 2;
                    }else{
                        $task_solution = $task_solution . "<div class=\"paragraph\"><b>" . $congruence_counter + 1 . ". lépés: 1. - $congruence_counter. és " .  $congruence_counter + 1  . ". kongruencia egyesítése:</b></div>";
                        $first_congruence = $steps[$number_of_congruences_per_system + $merged_counter];
                        $second_congruence = $steps[$congruence_counter];
                        $congruence_counter++;
                        $merged_counter++;
                    }
                    $task_solution = $task_solution . "<div class=\"paragraph\">";
                    $task_solution = $task_solution . $this->CreateCongruenceText("x", $first_congruence) . "<br>";
                    $task_solution = $task_solution . $this->CreateCongruenceText("x", $second_congruence) . "<br>";
                    $task_solution = $task_solution . "</div>";
                    
                    $diophantine_equation_solution = $detailed_steps[$coungruence_counter + $merged_counter];
                    $task_solution = $task_solution . "<div class=\"paragraph\"><b>" . $merged_counter + 2 . ".1. lépés: az m<span class=\"bottom\">" . $merged_counter + 1 . ",1</span> * " .  $first_congruence[2] . " + m<span class=\"bottom\">" . $merged_counter + 1 . ",2</span> * " . $second_congruence[2] . " = 1 lineáris diofantikus egyenlet megoldása:</b></div>";
                    $task_solution = $task_solution .  $this->CreateDiophantineSolutionText("m<span class=\"bottom\">" . $merged_counter + 1 . ",1</span>", "m<span class=\"bottom\">" . $merged_counter + 1 . ",2</span>", [$first_congruence[2],$second_congruence[2], 1], $diophantine_equation_solution["steps"],  $diophantine_equation_solution["solution"]);
                    $task_solution = $task_solution . $this->CreateCongruenceText("x", $steps[$number_of_congruences_per_system + $merged_counter]) . "<br>";
                }

                if($counter < $number_of_congruence_systems - 1){
                    $task_description = $task_description . "\n";
                    $task_solution = $task_solution . "\n";
                }
            }
            
            return array("data" => $congruence_systems , "task_text" => $task_description, "solution" => $solutions, "solution_text" => $task_solution);
        }

        /**
         * This private method append a congruence equivalence to the end of a text.
         */
        private function CreateModuloEquivalence($variable_name, $final_b, $final_modulo, $text){
            return "<label class=\"task_solution\">$text" . " $variable_name \u{2261} " . $final_b . " (mod " . $final_modulo . ") \u{2194} " 
                                . $final_modulo . "\u{2223}  $variable_name" . $this->PlusMinus($final_b) . abs($final_b) . " \u{2194} "
                                . "<b>$variable_name = " . $final_b . $this->PlusMinus($final_modulo) . abs($final_modulo) . "*k (k \u{2208} \u{2124})</b></label><br>";
        }

        /**
         * This private method returns a plus, or minus based on the argument's sign.
         */
        private function PlusMinus($value){
            return $value < 0?" - ":" + ";
        }

        /**
         * 
         */
        private function CreateCongruenceText($variable_name = "x", $congruence){
            return  $congruence[0] . "*$variable_name \u{2261} " . $congruence[1] . " (mod " .  $congruence[2] . ")";
        }

        /**
         * 
         */
        private function CreateCongruenceSolutionText($variable_name = "x", $congruence_steps){
            $task_solution = "";
            foreach($congruence_steps as $step_counter => $step){
                $task_solution = $task_solution . "<label class=\"task_solution\">" . $step[0] . "*$variable_name \u{2261} " . $step[1] . " (mod " .  $step[2] . ")</label><br>";
            }
            return $task_solution;
        }

        /**
         * This private method creates the solution text for diophantine equations.
         */
        private function CreateDiophantineSolutionText($first_variable_name = "x", $second_variable_name = "y", $diophantine_equation, $steps, $solution){
            $task_solution = "";
            
            $y_coef_sign = $this->PlusMinus($diophantine_equation[1]);
            $x_coef_sign = $this->PlusMinus(-1*$diophantine_equation[0]);
            $diophantine_equation[1] = abs($diophantine_equation[1]);
            $task_solution = $task_solution . "<div class=\"paragraph\">" . $diophantine_equation[0] . "*$first_variable_name" . $this->PlusMinus($diophantine_equation[1]) . $diophantine_equation[1] . "*$second_variable_name = " . $diophantine_equation[2] . " | -1*" . $diophantine_equation[1] . "*$second_variable_name \u{2194} <br>" 
                . $diophantine_equation[0] . "*$first_variable_name = "  . $diophantine_equation[2] . $this->PlusMinus(-1*$diophantine_equation[1]) . $diophantine_equation[1] . "*$second_variable_name " . " | (mod" . $diophantine_equation[1] . ") \u{2192} <br>";
            $task_solution = $task_solution . $this->CreateCongruenceSolutionText($first_variable_name, $steps);
            $task_solution = $task_solution . $this->CreateModuloEquivalence($first_variable_name, $solution[0][1], $solution[0][2], "");
            $task_solution = $task_solution . "<b>$second_variable_name=</b>(" . $diophantine_equation[2] . $x_coef_sign . abs($diophantine_equation[0]) . "*$first_variable_name)/(" . $diophantine_equation[1] . ")"
            . " = (" . $diophantine_equation[2] . $x_coef_sign . abs($diophantine_equation[0]) . " * (" . $solution[0][1] . $this->PlusMinus($solution[0][2]) .  abs($solution[0][2])  . "*k))/(" . $diophantine_equation[1] . ")"
            . " =<b>" .  $solution[1][0] . $this->PlusMinus($solution[1][1]) .  abs($solution[1][1])  . "*k (k \u{2208} \u{2124})</b></div>";
            
            return $task_solution;
        }
    }


?>
