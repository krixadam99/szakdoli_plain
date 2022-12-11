<?php
    /**
     * This helper class contains only static methods. 
     * 
     * These methods will create printable forms of different mathematical structures (like relation, point, polynomial expression). 
     * These will be used by the views and subtask generator classes.
     */
    class PrintServices {
        /**
         * This method returns the correct hungarian suffix for a number.
         * 
         * @param int $number The number for which the method returns the correct suffix.
         * 
         * @return string Returns the correct suffix for the given number. 
         */
        static function UseCorrectAdverb($number){
            $suffix = "";
            switch(intval($number) % 10){
                case 0: {
                    switch(intval($number) % 100){
                        case 0: $suffix = "al";break;
                        case 10: $suffix = "zel";break;
                        case 20: $suffix = "szal";break;
                        case 30: $suffix = "cal";break;
                        case 40: $suffix = "nel";break;
                        case 50: $suffix = "nel";break;
                        case 60: $suffix = "nal";break;
                        case 70: $suffix = "nel";break;
                        case 80: $suffix = "nal";break;
                        case 90: $suffix = "nel";break;
                    }
                };break;
                case 1: $suffix = "gyel";break;
                case 2: $suffix = "vel";break;
                case 3: $suffix = "mal";break;
                case 4: $suffix = "gyel";break;
                case 5: $suffix = "tel";break;
                case 6: $suffix = "tal";break;
                case 7: $suffix = "tel";break;
                case 8: $suffix = "cal";break;
                case 9: $suffix = "cel";break;
            }
            return $suffix;
        }
    
        /**
         * This method returns the correct hungarian object suffix for a number.
         * 
         * @param int $number The number for which the method returns the correct object suffix.
         * 
         * @return string Returns the correct object suffix for the given number. 
         */
        static function UseCorrectObjectSuffix($number){
            $suffix = "";
            switch(intval($number) % 10){
                case 0: {
                    switch(intval($number) % 100){
                        case 0: $suffix = "t";break;
                        case 10: $suffix = "et";break;
                        case 20: $suffix = "at";break;
                        case 30: $suffix = "at";break;
                        case 40: $suffix = "et";break;
                        case 50: $suffix = "et";break;
                        case 60: $suffix = "at";break;
                        case 70: $suffix = "et";break;
                        case 80: $suffix = "at";break;
                        case 90: $suffix = "et";break;
                    }
                };break;
                case 1: $suffix = "et";break;
                case 2: $suffix = "őt";break;
                case 3: $suffix = "at";break;
                case 4: $suffix = "et";break;
                case 5: $suffix = "öt";break;
                case 6: $suffix = "ot";break;
                case 7: $suffix = "et";break;
                case 8: $suffix = "at";break;
                case 9: $suffix = "et";break;
            }
            return $suffix;
        }

        /**
         * This method prints out a polynomial expression.
         * 
         * @param int $polynomial_degree The degree of the polynomial expression.
         * @param array $polynomial_expression_coefficients The coefficients of the polynomial expression.
         * 
         * @return void
         */
        static function PrintPolynomialExpression($polynomial_degree, $polynomial_expression_coefficients){
            foreach($polynomial_expression_coefficients as $coefficient_index => $coefficient){
                $actual_index = $polynomial_degree - $coefficient_index;
                
                $prefix = "";
                if($coefficient_index != 0){
                    $prefix = $coefficient < 0?" - ":" + ";
                    $coefficient = abs($coefficient);
                }
                if($coefficient != 0){
                    $coefficient = $coefficient === 1 && $actual_index !== 0?"":$coefficient;
                    $coefficient = $coefficient === -1 && $coefficient_index === 0?"-":$coefficient;
                    $variable = $actual_index === 0?"":"x";
                    $expo = $actual_index <= 1?"":"<sup>$actual_index</sup>";
                    echo($prefix . $coefficient . $variable . $expo);
                }
            }
        }

        /**
         * This method returns the printable version of the given points.
         * 
         * @param array $points An array containing the points to be printed. Each point is of the form of [first coordinate, second coordinate].
         * 
         * @return string Returns a printable version of the given points.
         */
        static function PrintPoints($points){
            $return_string = "";
            foreach($points as $point_counter => $point){
                if($point_counter != 0){
                    $return_string .= ", ";
                }
                $return_string .= "(" . $point[0] . ", " . $point[1] . ")";
            }
            return $return_string;
        }
    
        /**
         * This method returns the printable version of the given places.
         * 
         * @param array $places The places to be printed.
         * 
         * @return string Returns a printable version of the given places.
         */
        static function CreatePrintablePlaces($places){
            $return_string = "";
            foreach($places as $place_counter => $place){
                $prefix = $place_counter !== 0?', ':'';
                $prefix = $place_counter === (count($places) - 1)?' és ':$prefix;
                $return_string = $return_string . $prefix . $place;
            }
            return $return_string;
        }

        /**
         * This method returns the printable version of the given graph.
         * 
         * The simple and tree graphs will be represented by a number sequence.
         * The paired graph will be represented by 2 number sequences.
         * The directed graph will be represented as the relations (an array of ordered pairs).
         * 
         * @param array $degrees The degrees of the graph. This is either an array of numbers, or an array of 2 arrays (containing numbers).
         * @param string $type The type of the graph. The default is "simple".
         * 
         * @return string Returns a printable version of the graph.
         */
        static function CreatePrintableGraph($degrees, $type = "simple"){
            $return_string = "[";
            
            if($type === "simple" || $type === "tree"){
                foreach($degrees as $degree_counter => $degree){
                    $prefix = $degree_counter !== 0?', ':'';
                    $return_string = $return_string . $prefix . $degree;
                }
            }else if($type === "paired"){
                $first_class = $degrees[0];
                $second_class = $degrees[1];
                
                foreach($first_class as $degree_counter => $degree){
                    $prefix = $degree_counter !== 0?', ':'';
                    $return_string = $return_string . $prefix . $degree;
                }
                $return_string .= "] és [";
                foreach($second_class as $degree_counter => $degree){
                    $prefix = $degree_counter !== 0?', ':'';
                    $return_string = $return_string . $prefix . $degree;
                }
            }else if($type === "directed"){
                $first_class = $degrees[0];
                $second_class = $degrees[1];
                
                foreach($first_class as $degree_counter => $degree){
                    $prefix = $degree_counter !== 0?', ':'';
                    $return_string = $return_string . $prefix . "(" . $degree . ", " . $second_class[$degree_counter] . ")";
                }
            }

            return $return_string . "]";
        }

        /**
         * This method creates the printable version of the given set.
         * 
         * @param string $set_name The name of the set.
         * @param array $set_elements An array containing the elements of a set.
         * @param bool $with_name This parameter determines whether the returned string should also contain the name of the set, on not. The default value is true.
         * 
         * @return string Returns the printable version of the set.
         */
        static function CreatePrintableSet($set_name, $set_elements, $with_name = true){
            $text = "";
            if($with_name){
                $text = $set_name . " = {";
            }else{
                $text = "{";
            }


            foreach($set_elements as $element_counter => $element){
                if($element_counter !== 0){
                    $text = $text . ", ";
                }
                $text = $text . $element;
            }
            $text = $text . "}";
            return $text;
        }

        /**
         * This method creates the printable version of the given relation.
         * 
         * @param string  $relation_name The name of the relation.
         * @param array   $relation_elements An array containing the ordered pairs of the relation in the form of [first element, second element].
         * @param boolean $with_name This parameter determines whether the returned string should also contain the name of the relation, on not. The default value is true.
         * 
         * @return string Returns the printable version of the relation.
         */
        static function CreatePrintableRelation($relation_name, $relation_elements, $with_name = true){
            $text = "";
            if($with_name){
                $text = $relation_name . " = {";
            }else{
                $text = "{";
            }
            
            foreach($relation_elements as $element_counter => $element){
                if($element_counter !== 0){
                    $text = $text . ", ";
                }
                $text = $text . "(" . $element[0] . ", " . $element[1] . ")";
            }
            $text = $text . "}";
            return $text;
        }

        /**
         * This method creates the printable version of the complex number given by its algebraic form.
         * 
         * @param string  $complex_number_name The name of the complex number.
         * @param array   $complex_number An array containing the real and imaginary parts of the complex number.
         * @param boolean $with_name This parameter determines whether the returned string should also contain the name of the complex number, on not. The default value is true.
         * 
         * @return string Returns the printable version of the complex number.
         */
        static function CreatePrintableComplexNumberAlgebraic($complex_number_name, $complex_number, $with_name = true){
            $text = "";
            if(count($complex_number) === 2 ){
                if($complex_number_name){
                    $text = $complex_number_name . " = ";
                }

                $text = $text . $complex_number[0] . PrintServices::PlusMinus($complex_number[1]) . abs($complex_number[1]) . "*i";
            }

            return $text;
        }

        /**
         * This method creates the printable version of the complex number given by its trigonometric form.
         * 
         * @param string  $complex_number_name The name of the complex number.
         * @param array   $complex_number An array containing the length and argument of the complex number.
         * @param boolean $pi_form This parameter determines whether the string should contain pi in the cosinus and sinus parts.
         * @param boolean $with_name This parameter determines whether the returned string should also contain the name of the complex number, on not. The default value is true.
         * @param boolean $with_degree This parameter determines whether the string should contain ° in the cosinus and sinus parts.
         * 
         * @return string Returns the printable version of the complex number.
         */
        static function CreatePrintableComplexNumberTrigonometric($complex_number_name, $complex_number, $pi_form = true, $with_name = true, $with_degree = false){
            $text = "";
            
            if(count($complex_number) === 2 ){
                if($complex_number_name){
                    $text = $complex_number_name . " = ";
                }

                if($pi_form){
                    $text = $text . $complex_number[0] . " * (cos(" . $complex_number[1] . "\u{03C0}) + i*sin(" . $complex_number[1] . "\u{03C0}))";
                }elseif($with_degree){
                    $text = $text . $complex_number[0] . " * (cos(" . $complex_number[1] . "\u{00B0}) + i*sin(" . $complex_number[1] . "\u{00B0}))";
                }else{
                    $text = $text . $complex_number[0] . " * (cos(" . $complex_number[1] . ") + i*sin(" . $complex_number[1] . "))";
                }
            }

            return $text;
        }

        /**
         * This method creates the printable version of a prime factorization.
         * 
         * @param array $relation An array containing the prime factorization as ordered pairs in the form of [base, power].
         * 
         * @return string Returns the printable version of the complex number.
         */
        static function CreatePrintablePrimeFactorization($relation){
            $text = "";
            foreach($relation as $pair_counter => $pair){
                if($pair_counter !== 0){
                    $text = $text . " * ";
                }
                $text = $text . $pair[0] . "<sup>" .  $pair[1] . "</sup>";
            }
            return $text;
        }

        /**
         * This method creates a congruence and an equivalent form.
         * 
         * @param string $variable_name The name of the variable.
         * @param string $final_b The right side of the congruence.
         * @param string $final_modulo The modulo of the congruence.
         * 
         * @return string Returns the printable version of the complex number.
         */
        static function CreatePrintableModuloEquivalence($variable_name, $final_b, $final_modulo){
            return "$variable_name \u{2261} " . $final_b . " (mod " . $final_modulo . ") \u{2194} " 
                                . $final_modulo . "\u{2223}  $variable_name" . PrintServices::PlusMinus($final_b) . abs($final_b) . " \u{2194} "
                                . "<b>$variable_name = " . $final_b . PrintServices::PlusMinus($final_modulo) . abs($final_modulo) . "*k (k \u{2208} \u{2124})</b><br>";
        }

        /**
         * This method creates a plus-minus sign for the given value.
         * 
         * @param int $value The given value for which the method will give back the sign.
         * 
         * @return string Returns the sign for the given value.
         */
        static function PlusMinus($value){
            return $value < 0?" - ":" + ";
        }

        /**
         * This method creates the printable version of a congruence.
         * 
         * @param string $variable_name The name of the variable. The default is "x".
         * @param array $congruence The parts (left and right side, and the modulo of the congruence).
         * 
         * @return string Returns the printable version of the congruence.
         */
        static function CreatePrintableCongruence($variable_name = "x", $congruence){
            return  $congruence[0] . "*$variable_name \u{2261} " . $congruence[1] . " (mod " .  $congruence[2] . ")";
        }

        /**
         * This method creates the printable version of the steps of a linear congruence solution.
         * 
         * @param string $variable_name The name of the variable. The default is "x".
         * @param array $congruence_steps The steps for solving the the linear congruence.
         * 
         * @return string Returns the printable version of the steps of a linear congruence solution.
         */
        static function CreatePrintableCongruenceSolution($variable_name = "x", $congruence_steps){
            $task_solution = "";
            foreach($congruence_steps as $step_counter => $step){
                if($step_counter !== 0){
                    $task_solution .= " \u{2194} ";
                }
                $task_solution .= $step[0] . "*$variable_name \u{2261} " . $step[1] . " (mod " .  $step[2] . ")";
            }
            return $task_solution;
        }

        /**
         * This method creates the printable version of a polynomial coefficient.
         * 
         * @param int $coefficient The coefficient.
         * @param int $coefficient_counter The actual coefficient's index.
         * @param int $degree The degree of the original polynomial expression.
         * @param bool $zero_coefficient Whether to include the zero coefficient in the prinatble text, or not. The default is false.
         * 
         * @return string Returns the printable version of a polynomial coefficient.
         */
        static function CreatePrintablePolynomialCoefficient($coefficient, $coefficient_counter, $degree, $zero_coefficient = false){
            $text = "";
            
            if($coefficient != 0 || $zero_coefficient){
                $text = $text . $coefficient;

                if($degree > $coefficient_counter){
                    if($degree - 1 === $coefficient_counter){
                        $text = $text . "*x";
                    }else{
                        $text = $text . "*x<sup>" . $degree - $coefficient_counter . "</sup>";
                    }
                }
            }

            return $text;
        }

        /**
         * This method creates the printable version of a polynomial expression.
         * 
         * @param array $polynomial_expression The coefficients of the polynomial expression. 
         * 
         * @return string Returns the printable version of a polynomial expression.
         */
        static function CreatePrintablePolynomial($polynomial_expression){
            $task_description = "";

            $degree = count($polynomial_expression) - 1;
            foreach($polynomial_expression as $coefficient_counter => $coefficient){
                if($coefficient_counter !== 0 && $coefficient !== 0){
                    $task_description = $task_description . PrintServices::PlusMinus($coefficient);
                    $coefficient = abs($coefficient);
                }
                $task_description = $task_description . PrintServices::CreatePrintablePolynomialCoefficient($coefficient, $coefficient_counter, $degree);
            }

            return $task_description;
        }

        /**
         * This method creates the printable version of a polynomial expression by pairs.
         * 
         * @param array $pairs An array containing [coefficient, power] pairs. 
         * 
         * @return string Returns the printable version of a polynomial expression.
         */
        static function CreatePrintablePolynomialByPairs($pairs){
            $text = "";
            foreach($pairs as $coefficient_counter => $pair){
                [$coefficient, $actual_degree] = $pair;
                if($coefficient !== 0){
                    if($coefficient_counter !== 0){
                        $text = $text . PrintServices::PlusMinus($coefficient) . abs($coefficient); 
                    }else{
                        $text = $text . $coefficient; 
                    }
                    
                    if($actual_degree !== 0){
                        $text = $text . "*x";
                        if($actual_degree !== 1){
                            $text = $text . "<sup>" . $actual_degree ."</sup>";
                        }
                    }
                }
            }
            return $text;
        }

        /**
         * This method returns a printable version of a row containing a polynomial expression.
         * 
         * @param array $polynomial_expression The polynomial expression wich will be present in the row.
         * @param int $degree The degree of the previously mentioned polynomial expression.
         * @param string $open_tag The opening tag for each coefficient. The default is "<td>".
         * @param string $close_tag The closing tag for each coefficient. The default is "</td>".
         * 
         * @return string Returns the printable version of a row containing a polynomial expression.
         */
        static function CreatePrintableTableRowWithPolynomial($polynomial_expression, $degree, $open_tag = "<td>", $close_tag = "</td>"){
            $text = "";
            foreach($polynomial_expression as $coefficient_counter => $coefficient){
                if($coefficient_counter !== 0){
                    $text = $text . $open_tag . PrintServices::PlusMinus($coefficient) . $close_tag;
                    $coefficient = abs($coefficient);
                }
                $text = $text . $open_tag . PrintServices::CreatePrintablePolynomialCoefficient($coefficient, $coefficient_counter, $degree, true) . $close_tag;
            }
            return $text;
        }

        /**
         * This method creates the printable version of a points.
         * 
         * @param array $points An array containing the points to be printed. Each point is of the form of [first coordinate, second coordinate].
         * 
         * @return string Returns the printable version of the complex number.
         */
        static function CreatePrintablePoints($points){
            $text = "";
            foreach($points as $point_counter => $point){
                if($point_counter !== 0){
                    $text = $text . ", ";
                }
                $text = $text . "(" . $point[0]. ", " . $point[1] . ")";
            }
            return $text;
        }
    }

?>