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
         * This function is responsible for creating the first set of tasks for Discrete Mathematics II. related to division, number of dividors and congruencies.
         * 
         * ...Subtasks created here...
         * 
         * @return void
         */
        private function CreateTaskOne(){
            $this->dimat_helper_functions->SetMaximumNumber(1000);
            $this->dimat_helper_functions->SetMinimumNumber(-1000);

            $first_pairs = $this->dimat_helper_functions->CreatePairOfNumber(4);
            $second_numbers = [mt_rand(100,1000),mt_rand(100,1000),mt_rand(100,1000),mt_rand(100,1000)];
            $third_numbers = [mt_rand(100,1000),mt_rand(100,1000),mt_rand(100,1000),mt_rand(100,1000)];
            $fourth_pairs = $this->dimat_helper_functions->CreatePairOfNumber(4, true);

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
         * This function is responsible for creating the second task related to Discrete Mathematics II..
         * 
         * ...Subtasks created here...
         * 
         * @return void
         */
        private function CreateTaskTwo(){

        }

        /**
         * 
         * This function is responsible for creating the third task related to Discrete Mathematics II..
         * 
         * ...Subtasks created here...
         * 
         * @return void
         */
        private function CreateTaskThree(){

        }

        /**
         * 
         * This function is responsible for creating the fourth task related to Discrete Mathematics II..
         * 
         * ...Subtasks created here...
         * 
         * @return void
         */
        private function CreateTaskFour(){

        }

        /**
         * 
         * This function is responsible for creating the fifth task related to Discrete Mathematics II..
         * 
         * ...Subtasks created here...
         * 
         * @return void
         */
        private function CreateTaskFive(){

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