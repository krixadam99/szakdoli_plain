<?php
    /**
     * This is a controller class which is responsible for showing the practice page.
     * 
     * This controller extends the MainContentController, from which it inherits members that are related to a logged in user.
     * If someone navigates to the practice page, although they are not logged in, then this controller redirects them to the login page.
     * If someone navigates to the practice page, however they are not a student, then this controller redirects them to the notifications page.
    */
    class DimatiiTaskEvaluator extends TaskEvaluator{
        /**
         * 
         * The contructor for DimatiiTaskEvaluator class.
         * 
         * The inherated members will all be set here.
         * 
         * @param array $given_answers An associative array containing the user's given solutions.
         * 
         * @return void
         */
        public function __construct($given_answers){
            $this->subject_id = "ii";
            $this->solution_counter = 0;
            $this->count_correct = 0;
            $this->real_solutions = $_SESSION["solution"];
            $this->given_answers = array_values($given_answers);
        }
        
        /**
         * This method will make the comparison between the given and real answers. The right method will be chosen by the topic number.
         * 
         * @param string $topic_number A numeric string between 0-9. The function will chosse the right comparing method based on this variable.
         * 
         * @return void
         */
        public function CheckSolution($topic_number){
            $_SESSION["answers"] = [];
            $this->topic_number = $topic_number;

            switch($topic_number){
                case "0":{
                    $this->CheckFirstTaskSolution();
                };
                break;
                case "1":{
                    $this->CheckSecondTaskSolution();
                };
                break;
                case "2":{
                    $this->CheckThirdTaskSolution();
                };
                break;
                case "3":{
                    $this->CheckFourthTaskSolution();
                };
                break;
                case "4":{
                    $this->CheckFifthTaskSolution();
                };
                break;
                case "5":{
                    $this->CheckSixthTaskSolution();
                };
                break;
                case "6":{
                    $this->CheckSeventhTaskSolution();
                };
                break;
                case "7":{
                    $this->CheckEigthTaskSolution();
                };
                break;
                case "8":{
                    $this->CheckNinethTaskSolution();
                };
                break;
                case "9":{
                    $this->CheckTenthTaskSolution();
                };
                break;
                default:break;
            }
        }

        /**
         * 
         * This private method compares the given answers with the solutions for Discrete mathematics II. subject 1st topic's tasks related to division (with whole numbers), congruences and greatest common divisors.
         * 
         * @return void
        */
        private function CheckFirstTaskSolution(){
            $was_correct = false;
            
            // Check first subtask
            $first_solution = $this->real_solution["divide_pairs_solution"];
            $given_answer_first_pair_raw = [$this->given_answers[0]??"", $this->given_answers[1]??""];
            $given_answer_first_pair = [$this->ExtractSolutionFromInput($given_answer_first_pair_raw[0])[0],$this->ExtractSolutionFromInput($given_answer_first_pair_raw[1])[0]];

            if($given_answer_first_pair === $first_solution[0]){
                $this->count_correct += 1;
                $was_correct = true;
            }

            $this->solution_counter += 2;
            $this->SetSessionAnswer("0_0_0", $given_answer_first_pair[0], $given_answer_first_pair[0], $first_solution[0][0], $was_correct);
            $this->SetSessionAnswer("0_0_1", $given_answer_first_pair[0], $given_answer_first_pair[0], $first_solution[0][1], $was_correct);

            // Check second subtask
            $second_solution = $this->real_solution["prime_factorization_solution"];

            // Check third subtask
            $third_solution = $this->real_solution["positive_divisor_count_solution"];

            // Check fourth subtask

            // Check fifth subtask
        }

        /**
         * 
         * This private method compares the given answers with the solutions for Discrete mathematics II. subject 2nd topic's tasks
         * 
         * @return void
        */
        private function CheckSecondTaskSolution(){
        }

        /**
         * 
         * This private method compares the given answers with the solutions for Discrete mathematics II. subject 3rd topic's tasks.
         * 
         * @return void
        */
        private function CheckThirdTaskSolution(){
        }

        /**
         * 
         * This private method compares the given answers with the solutions for Discrete mathematics II. subject 4th topic's tasks.
         * 
         * @return void
        */
        private function CheckFourthTaskSolution(){
        }

        /**
         * 
         * This private method compares the given answers with the solutions for Discrete mathematics II. subject 5th topic's tasks.
         * 
         * @return void
        */
        private function CheckFifthTaskSolution(){
        }

        /**
         * 
         * This private method compares the given answers with the solutions for Discrete mathematics II. subject 6th topic's tasks.
         *  
         * @return void
        */
        private function CheckSixthTaskSolution(){
        }

        /**
         * 
         * This private method compares the given answers with the solutions for Discrete mathematics II. subject 7th topic's tasks.
         * 
         * @return void
        */
        private function CheckSeventhTaskSolution(){
        }

        /**
         * 
         * This private method compares the given answers with the solutions for Discrete mathematics II. subject 8th topic's tasks.
         * 
         * @return void
        */
        private function CheckEigthTaskSolution(){
        }

        /**
         * 
         * This private method compares the given answers with the solutions for Discrete mathematics II. subject 9th topic's tasks.
         * 
         * @return void
        */
        private function CheckNinethTaskSolution(){
        }

        /**
         * 
         * This private method compares the given answers with the solutions for Discrete mathematics II. subject 10th topic's tasks.
         * 
         * @return void
        */
        private function CheckTenthTaskSolution(){
        }
    }
?>