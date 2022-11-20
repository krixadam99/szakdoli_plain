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
         */
        protected function ValidateInputs($validation_array){            
            $input_counter = 1;            
            foreach ($validation_array as $key_name => $real_validation_array) {
                $key_name_array = explode(":", $key_name);
                $key = $key_name_array[0];
                $attribute_name = $key_name_array[1]??"szöveg";

                foreach($real_validation_array as $input => $validation_rules){
                    $was_valid_before = true;
                    $was_valid = true;
                    // The name attribute was overwritten
                    if((is_string($input) || is_numeric($input)) && $input !== "INVALID NAME ATTRIBUTE"){
                        // Here comes the validation rules for the attribute
                        foreach($validation_rules as $attribute => $condition){
                            if($was_valid_before){
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
                                                    $this->incorrect_parameters[$key] = "A(z) $attribute_name túl rövid!";
                                                    $was_valid = false;
                                                }
                                            };break;
                                            case "<":{
                                                if($left_side >= $right_side){
                                                    $this->incorrect_parameters[$key] = "A(z) $attribute_name túl hosszú!";
                                                    $was_valid = false;
                                                }
                                            };break;
                                            case ">=":{
                                                if($left_side < $right_side){
                                                    $this->incorrect_parameters[$key] = "A(z) $attribute_name túl rövid!";
                                                    $was_valid = false;
                                                }
                                            };break;
                                            case "<=":{
                                                if($left_side > $right_side){
                                                    $this->incorrect_parameters[$key] = "A(z) $attribute_name túl hosszú!";
                                                    $was_valid = false;
                                                }
                                            };break;
                                            case "==":{
                                                if($left_side != $right_side){
                                                    $this->incorrect_parameters[$key] = "A(z) $attribute_name nem megfelelő hosszú ($right_side hosszú kell, hogy legyen)!";
                                                    $was_valid = false;
                                                }
                                            };break;
                                            case "!=":{
                                                if($left_side == $right_side){
                                                    $this->incorrect_parameters[$key] = "A(z) $attribute_name nem lehet $right_side hosszú!";
                                                    $was_valid = false;
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
                                                $this->incorrect_parameters[$key] = "A(z) $attribute_name nem lehet a helyfoglaló!";
                                                $was_valid = false;
                                            }
                                        }elseif(is_array($place_holder)){
                                            if(in_array($left_side, $place_holder)){
                                                $this->incorrect_parameters[$key] = "A(z) $attribute_name nem lehet a helyfoglaló, se az üres sztring!";
                                                $was_valid = false;
                                            }
                                        }
                                    };break;
                                    case "in_array":{
                                        $left_side = $input;
                                        $array = $condition;
            
                                        if(is_array($array)){
                                            if(!in_array($left_side, $array)){
                                                $this->incorrect_parameters[$key] = "Nem található a megadott $attribute_name!";
                                                $was_valid = false;
                                            }
                                        }
                                    };break;
                                    case "already_exists":{
                                        $left_side = $input;
                                        $array = $condition;
            
                                        if(is_array($array)){
                                            if(in_array($left_side, $array)){
                                                $this->incorrect_parameters[$key] = "Már létezik a(z) $attribute_name!";
                                                $was_valid = false;
                                            }
                                        }
                                    };break;
                                    case "filter_var": {
                                        $left_side = $input;
            
                                        if(!filter_var($left_side, $condition)){
                                            $this->incorrect_parameters[$key] = "A(z) $attribute_name nem email formátumú!";
                                            $was_valid = false;
                                        }
                                    };break;
                                    case "preg_match": {
                                        $left_side = $input;
                                        $array = $condition;
                                        $all_true = true;
                                        foreach($array as $reg_exp){
                                            $all_true = $all_true && preg_match($reg_exp, $left_side);
                                        }
    
                                        if(!$all_true){
                                            $this->incorrect_parameters[$key] = "A(z) $attribute_name nem megfelelő formátumú!"; 
                                            $was_valid = false;
                                        }
                                    };break;
                                    case "is_same": {
                                        $left_side = $input;
    
                                        if($left_side !== $condition){
                                            $this->incorrect_parameters[$key] = "A(z) $attribute_name nem azonos a(z) \"$condition\" szöveggel!"; 
                                            $was_valid = false;
                                        }
                                    };break;
                                    case "is_same_password": {
                                        $left_side = $input;

                                        if(!password_verify($left_side, $condition)){
                                            $this->incorrect_parameters[$key] = "A jelszók nem egyeznek!"; 
                                            $was_valid = false;
                                        }
                                    };break;
                                }

                                if(!$was_valid){
                                    $was_valid_before = false;
                                }
                            }
                        }
                        if($was_valid){
                            $this->correct_parameters[$key] = $input; 
                        }
                    }else{
                        $this->incorrect_parameters[$key] = "Át lett írva a name attribútum!";
                        $was_valid_before = false;
                    }
                }
            }
        }
    }

?>