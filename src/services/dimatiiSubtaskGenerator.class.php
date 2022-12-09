<?php
    /**
     * This is a helper class which will generate a subtask related to Discrete mathematics II. given by the main topic, subtopic indices and the number of subtasks.
     * 
     * This class will be used by the DimatiiTasks and TaskGenerationController classes.
     */
    class DimatiiSubtaskGenerator {
        private $dimat_helper_functions;
        
        /**
         * 
         * The contructor for DimatiiSubtaskGenerator class.
         * 
         * @return void
         */
        public function __construct(){
            $this->dimat_helper_functions = new DimatiiHelperFunctions();
        }

        /**
         * This method is responsible for creating a set of appropriate subtasks related to Discrete mathematics II..
         * 
         * @param string $main_topic_number The main topic's number.
         * @param string $subtopic_number The subtopic's number.
         * @param int $number_of_subtasks The number of subtasks to be generated.
         * 
         * @return array Returns an array containing the subtasks' data, the subtasks' descriptions, subtasks' solutions and the printable solution for each subtask.
         */
        public function CreateSubtask($main_topic_number, $subtopic_number, $number_of_subtasks){
            $subtask = [];
            switch($main_topic_number){
                case "0":{
                    switch($subtopic_number){
                        case "0": $subtask = $this->CreateDivisionPairsSubtask($number_of_subtasks);break;
                        case "1": $subtask = $this->CreatePrimeFactorizationSubtask($number_of_subtasks); break;
                        case "2": $subtask = $this->CreateDivisorCountSubtask($number_of_subtasks);break;
                        case "3": $subtask = $this->CreateCongruentNumbersSubtask($number_of_subtasks);break;
                        default:break;
                    }
                }break;
                case "1":{
                    switch($subtopic_number){
                        case "0": $subtask = $this->CreateCompleteResidueSystemSubtask($number_of_subtasks);break;
                        case "1": $subtask = $this->CreateReducedResidueSystemSubtask($number_of_subtasks); break;
                        case "2": $subtask = $this->CreateEulerPhiFunctionSubtask($number_of_subtasks);break;
                        default:break;
                    }
                }break;
                case "2":{
                    switch($subtopic_number){
                        case "0": $subtask = $this->CreateEuclideanAlgorithmSubtask($number_of_subtasks);break;
                        case "1": ; break;
                        default:break;
                    }
                }break;
                case "3":{
                    switch($subtopic_number){
                        case "0": $subtask = $this->CreateLinearCongruenceSubtask($number_of_subtasks);break;
                        case "1": ; break;
                        default:break;
                    }
                }break;
                case "4":{
                    switch($subtopic_number){
                        case "0": $subtask = $this->CreateDiophantineEquationSubtask($number_of_subtasks);break;
                        case "1": $subtask = $this->CreateNumberDivisionWithConditionsSubtask($number_of_subtasks); break;
                        default:break;
                    }
                }break;
                case "5":{
                    switch($subtopic_number){
                        case "0": $subtask = $this->CreateCRTSubtask($number_of_subtasks);break;
                        case "1": $subtask = $this->CreateCRTNumberResiduesSubtask($number_of_subtasks); break;
                        default:break;
                    }
                }break;
                case "6":{
                    switch($subtopic_number){
                        case "0": $subtask = $this->CreateHornerSchemeSubtask($number_of_subtasks);break;
                        case "1": $subtask = $this->CreatePolynomialDivisionHornerSchemeSubtask($number_of_subtasks); break;
                        default:break;
                    }
                }break;
                case "7":{
                    switch($subtopic_number){
                        case "0": $subtask = $this->CreatePolynomialDivisionSubtask($number_of_subtasks);break;
                        case "1": $subtask = $this->CreatePolynomialMultiplicationSubtask($number_of_subtasks); break;
                        default:break;
                    }
                }break;
                case "8":{
                    switch($subtopic_number){
                        case "0": $subtask = $this->CreateLagrangeInterpolationSubtask($number_of_subtasks);break;
                        case "1": $subtask = $this->CreateNewtonInterpolationSubtask($number_of_subtasks); break;
                        default:break;
                    }
                }break;
                case "9":{
                    switch($subtopic_number){
                        default:break;
                    }
                }break;
                default:break;
            };

            return $subtask;
        }
        
        /**
         * This private method will generate a set of tasks related to the first main topic - first subtopic of Discrete Mathematics II.
         * 
         * Per subtask:
         * 
         * Create dividand, divisor pair. These are whole numbers from the [-1000,1000] interval.
         * The method also determines the quotient and residue.
         * 
         * @param int $number_of_pairs The number of pairs which is a positive whole number.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        private function CreateDivisionPairsSubtask($number_of_pairs){
            $division_pairs = $this->dimat_helper_functions->CreatePairsOfNumbers($number_of_pairs, -1000, 1000);
            $solutions = $this->dimat_helper_functions->DetermineQuotientAndResidue($division_pairs);
            $descriptions = [];
            $printable_solutions = ["<div class=\"editable_box\"><label class=\"editable_label\">Megoldás:</label></div>"];
            
            for($division_counter = 0; $division_counter < $number_of_pairs; $division_counter++){
                $task_text = "<div class=\"editable_box\"><label class=\"editable_label\">" . $division_counter + 1 . ". csoport: </label></div><div class=\"editable_box\"><label class=\"editable_label\">Add meg ". $division_pairs[$division_counter][0] . "/" . $division_pairs[$division_counter][1] . " osztás eredményét az egész számok körében!</label></div>";
                $printable_solution = "<div class=\"editable_box\"><label class=\"editable_label\">" . $division_counter + 1 . ". csoport: </label></div><div class=\"editable_box\"><label class=\"editable_label\">". $division_pairs[$division_counter][0] . " = " . $solutions[$division_counter][0] . " * " . $division_pairs[$division_counter][1] . " + " . $solutions[$division_counter][1] . "</label></div>";
                array_push($descriptions, $task_text);
                array_push($printable_solutions, $printable_solution);
            }

            return array("data" => $division_pairs , "descriptions" => $descriptions, "solutions" => $solutions, "printable_solutions" => $printable_solutions);
        }

        /**
         * This private method will generate a set of tasks related to the first main topic - second subtopic of Discrete Mathematics II.
         * 
         * Per subtask:
         * 
         * Pick the given amount of distinct whole numbers from the [100,1000] interval.
         * Determine the prime factorizations for these numbers.
         * 
         * @param int $number_of_numbers The number of numbers which is a positive whole number.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        private function CreatePrimeFactorizationSubtask($number_of_numbers){
            $prime_factorization_numbers = $this->dimat_helper_functions->CreateDistinctNumbers($number_of_numbers, 100, 1000);
            $solutions = $this->dimat_helper_functions->DeterminePrimeFactorization($prime_factorization_numbers);
            $descriptions = [];
            $printable_solutions = ["<div class=\"editable_box\"><label class=\"editable_label\">Megoldás:</label></div>"];

            for($prime_factorization_counter = 0; $prime_factorization_counter < $number_of_numbers; $prime_factorization_counter++){
                $task_description =  "<div class=\"editable_box\"><label class=\"editable_label\">" . $prime_factorization_counter + 1 . ". csoport: </label></div><div class=\"editable_box\"><label class=\"editable_label\">Add meg ". $prime_factorization_numbers[$prime_factorization_counter] . " prímfelbontását!</label></div>";
                
                $number = intval($prime_factorization_numbers[$prime_factorization_counter]);
                $printable_solution =  "<div class=\"editable_box\"><label class=\"editable_label\">" . $prime_factorization_counter + 1 . ". csoport: </label></div>" . "<table class=\"prime_factorization_table\">";
                foreach($solutions[$prime_factorization_counter] as $factor_index => $factor){
                    for($exp_counter = 0; $exp_counter < $factor[1]; $exp_counter++){
                        $printable_solution = $printable_solution . "<tr><td class=\"editable_box\"><label class=\"editable_label\">" . $number . "</label></td><td class=\"editable_box\"><label class=\"editable_label\">". $factor[0] . "</label></td></tr>";
                        if(intval($factor[0]) !== 0){
                            $number /= intval($factor[0]);
                        }
                    }
                }
                $printable_solution = $printable_solution . "</table>";
                
                array_push($descriptions, $task_description);
                array_push($printable_solutions, $printable_solution);
            }
            
            return array("data" => $prime_factorization_numbers , "descriptions" => $descriptions, "solutions" => $solutions, "printable_solutions" => $printable_solutions);
        }

        /**
         * This private method will generate a set of tasks related to the first main topic - third subtopic of Discrete Mathematics II.
         * 
         * Per subtask:
         * 
         * Pick the given amount of distinct whole numbers from the [100,1000] interval.
         * Determine the number of divisors for these numbers.
         * 
         * @param int $number_of_numbers The number of numbers which is a positive whole number.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        private function CreateDivisorCountSubtask($number_of_numbers){
            $positive_divisor_count_numbers = $this->dimat_helper_functions->CreateDistinctNumbers($number_of_numbers, 100, 1000);
            $prime_factorizations = $this->dimat_helper_functions->DeterminePrimeFactorization($positive_divisor_count_numbers);
            $solutions = $this->dimat_helper_functions->DetermineNumberOfDivisors($positive_divisor_count_numbers);
            $descriptions = [];
            $printable_solutions = ["<div class=\"editable_box\"><label class=\"editable_label\">Megoldás:</label></div>"];

            for($counter = 0; $counter < $number_of_numbers; $counter++){
                $task_description = "<div class=\"editable_box\"><label class=\"editable_label\">" . $counter + 1 . ". csoport: </label></div><div class=\"editable_box\"><label class=\"editable_label\">Add meg a ". $positive_divisor_count_numbers[$counter] . " osztóinak számát!</label></div>";
                
                $number = intval($positive_divisor_count_numbers[$counter]);
                $printable_solution = "<div class=\"editable_box\"><label class=\"editable_label\">" . $counter + 1 . ". csoport: </label></div><table class=\"prime_factorization_table\">";
                $multplication_form = "";
                $exponential_form = "";
                foreach($prime_factorizations[$counter] as $factor_index => $factor){
                    for($exponential_counter = 0; $exponential_counter < $factor[1]; $exponential_counter++){
                        $printable_solution = $printable_solution . "<tr><td class=\"editable_box\"><label class=\"editable_label\">" . $number . "</label></td><td class=\"editable_box\"><label class=\"editable_label\">". $factor[0] . "</label></td></tr>";
                        if(intval($factor[0]) !== 0){
                            $number /= intval($factor[0]);
                        }
                    }

                    if($factor_index !== 0){
                        $multplication_form = $multplication_form . " * ";
                        $exponential_form = $exponential_form . " * ";
                    }
                    $exponential_form = $exponential_form . "( " . $factor[1] ." + 1)";
                    $multplication_form = $multplication_form . $factor[0] . "<sup>" . $factor[1] . "</sup>";
                }
                $printable_solution = $printable_solution . "</table>";

                $printable_solution = $printable_solution . "<div class=\"editable_box\"><label class=\"editable_label\">d(" 
                    . $positive_divisor_count_numbers[$counter] . ") = "
                    . $multplication_form . " = " . $exponential_form . " = "
                    . $solutions[$counter] . "</label></div>";
                
                array_push($descriptions, $task_description);
                array_push($printable_solutions, $printable_solution);
            }
            
            return array("data" => $positive_divisor_count_numbers, "descriptions" => $descriptions, "solutions" => $solutions, "printable_solutions" => $printable_solutions);
        }

        /**
         * This private method will generate a set of tasks related to the first main topic - fourth subtopic of Discrete Mathematics II.
         * 
         * Per subtask:
         * 
         * Pick a pair of whole numbers from the [-1000, 1000] interval, where the second number must be positive.
         * For each subtask the student has to find a number being congruent with the first number modulo second number.
         * 
         * @param int $number_of_numbers The number of pairs which is a positive whole number.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        private function CreateCongruentNumbersSubtask($number_of_pairs){
            $congruences = $this->dimat_helper_functions->CreatePairsOfNumbers($number_of_pairs, -1000, 1000, false, true);
            $descriptions = [];
            $printable_solutions = ["<div class=\"editable_box\"><label class=\"editable_label\">Megoldás:</label></div>"];
            $task_description = [];

            for($congruence_counter = 0; $congruence_counter < $number_of_pairs; $congruence_counter++){
                $task_description = "<div class=\"editable_box\"><label class=\"editable_label\">" . $congruence_counter + 1 . ". csoport: </label></div><div class=\"editable_box\"><label class=\"editable_label\">Írj a ". $congruences[$congruence_counter][0] . " \u{2261} x (mod " . $congruences[$congruence_counter][1] . ") kongruenciában az x helyére egy egészet, hogy igaz állítást kapj!</label></div>";
                $printable_solution =  "<div class=\"editable_box\"><label class=\"editable_label\">" . $congruence_counter + 1 . ". csoport: </label></div><div class=\"editable_box\"><label class=\"editable_label\">" . PrintServices::CreatePrintableModuloEquivalence("x",$congruences[$congruence_counter][0], $congruences[$congruence_counter][1]) . "</label></div>";
                array_push($descriptions, $task_description);
                array_push($printable_solutions, $printable_solution);
            }
            
            return array("data" => $congruences, "descriptions" => $descriptions, "solutions" => [], "printable_solutions" => $printable_solutions);
        }

        /**
         * This private method will generate a set of tasks related to the second main topic - first subtopic of Discrete Mathematics II.
         * 
         * Per subtask:
         * 
         * Picks the given amount of whole numbers from the [2,15] interval.
         * Determines the complete residue system modulo the picked numbers.
         * 
         * @param int $number_of_numbers The number of numbers which is a positive whole number.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        private function CreateCompleteResidueSystemSubtask($number_of_numbers){
            $lower = 2; 
            $upper = 15;
            $modulos = $this->dimat_helper_functions->CreateDistinctNumbers($number_of_numbers, $lower, $upper);
            $solutions = [];
            $printable_solutions = ["<div class=\"editable_box\"><label class=\"editable_label\">Megoldás:</label></div>"];
            $descriptions = [];

            for($crs_counter = 0; $crs_counter < $number_of_numbers; $crs_counter++){
                $task_description = "<div class=\"editable_box\"><label class=\"editable_label\">" . $crs_counter + 1 . ". csoport: </label></div><div class=\"editable_box\"><label class=\"editable_label\">Add meg a \u{2124}/<sub>". $modulos[$crs_counter] . "</sub>\u{2124} teljes maradékrendszer maradékosztályait 1-1 reprezentatív elemükkel!</label></div>";
                $solution = $this->dimat_helper_functions->DetermineCompleteResidueSystem($modulos[$crs_counter]);
                array_push($solutions, $solution);

                $set= "";
                foreach($solution as $counter => $representative_element){
                    if($counter !== 0){
                        $set = $set . ", ";
                    }
                    $set = $set . "<span style=\"border-top:1px solid black\">". $representative_element . "</span>"; 
                }
                $printable_solution = "<div class=\"editable_box\"><label class=\"editable_label\">" . $crs_counter + 1 . ". csoport: </label></div><div class=\"editable_box\"><label class=\"editable_label\">\u{2124}/<sub>". $modulos[$crs_counter] . "</sub>\u{2124} = {" . $set . "}</label></div>";

                array_push($descriptions, $task_description);
                array_push($printable_solutions, $printable_solution);
            }
            
            return array("data" => $modulos, "descriptions" => $descriptions, "solutions" => $solutions, "printable_solutions" => $printable_solutions);
        }

        /**
         * This private method will generate a set of tasks related to the second main topic - second subtopic of Discrete Mathematics II.
         * 
         * The subtask is about giving the residue classes by representative elements of the created reduced residue systems.
         * 
         * Per subtask:
         * 
         * Picks the given amount of whole numbers from the [2,25] interval.
         * Determines the reduced residue system modulo the picked numbers.
         * 
         * @param int $number_of_numbers The number of numbers which is a positive whole number.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        private function CreateReducedResidueSystemSubtask($number_of_numbers){
            $lower = 2; 
            $upper = 25;
            $modulos = $this->dimat_helper_functions->CreateDistinctNumbers($number_of_numbers, $lower, $upper);
            $solutions = [];
            $printable_solutions = ["<div class=\"editable_box\"><label class=\"editable_label\">Megoldás:</label></div>"];
            $descriptions = [];

            for($rrs_counter = 0; $rrs_counter < $number_of_numbers; $rrs_counter++){
                $task_description = "<div class=\"editable_box\"><label class=\"editable_label\">" . $rrs_counter + 1 . ". csoport: </label></div><div class=\"editable_box\"><label class=\"editable_label\">Add meg a (\u{2124}/<sub>". $modulos[$rrs_counter] . "</sub>\u{2124})* redukált maradékrendszer maradékosztályait 1-1 reprezentatív elemükkel!</label></div>";
                $solution = $this->dimat_helper_functions->DetermineReducedResidueSystem($modulos[$rrs_counter]);
                array_push($solutions, $solution);

                $set= "";
                foreach($solution as $counter => $representative_element){
                    if($counter !== 0){
                        $set = $set . ", ";
                    }
                    $set = $set . "<span style=\"border-top:1px solid black\">". $representative_element . "</span>"; 
                }
                $printable_solution = "<div class=\"editable_box\"><label class=\"editable_label\">" . $rrs_counter + 1 . ". csoport: </label></div><div class=\"editable_box\"><label class=\"editable_label\">(\u{2124}/<sub>". $modulos[$rrs_counter] . "</sub>\u{2124})* = {" . $set . "}</label></div>";

                array_push($descriptions, $task_description);
                array_push($printable_solutions, $printable_solution);
            }
            
            return array("data" => $modulos, "descriptions" => $descriptions, "solutions" => $solutions, "printable_solutions" => $printable_solutions);
        }

        /**
         * This private method will generate a set of tasks related to the second main topic - third subtopic of Discrete Mathematics II.
         * 
         * The subtask is about giving the size of a reduced residue systems by the Euler's phi function.
         * 
         * Per subtask:
         * 
         * Picks the given amount of whole numbers from the [1000, 5000] interval.
         * Determines the size of the reduced residue system modulo the picked numbers.
         * 
         * @param int $number_of_numbers The number of numbers which is a positive whole number.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        private function CreateEulerPhiFunctionSubtask($number_of_numbers){
            $lower = 1000;
            $upper = 5000;
            $modulos = $this->dimat_helper_functions->CreateDistinctNumbers($number_of_numbers, $lower, $upper);
            $solutions = [];
            $printable_solutions = ["<div class=\"editable_box\"><label class=\"editable_label\">Megoldás:</label></div>"];
            $descriptions = [];

            for($rrs_size_counter = 0; $rrs_size_counter < $number_of_numbers; $rrs_size_counter++){
                $task_description = "<div class=\"editable_box\"><label class=\"editable_label\">" . $rrs_size_counter + 1 . ". csoport: </label></div><div class=\"editable_box\"><label class=\"editable_label\">Add meg a (\u{2124}/<sub>". $modulos[$rrs_size_counter] . "</sub>\u{2124})* redukált maradékrendszer méretét (maradékosztályainak számát)!</label></div>";
                $solution = $this->dimat_helper_functions->DetermineEulerPhiValue($modulos[$rrs_size_counter]);
                array_push($solutions, $solution["solution"]);
                
                $phi_part = "";
                $multiplication_part = "";
                foreach($solution["prime_factorization"] as $pair_counter => $factor){
                    if($pair_counter !== 0){
                        $phi_part = $phi_part . " * ";
                        $multiplication_part = $multiplication_part . " * ";
                    }
                    $phi_part = $phi_part . "\u{03C6}(" . $factor[0] . "<sup>" . $factor[1] . "</sup>)"; 
                    $multiplication_part = $multiplication_part . $factor[0] . "<sup>(" . $factor[1] - 1 . ")</sup> * (" .  $factor[0] . " - 1)"; 
                }
                
                $printable_solution = "<div class=\"editable_box\"><label class=\"editable_label\">" . $rrs_size_counter + 1 . ". csoport: </label></div><div class=\"editable_box\"><label class=\"editable_label\">|(\u{2124}/<sub>".
                                $modulos[$rrs_size_counter] . "</sub>\u{2124})*| = ". 
                                $phi_part . " = " .
                                $multiplication_part . " = " .
                                $solution["solution"]  . "</label></div>";

                array_push($descriptions, $task_description);
                array_push($printable_solutions, $printable_solution);
            }
            
            return array("data" => $modulos, "descriptions" => $descriptions, "solutions" => $solutions, "printable_solutions" => $printable_solutions);
        }

        /**
         * This private method will generate a set of tasks related to the third main topic - first subtopic of Discrete Mathematics II.
         * 
         * The subtask is about giving the gcd for each pair with the Euclidean algorithm. Additionally, the lcm for these pairs will also be determined.
         * 
         * Per subtask:
         * 
         * Creates the given amount of distinct pairs, where the elements of the pairs are from the [30, 200] interval and are whole numbers.
         * Determines the GCD with the Euclidean algorithm.
         * 
         * @param int $number_of_numbers The number of numbers which is a positive whole number.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        private function CreateEuclideanAlgorithmSubtask($number_of_numbers){
            $lower = 30;
            $upper = 200;
            $gcd_pairs = $this->dimat_helper_functions->CreatePairsOfNumbers($number_of_numbers, $lower, $upper);
            $printable_solutions = ["<div class=\"editable_box\"><label class=\"editable_label\">Megoldás:</label></div>"];
            $descriptions = [];

            $euclidean_algorithm = [];
            $gcd_array = [];
            $lcm_array = [];
            foreach($gcd_pairs as $index => $pair){
                $algorithm = $this->dimat_helper_functions->DetermineGCDWithEuclidean($pair);
                array_push($euclidean_algorithm, $algorithm["steps"]);
                array_push($gcd_array, $algorithm["solution"]);
                if($algorithm["solution"] !== 0){
                    array_push($lcm_array, ($pair[0]*$pair[1])/$algorithm["solution"]);
                }else{
                    array_push($lcm_array, "inf");
                }
            }

            for($gcd_pair_counter = 0; $gcd_pair_counter < count($gcd_pairs); $gcd_pair_counter++){
                $actual_gcd = $gcd_array[$gcd_pair_counter];
                $actual_lcm = $lcm_array[$gcd_pair_counter];
                $actual_steps = $euclidean_algorithm[$gcd_pair_counter];
                $first_number = $gcd_pairs[$gcd_pair_counter][0];
                $second_number = $gcd_pairs[$gcd_pair_counter][1];

                $task_description =  "<div class=\"editable_box\"><label class=\"editable_label\">" . $gcd_pair_counter + 1 . ". csoport: </label></div><div class=\"editable_box\"><label class=\"editable_label\">Add meg a " . $first_number . " és " . $second_number . " számok legnagyobb közös osztóját az euklideszi algoritmus segítségével!</label></div>";
                
                $printable_solution = "<div class=\"editable_box\"><label class=\"editable_label\">" . $gcd_pair_counter + 1 . ". csoport: </label></div><table class=\"euclidean_solution_table\">";
                $printable_solution = $printable_solution . "<tr><td class=\"editable_box\"><label class=\"editable_label\">i</label></td><td class=\"editable_box\"><label class=\"editable_label\">r<sub>i-2</sub><td class=\"editable_box\"><label class=\"editable_label\">=</label></td><td class=\"editable_box\"><label class=\"editable_label\">q<sub>i</sub></label></td><td class=\"editable_box\"><label class=\"editable_label\"> * </label></td><td class=\"editable_box\"><label class=\"editable_label\">r<sub>i-1</sub><td class=\"editable_box\"><label class=\"editable_label\">+</label></td><td class=\"editable_box\"><label class=\"editable_label\">r<sub>i</sub></label></td></tr>";
                foreach($actual_steps as $step_counter => $actual_step){
                    $printable_solution = $printable_solution . "<tr><td class=\"editable_box\"><label class=\"editable_label\">" . $step_counter + 1 . ".</label></td><td class=\"editable_box\"><label class=\"editable_label\">" . $actual_step[0] .  "</label></td><td class=\"editable_box\"><label class=\"editable_label\">=</label></td><td class=\"editable_box\"><label class=\"editable_label\">" . $actual_step[1] . "</label></td><td class=\"editable_box\"><label class=\"editable_label\">*</label></td><td class=\"editable_box\"><label class=\"editable_label\">" . $actual_step[2] . "</label></td><td class=\"editable_box\"><label class=\"editable_label\">+</label></td><td class=\"editable_box\"><label class=\"editable_label\">" . $actual_step[3] .  "</label></td></tr>";
                }
                $printable_solution = $printable_solution . "</table>";
                $printable_solution = $printable_solution . "<div class=\"editable_box\"><label class=\"editable_label\">LNKO(" . $first_number . ", " . $second_number . ") = " . $actual_gcd . "</label></div>";
                $printable_solution = $printable_solution . "<div class=\"editable_box\"><label class=\"editable_label\">LKKT(" . $first_number . ", " . $second_number . ") = " . $first_number  . " * " . $second_number . "/ " . $actual_gcd  . " = " . $actual_lcm . "</label></div>";
                
                array_push($descriptions, $task_description);
                array_push($printable_solutions, $printable_solution);
            }
            
            return array("data" => $gcd_pairs , "descriptions" => $descriptions, "solutions" => [$euclidean_algorithm, $gcd_array, $lcm_array], "printable_solutions" => $printable_solutions);
        }

        /**
         * This private method will generate a set of tasks related to the fourth main topic - first subtopic of Discrete Mathematics II.
         * 
         * The subtask is about giving the solution for a linear congruences.
         * 
         * Per subtask:
         * 
         * Creates the given number of triplets (each representing a linear congruence). Each triplet has non-zero, whole numbers from the [-30, 30] interval.
         * Determines the solution for each linear congruence.
         * 
         * @param int $number_of_numbers The number of numbers which is a positive whole number.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        private function CreateLinearCongruenceSubtask($number_of_triplets){
            $lower = -30;
            $upper = 30;
            $triplets = $this->dimat_helper_functions->CreateSolvableLinearCongruences($number_of_triplets, true, $lower, $upper);
            $printable_solutions = ["<div class=\"editable_box\"><label class=\"editable_label\">Megoldás:</label></div>"];
            $descriptions = [];

            $linear_congrences_algorithm = [];
            $solutions = [];
            foreach($triplets as $index => $triplet){
                //$algorithm = $this->dimat_helper_functions->DetermineLinearCongruenceSolution($triplet);
                $algorithm = $this->dimat_helper_functions->DetermineLinearCongruenceSolutionSmart($triplet);
                array_push($linear_congrences_algorithm, $algorithm["steps"]);
                array_push($solutions, $algorithm["solution"]);
            }

            for($linear_congruence_counter = 0; $linear_congruence_counter < count($triplets); $linear_congruence_counter++){
                $actual_steps = $linear_congrences_algorithm[$linear_congruence_counter];
                $first_number = $triplets[$linear_congruence_counter][0];
                $second_number = $triplets[$linear_congruence_counter][1];
                $third_number = $triplets[$linear_congruence_counter][2];

                $task_description =  "<div class=\"editable_box\"><label class=\"editable_label\">" . $linear_congruence_counter + 1 . ". csoport: </label></div><div class=\"editable_box\"><label class=\"editable_label\">Old meg a " . $first_number . "*x \u{2261} " . $second_number . " mod(" . $third_number . ") lineáris kongruenciát!</label></div>";
                $printable_solution = "<div class=\"editable_box\"><label class=\"editable_label\">" . $linear_congruence_counter + 1 . ". csoport: </label></div>";            
                $printable_solution =  $printable_solution . "<div class=\"editable_box\"><label class=\"editable_label\">" . PrintServices::CreatePrintableCongruenceSolution("x", $actual_steps) . "</label></div>";


                array_push($descriptions, $task_description);
                array_push($printable_solutions, $printable_solution);
            }
            
            return array("data" => $triplets , "descriptions" => $descriptions, "solutions" => [$linear_congrences_algorithm, $solutions], "printable_solutions" => $printable_solutions);
        }

        /**
         * This private method will generate a set of tasks related to the fifth main topic - first subtopic of Discrete Mathematics II.
         * 
         * The subtask is about giving the solution for diophantine equations.
         * 
         * Per subtask:
         * 
         * Creates a triplet (representing a diophantine equation). The triplet has non-zero, whole numbers from the [-50, 50] interval.
         * Determines the solution for The diophantine equation.
         * 
         * @param int $number_of_numbers The number of numbers which is a positive whole number.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        private function CreateDiophantineEquationSubtask($number_of_triplets){
            $lower = -50;
            $upper = 50;
            $triplets = $this->dimat_helper_functions->CreateSolvableLinearCongruences($number_of_triplets, true, $lower, $upper);
            $printable_solutions = ["<div class=\"editable_box\"><label class=\"editable_label\">Megoldás:</label></div>"];
            $descriptions = [];

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

            for($diophantine_equation_counter = 0; $diophantine_equation_counter < count($triplets); $diophantine_equation_counter++){
                $diophantine_equation = $diophantine_equations[$diophantine_equation_counter];
                $steps = $diophantine_algorithm[$diophantine_equation_counter];
                $solution = $diophantine_solutions[$diophantine_equation_counter];
                
                $task_description = "<div class=\"editable_box\"><label class=\"editable_label\">" . $diophantine_equation_counter + 1 . ". csoport: </label></div><div class=\"editable_box\"><label class=\"editable_label\"> Add meg a " . $diophantine_equation[0] . " * x " . PrintServices::PlusMinus($diophantine_equation[1]) . abs($diophantine_equation[1]) . " * y = " . $diophantine_equation[2] . " lineáris diofantikus egyenlet megoldását!</label></div>";
                $printable_solution = "<div class=\"editable_box\"><label class=\"editable_label\">" . $diophantine_equation_counter + 1 . ". csoport: </label></div>" . $this->CreateDiophantineSolutionText("x", "y", $diophantine_equation, $steps, $solution);

                array_push($descriptions, $task_description);
                array_push($printable_solutions, $printable_solution);
            }
            
            return array("data" => $diophantine_equations , "descriptions" => $descriptions, "solutions" => $diophantine_solutions, "printable_solutions" => $printable_solutions);
        }

        /**
         * This private method will generate a set of tasks related to the first main topic - second subtopic of Discrete Mathematics II.
         * 
         * The subtask is about giving the solution for a number division, where the numbers have conditions dividorwise.
         * 
         * Per subtask:
         * 
         * Creates a triplet (representing a diophantine equation). The triplet has a congr. b (mod c) form, where a, b, c whole numbers, the left side and the modulo are from [2, 100] interval and the right side is from the [200, 1000] interval.
         * Determines the solution for the diophantine equation.
         * 
         * @param int $number_of_numbers The number of numbers which is a positive whole number.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        private function CreateNumberDivisionWithConditionsSubtask($number_of_triplets){
            $triplets = [];
            $printable_solutions = ["<div class=\"editable_box\"><label class=\"editable_label\">Megoldás:</label></div>"];
            $descriptions = [];

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

            for($diophantine_equation_counter = 0; $diophantine_equation_counter < count($triplets); $diophantine_equation_counter++){
                $diophantine_equation = $diophantine_equations[$diophantine_equation_counter];
                $steps = $diophantine_algorithm[$diophantine_equation_counter];
                $solution = $diophantine_solutions[$diophantine_equation_counter];
                
                $task_description = "<div class=\"editable_box\"><label class=\"editable_label\">" . $diophantine_equation_counter + 1 . ". csoport: </label></div><div class=\"editable_box\"><label class=\"editable_label\"> Bontsd fel a " . $diophantine_equation[2] .  "-" . PrintServices::UseCorrectObjectSuffix($diophantine_equation[2]) . " úgy két szám összegére, hogy az egyik osztható " . $diophantine_equation[0] . "-" . PrintServices::UseCorrectAdverb($diophantine_equation[0]) . ", a másik pedig a " . $diophantine_equation[1] . "-" . PrintServices::UseCorrectAdverb($diophantine_equation[1]) . "!</label></div>";
                $printable_solution = "<div class=\"editable_box\"><label class=\"editable_label\">" . $diophantine_equation_counter + 1 . ". csoport: </label></div>" . $this->CreateDiophantineSolutionText("x", "y", $diophantine_equation, $steps, $solution);
                $printable_solution = $printable_solution .  "<div class=\"editable_box\"><label class=\"editable_label\">Az első szám így: x * " .  $diophantine_equation[0]  .  ", a második szám pedig: y * " .  $diophantine_equation[1] . " (például: " . $diophantine_equation[0]*$solution[0][1] . " és " . $diophantine_equation[1]*$solution[1][0] . ")</label></div>";
                
                array_push($descriptions, $task_description);
                array_push($printable_solutions, $printable_solution);
            }
            
            return array("data" => $diophantine_equations , "descriptions" => $descriptions, "solutions" => $diophantine_solutions, "printable_solutions" => $printable_solutions);
        }

        /**
         * This private method will generate a set of tasks related to the sixth main topic - first subtopic of Discrete Mathematics II.
         * 
         * The subtask is about giving the solution for congruence systems.
         * 
         * Per subtask:
         * 
         * Creates a congruence system of triplets (each triplet represents a linear congruence). Each linear congruence is solvable, the numbers in them are from the [-50, 50] interval.
         * Determines the solution for the congruence system.
         * 
         * @param int $number_of_congruence_systems The number of congruence systems which is a positive whole number. The default value is 1.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        private function CreateCRTSubtask($number_of_congruence_systems = 1){
            $number_of_congruences_per_system = 3;
            $lower = -50;
            $upper = 50;
            $congruence_systems = [];
            $solutions = [];
            $printable_solutions = ["<div class=\"editable_box\"><label class=\"editable_label\">Megoldás:</label></div>"];
            $descriptions = [];

            for($congruence_systems_counter = 0; $congruence_systems_counter < $number_of_congruence_systems; $congruence_systems_counter++){
                $new_congruence_system = $this->dimat_helper_functions->CreateSolvableLinearCongruencesForCRT($number_of_congruences_per_system, $lower, $upper);
                if(in_array($new_congruence_system, $congruence_systems)){
                    $new_congruence_system = $this->dimat_helper_functions->CreateSolvableLinearCongruencesForCRT($number_of_congruences_per_system, $lower, $upper);
                }
                array_push($congruence_systems, $new_congruence_system);
                $actual_solution = $this->dimat_helper_functions->DetermineLinearCongruenceSystemSolution($new_congruence_system);
                array_push($solutions, $actual_solution);

                $texts = $this->CreateCRTSolutionText($new_congruence_system, $actual_solution);
                $task_description = "<div class=\"editable_box\"><label class=\"editable_label\">" . $congruence_systems_counter + 1 . ". csoport: </label></div>" . $texts["task_description"];
                $printable_solution = "<div class=\"editable_box\"><label class=\"editable_label\">" . $congruence_systems_counter + 1 . ". csoport: </label></div>" . $texts["task_description"] . $texts["task_solution"];
                

                array_push($descriptions, $task_description);
                array_push($printable_solutions, $printable_solution);
            }
            
            return array("data" => $congruence_systems , "descriptions" => $descriptions, "solutions" => $solutions, "printable_solutions" => $printable_solutions);
        }

        /**
         * This private method will generate a set of tasks related to the sixth main topic - second subtopic of Discrete Mathematics II.
         * 
         * The subtask is about finding a number which gives different residues upon divising them with different numbers. 
         * 
         * Per subtask:
         * 
         * Create a congruence system of 2 linear congruences. Each linear congruence is solvable, the numbers in them are from the [2, 100] interval.
         * Determines the solution for the congruence system.
         * 
         * @param int $number_of_congruence_systems The number of congruence systems which is a positive whole number. The default value is 1.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        private function CreateCRTNumberResiduesSubtask($number_of_congruence_systems = 1){
            $lower = 2;
            $upper = 100;
            $congruence_systems = [];
            $solutions = [];
            $printable_solutions = ["<div class=\"editable_box\"><label class=\"editable_label\">Megoldás:</label></div>"];
            $descriptions = [];

            for($congruence_systems_counter = 0; $congruence_systems_counter < $number_of_congruence_systems; $congruence_systems_counter++){
                $new_congruence_system = $this->dimat_helper_functions->CreateSolvableLinearCongruencesForCRT(2, $lower, $upper);
                for($index = 0; $index < count($new_congruence_system); $index++){
                    $new_congruence_system[$index][0] = 1;
                    $new_congruence_system[$index][1] %= $new_congruence_system[$index][2];
                }

                if(in_array($new_congruence_system, $congruence_systems)){
                    $new_congruence_system = $this->dimat_helper_functions->CreateSolvableLinearCongruencesForCRT(2, $lower, $upper);
                    for($index = 0; $index < count($new_congruence_system); $index++){
                        $new_congruence_system[$index][0] = 1;
                        $new_congruence_system[$index][1] %= $new_congruence_system[$index][2];
                    }
                }
                array_push($congruence_systems, $new_congruence_system);
                
                $actual_solution = $this->dimat_helper_functions->DetermineLinearCongruenceSystemSolution($new_congruence_system);
                array_push($solutions, $actual_solution);

                $texts = $this->CreateCRTSolutionText($new_congruence_system, $actual_solution);
                
                $task_description = "<div class=\"editable_box\"><label class=\"editable_label\">" . $congruence_systems_counter + 1 . ". csoport: </label></div><div class=\"editable_box\"><label class=\"editable_label\">Adj egy olyan számot, ami " . $new_congruence_system[0][2] . "-" .  PrintServices::UseCorrectAdverb($new_congruence_system[0][2]) . " osztva " . $new_congruence_system[0][1] . "-" . PrintServices::UseCorrectObjectSuffix($new_congruence_system[0][1]) . " és "
                . $new_congruence_system[1][2] . "-" .  PrintServices::UseCorrectAdverb($new_congruence_system[1][2]) . " osztva " . $new_congruence_system[1][1] . "-" . PrintServices::UseCorrectObjectSuffix($new_congruence_system[1][1]) . " ad maradékul!</label></div>";
                
                $printable_solution = "<div class=\"editable_box\"><label class=\"editable_label\">" . $congruence_systems_counter + 1 . ". csoport: </label></div>" . "<div class=\"editable_box\"><label class=\"editable_label\">Adj egy olyan számot, ami " . $new_congruence_system[0][2] . "-" .  PrintServices::UseCorrectAdverb($new_congruence_system[0][2]) . " osztva " . $new_congruence_system[0][1] . "-" . PrintServices::UseCorrectObjectSuffix($new_congruence_system[0][1]) . " és "
                . $new_congruence_system[1][2] . "-" .  PrintServices::UseCorrectAdverb($new_congruence_system[1][2]) . " osztva " . $new_congruence_system[1][1] . "-" . PrintServices::UseCorrectObjectSuffix($new_congruence_system[1][1]) . " ad maradékul!</label></div>" . $texts["task_solution"];
                
                array_push($descriptions, $task_description);
                array_push($printable_solutions, $printable_solution);
            }
            
            return array("data" => $congruence_systems , "descriptions" => $descriptions, "solutions" => $solutions, "printable_solutions" => $printable_solutions);
        }

        /**
         * This private method will generate a set of tasks related to the seventh main topic - first subtopic of Discrete Mathematics II.
         * 
         * The subtask is about giving the Horner-scheme for polynomials with places.
         * 
         * Per subtask:
         * 
         * Creates a polynomial expression with degree of 2 - 5 and of coefficients (whole numbers) from the [-10,10] interval.
         * Picks polynomial degree number of places (polynomial degree - 2 number of roots), where the Horner- scheme will be executed.
         * Determines the Horner- shceme for these places.
         * 
         * @param int $number_of_polynomials The number of polynomials which is a positive whole number. The default value is 3.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        private function CreateHornerSchemeSubtask($number_of_polynomials = 1){
            $lower = -10;
            $upper = 10;
            $tasks = [];
            $polynomials = [];
            $places = [];
            $solutions = [];
            $printable_solutions = ["<div class=\"editable_box\"><label class=\"editable_label\">Megoldás:</label></div>"];
            $descriptions = [];

            for($polynomial_counter = 0; $polynomial_counter < $number_of_polynomials; $polynomial_counter++){
                // Creating $number_of_polynomials polynomials with degree between 2 and 5.
                // Picking 2-5 (same as degree) wole numbers from the range of -20 and 20, where degree - 2 needs to be actual roots of the first and second polynomial expressions respectively.
                $polynomial_degree = mt_rand(2,5);
                [$polynomial_expression, $roots] = $this->dimat_helper_functions->CreatePolynomialExpression($polynomial_degree, $lower, $upper);
                if(in_array($polynomial_expression, $polynomials)){
                    [$polynomial_expression, $roots] = $this->dimat_helper_functions->CreatePolynomialExpression($polynomial_degree, $lower, $upper);
                }
                $places = $this->dimat_helper_functions->CreatePlacesWithRoots($polynomial_degree, $polynomial_degree - 2, $roots, -20, 20);
                array_push($tasks, [$polynomial_degree, $polynomial_expression, $places]);
                array_push($polynomials, $polynomial_expression);

                $horner_schemes = $this->dimat_helper_functions->DetermineHornerSchemes($polynomial_expression, $places);
                array_push($solutions,$horner_schemes);
                
                $texts = $this->CreateHornerSchemeText($polynomial_expression, $places, $horner_schemes);
                $task_description = "<div class=\"editable_box\"><label class=\"editable_label\">" . $polynomial_counter + 1 . ". csoport: </label></div>" . $texts["task_description"];
                $printable_solution = "<div class=\"editable_box\"><label class=\"editable_label\">" . $polynomial_counter + 1 . ". csoport: </label></div>" . $texts["task_solution"];


                array_push($descriptions, $task_description);
                array_push($printable_solutions, $printable_solution);
            }
            
            return array("data" => $tasks , "descriptions" => $descriptions, "solutions" => $solutions, "printable_solutions" => $printable_solutions);
        }

        /**
         * This private method will generate a set of tasks related to the seventh main topic - second subtopic of Discrete Mathematics II.
         * 
         * The subtask is determining the polynomial division (where the divisor is a first degree polynomial expression) with the help of the Horner- scheme.
         * 
         * Per subtask:
         * 
         * Creates a polynomial expression with degree of 2 - 5 and of coefficients (whole numbers) from the [-10,10] interval.
         * Picks 1 place where the Horner- scheme will be executed.
         * Determines the Horner- shceme for this place.
         * 
         * @param int $number_of_polynomials The number of polynomials which is a positive whole number. The default value is 3.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        private function CreatePolynomialDivisionHornerSchemeSubtask($number_of_polynomials = 1){
            $lower = -10;
            $upper = 10;
            $tasks = [];
            $polynomials = [];
            $places = [];
            $solutions = [];
            $printable_solutions = ["<div class=\"editable_box\"><label class=\"editable_label\">Megoldás:</label></div>"];
            $descriptions = [];

            for($polynomial_counter = 0; $polynomial_counter < $number_of_polynomials; $polynomial_counter++){
                // Creating $number_of_polynomials polynomials with degree between 2 and 5.
                // Picking 2-5 (same as degree) wole numbers from the range of -20 and 20, where degree - 2 needs to be actual roots of the first and second polynomial expressions respectively.
                $polynomial_degree = mt_rand(2,5);
                [$polynomial_expression, $roots] = $this->dimat_helper_functions->CreatePolynomialExpression($polynomial_degree, $lower, $upper);
                if(in_array($polynomial_expression, $polynomials)){
                    [$polynomial_expression, $roots] = $this->dimat_helper_functions->CreatePolynomialExpression($polynomial_degree, $lower, $upper);
                }
                $places = $this->dimat_helper_functions->CreatePlacesWithRoots(1, 0, $roots, $lower, $upper);
                array_push($tasks, [$polynomial_degree, $polynomial_expression, $places]);
                array_push($polynomials, $polynomial_expression);

                $horner_schemes = $this->dimat_helper_functions->DetermineHornerSchemes($polynomial_expression, $places);
                array_push($solutions,$horner_schemes);
                $texts = $this->CreateHornerSchemeText($polynomial_expression, $places, $horner_schemes);
                
                
                $printable_solution = "<div class=\"editable_box\"><label class=\"editable_label\">" . $polynomial_counter + 1 . ". csoport: </label></div>" . $texts["task_solution"];                
                $task_description = "<div class=\"editable_box\"><label class=\"editable_label\">" . $polynomial_counter + 1 . ". csoport: </label></div><div class=\"editable_box\"><label class=\"editable_label\">Add meg a " . PrintServices::CreatePrintablePolynomial($polynomial_expression);
                $task_description = $task_description . " polinom (x" . PrintServices::PlusMinus(-1*$places[0]) . abs($places[0]) . ") polinommal való osztási maradékát és eredményét! Használd a Horner- elrendezést!</label></div>";

                $residue_text = "<div class=\"editable_box\"><label class=\"editable_label\">Az eredmény: ";
                $division_text = "<div class=\"editable_box\"><label class=\"editable_label\">A maradék: ";
                $degree = count($polynomial_expression) - 1;
                $residue_degree = $degree - 1;
                foreach($horner_schemes[0] as $cell_counter => $cell_value){
                    if($residue_degree - $cell_counter >= 0){
                        if($cell_value != 0){
                            if($cell_counter != 0){
                                $residue_text = $residue_text . PrintServices::PlusMinus($cell_value) . abs($cell_value);
                            }else{
                                $residue_text = $residue_text . $cell_value;
                            }
                            $residue_text = $residue_text. "*x<sup>" . $degree - $cell_counter . "</sup>";
                        }
                    }else if($residue_degree - $cell_counter < 0){
                        $division_text = $division_text . $cell_value;
                    }
                }
                $residue_text = $residue_text . "</label></div>";
                $division_text = $division_text . "</label></div>";
                $printable_solution = $printable_solution . $residue_text . $division_text;


                array_push($descriptions, $task_description);
                array_push($printable_solutions, $printable_solution);
            }
            
            return array("data" => $tasks , "descriptions" => $descriptions, "solutions" => $solutions, "printable_solutions" => $printable_solutions);
        }

        /**
         * This private method will generate a set of tasks related to the eight main topic - first subtopic of Discrete Mathematics II.
         * 
         * The subtask is about determining the polynomial division (the first polynomial expressions will be divided with the second expressions).
         * 
         * Per subtask:
         * 
         * Creates a polynomial expression with degree of 2 - 5 and of coefficients (whole numbers) from the [-10,10] interval.
         * Creates a polynomial expression with degree of previous polynomial expression's degree - 1 and of coefficients (whole numbers) from the [-10,10] interval.
         * Determines the quotients and residue of the first polynomial expression / second polynomial expression division.
         * 
         * @param int $number_of_pairs The number of pairs of polynomials which is a positive whole number. The default value is 1.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        private function CreatePolynomialDivisionSubtask($number_of_pairs = 1){
            $lower = -10;
            $upper = 10;
            $tasks = [];
            $dividands = [];
            $solutions = [];
            $printable_solutions = ["<div class=\"editable_box\"><label class=\"editable_label\">Megoldás:</label></div>"];
            $descriptions = [];

            for($polynomial_counter = 0; $polynomial_counter < $number_of_pairs; $polynomial_counter++){
                // Creating the dividand polynomial expression of degree between 3 and 5.
                // If this polynomial expression is already created, then a new one will be created.
                $dividand_polynomial_degree = mt_rand(3,5);
                [$dividand_polynomial_expression, $roots] = $this->dimat_helper_functions->CreatePolynomialExpression($dividand_polynomial_degree);
                if(in_array($dividand_polynomial_expression, $dividands)){
                    $dividand_polynomial_degree = mt_rand(3,5);
                    [$dividand_polynomial_degree, $roots] = $this->dimat_helper_functions->CreatePolynomialExpression($dividand_polynomial_degree, $lower, $upper);
                }

                // Creating the divisor polynomial expression
                $divisor_polynomial_degree = mt_rand(1,$dividand_polynomial_degree - 1);
                [$divisor_polynomial_expression, $roots] = $this->dimat_helper_functions->CreatePolynomialExpression($divisor_polynomial_degree);

                array_push($tasks, [[$dividand_polynomial_degree, $dividand_polynomial_expression],[$divisor_polynomial_degree, $divisor_polynomial_expression]]);
                array_push($dividands, $dividand_polynomial_expression);

                $division = $this->dimat_helper_functions->DividePolynomialExpressions($dividand_polynomial_expression, $divisor_polynomial_expression);
                $quotient_coefficients = $division["quotient_coefficients"];
                array_push($solutions, $division["solution"]);
                
                $task_description = "<div class=\"editable_box\"><label class=\"editable_label\">" . $polynomial_counter + 1 . ". csoport: </label></div><div class=\"editable_box\"><label class=\"editable_label\">Add meg a <b>(" . PrintServices::CreatePrintablePolynomial($dividand_polynomial_expression) . ")</b> / <b>(" . PrintServices::CreatePrintablePolynomial($divisor_polynomial_expression) . ")</b> hányados eredményét!</label></div>";
                
                $printable_solution = "<div class=\"editable_box\"><label class=\"editable_label\">" . $polynomial_counter + 1 . ". csoport: </label></div>" . "<table class=\"polynomial_division_table\">";
                $printable_solution = $printable_solution . "<tr>";
                $printable_solution = $printable_solution . "<th class=\"editable_box\"><label class=\"editable_label\"></label></th>" . PrintServices::CreatePrintableTableRowWithPolynomial($dividand_polynomial_expression, count($dividand_polynomial_expression)-1, "<th class=\"editable_box\"><label class=\"editable_label\">", "</label></th>");
                $printable_solution = $printable_solution . "<th class=\"editable_box\"><label class=\"editable_label\">:</label></th>";
                $printable_solution = $printable_solution . PrintServices::CreatePrintableTableRowWithPolynomial($divisor_polynomial_expression, count($divisor_polynomial_expression)-1, "<th class=\"editable_box\"><label class=\"editable_label\">", "</label></th>");
                $printable_solution = $printable_solution . "<th class=\"editable_box\"><label class=\"editable_label\">=</label></th>";
                if(count($quotient_coefficients) !== 0){
                    $printable_solution = $printable_solution . PrintServices::CreatePrintableTableRowWithPolynomial($quotient_coefficients, count($quotient_coefficients)-1, "<th class=\"editable_box\"><label class=\"editable_label\">", "</label></th>");
                }else{
                    $printable_solution = $printable_solution . "<th class=\"editable_box\"><label class=\"editable_label\">0</label></th>";
                }

                $td_counter = 0;
                foreach($division["steps"] as $step_counter => $step){
                    for($division_partial_step = 0; $division_partial_step < 2; $division_partial_step++){                        
                        $printable_solution = $printable_solution . "<tr>";
                        for($blank_cell_counter = 0; $blank_cell_counter < $td_counter; $blank_cell_counter++){
                            $printable_solution = $printable_solution . "<td class=\"editable_box\"><label class=\"editable_label\"></label></td>";
                        }
                        $partial_step = $step[$division_partial_step];
                        
                        if($division_partial_step === 0){
                            $printable_solution = $printable_solution .  "<td style=\"border-bottom:1px solid black\" class=\"editable_box\"><label class=\"editable_label\">-1*(</label></td>";
                            $printable_solution = $printable_solution . PrintServices::CreatePrintableTableRowWithPolynomial($partial_step, count($dividand_polynomial_expression) - 1 - floor($td_counter/2), "<td style=\"border-bottom:1px solid black\" class=\"editable_box\"><label class=\"editable_label\">", "</label></td>");
                            $printable_solution = $printable_solution .  "<td style=\"border-bottom:1px solid black\" class=\"editable_box\"><label class=\"editable_label\">)</label></td>";
                        }else{
                            $printable_solution = $printable_solution . PrintServices::CreatePrintableTableRowWithPolynomial($partial_step, count($dividand_polynomial_expression) - 1 - floor($td_counter/2), "<td class=\"editable_box\"><label class=\"editable_label\">", "</label></td>");
                            $new_in_row = $dividand_polynomial_expression[count($divisor_polynomial_expression) + $step_counter] ?? "";
                            if($new_in_row !== ""){
                                $printable_solution = $printable_solution . "<td class=\"editable_box\"><label class=\"editable_label\">" . PrintServices::PlusMinus($new_in_row) . "</label></td><td class=\"editable_box\"><label class=\"editable_label\">" . PrintServices::CreatePrintablePolynomialCoefficient(abs($new_in_row), count($partial_step), count($dividand_polynomial_expression) - 1 - floor($td_counter/2), true) . "</label></td>";
                            }
                        }

                        $td_counter++;

                        $printable_solution = $printable_solution . "</tr>";
                    }
                }

                $printable_solution = $printable_solution . "</tr>";
                $printable_solution = $printable_solution . "</table>";

                array_push($descriptions, $task_description);
                array_push($printable_solutions, $printable_solution);
            }
            
            return array("data" => $tasks , "descriptions" => $descriptions, "solutions" => $solutions, "printable_solutions" => $printable_solutions);
        }

        /**
         * This private method will generate a set of tasks related to the eight main topic - second subtopic of Discrete Mathematics II.
         * 
         * The subtask is about determining the polynomial multiplication.
         * 
         * Per subtask:
         * 
         * Creates a polynomial expression with degree of 3 - 5 and of coefficients (whole numbers) from the [-10,10] interval.
         * Creates a polynomial expression with degree of 1 - 5 and of coefficients (whole numbers) from the [-10,10] interval.
         * Picks the modulo (whole number) from the [2, 80] interval.
         * Determines product of first polynomial and second polynomial expressions, then takes the modulo for each coefficient.
         * 
         * @param int $number_of_pairs The number of pairs of polynomials which is a positive whole number. The default value is 1.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        private function CreatePolynomialMultiplicationSubtask($number_of_pairs = 1){
            $lower = -10;
            $upper = 10;
            $tasks = [];
            $multiplicands = [];
            $solutions = [];
            $printable_solutions = ["<div class=\"editable_box\"><label class=\"editable_label\">Megoldás:</label></div>"];
            $descriptions = [];

            for($polynomial_counter = 0; $polynomial_counter < $number_of_pairs; $polynomial_counter++){
                // Creating the multiplicand polynomial expression of degree between 3 and 5.
                // If this polynomial expression is already created, then a new one will be created.
                $multiplicand_polynomial_degree = mt_rand(3,5);
                [$multiplicand_polynomial_expression, $roots] = $this->dimat_helper_functions->CreatePolynomialExpression($multiplicand_polynomial_degree, $lower, $upper);
                if(in_array($multiplicand_polynomial_expression, $multiplicands)){
                    $multiplicand_polynomial_degree = mt_rand(3,5);
                    [$multiplicand_polynomial_expression, $roots] = $this->dimat_helper_functions->CreatePolynomialExpression($multiplicand_polynomial_degree, $lower, $upper);
                }

                // Creating the multiplier polynomial expression
                $multiplier_polynomial_degree = mt_rand(1,5);
                [$multiplier_polynomial_expression, $roots] = $this->dimat_helper_functions->CreatePolynomialExpression($multiplier_polynomial_degree);

                // Creating a modulo between 2 and 80
                $modulo = mt_rand(2,80);
                array_push($tasks, [[$multiplicand_polynomial_degree, $multiplicand_polynomial_expression],[$multiplier_polynomial_degree, $multiplier_polynomial_expression], $modulo]);
                array_push($multiplicands, $multiplicand_polynomial_expression);

                // Getting the product polynomial expressions
                $product = $this->dimat_helper_functions->MultiplyPolynomialExpressions($multiplicand_polynomial_expression, $multiplier_polynomial_expression, $modulo);
                $before_modulo = $product["before_modulo"];
                array_push($solutions, $product["product"]);
                
                $task_description = "<div class=\"editable_box\"><label class=\"editable_label\">" . $polynomial_counter + 1 . ". csoport: </label></div><div class=\"editable_box\"><label class=\"editable_label\">Add meg a <b>(" . PrintServices::CreatePrintablePolynomial($multiplicand_polynomial_expression) . ")</b> * <b>(" . PrintServices::CreatePrintablePolynomial($multiplier_polynomial_expression) . ")</b> szorzás eredményét a \u{2124}<sub>" . $modulo . "</sub> felett!</label></div>";
                $printable_solution = "<div class=\"editable_box\"><label class=\"editable_label\">" . $polynomial_counter + 1 . ". csoport: </label></div><div class=\"editable_box\"><label class=\"editable_label\">" . "(" . PrintServices::CreatePrintablePolynomial($multiplicand_polynomial_expression) . ") * (" . PrintServices::CreatePrintablePolynomial($multiplier_polynomial_expression) . ") = (";
                $printable_solution = $printable_solution . PrintServices::CreatePrintablePolynomialByPairs($before_modulo);
                $printable_solution = $printable_solution . ") % " . $modulo . " = ";
                $printable_solution = $printable_solution . PrintServices::CreatePrintablePolynomialByPairs($product["product"]) . "</label></div>";

                array_push($descriptions, $task_description);
                array_push($printable_solutions, $printable_solution);
            }
            
            return array("data" => $tasks , "descriptions" => $descriptions, "solutions" => $solutions, "printable_solutions" => $printable_solutions);
        }

        /**
         * This private method will generate a set of tasks related to the nineth main topic - second subtopic of Discrete Mathematics II.
         * 
         * The subtask is about giving the Lagrange interpolation for the generated points.
         * 
         * Importantly, the polynomial expressions (which happen to be the solutions for the subtasks) are generated first, then the points will be created for each of them. The number of points are greater, or eqaul than the degree of the respective polinomial expression + 1, and all of them will lie on their corresponding polynomial expression.
         * This alternative approach (this reverse method) is used, because this way the coefficients of the interpolation polynomial expressions will be inherently whole numbers (since the created polynomial expressions' coefficients are whole numbers all the time), that is, "will be nice".
         * 
         * @param int $number_of_pairs The number of pairs of polynomials which is a positive whole number. The default value is 1.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        private function CreateLagrangeInterpolationSubtask($number_of_points = 3){
            $lower = -10;
            $upper = 10;
            $tasks = [];
            $solutions = [];
            $polynomial_expressions = [];
            $printable_solutions = ["<div class=\"editable_box\"><label class=\"editable_label\">Megoldás:</label></div>"];
            $descriptions = [];

            for($polynomial_counter = 0; $polynomial_counter < $number_of_points; $polynomial_counter++){
                $polynomial_degree = mt_rand(2,3);
                [$polynomial_expression, $roots] = $this->dimat_helper_functions->CreatePolynomialExpression($polynomial_degree);
                if(in_array($polynomial_expression, $polynomial_expressions)){
                    $polynomial_degree = mt_rand(2,3);
                    [$polynomial_expression, $roots] = $this->dimat_helper_functions->CreatePolynomialExpression($polynomial_degree);
                }
                array_push($polynomial_expressions, $polynomial_expressions);
                $points = $this->dimat_helper_functions->CreatePoints($polynomial_degree + 1, $lower, $upper, $polynomial_expression);
                array_push($tasks,$points);

                $interpolation = $this->dimat_helper_functions->DetermineLagrangeInterpolation($points);
                array_push($solutions, $interpolation);
                $base_polynomial_expressions = $interpolation["base_polynomial_expressions"];

                $task_description = "<div class=\"editable_box\"><label class=\"editable_label\">" . $polynomial_counter + 1 . ". csoport: </label></div><div class=\"editable_box\"><label class=\"editable_label\">Add meg a Lagrange- interpoláció segítségével azt a " . $polynomial_degree . "-d fokú polinomot, amely illeszkedik a <b>" . PrintServices::CreatePrintablePoints($points) . "</b> pontokra!</label></div>";
                $printable_solution = "<div class=\"editable_box\"><label class=\"editable_label\">" . $polynomial_counter + 1 . ". csoport: </label></div><div class=\"editable_box\"><label class=\"editable_label\">Add meg a Lagrange- interpoláció segítségével azt a " . $polynomial_degree . "-d fokú polinomot, amely illeszkedik a <b>" . PrintServices::CreatePrintablePoints($points) . "</b> pontokra!</label></div>";
                $sum_text = "";
                foreach($base_polynomial_expressions as $base_polynomial_counter => $base_polynomial_expression){
                    if($base_polynomial_counter !== 0){
                        $sum_text = $sum_text . PrintServices::PlusMinus($points[$base_polynomial_counter][1]) . abs($points[$base_polynomial_counter][1]);
                    }else{
                        $sum_text = $sum_text . $points[$base_polynomial_counter][1];
                    }
                    $polynomial_text = PrintServices::CreatePrintablePolynomialByPairs($base_polynomial_expression);
                    $printable_solution = $printable_solution . "<div class=\"editable_box\"><label class=\"editable_label\">l<sub>(" . $points[$base_polynomial_counter][0] . ", " . $points[$base_polynomial_counter][1] . ")</sub> = ";
                    $printable_solution = $printable_solution . $polynomial_text . "</label></div>";
                    $sum_text = $sum_text . " * (" .  $polynomial_text . ")";
                }
                $printable_solution = $printable_solution . "<div class=\"editable_box\"><label class=\"editable_label\"><b>L[x] = </b>" . $sum_text . " = <b>" . PrintServices::CreatePrintablePolynomialByPairs($interpolation["polynomial_expression"]) . "</b>" . "</label></div>";

                array_push($descriptions, $task_description);
                array_push($printable_solutions, $printable_solution);
            }
            
            return array("data" => $tasks , "descriptions" => $descriptions, "solutions" => $solutions, "printable_solutions" => $printable_solutions);
        }

        /**
         * This private method will generate a set of tasks related to the nineth main topic - second subtopic of Discrete Mathematics II.
         * 
         * The subtask is about giving the Newton interpolation for the generated points.
         * 
         * Importantly, the polynomial expressions (which happen to be the solutions for the subtasks) are generated first, then the points will be created for each of them. The number of points are greater, or eqaul than the degree of the respective polinomial expression + 1, and all of them will lie on their corresponding polynomial expression.
         * This alternative approach (this reverse method) is used, because this way the coefficients of the interpolation polynomial expressions will be inherently whole numbers (since the created polynomial expressions' coefficients are whole numbers all the time), that is, "will be nice".
         * Other than this, this function will use the Newton interpolation to create the final polynomial expressions (the ones generated above).
         * It also creates a visual solution containing the table form of the solution, this will be used in the test (or seminar task) generation part.
         * 
         * @param int $number_of_pairs The number of pairs of polynomials which is a positive whole number. The default value is 1.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        private function CreateNewtonInterpolationSubtask($number_of_points = 3){
            $lower = -5;
            $upper = 5;
            $tasks = [];
            $solutions = [];
            $polynomial_expressions = [];
            $printable_solutions = ["<div class=\"editable_box\"><label class=\"editable_label\">Megoldás:</label></div>"];
            $descriptions = [];

            for($polynomial_counter = 0; $polynomial_counter < $number_of_points; $polynomial_counter++){
                $polynomial_degree = mt_rand(3,4);
                [$polynomial_expression, $roots] = $this->dimat_helper_functions->CreatePolynomialExpression($polynomial_degree);
                if(in_array($polynomial_expression, $polynomial_expressions)){
                    $polynomial_degree = mt_rand(3,4);
                    [$polynomial_expression, $roots] = $this->dimat_helper_functions->CreatePolynomialExpression($polynomial_degree);
                }
                array_push($polynomial_expressions, $polynomial_expressions);
                $points = $this->dimat_helper_functions->CreatePoints($polynomial_degree + 1, $lower, $upper, $polynomial_expression);
                array_push($tasks,$points);

                $interpolation = $this->dimat_helper_functions->DetermineNewtonInterpolation($points);
                array_push($solutions, $interpolation);
                $table_data = $interpolation["table_data"];

                $task_description = "<div class=\"editable_box\"><label class=\"editable_label\">" . $polynomial_counter + 1 . ". csoport: </label></div><div class=\"editable_box\"><label class=\"editable_label\">Add meg a Newton- interpoláció segítségével azt a " . $polynomial_degree . "-d fokú polinomot, amely illeszkedik a <b>" . PrintServices::CreatePrintablePoints($points) . "</b> pontokra!</label></div>";
                $printable_solution = "<div class=\"editable_box\"><label class=\"editable_label\">" . $polynomial_counter + 1 . ". csoport: </label></div><div class=\"editable_box\"><label class=\"editable_label\">Add meg a Newton- interpoláció segítségével azt a " . $polynomial_degree . "-d fokú polinomot, amely illeszkedik a <b>" . PrintServices::CreatePrintablePoints($points) . "</b> pontokra!</label></div>";
                $printable_solution = $printable_solution . "<table class=\"stair_table\">";
                $printable_solution = $printable_solution . "<tr>";
                for($column_counter=0; $column_counter < count($points) + 1; $column_counter++){
                    if($column_counter === 0){
                        $printable_solution = $printable_solution . "<th class=\"editable_box\"><label class=\"editable_label\">x<sub>i</sub></label></th>";
                    }elseif($column_counter === 1){
                        $printable_solution = $printable_solution . "<th class=\"editable_box\"><label class=\"editable_label\">y<sub>i</sub></label></th>";
                    }else{
                        $printable_solution = $printable_solution . "<th class=\"editable_box\"><label class=\"editable_label\">" . $column_counter - 1 . ".lépés</label></th>";
                    }
                }
                $printable_solution = $printable_solution . "</tr>";
                for($row_counter=0; $row_counter < 2*count($points); $row_counter++){
                    $printable_solution = $printable_solution . "<tr>";
                    for($column_counter=0; $column_counter < count($points) + 1; $column_counter++){
                        $width = ($column_counter === 0 || $column_counter === 1)?10:80/count($points);
                        if($column_counter === 0 || $column_counter === 1){
                            if($row_counter % 2 === 0){
                                $printable_solution = $printable_solution . "<td class=\"editable_box\" style=\"border-left: 1px solid black; border-top: 1px solid black; width: $width%; border-right: 1px solid black\"><label class=\"editable_label\">" 
                                . $points[$row_counter/2][$column_counter]??"" . "</label></td>";
                            }else{
                                $printable_solution = $printable_solution . "<td class=\"editable_box\" style=\"border-left: 1px solid black; width: $width%; border-right: 1px solid black;"; 
                                if($row_counter === 2*count($points) - 1){
                                    $printable_solution = $printable_solution . "border-bottom: 1px solid black; padding-top:3%";
                                }
                                $printable_solution = $printable_solution . "\"><label class=\"editable_label\"></label></td>";
                            }
                        }else{
                            if($row_counter - $column_counter > -2 && $row_counter < 2*count($points) - ($column_counter-1)){
                                if(abs($column_counter - $row_counter) % 2 === 1){
                                    $column_index = $column_counter - 2;
                                    $row_index = floor(($row_counter - $column_counter + 1)/2);
                                    
                                    $denominator_second_index =  $row_index + 1;
                                    $denominator_first_index = $row_index + 1 + $column_index + 1;

                                    $nominator_first =  "y<sub>" . $denominator_first_index . "</sub>";
                                    $nominator_second = "y<sub>" . $denominator_second_index . "</sub>";
                                    if($column_counter > 2){
                                        $nominator_first =  "y<sub>" . $denominator_second_index + 1 ."," . $denominator_second_index + $column_index + 1 . "</sub>";
                                        $nominator_second = "y<sub>" . $denominator_first_index - $column_index - 1 ."," . $denominator_first_index - 1 . "</sub>";
                                    }

                                    $cell_content = "($nominator_first - $nominator_second)/(x<sub>" . $denominator_first_index . "</sub>-x<sub>" . $denominator_second_index . "</sub>) = ";

                                    $content = $table_data[$column_counter - 2]??"";
                                    if(is_array($content)){
                                        $cell_content = $cell_content . $content[floor(($row_counter - $column_counter + 1)/2)]??"";
                                    }

                                    $printable_solution = $printable_solution . "<td class=\"editable_box\" style=\"border-top: 1px solid black; width: $width%; border-right: 1px solid black\"><label class=\"editable_label\">$cell_content</label></td>";
                                }else{
                                    $printable_solution = $printable_solution . "<td class=\"editable_box no_content_cell\" style=\"width: $width%;";
                                    if($row_counter === 2*count($points) - ($column_counter-1) - 1){
                                        $printable_solution = $printable_solution . "border-bottom: 1px solid black";
                                    }
                                    $printable_solution = $printable_solution . "\"><label class=\"editable_label\"></label></td>";
                                }
                            }else{
                                $printable_solution = $printable_solution . "<td class=\"editable_box\" style =\"border: 0px\"><label class=\"editable_label\"></label></td>";
                            }
                        }
                    }
                    $printable_solution = $printable_solution . "</tr>";
                }
                $printable_solution = $printable_solution . "</table>"; 
                $printable_solution .=  "<div class=\"editable_box\"><label class=\"editable_label\">N[x]=" . PrintServices::CreatePrintablePolynomial($polynomial_expression) . ".</label></div>";
                
                array_push($descriptions, $task_description);
                array_push($printable_solutions, $printable_solution);
            }
            
            return array("data" => $tasks , "descriptions" => $descriptions, "solutions" => $solutions, "printable_solutions" => $printable_solutions);
        }

        /**
         * This private method creates a printable version for a diophantine equation.
         * 
         * @param string $first_variable_name The first parameter's name in the equation. The default is "x".
         * @param string $second_variable_name The second parameter's name in the equation. The default is "y".
         * @param array $diophantine_equation An array containing the numbers of the diophantine equation.
         * @param array $steps An array containing the solution steps.
         * @param array $solution An array containing the final solution of the equation.
         * 
         * @return string Returns a printable version of the diophantine equation.
         */
        private function CreateDiophantineSolutionText($first_variable_name = "x", $second_variable_name = "y", $diophantine_equation, $steps, $solution){
            $task_solution = "";
            
            $y_coef_sign = PrintServices::PlusMinus($diophantine_equation[1]);
            $x_coef_sign = PrintServices::PlusMinus(-1*$diophantine_equation[0]);
            $diophantine_equation[1] = abs($diophantine_equation[1]);
            $task_solution = $task_solution . "<div class=\"editable_box\"><label class=\"editable_label\">" . $diophantine_equation[0] . "*$first_variable_name" . PrintServices::PlusMinus($diophantine_equation[1]) . $diophantine_equation[1] . "*$second_variable_name = " . $diophantine_equation[2] . " | -1*" . $diophantine_equation[1] . "*$second_variable_name \u{2194}" 
                . $diophantine_equation[0] . "*$first_variable_name = "  . $diophantine_equation[2] . PrintServices::PlusMinus(-1*$diophantine_equation[1]) . $diophantine_equation[1] . "*$second_variable_name " . " | (mod" . $diophantine_equation[1] . ") \u{2192}</label></div>";
            $task_solution = $task_solution . "<div class=\"editable_box\"><label class=\"editable_label\">" . PrintServices::CreatePrintableCongruenceSolution($first_variable_name, $steps) . "</label></div>";
            $task_solution = $task_solution . "<div class=\"editable_box\"><label class=\"editable_label\">" . PrintServices::CreatePrintableModuloEquivalence($first_variable_name, $solution[0][1], $solution[0][2], "") . "</label></div>";
            $task_solution = $task_solution . "<div class=\"editable_box\"><label class=\"editable_label\">" . "<b>$second_variable_name=</b>(" . $diophantine_equation[2] . $x_coef_sign . abs($diophantine_equation[0]) . "*$first_variable_name)/(" . $diophantine_equation[1] . ")"
            . " = (" . $diophantine_equation[2] . $x_coef_sign . abs($diophantine_equation[0]) . " * (" . $solution[0][1] . PrintServices::PlusMinus($solution[0][2]) .  abs($solution[0][2])  . "*k))/(" . $diophantine_equation[1] . ")"
            . " =<b>" .  $solution[1][0] . PrintServices::PlusMinus($solution[1][1]) .  abs($solution[1][1])  . "*k (k \u{2208} \u{2124})</b></label></div>";
            
            return $task_solution;
        }

        /**
         * This private method create the CRT subtask's task description and task solution text.
         * 
         * @param array $new_congruence_system An array containing the linear congruences in the CRT.
         * @param array $actual_solution An array containing the solution and solution steps of the CRT.
         * 
         * @return array Returns an array containing the CRT subtask's description and solution text.
         */
        private function CreateCRTSolutionText($new_congruence_system, $actual_solution){
            $number_of_congruences_per_system = count($new_congruence_system);
            $steps = $actual_solution["steps"];
            $detailed_steps = $actual_solution["detailed_steps"];

            $task_description = "<div class=\"editable_box\"><label class=\"editable_label\"> Add meg a következő lineáris kongruenciarendszer megoldását!</label></div>";
            $task_solution = "<div class=\"editable_box\"><label class=\"editable_label\"><b>1. lépés: lineáris kongruenciák egyszerűsítése</b></label></div>";
            for($coungruence_counter = 0; $coungruence_counter < count($new_congruence_system); $coungruence_counter++){
                $task_description = $task_description . "<div class=\"editable_box\"><label class=\"editable_label\">" . PrintServices::CreatePrintableCongruence("x", $new_congruence_system[$coungruence_counter]) . "</label></div>";
                $task_solution = $task_solution . "<div class=\"editable_box\"><label class=\"editable_label\">" . $coungruence_counter + 1 . ". lineáris kongruencia megoldása:</label></div><div class=\"editable_box\"><label class=\"editable_label\">" . PrintServices::CreatePrintableCongruenceSolution("x", $detailed_steps[$coungruence_counter]) . "</label></div>";
            }
            $task_description = $task_description . "";

            $merged_counter = 0;
            for($congruence_counter = 0; $congruence_counter < $number_of_congruences_per_system;){
                if($congruence_counter === 0){
                    $task_solution = $task_solution . "<div class=\"editable_box\"><label class=\"editable_label\"><b>2. lépés: 1. és 2. kongruencia egyesítése</b></label></div>";
                    $first_congruence = $steps[0];
                    $second_congruence = $steps[1];
                    $bottom_index_c_first = "1";
                    $bottom_index_c_second= "2";
                    $modulo_bottom_index = "1,2";
                    $congruence_counter += 2;
                }else{
                    $task_solution = $task_solution . "<div class=\"editable_box\"><label class=\"editable_label\"><b>" . $congruence_counter + 1 . ". lépés: 1. - $congruence_counter. és " .  $congruence_counter + 1  . ". kongruencia egyesítése:</b></label></div>";
                    $first_congruence = $steps[$number_of_congruences_per_system + $merged_counter];
                    $second_congruence = $steps[$congruence_counter];
                    $bottom_index_c_first = "1," . $congruence_counter;
                    $bottom_index_c_second= $congruence_counter + 1;
                    $modulo_bottom_index = $bottom_index_c_first;
                    $congruence_counter++;
                    $merged_counter++;
                }

                $task_solution = $task_solution . "<div class=\"editable_box\"><label class=\"editable_label\">";
                $task_solution = $task_solution . PrintServices::CreatePrintableCongruence("x", $first_congruence) . "<br>";
                $task_solution = $task_solution . PrintServices::CreatePrintableCongruence("x", $second_congruence) . "<br>";
                $task_solution = $task_solution . "</label></div>";
                
                $bottom_index = $merged_counter + 1;
                $diophantine_equation_solution = $detailed_steps[$number_of_congruences_per_system + $merged_counter];
                $task_solution = $task_solution . "<div class=\"editable_box\"><label class=\"editable_label\"><b>" . $merged_counter + 2 . ".1. lépés: az m<sub>" . $bottom_index . ",1</sub> * " .  $first_congruence[2] . " + m<sub>" . $merged_counter + 1 . ",2</sub> * " . $second_congruence[2] . " = 1 lineáris diofantikus egyenlet megoldása:</b></label></div>";
                $task_solution = $task_solution . "<div class=\"editable_box\"><label class=\"editable_label\">" . $this->CreateDiophantineSolutionText("m<sub>" . $modulo_bottom_index . ",1</sub>", "m<sub>" . $modulo_bottom_index . ",2</sub>", [$first_congruence[2],$second_congruence[2], 1], $diophantine_equation_solution["steps"],  $diophantine_equation_solution["solution"]) . "</label></div>";
            
                $solution = $diophantine_equation_solution["solution"];
                $task_solution = $task_solution . "<div class=\"editable_box\"><label class=\"editable_label\"><b>" . $merged_counter + 2 . ".2. lépés: Új együtthatók megállapítása</b></label></div>";
                $task_solution = $task_solution . "<div class=\"editable_box\"><label class=\"editable_label\"><b>c<sub>1, " . $bottom_index + 1 . "</sub> =</b>"
                . "m<sub>" . $modulo_bottom_index . ",1</sub> * " . "m<sub>" . $bottom_index_c_first . "</sub> * " . "c<sub>" . $bottom_index_c_second . "</sub>" . " + "
                . "m<sub>" . $modulo_bottom_index . ",2</sub> * " . "m<sub>" . $bottom_index_c_second . "</sub> * " . "c<sub>" . $bottom_index_c_first . "</sub>"  .  " = "
                . "<b>" . $solution[0][1] . " * " . $first_congruence[2] . " * " . $second_congruence[1] . " + " . $solution[1][0] . " * " . $second_congruence[2] . " * " . $first_congruence[1] ." = "
                . $solution[0][1] * $first_congruence[2] * $second_congruence[1] + $solution[1][0] * $second_congruence[2] * $first_congruence[1]
                . "</b></label></div>";

                $task_solution = $task_solution . "<div class=\"editable_box\"><label class=\"editable_label\">";
                $task_solution = $task_solution . "<b>" . PrintServices::CreatePrintableCongruence("x", $steps[$number_of_congruences_per_system + $merged_counter]) . "</b>";
                $task_solution = $task_solution . "</label></div>";
            }
            
            return array("task_description"=>$task_description, "task_solution"=>$task_solution);
        }

        /**
         * This private method create the Horner- scheme subtask's task description and task solution text.
         * 
         * @param array $polynomial_expression An array containing the coefficients of the polynomial expression.
         * @param array $places An array containing the places where the Horner- scheme will be determined.
         * @param array $horner_schemes The steps of the Horner- scheme.
         * 
         * @return array Returns an array containing the Horner- scheme subtask's description and solution text.
         */
        private function CreateHornerSchemeText($polynomial_expression, $places, $horner_schemes){
            $task_description = "<div class=\"editable_box\"><label class=\"editable_label\">Add meg a ";
            $task_solution = "<table class=\"solution_table\">";
            $task_solution = $task_solution . "<tr><th class=\"editable_box\"><label class=\"editable_label\">x<sub>i</sub></label></th>";
            $degree = count($polynomial_expression) - 1;
            foreach($polynomial_expression as $coefficient_counter => $coefficient){
                $sign = 1;
                if($coefficient_counter !== 0){
                    $task_description = $task_description . PrintServices::PlusMinus($coefficient);

                    if($coefficient < 0){
                        $sign = -1;
                    }

                    $coefficient = abs($coefficient);
                }
                $task_description = $task_description . PrintServices::CreatePrintablePolynomialCoefficient($coefficient, $coefficient_counter, $degree, true);
                $task_solution = $task_solution . "<th class=\"editable_box\"><label class=\"editable_label\">p<sub>" . $degree - $coefficient_counter . "</sub> = " . $sign * $coefficient . "</label></th>";
            }
            $task_description = $task_description . " polinom helyettesítési értékét a ";
            $task_solution = $task_solution . "<th class=\"editable_box\"><label class=\"editable_label\">P[x<sub>i</sub>]</label></th>";
            $task_solution = $task_solution . "</tr>";
            
            foreach($horner_schemes as $row_counter => $horner_scheme){
                if($row_counter !== 0){
                    $task_description = $task_description . ", ";
                }
                $task_description = $task_description . $places[$row_counter];

                $task_solution = $task_solution . "<tr>";
                $task_solution = $task_solution . "<td class=\"editable_box\" class=\"editable_box\"><label class=\"editable_label\">x<sub>" . $row_counter + 1 . "</sub> = " . $places[$row_counter] . "</label></td><td class=\"editable_box\" class=\"editable_box\"><label class=\"editable_label\"></label></td>";
                foreach($horner_scheme as $cell_counter => $cell_data){
                    $task_solution = $task_solution . "<td class=\"editable_box\" class=\"editable_box\"><label class=\"editable_label\">" . $cell_data . "</label></td>";
                }
                $task_solution = $task_solution . "</tr>";
            }
            $task_description = $task_description . " helyeken!</label></div>";
            $task_solution = $task_solution . "</table>";

            return array("task_description"=>$task_description, "task_solution"=>$task_solution);
        }
    }


?>
