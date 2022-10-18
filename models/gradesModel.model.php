<?php
    /**
     * This is a model class which is responsible for requesting data for the grades page.
     * 
     * This model extends the TasksModel class.
    */
    class GradesModel extends TasksModel {
        /**
         * 
         * The contructor of the GradesModel class.
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
         * This public method returns the  results from the results table for the user given by their neptun code.
         * 
         * @param string $neptun_code The neptun code of the user.
         * 
         * @return array Returns an array containing the results of the student.
         */
        public function GetResults($neptun_code){
            $neptun_code = strtoupper($neptun_code);
            $query = "SELECT * FROM user_groups, results WHERE ";
            $query .= "user_groups.neptun_code = results.neptun_code AND user_groups.subject_id = results.subject_id AND user_groups.subject_group = results.subject_group ";
            $query .= "AND results.neptun_code = \"$neptun_code\" AND user_groups.application_request_status = \"APPROVED\" AND user_groups.is_teacher = \"0\"";
            return $this->database->LoadDataFromDatabase($query);
        }
    }

?>