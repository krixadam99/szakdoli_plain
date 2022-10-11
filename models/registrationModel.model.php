<?php
    /**
     * This is a model class which is responsible for adding a new user to the users table. Additionally it should add them to the user_groups table as well.
     * 
     * This model extends the MainModel class.
    */
    class RegistrationModel extends MainModel{
        /**
         * This public method is responsible for adding the new user to the users table and to the user_groups table.
         * 
         * New users will not be administrators.
         * Each user's status is pending in the beginning.
         * If the selected group is the "-", then the selected group will be 0.
         * 
         * @param string $neptun_code This is the neptun code of the user. This will be used in both the users and user_groups tables.
         * @param string $user_password This is the user' password. This will be hashed. This will be used in the users table.
         * @param string $user_password_again This is the user' repeated password. This will not be used.
         * @param string $user_email This is the user' email address. This will be used in the users table.
         * @param string $subject_name This is the user' selected subject's name. This can be "i", or "ii". This will be used in the user_groups table.
         * @param string $user_status This is the user' selected user status. This can be "Demonstrátor", or "Diák". This will be used in the user_groups table.
         * @param string $subject_group This is the user' selected subject group. This can be either a group's number which is in the selected subject and has an assigned teacher, the "-" sign, or a number between 1 and 30 (inclusively). This will be used in the user_groups table.
         * 
         * @return void
         */
        public function Register($neptun_code = "", $user_password = "", $user_password_again = "", $user_email = "", $subject_name = "", $user_status = "", $subject_group = "") {  
            $neptun_code = strtoupper($neptun_code);       
            $is_admin = 0;
            $query = "INSERT INTO users VALUES(\"".$neptun_code."\", \"".$user_email."\", \"".password_hash($user_password,PASSWORD_BCRYPT)."\", \"$is_admin\")";
            $this->database->UpdateDatabase($query);

            $pending_status = 1;
            if($user_status === "Demonstrátor"){
                $user_status = 1;
            }else{
                $user_status = 0;
            }

            if($subject_group === "-"){
                $subject_group = 0;
            }

            $query = "INSERT INTO user_groups VALUES(\"".$neptun_code."\", \"$user_status\", \"$subject_group\", \"$subject_name\", \"$pending_status\")";
            $this->database->UpdateDatabase($query);
        }
    }

?>