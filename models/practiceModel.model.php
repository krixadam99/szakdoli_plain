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
         * This method updates the practice task points by the given parameters.
         * 
         * Additionally, if the user's practice score is above (or equal to) 10, and the previous score is below 10, plus the practice task is not over the deadline, then the user's extra point will be incremented.
         * 
         * @param string $neptun_code The neptun code of the user.
         * @param string $practice_number The id of the practice tasks.
         * @param float $previous_point The previous point for the given pracice tasks.
         * @param float $update_point The current point for the given pracice tasks.
         * 
         * @return bool Returns whether the database update was successful, or not.
         */
        public function UpdatePracticeScore($neptun_code, $practice_number, $previous_point, $update_point){
            $neptun_code = strtoupper($neptun_code);
            $new_point = $previous_point + $update_point;

            $query = "BEGIN; UPDATE practice_task_points SET practice_task_$practice_number = $new_point WHERE ";
            $query .= "subject_group_id = (SELECT subject_group_id FROM user_status JOIN subject_group USING(subject_group_id) WHERE user_status.application_request_status = \"APPROVED\" AND user_status.is_teacher = \"0\" AND user_status.neptun_code = \"$neptun_code\")";
            $query .= " AND neptun_code = \"$neptun_code\"; ";

            if($previous_point < 10 && $new_point >= 10){
                $extra_points = $this->database->LoadDataFromDatabase("SELECT extra FROM results WHERE subject_group_id = (SELECT subject_group_id FROM user_status JOIN subject_group USING(subject_group_id) WHERE user_status.application_request_status = \"APPROVED\" AND user_status.is_teacher = \"0\" AND user_status.neptun_code = \"$neptun_code\")");
                $extra_points = $extra_points[0]??array("extra" => 0);
                $extra_points = $extra_points["extra"];

                $current_date = date("Y-m-d");
                $practice_task_due_date = $this->database->LoadDataFromDatabase("SELECT due_to FROM task_due_to_date WHERE task_type = \"practice_task_$practice_number\" AND subject_group_id = (SELECT subject_group_id FROM user_status JOIN subject_group USING(subject_group_id) WHERE user_status.application_request_status = \"APPROVED\" AND user_status.is_teacher = \"0\" AND user_status.neptun_code = \"$neptun_code\")");
                $practice_task_due_date = $practice_task_due_date[0]??array("due_to" => "");
                $practice_task_due_date = $practice_task_due_date["due_to"];

                if($current_date <= $practice_task_due_date){   
                    $query .= "UPDATE results SET extra = $extra_points + 1 WHERE ";
                    $query .= "subject_group_id = (SELECT subject_group_id FROM user_status JOIN subject_group USING(subject_group_id) WHERE user_status.application_request_status = \"APPROVED\" AND user_status.is_teacher = \"0\" AND user_status.neptun_code = \"$neptun_code\")";    
                    $query .= " AND neptun_code = \"$neptun_code\"; ";
                }
            }
            $query .= "COMMIT";
            return $this->database->UpdateDatabase($query, true);
        }
    }

?>