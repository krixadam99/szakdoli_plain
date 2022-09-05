<?php
    /**
     * This is a helper class which contains helper functions related to Discrete Mathematics II..
     * 
    */
    class DimatiiHelperFunctions {
        private $maximum_number;
        private $minimum_number;

        /**
         * 
         * The contructor for DimatiiHelperFunctions class.
         * 
         * The range for random numbers are set here.
         * 
         * @return void
         */
        public function __construct(){
            $this->maximum_number = 10;
            $this->minimum_number = 1;
        }

        /**
         *
         * This method is responsible for setting the upper bound of the range from which numbers will be picked randomly.
         *  
         * @param int $maximum_number The upper bound for the range from which numbers will be picked randomly.
         * @return void
        */
        public function SetMaximumNumber($maximum_number){ $this->maximum_number = $maximum_number;}
        
        /**
         *
         * This method is responsible for setting the lowe bound of the range from which numbers will be picked randomly.
         *  
         * @param int $maximum_number The lower bound for the range from which numbers will be picked randomly.
         * @return void
        */
        public function SetMinimumNumber($minimum_number){ $this->minimum_number = $minimum_number;}

        /**
         * 
         * This function is responsible for creating the given amount of pairs of numbers.
         * 
         * @param int $number_of_pairs The number of pairs the function must return
         * @param bool $is_first_positive Should we guarantee that the first number is positive, or not. The default value is false.
         * @param bool $is_second_positive Should we guarantee that the second number is positive, or not. The default value is false.
         * 
         * @return array Return the given amount of pairs of numbers.
         */
        public function CreatePairOfNumber($number_of_pairs, $is_first_positive = false, $is_second_positive = false){
            $return_pairs = [];
            for($counter = 0; $counter < $number_of_pairs; $counter++){
                $first_element = mt_rand($this->minimum_number, $this->maximum_number);
                if($is_first_positive){
                    $first_element = mt_rand(1, $this->maximum_number);
                }
                $second_element = mt_rand($this->minimum_number, $this->maximum_number);
                if($is_second_positive){
                    $second_element = mt_rand(1, $this->maximum_number);
                }

                while($first_element == $second_element || in_array([$first_element,$second_element], $return_pairs)){
                    $first_element = mt_rand($this->minimum_number, $this->maximum_number);
                    if($is_first_positive){
                        $first_element = mt_rand(1, $this->maximum_number);
                    }
                    $second_element = mt_rand($this->minimum_number, $this->maximum_number);
                    if($is_second_positive){
                        $second_element = mt_rand(1, $this->maximum_number);
                    }
                }
                array_push($return_pairs, [$first_element, $second_element]);
            }
            return $return_pairs;
        }

        /**
         * This function uses the Eucleidan algorithm to calculate the greatest common divisor of the given pair.
         * 
         * @return array Returns an array containing each step of the algorithm in the form of [bigger_number, quotient, smaller_number, residue].
         */
        public function GetGCDWithEucleidan($pair){
            $return_array = [];
            $smaller = min($pair[0], $pair[1]);
            $bigger = max($pair[0], $pair[1]);
            $quotient = floor($bigger/$smaller);
            $residue = $bigger - $quotient*$smaller;
            array_push($return_array, [$bigger, $quotient, $smaller, $residue]);
            while($residue > 0){
                $bigger = $smaller;
                $smaller = $residue;
                $quotient = floor($bigger/$smaller);
                $residue = $bigger - $quotient*$smaller;
                array_push($return_array, [$bigger, $quotient, $smaller, $residue]);
            }
            return $return_array;
        }

    }
?>