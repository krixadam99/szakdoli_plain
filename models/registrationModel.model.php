<?php
    /**
     * This is a model class which is responsible for adding a new user to the users table. Additionally it should add them to the user_status table as well.
     * 
     * This model extends the AuthenticationModel class.
    */
    class RegistrationModel extends AuthenticationModel{
        /**
         * 
         * The contructor of the RegistrationModel class.
         * 
         * It will call the AuthenticationModel class's constructor with which it will assign default values to the inherited members.
         * 
         * @return void
         */
        public function __construct(){
            parent::__construct();
        }
        
        /**
         * This public method is responsible for adding the new user to the users table, user_status and subject_group table.
         * 
         * New users will not be administrators.
         * Each user's status is pending in the beginning.
         * If the selected group is the "-", then the subject_group_id will be 1.
         * 
         * @param string $neptun_code This is the neptun code of the user. This will be used in both the users and user_status tables. The default is "".
         * @param string $user_password This is the user' password. This will be hashed. This will be used in the users table. The default is "".
         * @param string $user_password_again This is the user' repeated password. This will not be used. The default is "".
         * @param string $user_email This is the user' email address. This will be used in the users table. The default is "".
         * @param string $subject_id This is the user' selected subject's name. This can be "i", or "ii". This will be used in the subject_group table. The default is "".
         * @param string $user_status This is the user' selected user status. This can be "Demonstrátor", or "Diák". This will be used in the user_status table. The default is "".
         * @param string $subject_group This is the user' selected subject group. This can be either a group's number which is in the selected subject and has an assigned teacher, the "-" sign, or a number between 1 and 30 (inclusively). This will be used in the subject_group table. The default is "".
         * 
         * @return bool Returns whether the registration was succesful, or not.
         */
        public function Register($neptun_code = "", $user_password = "", $user_password_again = "", $user_email = "", $subject_id = "", $user_status = "", $subject_group = "") {  
            $neptun_code = strtoupper($neptun_code);       
            $is_admin = 0;
            $query = "INSERT INTO users VALUES(\"".$neptun_code."\", \"".$user_email."\", \"".password_hash($user_password,PASSWORD_BCRYPT)."\", \"$is_admin\")";
            $this->database->UpdateDatabase($query);

            $pending_status = "PENDING";
            if($user_status === "Demonstrátor"){
                $user_status = 1;
            }else{
                $user_status = 0;
            }

            if($subject_group !== "0"){
                $query = "INSERT INTO subject_group(subject_id, group_number) VALUES(\"$subject_id\", \"$subject_group\") ON DUPLICATE KEY UPDATE subject_id = \"$subject_id\"; ";
                $this->database->UpdateDatabase($query);
    
                $query = "INSERT INTO user_status(subject_group_id, neptun_code, is_teacher, application_request_status) VALUES((SELECT subject_group_id FROM subject_group WHERE group_number = \"$subject_group\" AND subject_id = \"$subject_id\")
                , \"".$neptun_code."\", \"$user_status\", \"$pending_status\")";
            }else{
                $query = "INSERT INTO user_status(subject_group_id, neptun_code, is_teacher, application_request_status) VALUES((SELECT subject_group_id FROM subject_group WHERE group_number = \"$subject_group\")
                , \"".$neptun_code."\", \"$user_status\", \"$pending_status\")";
            }
            
            return $this->database->UpdateDatabase($query);
        }
    }

?>