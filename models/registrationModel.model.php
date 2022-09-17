<?php

    class RegistrationModel extends MainModel{
        public function __construct($database = ""){
            parent::__construct($database);
        }

        public function Register($neptun_code = "", $user_password = "", $user_password_again = "", $user_email = "", $subject_name = "", $user_status = "", $subject_group = "") {  
            $neptun_code = strtoupper($neptun_code);       
            $is_admin = 0;
            $query = "INSERT INTO users VALUES(\"".$neptun_code."\", \"".$user_email."\", \"".password_hash($user_password,PASSWORD_BCRYPT)."\", \"$is_admin\")";
            $this->database->UpdateDatabase($query);

            $pending_status = 1;
            if($user_status == "Demonstrátor"){
                $user_status = "teacher";
            }else{
                $user_status = "student";
                if($subject_name != "i" && $subject_name != "ii"){
                    $subject_name = "dimmoa";
                    $pending_status = 0;
                }
            }

            if($subject_group == "-"){
                $subject_group = 0;
            }

            $query = "INSERT INTO status_pending VALUES(\"".$neptun_code."\", \"$user_status\", \"$subject_group\", \"$subject_name\", \"$pending_status\")";
            $this->database->UpdateDatabase($query);
        }
    }

?>