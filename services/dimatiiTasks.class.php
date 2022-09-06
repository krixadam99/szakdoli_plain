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
                $algorithm_steps = $this->dimat_helper_functions->GetGCDWithEucleidan($pair);
                $actual_gcd = $algorithm_steps[count($algorithm_steps)-1][2];
                array_push($eucleidan_algorithm, $algorithm_steps);
                array_push($gcd_array, $actual_gcd); // We need the smaller number from the last step (it is the residue of the last but one step)
                if($actual_gcd !== 0){
                    array_push($lcm_array, ($pair[0]*$pair[1])/$actual_gcd);
                }else{
                    array_push($lcm_array, "inf");
                }
                array_push($step_counts, count($algorithm_steps));
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
                $algorithm_steps = $this->dimat_helper_functions->GetLinearCongruencySolution($triplet);
                array_push($linear_congruency_algorithm, $algorithm_steps);
                array_push($solution_array, $algorithm_steps[count($algorithm_steps)-1]);
            }


            $task_array = array(
                "task_description" => "Old meg a következő Eukleidészi algoritmussal kapcsolatos feladatokat!",
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
            
            $this->dimat_helper_functions->SetMinimumNumber(100);
            $this->dimat_helper_functions->SetMaximumNumber(1000);
            array_push($congruency_triplets, $this->dimat_helper_functions->CreateSolvableLinearCongruencies(1)[0]);
            $diophantine_algorithm = [];
            $triplets = [];
            foreach($congruency_triplets as $index => $triplet){
                $diophantine_equation = [$triplet[0], -$triplet[2], $triplet[1]]; // ax - b = cy -> ax - cy = b 
                $algorithm_steps = $this->dimat_helper_functions->GetDiophantineEquationSolution($diophantine_equation);
                array_push($diophantine_algorithm, $algorithm_steps);
                array_push($triplets, $diophantine_equation);
            }


            $task_array = array(
                "task_description" => "Old meg a következő Eukleidészi algoritmussal kapcsolatos feladatokat!",
                "first_triplets" => [$triplets[0], $triplets[1]],
                "second_triplet" => $triplets[2],
                "solution" => $diophantine_algorithm 
            );
            $this->SetTaskDescription($task_array);
        }

        /**
         * 
         * This function is responsible for creating the sixth task related to Discrete Mathematics II..
         * 
         * ...Subtasks created here...
         * 
         * @return void
         */
        private function CreateTaskSix(){

        }

        /**
         * 
         * This function is responsible for creating the seventh task related to Discrete Mathematics II..
         * 
         * ...Subtasks created here...
         * 
         * @return void
         */
        private function CreateTaskSeven(){

        }

        /**
         * 
         * This function is responsible for creating the eight task related to Discrete Mathematics II..
         * 
         * ...Subtasks created here...
         * 
         * @return void
         */
        private function CreateTaskEight(){

        }

        /**
         * 
         * This function is responsible for creating the ninth task related to Discrete Mathematics II..
         * 
         * ...Subtasks created here...
         * 
         * @return void
         */
        private function CreateTaskNine(){

        }

        /**
         * 
         * This function is responsible for creating the tenth task related to Discrete Mathematics II..
         * 
         * ...Subtasks created here...
         * 
         * @return void
         */
        private function CreateTaskTen(){

        }
    }
?>