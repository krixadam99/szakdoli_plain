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

            $query = "UPDATE practice_task_points, user_groups SET practice_task_$practice_number = $new_point WHERE ";
            $query .= "user_groups.neptun_code = practice_task_points.neptun_code AND user_groups.subject_id = practice_task_points.subject_id ";
            $query .= "AND practice_task_points.neptun_code = \"$neptun_code\" AND user_groups.application_request_status = \"APPROVED\" AND user_groups.is_teacher = \"0\"";
            
            return $this->UpdataDatabase($query);
        }
    }

?>