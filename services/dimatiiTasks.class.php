<?php
    /**
     * This is a helper class which contains task generator functions related to Discrete Mathematics II..
     * 
    */
    class DimatiiTasks extends Tasks{        
        /**
         * 
         * The contructor for DimatiiTasks class.
         * 
         * Here the inherited members will be set.
         * Based on the $topic parameter a new set of tasks will be generated,
         * 
         * @param string $topic The topic id for task generation,
         * 
         * @return void
         */
        public function __construct($topic){
            $this->SetTaskDescription([]);
            $this->SetTaskSolution([]);
            $this->SetDefinitions("");

            $this->dimat_helper_functions = new DimatiiHelperFunctions();

            mt_srand(time()); // Seeding the random number generator with the current time (we may change this overtime...)

            switch($topic){
                case "0":{
                    $this->CreateTaskOne();
                };
                break;
                case "1":{
                    $this->CreateTaskTwo();
                };
                break;
                case "2":{
                    $this->CreateTaskThree();
                };
                break;
                case "3":{
                    $this->CreateTaskFour();
                };
                break;
                case "4":{
                    $this->CreateTaskFive();
                };
                break;
                case "5":{
                    $this->CreateTaskSix();
                };
                break;
                case "6":{
                    $this->CreateTaskSeven();
                };
                break;
                case "7":{
                    $this->CreateTaskEight();
                };
                break;
                case "8":{
                    $this->CreateTaskNine();
                };
                break;
                case "9":{
                    $this->CreateTaskTen();
                };
                break;
                default:break;
            }
        }

        /**
         * 
         * This function is responsible for creating the first set of tasks of Discrete Mathematics II. related to division, number of dividors and congruencies.
         * 
         * ...Subtasks created here...
         * 
         * @return void
         */
        private function CreateTaskOne(){
            // Task creation part:
            // 2 pairs for division subtask (1 pair/ subtask)
            // 2 numbers for prime factorization subtask (1 number/ subtask)
            // 2 numbers for divisor counting subtask (1 number/ subtask)
            // 2 pairs for congruency subtask (1 pair/ subtask)
            $divide_pairs = $this->dimat_helper_functions->CreatePairsOfNumbers(2, -1000, 1000);
            $prime_factorization_numbers = $this->dimat_helper_functions->CreatePairsOfNumbers(1, 100, 1000)[0];
            $positive_divisor_count_numbers = $this->dimat_helper_functions->CreatePairsOfNumbers(1, 100, 1000)[0];
            $congruency_pairs = $this->dimat_helper_functions->CreatePairsOfNumbers(2, -1000, 1000, false, true);

            // Adding the data to the task array
            $task_array = array(
                "task_description" => "Old meg a következő osztással, osztók számával és kongruencia definíciójával kapcsolatos feladatokat!",
                "divide_pairs" => $divide_pairs,
                "prime_factorization_numbers" => $prime_factorization_numbers,
                "positive_divisor_count_numbers" => $positive_divisor_count_numbers,
                "congruency_pairs" => $congruency_pairs
            );
            $this->SetTaskDescription($task_array);

            //Solutions part:
            $solution_array = [
                "divide_pairs_solution" => $this->dimat_helper_functions->DetermineQuotientAndResidue($divide_pairs),
                "prime_factorization_solution" => $this->dimat_helper_functions->DeterminePrimeFactorization($prime_factorization_numbers),
                "positive_divisor_count_solution" => $this->dimat_helper_functions->DetermineNumberOfDivisors($positive_divisor_count_numbers)
            ];
            $this->SetTaskSolution($solution_array);

            // Definition part:
        }

        /**
         * 
         * This function is responsible for creating the second set of tasks of Discrete Mathematics II. related to residue systems.
         * 
         * ...Subtasks created here...
         * 
         * @return void
         */
        private function CreateTaskTwo(){    
            $crs_numbers = $this->dimat_helper_functions->CreatePairsOfNumbers(1, 5, 15)[0];
            $rrs_numbers = $this->dimat_helper_functions->CreatePairsOfNumbers(1, 5, 25)[0];
            $rrs_size_numbers = $this->dimat_helper_functions->CreatePairsOfNumbers(1, 1000, 5000)[0];

            $multiplicand_rs_size = mt_rand(3,7);
            $multiplier_rs_size = mt_rand(3,7);
            $rrs_pairs = [3,5]; //$this->dimat_helper_functions->CreatePairsOfNumbers(1, 2, 10)[0];

            $task_array = array(
                "task_description" => "Old meg a következő maradékrendszerekkel kapcsolatos feladatokat!",
                "crs_numbers" => $crs_numbers,
                "rrs_numbers" => $rrs_numbers,
                "rrs_size_numbers" => $rrs_size_numbers,
                "multiply_rrs" => [$multiplicand_rs_size, $multiplier_rs_size, $rrs_pairs]
            );
            $this->SetTaskDescription($task_array);
        }

        /**
         * 
         * This function is responsible for creating the third set of tasks of Discrete Mathematics II. related to Eucleidan algorithm.
         * 
         * ...Subtasks created here...
         * 
         * @return void
         */
        private function CreateTaskThree(){
            $gcd_pairs = $this->dimat_helper_functions->CreatePairsOfNumbers(3, 30, 200);
            $step_counts = [];
            $eucleidan_algorithm = [];
            $gcd_array = [];
            $lcm_array = [];
            foreach($gcd_pairs as $index => $pair){
                $algorithm = $this->dimat_helper_functions->DetermineGCDWithEucleidan($pair);
                array_push($eucleidan_algorithm, $algorithm["steps"]);
                array_push($gcd_array, $algorithm["solution"]); // We need the smaller number from the last step (it is the residue of the last but one step)
                if($algorithm["solution"] !== 0){
                    array_push($lcm_array, ($pair[0]*$pair[1])/$algorithm["solution"]);
                }else{
                    array_push($lcm_array, "inf");
                }
                array_push($step_counts, count($algorithm["steps"]));
            }


            $task_array = array(
                "task_description" => "Old meg a következő Eukleidészi algoritmussal kapcsolatos feladatokat!",
                "gcd_pairs" => $gcd_pairs,
                "step_counts" => $step_counts
            );
            $this->SetTaskDescription($task_array);
        }

        /**
         * 
         * This function is responsible for creating the fourth set of tasks of Discrete Mathematics II. related to linear congruencies.
         * 
         * ...Subtasks created here...
         * 
         * @return void
         */
        private function CreateTaskFour(){
         $linear_congrences = $this->dimat_helper_functions->CreateTripletsOfNumbersWithoutZero(3, -100, 100);
            $linear_congrences_algorithm = [];
            $solution_array = [];
            foreach($linear_congrences as $index => $triplet){
                $algorithm = $this->dimat_helper_functions->DetermineLinearCongruenceSolution($triplet);
                array_push($linear_congrences_algorithm, $algorithm["steps"]);
                array_push($solution_array, $algorithm["solution"]);
            }


            $task_array = array(
                "task_description" => "Old meg a következő lineáris kongruenciákkal kapcsolatos feladatokat!",
                "linear_congrences" => $linear_congrences,
                "steps" => $linear_congrences_algorithm,
                "solution" => $solution_array
            );
            $this->SetTaskDescription($task_array);
        }

        /**
         * 
         * This function is responsible for creating the fifth set of tasks of Discrete Mathematics II. related to linear diophantine equations.
         * 
         * ...Subtasks created here...
         * 
         * @return void
         */
        private function CreateTaskFive(){
            $congruency_triplets = $this->dimat_helper_functions->CreateSolvableLinearCongruencies(2, true, -50, 50); // ax \equiv b (mod c)
            
            // Divide b into two numbers, so that the first is divisable by a, and the second is divisible by c
            // ax + cy = b
            // Let b between 100-1000
            // Let a and c be strictly smaller than b
            $b = mt_rand(100,1000);
            $c = mt_rand(2,1000);
            $a = mt_rand(2,1000);
            while($a > $b 
                || $c > $b 
                || $a === $c 
                || $b % $this->dimat_helper_functions->DetermineGCDWithIteration([$a,$c]) !== 0){
                $c = mt_rand(100,1000);
                $a = mt_rand(100,1000);
            }
            // $ax \equiv $b (mod $c) => $a*x + $c*y = $b
            array_push($congruency_triplets, [$a,$b,$c]);

            $diophantine_algorithm = [];
            $diophantine_equation = [];
            foreach($congruency_triplets as $equation_counter => $triplet){
                // Triplet in the form of $triplet[0]*x \equiv $triplet[1] (mod $triplet[2]) -> $triplet[0]*x - $triplet[1] = $triplet[2]*y
                // Equation in the form of $triplet[0]*x + $triplet[2]*y = $triplet[1]
                $actual_diophantine_equation = [$triplet[0], $triplet[2], $triplet[1]];
                $algorithm_steps = $this->dimat_helper_functions->DetermineDiophantineEquationSolution($actual_diophantine_equation);
                array_push($diophantine_algorithm, $algorithm_steps);
                array_push($diophantine_equation, $actual_diophantine_equation);
            }

            $task_array = array(
                "task_description" => "Old meg a következő diofantoszi egyenletekkel kapcsolatos feladatokat!",
                "diophantine_equations" => [$diophantine_equation[0], $diophantine_equation[1]],
                "partition_number" => $diophantine_equation[2],
                "solution" => $diophantine_algorithm 
            );
            $this->SetTaskDescription($task_array);
        }

        /**
         * 
         * This function is responsible for creating the sixth set of tasks of Discrete Mathematics II. related to chinese remainder theorem.
         * 
         * ...Subtasks created here...
         * 
         * @return void
         */
        private function CreateTaskSix(){
            $divide_triplets = $this->dimat_helper_functions->CreateSolvableLinearCongruencies(2, true, 2, 1000);
            while($this->dimat_helper_functions->DetermineGCDWithIteration([$divide_triplets[0][2],$divide_triplets[1][2]]) !== 1){
                $divide_triplets = $this->dimat_helper_functions->CreateSolvableLinearCongruencies(2, true, 2, 1000);
            }
            $first_divide_triplet = $this->dimat_helper_functions->DetermineLinearCongruenceSolution($divide_triplets[0])["solution"];
            $second_divide_triplet = $this->dimat_helper_functions->DetermineLinearCongruenceSolution($divide_triplets[1])["solution"];

            $first_congruence_system_triplets = [$first_divide_triplet, $second_divide_triplet];
            $second_congruence_system_triplets = $this->dimat_helper_functions->CreateSolvableLinearCongruenciesForCRT(4, -50, 50);

            $first_solution = $this->dimat_helper_functions->DetermineLinearCongruenceSystemSolution($first_congruence_system_triplets);
            $second_solution = $this->dimat_helper_functions->DetermineLinearCongruenceSystemSolution($second_congruence_system_triplets);

            $task_array = array(
                "task_description" => "Old meg a következő kínai maradékrendszerrel kapcsolatos feladatokat!",
                "divide_triplets" => $divide_triplets,
                "first_congruence_system_triplets" => $first_congruence_system_triplets,
                "second_congruence_system_triplets" => $second_congruence_system_triplets,
                "first_solution" => $first_solution,
                "second_solution" => $second_solution,
            );
            $this->SetTaskDescription($task_array);
        }

        /**
         * 
         * This function is responsible for creating the seventh set of tasks of Discrete Mathematics II. related to horner table.
         * 
         * ...Subtasks created here...
         * 
         * @return void
         */
        private function CreateTaskSeven(){
            $task_array = array(
                "task_description" => "Old meg a következő Horner-táblázattal kapcsolatos feladatokat!",
                "polynomials" => [],
                "divide_polynomials" => []
            );
            
            for($counter = 0; $counter < 2; $counter++){
                $polynomial_degree = 2*$counter + 2;
                [$polynomial_expression, $roots] = $this->dimat_helper_functions->CreatePolynomialExpression($polynomial_degree);
                $places = $this->dimat_helper_functions->CreatePlacesWithRoots($polynomial_degree, $polynomial_degree - 2, $roots, -20, 20);
                array_push($task_array["polynomials"], [$polynomial_degree, $polynomial_expression, $places]);
            }

            [$polynomial_expression, $roots] = $this->dimat_helper_functions->CreatePolynomialExpression(5);
            $places = $this->dimat_helper_functions->CreatePlacesWithRoots(1, 0, $roots, -20, 20);
            $task_array["divide_polynomials"] = [5, $polynomial_expression, $places];

            $this->SetTaskDescription($task_array);

        }

        /**
         * 
         * This function is responsible for creating the eight set of tasks of Discrete Mathematics II. related to polinomial division and multiplication.
         * 
         * ...Subtasks created here...
         * 
         * @return void
         */
        private function CreateTaskEight(){
            $task_array = array(
                "task_description" => "Old meg a következő polinomok osztásával és szorzásával kapcsolatos feladatokat!",
                "divide_polynomials" => [],
                "multiply_polynomials" => []
            );
            
            for($counter = 0; $counter < 2; $counter++){
                $first_polynomial_degree = mt_rand(3,5);
                $second_polynomial_degree = mt_rand(1,3);
                [$first_polynomial_expression, $roots] = $this->dimat_helper_functions->CreatePolynomialExpression($first_polynomial_degree);
                [$second_polynomial_expression, $roots] = $this->dimat_helper_functions->CreatePolynomialExpression($second_polynomial_degree);
                if($counter === 0){
                    $key = "divide_polynomials";
                }else{
                    $key = "multiply_polynomials";
                }
                $task_array[$key] = [
                    [$first_polynomial_degree, $first_polynomial_expression], 
                    [$second_polynomial_degree, $second_polynomial_expression], 
                    mt_rand(2,80)
                ];
            }

            $this->SetTaskDescription($task_array);
        }

        /**
         * 
         * This function is responsible for creating the ninth set of tasks of Discrete Mathematics II. related to interpolations.
         * 
         * ...Subtasks created here...
         * 
         * @return void
         */
        private function CreateTaskNine(){
            $task_array = array(
                "task_description" => "Old meg a következő Lagrange- és Newton- féle interpolációkkal kapcsolatos feladatokat!",
                "lagrange_points" => [],
                "newton_points" => []
            );
            
            $task_array["lagrange_points"] = $this->dimat_helper_functions->CreatePoints(mt_rand(3,5), -15, 15);
            $task_array["newton_points"] = $this->dimat_helper_functions->CreatePoints(mt_rand(5,7), -15, 15);

            $this->SetTaskDescription($task_array);
        }

        /**
         * 
         * This function is responsible for creating the tenth set of tasks of Discrete Mathematics II. related to equations.
         * 
         * ...Subtasks created here...
         * 
         * @return void
         */
        private function CreateTaskTen(){

        }
    }
?>