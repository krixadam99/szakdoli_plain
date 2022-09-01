<?php
    /**
     * This is a model class which is responsible for requesting data for the practice page.
     * 
     * This model extends the MainModel class.
     * Here only the basic data should be requested from the database for the logged in user, so this model calls the MainModel's contructor.
     * Data request will be performed by the methods which were inherited from the MainModel.
     * The practice score update will be performed by the UpdatePracticeScore method.
    */
    class PracticeModel extends MainModel {
        
        public function __construct($database = "szakdoli"){
            parent::__construct($database);
        }

        public function UpdatePracticeScore($neptun_code, $practice_number, $previous_point, $update_point){
            $neptun_code = strtoupper($neptun_code);
            $new_point = $previous_point + $update_point;
            $query = "UPDATE practice_task_points SET practice_$practice_number = $new_point WHERE neptun_code = \"$neptun_code\"; ";
            $this->UpdataDatabase($query);
        }
    }

?>