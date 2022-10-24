<?php
    /**
     * This is a helper class that simulates a user.
     * 
     * It gets the MainModel with the database, so the actual data fetch will be executed by the MainModel.
     * A user can have a neptun code, user email, subject name, user status, subject group, password and reassuring password.
     * These members will be set when an instance of the class is created, but the subject name can be updated later on.
     * This class checks if the user's password and the given password are the same, this is important for both the registration and login.
     * It also checks if the user's given neptun code is in use or not, this will be important for the registration.
     * Furthermore, it checks if the user is the administrator.
     * Finally, it checks if the user's given subject group is a valid subject group or not.
     * 
     */
    class UserHandler {
        private $neptun_code;
        private $user_email;
        private $subject_id;
        private $user_status;
        private $subject_group;
        private $user_password;
        private $user_password_again;
        private $database_handler;

        /**
         * 
         * The contructor of the UserHandler class.
         * 
         * @param string $database The name of the database from which the class will request data. 
         * @param string $neptun_code The neptun code of the user.
         * @param string $user_password The password the user.
         * @param string $user_password_again The reassuring password of the user.
         * @param string $user_email The email address of the user.
         * @param string $subject_id The subject name which the user applied to.
         * @param string $user_status The status of the user for the applied subject.
         * @param string $subject_group The group which the user applied to in the subject.
         * 
         * @return void
        */
        public function __construct($neptun_code = "", $user_password = "", $user_password_again = "", $user_email = "", $subject_id = "", $user_status = "", $subject_group = ""){
            $this->database_handler = new DatabaseHandler();
            $this->neptun_code = $neptun_code;
            $this->user_email = $user_email;
            $this->subject_id = $subject_id;
            $this->user_status = $user_status;
            $this->subject_group = $subject_group;
            $this->user_password = $user_password;
            $this->user_password_again = $user_password_again;
        }

        /**
         * 
         * This method returns the neptun code of the user.
         * 
         * @return string The neptun code of the user.
        */
        public function GetNeptunCode() { return $this->neptun_code;}

        /**
         * 
         * This method returns the email address of the user.
         * 
         * @return string The email address of the user.
        */
        public function GetUserEmail() { return $this->user_email;}

        /**
         * 
         * This method returns the name of the subject which the user applied to.
         * 
         * @return string The name of the subject which the user applied to.
        */
        public function GetSubjectId() { return $this->subject_id;}

        /**
         * 
         * This method returns the status of the user for the applied subject.
         * 
         * @return string The status of the user for the applied subject.
        */
        public function GetUserStatus() { return $this->user_status;}

        /**
         * 
         * This method returns the subject group of the user.
         * 
         * @return string The subject group of the user.
        */
        public function GetSubjectGroup() { return $this->subject_group;}

        /**
         * 
         * This method returns the user's password.
         * 
         * @return string The password of the user.
        */
        public function GetUserPassword() { return $this->user_password;}

        /**
         * 
         * This method returns the reassuring password of the user.
         * 
         * @return string The reassuring password of the user.
        */
        public function GetUserPasswordAgain() { return $this->user_password_again;}

        /**
         * 
         */
        public function SetSubjectId($subject_id) { $this->subject_id = $subject_id;}

        /**
         * 
         * This method decides if the password belonging to the given neptun code and the given password are the same.
         * 
         * @return bool Returns if the password belonging to the given neptun code and the given password are the same.
        */
        public function IsSamePassword() {
            $neptun_code = strtoupper($this->neptun_code);
            $query = "SELECT * FROM users WHERE users.neptun_code = \"".$neptun_code."\"";
            $users = $this->database_handler->LoadDataFromDatabase($query);

            if(count($users) != 0){ //There is at least one record in the database which has the $neptun_code as a value in the neptun_code column
                return password_verify($this->user_password, $users[0]["user_password"]); //Checking if the hashed password stored under the user's given name is the same as the given password
            }else{ //No record was found in the database
                return false;
            }
        }
        
        /**
         * 
         * This method decides if the neptun code given by the user is already in use, or not.
         * 
         * @return bool Returns whether the neptun code given by the user is already in use, or not.
        */
        public function IsUserNameUsed() {
            $neptun_code = strtoupper($this->neptun_code);
            $query = "SELECT * FROM users WHERE users.neptun_code =  \"".$neptun_code."\"";
            $users = $this->database_handler->LoadDataFromDatabase($query);
            if(count($users) != 0){
                return true;
            }else{
                return false;
            }
        }

        /**
         * 
         * This method decides if the email address given by the user is already in use, or not.
         * 
         * @return bool Returns whether the email address given by the user is already in use, or not.
        */
        public function IsEmailAddressUsed() {
            $query = "SELECT * FROM users WHERE users.email_address =  \"".$this->user_email."\"";
            $users = $this->database_handler->LoadDataFromDatabase($query);
            if(count($users) != 0){
                return true;
            }else{
                return false;
            }
        }

        /**
         * 
         * This method decides whether the user is an administrator, or not.
         * 
         * @return bool Returns whether the user is an administrator, or not.
        */
        public function IsAdministrator() {
            $neptun_code = strtoupper($this->neptun_code);
            $query = "SELECT * FROM users WHERE users.neptun_code = \"".$neptun_code."\"";
            $users = $this->database_handler->LoadDataFromDatabase($query);
            
            if(count($users) != 0){
                return $users["is_administrator"];
            }else{
                return false;
            }
        }

        /**
         * 
         * This method decides whether the user as a student applied to a valid group, or not. A valid group is which is assigned to an approved teacher.
         * 
         * @return bool Returns whether the user as a student applied to a valid group.
        */
        public function IsGroupNumberCorrect() {
            $query = "SELECT DISTINCT group_number FROM user_status JOIN subject_group USING(subject_group_id) WHERE subject_id = \"".$this->subject_id."\" AND application_request_status = \"APPROVED\" AND is_teacher=\"1\"";
            $groups = $this->database_handler->LoadDataFromDatabase($query);

            $count_group = 0;
            $in_array = false;
            while($count_group < count($groups) && !$in_array){
                $in_array = $this->subject_group == array_values($groups[$count_group])[0];
                ++$count_group;
            }

            if($in_array || $this->subject_group === "-"){
                return true;
            }else{
                return false;
            }
        }
    } 

?>