<?php
    /**
     * 
     */
    class AdministratorModel extends MainModel {        
        /**
         * 
         * The contructor of the AdministratorModel class.
         * 
         * It will call the MainModel class's constructor with which it will assign default values to the inherited members.
         * 
         * @return void
         */
        public function __construct(){
            parent::__construct();
        }
        
        /**
         * This public method returns all of the pending teachers.
         * 
         * @return array Returns an array containing all of the pending teachers.
         */
        public function GetPendingTeachers(){
            $query = "SELECT neptun_code, group_number, subject_id 
            FROM users JOIN user_status USING(neptun_code) JOIN subject_group USING(subject_group_id)
            WHERE neptun_code != \"admin\" AND is_teacher = 1 AND application_request_status = \"PENDING\"";
            return $this->database->LoadDataFromDatabase($query);
        }

        /**
         * This public method updates the user_groups table via queries formed by query data given in an array.
         * 
         * @param array $query_array An array containing the record of each user who will be updated. A record contains information about the neptun code, subject group, subject name and pending status (basically the attributes of the user_groups table).
         * 
         * @return bool Returns whether the teachers' pending status update was successful, or not.
         */
        public function UpdatePendingTeachers($query_array) {
            $query = "BEGIN; ";
            foreach($query_array as $index => $record){
                $neptun_code = $record["neptun_code"];
                $subject_group = $record["group_number"];
                $subject_id = $record["subject_id"];
                $pending_status = $record["application_request_status"];

                // Whithdraw from subjects if approved
                if($pending_status === "APPROVED"){
                    if($subject_id === "i"){
                        $query .= "UPDATE user_status SET application_request_status = \"WITHDRAWN\" WHERE neptun_code = \"$neptun_code\" AND is_teacher = \"0\" AND subject_group_id IN (SELECT subject_group_id FROM subject_group WHERE subject_group.subject_id = \"i\"); ";
                    }else{
                        $query .= "UPDATE user_status SET application_request_status = \"WITHDRAWN\" WHERE neptun_code = \"$neptun_code\" AND is_teacher = \"0\"; ";
                    }

                    $query .= "INSERT INTO subject_group(subject_id, group_number) VALUES(\"$subject_id\", \"$subject_group\") ON DUPLICATE KEY UPDATE subject_id = \"$subject_id\"; ";
                    $query .= "UPDATE user_status SET application_request_status = \"$pending_status\" WHERE neptun_code = \"$neptun_code\" 
                    AND subject_group_id = (SELECT subject_group_id FROM subject_group WHERE subject_id = \"$subject_id\" AND group_number = \"$subject_group\"); "; 
                    
                    $query .= "INSERT INTO expectation_rules(subject_group_id, task_type) VALUES((SELECT subject_group_id FROM subject_group WHERE subject_id = \"$subject_id\" AND group_number = \"$subject_group\"), \"practice_count\") ON DUPLICATE KEY UPDATE task_type = \"practice_count\";"; 
                    $query .= "INSERT INTO expectation_rules(subject_group_id, task_type) VALUES((SELECT subject_group_id FROM subject_group WHERE subject_id = \"$subject_id\" AND group_number = \"$subject_group\"), \"extra\") ON DUPLICATE KEY UPDATE task_type = \"extra\";"; 
                    $query .= "INSERT INTO expectation_rules(subject_group_id, task_type) VALUES((SELECT subject_group_id FROM subject_group WHERE subject_id = \"$subject_id\" AND group_number = \"$subject_group\"), \"middle_term_exam\") ON DUPLICATE KEY UPDATE task_type = \"middle_term_exam\";"; 
                    $query .= "INSERT INTO expectation_rules(subject_group_id, task_type) VALUES((SELECT subject_group_id FROM subject_group WHERE subject_id = \"$subject_id\" AND group_number = \"$subject_group\"), \"final_term_exam\") ON DUPLICATE KEY UPDATE task_type = \"final_term_exam\";";
                    $query .= "INSERT INTO expectation_rules(subject_group_id, task_type) VALUES((SELECT subject_group_id FROM subject_group WHERE subject_id = \"$subject_id\" AND group_number = \"$subject_group\"), \"middle_term_exam_correction\") ON DUPLICATE KEY UPDATE task_type = \"middle_term_exam_correction\";"; 
                    $query .= "INSERT INTO expectation_rules(subject_group_id, task_type) VALUES((SELECT subject_group_id FROM subject_group WHERE subject_id = \"$subject_id\" AND group_number = \"$subject_group\"), \"final_term_exam_correction\") ON DUPLICATE KEY UPDATE task_type = \"final_term_exam_correction\";"; 
                    $query .= "INSERT INTO expectation_rules(subject_group_id, task_type) VALUES((SELECT subject_group_id FROM subject_group WHERE subject_id = \"$subject_id\" AND group_number = \"$subject_group\"), \"small_tests\") ON DUPLICATE KEY UPDATE task_type = \"small_tests\";"; 
                    
                    $query .= "INSERT INTO task_due_to_date(subject_group_id, task_type) VALUES((SELECT subject_group_id FROM subject_group WHERE subject_id = \"$subject_id\" AND group_number = \"$subject_group\"), \"middle_term_exam\") ON DUPLICATE KEY UPDATE task_type = \"middle_term_exam\";"; 
                    $query .= "INSERT INTO task_due_to_date(subject_group_id, task_type) VALUES((SELECT subject_group_id FROM subject_group WHERE subject_id = \"$subject_id\" AND group_number = \"$subject_group\"), \"final_term_exam\") ON DUPLICATE KEY UPDATE task_type = \"final_term_exam\";";
                    $query .= "INSERT INTO task_due_to_date(subject_group_id, task_type) VALUES((SELECT subject_group_id FROM subject_group WHERE subject_id = \"$subject_id\" AND group_number = \"$subject_group\"), \"middle_term_exam_correction\") ON DUPLICATE KEY UPDATE task_type = \"middle_term_exam_correction\";"; 
                    $query .= "INSERT INTO task_due_to_date(subject_group_id, task_type) VALUES((SELECT subject_group_id FROM subject_group WHERE subject_id = \"$subject_id\" AND group_number = \"$subject_group\"), \"final_term_exam_correction\") ON DUPLICATE KEY UPDATE task_type = \"final_term_exam_correction\";";
                    $query .= "INSERT INTO task_due_to_date(subject_group_id, task_type) VALUES((SELECT subject_group_id FROM subject_group WHERE subject_id = \"$subject_id\" AND group_number = \"$subject_group\"), \"small_test_1\") ON DUPLICATE KEY UPDATE task_type = \"small_test_1\";"; 
                    $query .= "INSERT INTO task_due_to_date(subject_group_id, task_type) VALUES((SELECT subject_group_id FROM subject_group WHERE subject_id = \"$subject_id\" AND group_number = \"$subject_group\"), \"small_test_2\") ON DUPLICATE KEY UPDATE task_type = \"small_test_2\";"; 
                    $query .= "INSERT INTO task_due_to_date(subject_group_id, task_type) VALUES((SELECT subject_group_id FROM subject_group WHERE subject_id = \"$subject_id\" AND group_number = \"$subject_group\"), \"small_test_3\") ON DUPLICATE KEY UPDATE task_type = \"small_test_3\";"; 
                    $query .= "INSERT INTO task_due_to_date(subject_group_id, task_type) VALUES((SELECT subject_group_id FROM subject_group WHERE subject_id = \"$subject_id\" AND group_number = \"$subject_group\"), \"small_test_4\") ON DUPLICATE KEY UPDATE task_type = \"small_test_4\";"; 
                    $query .= "INSERT INTO task_due_to_date(subject_group_id, task_type) VALUES((SELECT subject_group_id FROM subject_group WHERE subject_id = \"$subject_id\" AND group_number = \"$subject_group\"), \"small_test_5\") ON DUPLICATE KEY UPDATE task_type = \"small_test_5\";"; 
                    $query .= "INSERT INTO task_due_to_date(subject_group_id, task_type) VALUES((SELECT subject_group_id FROM subject_group WHERE subject_id = \"$subject_id\" AND group_number = \"$subject_group\"), \"small_test_6\") ON DUPLICATE KEY UPDATE task_type = \"small_test_6\";"; 
                    $query .= "INSERT INTO task_due_to_date(subject_group_id, task_type) VALUES((SELECT subject_group_id FROM subject_group WHERE subject_id = \"$subject_id\" AND group_number = \"$subject_group\"), \"small_test_7\") ON DUPLICATE KEY UPDATE task_type = \"small_test_7\";"; 
                    $query .= "INSERT INTO task_due_to_date(subject_group_id, task_type) VALUES((SELECT subject_group_id FROM subject_group WHERE subject_id = \"$subject_id\" AND group_number = \"$subject_group\"), \"small_test_8\") ON DUPLICATE KEY UPDATE task_type = \"small_test_8\";"; 
                    $query .= "INSERT INTO task_due_to_date(subject_group_id, task_type) VALUES((SELECT subject_group_id FROM subject_group WHERE subject_id = \"$subject_id\" AND group_number = \"$subject_group\"), \"small_test_9\") ON DUPLICATE KEY UPDATE task_type = \"small_test_9\";"; 
                    $query .= "INSERT INTO task_due_to_date(subject_group_id, task_type) VALUES((SELECT subject_group_id FROM subject_group WHERE subject_id = \"$subject_id\" AND group_number = \"$subject_group\"), \"small_test_10\") ON DUPLICATE KEY UPDATE task_type = \"small_test_10\";";
                    $query .= "INSERT INTO task_due_to_date(subject_group_id, task_type) VALUES((SELECT subject_group_id FROM subject_group WHERE subject_id = \"$subject_id\" AND group_number = \"$subject_group\"), \"practice_task_1\") ON DUPLICATE KEY UPDATE task_type = \"practice_task_1\";"; 
                    $query .= "INSERT INTO task_due_to_date(subject_group_id, task_type) VALUES((SELECT subject_group_id FROM subject_group WHERE subject_id = \"$subject_id\" AND group_number = \"$subject_group\"), \"practice_task_2\") ON DUPLICATE KEY UPDATE task_type = \"practice_task_2\";"; 
                    $query .= "INSERT INTO task_due_to_date(subject_group_id, task_type) VALUES((SELECT subject_group_id FROM subject_group WHERE subject_id = \"$subject_id\" AND group_number = \"$subject_group\"), \"practice_task_3\") ON DUPLICATE KEY UPDATE task_type = \"practice_task_3\";"; 
                    $query .= "INSERT INTO task_due_to_date(subject_group_id, task_type) VALUES((SELECT subject_group_id FROM subject_group WHERE subject_id = \"$subject_id\" AND group_number = \"$subject_group\"), \"practice_task_4\") ON DUPLICATE KEY UPDATE task_type = \"practice_task_4\";"; 
                    $query .= "INSERT INTO task_due_to_date(subject_group_id, task_type) VALUES((SELECT subject_group_id FROM subject_group WHERE subject_id = \"$subject_id\" AND group_number = \"$subject_group\"), \"practice_task_5\") ON DUPLICATE KEY UPDATE task_type = \"practice_task_5\";"; 
                    $query .= "INSERT INTO task_due_to_date(subject_group_id, task_type) VALUES((SELECT subject_group_id FROM subject_group WHERE subject_id = \"$subject_id\" AND group_number = \"$subject_group\"), \"practice_task_6\") ON DUPLICATE KEY UPDATE task_type = \"practice_task_6\";"; 
                    $query .= "INSERT INTO task_due_to_date(subject_group_id, task_type) VALUES((SELECT subject_group_id FROM subject_group WHERE subject_id = \"$subject_id\" AND group_number = \"$subject_group\"), \"practice_task_7\") ON DUPLICATE KEY UPDATE task_type = \"practice_task_7\";"; 
                    $query .= "INSERT INTO task_due_to_date(subject_group_id, task_type) VALUES((SELECT subject_group_id FROM subject_group WHERE subject_id = \"$subject_id\" AND group_number = \"$subject_group\"), \"practice_task_8\") ON DUPLICATE KEY UPDATE task_type = \"practice_task_8\";"; 
                    $query .= "INSERT INTO task_due_to_date(subject_group_id, task_type) VALUES((SELECT subject_group_id FROM subject_group WHERE subject_id = \"$subject_id\" AND group_number = \"$subject_group\"), \"practice_task_9\") ON DUPLICATE KEY UPDATE task_type = \"practice_task_9\";"; 
                    $query .= "INSERT INTO task_due_to_date(subject_group_id, task_type) VALUES((SELECT subject_group_id FROM subject_group WHERE subject_id = \"$subject_id\" AND group_number = \"$subject_group\"), \"practice_task_10\") ON DUPLICATE KEY UPDATE task_type = \"practice_task_10\";";
                    
                    $query .= "INSERT INTO grade_table(subject_group_id) VALUES((SELECT subject_group_id FROM subject_group WHERE subject_id = \"$subject_id\" AND group_number = \"$subject_group\")) ON DUPLICATE KEY UPDATE subject_group_id = (SELECT subject_group_id FROM subject_group WHERE subject_id = \"$subject_id\" AND group_number = \"$subject_group\");";
                }
            }
            $query .= "COMMIT;";

            var_dump($query);

            $this->database->UpdateDatabase($query, true);
        }
    }

?>