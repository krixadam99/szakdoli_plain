<?php
    /**
     * This is a helper class which contains task generator functions related to Discrete Mathematics II..
    */
    class DimatiiTasks extends Task {        
        private $dimatii_subtasks_generator;

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
            $this->task_descriptions = [];
            $this->task_solutions = [];
            $this->definitions = "";
            $this->solution_texts = [];
            $this->topic = $topic;
            $this->dimatii_subtasks_generator = new DimatiiSubtaskGenerator();
            mt_srand(time()); // Seeding the random number generator with the current time.
        }

        /**
         * 
         * This method is responsible for creating a set of tasks based on the selected topic number.
         *  
         * @return void
         */
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
                default:break;
            }
        }

        /**
         * 
         * This method is responsible for creating the first set of tasks of Discrete Mathematics II. related to division, number of dividors and congruencies.
         * 
         * 4 types of subtask will be generated here (2 subtasks per type). These are: dividing whole numbers among whole numbers, and getting the quotients and residues, prime factorization for positive whole numbers, number of positive divisors for positive whole numbers and one example for 2 congruences to get a valid statement.
         * 
         * @return void
         */
        private function CreateTaskOne(){
            $divide_pairs = $this->dimatii_subtasks_generator->CreateSubtask("0", "0", 2);
            $prime_factorization_numbers = $this->dimatii_subtasks_generator->CreateSubtask("0", "1", 2);
            $positive_divisor_count_numbers = $this->dimatii_subtasks_generator->CreateSubtask("0", "2", 2);
            $congruency_pairs = $this->dimatii_subtasks_generator->CreateSubtask("0", "3", 2);

            // Adding the data to the task array.
            $task_array = array(
                "task_description" => "Old meg a következő osztással, osztók számával és kongruencia definíciójával kapcsolatos feladatokat!",
                "divide_pairs" => $divide_pairs["data"],
                "prime_factorization_numbers" => $prime_factorization_numbers["data"],
                "positive_divisor_count_numbers" => $positive_divisor_count_numbers["data"],
                "congruency_pairs" => $congruency_pairs["data"]
            );
            $this->task_descriptions = $task_array;

            //Solutions part:
            $solution_array = [
                "divide_pairs_solution" => $divide_pairs["solutions"],
                "prime_factorization_solution" => $prime_factorization_numbers["solutions"],
                "positive_divisor_count_solution" => $positive_divisor_count_numbers["solutions"],
                "congruence" => $congruency_pairs["data"]
            ];
            $this->task_solutions = $solution_array;

            $this->solution_texts = array(
                "prime_factorization_numbers" => $prime_factorization_numbers["printable_solutions"],
            );
        }

        /**
         * 
         * This method is responsible for creating the second set of tasks of Discrete Mathematics II. related to residue systems.
         * 
         * 3 types of subtask will be generated here (1, 1 and 2 subtasks respectively). These are: residue classes with a representative element for a complete residue system modulo n, residue classes with a representative element for a reduced residue system modulo n, size of a reduced residue system modulo n (where n is considerably big).
         * 
         * @return void
         */
        private function CreateTaskTwo(){    
            // Task creation part:
            $crs_numbers = $this->dimatii_subtasks_generator->CreateSubtask("1", "0", 1);
            $rrs_numbers = $this->dimatii_subtasks_generator->CreateSubtask("1", "1", 1);
            $rrs_size_numbers = $this->dimatii_subtasks_generator->CreateSubtask("1", "2", 2);

            // Adding the data to the task array.
            $task_array = array(
                "task_description" => "Old meg a következő maradékrendszerekkel kapcsolatos feladatokat!",
                "crs_numbers" => $crs_numbers["data"],
                "rrs_numbers" => $rrs_numbers["data"],
                "rrs_size_numbers" => $rrs_size_numbers["data"]
            );
            $this->task_descriptions = $task_array;

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
         * This method is responsible for creating the third set of tasks of Discrete Mathematics II. related to Eucleidan algorithm.
         * 
         * 1 type of subtask will be generated here (3 subtasks). This is the Eucleidan algorithm.
         * 
         * @return void
         */
        private function CreateTaskThree(){
            // Task creation part:
            $gcd_pairs = $this->dimatii_subtasks_generator->CreateSubtask("2", "0", 3);

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
            $this->task_descriptions = $task_array;

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
         * This method is responsible for creating the fourth set of tasks of Discrete Mathematics II. related to linear congruences.
         * 
         * 1 type of subtask will be generated here (3 subtasks). This is solving linear congruences.
         * 
         * @return void
         */
        private function CreateTaskFour(){
            // Task creation part:
            $linear_congrences = $this->dimatii_subtasks_generator->CreateSubtask("3","0",3);

            // Adding the data to the task array.
            $task_array = array(
                "task_description" => "Old meg a következő lineáris kongruenciákkal kapcsolatos feladatokat!",
                "linear_congrences" => $linear_congrences["data"],
            );
            $this->task_descriptions = $task_array;

            //Solutions part:
            $solution_array = [
                "linear_congruences" => $linear_congrences["solutions"][0], 
                "solutions" => $linear_congrences["solutions"][1],
            ];
            $this->task_solutions = $solution_array;
        }

        /**
         * 
         * This method is responsible for creating the fifth set of tasks of Discrete Mathematics II. related to linear diophantine equations.
         * 
         * 2 types of subtask will be generated here (2 and 1 subtasks respectively). These are: diophantine equations and number division into two numbers with plus condition.
         * 
         * @return void
         */
        private function CreateTaskFive(){
            // Task creation part:
            $diophantine_equations = $this->dimatii_subtasks_generator->CreateSubtask("4", "0", 2); // ax \equiv b (mod c)
            $third_subtask = $this->dimatii_subtasks_generator->CreateSubtask("4", "1", 1);

            // Adding the data to the task array.
            $task_array = array(
                "task_description" => "Old meg a következő diofantoszi egyenletekkel kapcsolatos feladatokat!",
                "diophantine_equations" => $diophantine_equations["data"],
                "partition_number" => $third_subtask["data"][0]
            );
            $this->task_descriptions = $task_array;
            array_push($diophantine_equations["solutions"], $third_subtask["solutions"][0]);
            
            //Solutions part:
            $solution_array = [
                "diophantine_equations" => $diophantine_equations["solutions"],
            ];
            $this->task_solutions = $solution_array;
        }

        /**
         * 
         * This method is responsible for creating the sixth set of tasks of Discrete Mathematics II. related to chinese remainder theorem.
         * 
         * 2 types of subtask will be generated here (1-1 subtask). These are: CRT and searching for a number satisfying 2 congruences simultaneously.
         * 
         * @return void
         */
        private function CreateTaskSix(){
            // Task creation part:
            $first_congruence_system_triplets = $this->dimatii_subtasks_generator->CreateSubtask("5", "1", 1);
            $second_congruence_system_triplets = $this->dimatii_subtasks_generator->CreateSubtask("5", "0", 1);

            // Adding the data to the task array.
            $task_array = array(
                "task_description" => "Old meg a következő kínai maradékrendszerrel kapcsolatos feladatokat!",
                "divide_triplets" => $first_congruence_system_triplets["data"][0],
                "first_congruence_system_triplets" => $first_congruence_system_triplets["data"][0],
                "second_congruence_system_triplets" => $second_congruence_system_triplets["data"][0]
            );
            $this->task_descriptions = $task_array;

            //Solutions part:
            $solution_array = [
                "first_crt_solution" => $first_congruence_system_triplets["solutions"][0],
                "second_crt_solution" => $second_congruence_system_triplets["solutions"][0],
            ];
            $this->task_solutions = $solution_array;
        }

        /**
         * 
         * This method is responsible for creating the seventh set of tasks of Discrete Mathematics II. related to horner table.
         * 
         * 2 types of subtask will be generated here (2 and 1 subtasks respectively). These are: Horner-schemes and polynomial dvision with Horner- scheme.
         *
         * @return void
         */
        private function CreateTaskSeven(){
            // Creating 2 polynomials with degree of 2 and 4.
            $horner_schemes_first = $this->dimatii_subtasks_generator->CreateSubtask("6", "0", 2);
            $horner_schemes_second = $this->dimatii_subtasks_generator->CreateSubtask("6", "1", 1);

            // Task array declaration.
            $task_array = array(
                "task_description" => "Old meg a következő Horner-táblázattal kapcsolatos feladatokat!",
                "polynomials" => $horner_schemes_first["data"],
                "divide_polynomials" => $horner_schemes_second["data"][0]
            );

            // Adding data to the task array.
            $this->task_descriptions = $task_array;

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
         * This method is responsible for creating the eight set of tasks of Discrete Mathematics II. related to polinomial division and multiplication.
         * 
         * 2 types of subtask will be generated here (1 and 1 subtask respectively). These are: polynomial division and multiplication.
         * 
         * @return void
         */
        private function CreateTaskEight(){
            $polynomial_division_subtask = $this->dimatii_subtasks_generator->CreateSubtask("7", "0", 1);
            $polynomial_multiplication_subtask = $this->dimatii_subtasks_generator->CreateSubtask("7", "1", 1);
            
            $task_array = array(
                "task_description" => "Old meg a következő polinomok osztásával és szorzásával kapcsolatos feladatokat!",
                "divide_polynomials" => $polynomial_division_subtask["data"][0],
                "multiply_polynomials" => $polynomial_multiplication_subtask["data"][0],
            );

            // Adding data to the task array.
            $this->task_descriptions = $task_array;

            //Solutions part:
            $solution_array = [
                "polynomial_division" => $polynomial_division_subtask["solutions"][0],
                "polynomial_multiplication" => $polynomial_multiplication_subtask["solutions"][0]
            ];
            $this->task_solutions = $solution_array;
        }

        /**
         * 
         * This method is responsible for creating the ninth set of tasks of Discrete Mathematics II. related to interpolations.
         * 
         * 2 types of subtask will be generated here (1 and 1 subtask respectively). These are: Lagrange and Newton interpolation.
         * 
         * @return void
         */
        private function CreateTaskNine(){
            $lagrange_interpolation = $this->dimatii_subtasks_generator->CreateSubtask("8", "0", 1);
            $newton_interpolation = $this->dimatii_subtasks_generator->CreateSubtask("8", "1", 1);
            
            $task_array = array(
                "task_description" => "Old meg a következő Lagrange- és Newton- féle interpolációkkal kapcsolatos feladatokat!",
                "lagrange_points" => $lagrange_interpolation["data"][0],
                "newton_points" => $newton_interpolation["data"][0],
            );
                       
            // Adding data to the task arrays
            $this->task_descriptions = $task_array;

            //Solutions part:
            $solution_array = [
                "Lagrange_interpolation" => $lagrange_interpolation["solutions"][0],
                "Newton_interpolation" => $newton_interpolation["solutions"][0]
            ];
            $this->task_solutions = $solution_array;
        }
    }
?>