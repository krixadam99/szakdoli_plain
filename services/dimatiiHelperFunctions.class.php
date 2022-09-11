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
         * This method is responsible for creating the given amount of pairs of numbers.
         * 
         * @param int $number_of_pairs The number of pairs the method must return.
         * @param int $lower The lower bound for the range from which a random number will be picked. The default value is -1000.
         * @param int $upper The upper bound for the range from which a random number will be picked. The default value is 1000.
         * @param bool $is_first_positive Should we guarantee that the first number is positive, or not. The default value is false.
         * @param bool $is_second_positive Should we guarantee that the second number is positive, or not. The default value is false.
         * 
         * @return array Returns the given amount of pairs of numbers.
         */
        public function CreatePairsOfNumbers($number_of_pairs, $lower = -1000, $upper = 1000, $is_first_positive = false, $is_second_positive = false){
            $return_pairs = [];
            for($counter = 0; $counter < $number_of_pairs; $counter++){
                $first_element = mt_rand($lower, $upper);
                if($is_first_positive){
                    $first_element = mt_rand(1, $upper);
                }
                $second_element = mt_rand($lower, $upper);
                if($is_second_positive){
                    $second_element = mt_rand(1, $upper);
                }

                while($first_element == $second_element || in_array([$first_element, $second_element], $return_pairs)){
                    $first_element = mt_rand($lower, $upper);
                    if($is_first_positive){
                        $first_element = mt_rand(1, $upper);
                    }
                    $second_element = mt_rand($lower, $upper);
                    if($is_second_positive){
                        $second_element = mt_rand(1, $upper);
                    }
                }
                array_push($return_pairs, [$first_element, $second_element]);
            }
            return $return_pairs;
        }

        /**
         * 
         */
        public function CreateReducedResidueSystemPair(){
            $primes_between_7_and_20 = [7, 11, 13, 17, 19];
            
            //Let the cell number be maximum 8...
            // Euler's phi values starting from 7:  6 (7), 4 (8), 6 (9), 4 (10), 10 (11), 4 (12), 12 (13), 6 (14), 8 (15), 8 (16), 16 (17), 6 (18), 18 (19), 8 (20) ... (from now on above 8)
            $first_number_of_residue_classes = mt_rand(7,20);
            while(in_array($first_number_of_residue_classes, $primes_between_7_and_20)){
                $first_number_of_residue_classes = mt_rand(7,20);
            }

            $second_number_of_residue_classes = mt_rand(7,20);
            while(in_array($second_number_of_residue_classes, $primes_between_7_and_20)){
                $second_number_of_residue_classes = mt_rand(7,20);
            }

            return [[$first_number_of_residue_classes, $this->DetermineReducedResidueSystem($first_number_of_residue_classes)], [$second_number_of_residue_classes, $this->DetermineReducedResidueSystem($second_number_of_residue_classes)]];
        }

        /**
         * 
         * This method is responsible for creating the given amount of triplets of numbers with the condition that non of the created numbers can be 0.
         * 
         * @param int $number_of_triplets The number of triplets the method must return.
         * @param int $lower The lower bound for the range from which a random number will be picked. The default value is -1000.
         * @param int $upper The upper bound for the range from which a random number will be picked. The default value is 1000.
         * 
         * @return array Returns the given amount of triplets of numbers.
         */
        public function CreateTripletsOfNumbersWithoutZero($number_of_triplets, $lower = -1000, $upper = 1000){
            $return_triplets = [];
            for($counter = 0; $counter < $number_of_triplets; $counter++){
                $triplet = $this->CreateTripletOfNumbers($lower, $upper);
                while($triplet[0] == 0 
                    || $triplet[1] == 0 
                    || $triplet[2] == 0 
                    || in_array($triplet, $return_triplets)
                    ){
                        $triplet = $this->CreateTripletOfNumbers($lower, $upper);
                }
                array_push($return_triplets, $triplet);
            }
            return $return_triplets;
        }

        /**
         * 
         * This method is responsible for creating the given amount of triplets of numbers with which a linear congruence could be solved.
         * 
         * @param int $number_of_triplets The number of triplets the method is required to return.
         * @param bool $without_zeros Should we guarantee that the triplets don't contain any zero, or not. The default is true.
         * @param int $lower The lower bound for the range from which a random number will be picked for the elements of the congruences. The default value is -1000.
         * @param int $upper The upper bound for the range from which a random number will be picked for the elements of the congruences. The default value is 1000.
         * 
         * @return array Returns the given amount of triplets of numbers.
         */
        public function CreateSolvableLinearCongruencies($number_of_triplets, $without_zeros = true, $lower = -1000, $upper = 1000){
            $return_triplets = [];
            for($counter = 0; $counter < $number_of_triplets; $counter++){
                $triplet = $this->CreateTripletOfNumbers($lower, $upper);
                $b= $triplet[1];
                $gcd = $this->DetermineGCDWithIteration([$triplet[0], $triplet[2]]);
                $was_there_zero = false;
                if($without_zeros){
                    $was_there_zero = $triplet[0] === 0 || $triplet[1] === 0 || $triplet[2] === 0;
                }
                while( $was_there_zero 
                    || in_array($triplet, $return_triplets)
                    || $b % $gcd !== 0
                    ){
                        $triplet = $this->CreateTripletOfNumbers($lower, $upper);
                        $b= $triplet[1];
                        $gcd = $this->DetermineGCDWithIteration([$triplet[0], $triplet[2]]);
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
         * This method is responsible for creating the given amount of triplets of numbers symbolising the linear congruencies with which CRT can be solved.
         * 
         * Conditions for linear congruencies in the system:
         * non of the numbers in the linear congruencies is 0;
         * the linear congruencies should contain different numbers for the modulo and the other parts of the congruence (left and right hand side can be similar);
         * the modulos in the system should be pairwise relatively prime (this also guarantees, that the system contains ).
         * 
         * @param int $number_of_triplets The number of triplets (symbolising the congruencies) the method must return.
         * @param int $lower The lower bound for the range from which a random number will be picked for the elements of the congruences. The default value is -1000.
         * @param int $upper The upper bound for the range from which a random number will be picked for the elements of the congruences. The default value is 1000.
         * 
         * @return array Returns the given amount of triplets of numbers (one triplet is one congruence).
         */
        public function CreateSolvableLinearCongruenciesForCRT($number_of_triplets, $lower = -1000, $upper = 1000){
            $return_triplets = [];
            for($counter = 0; $counter < $number_of_triplets; $counter++){
                $triplet = $this->CreateTripletOfNumbers($lower, $upper);
                $b= $triplet[1];
                $gcd = $this->DetermineGCDWithIteration([$triplet[0], $triplet[2]]); // The linear congruence can be solved
                
                $was_there_zero = $triplet[0] === 0 || $triplet[1] === 0 || $triplet[2] === 0; // Non of the coefficients in the congruence is zero
                $triplet_contains_similar = abs($triplet[1]) === abs($triplet[2]) || abs($triplet[0]) === abs($triplet[2]); // The left and right hand sides are different from the modulo  
                $is_modulo_relative_prime_to_modulos = $this->CheckIfModulosRelativelyPrimes($return_triplets, $triplet[2]); // New modulo is relatively prime to the modulos in the congruence system

                while( $was_there_zero
                    || $triplet_contains_similar 
                    || !$is_modulo_relative_prime_to_modulos
                    || in_array($triplet, $return_triplets)
                    || $b % $gcd !== 0
                    ){
                        $triplet = $this->CreateTripletOfNumbers($lower, $upper);
                        $b= $triplet[1];
                        $gcd = $this->DetermineGCDWithIteration([$triplet[0], $triplet[2]]);
                        
                        $was_there_zero = $triplet[0] === 0 || $triplet[1] === 0 || $triplet[2] === 0; // Non of the coefficients in the congruence is zero
                        $triplet_contains_similar = abs($triplet[1]) === abs($triplet[2]) || abs($triplet[0]) === abs($triplet[2]); // The left and right hand sides are different from the modulo 
                        $is_modulo_relative_prime_to_modulos = $this->CheckIfModulosRelativelyPrimes($return_triplets, $triplet[2]); // New modulo is relatively prime to the modulos in the congruence system
                }
                array_push($return_triplets, $triplet);
            }
            return $return_triplets;
        }

        /**
         * 
         * This method creates a polynomial expression which degree is given as an argument.
         * 
         * The method will create $degree number of not necessarily distinct number of roots, then uses generalized Viéte's formulas to determine the coefficients.
         * 
         * @param int $degree A positive integer which determines the degree of the created polynomial expression.
         * @param int $lower The lower bound for the range from which a random number will be picked for a root. The default value is -10.
         * @param int $upper The upper bound for the range from which a random number will be picked for a root. The default value is 10.
         * 
         * @return array Returns an array containing the coefficients of the polynomial expression. The coefficients will be in descending manner based on the degrees.
         */
        public function CreatePolynomialExpression($degree, $lower = -10, $upper = 10){
            // a*(x-x_1)*(x-x_2)*...*(x*x_$degree)
            // Main coefficient = a -> ($degree | $degree) = 1 addition
            // x^($degree-1)'s coefficient = x_1 + ->$_COOKIE ($degree | $degree-1) addition
            // x^($degree-2)'s coefficient = (x_1*...*x_degree-2) + -> ($degree | $degree-2) addition
            // ... x^1's coefficient = (x_1*...*x_degree-1) + -> ($degree | 1) addition
            // x^0's coefficient = x_1*...*x_degree -> ($degree | 0) = 1 addition
            $roots = [];
            $negated_roots = [];
            for($counter = 0; $counter < $degree; $counter++){
                $new_root = mt_rand($lower, $upper);
                array_push($roots, $new_root);
                array_push($negated_roots, -1*$new_root);
            }

            // Here the roots are given
            // Now it is time to calculate the coefficients:
            $sign = mt_rand(0,1) == 0?-1:1;
            $main_coefficient = $sign*mt_rand(1,5); // The main coefficient is never 0
            $coefficients = [$main_coefficient];
            for($counter = $degree-1; $counter >= 0; $counter--){
                array_push($coefficients, $main_coefficient*$this->DetermineCoefficientByVieta($negated_roots, $counter));
            }

            return [$coefficients, $roots];
        }

        /**
         * This method returns the requested amount of places which will include the given amount of roots.
         * 
         * There is a chance, that the number of places that should be from the roots array is greater than, or equal to the number of requested places. In this case, a part of the roots array should be returned with extra places that are not roots.
         * It is possible, that the number of places that should be from the roots array is greater than, or equla to the number of distinct elements in the roots array. In this case, the distinct elements of the roots array should be returned with extra places that are not roots.
         * 
         * @param int $number_of_places The number of places the method will return.
         * @param int $number_of_roots The number of places that will be a root.
         * @param array $roots An indexed array containing the roots of a polynomial expression.
         * @param int $lower The lower bound for the range from which a random number will be picked for a place. The default value is -10.
         * @param int $upper The upper bound for the range from which a random number will be picked for a place. The default value is 10.
         * 
         * @return array Returns an array containing the places, where the values will be calculated upon substituting the places into the polynomial expression's variables.
         */
        public function CreatePlacesWithRoots($number_of_places, $number_of_roots, $roots, $lower = -10, $upper = 10){
            $return_places = [];
            
            // Distinct roots
            $distinct_roots = [];
            foreach($roots as $index => $root){
                if(!in_array($root, $distinct_roots)){
                    array_push($distinct_roots, $root);
                }
            }

            // Add places to return array
            $counter = 0;
            $root_counter = 0;
            $random_indices = [];
            while($counter < $number_of_places){
                $random_index = mt_rand(0,$number_of_places-1);
                while(in_array($random_index, $random_indices)){
                    $random_index = mt_rand(0,$number_of_places-1);
                }
                array_push($random_indices, $random_index);

                if(  $root_counter < count($distinct_roots)
                  && $root_counter < $number_of_roots
                ){
                    $random_element_from_roots = $distinct_roots[mt_rand(0,count($distinct_roots)-1)];
                    while(in_array($random_element_from_roots, $return_places)){
                        $random_element_from_roots = $distinct_roots[mt_rand(0,count($distinct_roots)-1)];
                    }
                    $return_places[$random_index] = $random_element_from_roots; 
                    $root_counter++;
                }else{
                    $random_element = mt_rand($lower, $upper);
                    while(in_array($random_element, $return_places) || in_array($random_element, $roots)){
                        $random_element = mt_rand($lower, $upper);
                    }
                    $return_places[$random_index] = $random_element;
                }
                $counter++;
            }

            ksort($return_places);
            return $return_places;
        }

        /**
         * 
         * This method creates the given amount of points.
         * 
         * Each points are distinct, and the first coordinates are pairwise different. 
         * 
         * @param int $number_of_points The number of points the method returns.
         * @param int $lower The lower bound for the range from which a random number will be picked for the first coordinate. The default value is -1000.
         * @param int $upper The upper bound for the range from which a random number will be picked for the first coordinate. The default value is 1000.
         * 
         * @return array Returns the given amount of points.
         */
        public function CreatePoints($number_of_points, $lower = -1000, $upper = 1000){
            $return_points = [];
            $first_coordinates = []; 
            for($counter = 0; $counter < $number_of_points; $counter++){
                $first_element = mt_rand($lower, $upper);
                $second_element = mt_rand($lower, $upper);

                while( in_array([$first_element, $second_element], $return_points) 
                    || in_array($first_element, $first_coordinates)){
                    $first_element = mt_rand($lower, $upper);
                    $second_element = mt_rand($lower, $upper);
                }
                array_push($return_points, [$first_element, $second_element]);
                array_push($first_coordinates, $first_element);
            }
            return $return_points;
        }

        /**
         * This method determines the quotients and residues for the given pairs of numbers, where the first number of the pair is the dividend and the secind is the divisor.
         * 
         * @param array $pairs The pairs of which the method returns the quotients and residues. Each of them is of the form of [dividend, divisor].
         * 
         * @return array Returns an indexed array containing the quotients and residues after dividing each pair's first component with the second.
         */ 
        public function DetermineQuotientAndResidue($pairs){
            $quotients_and_residues = [];
            foreach($pairs as $pair_index => $pair){
                $dividend = $pair[0];
                $divisor = $pair[1];

                $quotient = 0;
                if($dividend >= 0){
                    if($divisor > 0){
                        // 5,4
                        // 5,8
                        // 5,5
                        // 0,5
                        while($dividend - ($quotient + 1) * $divisor >= 0){
                            $quotient++;
                        }
                        $residue = $dividend - $quotient * $divisor;
                    }else if($divisor <0){
                        // 5,-1
                        // 5,-5
                        // 5,-8
                        // 0,-1
                        while($dividend - ($quotient - 1) * $divisor >= 0){
                            $quotient--;
                        }
                        $residue = $dividend - $quotient * $divisor;
                    }else{ // Illegal
                        $residue = 0;
                    }
                }else{
                    if($divisor > 0){
                        // -5,4
                        // -5,8
                        // -5,5
                        while($dividend - $quotient * $divisor < 0){
                            $quotient--;
                        }
                        $residue = $dividend - $quotient * $divisor;
                    }else if($divisor <0){
                        // -5,-1
                        // -5,-5
                        // -5,-8
                        while($dividend - $quotient * $divisor < 0){
                            $quotient++;
                        }
                        $residue = $dividend - $quotient * $divisor;
                    }else{ // Illegal
                        $residue = 0;
                    }
                }
                array_push($quotients_and_residues, [$quotient, $residue]);
            }
            return $quotients_and_residues;
        }

        /**
         * This method determines the prime factorization for each given number.
         * 
         * @param array $numbers The array containing the numbers for which the method gives the prime factorization.
         * 
         * @return array Returns an indexed array containing the prime factorization for each given number. The prime factorizations are stored in an indexed array, the factorization consists of [prime number, number of occurence] pairs.
         */
        public function DeterminePrimeFactorization($numbers){
            $prime_factorizations = [];
            foreach($numbers as $number_index => $number){
                $prime_factorization = [];

                $number = abs($number);
                $divisor = 2;
                while($number > 1){
                    $is_divisor_prime = $this->IsPrime($divisor);
                    if($is_divisor_prime){
                        $occurence = 0;
                        while($number % $divisor === 0 && $number > 0){
                            $number /= $divisor;
                            $occurence++;
                        }
                        if($occurence > 0){
                            array_push($prime_factorization, [$divisor, $occurence]);
                        }
                    }
                    $divisor++;
                }

                array_push($prime_factorizations, $prime_factorization);
            }
            return $prime_factorizations;
        }

        /**
         * This method determines the number of positive divisors for each given number.
         * 
         * @param array $numbers The array containing the numbers for which the method gives the number of positive divisors.
         * 
         * @return array Returns an indexed array containing the number of positive divisors for each given number.
         */
        public function DetermineNumberOfDivisors($numbers){
            $count_positive_divisors_array = [];
            foreach($numbers as $number_index => $number){
                $count_positive_divisors = 1;
                $prime_factorization =  $this->DeterminePrimeFactorization([$number])[0];
                foreach($prime_factorization as $factor_index => $factor_pair){
                    $count_positive_divisors *= $factor_pair[1] + 1;
                }
                array_push($count_positive_divisors_array, $count_positive_divisors);
            }
            return $count_positive_divisors_array;
        }

        /**
         * This method determines all of the residue classes for the Z/moduloZ complete residue system with a representative per residue class.
         * 
         * @param int $modulo A positive integer for which the method returns the complete residue system.
         * 
         * @return array Returns an indexed array containing all of the resiude classes for Z/moduloZ. Each resiude class is represented by an element, thus the method returns an array containing n numbers.
         */
        public function DetermineCompleteResidueSystem($modulo){
            if($modulo > 0){
                $complete_residue_system = [];

                for($residue_class_representative = 0; $residue_class_representative < $modulo; $residue_class_representative++){
                    array_push($complete_residue_system, $residue_class_representative);
                }
    
                return $complete_residue_system;
            }else{
                return [];
            }
        }

        /**
         * This method determines all of the residue classes for the (Z/moduloZ)* reduced residue system with a representative per residue class.
         * 
         * @param int $modulo A positive integer for which the method returns the reduced residue system.
         * 
         * @return array Returns an indexed array containing all of the resiude classes for (Z/moduloZ)*. Each resiude class is represented by an element, thus the method returns an array containing phi(n) (Euler's phi function) numbers.
         */
        public function DetermineReducedResidueSystem($modulo){
            if($modulo > 0){
                $reduced_residue_system = [];

                for($residue_class_representative = 0; $residue_class_representative < $modulo; $residue_class_representative++){
                    if($this->DetermineGCDWithIteration([$residue_class_representative,$modulo]) === 1){
                        array_push($reduced_residue_system, $residue_class_representative);
                    }
                }
    
                return $reduced_residue_system;
            }else{
                return [];
            }
        }

        /**
         * This method computes the value for the input by the Euler Phi function. This value for an input is the number of positive integers up to it that are relatively primes to it as well.
         * 
         * @param int $input_value The input for which the method determines the number of positive integers up to and are relatively primes to it as well.
         * 
         * @return int Returns the positive integers up to the given input that are relatively primes to it.
         */
        public function DetermineEulerPhiValue($input_value){
            if($input_value >= 0){
                $euler_phi_value = 1;
                $prime_factorization = $this->DeterminePrimeFactorization([$input_value])[0];
                foreach($prime_factorization as $pair_counter => $factor){
                    $prime = $factor[0];
                    $exponent = $factor[1];
                    $euler_phi_value *= pow($prime, $exponent - 1)*($prime - 1); // $factor - $prime ^ (exponent - 1), e.g.: phi(2^3) = 8 - 4 = 4 (1, 3, 5, 7) 
                }
                return $euler_phi_value;
            }else{
                return 0;
            }
        }

        /**
         * This method uses the Eucleidan algorithm to Determine the greatest common divisor of the given pair.
         * 
         * @param array $pair The pair for which the method will determine the gcd and eucleidan algorithm steps.
         * 
         * @return array Returns an associative array containing each step of the algorithm in the form of [bigger_number, quotient, smaller_number, residue] and the solution.
         */
        public function DetermineGCDWithEucleidan($pair){
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
         * This method uses the linear congruence solver algorithm to give the final congruence for a given linear congruence.
         * 
         * @param array $triplet The triplet for which the method will determine the linear congruence and algorithm steps.
         * 
         * @return array Returns an associative array containing each step of the algorithm in the form of [first operand, second operand, modulo] and the solution.
         */
        public function DetermineLinearCongruenceSolution($triplet){
            $return_array = array("steps" => [], "solution" => []);
            
            $a = $triplet[0];
            $b = $triplet[1];
            $modulo = abs($triplet[2]); // $c can be negative and positive, the congruence means the same
            
            // Make $a and $b coefficients positive
            while($a < 0){
                $a += $modulo;
            } 
            while($b < 0){
                $b += $modulo;
            }

            if($a !== 0){
                // Check if congruence is solvable
                $gcd_ac = $this->DetermineGCDWithIteration([$a, $modulo]);
                if($b % $gcd_ac === 0){
                    // Divide every coefficient and the modulo with the greatest common divisor of the non-modulo coefficients 
                    $gcd_ab = $this->DetermineGCDWithIteration([$a, $b]);
                    if($gcd_ab !== 0){
                        $a /= $gcd_ab;
                        $b /= $gcd_ab; 
                        $modulo /= $this->DetermineGCDWithIteration([$gcd_ab, $modulo]); 
                    }

                    // Introduce a new, helper congruence
                    // This method will follow the example of the eucleidan algorithm
                    $helper_congruence_a = $modulo;
                    $helper_congruence_b = 0;

                    // In every turn, the congruence with the smaller coefficient (next to the x) will be substracted from the congruence with the bigger coefficient
                    // Since in each turn a smaller (or equal) number will be substracted from the bigger, the coefficient next to the x will be always non-negative (an invariant characteristic)
                    array_push($return_array["steps"], [$a, $b, $modulo, $helper_congruence_a, $helper_congruence_b]);
                    while($helper_congruence_a !== 0 && $a !== 0){
                    if($helper_congruence_a > $a){
                            $helper_congruence_a -= $a;
                            $helper_congruence_b -= $b;
                    }else{
                            $a -= $helper_congruence_a;
                            $b -= $helper_congruence_b;
                    }
                    array_push($return_array["steps"], [$a, $b, $modulo, $helper_congruence_a, $helper_congruence_b]);
                    }

                    // Getting the solution
                    // We have to choose the congruence with non-zero left side coefficient
                    if($helper_congruence_a === 0){
                        // Simplify the right side coefficient in the congruence where the left side coefficient is zero
                        if($helper_congruence_b < 0){
                            while($helper_congruence_b - $modulo >= 0){
                                $helper_congruence_b -= $modulo;
                            }
                        }else{
                            while($helper_congruence_b + $modulo <= 0){
                                $helper_congruence_b += $modulo;
                            }
                        }

                        if($helper_congruence_b !== 0){
                            $return_array["solution"] = "NINCSEN";
                        }else{
                            // Divide the coefficients in the congruence with the the greatest common divisor of the non-modulo coefficients 
                            $gcd_ab = $this->DetermineGCDWithIteration([$a, $b]);
                            if($gcd_ab !== 0){
                                $modulo /= $this->DetermineGCDWithIteration([$gcd_ab, $modulo]);    
                            }
                            if($a !== 0){
                                $b /= $a;
                                $a = 1;
                            }

                            // Minimize the right side coefficient in the solution
                            if($b >= 0){
                                while($b - $modulo >= 0){
                                    $b -= $modulo;
                                }
                            }else{
                                while($b <= 0){
                                    $b += $modulo;
                                }
                            }

                            $return_array["solution"] = [$a,$b,$modulo];
                        }
                    }else{
                        // Simplify the right side coefficient in the congruence where the left side coefficient is zero
                        if($b >= 0){
                            while($b - $modulo >= 0){
                                $b -= $modulo;
                            }
                        }else{
                            while($b + $modulo <= 0){
                                $b += $modulo;
                            }
                        }

                        if($b !== 0){
                            $return_array["solution"] = "NINCSEN";
                        }else{
                            // Divide the coefficients in the congruence with the the greatest common divisor of the non-modulo coefficients
                            $gcd_ab = $this->DetermineGCDWithIteration([$helper_congruence_a, $helper_congruence_b]);
                            if($gcd_ab !== 0){
                                $modulo /= $this->DetermineGCDWithIteration([$gcd_ab, $modulo]);    
                            }
                            $helper_congruence_b /= $helper_congruence_a; // In this branch: $helper_congruence_a !== 0
                            $helper_congruence_a = 1;

                            // Minimize the right side coefficient in the solution
                            if($helper_congruence_b >= 0){
                                while($helper_congruence_b - $modulo >= 0){
                                    $helper_congruence_b -= $modulo;
                                }
                            }else{
                                while($helper_congruence_b <= 0){
                                    $helper_congruence_b += $modulo;
                                }
                            }

                            $return_array["solution"] = [$helper_congruence_a, $helper_congruence_b, $modulo];
                        }
                    }
                }else{
                    $return_array["solution"] = "NINCSEN";
                }
            }else{
                $return_array["solution"] = [0,$b,$modulo];
            }
            

            return $return_array;
        }

        /**
         * This method uses the diophantine equation solver algorithm to get the solution for a diophatnine equation.
         * 
         * @param array $triplet The triplet representing a diophantine equation for which the method will determine the solution and algorithm steps. It is in the form of ax + bx = c, where a is the first, b the second and c the third triplet element.
         * 
         * @return array Returns an array containing the solution of the algorithm.
         */
        public function DetermineDiophantineEquationSolution($triplet){
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
            $first_congruence_solution = $this->DetermineLinearCongruenceSolution($congruence);
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
         * This method uses the algorithm used while proving chinese remainder theorem to get the solution for a linear congruence system.
         * 
         * The method solves the linear congruences in the system, then it will calculate a shared solution for the first two congruences, and substitute those with it.
         * The algorithm continues until only one linear congruence remains.
         * 
         * @param array $congruences The triplets representing the linear congruences in the system. Each of them is of the form [coefficient of x, right side of congruence, modulo].
         * 
         * @return array Returns an array containing each step and the solution of the algorithm.
         */
        public function DetermineLinearCongruenceSystemSolution($congruences){
            $return_array = array("steps" => [], "solution" => []);
            $simplified_congruences = [];
            foreach($congruences as $index => $congruence){
                array_push($simplified_congruences, $this->DetermineLinearCongruenceSolution($congruence)["solution"]);
            }
            array_push($return_array["steps"], $simplified_congruences);

            $merged_solution = $this->DetermineMergedSolutionForCongruencies($simplified_congruences[0], $simplified_congruences[1]);
            array_push($return_array["steps"], $merged_solution);
            for($counter = 2; $counter < count($simplified_congruences); $counter++){
                $merged_solution = $this->DetermineMergedSolutionForCongruencies($merged_solution, $simplified_congruences[$counter]);
                array_push($return_array["steps"], $merged_solution);
            }
            $return_array["solution"] = $merged_solution;
            
            return $return_array;
        }

        /**
         * This method determines the Horner scheme for the given places and polynomial expression.
         * 
         * @param array $polynomial_expression An indexed array containing the coefficients of a polynomial expression from the main coefficient to the constant part's coefficient (descending manner based on the degree).
         * @param array $places The places where the method determines the Horner scheme. 
         * 
         * @return array Returns an indexed array containing the Horner schemes for each polynomial expression and places.
         */
        public function DetermineHornerSchemes($polynomial_expression, $places){
            $horner_schemes = [];
            foreach($places as $place_index => $place){
                $horner_scheme = [];
                $solution_part = 0;
                foreach($polynomial_expression as $polynomial_index => $polynomial_coefficient){
                    if($polynomial_index === 0){
                        $solution_part = $polynomial_coefficient;
                    }else{
                        $solution_part = $place*$solution_part + $polynomial_coefficient;
                    }
                    array_push($horner_scheme, $solution_part);
                }
                array_push($horner_schemes, $horner_scheme);
            }

            return $horner_schemes;
        }

        /**
         * 
         */
        public function DeterminePolynomialDivision($dividend_polynomial_expression, $divisor_polynomial_expression){
            if(count($dividend_polynomial_expression) !== 0 && count($divisor_polynomial_expression) !== 0){
                $quotient = [];
                $residue = [];
                
                // 1. 3x^2+3x+3 / x+2 -> 0-1
                // 2. 3x^2+3x+3 / 2 -> 0-1-2
                // 3. 3x^2+3x+3 / x^2 -> 0
                for($coefficient_counter = 0; $coefficient_counter <= count($dividend_polynomial_expression) - count($divisor_polynomial_expression); $coefficient_counter++){
                    $actual_coefficient = $dividend_polynomial_expression[$coefficient_counter];
                    
                    // 1. 3; -3;
                    // 2. 3/2; 3/2; 3/2
                    // 3. 3
                    $actual_quotient_coefficient = $actual_coefficient/$divisor_polynomial_expression[0]; // $divisor_polynomial_expression[0] cannot be 0
                    array_push($quotient, $actual_quotient_coefficient);
        
                    // 1. 0x^2 - 3x + 3; 0x^2 - 0x + 9
                    // 2. 0x^2 + 3x + 3; 0x^2 + 0x + 3; 0
                    // 3. 0x^2 + 3x + 3
                    for($substract_index = 0; $substract_index < count($divisor_polynomial_expression); $substract_index++){
                        $dividend_polynomial_expression[$substract_index + $coefficient_counter] -= $actual_quotient_coefficient*$divisor_polynomial_expression[$substract_index];
                    }
                }
        
                foreach($dividend_polynomial_expression as $coefficient_counter => $coefficient){
                    if($coefficient !== 0){
                        array_push($residue, $coefficient);
                    }
                }
        
                return [$quotient, $residue];
            }else{
                return [[],[]];
            }
        }

        /**
         * This method uses iteration to get the greatest common divisor of two numbers.
         * 
         * Since the gcd is positive, the method will firstly take the absolute value of the given numbers.
         * 
         * @param array $pair The pair for which the method will determine the gcd.
         * 
         * @return int Returns the (positive) gcd for the given pair.
         */
        public function DetermineGCDWithIteration($pair){
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
         * This method is responsible for creating a triplet of numbers.
         * 
         * The triplets here will represent linear congruencies in the form of [coefficient of x, right side of congruence, modulo].
         * We will only require the modulo to be non-zero, since the ax \equiv b (mod c) congruency can be rewritten as ax-b = ck, where k is an integer, we can multiply both side with -1, and get the same result, that is, ax \equiv b (mod -c).
         * 
         * @param int $lower The lower bound for the range from which a random number will be picked. The default value is -1000.
         * @param int $upper The upper bound for the range from which a random number will be picked. The default value is 1000.
         * 
         * @return array Returns the given amount of triplets of numbers.
         */
        private function CreateTripletOfNumbers($lower = 0, $upper = 1000){
            $first_element = mt_rand($lower, $upper);
            $second_element = mt_rand($lower, $upper);
            $third_element = mt_rand($lower>0?$lower:1, $upper);
            return [$first_element, $second_element, $third_element];
        }

        /**
         * This private mehtod checks whether the given number is a prime, or not.
         * 
         * @param int $number An integer which will be checked for being a prime.
         * 
         * @return bool Returns true if the given number is a prime, else it returns false.
         */
        public function IsPrime($number){
            $number = abs($number);
            for($divisor = 2; $divisor <= sqrt($number); $divisor++){
                if($number % $divisor === 0){
                    return false;
                }
            }
            return true;
        }

        /**
         * 
         * This private method is responsible for checking if the new modulo is relative prime to the modulos of the given congruence system.
         * 
         * @param array $congruence_system An array containing triplets representing linear congruencies in the form of [coefficient of x, right side of congruence, modulo].
         * @param int $new_modulo The new modulo we wish to compare to the modulos of the congruence system.
         * 
         * @return bool Returns whether the new modulo is relative prime to the the modulos of the given congruence system, or not.
         */
        private function CheckIfModulosRelativelyPrimes($congruence_system, $new_modulo){
            foreach($congruence_system as $index => $congruence){
                if($this->DetermineGCDWithIteration([$congruence[2], $new_modulo]) !== 1){
                    return false;
                }
            }
            return true;
        }

        /**
         * 
         * This method is responsible for creating a merged linear congruency from two.
         * 
         * @param array $first_congruence A triplet representing a linear congruence in the form of [coefficient of x, right side of congruence, modulo].
         * @param array $second_congruence A triplet representing a linear congruence in the form of [coefficient of x, right side of congruence, modulo].
         * 
         * @return array Returns a merged linear congruence for the given linear congruences.
         */
        private function DetermineMergedSolutionForCongruencies($first_congruence, $second_congruence){
            [$a_1, $c_1, $m_1] = $first_congruence;
            [$a_2, $c_2, $m_2] = $second_congruence;
            
            // Diophantine equation: $m_1*x + $m_2*y = 1
            [$solution_x, $solution_y] = $this->DetermineDiophantineEquationSolution([$m_1, $m_2, 1]);

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

        /**
         * 
         * This private recursive method creates a list containing possible combinations of the elements of the given list, where the number of elements per list is also given.
         * 
         * The list will be iterated through by embedded iterations, where the "deepest level" is the same as the required amount of elements per combination.
         * Every iteration will start from the element following the "parent" iteration's actual element and ends at the element of the index of the original (list's size - original number of elements per combination + level of iteration (embedding count)).
         * The element pushing happens on the deppest level.
         * Since embedding n number of iterations is tedious and certainly not a good practice, the easiest way to implement this task is to make it recursive.
         * 
         * @param array $original_list The original list of which the method will give the combinations.
         * @param int $number_of_remained_iterations The number of remained iterations. This decreases by every recursive call.
         * @param array $actual_elements This is a list of elements. It is growing every turn, and will finally contain a combination when it gets to the deepest level of iterations. When this finally contains as many elements as originally was required, then it gets pushed to the return array.
         * @param int $previous_index The previous iteration's last element's index.
         * 
         * @return array An indexed array containing possible combinations of the original list's elements (required number of elements). In the final level all of the combinations are in the returned array.
        */
        private function DetermineCombinationOfList($original_list, $number_of_remained_iterations = 1, $actual_elements = [], $previous_index = 0){
            if($number_of_remained_iterations >= 1){ // At least 1 iterations remained
                if($number_of_remained_iterations < count($original_list)){ // The number of remained iterations is not greater than, or equal to the number of elements of the original list 
                    if($number_of_remained_iterations > 1){ // At least 2 iterations remained
                        $return_list = [];
                        for($counter = $previous_index; $counter < count($original_list) - $number_of_remained_iterations + 1; $counter++){
                            $temporary_list = $actual_elements; // NOT reference, also this is needed, or else we should pop the last element of $actual_elements in the end of each iteration
                            array_push($temporary_list, $original_list[$counter]);
                            $combination_list = $this->DetermineCombinationOfList($original_list, $number_of_remained_iterations - 1, $temporary_list, $counter + 1); // A part of the final list of combinations
                            $return_list = array_merge($return_list, $combination_list); // Merging the list of combinations with part of the possible combinations  
                        }
                        return $return_list;
                    }elseif($number_of_remained_iterations === 1){ // There is only 1 iteration left
                        $return_list = [];
                        for($counter = $previous_index; $counter < count($original_list); $counter++){
                            $temporary_list = $actual_elements; // NOT reference, also this is needed, or else we should pop the last element of $actual_elements in the end of each iteration
                            array_push($temporary_list, $original_list[$counter]);
                            array_push($return_list, $temporary_list);
                        }
                        return $return_list; // Returning a part of the final combination's list, this is the deepest level of iterations
                    }
                }else{
                    return [$original_list];
                }
            }
            
            return [];
        }

        /**
         * 
         * This private method will use the given roots to calculate the coefficient given by its index.
         * 
         * By Viéte the number of elements per combinations is (the size of the array containing roots - index of coefficient).
         * 
         * @param array $roots The roots of a polynomial expression.
         * @param int $index_of_coefficient The index of coefficient which the method will calculate.
         * 
         * @return int Returns the coefficient given by its index.
        */
        private function DetermineCoefficientByVieta($roots, $index_of_coefficient = 0){
            $actual_index = count($roots) - $index_of_coefficient;
            $combinations = $this->DetermineCombinationOfList($roots, $actual_index);

            $sum = 0;
            foreach($combinations as $combination_index => $combination){
                $prod = 1;
                foreach($combination as $element_index => $combination_element){
                    $prod *= $combination_element; 
                }
                $sum += $prod;
            }

            return $sum;
        }
    }
?>