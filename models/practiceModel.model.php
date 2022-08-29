<?php

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