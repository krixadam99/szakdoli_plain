<?php
    /**
     * This is the model which will be extended by the controllers belonging to the main part (i.e., not login, registration, index) throughout the project.
     * 
     * Every controller belonging to the main part (i.e., not login, registration, index) will instantiate its own model class. 
     * Each of these class will extend this model, so every one of them will inherit the public and protected methods implemented here.
     * It is possible, that some of them will not have further methods.
     */
    class TasksModel extends MainModel {        
        /**
         * 
         * The contructor of the TaskDetailModel class.
         * 
         * It will call the MainModel class's constructor with which it will assign default values to the inherited members.
         * 
         * @return void
         */
        protected function __construct(){
            parent::__construct();
        }
        
        /**
         * This public method returns the details of each task for the given subject name - subject group pair (that is, for the teacher's given group in the given subject).
         * 
         * @param string $subject_id The subject's name.
         * @param int $subject_group The group's number.
         * 
         * @return array Returns an array containing each task's details (minimum to pass, type of task, maximum points and whether the better counts, or not, if there is a correction from this type of task) belonging to the subject name - subject group pair.
         */
        public function GetExpectationRules($subject_id, $subject_group){
            
            $query = "SELECT * FROM expectation_rules 
            WHERE subject_group_id = (SELECT subject_group_id FROM subject_groups WHERE subject_id = \"$subject_id\" AND group_number = \"$subject_group\")";
            return $this->database->LoadDataFromDatabaseWithPDO($query);
            //return $this->database->LoadDataFromDatabase($query);
        }

        /**
         * This public method returns the due dates of each task for the given subject name - subject group pair (that is, for the teacher's given group in the given subject).
         * 
         * @param string $subject_id The subject's name.
         * @param int $subject_group The group's number.
         * 
         * @return array Returns an array containing each task's due date belonging to the subject name - subject group pair.
         */
        public function GetTaskDueDate($subject_id, $subject_group){
            $query = "SELECT * FROM task_due_to_date_table 
            WHERE subject_group_id = (SELECT subject_group_id FROM subject_groups WHERE subject_id = \"$subject_id\" AND group_number = \"$subject_group\")";
            return $this->database->LoadDataFromDatabaseWithPDO($query);
            //return $this->database->LoadDataFromDatabase($query);
        }

        /**
         * This public method returns the grade levels of each task for the given subject name - subject group pair (that is, for the teacher's given group in the given subject).
         * 
         * @param string $subject_id The subject's name.
         * @param int $subject_group The group's number.
         * 
         * @return array Returns an array containing the minimum point to get a certain grade for the subject name - subject group pair.
         */
        public function GetGradeLevels($subject_id, $subject_group){
            $query = "SELECT * FROM grade_table JOIN subject_groups USING(subject_group_id)
            WHERE group_number = \"$subject_group\" AND subject_id= \"$subject_id\"";
            return $this->database->LoadDataFromDatabaseWithPDO($query);
            //return $this->database->LoadDataFromDatabase($query);
        }

        /**
         * This public method returns the practice task results from the practice_task_points table for the user given by their neptun code.
         * 
         * @param string $neptun_code The neptun code of the user.
         * 
         * @return array Returns an array containing the practice task points.
         */
        public function GetPracticeResults($neptun_code){
            $neptun_code = strtoupper($neptun_code);
            $query = "SELECT * FROM user_status JOIN practice_task_points USING(neptun_code, subject_group_id) WHERE ";
            $query .= "practice_task_points.neptun_code = \"$neptun_code\" AND user_status.application_request_status = \"APPROVED\" AND user_status.is_teacher = \"0\"";
            return $this->database->LoadDataFromDatabaseWithPDO($query);
            //return $this->database->LoadDataFromDatabase($query);
        }
    }

?>