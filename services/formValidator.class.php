<?php

    abstract class FormValidator {
        private $error_params = array();
        private $valid_params = array();

        /**
         *
         * This function is responsible for giving back the error parameters
         *  
         * @return array
        */
        public function GetErrorParameters() : array { return $this->error_params; }

        /**
         *
         * This function is responsible for pushing a new error parameter to the back of the array holding the error parameters
         * @param string $value The value we wish to push to the back of the array holding the incorrect values
         * @return array
        */
        public function SetErrorParameters($value) { array_push( $this->error_params,$value); }
        
        /**
         *
         * This function is responsible for giving back the valid parameters
         *  
         * @return array
        */
        public function GetValidParameters() : array { return $this->valid_params; }

        /**
         *
         * This function is responsible for setting the value of the valid parameters' dictionary by the given key
         *  
         * @param string $key The key which we want to assign a new value to in the valid parameters' dictionary
         * @param string $value The value we want to assign to the key in the valid parameters' dictionary
         * @return array
        */
        public function SetValidParameters($key, $value) { $this->valid_params[$key] = $value; }

        /**
         *
         * This function is responsible for validating a user's form
         *  
         * @return array
        */
        public abstract function ValidateUser();
    }

?>