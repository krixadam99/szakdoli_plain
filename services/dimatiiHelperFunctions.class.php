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
         * @param int $number_of_pairs The number of pairs the function must return.
         * @param bool $is_first_positive Should we guarantee that the first number is positive, or not. The default value is false.
         * @param bool $is_second_positive Should we guarantee that the second number is positive, or not. The default value is false.
         * 
         * @return array Return the given amount of pairs of numbers.
         */
        public function CreatePairsOfNumbers($number_of_pairs, $is_first_positive = false, $is_second_positive = false){
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

                while($first_element == $second_element || in_array([$first_element, $second_element], $return_pairs)){
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
         * 
         * This function is responsible for creating the given amount of triplets of numbers with the condition that non of the created numbers can be 0.
         * 
         * @param int $number_of_triplets The number of triplets the function must return.
         * 
         * @return array Return the given amount of triplets of numbers.
         */
        public function CreateTripletsOfNumbersWithoutZero($number_of_triplets){
            $return_triplets = [];
            for($counter = 0; $counter < $number_of_triplets; $counter++){
                $triplet = $this->CreateTripletOfNumbers();
                while($triplet[0] == 0 
                    || $triplet[1] == 0 
                    || $triplet[2] == 0 
                    || in_array($triplet, $return_triplets)
                    ){
                        $triplet = $this->CreateTripletOfNumbers();
                }
                array_push($return_triplets, $triplet);
            }
            return $return_triplets;
        }

        /**
         * 
         * This function is responsible for creating the given amount of triplets of numbers with which a linear congruency could be solved.
         * 
         * @param int $number_of_triplets The number of triplets the function must return.
         * @param bool $without_zeros Should we guarantee that the triplets don't contain any zero, or not. The default is true.
         * 
         * @return array Return the given amount of triplets of numbers.
         */
        public function CreateSolvableLinearCongruencies($number_of_triplets, $without_zeros = true){
            $return_triplets = [];
            for($counter = 0; $counter < $number_of_triplets; $counter++){
                $triplet = $this->CreateTripletOfNumbers();
                $b= $triplet[1];
                $gcd = $this->GetGCDWithIteration([$triplet[0], $triplet[2]]);
                $was_there_zero = false;
                if($without_zeros){
                    $was_there_zero = $triplet[0] === 0 || $triplet[1] === 0 || $triplet[2] === 0;
                }
                while( $was_there_zero 
                    || in_array($triplet, $return_triplets)
                    || $b % $gcd !== 0
                    ){
                        $triplet = $this->CreateTripletOfNumbers();
                        $b= $triplet[1];
                        $gcd = $this->GetGCDWithIteration([$triplet[0], $triplet[2]]);
                        if($without_zeros){
                            $was_there_zero = $triplet[0] === 0 || $triplet[1] === 0 || $triplet[2] === 0;
                        }
                }
                array_push($return_triplets, $triplet);
            }
            return $return_triplets;
        }

        /**
         * This function uses the Eucleidan algorithm to calculate the greatest common divisor of the given pair.
         * 
         * @param array $pair The pair for which the function will determine the gcd and eucleidan algorithm steps.
         * 
         * @return array Returns an array containing each step of the algorithm in the form of [bigger_number, quotient, smaller_number, residue].
         */
        public function GetGCDWithEucleidan($pair){
            $return_array = [];
            $first_number = abs($pair[0]);
            $second_number = abs($pair[1]);
            $smaller = min($first_number, $second_number);
            $bigger = max($first_number, $second_number);
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

        /**
         * This function uses the linear congruency solver algorithm to give the final congruency for a given linear congruency.
         * 
         * @param array $triplet The triplet for which the function will determine the linear congruency and algorithm steps.
         * 
         * @return array Returns an array containing each step of the algorithm in the form of [first operand, second operand, modulo].
         */
        public function GetLinearCongruencySolution($triplet){
            $return_array = [];
            $a = $triplet[0];
            $b = $triplet[1];
            $c = abs($triplet[2]); // $c can be negative and positive, the congruency means the same
            while($a < 0){
                $a += $c;
            } 
            while($b < 0){
                $b += $c;
            }

            if($a !== 0 && $b !== 0){
                // $a*x \equiv $b (mod $c)
                $gcd_ac = $this->GetGCDWithIteration([$a, $c]);
                if($b % $gcd_ac === 0){
                    $gcd_ab = $this->GetGCDWithIteration([$a, $b]);
                    $a /= $gcd_ab;
                    $b /= $gcd_ab; 
                    $c /= $this->GetGCDWithIteration([$gcd_ab, $c]); 

                    while($b % $a !== 0){
                        $b = $b + $c;
                    }
                    $b /= $a;
                    $a = 1;
                    $c /= $this->GetGCDWithIteration([$a, $c]);
                    array_push($return_array, [$a,$b,$c]);
                }else{
                    array_push($return_array, "NINCSEN");
                }
            }else{
                if($a === 0 ){
                    array_push($return_array, [0,$b,1]);
                }else{
                    array_push($return_array, [1,0,$c/$this->GetGCDWithIteration([$a, $c])]);
                }
            }
            return $return_array;
        }

        /**
         * This function uses the diophantine equation solver algorithm to give the solution for a diophatnine equation.
         * 
         * @param array $triplet The triplet symbilosing a diophantine equation for which the function will determine the solution and algorithm steps. It is in the form of ax + bx = c, where a is the first, b the second and c the third triplet element.
         * 
         * @return array Returns an array containing each step of the algorithm.
         */
        public function GetDiophantineEquationSolution($triplet){
            $return_array = [];
            $a = $triplet[0];
            $b = $triplet[1];
            $c = $triplet[2];
            
            // $a * x + $b * y = $c | - ($b * y)
            // $a * x = $c - $b * y | %$b
            // $a * x \equiv $c (mod $b)
            // y = ($c - $a * x) / $b
            $congruency = [$a, $c, $b];
 
            // x \equiv $d (mod $e)
            // x - $d = $e * k (k \in \doubleZ)
            // x = $e * k + $d (k \in \doubleZ)
            $first_congruency_solution = $this->GetLinearCongruencySolution($congruency);
            $x_solution = $first_congruency_solution[count($first_congruency_solution)-1];
            $d = $x_solution[1];
            $e = $x_solution[2];
            if($first_congruency_solution[0] !== "NINCSEN"){
                array_push($return_array, $first_congruency_solution);

                // y = ($c - $a * x) / $b
                // x = $e * k + $d (k \in \doubleZ)
                // y = ($c - $a * $e * k - $a * $d) / $b
                array_push($return_array, [($c - $a*$d)/$b, ($a*$e)/$b]);
            }else{
                array_push($return_array, ["NINCSEN"]);
            }
            return $return_array;
        }

        /**
         * This function uses iteration to get the greatest common divisor of two numbers.
         * 
         * Since the gcd is positive, the function will firstly take the absolute value of the given numbers.
         * 
         * @param array $pair The pair for which the function will determine the gcd.
         * 
         * @return int Returns the (positive) gcd for the given pair.
         */
        private function GetGCDWithIteration($pair){
            $gcd = 0;
            $first_number = abs($pair[0]);
            $second_number = abs($pair[1]);
            $smaller_number = min($first_number, $second_number);
            for($counter = $smaller_number; $counter > 0; $counter--){
                if($first_number%$counter === 0 && $second_number%$counter === 0){
                    $gcd = $counter;
                    break;
                }
            }
            return $gcd;
        }

        /**
         * 
         * This function is responsible for creating a triplet of numbers.
         * 
         * @return array Return the given amount of triplets of numbers.
         */
        private function CreateTripletOfNumbers(){
            $first_element = mt_rand($this->minimum_number, $this->maximum_number);
            $second_element = mt_rand($this->minimum_number, $this->maximum_number);
            $third_element = mt_rand($this->minimum_number, $this->maximum_number);

            while($first_element == $second_element 
                    || $second_element == $third_element 
                    || $first_element == $third_element
                    ){
                    $first_element = mt_rand($this->minimum_number, $this->maximum_number);
                    $second_element = mt_rand($this->minimum_number, $this->maximum_number);
                    $third_element = mt_rand($this->minimum_number, $this->maximum_number);
            }
            return [$first_element, $second_element, $third_element];
        }
    }
?>