<?php
    /**
     * This is a helper class which contains task generator functions related to Discrete Mathematics II..
     * 
    */
    class DimatiiTasks extends Task {        
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
            $divide_pairs = $this->dimatii_subtasks->CreateSubtask("0", "0", 2);
            $prime_factorization_numbers = $this->dimatii_subtasks->CreateSubtask("0", "1", 2);
            $positive_divisor_count_numbers = $this->dimatii_subtasks->CreateSubtask("0", "2", 2);
            $congruency_pairs = $this->dimatii_subtasks->CreateSubtask("0", "3", 2);

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
                "divide_pairs_solution" => $divide_pairs["solutions"],
                "prime_factorization_solution" => $prime_factorization_numbers["solutions"],
                "positive_divisor_count_solution" => $positive_divisor_count_numbers["solutions"],
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
            $crs_numbers = $this->dimatii_subtasks->CreateSubtask("1", "0", 1);
            $rrs_numbers = $this->dimatii_subtasks->CreateSubtask("1", "1", 1);
            $rrs_size_numbers = $this->dimatii_subtasks->CreateSubtask("1", "2", 2);

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
                "crs_systems" => $crs_numbers["solutions"][0],
                "rrs_systems" => $rrs_numbers["solutions"][0],
                "rrs_size_numbers" => $rrs_size_numbers["solutions"]
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
            $gcd_pairs = $this->dimatii_subtasks->CreateSubtask("2", "0", 3);
            
            // 1 pair of numbers for extended eucleidan algorithm (1 pair of numbers/ subtask)

            $step_counts = [];
            foreach($gcd_pairs["solutions"][0] as $pair_counter => $algorithm){
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
                "eucleidan_algorithm" => $gcd_pairs["solutions"][0],
                "gcd" => $gcd_pairs["solutions"][1],
                "lcm" => $gcd_pairs["solutions"][2] 
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
            $linear_congrences = $this->dimatii_subtasks->CreateSubtask("3","0",3);

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
                "linear_congruences" => $linear_congrences["solutions"][0], 
                "solutions" => $linear_congrences["solutions"][1],
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
            $diophantine_equations = $this->dimatii_subtasks->CreateSubtask("4", "0", 2); // ax \equiv b (mod c)
            $third_subtask = $this->dimatii_subtasks->CreateSubtask("4", "1", 1);

            // Adding the data to the task array.
            $task_array = array(
                "task_description" => "Old meg a következő diofantoszi egyenletekkel kapcsolatos feladatokat!",
                "diophantine_equations" => $diophantine_equations["data"],
                "partition_number" => $third_subtask["data"][0]
            );
            $this->task_description = $task_array;

            //Solutions part:
            $solution_array = [
                "diophantine_equations" => $diophantine_equations["solutions"],
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
            $first_congruence_system_triplets = $this->dimatii_subtasks->CreateSubtask("5", "1", 1);
            $second_congruence_system_triplets = $this->dimatii_subtasks->CreateSubtask("5", "0", 1);

            // Adding the data to the task array.
            $task_array = array(
                "task_description" => "Old meg a következő kínai maradékrendszerrel kapcsolatos feladatokat!",
                "divide_triplets" => $first_congruence_system_triplets["data"][0],
                "first_congruence_system_triplets" => $first_congruence_system_triplets["data"][0],
                "second_congruence_system_triplets" => $second_congruence_system_triplets["data"][0]
            );
            $this->task_description = $task_array;

            //Solutions part:
            $solution_array = [
                "first_crt_solution" => $first_congruence_system_triplets["solutions"][0],
                "second_crt_solution" => $second_congruence_system_triplets["solutions"][0],
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
            // Creating 2 polynomials with degree of 2 and 4.
            // Picking 2 and 4 wole numbers from the range of -10 and 10, where for the first case 0, for the second case 2 needs to be actual roots of the first and second polynomial expressions respectively.
            $horner_schemes_first = $this->dimatii_subtasks->CreateSubtask("6", "0", 2);
           
            // Creating 1 polynomial.
            // Creating 1 input between -10 and 10.
            $horner_schemes_second = $this->dimatii_subtasks->CreateSubtask("6", "1", 1);

            // Task array declaration.
            $task_array = array(
                "task_description" => "Old meg a következő Horner-táblázattal kapcsolatos feladatokat!",
                "polynomials" => $horner_schemes_first["data"],
                "divide_polynomials" => $horner_schemes_second["data"][0]
            );

            // Adding data to the task array.
            $this->task_description = $task_array;

            //Solutions part:
            $solution_array = [
                "first_horner_scheme" => $horner_schemes_first["solutions"][0],
                "second_horner_scheme" => $horner_schemes_first["solutions"][1],
                "third_horner_scheme" => [$horner_schemes_second["data"][0][2], $horner_schemes_second["solutions"][0]],
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
            $polynomial_division_subtask = $this->dimatii_subtasks->CreateSubtask("7", "0", 1);
            $polynomial_multiplication_subtask = $this->dimatii_subtasks->CreateSubtask("7", "1", 1);
            
            $task_array = array(
                "task_description" => "Old meg a következő polinomok osztásával és szorzásával kapcsolatos feladatokat!",
                "divide_polynomials" => $polynomial_division_subtask["data"][0],
                "multiply_polynomials" => $polynomial_multiplication_subtask["data"][0],
            );

            // Adding data to the task array.
            $this->task_description = $task_array;

            //Solutions part:
            $solution_array = [
                "polynomial_division" => $polynomial_division_subtask["solutions"][0],
                "polynomial_multiplication" => $polynomial_multiplication_subtask["solutions"][0]
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
            $lagrange_interpolation = $this->dimatii_subtasks->CreateSubtask("8", "0", 1);
            $newton_interpolation = $this->dimatii_subtasks->CreateSubtask("8", "1", 1);
            
            $task_array = array(
                "task_description" => "Old meg a következő Lagrange- és Newton- féle interpolációkkal kapcsolatos feladatokat!",
                "lagrange_points" => $lagrange_interpolation["data"][0],
                "newton_points" => $newton_interpolation["data"][0],
            );
                       
            // Adding data to the task array.s
            $this->task_description = $task_array;

            //Solutions part:
            $solution_array = [
                "Lagrange_interpolation" => $lagrange_interpolation["solutions"][0],
                "Newton_interpolation" => $newton_interpolation["solutions"][0]
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