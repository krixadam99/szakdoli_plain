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
            $query = "SELECT * FROM user_groups, practice_task_points WHERE ";
            $query .= "user_groups.neptun_code = practice_task_points.neptun_code AND user_groups.subject_id = practice_task_points.subject_id AND user_groups.subject_group = practice_task_points.subject_group ";
            $query .= "AND practice_task_points.neptun_code = \"$neptun_code\" AND user_groups.application_request_status = \"APPROVED\" AND user_groups.is_teacher = \"0\"";
            return $this->database->LoadDataFromDatabase($query);
        }

        /**
         * This public method returns all of the students for the given subject name - subject group pair.
         * 
         * @param string $subject_id The subject's name.
         * @param int $subject_group The group's number.
         * 
         * @return array Returns an array containing the students belonging to the subject name - subject group pair.
         */
        public function GetStudents($subject_id, $subject_group){
            $query = "SELECT * FROM user_groups WHERE neptun_code != \"admin\" AND is_teacher = 0 AND subject_id = \"$subject_id\" AND subject_group = \"$subject_group\"";
            return $this->database->LoadDataFromDatabase($query);
        }

        /**
         * This public method returns all of the pending teachers.
         * 
         * @return array Returns an array containing all of the pending teachers.
         */
        public function GetPendingTeachers(){
            $query = "SELECT neptun_code, subject_group, subject_id FROM user_groups WHERE neptun_code != \"admin\" AND is_teacher = 1 AND application_request_status = \"PENDING\"";
            return $this->database->LoadDataFromDatabase($query);
        }

        /**
         * This public method returns the details of each task for the given subject name - subject group pair (that is, for the teacher's given group in the given subject).
         * 
         * @param string $subject_id The subject's name.
         * @param int $subject_group The group's number.
         * 
         * @return array Returns an array containing each task's details (minimum to pass, type of task, maximum points and whether the better counts, or not, if there is a correction from this type of task) belonging to the subject name - subject group pair.
         */
        public function GetExpectationRules($subject_id, $subject_group){
            $query = "SELECT * FROM expectation_rules 
            WHERE expectation_rules.subject_id = \"$subject_id\" 
            AND expectation_rules.subject_group = \"$subject_group\"";
            return $this->database->LoadDataFromDatabase($query);
        }

        /**
         * This public method returns the due dates of each task for the given subject name - subject group pair (that is, for the teacher's given group in the given subject).
         * 
         * @param string $subject_id The subject's name.
         * @param int $subject_group The group's number.
         * 
         * @return array Returns an array containing each task's due date belonging to the subject name - subject group pair.
         */
        public function GetTaskDueDate($subject_id, $subject_group){
            $query = "SELECT * FROM task_due_to_date 
            WHERE task_due_to_date.subject_id = \"$subject_id\" 
            AND task_due_to_date.subject_group = \"$subject_group\"";
            return $this->database->LoadDataFromDatabase($query);
        }

        /**
         * This public method returns the grade levels of each task for the given subject name - subject group pair (that is, for the teacher's given group in the given subject).
         * 
         * @param string $subject_id The subject's name.
         * @param int $subject_group The group's number.
         * 
         * @return array Returns an array containing the minimum point to get a certain grade for the subject name - subject group pair.
         */
        public function GetGradeLevels($subject_id, $subject_group){
            $query = "SELECT * FROM grade_table 
            WHERE grade_table.subject_id = \"$subject_id\" 
            AND grade_table.subject_group = \"$subject_group\"";
            return $this->database->LoadDataFromDatabase($query);
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
         * This public method updates the user_groups table via queries formed by query data given in an array. Additionally, if the user is a student, and their pending status becomes 0 (will be approved), then they will be added to the results and practice_task_points tables as well.
         * 
         * @param array $query_array An array containing the record of each user who will be updated. A record contains information about the neptun code, user status, subject group, subject name and pending status (basically the attributes of the user_groups table).
         * 
         * @return void
         */
        public function UpdatePendingData($query_array) {
            $query = "BEGIN; ";
            foreach($query_array as $index => $record){
                $neptun_code = $record["neptun_code"];
                
                if($record["user_status"] === "teacher"){
                    $is_teacher = 1;
                }else{
                    $is_teacher = 0;
                }
                
                $subject_group = $record["subject_group"];
                $subject_id = $record["subject_id"];
                $pending_status = $record["application_request_status"];

                if($is_teacher === 0){
                    $query .= "UPDATE user_groups SET application_request_status = \"$pending_status\" WHERE neptun_code = \"$neptun_code\" AND subject_id = \"$subject_id\" AND subject_group = \"$subject_group\" AND is_teacher = \"0\" AND application_request_status != \"WITHDRAWN\"; "; 
                }
                
                if($pending_status === "APPROVED" && $is_teacher === 0){
                    if($subject_id === "i"){
                        $query .= "UPDATE user_groups SET application_request_status = \"WITHDRAWN\" WHERE neptun_code = \"$neptun_code \" AND is_teacher = \"1\"; ";
                    }else{
                        $query .= "UPDATE user_groups SET application_request_status = \"WITHDRAWN\" WHERE neptun_code = \"$neptun_code \" AND is_teacher = \"1\" AND subject_id = \"ii\"; ";
                    }
                    
                    $query .= "UPDATE user_groups SET application_request_status = \"WITHDRAWN\" WHERE neptun_code = \"$neptun_code\" AND is_teacher = 0 AND application_request_status != \"APPROVED\"; ";
                }

                if($is_teacher === 1){
                    $query .= "UPDATE user_groups SET application_request_status = \"$pending_status\" WHERE neptun_code = \"$neptun_code\" AND subject_id = \"$subject_id\" AND subject_group = \"$subject_group\" AND is_teacher = \"1\"; "; 

                    // Whithdraw from subjects if approved
                    if($pending_status === "APPROVED"){
                        if($subject_id === "i"){
                            $query .= "UPDATE user_groups SET application_request_status = \"WITHDRAWN\" WHERE neptun_code = \"$neptun_code \" AND is_teacher = \"0\" AND subject_id = \"i\"; ";
                        }else{
                            $query .= "UPDATE user_groups SET application_request_status = \"WITHDRAWN\" WHERE neptun_code = \"$neptun_code \" AND is_teacher = \"0\"; ";
                        }
                        
                        $query .= "INSERT INTO expectation_rules(subject_group, subject_id, task_type) VALUES(\"$subject_group\", \"$subject_id\", \"practice_count\") ON DUPLICATE KEY UPDATE subject_group = \"$subject_group\";"; 
                        $query .= "INSERT INTO expectation_rules(subject_group, subject_id, task_type) VALUES(\"$subject_group\", \"$subject_id\", \"extra\") ON DUPLICATE KEY UPDATE subject_group = \"$subject_group\";"; 
                        $query .= "INSERT INTO expectation_rules(subject_group, subject_id, task_type) VALUES(\"$subject_group\", \"$subject_id\", \"middle_term_exam\") ON DUPLICATE KEY UPDATE subject_group = \"$subject_group\";"; 
                        $query .= "INSERT INTO expectation_rules(subject_group, subject_id, task_type) VALUES(\"$subject_group\", \"$subject_id\", \"final_term_exam\") ON DUPLICATE KEY UPDATE subject_group = \"$subject_group\";";
                        $query .= "INSERT INTO expectation_rules(subject_group, subject_id, task_type) VALUES(\"$subject_group\", \"$subject_id\", \"middle_term_exam_correction\") ON DUPLICATE KEY UPDATE subject_group = \"$subject_group\";"; 
                        $query .= "INSERT INTO expectation_rules(subject_group, subject_id, task_type) VALUES(\"$subject_group\", \"$subject_id\", \"final_term_exam_correction\") ON DUPLICATE KEY UPDATE subject_group = \"$subject_group\";"; 
                        $query .= "INSERT INTO expectation_rules(subject_group, subject_id, task_type) VALUES(\"$subject_group\", \"$subject_id\", \"small_tests\") ON DUPLICATE KEY UPDATE subject_group = \"$subject_group\";"; 
                        
                        $query .= "INSERT INTO task_due_to_date(subject_group, subject_id, task_type) VALUES(\"$subject_group\", \"$subject_id\", \"middle_term_exam\") ON DUPLICATE KEY UPDATE subject_group = \"$subject_group\";"; 
                        $query .= "INSERT INTO task_due_to_date(subject_group, subject_id, task_type) VALUES(\"$subject_group\", \"$subject_id\", \"final_term_exam\") ON DUPLICATE KEY UPDATE subject_group = \"$subject_group\";";
                        $query .= "INSERT INTO task_due_to_date(subject_group, subject_id, task_type) VALUES(\"$subject_group\", \"$subject_id\", \"middle_term_exam_correction\") ON DUPLICATE KEY UPDATE subject_group = \"$subject_group\";"; 
                        $query .= "INSERT INTO task_due_to_date(subject_group, subject_id, task_type) VALUES(\"$subject_group\", \"$subject_id\", \"final_term_exam_correction\") ON DUPLICATE KEY UPDATE subject_group = \"$subject_group\";";
                        $query .= "INSERT INTO task_due_to_date(subject_group, subject_id, task_type) VALUES(\"$subject_group\", \"$subject_id\", \"small_test_1\") ON DUPLICATE KEY UPDATE subject_group = \"$subject_group\";"; 
                        $query .= "INSERT INTO task_due_to_date(subject_group, subject_id, task_type) VALUES(\"$subject_group\", \"$subject_id\", \"small_test_2\") ON DUPLICATE KEY UPDATE subject_group = \"$subject_group\";"; 
                        $query .= "INSERT INTO task_due_to_date(subject_group, subject_id, task_type) VALUES(\"$subject_group\", \"$subject_id\", \"small_test_3\") ON DUPLICATE KEY UPDATE subject_group = \"$subject_group\";"; 
                        $query .= "INSERT INTO task_due_to_date(subject_group, subject_id, task_type) VALUES(\"$subject_group\", \"$subject_id\", \"small_test_4\") ON DUPLICATE KEY UPDATE subject_group = \"$subject_group\";"; 
                        $query .= "INSERT INTO task_due_to_date(subject_group, subject_id, task_type) VALUES(\"$subject_group\", \"$subject_id\", \"small_test_5\") ON DUPLICATE KEY UPDATE subject_group = \"$subject_group\";"; 
                        $query .= "INSERT INTO task_due_to_date(subject_group, subject_id, task_type) VALUES(\"$subject_group\", \"$subject_id\", \"small_test_6\") ON DUPLICATE KEY UPDATE subject_group = \"$subject_group\";"; 
                        $query .= "INSERT INTO task_due_to_date(subject_group, subject_id, task_type) VALUES(\"$subject_group\", \"$subject_id\", \"small_test_7\") ON DUPLICATE KEY UPDATE subject_group = \"$subject_group\";"; 
                        $query .= "INSERT INTO task_due_to_date(subject_group, subject_id, task_type) VALUES(\"$subject_group\", \"$subject_id\", \"small_test_8\") ON DUPLICATE KEY UPDATE subject_group = \"$subject_group\";"; 
                        $query .= "INSERT INTO task_due_to_date(subject_group, subject_id, task_type) VALUES(\"$subject_group\", \"$subject_id\", \"small_test_9\") ON DUPLICATE KEY UPDATE subject_group = \"$subject_group\";"; 
                        $query .= "INSERT INTO task_due_to_date(subject_group, subject_id, task_type) VALUES(\"$subject_group\", \"$subject_id\", \"small_test_10\") ON DUPLICATE KEY UPDATE subject_group = \"$subject_group\";";
                        $query .= "INSERT INTO task_due_to_date(subject_group, subject_id, task_type) VALUES(\"$subject_group\", \"$subject_id\", \"practice_task_1\") ON DUPLICATE KEY UPDATE subject_group = \"$subject_group\";"; 
                        $query .= "INSERT INTO task_due_to_date(subject_group, subject_id, task_type) VALUES(\"$subject_group\", \"$subject_id\", \"practice_task_2\") ON DUPLICATE KEY UPDATE subject_group = \"$subject_group\";"; 
                        $query .= "INSERT INTO task_due_to_date(subject_group, subject_id, task_type) VALUES(\"$subject_group\", \"$subject_id\", \"practice_task_3\") ON DUPLICATE KEY UPDATE subject_group = \"$subject_group\";"; 
                        $query .= "INSERT INTO task_due_to_date(subject_group, subject_id, task_type) VALUES(\"$subject_group\", \"$subject_id\", \"practice_task_4\") ON DUPLICATE KEY UPDATE subject_group = \"$subject_group\";"; 
                        $query .= "INSERT INTO task_due_to_date(subject_group, subject_id, task_type) VALUES(\"$subject_group\", \"$subject_id\", \"practice_task_5\") ON DUPLICATE KEY UPDATE subject_group = \"$subject_group\";"; 
                        $query .= "INSERT INTO task_due_to_date(subject_group, subject_id, task_type) VALUES(\"$subject_group\", \"$subject_id\", \"practice_task_6\") ON DUPLICATE KEY UPDATE subject_group = \"$subject_group\";"; 
                        $query .= "INSERT INTO task_due_to_date(subject_group, subject_id, task_type) VALUES(\"$subject_group\", \"$subject_id\", \"practice_task_7\") ON DUPLICATE KEY UPDATE subject_group = \"$subject_group\";"; 
                        $query .= "INSERT INTO task_due_to_date(subject_group, subject_id, task_type) VALUES(\"$subject_group\", \"$subject_id\", \"practice_task_8\") ON DUPLICATE KEY UPDATE subject_group = \"$subject_group\";"; 
                        $query .= "INSERT INTO task_due_to_date(subject_group, subject_id, task_type) VALUES(\"$subject_group\", \"$subject_id\", \"practice_task_9\") ON DUPLICATE KEY UPDATE subject_group = \"$subject_group\";"; 
                        $query .= "INSERT INTO task_due_to_date(subject_group, subject_id, task_type) VALUES(\"$subject_group\", \"$subject_id\", \"practice_task_10\") ON DUPLICATE KEY UPDATE subject_group = \"$subject_group\";";
                        
                        $query .= "INSERT INTO grade_table(subject_group, subject_id) VALUES(\"$subject_group\", \"$subject_id\") ON DUPLICATE KEY UPDATE subject_group = \"$subject_group\";";
                    }
                }

                if($pending_status === "APPROVED" && $is_teacher === 0){
                    $query .= "INSERT INTO results(neptun_code, subject_id) VALUES(\"$neptun_code\", \"$subject_id\") ON DUPLICATE KEY UPDATE subject_group = \"$subject_group\"; ";
                    $query .= "INSERT INTO practice_task_points(neptun_code, subject_id) VALUES(\"$neptun_code\", \"$subject_id\") ON DUPLICATE KEY UPDATE subject_group = \"$subject_group\"; ";
                }
            }
            $query .= "COMMIT;";

            $this->database->UpdateDatabase($query, true);
        }
    }

?>