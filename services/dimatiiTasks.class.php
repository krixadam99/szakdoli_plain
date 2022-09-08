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

            mt_srand(time()); //Seeding the random number generator with the current time (we may change this overtime...)
            
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
            $this->dimat_helper_functions->SetMinimumNumber(-1000);
            $this->dimat_helper_functions->SetMaximumNumber(1000);

            $first_pairs = $this->dimat_helper_functions->CreatePairsOfNumbers(4);
            $second_numbers = [mt_rand(100,1000),mt_rand(100,1000),mt_rand(100,1000),mt_rand(100,1000)];
            $third_numbers = [mt_rand(100,1000),mt_rand(100,1000),mt_rand(100,1000),mt_rand(100,1000)];
            $fourth_pairs = $this->dimat_helper_functions->CreatePairsOfNumbers(4, false, true);

            $task_array = array(
                "task_description" => "Old meg a következő osztással, osztók számával és kongruencia definíciójával kapcsolatos feladatokat!",
                "first_parameter" => $first_pairs,
                "second_parameter" => $second_numbers,
                "third_parameter" => $third_numbers,
                "fourth_parameter" => $fourth_pairs
            );
            $this->SetTaskDescription($task_array);
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
            $first_numbers = [mt_rand(5,15),mt_rand(5,15)];
            $second_numbers = [mt_rand(5,25), mt_rand(5,25), mt_rand(5,25), mt_rand(5,25)];
            $third_numbers = [mt_rand(1000,5000), mt_rand(1000,5000), mt_rand(1000,5000), mt_rand(1000,5000)];
            
            $this->dimat_helper_functions->SetMinimumNumber(2);
            $this->dimat_helper_functions->SetMaximumNumber(5000);
            $fourth_pairs = $this->dimat_helper_functions->CreatePairsOfNumbers(4);
            $fourth_mods = [mt_rand(10,100), mt_rand(10,100), mt_rand(10,100), mt_rand(10,100)];

            $task_array = array(
                "task_description" => "Old meg a következő maradékrendszerekkel kapcsolatos feladatokat!",
                "first_parameter" => $first_numbers,
                "second_parameter" => $second_numbers,
                "third_parameter" => $third_numbers,
                "fourth_parameter" => $fourth_pairs,
                "fourth_mods" => $fourth_mods
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
            $this->dimat_helper_functions->SetMinimumNumber(30);
            $this->dimat_helper_functions->SetMaximumNumber(200);
            
            $first_pairs = $this->dimat_helper_functions->CreatePairsOfNumbers(4);
            $step_counts = [];
            $eucleidan_algorithm = [];
            $gcd_array = [];
            $lcm_array = [];
            foreach($first_pairs as $index => $pair){
                $algorithm = $this->dimat_helper_functions->CalculateGCDWithEucleidan($pair);
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
                "first_parameter" => $first_pairs,
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
            $this->dimat_helper_functions->SetMinimumNumber(-100);
            $this->dimat_helper_functions->SetMaximumNumber(100);
            
            $first_triplets = $this->dimat_helper_functions->CreateTripletsOfNumbersWithoutZero(5);
            $linear_congruency_algorithm = [];
            $solution_array = [];
            foreach($first_triplets as $index => $triplet){
                $algorithm = $this->dimat_helper_functions->CalculateLinearCongruenceSolution($triplet);
                array_push($linear_congruency_algorithm, $algorithm["steps"]);
                array_push($solution_array, $algorithm["solution"]);
            }


            $task_array = array(
                "task_description" => "Old meg a következő lineáris kongruenciákkal kapcsolatos feladatokat!",
                "first_triplets" => $first_triplets,
                "solution" => $linear_congruency_algorithm
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
            $this->dimat_helper_functions->SetMinimumNumber(-50);
            $this->dimat_helper_functions->SetMaximumNumber(50);
            $congruency_triplets = $this->dimat_helper_functions->CreateSolvableLinearCongruencies(2); // ax \equiv b (mod c)
            
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
                || $b % $this->dimat_helper_functions->CalculateGCDWithIteration([$a,$c]) !== 0){
                $c = mt_rand(100,1000);
                $a = mt_rand(100,1000);
            }
            // $ax \equiv $b (mod $c) => $a*x + $c*y = $b
            array_push($congruency_triplets, [$a,$b,$c]);

            $diophantine_algorithm = [];
            $triplets = [];
            foreach($congruency_triplets as $index => $triplet){
                // Triplet in the form of $triplet[0]*x \equiv $triplet[1] (mod $triplet[2]) -> $triplet[0]*x - $triplet[1] = $triplet[2]*y
                // Equation in the form of $triplet[0]*x + $triplet[2]*y = $triplet[1]
                $diophantine_equation = [$triplet[0], $triplet[2], $triplet[1]];
                $algorithm_steps = $this->dimat_helper_functions->CalculateDiophantineEquationSolution($diophantine_equation);
                array_push($diophantine_algorithm, $algorithm_steps);
                array_push($triplets, $diophantine_equation);
            }

            $task_array = array(
                "task_description" => "Old meg a következő diofantoszi egyenletekkel kapcsolatos feladatokat!",
                "first_triplets" => [$triplets[0], $triplets[1]],
                "second_triplet" => $triplets[2],
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
            $this->dimat_helper_functions->SetMinimumNumber(2);
            $this->dimat_helper_functions->SetMaximumNumber(1000);
            $divide_triplets = $this->dimat_helper_functions->CreateSolvableLinearCongruencies(2);
            while($this->dimat_helper_functions->CalculateGCDWithIteration([$divide_triplets[0][2],$divide_triplets[1][2]]) !== 1){
                $divide_triplets = $this->dimat_helper_functions->CreateSolvableLinearCongruencies(2);
            }
            $first_divide_triplet = $this->dimat_helper_functions->CalculateLinearCongruenceSolution($divide_triplets[0])["solution"];
            $second_divide_triplet = $this->dimat_helper_functions->CalculateLinearCongruenceSolution($divide_triplets[1])["solution"];

            $this->dimat_helper_functions->SetMinimumNumber(-50);
            $this->dimat_helper_functions->SetMaximumNumber(50);
            $first_congruence_system_triplets = [$first_divide_triplet, $second_divide_triplet];
            $second_congruence_system_triplets = $this->dimat_helper_functions->CreateSolvableLinearCongruenciesForCRT(3);
            $third_congruence_system_triplets = $this->dimat_helper_functions->CreateSolvableLinearCongruenciesForCRT(4);

            $first_solution = $this->dimat_helper_functions->CalculateLinearCongruenceSystemSolution($first_congruence_system_triplets);
            $second_solution = $this->dimat_helper_functions->CalculateLinearCongruenceSystemSolution($second_congruence_system_triplets);
            $third_solution = $this->dimat_helper_functions->CalculateLinearCongruenceSystemSolution($third_congruence_system_triplets);


            $task_array = array(
                "task_description" => "Old meg a következő kínai maradékrendszerrel kapcsolatos feladatokat!",
                "divide_triplets" => $divide_triplets,
                "first_congruence_system_triplets" => $first_congruence_system_triplets,
                "second_congruence_system_triplets" => $second_congruence_system_triplets,
                "third_congruence_system_triplets" => $third_congruence_system_triplets,
                "first_solution" => $first_solution,
                "second_solution" => $second_solution,
                "third_solution" => $third_solution
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
                "polynomials" => []
            );

            $this->dimat_helper_functions->SetMinimumNumber(-10);
            $this->dimat_helper_functions->SetMaximumNumber(10);
            
            for($counter = 0; $counter < 2; $counter++){
                $polynomial_degree = 2*$counter + 2;
                [$polynomial_expression, $roots] = $this->dimat_helper_functions->CreatePolynomialExpression($polynomial_degree);
                $places = $this->dimat_helper_functions->CreatePlacesWithRoots($polynomial_degree, $polynomial_degree - 2, $roots);
                array_push($task_array["polynomials"], [$polynomial_degree, $polynomial_expression, $places]);
            }

            $this->SetTaskDescription($task_array);

        }

        /**
         * 
         * This function is responsible for creating the eight set of tasks of Discrete Mathematics II. related to polinomial division.
         * 
         * ...Subtasks created here...
         * 
         * @return void
         */
        private function CreateTaskEight(){

        }

        /**
         * 
         * This function is responsible for creating the ninth set of tasks of Discrete Mathematics II. related to Lagrange interpolation.
         * 
         * ...Subtasks created here...
         * 
         * @return void
         */
        private function CreateTaskNine(){

        }

        /**
         * 
         * This function is responsible for creating the tenth set of tasks of Discrete Mathematics II. related to Newton interpolation.
         * 
         * ...Subtasks created here...
         * 
         * @return void
         */
        private function CreateTaskTen(){

        }
    }
?>