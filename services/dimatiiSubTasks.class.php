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
    }


?>
