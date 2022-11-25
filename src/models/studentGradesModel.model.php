<?php
    /**
     * This is a model class which is responsible for assigning results to students.
     * 
     * This model extends the MainModel class.
    */
    class StudentGradesModel extends TasksModel {
        /**
         * 
         * The contructor of the StudentGradesModel class.
         * 
         * It will call the MainModel class's constructor with which it will assign default values to the inherited members.
         * 
         * @return void
         */
        public function __construct(){
            parent::__construct();
        }

        /**
         * This public method returns all of the students' grades for the given subject name - subject group pair (that is, for the given teacher).
         * 
         * @param string $subject_id The subject's name.
         * @param int $subject_group The group's number.
         * 
         * @return array Returns an array containing the students' grades belonging to the subject name - subject group pair.
         */
        public function GetResults($subject_id, $subject_group){
            $query = "SELECT * FROM user_status JOIN subject_groups USING(subject_group_id) JOIN results USING(neptun_code, subject_group_id) 
            WHERE subject_id = \"$subject_id\" 
            AND group_number = \"$subject_group\" 
            AND is_teacher = \"0\"
            AND application_request_status = \"APPROVED\"";

            return $this->database->LoadDataFromDatabaseWithPDO($query);
            //return $this->database->LoadDataFromDatabase($query);
        }

        /**
         * This public method returns the practice task results from the practice_task_points table for students belonging to the given subject name - subject group pair (that is, for the given teacher).
         * 
         * @param string $subject_id The subject's name. The default is "".
         * @param int $subject_group The group's number. The default is "".
         * 
         * @return array Returns an array containing the students' practice scores belonging to the subject name - subject group pair.
         */
        public function GetPracticeResults($subject_group = "", $subject_id = ""){
            $query = "SELECT * FROM user_status JOIN subject_groups USING(subject_group_id) JOIN practice_task_points USING(neptun_code, subject_group_id) WHERE ";
            $query .= "subject_groups.group_number = \"$subject_group\" AND subject_groups.subject_id = \"$subject_id\" AND user_status.application_request_status = \"APPROVED\" AND user_status.is_teacher = \"0\"";
            return $this->database->LoadDataFromDatabaseWithPDO($query);
            //return $this->database->LoadDataFromDatabase($query);
        }

        /**
         * This public method updates the results table via an array containing the queries.
         * 
         * @param array $query_array An indexed array containing associative arrays containing the column name - new value pairs. The default is the empty array.
         * 
         * @return bool Returns whether updating the results table was successful, or not.
         */
        public function UpdateResults($query_array = []){
            $query = "BEGIN; ";
            foreach($query_array as $index => $record){
                $neptun_code = $record["neptun_code"];
                $subject_group = $record["group_number"];
                $subject_id = $record["subject_id"];
                
                foreach($record["task_point_pairs"] as $task_type => $point){
                    $query .= "UPDATE results 
                    SET result = \"" . $point . "\"
                    WHERE neptun_code = \"$neptun_code \" 
                    AND results.subject_group_id = (SELECT subject_group_id FROM subject_groups WHERE subject_id = \"$subject_id\" AND group_number = \"$subject_group\")
                    AND task_type = \"$task_type\"; ";
                }
            }
            $query .= "COMMIT;";

            return $this->database->UpdateDatabaseWithPDO($query, []);
            //return $this->database->UpdateDatabase($query, true);
        }

        /**
         * This public method updates the expectation_rules table via an array containing the queries.
         * 
         * @param array $query_array An indexed array containing associative arrays containing the column name - new value pairs. The default is the empty array.
         * 
         * @return bool Returns whether updating the expextation_rules table was successful, or not.
         */
        public function UpdateExpectationRules($query_array = []){
            $query = "BEGIN; ";
            foreach($query_array as $index => $record){
                $subject_group = $record["group_number"];
                $subject_id = $record["subject_id"];
                $task_type = $record["task_type"];
                
                $query .= "UPDATE expectation_rules 
                SET is_better = \"" . $record["is_better"] . "\"
                , minimum_for_pass = \"" . $record["minimum_for_pass"] . "\"
                , maximum_value = \"" . $record["maximum_value"] . "\"
                WHERE task_type = \"$task_type\"
                AND expectation_rules.subject_group_id = (SELECT subject_group_id FROM subject_groups WHERE subject_id = \"$subject_id\" AND group_number = \"$subject_group\"); ";
            }
            $query .= "COMMIT;";

            return $this->database->UpdateDatabaseWithPDO($query, []);
            //return $this->database->UpdateDatabase($query, true);
        }

        /**
         * This public method updates the task_due_to_date_table table via an array containing the queries.
         * 
         * @param array $query_array An indexed array containing associative arrays containing the column name - new value pairs. The default is the empty array.
         * 
         * @return bool Returns whether updating the task_due_to_date_table table was successful, or not.
         */
        public function UpdateTaskDueDates($query_array = []){
            $query = "BEGIN; ";
            foreach($query_array as $index => $record){
                $subject_group = $record["group_number"];
                $subject_id = $record["subject_id"];
                $task_type = $record["task_type"];
                
                $query .= "UPDATE task_due_to_date_table 
                SET due_to = \"" . $record["due_to"] . "\"
                WHERE task_due_to_date_table.subject_group_id = (SELECT subject_group_id FROM subject_groups WHERE subject_id = \"$subject_id\" AND group_number = \"$subject_group\")
                AND task_type = \"$task_type\"; ";
            }
            $query .= "COMMIT;";
            
            return $this->database->UpdateDatabaseWithPDO($query, []);
            //return $this->database->UpdateDatabase($query, true);
        }
    }

?>