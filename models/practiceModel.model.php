<?php
    /**
     * This is a model class which is responsible for requesting data for the practice page.
     * 
     * This model extends the TasksModel class.
     * The practice score update will be performed by the UpdatePracticeScore method.
    */
    class PracticeModel extends TasksModel {
        /**
         * 
         * The contructor of the PracticeModel class.
         * 
         * It will call the MainModel class's constructor with which it will assign default values to the inherited members.
         * 
         * @return void
         */
        public function __construct(){
            parent::__construct();
        }
        
        /**
         * 
         */
        public function UpdatePracticeScore($neptun_code, $practice_number, $previous_point, $update_point){
            $neptun_code = strtoupper($neptun_code);
            $new_point = $previous_point + $update_point;

            $query = "UPDATE practice_task_points SET practice_task_$practice_number = $new_point WHERE ";
            $query .= "subject_group_id = (SELECT subject_group_id FROM user_status JOIN subject_group USING(subject_group_id) WHERE user_status.application_request_status = \"APPROVED\" AND user_status.is_teacher = \"0\" AND user_status.neptun_code = \"$neptun_code\")";

            return $this->UpdataDatabase($query);
        }
    }

?>