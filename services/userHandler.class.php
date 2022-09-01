<?php
    /**
     * This is a helper class that simulates a user
     * 
     * It gets the MainModel with the database, so the actual data fetch will be executed by the MainModel
     * A user can have a neptun code, user email, subject name, user status, subject group, password and reassuring password
     * These members will be set when an instance of the class is created, but the subject name can be updated later on
     * This class checks if the user's password and the given password are the same, this is important for both the registration and login
     * It also checks if the user's given neptun code is in use or not, this will be important for the registration 
     * Furthermore, it checks if the user is the administrator
     * Finally, it checks if the user's given subject group is a valid subject group or not
     * 
     */
    class UserHandler {
        private $neptun_code;
        private $user_email;
        private $subject_name;
        private $user_status;
        private $subject_group;
        private $user_password;
        private $user_password_again;


        public function __construct($database = "szakdoli", $neptun_code = "", $user_password = "", $user_password_again = "", $user_email = "", $subject_name = "", $user_status = "", $subject_group = ""){
            $this->model = new MainModel($database);
            $this->neptun_code = $neptun_code;
            $this->user_email = $user_email;
            $this->subject_name = $subject_name;
            $this->user_status = $user_status;
            $this->subject_group = $subject_group;
            $this->user_password = $user_password;
            $this->user_password_again = $user_password_again;
        }

        public function GetNeptunCode() : string { return $this->neptun_code;}
        public function GetUserEmail() : string { return $this->user_email;}
        public function GetSubjectName() : string { return $this->subject_name;}
        public function SetSubjectName($subject_name) : void { $this->subject_name = $subject_name;}
        public function GetUserStatus() : string { return $this->user_status;}
        public function GetSubjectGroup() : string { return $this->subject_group;}
        public function GetUserPassword() : string { return $this->user_password;}
        public function GetUserPasswordAgain() : string { return $this->user_password_again;}

        public function IsSamePassword() : bool {
            $neptun_code = strtoupper($this->neptun_code);
            $query = "SELECT * FROM users WHERE users.neptun_code = \"".$neptun_code."\"";
            $users = $this->model->GetDataFromDatabase($query);

            if(count($users) != 0){ //There is at least one record in the database which has the $neptun_code as a value in the neptun_code column
                return password_verify($this->user_password, $users[0]["user_password"]); //Checking if the hashed password stored under the user's given name is the same as the given password
            }else{ //No record was found in the database
                return false;
            }
        }

        public function IsUserNameUsed() : bool {
            $neptun_code = strtoupper($this->neptun_code);
            $query = "SELECT * FROM users WHERE users.neptun_code =  \"".$neptun_code."\"";
            $users = $this->model->GetDataFromDatabase($query);
            if(count($users) != 0){
                return true;
            }else{
                return false;
            }
        }

        public function IsAdministrator() : bool {
            $neptun_code = strtoupper($this->neptun_code);
            $query = "SELECT * FROM users WHERE users.neptun_code = \"".$neptun_code."\"";
            $users = $this->model->GetDataFromDatabase($query);
            
            if(count($users) != 0){
                return $users["is_administrator"];
            }else{
                return false;
            }
        }

        public function IsGroupNumberCorrect() : bool {
            $query = "SELECT DISTINCT subject_group FROM status_pending WHERE subject_name = \"".$this->subject_name."\" AND user_status = \"teacher\" AND pending_status  = \"0\"";
            $groups = $this->model->GetDataFromDatabase($query);
                
            $count_group = 0;
            $in_array = false;
            while($count_group < count($groups) && !$in_array){
                $in_array = $this->subject_group == array_values($groups[$count_group])[0];
                ++$count_group;
            }

            if($in_array || $this->subject_group == "-"){
                return true;
            }else{
                return false;
            }
        }
    } 

?>