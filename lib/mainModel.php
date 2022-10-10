<?php

    class MainModel {        
        protected $database;
        
        public function __construct(){
            $this->database = new DatabaseHandler();
        }

        public function GetDataFromDatabase($query, $data_type = MYSQLI_ASSOC){
            return $this->database->LoadDataFromDatabase($query, $data_type);
        }

        public function UpdataDatabase($query){
            return $this->database->UpdateDatabase($query);
        }

        public function GetUserData($neptun_code){
            $neptun_code = strtoupper($neptun_code);
            $query = "";
            if($neptun_code == "ADMIN"){
                $query = "SELECT * FROM users WHERE users.neptun_code = \"".$neptun_code."\"";
            }else{
                $query = "SELECT * FROM users, user_groups WHERE users.neptun_code = user_groups.neptun_code AND users.neptun_code = \"".$neptun_code."\"";
            }
            return $this->database->LoadDataFromDatabase($query);
        }

        public function GetPracticeResults($neptun_code){
            $neptun_code = strtoupper($neptun_code);
            $query = "SELECT * FROM practice_task_points WHERE neptun_code = \"$neptun_code\"";
            return $this->database->LoadDataFromDatabase($query);
        }

        public function UpdatePendingData($query_array) : void {
            $query = "BEGIN; ";
            foreach($query_array as $index => $record){
                $neptun_code = $record["neptun_code"];
                
                if($record["is_teacher"] === "demonstrátor"){
                    $user_status = 1;
                }else{
                    $user_status = 0;
                }
                
                $subject_group = $record["subject_group"];
                $subject_name = $record["subject_name"];
                $pending_status = $record["pending_status"];
                $query = $query."UPDATE user_groups SET pending_status = \"$pending_status\" WHERE neptun_code = \"$neptun_code\" AND subject_name = \"$subject_name\" AND subject_group = \"$subject_group\" AND user_status = \"$user_status\"; "; 
            
                if($pending_status == "0"){
                    if($subject_name == "i"){
                        $query = $query."INSERT INTO results(neptun_code, subject_name, group_number) VALUES(\"i\", \"$neptun_code\", $subject_group) ON DUPLICATE KEY UPDATE neptun_code = \"$neptun_code\",  group_number = $subject_group; ";
                    }else if($subject_name == "ii"){
                        $query = $query."INSERT INTO results(neptun_code, subject_name, group_number) VALUES(\"ii\", \"$neptun_code\", $subject_group) ON DUPLICATE KEY UPDATE neptun_code = \"$neptun_code\",  group_number = $subject_group; ";
                    }
                    $query = $query."INSERT INTO practice_task_points(neptun_code, subject_name) VALUES(\"$neptun_code\", \"$subject_name\") ON DUPLICATE KEY UPDATE neptun_code = \"$neptun_code\",  subject_name = \"$subject_name\"; ";
                }
            }
            $query = $query."COMMIT;";
            
            $this->database->UpdateDatabase($query, true);
        }

        public function GetStudents($subject_name, $subject_group){
            $query = "SELECT * FROM user_groups WHERE neptun_code != \"admin\" AND is_teacher = 0 AND subject_name = \"$subject_name\" AND subject_group = \"$subject_group\"";
            return $this->database->LoadDataFromDatabase($query);
        }

        public function GetPendingTeachers(){
            $query = "SELECT neptun_code, subject_group, subject_name FROM user_groups WHERE neptun_code != \"admin\" AND is_teacher = 1 AND pending_status = \"1\"";
            return $this->database->LoadDataFromDatabase($query);
        }
    }

?>