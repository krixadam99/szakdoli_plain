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
         * This function is responsible for creating the given amount of triplets of numbers with which a linear congruence could be solved.
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
         * 
         * This function is responsible for creating the given amount of triplets of numbers symbolising the linear congruencies with which CRT can be solved.
         * 
         * Conditions for linear congruencies in the system:
         * non of the numbers in the linear congruencies is 0;
         * the linear congruencies should contain different numbers for the modulo and the other parts of the congruence (left and right hand side can be similar);
         * the modulos in the system should be pairwise relatively prime (this also guarantees, that the system contains ).
         * 
         * @param int $number_of_triplets The number of triplets (symbolising the congruencies) the function must return.
         * 
         * @return array Return the given amount of triplets of numbers (one triplet is one congruence).
         */
        public function CreateSolvableLinearCongruenciesForCRT($number_of_triplets){
            $return_triplets = [];
            for($counter = 0; $counter < $number_of_triplets; $counter++){
                $triplet = $this->CreateTripletOfNumbers();
                $b= $triplet[1];
                $gcd = $this->GetGCDWithIteration([$triplet[0], $triplet[2]]); // The linear congruence can be solved
                
                $was_there_zero = $triplet[0] === 0 || $triplet[1] === 0 || $triplet[2] === 0; // Non of the coefficients in the congruence is zero
                $triplet_contains_similar = abs($triplet[1]) === abs($triplet[2]) || abs($triplet[0]) === abs($triplet[2]); // The left and right hand sides are different from the modulo  
                $is_modulo_relative_prime_to_modulos = $this->CheckIfModulosRelativelyPrimes($return_triplets, $triplet[2]); // New modulo is relatively prime to the modulos in the congruence system

                while( $was_there_zero
                    || $triplet_contains_similar 
                    || !$is_modulo_relative_prime_to_modulos
                    || in_array($triplet, $return_triplets)
                    || $b % $gcd !== 0
                    ){
                        $triplet = $this->CreateTripletOfNumbers();
                        $b= $triplet[1];
                        $gcd = $this->GetGCDWithIteration([$triplet[0], $triplet[2]]);
                        
                        $was_there_zero = $triplet[0] === 0 || $triplet[1] === 0 || $triplet[2] === 0; // Non of the coefficients in the congruence is zero
                        $triplet_contains_similar = abs($triplet[1]) === abs($triplet[2]) || abs($triplet[0]) === abs($triplet[2]); // The left and right hand sides are different from the modulo 
                        $is_modulo_relative_prime_to_modulos = $this->CheckIfModulosRelativelyPrimes($return_triplets, $triplet[2]); // New modulo is relatively prime to the modulos in the congruence system
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
         * @return array Returns an associative array containing each step of the algorithm in the form of [bigger_number, quotient, smaller_number, residue] and the solution.
         */
        public function GetGCDWithEucleidan($pair){
            $return_array = array("steps" => [], "solution" => []);
            $first_number = abs($pair[0]);
            $second_number = abs($pair[1]);
            $smaller = min($first_number, $second_number);
            $bigger = max($first_number, $second_number);
            $quotient = floor($bigger/$smaller);
            $residue = $bigger - $quotient*$smaller;
            array_push($return_array["steps"], [$bigger, $quotient, $smaller, $residue]);
            while($residue > 0){
                $bigger = $smaller;
                $smaller = $residue;
                $quotient = floor($bigger/$smaller);
                $residue = $bigger - $quotient*$smaller;
                array_push($return_array["steps"], [$bigger, $quotient, $smaller, $residue]);
            }
            $return_array["solution"] = $smaller;
            return $return_array;
        }

        /**
         * This function uses the linear congruence solver algorithm to give the final congruence for a given linear congruence.
         * 
         * @param array $triplet The triplet for which the function will determine the linear congruence and algorithm steps.
         * 
         * @return array Returns an associative array containing each step of the algorithm in the form of [first operand, second operand, modulo] and the solution.
         */
        public function GetLinearCongruenceSolution($triplet){
            $return_array = array("steps" => [], "solution" => []);
            $a = $triplet[0];
            $b = $triplet[1];
            $c = abs($triplet[2]); // $c can be negative and positive, the congruence means the same
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
                    array_push($return_array["steps"], [$a,$b,$c]);

                    while($b % $a !== 0){
                        $b = $b + $c;
                        array_push($return_array["steps"], [$a,$b,$c]);
                    }
                    $b /= $a;
                    $a = 1;
                    $c /= $this->GetGCDWithIteration([$a, $c]);
                    
                    array_push($return_array["steps"], [$a,$b,$c]);
                    $return_array["solution"] = [$a,$b,$c];
                }else{
                    $return_array["solution"] = "NINCSEN";
                }
            }else{
                if($a === 0 ){
                    $return_array["solution"] = [0,$b,1];
                }else{
                    $return_array["solution"] = [1,0,$c/$this->GetGCDWithIteration([$a, $c])];
                }
            }
            return $return_array;
        }

        /**
         * This function uses the diophantine equation solver algorithm to get the solution for a diophatnine equation.
         * 
         * @param array $triplet The triplet representing a diophantine equation for which the function will determine the solution and algorithm steps. It is in the form of ax + bx = c, where a is the first, b the second and c the third triplet element.
         * 
         * @return array Returns an array containing the solution of the algorithm.
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
            $congruence = [$a, $c, $b];
 
            // x \equiv $d (mod $e)
            // x - $d = $e * k (k \in \doubleZ)
            // x = $e * k + $d (k \in \doubleZ)
            $first_congruence_solution = $this->GetLinearCongruenceSolution($congruence);
            $x_solution = $first_congruence_solution["solution"];
            $d = $x_solution[1];
            $e = $x_solution[2];
            if($x_solution !== "NINCSEN"){
                array_push($return_array, $x_solution);

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
         * This function uses the algorithm used while proving chinese remainder theorem to get the solution for a linear congruence system.
         * 
         * The function solves the linear congruences in the system, then it will calculate a shared solution for the first two congruences, and substitute those with it.
         * The algorithm continues until only one linear congruence remains.
         * 
         * @param array $congruences The triplets representing the linear congruences in the system. Each of them is of the form [coefficient of x, right side of congruence, modulo].
         * 
         * @return array Returns an array containing each step and the solution of the algorithm.
         */
        public function GetLinearCongruenceSystemSolution($congruences){
            $return_array = array("steps" => [], "solution" => []);
            $simplified_congruences = [];
            foreach($congruences as $index => $congruence){
                array_push($simplified_congruences, $this->GetLinearCongruenceSolution($congruence)["solution"]);
            }
            array_push($return_array["steps"], $simplified_congruences);

            $merged_solution = $this->GetMergedSolutionForCongruencies($simplified_congruences[0], $simplified_congruences[1]);
            array_push($return_array["steps"], $merged_solution);
            for($counter = 2; $counter < count($simplified_congruences); $counter++){
                $merged_solution = $this->GetMergedSolutionForCongruencies($merged_solution, $simplified_congruences[$counter]);
                array_push($return_array["steps"], $merged_solution);
            }
            $return_array["solution"] = $merged_solution;
            
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
        public function GetGCDWithIteration($pair){
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
         * The triplets here will represent linear congruencies in the form of [coefficient of x, right side of congruence, modulo].
         * We will only require the modulo to be non-zero, since the ax \equiv b (mod c) congruency can be rewritten as ax-b = ck, where k is an integer, we can multiply both side with -1, and get the same result, that is, ax \equiv b (mod -c).
         * 
         * @return array Returns the given amount of triplets of numbers.
         */
        private function CreateTripletOfNumbers(){
            $first_element = mt_rand($this->minimum_number, $this->maximum_number);
            $second_element = mt_rand($this->minimum_number, $this->maximum_number);
            $third_element = mt_rand(1, $this->maximum_number);
            return [$first_element, $second_element, $third_element];
        }

        /**
         * 
         * This function is responsible for checking if the new modulo is relative prime to the modulos of the given congruence system.
         * 
         * @param array $congruence_system An array containing triplets representing linear congruencies in the form of [coefficient of x, right side of congruence, modulo].
         * @param int $new_modulo The new modulo we wish to compare to the modulos of the congruence system.
         * 
         * @return bool Returns whether the new modulo is relative prime to the the modulos of the given congruence system, or not.
         */
        private function CheckIfModulosRelativelyPrimes($congruence_system, $new_modulo){
            foreach($congruence_system as $index => $congruence){
                if($this->GetGCDWithIteration([$congruence[2], $new_modulo]) !== 1){
                    return false;
                }
            }
            return true;
        }

        /**
         * 
         * This function is responsible for creating a merged linear congruency from two.
         * 
         * @param array $first_congruence A triplet representing a linear congruence in the form of [coefficient of x, right side of congruence, modulo].
         * @param array $second_congruence A triplet representing a linear congruence in the form of [coefficient of x, right side of congruence, modulo].
         * 
         * @return array Returns a merged linear congruence for the given linear congruences.
         */
        private function GetMergedSolutionForCongruencies($first_congruence, $second_congruence){
            [$a_1, $c_1, $m_1] = $first_congruence;
            [$a_2, $c_2, $m_2] = $second_congruence;
            
            // Diophantine equation: $m_1*x + $m_2*y = 1
            [$solution_x, $solution_y] = $this->GetDiophantineEquationSolution([$m_1, $m_2, 1]);

            // Where all the xs = $solution_x[1] + $solution_x[2]*k (k any integer) and ys= $solution_y[0] + $solution_y[1]*k (k the same integer used for the xs)
            $basic_solution_x = $solution_x[1];
            $basic_solution_y = $solution_y[0];
            $c_12 = $m_1 * $basic_solution_x * $c_2 + $m_2* $basic_solution_y * $c_1;
            $m_12 = $m_1*$m_2;

            if($c_12 > 0){
                while($c_12 - $m_12 > 0){
                    $c_12 -= $m_12;
                }
            }else{
                while($c_12 < 0){
                    $c_12 += $m_12;
                }
            }

            return [1, $c_12, $m_12];
        }
    }
?>