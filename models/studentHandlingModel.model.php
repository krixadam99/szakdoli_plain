<?php
    /**
     * This is a model class which is responsible for updating the the user_status table. Additionally it updates the results and practice_task_points with rows for new approved students.
     * 
     * This model extends the MainModel class.
    */
    class StudentHandlingModel extends MainModel {
        /**
         * 
         * The contructor of the StudentHandlingModel class.
         * 
         * It will call the MainModel class's constructor with which it will assign default values to the inherited members.
         * 
         * @return void
         */
        public function __construct(){
            parent::__construct();
        }

        /**
         * This public method returns all of the students for the given subject name - subject group pair (i.e., belonging to the given group).
         * 
         * @param string $subject_id The subject's name.
         * @param int $subject_group The group's number.
         * 
         * @return array Returns an array containing the students belonging to the subject name - subject group pair.
         */
        public function GetStudents($subject_id, $subject_group){
            $query = "SELECT * FROM user_status JOIN subject_group USING(subject_group_id) WHERE neptun_code != \"admin\" AND is_teacher = 0 AND subject_id = \"$subject_id\" AND group_number = \"$subject_group\"";
            return $this->database->LoadDataFromDatabase($query);
        }

        /**
         * This public method updates the user_status table via queries formed by query data given in an array. Additionally, the pending status of the user becomes 0 (will be approved), then they will be added to the results and practice_task_points tables as well.
         * 
         * @param array $query_array An array containing the record of each user who will be updated. A record contains information about the neptun code, user status, subject group, subject name and pending status (basically the attributes of the user_groups table).
         * 
         * @return bool Returns whether the students' pending status update was successful, or not.
         */
        public function UpdatePendingStudents($query_array) {
            $query = "BEGIN; ";
            foreach($query_array as $index => $record){
                $neptun_code = $record["neptun_code"];
                
                $subject_group = $record["group_number"];
                $subject_id = $record["subject_id"];
                $pending_status = $record["application_request_status"];
                
                // Set the status of the user to the new status only if the previous status is not "WITHDRAWN"
                $query .= "UPDATE user_status SET application_request_status = \"$pending_status\" WHERE neptun_code = \"$neptun_code\" 
                AND subject_group_id = (SELECT subject_group_id FROM subject_group WHERE subject_id = \"$subject_id\" AND group_number = \"$subject_group\") 
                AND is_teacher = \"0\" AND application_request_status != \"WITHDRAWN\"; "; 
                
                // If the new status is "APPROVED"
                if($pending_status === "APPROVED"){
                    // Set the user's status to "WITHDRAWN" where the user is a teacher, or the user is a student, and their actual status is not "APPROVED"
                    if($subject_id === "i"){
                        $query .= "UPDATE user_status SET application_request_status = \"WITHDRAWN\" WHERE neptun_code = \"$neptun_code \" AND is_teacher = \"1\"; ";
                    }else{
                        $query .= "UPDATE user_status SET application_request_status = \"WITHDRAWN\" WHERE neptun_code = \"$neptun_code \" AND is_teacher = \"1\" AND subject_group_id = (SELECT subject_group_id FROM subject_group WHERE subject_group_id = user_status.subject_group_id); ";
                    }
                    $query .= "UPDATE user_status SET application_request_status = \"WITHDRAWN\" WHERE neptun_code = \"$neptun_code\" AND is_teacher = 0 AND application_request_status != \"APPROVED\"; ";
                
                    // INSERT INTO/ UPDATE the results table with the new user
                    $query .= "INSERT INTO results(neptun_code, subject_group_id) VALUES(\"$neptun_code\", (SELECT subject_group_id FROM subject_group WHERE subject_id = \"$subject_id\" AND group_number = \"$subject_group\")) 
                    ON DUPLICATE KEY UPDATE subject_group_id = (SELECT subject_group_id FROM subject_group WHERE subject_id = \"$subject_id\" AND group_number = \"$subject_group\"); ";

                    // INSERT INTO/ UPDATE the practice_task_points table with the new user
                    $query .= "INSERT INTO practice_task_points(neptun_code, subject_group_id) VALUES(\"$neptun_code\", (SELECT subject_group_id FROM subject_group WHERE subject_id = \"$subject_id\" AND group_number = \"$subject_group\")) 
                    ON DUPLICATE KEY UPDATE subject_group_id = (SELECT subject_group_id FROM subject_group WHERE subject_id = \"$subject_id\" AND group_number = \"$subject_group\"); ";
                }
            }
            $query .= "COMMIT;";

            return $this->database->UpdateDatabase($query, true);
        }
    }

?>