<?php
    /**
     * 
     */
    abstract class SubTask {
        /**
         * 
         */
        protected abstract function CreateSubtask($main_task_index, $subtask_index, $subtask_count);
        
        /**
         * 
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
         * 
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

        /**
         * This protected method append a congruence equivalence to the end of a text.
         */
        protected function CreateModuloEquivalence($variable_name, $final_b, $final_modulo){
            return "$variable_name \u{2261} " . $final_b . " (mod " . $final_modulo . ") \u{2194} " 
                                . $final_modulo . "\u{2223}  $variable_name" . $this->PlusMinus($final_b) . abs($final_b) . " \u{2194} "
                                . "<b>$variable_name = " . $final_b . $this->PlusMinus($final_modulo) . abs($final_modulo) . "*k (k \u{2208} \u{2124})</b><br>";
        }

        /**
         * This protected method returns a plus, or minus based on the argument's sign.
         */
        protected function PlusMinus($value){
            return $value < 0?" - ":" + ";
        }

        /**
         * 
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
    }


?>