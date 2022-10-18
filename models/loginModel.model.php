<?php
    /**
     * This is a model class which is responsible for updating the password of a user, and fetching their neptun code.
     * 
     * This model extends the MainModel class.
    */
    class LoginModel extends MainModel{
        /**
         * 
         * The contructor of the LoginModel class.
         * 
         * It will call the MainModel class's constructor with which it will assign default values to the inherited members.
         * 
         * @return void
         */
        public function __construct(){
            parent::__construct();
        }
        
        /**
         * This method updates the password of the user given by their neptun code.
         * 
         * @param string $neptun_code The user's neptun code in the users table. The default is "".
         * @param string $new_password The user's new password. The default is "".
         * 
         * @return bool Returns whether the update was successful, or not.
         */
        public function UpdatePassword($neptun_code = "", $new_password = "") {  
            $neptun_code = strtoupper($neptun_code); 
            $hashed_password = password_hash($new_password, PASSWORD_BCRYPT); // Hashing the new password

            $query = "UPDATE users SET user_password = \"$hashed_password\" WHERE neptun_code = \"$neptun_code\"";
            return $this->database->UpdateDatabase($query);
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