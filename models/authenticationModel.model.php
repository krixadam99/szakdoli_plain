<?php
    /**
     * This is a model class which is responsible for the authentication. It has basic methods like the one which fetches all of the neptun codes.
     * 
     * This model extends the MainModel class.
    */
    class AuthenticationModel extends MainModel{
        /**
         * 
         * The contructor of the AuthenticationModel class.
         * 
         * It will call the MainModel class's constructor with which it will assign default values to the inherited members.
         * 
         * @return void
         */
        public function __construct(){
            parent::__construct();
        }
        
        /**
         * This method fetches all of the neptun codes.
         * 
         * @return array Returns an array containing all of the neptun codes.
         */
        public function GetNeptunCodes() {  
            return $this->database->LoadDataFromDatabase("SELECT neptun_code FROM users");
        }

        /**
         * This method fetches all of the email addresses.
         * 
         * @return array Returns an array containing all of the email addresses.
         */
        public function GetEmailAddresses() {  
            return $this->database->LoadDataFromDatabase("SELECT email_address FROM users");
        }

        /**
         * This method fetches the email address for a user.
         * 
         * If there is no user with the given neptun code, then it returns the ["email_address" => ""] array.
         * 
         * @param string $neptun_code The user's neptun code in the users table. The default is "".
         * 
         * @return array Returns an associative array containing the ["email_address" => emailAdress] key-value pair.
         */
        public function GetEmailAddressOfUser($neptun_code = "") {  
            $neptun_code = strtoupper($neptun_code); 
            $query = "SELECT email_address FROM users WHERE neptun_code = \"$neptun_code\"";
            return $this->database->LoadDataFromDatabase($query)[0]??["email_address" => ""];
        }
    }

?>