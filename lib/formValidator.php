<?php
    /**
     * This is an abstract class, which represents a form.
     * 
     * Each form can have correct and incorrect parameters.
     * Correct parameters are those, which satisfy the predetermined conditions (e.g., correct form, length, complexity, characters etc.).
     * Inocrrect parameters are those, which don't satisfy the predetermined conditions.
     * Apart from the setter and getter methods, the class contains a user form validator abstract method, which is responsible for validating the user's form according to a set of rules. 
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
         *
         * This abstract method is responsible for validating a user's form.
         *  
         * @return void
        */
        public abstract function ValidateUser();
    }

?>