<?php

    class StudentGradesModel extends MainModel {
        /**
         * This public method returns all of the students' grades for the given subject name - subject group pair (that is, for the given teacher).
         * 
         * @param string $subject_name The subject's name.
         * @param int $subject_group The group's number.
         * 
         * @return array Returns an array containing the students' grades belonging to the subject name - subject group pair.
         */
        public function GetStudentsGrades($subject_name, $subject_group){
            $query = "SELECT * FROM user_groups, results 
            WHERE user_groups.neptun_code =  results.neptun_code
            AND user_groups.subject_name = results.subject_name
            AND user_groups.subject_group = results.subject_group
            AND user_groups.subject_name = \"$subject_name\" 
            AND user_groups.subject_group = \"$subject_group\" 
            AND user_groups.is_teacher = \"0\"
            AND user_groups.application_request_status = \"APPROVED\"";
            return $this->database->LoadDataFromDatabase($query);
        }

        /**
         * This public method updates the results table via an array containing the quires.
         * 
         * @param array $query_array An indexed array containing associative arrays containing the column name - new value pairs. The default is the empty array.
         * 
         * @return void
         */
        public function UpdateResults($query_array = []){
            $query = "BEGIN; ";
            foreach($query_array as $index => $record){
                $neptun_code = $record["neptun_code"];
                $subject_group = $record["subject_group"];
                $subject_name = $record["subject_name"];
                
                $query .= "UPDATE results 
                SET practice_count = \"" . $record["practice_count"] . "\"
                , extra = \"" . $record["extra"] . "\"
                , middle_term_exam = \"" . $record["middle_term_exam"] . "\"
                , middle_term_exam_correction = \"" . $record["middle_term_exam_correction"] . "\"
                , final_term_exam = \"" . $record["final_term_exam"] . "\"
                , final_term_exam_correction = \"" . $record["final_term_exam_correction"] . "\"
                , small_test_1 = \"" . $record["small_test_1"] . "\"
                , small_test_2 = \"" . $record["small_test_2"] . "\"
                , small_test_3 = \"" . $record["small_test_3"] . "\"
                , small_test_4 = \"" . $record["small_test_4"] . "\"
                , small_test_5 = \"" . $record["small_test_5"] . "\"
                , small_test_6 = \"" . $record["small_test_6"] . "\"
                , small_test_7 = \"" . $record["small_test_7"] . "\"
                , small_test_8 = \"" . $record["small_test_8"] . "\"
                , small_test_9 = \"" . $record["small_test_9"] . "\"
                , small_test_10 = \"" . $record["small_test_10"] . "\" 
                WHERE neptun_code = \"$neptun_code \" 
                AND subject_group = \"$subject_group\"
                AND subject_name = \"$subject_name\"; ";
            }
            $query .= "COMMIT;";
            $this->database->UpdateDatabase($query, true);
        }

        /**
         * This public method updates the expectation_rules table via an array containing the quires.
         * 
         * @param array $query_array An indexed array containing associative arrays containing the column name - new value pairs. The default is the empty array.
         * 
         * @return void
         */
        public function UpdateExpectationRules($query_array = []){
            $query = "BEGIN; ";
            foreach($query_array as $index => $record){
                $subject_group = $record["subject_group"];
                $subject_name = $record["subject_name"];
                $task_type = $record["task_type"];
                
                $query .= "UPDATE expectation_rules 
                SET is_better = \"" . $record["is_better"] . "\"
                , minimum_for_pass = \"" . $record["minimum_for_pass"] . "\"
                , maximum_value = \"" . $record["maximum_value"] . "\"
                WHERE subject_group = \"$subject_group\"
                AND subject_name = \"$subject_name\"
                AND task_type = \"$task_type\"; ";
            }
            $query .= "COMMIT;";
            $this->database->UpdateDatabase($query, true);
        }
    }

?>