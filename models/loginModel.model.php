<?php

    class LoginModel extends MainModel{
        
        
        /**
         * 
         */
        public function UpdatePassword($neptun_code = "", $new_password = "") {  
            $neptun_code = strtoupper($neptun_code); 
            $hashed_password = password_hash($neptun_code, PASSWORD_BCRYPT);
            
            $query = "UPDATE users SET user_password = \"$hashed_password\" WHERE neptun_code = \"$neptun_code\"";
            $this->database->UpdateDatabase($query);
        }

        /**
         * 
         */
        public function GetEmailAddressOfUser($neptun_code = "") {  
            $neptun_code = strtoupper($neptun_code); 
            $query = "SELECT email_address FROM users WHERE neptun_code = \"$neptun_code\"";
            return $this->database->LoadDataFromDatabase($query)[0]??["email_address" => ""];
        }
    }

?>