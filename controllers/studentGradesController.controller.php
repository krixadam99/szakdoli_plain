<?php
    /**
     * This is a controller class which is responsible for showing the students' grades' page.
     * 
     * This controller extends the MainContentController, from which it inherits members that are related to a logged in user.
     * If someone navigates to the students' grades' page, although they are not logged in, then this controller redirects them to the login page.
     * If someone navigates to the students' grades' page, however they are not a teacher, then this controller redirects them to the notifications page.
    */
    class StudentGradesController extends MainContentController{        
        /**
         * 
         * The contructor of the StudentGradesController class.
         * 
         * It will call the MainContentController class's constructor with which it will assign default values to the inherited members.
         * 
         * @return void
         */
        public function __construct(){
            parent::__construct();
        }
        
        /**
         *
         * This method is responsible for showing the students' grade page 
         * 
         * If a client types the page name in the searchbar of the browser, but not logged in, then they will be redirected to the login page
         * If a user is logged in, but is not a teacher, i.e., has no assigned group, then they will be redirected to the notifications page (every user has this, regardless their status)
         * 
         * @return void
        */
        public function StudentGrades(){
            //Users, who are not logged in won't see this page, they will be redirected to the login page
            if(isset($_SESSION["neptun_code"])){
                $this->SetMembers();
                
                //Only teachers can see this page, others will be redirected to the notifications page
                if(     isset($_SESSION["subject"])
                    &&  isset($_SESSION["group"])
                    &&  in_array(["subject_id" => $_SESSION["subject"],"subject_group" => $_SESSION["group"]], $this->approved_teacher_groups)
                ){
                    $model = new StudentGradesModel();
                
                    $students_grades = $model->GetResults($_SESSION["subject"], $_SESSION["group"]);
                    $expectation_rules = $model->GetExpectationRules($_SESSION["subject"], $_SESSION["group"]);
                    $task_due_dates = $model->GetTaskDueDate($_SESSION["subject"], $_SESSION["group"]);
                    $grade_levels = $model->GetGradeLevels($_SESSION["subject"], $_SESSION["group"])[0]??[];
                    
                    include(ROOT_DIRECTORY . "/views/studentGradesPage.view.php");
                }else{
                    header("Location: ./index.php?site=notifications");
                }
            }else{
                header("Location: ./index.php?site=login");
            }
        }

        /**
         *
         * This method is responsible for updating the results of students belonging to a subject name - subject group pair.
         * 
         * @return void
        */
        public function UpdateResults(){
            //Neptun code, subject group and subject name must be set in the session, otherwise we cannot move forward
            if(isset($_SESSION["neptun_code"])){
                $this->SetMembers();
                if(
                        isset($_SESSION["group"]) && isset($_SESSION["subject"])
                    &&  in_array(["subject_id" => $_SESSION["subject"],"subject_group" => $_SESSION["group"]], $this->approved_teacher_groups)
                ){
                    $current_subject = $_SESSION["subject"];
                    $current_group = $_SESSION["group"];

                    $new_results = array();
                    foreach($_POST as $key => $value){
                        $neptun = substr($key,0,6);
                        if(isset($new_results[$neptun])){
                            $key = substr($key,7);
                            $new_results[$neptun][$key] = $value;
                        }else{
                            $key = substr($key,7);
                            $new_results[$neptun] = array($key => $value);
                        }
                    }
                
                    $student_grades_model = new StudentGradesModel();
                    $original_user_results = $student_grades_model->GetResults($_SESSION["subject"], $_SESSION["group"]);
                    $query_array = array();
                    foreach($original_user_results as $index => $original_record){
                        if(isset($new_results[$original_record["neptun_code"]])){
                            $results = $new_results[$original_record["neptun_code"]];
                            
                            array_push($query_array, array(
                                "neptun_code" => $original_record["neptun_code"], 
                                "group_number" => $current_group, 
                                "subject_id" => $current_subject, 
                                "practice_count" => $results["grade_input_practice"]??$original_record["practice_count"],
                                "extra" => $results["grade_input_extra"]??$original_record["extra"],
                                "middle_term_exam" => $results["grade_input_middle_term"]??$original_record["middle_term_exam"],
                                "middle_term_exam_correction" => $results["grade_input_middle_term_corr"]??$original_record["middle_term_exam"],
                                "final_term_exam" => $results["grade_input_final_term"]??$original_record["final_term_exam"],
                                "final_term_exam_correction" => $results["grade_input_final_term_corr"]??$original_record["final_term_exam_correction"],
                                "small_test_1" => $results["grade_input_small_test_1"]??$original_record["small_test_1"],
                                "small_test_2" => $results["grade_input_small_test_2"]??$original_record["small_test_2"],
                                "small_test_3" => $results["grade_input_small_test_3"]??$original_record["small_test_3"],
                                "small_test_4" => $results["grade_input_small_test_4"]??$original_record["small_test_4"],
                                "small_test_5" => $results["grade_input_small_test_5"]??$original_record["small_test_5"],
                                "small_test_6" => $results["grade_input_small_test_6"]??$original_record["small_test_6"],
                                "small_test_7" => $results["grade_input_small_test_7"]??$original_record["small_test_7"],
                                "small_test_8" => $results["grade_input_small_test_8"]??$original_record["small_test_8"],
                                "small_test_9" => $results["grade_input_small_test_9"]??$original_record["small_test_9"],
                                "small_test_10" => $results["grade_input_small_test_10"]??$original_record["small_test_10"],
                            ));
                        }
                    }

                    $student_grades_model->UpdateResults($query_array);
                    header("Location: ./index.php?site=studentGrades&group=" . $_SESSION["group"] . "&subject=" . $_SESSION["subject"]);
                }else{
                    header("Location: ./index.php?site=notifications");
                }
            }else{
                header("Location: ./index.php");
            }
        }

        /**
         *
         * This method is responsible for updating the expectation rules of tasks belonging to a subject name - subject group pair.
         * 
         * @return void
        */
        public function UpdateExpectationRules(){            
            //Neptun code, subject group and subject name must be set in the session, otherwise we cannot move forward
            if(    isset($_SESSION["neptun_code"]) 
                && isset($_SESSION["group"]) 
                && isset($_SESSION["subject"])
            ){
                $this->SetMembers();
                if(
                        isset($_SESSION["group"]) && isset($_SESSION["subject"])
                    &&  in_array(["subject_id" => $_SESSION["subject"],"subject_group" => $_SESSION["group"]], $this->approved_teacher_groups)
                ){
                    $current_subject = $_SESSION["subject"];
                    $current_group = $_SESSION["group"];

                    $new_expectation_rules = array();
                    foreach($_POST as $key => $value){
                        $task = "";
                        $new_key = "";
                        if(is_numeric(strpos($key,"_is_better"))){
                            $task = explode("_is_better",$key)[0];
                            $new_key = "is_better";
                        }elseif(is_numeric(strpos($key,"_minimum_for_pass"))){
                            $task = explode("_minimum_for_pass",$key)[0];
                            $new_key = "minimum_for_pass";
                        }elseif(is_numeric(strpos($key,"_maximum_value"))){
                            $task = explode("_maximum_value",$key)[0];
                            $new_key = "maximum_value";
                        }

                        if($task !== "" && $new_key !== ""){
                            if(isset($new_expectation_rules[$task])){
                                $new_expectation_rules[$task][$new_key] = $value;
                            }else{
                                $new_expectation_rules[$task] = array($new_key => $value);
                            }
                        }
                    }
                
                    $student_grades_model = new StudentGradesModel();
                    $original_expectation_rules = $student_grades_model->GetExpectationRules($_SESSION["subject"], $_SESSION["group"]);
                    $query_array = array();
                    foreach($original_expectation_rules as $index => $original_expectation_rule){
                        $task_type = $original_expectation_rule["task_type"];
                        
                        if(isset($new_expectation_rules[$task_type])){
                            $is_better = $new_expectation_rules[$task_type]["is_better"]??$original_expectation_rule["is_better"];
                            $minimum_for_pass = $new_expectation_rules[$task_type]["minimum_for_pass"]??$original_expectation_rule["minimum_for_pass"];
                            $maximum_value = $new_expectation_rules[$task_type]["maximum_value"]??$original_expectation_rule["maximum_value"];

                            if($is_better === "NEM"){
                                $is_better = "0";
                            }elseif($is_better === "IGEN"){
                                $is_better = "1";
                            }else{
                                $is_better = "-1";
                            }

                            if(is_numeric($minimum_for_pass)){
                                if(intval($minimum_for_pass) < 0){
                                    $minimum_for_pass = $original_expectation_rule["minimum_for_pass"];
                                }
                            }else{
                                $minimum_for_pass = $original_expectation_rule["minimum_for_pass"];
                            }
                            
                            if(is_numeric($maximum_value)){
                                if(intval($maximum_value) < 0 || $maximum_value < $minimum_for_pass){
                                    $maximum_value = $original_expectation_rule["maximum_value"];
                                    $minimum_for_pass = $original_expectation_rule["minimum_for_pass"];
                                }
                            }else{
                                $maximum_value = $original_expectation_rule["maximum_value"];
                            }
                            
                            array_push($query_array, array(
                                "group_number" => $current_group, 
                                "subject_id" => $current_subject,
                                "task_type" => $task_type,
                                "is_better" => $is_better,
                                "minimum_for_pass" => $minimum_for_pass,
                                "maximum_value" => $maximum_value
                            ));
                        }
                    }

                    $student_grades_model->UpdateExpectationRules($query_array);
                    header("Location: ./index.php?site=studentGrades&group=" . $_SESSION["group"] . "&subject=" . $_SESSION["subject"]);
                }else{

                }
            }else{
                header("Location: ./index.php");
            }
        }

        /**
         *
         * This method is responsible for updating the task due dates belonging to a subject name - subject group pair.
         * 
         * @return void
        */
        public function UpdateTaskDueDates(){
            //Neptun code, subject group and subject name must be set in the session, otherwise we cannot move forward
            if(    isset($_SESSION["neptun_code"]) 
                && isset($_SESSION["group"]) 
                && isset($_SESSION["subject"])
            ){
                $this->SetMembers();
                if(
                        isset($_SESSION["group"]) && isset($_SESSION["subject"])
                    &&  in_array(["subject_id" => $_SESSION["subject"],"subject_group" => $_SESSION["group"]], $this->approved_teacher_groups)
                ){
                    $current_subject = $_SESSION["subject"];
                    $current_group = $_SESSION["group"];

                    $new_due_dates = array();
                    foreach($_POST as $key => $value){
                        $task = "";
                        if(is_numeric(strpos($key,"_due_to"))){
                            $task = explode("_due_to",$key)[0];
                        }

                        if($task !== ""){
                            $new_due_dates[$task] = $value;
                        }
                    }
                
                    $student_grades_model = new StudentGradesModel();
                    $original_due_dates = $student_grades_model->GetTaskDueDate($_SESSION["subject"], $_SESSION["group"]);
                    $query_array = array();
                    foreach($original_due_dates as $index => $original_due_date){
                        $task_type = $original_due_date["task_type"];
                        if(isset($new_due_dates[$task_type])){
                            $due_date = $new_due_dates[$task_type];
                            
                            $new_date = DateTime::createFromFormat("Y-m-d", $due_date);
                            if($new_date){
                                $due_date = $new_date->format("Y-m-d");
                            }else{
                                $due_date = $original_due_date["due_to"];
                            }

                            array_push($query_array, array(
                                "group_number" => $current_group, 
                                "subject_id" => $current_subject,
                                "task_type" => $task_type,
                                "due_to" => $due_date
                            ));
                        }
                    }

                    $student_grades_model->UpdateTaskDueDates($query_array);
                    header("Location: ./index.php?site=studentGrades&group=" . $_SESSION["group"] . "&subject=" . $_SESSION["subject"]);
                }else{

                }
            }else{
                header("Location: ./index.php");
            }
        }

        /**
         *
         * This method is responsible for updating the lower points of grades belonging to a subject name - subject group pair.
         * 
         * @return void
        */
        public function UpdateGradeLevels(){
            //Neptun code, subject group and subject name must be set in the session, otherwise we cannot move forward
            if(    isset($_SESSION["neptun_code"]) 
                && isset($_SESSION["group"]) 
                && isset($_SESSION["subject"])
            ){
                $this->SetMembers();
                if(
                        isset($_SESSION["group"]) && isset($_SESSION["subject"])
                    &&  in_array(["subject_id" => $_SESSION["subject"],"subject_group" => $_SESSION["group"]], $this->approved_teacher_groups)
                ){
                    $current_subject = $_SESSION["subject"];
                    $current_group = $_SESSION["group"];
                
                    $student_grades_model = new StudentGradesModel();
                    $original_grade_points = $student_grades_model->GetGradeLevels($_SESSION["subject"], $_SESSION["group"])[0]??[];
                    
                    $pass_level_point = $_POST["pass_level_point"]??$original_grade_points["pass_level_point"];
                    $satisfactory_level_point = $_POST["satisfactory_level_point"]??$original_grade_points["satisfactory_level_point"];
                    $good_level_point = $_POST["good_level_point"]??$original_grade_points["good_level_point"];
                    $excellent_level_point = $_POST["excellent_level_point"]??$original_grade_points["excellent_level_point"];
                    
                    if(!is_numeric($excellent_level_point)){
                        $excellent_level_point = $original_grade_points["excellent_level_point"];
                    }
                    if(!is_numeric($good_level_point)){
                        $good_level_point = $original_grade_points["good_level_point"];
                    }
                    if(!is_numeric($satisfactory_level_point)){
                        $satisfactory_level_point = $original_grade_points["satisfactory_level_point"];
                    }
                    if(!is_numeric($pass_level_point)){
                        $pass_level_point = $original_grade_points["pass_level_point"];
                    }

                    $original_points = [$original_grade_points["pass_level_point"], $original_grade_points["satisfactory_level_point"], $original_grade_points["good_level_point"], $original_grade_points["excellent_level_point"]];
                    $points = [$pass_level_point, $satisfactory_level_point, $good_level_point, $excellent_level_point];
                    for($point_counter = 3; $point_counter > 0; $point_counter--){
                        $lower = $points[$point_counter - 1];
                        $upper = $points[$point_counter];

                        if($lower > $upper){
                            $points[$point_counter] = $original_points[$point_counter];
                            $upper = $points[$point_counter];
                            if($lower > $upper){
                                $points[$point_counter - 1] = $original_points[$point_counter - 1];
                            }
                        }
                    }

                    $query = "UPDATE grade_table 
                    SET pass_level_point = \"" . $points[0] . "\",
                    satisfactory_level_point = \"" . $points[1] . "\",
                    good_level_point = \"" . $points[2] . "\",
                    excellent_level_point = \"" . $points[3] . "\"
                    WHERE subject_group_id = (SELECT subject_group_id FROM subject_group WHERE subject_id = \"$current_subject\"
                    AND group_number = \"$current_group\");";

                    $student_grades_model->UpdataDatabase($query);
                    header("Location: ./index.php?site=studentGrades&group=" . $_SESSION["group"] . "&subject=" . $_SESSION["subject"]);
                }else{

                }
            }else{
                header("Location: ./index.php");
            }
        }
    }

?>