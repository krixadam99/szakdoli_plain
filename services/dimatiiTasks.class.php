<?php
    /**
     * This is a helper class which contains task generator functions related to Discrete Mathematics II..
     * 
    */
    class DimatiiTasks extends Tasks{        
        private $dimat_helper_functions;
        private $dimatii_subtasks;

        /**
         * 
         * The contructor for DimatiiTasks class.
         * 
         * Here the inherited members will be set.
         * Based on the $topic parameter a new set of tasks will be generated,
         * 
         * @param string $topic The topic id for task generation.
         * 
         * @return void
         */
        public function __construct($topic){
            $this->task_description = [];
            $this->task_solutions = [];
            $this->definitions = "";
            $this->topic = $topic;
            $this->dimatii_subtasks = new DimatiiSubTasks();
            $this->dimat_helper_functions = new DimatiiHelperFunctions();
            mt_srand(time()); // Seeding the random number generator with the current time.
        }

        public function PracticePageTaskGeneration(){
            switch($this->topic){
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
         * Subtasks related to division and congruences are:
         * Dividing whole numbers among whole numbers, getting the quotients and residues;
         * Giving the prime factorization for positive whole numbers;
         * Giving the number of divisors for positive whole numbers;
         * Giving one example for 2 congruences to get a valid statement.
         * 
         * @return void
         */
        private function CreateTaskOne(){
            // Task creation part:
            // 2 pairs for division subtask (1 pair/ subtask);
            // 2 numbers for prime factorization subtask (1 number/ subtask);
            // 2 numbers for divisor counting subtask (1 number/ subtask);
            // 2 pairs for congruency subtask (1 pair/ subtask).
            $divide_pairs = $this->dimatii_subtasks->CreateDivisionPairsSubtask(2);
            $prime_factorization_numbers = $this->dimatii_subtasks->CreatePrimeFactorizationSubtask(2);
            $positive_divisor_count_numbers = $this->dimatii_subtasks->CreateDivisorCountSubtask(2);
            $congruency_pairs = $this->dimatii_subtasks->CreateCongruentNumbersSubtask(2);

            // Adding the data to the task array.
            $task_array = array(
                "task_description" => "Old meg a következő osztással, osztók számával és kongruencia definíciójával kapcsolatos feladatokat!",
                "divide_pairs" => $divide_pairs["data"],
                "prime_factorization_numbers" => $prime_factorization_numbers["data"],
                "positive_divisor_count_numbers" => $positive_divisor_count_numbers["data"],
                "congruency_pairs" => $congruency_pairs["data"]
            );
            $this->task_description = $task_array;

            //Solutions part:
            $solution_array = [
                "divide_pairs_solution" => $divide_pairs["solution"],
                "prime_factorization_solution" => $prime_factorization_numbers["solution"],
                "positive_divisor_count_solution" => $positive_divisor_count_numbers["solution"],
                "congruence" => $congruency_pairs["data"]
            ];
            $this->task_solutions = $solution_array;

            // Definition part:
        }

        /**
         * 
         * This function is responsible for creating the second set of tasks of Discrete Mathematics II. related to residue systems.
         * 
         * Subtasks related to residue systems:
         * Giving the residue classes with a representative element for a complete residue system modulo n;
         * Giving the residue classes with a representative element for a reduced residue system modulo n;
         * Giving the size of a reduced residue system modulo n (where n is considerably big).
         * 
         * @return void
         */
        private function CreateTaskTwo(){    
            // Task creation part:
            // 2 numbers for complete residue system subtask (1 number/ subtask);
            // 2 numbers for reduced residue system subtask (1 number/ subtask);
            // 2 numbers for reduced residue system size subtask (1 number/ subtask);
            $crs_numbers = $this->dimatii_subtasks->CreateCompleteResidueSystemSubtask(1,2,15);
            $rrs_numbers = $this->dimatii_subtasks->CreateReducedResidueSystemSubtask(1,2,25);;
            $rrs_size_numbers = $this->dimatii_subtasks->CreateEulerPhiFunctionSubtask(2);

            // Adding the data to the task array.
            $task_array = array(
                "task_description" => "Old meg a következő maradékrendszerekkel kapcsolatos feladatokat!",
                "crs_numbers" => $crs_numbers["data"],
                "rrs_numbers" => $rrs_numbers["data"],
                "rrs_size_numbers" => $rrs_size_numbers["data"]
            );
            $this->task_description = $task_array;

            //Solutions part:
            $solution_array = [
                "crs_systems" => $crs_numbers["solution"][0],
                "rrs_systems" => $rrs_numbers["solution"][0],
                "rrs_size_numbers" => $rrs_size_numbers["solution"]
            ];
            $this->task_solutions = $solution_array;
        }

        /**
         * 
         * This function is responsible for creating the third set of tasks of Discrete Mathematics II. related to Eucleidan algorithm.
         * 
         * Subtasks related to Eucleidan algorithm:
         * Creating 3 distinct pairs of numbers for which we want to determine the gcd with the Eucleidan algorithm;
         * Creating 1 pair for which the student will have to determine the extended eucleidan algorithm.
         * 
         * @return void
         */
        private function CreateTaskThree(){
            // Task creation part:
            // 3 pairs of numbers for gcd (1 pair of numbers/ subtask);
            $gcd_pairs = $this->dimatii_subtasks->CreateEucleidanAlgorithmSubtask(3, 30, 200);
            
            // 1 pair of numbers for extended eucleidan algorithm (1 pair of numbers/ subtask)

            $step_counts = [];
            foreach($gcd_pairs["solution"][0] as $pair_counter => $algorithm){
                array_push($step_counts, count($algorithm));
            }

            // Adding the data to the task array.
            $task_array = array(
                "task_description" => "Old meg a következő Eukleidészi algoritmussal kapcsolatos feladatokat!",
                "gcd_pairs" => $gcd_pairs["data"],
                "step_counts" => $step_counts
            );
            $this->task_description = $task_array;

            //Solutions part:
            $solution_array = [
                "eucleidan_algorithm" => $gcd_pairs["solution"][0],
                "gcd" => $gcd_pairs["solution"][1],
                "lcm" => $gcd_pairs["solution"][2] 
            ];
            $this->task_solutions = $solution_array;
        }

        /**
         * 
         * This function is responsible for creating the fourth set of tasks of Discrete Mathematics II. related to linear congruences.
         * 
         * Subtasks related to linear congruences:
         * Creating 3 distinct triplets containing non-zero whole numbers representing congruences, where the modulo is positive, for the linear congruences subtask.
         * Creating 2 distinct pairs of numbers for Euler-Fermat theorem subtask.
         * 
         * @return void
         */
        private function CreateTaskFour(){
            // Task creation part:
            // 3 distinct triplets of numbers for linear congruences (1 triplet of numbers/ subtask).
            $linear_congrences = $this->dimatii_subtasks->CreateLinearCongruenceSubtask(3);

            // 2 pairs of numbers for Euler-Fermat theorem (1 pair of numbers/ subtask).

            // 1 pair of numbers for raising to power with the rapid algorithm.

            // Adding the data to the task array.
            $task_array = array(
                "task_description" => "Old meg a következő lineáris kongruenciákkal kapcsolatos feladatokat!",
                "linear_congrences" => $linear_congrences["data"],
            );
            $this->task_description = $task_array;

            //Solutions part:
            $solution_array = [
                "linear_congruences" => $linear_congrences["solution"][0], 
                "solutions" => $linear_congrences["solution"][1],
            ];
            $this->task_solutions = $solution_array;
        }

        /**
         * 
         * This function is responsible for creating the fifth set of tasks of Discrete Mathematics II. related to linear diophantine equations.
         * 
         * Subtasks related to linear diophantine equations:
         * Creating 1 triplet containing whole numbers that are at least 2, for partitioning a number into smaller numbers.
         * Creating 2 distinct triplets of numbers for diophantine equations. These triplets represent congruences, that are solvable.
         * 
         * @return void
         */
        private function CreateTaskFive(){
            // Task creation part:
            // 1 triplet of numbers of whole numbers at least 2 for artitioning a number into smaller numbers (1 triplet of numbers/ subtask).
            // 2 triplet of numbers of whole numbers between -50 and 50 representing congruences, that are solvable (1 triplet of numbers/ subtask).
            $congruency_triplets = $this->dimat_helper_functions->CreateSolvableLinearCongruences(2, true, -50, 50); // ax \equiv b (mod c)
            
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

            // Adding the data to the task array.
            $task_array = array(
                "task_description" => "Old meg a következő diofantoszi egyenletekkel kapcsolatos feladatokat!",
                "diophantine_equations" => [$diophantine_equation[0], $diophantine_equation[1]],
                "partition_number" => $diophantine_equation[2]
            );
            $this->task_description = $task_array;

            //Solutions part:
            $solution_array = [
                "diophantine_equations" => $diophantine_algorithm,
            ];
            $this->task_solutions = $solution_array;
        }

        /**
         * 
         * This function is responsible for creating the sixth set of tasks of Discrete Mathematics II. related to chinese remainder theorem.
         * 
         * Subtasks related to chinese remainder theorem:
         * Creating 1 triplet containing whole numbers that are at least 2, for getting numbers that satisfy 2 simultaneous congruences.
         * Creating 1 triplet containing whole numbers that are between -50 and 50, for getting numbers that satisfy 4 simultaneous congruences.
         * 
         * @return void
         */
        private function CreateTaskSix(){
            // Task creation part:
            // 1 triplet of whole numbers that are at least 2 representing congruences for getting numbers that satisfy 2 simultaneous congruences (1 triplet of numbers/ subtask).
            // 1 triplet of whole numbers that are between -50 and 50 representing congruences for getting numbers that satisfy 4 simultaneous congruences (1 triplet of numbers/ subtask).
            $divide_triplets = $this->dimat_helper_functions->CreateSolvableLinearCongruences(2, true, 2, 1000);
            while($this->dimat_helper_functions->DetermineGCDWithIteration([$divide_triplets[0][2],$divide_triplets[1][2]]) !== 1){
                $divide_triplets = $this->dimat_helper_functions->CreateSolvableLinearCongruences(2, true, 2, 1000);
            }
            $first_divide_triplet = $this->dimat_helper_functions->DetermineLinearCongruenceSolution($divide_triplets[0])["solution"];
            $second_divide_triplet = $this->dimat_helper_functions->DetermineLinearCongruenceSolution($divide_triplets[1])["solution"];

            $first_congruence_system_triplets = [$first_divide_triplet, $second_divide_triplet];
            $second_congruence_system_triplets = $this->dimat_helper_functions->CreateSolvableLinearCongruencesForCRT(4, -50, 50);

            // Adding the data to the task array.
            $task_array = array(
                "task_description" => "Old meg a következő kínai maradékrendszerrel kapcsolatos feladatokat!",
                "divide_triplets" => $divide_triplets,
                "first_congruence_system_triplets" => $first_congruence_system_triplets,
                "second_congruence_system_triplets" => $second_congruence_system_triplets
            );
            $this->task_description = $task_array;

            //Solutions part:
            $solution_array = [
                "first_crt_solution" => $this->dimat_helper_functions->DetermineLinearCongruenceSystemSolution($first_congruence_system_triplets),
                "second_crt_solution" => $this->dimat_helper_functions->DetermineLinearCongruenceSystemSolution($second_congruence_system_triplets),
            ];
            $this->task_solutions = $solution_array;
        }

        /**
         * 
         * This function is responsible for creating the seventh set of tasks of Discrete Mathematics II. related to horner table.
         * 
         * Subtasks related to horner's scheme:
         * Creating 2 polynomial expressions and picking whole numbers from the range -20 and 20, where the first is of degree 2, and the second is of degree 4. The number of inputs for polynomial expression is the same as its degree.
         * Creating 1 polynomial expression of degree 5 and picking a whole number from the range -20 and 20. 
         *
         * @return void
         */
        private function CreateTaskSeven(){
            // Task array declaration.
            $task_array = array(
                "task_description" => "Old meg a következő Horner-táblázattal kapcsolatos feladatokat!",
                "polynomials" => [],
                "divide_polynomials" => []
            );
            
            // Creating 2 polynomials with degree of 2 and 4.
            // Picking 2 and 4 wole numbers from the range of -20 and 20, where for the first case 0, for the second case 2 needs to be actual roots of the first and second polynomial expressions respectively.
            for($counter = 0; $counter < 2; $counter++){
                $polynomial_degree = 2*$counter + 2;
                [$polynomial_expression, $roots] = $this->dimat_helper_functions->CreatePolynomialExpression($polynomial_degree);
                $places = $this->dimat_helper_functions->CreatePlacesWithRoots($polynomial_degree, $polynomial_degree - 2, $roots, -20, 20);
                array_push($task_array["polynomials"], [$polynomial_degree, $polynomial_expression, $places]);
            }

            // Creating 1 polynomials with degree of 5.
            // Creating 1 input between -20 and 20. Non of the has to be a root of the polynomial expression
            [$polynomial_expression, $roots] = $this->dimat_helper_functions->CreatePolynomialExpression(5, -5, 5);
            $places = $this->dimat_helper_functions->CreatePlacesWithRoots(1, 0, $roots, -5, 5);
            $task_array["divide_polynomials"] = [5, $polynomial_expression, $places];

            // Adding data to the task array.
            $this->task_description = $task_array;

            //Solutions part:
            $solution_array = [
                "first_horner_scheme" => $this->dimat_helper_functions->DetermineHornerSchemes($task_array["polynomials"][0][1], $task_array["polynomials"][0][2]),
                "second_horner_scheme" => $this->dimat_helper_functions->DetermineHornerSchemes($task_array["polynomials"][1][1], $task_array["polynomials"][1][2]),
                "third_horner_scheme" => [$task_array["divide_polynomials"][2], $this->dimat_helper_functions->DetermineHornerSchemes($task_array["divide_polynomials"][1], $task_array["divide_polynomials"][2])],
            ];
            $this->task_solutions = $solution_array;
        }

        /**
         * 
         * This function is responsible for creating the eight set of tasks of Discrete Mathematics II. related to polinomial division and multiplication.
         * 
         * Subtasks related to polinomial division and multiplication:
         * Creating 2 polynomial expressions for polynomial division. The first one's degree is between 3 and 5.
         * Creating 2 polynomial expression for polynomial multiplication. The second one's degree is between 1 and 3.
         * 
         * @return void
         */
        private function CreateTaskEight(){
            $task_array = array(
                "task_description" => "Old meg a következő polinomok osztásával és szorzásával kapcsolatos feladatokat!",
                "divide_polynomials" => [],
                "multiply_polynomials" => [],
                "solution" => []
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

            $task_array["solution"] = [
                "polynomial_division" => $this->dimat_helper_functions->DividePolynomialExpressions($task_array["divide_polynomials"][0][1], $task_array["divide_polynomials"][1][1]),
                "polynomial_multiplication" => $this->dimat_helper_functions->MultiplyPolynomialExpressions($task_array["multiply_polynomials"][0][1], $task_array["multiply_polynomials"][1][1], $task_array["multiply_polynomials"][2])
            ];

            // Adding data to the task array.
            $this->task_description = $task_array;

            //Solutions part:
            $solution_array = [
                "polynomial_division" => $this->dimat_helper_functions->DividePolynomialExpressions($task_array["divide_polynomials"][0][1], $task_array["divide_polynomials"][1][1]),
                "polynomial_multiplication" => $this->dimat_helper_functions->MultiplyPolynomialExpressions($task_array["multiply_polynomials"][0][1], $task_array["multiply_polynomials"][1][1], $task_array["multiply_polynomials"][2])
            ];

            $this->task_solutions = $solution_array;
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
            
            $first_polynomial_degree = mt_rand(2,3);
            [$first_polynomial_expression, $roots] = $this->dimat_helper_functions->CreatePolynomialExpression($first_polynomial_degree);
            $task_array["lagrange_points"] = $this->dimat_helper_functions->CreatePoints($first_polynomial_degree + 1, -5, 5, $first_polynomial_expression);
            
            $second_polynomial_degree = mt_rand(4,5);
            [$second_polynomial_expression, $roots] = $this->dimat_helper_functions->CreatePolynomialExpression($second_polynomial_degree);
            $task_array["newton_points"] = $this->dimat_helper_functions->CreatePoints($second_polynomial_degree + 1, -5, 5, $second_polynomial_expression);
            
            // Adding data to the task array.s
            $this->task_description = $task_array;

            //Solutions part:
            $solution_array = [
                "Lagrange_interpolation" => $this->dimat_helper_functions->DetermineLagrangeInterpolation($task_array["lagrange_points"]),
                "Newton_interpolation" => $this->dimat_helper_functions->DetermineNewtonInterpolation($task_array["newton_points"])
            ];

            $this->task_solutions = $solution_array;
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