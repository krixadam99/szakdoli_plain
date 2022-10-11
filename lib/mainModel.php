<?php
    /**
     * This is the model which will be extended by the controllers belonging to the main part (i.e., not login, registration, index) throughout the project.
     * 
     * Every controller belonging to the main part (i.e., not login, registration, index) will instantiate its own model class. 
     * Each of these class will extend this model, so every one of them will inherit the public and protected methods implemented here.
     * It is possible, that some of them will not have further methods.
     */
    class MainModel {        
        protected $database;
        
        /**
         * The constructor method of the MainModel class.
         * 
         * @return void 
         */
        public function __construct(){
            $this->database = new DatabaseHandler();
        }

        /**
         * This public method fetches data from the database via the given query.
         * 
         * @param string $query The query with which data will be fetched from the database.
         * @param int $data_type The form of the returned array (either associative or indexed). The default is MYSQLI_ASSOC.
         * 
         * @return array Returns an array containing the data fetched from the database.
         */
        public function GetDataFromDatabase($query, $data_type = MYSQLI_ASSOC){
            return $this->database->LoadDataFromDatabase($query, $data_type);
        }

        /**
         * This public method updates the database by the given query.
         * 
         * @param string $query The query with which data will be updated in the database.
         * 
         * @return bool Returns whether updating the database was successful, or not.
         */
        public function UpdataDatabase($query){
            return $this->database->UpdateDatabase($query);
        }

        /**
         * This public method fetches all of the rows from the users table, or users and user_groups joined tables that belongs to the user with the given neptun code.
         * 
         * The administrator will only be present in the users table, so for them data should be fetched from the users table.
         * Every other user's data will be fetched from the users and user_groups joined table (they will be joined on the neptun_code key).
         * 
         * @param string $neptun_code The neptun code of the user.
         * 
         * @return array Returns an array containing the fetched rows.
         */
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

        /**
         * This public method returns the practice task results from the practice_task_points table for the user given by their neptun code.
         * 
         * @param string $neptun_code The neptun code of the user.
         * 
         * @return array Returns an array containing the practice task points.
         */
        public function GetPracticeResults($neptun_code){
            $neptun_code = strtoupper($neptun_code);
            $query = "SELECT * FROM practice_task_points WHERE neptun_code = \"$neptun_code\"";
            return $this->database->LoadDataFromDatabase($query);
        }

        /**
         * This public method updates the user_groups table via queries formed by query data given in an array. Additionally, if the user is a student, and their pending status becomes 0 (will be approved), then they will be added to the results and practice_task_points tables as well.
         * 
         * @param array $query_array An array containing the record of each user who will be updated. A record contains information about the neptun code, user status, subject group, subject name and pending status (basically the attributes of the user_groups table).
         * 
         * @return void
         */
        public function UpdatePendingData($query_array) : void {
            $query = "BEGIN; ";
            foreach($query_array as $index => $record){
                $neptun_code = $record["neptun_code"];
                
                if($record["user_status"] === "teacher"){
                    $user_status = 1;
                }else{
                    $user_status = 0;
                }
                
                $subject_group = $record["subject_group"];
                $subject_name = $record["subject_name"];
                $pending_status = $record["pending_status"];
                $query = $query."UPDATE user_groups SET pending_status = \"$pending_status\" WHERE neptun_code = \"$neptun_code\" AND subject_name = \"$subject_name\" AND subject_group = \"$subject_group\" AND is_teacher = \"$user_status\"; "; 

                if($pending_status === "0" && $user_status !== 1){
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

        /**
         * This public method returns all of the students for the given subject name - subject group pair.
         * 
         * @param string $subject_name The subject's name.
         * @param int $subject_group The group's number.
         * 
         * @return array Returns an array containing the students belonging to the subject name - subject group pair.
         */
        public function GetStudents($subject_name, $subject_group){
            $query = "SELECT * FROM user_groups WHERE neptun_code != \"admin\" AND is_teacher = 0 AND subject_name = \"$subject_name\" AND subject_group = \"$subject_group\"";
            return $this->database->LoadDataFromDatabase($query);
        }

        /**
         * This public method returns all of the pending teachers.
         * 
         * @return array Returns an array containing all of the pending teachers.
         */
        public function GetPendingTeachers(){
            $query = "SELECT neptun_code, subject_group, subject_name FROM user_groups WHERE neptun_code != \"admin\" AND is_teacher = 1 AND pending_status = \"1\"";
            return $this->database->LoadDataFromDatabase($query);
        }
    }

?>