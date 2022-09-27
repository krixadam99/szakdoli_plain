<?php
    /**
     * This is an abstract class, which represents a subtask.
     * 
     * Each subtask have methods to make printable form of different mathematical objects, like sets, polynomial expressions, complex numbers, congruences.
    */
    abstract class SubTask {
        /**
         * This is an abstract method which creates the given amount of subtasks for the given task - subtask index pair.
         * 
         * @param string $main_task_index The index of the main task.
         * @param string $subtask_index The index of the subtask.
         * @param string $subtask_count The number of subtasks to be created.
         */
        protected abstract function CreateSubtask($main_task_index, $subtask_index, $subtask_count);
        
        /**
         * This method creates the string format of the given set.
         * 
         * @param string $set_name The name of the set.
         * @param array $set_elements An array containing the elements of a set.
         * @param boolean $with_name This parameter determines whether the returned string should also contain the name of the set, on not. The default value is true.
         * 
         * @return string Returns the printable form of the set.
         */
        protected function CreateSetText($set_name, $set_elements, $with_name = true){
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
         * This method creates the string format of the given relation.
         * 
         * @param string $relation_name The name of the relation.
         * @param array $relation_elements An array containing the ordered pairs of the relation in the form of [first element, second element].
         * @param boolean $with_name This parameter determines whether the returned string should also contain the name of the relation, on not. The default value is true.
         * 
         * @return string Returns the printable form of the relation.
         */
        protected function CreateRelationText($relation_name, $relation_elements, $with_name = true){
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
         * This method creates the string format of the complex number given by its algebraic form.
         * 
         * @param string $complex_number_name The name of the complex number.
         * @param array $complex_number An array containing the real and imaginary parts of the complex number.
         * @param boolean $with_name This parameter determines whether the returned string should also contain the name of the complex number, on not. The default value is true.
         * 
         * @return string Returns the printable form of the complex number.
         */
        protected function CreateComplexNumberAlgebraicText($complex_number_name, $complex_number, $with_name = true){
            $text = "";
            if($complex_number_name){
                $text = $complex_number_name . " = ";
            }

            $text = $text . $complex_number[0] . $this->PlusMinus($complex_number[1]) . abs($complex_number[1]) . "*i";

            return $text;
        }

        /**
         * This method creates the string format of the complex number given by its trigonometric form.
         * 
         * @param string $complex_number_name The name of the complex number.
         * @param array $complex_number An array containing the length and argument of the complex number.
         * @param boolean $pi_form This parameter determines whether the string should contain pi in the cosinus and sinus parts.
         * @param boolean $with_name This parameter determines whether the returned string should also contain the name of the complex number, on not. The default value is true.
         * @param boolean $with_degree This parameter determines whether the string should contain ° in the cosinus and sinus parts.
         * 
         * @return string Returns the printable form of the complex number.
         */
        protected function CreateComplexNumberTrigonometricText($complex_number_name, $complex_number, $pi_form = true, $with_name = true, $with_degree = false){
            $text = "";
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

            return $text;
        }

        /**
         * This method creates a congruence and an equivalent form.
         * 
         * @param string $variable_name The name of the variable.
         * @param string $final_b The right side of the congruence.
         * @param string $final_modulo The modulo of the congruence.
         * 
         * @return string Returns the printable form of the complex number.
         */
        protected function CreateModuloEquivalence($variable_name, $final_b, $final_modulo){
            return "$variable_name \u{2261} " . $final_b . " (mod " . $final_modulo . ") \u{2194} " 
                                . $final_modulo . "\u{2223}  $variable_name" . $this->PlusMinus($final_b) . abs($final_b) . " \u{2194} "
                                . "<b>$variable_name = " . $final_b . $this->PlusMinus($final_modulo) . abs($final_modulo) . "*k (k \u{2208} \u{2124})</b><br>";
        }

        /**
         * This method creates a plus-minus sign for the given value.
         * 
         * @param int $value The given value for which the method will give back the sign.
         * 
         * @return string Returns the sign for the given value.
         */
        protected function PlusMinus($value){
            return $value < 0?" - ":" + ";
        }

        /**
         * This method creates the printable form of a congruence.
         * 
         * @param string $variable_name The name of the variable. The default is "x".
         * @param array $congruence The parts (left and right side, and the modulo of the congruence).
         * 
         * @return string Returns the printable form of the congruence.
         */
        protected function CreateCongruenceText($variable_name = "x", $congruence){
            return  $congruence[0] . "*$variable_name \u{2261} " . $congruence[1] . " (mod " .  $congruence[2] . ")";
        }

        /**
         * 
         */
        protected function CreateCongruenceSolutionText($variable_name = "x", $congruence_steps){
            $task_solution = "";
            foreach($congruence_steps as $step_counter => $step){
                $task_solution = $task_solution . "<label class=\"task_solution\">" . $step[0] . "*$variable_name \u{2261} " . $step[1] . " (mod " .  $step[2] . ")</label><br>";
            }
            return $task_solution;
        }

        /**
         * 
         */
        protected function CreatePolynomialCoefficient($coefficient, $coefficient_counter, $degree, $zero_coefficient = false){
            $text = "";
            
            if($coefficient != 0 || $zero_coefficient){
                $text = $text . $coefficient;

                if($degree > $coefficient_counter){
                    if($degree - 1 === $coefficient_counter){
                        $text = $text . "*x";
                    }else{
                        $text = $text . "*x<span class=\"exp\">" . $degree - $coefficient_counter . "</span>";
                    }
                }
            }

            return $text;
        }

        /**
         * 
         */
        protected function CreatePolynomialText($polynomial_expression){
            $task_description = "";

            $degree = count($polynomial_expression) - 1;
            foreach($polynomial_expression as $coefficient_counter => $coefficient){
                if($coefficient_counter !== 0 && $coefficient !== 0){
                    $task_description = $task_description . $this->PlusMinus($coefficient);
                    $coefficient = abs($coefficient);
                }
                $task_description = $task_description . $this->CreatePolynomialCoefficient($coefficient, $coefficient_counter, $degree);
            }

            return $task_description;
        }

        /**
         * 
         */
        protected function CreatePolynomialTextByPairs($pairs){
            $text = "";
            foreach($pairs as $coefficient_counter => $pair){
                [$coefficient, $actual_degree] = $pair;
                if($coefficient !== 0){
                    if($coefficient_counter !== 0){
                        $text = $text . $this->PlusMinus($coefficient) . abs($coefficient); 
                    }else{
                        $text = $text . $coefficient; 
                    }
                    
                    if($actual_degree !== 0){
                        $text = $text . "*x";
                        if($actual_degree !== 1){
                            $text = $text . "<span class=\"exp\">" . $actual_degree ."</span>";
                        }
                    }
                }
            }
            return $text;
        }
        

        /**
         * 
         */
        protected function CreateTableRowWithPolynomial($polynomial_expression, $degree, $open_tag, $close_tag){
            $text = "";
            foreach($polynomial_expression as $coefficient_counter => $coefficient){
                if($coefficient_counter !== 0){
                    $text = $text . $open_tag . $this->PlusMinus($coefficient) . $close_tag;
                    $coefficient = abs($coefficient);
                }
                $text = $text . $open_tag . $this->CreatePolynomialCoefficient($coefficient, $coefficient_counter, $degree, true) . $close_tag;
            }
            return $text;
        }

        /**
         * 
         */
        protected function CreatePointsText($points){
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