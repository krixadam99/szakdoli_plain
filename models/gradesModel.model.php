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
         * The user can have only one approved student status at a time, that is why only those results should be sent, that belongs to the subject group, where the user's student status is approved.
         * 
         * @param string $neptun_code The neptun code of the user.
         * 
         * @return array Returns an array containing the results of the student.
         */
        public function GetResults($neptun_code){
            $neptun_code = strtoupper($neptun_code);
            
            $query = "SELECT * FROM user_status JOIN results USING(neptun_code, subject_group_id) WHERE ";
            $query .= "results.neptun_code = :neptun_code AND user_status.application_request_status = \"APPROVED\" AND user_status.is_teacher = \"0\"";
            return $this->database->LoadDataFromDatabaseWithPDO($query, [":neptun_code" => $neptun_code]);
            
            // $query = "SELECT * FROM user_status JOIN results USING(neptun_code, subject_group_id) WHERE ";
            //$query .= "results.neptun_code = \"$neptun_code\" AND user_status.application_request_status = \"APPROVED\" AND user_status.is_teacher = \"0\"";
            //return $this->database->LoadDataFromDatabase($query);
        }
    }

?>