<?php
    /**
     * This is a model class which is responsible for updating a user's student group, or teacher groups.
     * 
     * This model extends the MainModel class.
    */
    class GroupAdditionModel extends MainModel{
        /**
         * 
         * The contructor of the GroupAdditionModel class.
         * 
         * It will call the MainModel class's constructor with which it will assign default values to the inherited members.
         * 
         * @return void
         */
        public function __construct(){
            parent::__construct();
        }
        
        /**
         * This public method is responsible for updating the user_groups table with the given data.
         * 
         * The new record will contain the neptun code, the selected user status, subject name and subject group.
         * If a student previously chose the "-" sign while applying to a subject name - subject group pair, then that row should be deleted from the table.
         * If there is a row for the neptun code - subject name - subject group triplet where the student was denied, then the application_request_status attribute should be updated to "PENDING".
         * If there is a row (or more rows) for the student already in this table, then the application_request_status attribute for that row (or rows) should be modified to "WITHDREW", and the application_request_status for this new record should be "PENDING".
         * 
         * If a teacher applies to the same subject name - subject group and their application_request_status is APPROVED, then this should not overwrite that (previously checked).
         * 
         * @param string $neptun_code This is the neptun code of the user. This will be used in both the users and user_groups tables.
         * @param string $subject_id This is the user' selected subject's name. This can be "i", or "ii". This will be used in the user_groups table.
         * @param string $user_status This is the user' selected user status. This can be "Demonstrátor", or "Diák". This will be used in the user_groups table.
         * @param string $subject_group This is the user' selected subject group. This can be either a group's number which is in the selected subject and has an assigned teacher, or a number between 1 and 30 (inclusively). This will be used in the user_groups table.
         * 
         * @return bool Returns whether updating the user's applied groups was successful, or not.
         */
        public function UpdateUserGroups($neptun_code = "", $subject_id = "", $user_status = "", $subject_group = "") {  
            $neptun_code = strtoupper($neptun_code);       

            $pending_status = "PENDING";
            if($user_status === "Demonstrátor"){
                $is_teacher = 1;
            }else{
                $is_teacher = 0;
            }

            if($subject_group === "-"){
                $subject_group = 0;
            }

            $query = "BEGIN; ";
            if($is_teacher === 1){
                $query .= "INSERT INTO subject_group(subject_id, subject_group) VALUES(\"$subject_group\", \"$subject_id\") ON DUPLICATE KEY UPDATE subject_id = \"$subject_id\" AND group_number = \"$subject_group\";";
                $query .= "INSERT INTO user_status VALUES((SELECT subject_group_id FROM subject_group WHERE subject_id = \"$subject_id\" AND group_number = \"$subject_group\"), \"$neptun_code\", \"$is_teacher\", \"$pending_status\") ON DUPLICATE KEY UPDATE application_request_status = \"$pending_status\", is_teacher = \"1\"; ";
            }else{
                $query .= "DELETE FROM user_status WHERE neptun_code = \"$neptun_code \" AND subject_group_id = 1; ";

                // WITHDRAWN or DELETED?
                $query .= "UPDATE user_status SET application_request_status = \"WITHDRAWN\" WHERE neptun_code = \"$neptun_code \" AND is_teacher = \"0\"; ";
                $query .= "INSERT INTO user_status VALUES((SELECT subject_group_id FROM subject_group WHERE subject_id = \"$subject_id\" AND group_number = \"$subject_group\"), \"$neptun_code\", \"$is_teacher\", \"$pending_status\") ON DUPLICATE KEY UPDATE application_request_status = \"$pending_status\", is_teacher = \"0\"; ";
            }
            $query .= "COMMIT; ";

            return $this->database->UpdateDatabase($query, true);
        }
    }

?>