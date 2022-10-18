<?php

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
            $query = "SELECT * FROM user_groups WHERE neptun_code != \"admin\" AND is_teacher = 0 AND subject_id = \"$subject_id\" AND subject_group = \"$subject_group\"";
            return $this->database->LoadDataFromDatabase($query);
        }

        /**
         * This public method updates the user_groups table via queries formed by query data given in an array. Additionally, the pending status of the user becomes 0 (will be approved), then they will be added to the results and practice_task_points tables as well.
         * 
         * @param array $query_array An array containing the record of each user who will be updated. A record contains information about the neptun code, user status, subject group, subject name and pending status (basically the attributes of the user_groups table).
         * 
         * @return bool Returns whether the students' pending status update was successful, or not.
         */
        public function UpdatePendingStudents($query_array) {
            $query = "BEGIN; ";
            foreach($query_array as $index => $record){
                $neptun_code = $record["neptun_code"];
                
                $subject_group = $record["subject_group"];
                $subject_id = $record["subject_id"];
                $pending_status = $record["application_request_status"];
                
                $query .= "UPDATE user_groups SET application_request_status = \"$pending_status\" WHERE neptun_code = \"$neptun_code\" AND subject_id = \"$subject_id\" AND subject_group = \"$subject_group\" AND is_teacher = \"0\" AND application_request_status != \"WITHDRAWN\"; "; 
                
                
                if($pending_status === "APPROVED"){
                    if($subject_id === "i"){
                        $query .= "UPDATE user_groups SET application_request_status = \"WITHDRAWN\" WHERE neptun_code = \"$neptun_code \" AND is_teacher = \"1\"; ";
                    }else{
                        $query .= "UPDATE user_groups SET application_request_status = \"WITHDRAWN\" WHERE neptun_code = \"$neptun_code \" AND is_teacher = \"1\" AND subject_id = \"ii\"; ";
                    }
                    $query .= "UPDATE user_groups SET application_request_status = \"WITHDRAWN\" WHERE neptun_code = \"$neptun_code\" AND is_teacher = 0 AND application_request_status != \"APPROVED\"; ";
                
                    $query .= "INSERT INTO results(neptun_code, subject_id) VALUES(\"$neptun_code\", \"$subject_id\") ON DUPLICATE KEY UPDATE subject_group = \"$subject_group\"; ";
                    $query .= "INSERT INTO practice_task_points(neptun_code, subject_id) VALUES(\"$neptun_code\", \"$subject_id\") ON DUPLICATE KEY UPDATE subject_group = \"$subject_group\"; ";
                }
            }
            $query .= "COMMIT;";

            return $this->database->UpdateDatabase($query, true);
        }
    }

?>