<?php
    /**
     * This is an abstract class, which represents a form.
     * 
     * Each form can have correct and incorrect parameters.
     * Correct parameters are those, which satisfy the predetermined conditions (e.g., correct form, length, complexity, characters etc.).
     * Inocrrect parameters are those, which don't satisfy the predetermined conditions.
     * Apart from the setter and getter methods, the class contains a prtoected ValidateInputs method which will validate the given inputs by the determined sets of rules. 
    */
    abstract class FormValidator {
        protected $incorrect_parameters = array();
        protected $correct_parameters = array();

        /**
         *
         * This method gives back the incorrect parameters.
         *  
         * @return array An indexed array containing the incorrect parameters.
        */
        public function GetIncorrectParameters() : array { return $this->incorrect_parameters; }

        /**
         *
         * This method pushes a new incorrect parameter to the back of the array holding the incorrect parameters.
         * @param string $value The value we wish to push to the back of the array holding the incorrect values.
         * @return void
        */
        public function SetIncorrectParameter($value) { array_push( $this->incorrect_parameters,$value); }
        
        /**
         *
         * This method gives back the valid parameters.
         *  
         * @return array An associative array containing the incorrect parameters.
        */
        public function GetCorrectParameters() : array { return $this->correct_parameters; }

        /**
         *
         * This method sets a value of the correct parameters' dictionary by the given key.
         *  
         * @param string $key The key which we want to assign a new value to in the correct parameters' dictionary.
         * @param string $value The value we want to assign to the key in the correct parameters' dictionary.
         * @return void
        */
        public function SetCorrectParameter($key, $value) { $this->correct_parameters[$key] = $value; }

        /**
         * This method validates user inputs based on validation rules.
         * 
         * @param array $validation_array This is an array where the keys are the given inputs. The values are associative arrays, containing the attribute of the given answer (the key), and the rules for this attribute (the value).
         * 
         * @return array Returns an array containing the error messages.
         */
        protected function ValidateInputs($validation_array){            
            $input_counter = 1;
            $incorrect_parameters = [];
            foreach($validation_array as $input => $validation_rules){
                if(is_string($input)){
                    foreach($validation_rules as $attribute => $condition){
                        switch($attribute){
                            case "length":{
                                $left_side = strlen($input);
                                $relation = $condition[0]??">";
                                $right_side = $condition[1]??0;
                                if(is_numeric($right_side)){
                                    $right_side = intval($right_side);
                                }else{
                                    $right_side = 0;
                                }
                                
                                switch($relation){
                                    case ">":{
                                        if($left_side <= $right_side){
                                            array_push($incorrect_parameters, "wrong_$input_counter" . "_too_short");
                                        }
                                    };break;
                                    case "<":{
                                        if($left_side >= $right_side){
                                            array_push($incorrect_parameters, "wrong_$input_counter" . "_too_long");
                                        }
                                    };break;
                                    case ">=":{
                                        if($left_side < $right_side){
                                            array_push($incorrect_parameters, "wrong_$input_counter" . "_too_short");
                                        }
                                    };break;
                                    case "<=":{
                                        if($left_side > $right_side){
                                            array_push($incorrect_parameters, "wrong_$input_counter" . "_too_long");
                                        }
                                    };break;
                                    case "==":{
                                        if($left_side != $right_side){
                                            array_push($incorrect_parameters, "wrong_$input_counter" . "_not_equal");
                                        }
                                    };break;
                                    case "!=":{
                                        if($left_side == $right_side){
                                            array_push($incorrect_parameters, "wrong_$input_counter" . "_equal");
                                        }
                                    };break;
                                    default:break;
                                }
                            };break;
                            case "not_placeholder":{
                                $left_side = $input;
                                $place_holder = $condition;

                                if(is_string($place_holder)){
                                    if($left_side === $place_holder){
                                        array_push($incorrect_parameters, "wrong_$input_counter" . "_not_set");
                                    }
                                }elseif(is_array($place_holder)){
                                    if(in_array($left_side, $place_holder)){
                                        array_push($incorrect_parameters, "wrong_$input_counter" . "_not_set");
                                    }
                                }
                            };break;
                            case "in_array":{
                                $left_side = $input;
                                $array = $condition;
    
                                if(is_array($array)){
                                    if(!in_array($left_side, $array)){
                                        array_push($incorrect_parameters, "wrong_$input_counter" . "_not_in_array");
                                    }
                                }
                            };break;
                        }
                    }
                }else{
                    array_push($incorrect_parameters, "wrong_$input_counter" . "_not_found");
                }
        
                $input_counter += 1;
            }

            return $incorrect_parameters;
        }
    }

?>