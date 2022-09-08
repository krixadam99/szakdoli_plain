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
         * @param bool $is_first_positive Should we guarantee that the first number is positive, or not. The default value is false.
         * @param bool $is_second_positive Should we guarantee that the second number is positive, or not. The default value is false.
         * 
         * @return array Returns the given amount of pairs of numbers.
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
         * This method is responsible for creating the given amount of triplets of numbers with the condition that non of the created numbers can be 0.
         * 
         * @param int $number_of_triplets The number of triplets the method must return.
         * 
         * @return array Returns the given amount of triplets of numbers.
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
         * This method is responsible for creating the given amount of triplets of numbers with which a linear congruence could be solved.
         * 
         * @param int $number_of_triplets The number of triplets the method is required to return.
         * @param bool $without_zeros Should we guarantee that the triplets don't contain any zero, or not. The default is true.
         * 
         * @return array Returns the given amount of triplets of numbers.
         */
        public function CreateSolvableLinearCongruencies($number_of_triplets, $without_zeros = true){
            $return_triplets = [];
            for($counter = 0; $counter < $number_of_triplets; $counter++){
                $triplet = $this->CreateTripletOfNumbers();
                $b= $triplet[1];
                $gcd = $this->CalculateGCDWithIteration([$triplet[0], $triplet[2]]);
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
                        $gcd = $this->CalculateGCDWithIteration([$triplet[0], $triplet[2]]);
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
         * 
         * @return array Returns the given amount of triplets of numbers (one triplet is one congruence).
         */
        public function CreateSolvableLinearCongruenciesForCRT($number_of_triplets){
            $return_triplets = [];
            for($counter = 0; $counter < $number_of_triplets; $counter++){
                $triplet = $this->CreateTripletOfNumbers();
                $b= $triplet[1];
                $gcd = $this->CalculateGCDWithIteration([$triplet[0], $triplet[2]]); // The linear congruence can be solved
                
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
                        $gcd = $this->CalculateGCDWithIteration([$triplet[0], $triplet[2]]);
                        
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
         * 
         * @return array Returns an array containing the coefficients of the polynomial expression. The coefficients will be in descending manner based on the degrees.
         */
        public function CreatePolynomialExpression($degree){
            // a*(x-x_1)*(x-x_2)*...*(x*x_$degree)
            // Main coefficient = a -> ($degree | $degree) = 1 addition
            // x^($degree-1)'s coefficient = x_1 + ->$_COOKIE ($degree | $degree-1) addition
            // x^($degree-2)'s coefficient = (x_1*...*x_degree-2) + -> ($degree | $degree-2) addition
            // ... x^1's coefficient = (x_1*...*x_degree-1) + -> ($degree | 1) addition
            // x^0's coefficient = x_1*...*x_degree -> ($degree | 0) = 1 addition
            $roots = [];
            $negated_roots = [];
            for($counter = 0; $counter < $degree; $counter++){
                $new_root = mt_rand($this->minimum_number, $this->maximum_number);
                array_push($roots, $new_root);
                array_push($negated_roots, -1*$new_root);
            }

            // Here the roots are given
            // Now it is time to calculate the coefficients:
            $sign = mt_rand(0,1) == 0?-1:1;
            $main_coefficient = $sign*mt_rand(1,5);
            $coefficients = [$main_coefficient];
            for($counter = $degree-1; $counter >= 0; $counter--){
                array_push($coefficients, $main_coefficient*$this->CalculateCoefficientByVieta($negated_roots, $counter));
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
         * 
         * @return array Returns an array containing the places, where the values will be calculated upon substituting the places into the polynomial expression's variables.
         */
        public function CreatePlacesWithRoots($number_of_places, $number_of_roots, $roots){
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
                    $random_element = mt_rand($this->minimum_number,$this->maximum_number);
                    while(in_array($random_element, $return_places) || in_array($random_element, $roots)){
                        $random_element = mt_rand($this->minimum_number,$this->maximum_number);
                    }
                    $return_places[$random_index] = $random_element;
                }
                $counter++;
            }

            return $return_places;
        }

        /**
         * This method uses the Eucleidan algorithm to calculate the greatest common divisor of the given pair.
         * 
         * @param array $pair The pair for which the method will determine the gcd and eucleidan algorithm steps.
         * 
         * @return array Returns an associative array containing each step of the algorithm in the form of [bigger_number, quotient, smaller_number, residue] and the solution.
         */
        public function CalculateGCDWithEucleidan($pair){
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
        public function CalculateLinearCongruenceSolution($triplet){
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
                $gcd_ac = $this->CalculateGCDWithIteration([$a, $c]);
                if($b % $gcd_ac === 0){
                    $gcd_ab = $this->CalculateGCDWithIteration([$a, $b]);
                    $a /= $gcd_ab;
                    $b /= $gcd_ab; 
                    $c /= $this->CalculateGCDWithIteration([$gcd_ab, $c]); 
                    array_push($return_array["steps"], [$a,$b,$c]);

                    while($b % $a !== 0){
                        $b = $b + $c;
                        array_push($return_array["steps"], [$a,$b,$c]);
                    }
                    $b /= $a;
                    $a = 1;
                    $c /= $this->CalculateGCDWithIteration([$a, $c]);
                    
                    array_push($return_array["steps"], [$a,$b,$c]);
                    $return_array["solution"] = [$a,$b,$c];
                }else{
                    $return_array["solution"] = "NINCSEN";
                }
            }else{
                if($a === 0 ){
                    $return_array["solution"] = [0,$b,1];
                }else{
                    $return_array["solution"] = [1,0,$c/$this->CalculateGCDWithIteration([$a, $c])];
                }
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
        public function CalculateDiophantineEquationSolution($triplet){
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
            $first_congruence_solution = $this->CalculateLinearCongruenceSolution($congruence);
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
        public function CalculateLinearCongruenceSystemSolution($congruences){
            $return_array = array("steps" => [], "solution" => []);
            $simplified_congruences = [];
            foreach($congruences as $index => $congruence){
                array_push($simplified_congruences, $this->CalculateLinearCongruenceSolution($congruence)["solution"]);
            }
            array_push($return_array["steps"], $simplified_congruences);

            $merged_solution = $this->CalculateMergedSolutionForCongruencies($simplified_congruences[0], $simplified_congruences[1]);
            array_push($return_array["steps"], $merged_solution);
            for($counter = 2; $counter < count($simplified_congruences); $counter++){
                $merged_solution = $this->CalculateMergedSolutionForCongruencies($merged_solution, $simplified_congruences[$counter]);
                array_push($return_array["steps"], $merged_solution);
            }
            $return_array["solution"] = $merged_solution;
            
            return $return_array;
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
        public function CalculateGCDWithIteration($pair){
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
         * @return array Returns the given amount of triplets of numbers.
         */
        private function CreateTripletOfNumbers(){
            $first_element = mt_rand($this->minimum_number, $this->maximum_number);
            $second_element = mt_rand($this->minimum_number, $this->maximum_number);
            $third_element = mt_rand($this->minimum_number>0?$this->minimum_number:1, $this->maximum_number);
            return [$first_element, $second_element, $third_element];
        }

        /**
         * 
         * This method is responsible for checking if the new modulo is relative prime to the modulos of the given congruence system.
         * 
         * @param array $congruence_system An array containing triplets representing linear congruencies in the form of [coefficient of x, right side of congruence, modulo].
         * @param int $new_modulo The new modulo we wish to compare to the modulos of the congruence system.
         * 
         * @return bool Returns whether the new modulo is relative prime to the the modulos of the given congruence system, or not.
         */
        private function CheckIfModulosRelativelyPrimes($congruence_system, $new_modulo){
            foreach($congruence_system as $index => $congruence){
                if($this->CalculateGCDWithIteration([$congruence[2], $new_modulo]) !== 1){
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
        private function CalculateMergedSolutionForCongruencies($first_congruence, $second_congruence){
            [$a_1, $c_1, $m_1] = $first_congruence;
            [$a_2, $c_2, $m_2] = $second_congruence;
            
            // Diophantine equation: $m_1*x + $m_2*y = 1
            [$solution_x, $solution_y] = $this->CalculateDiophantineEquationSolution([$m_1, $m_2, 1]);

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
        private function CalculateCombinationOfList($original_list, $number_of_remained_iterations = 1, $actual_elements = [], $previous_index = 0){
            if($number_of_remained_iterations >= 1){ // At least 1 iterations remained
                if($number_of_remained_iterations < count($original_list)){ // The number of remained iterations is not greater than, or equal to the number of elements of the original list 
                    if($number_of_remained_iterations > 1){ // At least 2 iterations remained
                        $return_list = [];
                        for($counter = $previous_index; $counter < count($original_list) - $number_of_remained_iterations + 1; $counter++){
                            $temporary_list = $actual_elements; // NOT reference, also this is needed, or else we should pop the last element of $actual_elements in the end of each iteration
                            array_push($temporary_list, $original_list[$counter]);
                            $combination_list = $this->CalculateCombinationOfList($original_list, $number_of_remained_iterations - 1, $temporary_list, $counter + 1); // A part of the final list of combinations
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
        private function CalculateCoefficientByVieta($roots, $index_of_coefficient = 0){
            $actual_index = count($roots) - $index_of_coefficient;
            $combinations = $this->CalculateCombinationOfList($roots, $actual_index);

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