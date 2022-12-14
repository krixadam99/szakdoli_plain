<?php
    /**
     * This is a controller class which is responsible for showing the students' grades' page.
     * 
     * This controller extends the MainContentController, from which it inherits members that are related to a logged in user.
     * If someone navigates to the students' grades' page, although they are not logged in, then this controller redirects them to the login page.
     * If someone navigates to the students' grades' page, however they are not a teacher, then this controller redirects them to the notifications page.
    */
    class StudentGradesController extends MainContentController{        
        private $student_grades_model;

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
            $this->student_grades_model = new StudentGradesModel();
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
            // Users, who are not logged in won't see this page, they will be redirected to the login page
            if(isset($_SESSION["neptun_code"])){
                $this->SetMembers();
                
                // Only teachers can see this page, others will be redirected to the notifications page
                if(     isset($_SESSION["subject"])
                    &&  isset($_SESSION["group"])
                    &&  in_array(["subject_id" => $_SESSION["subject"],"subject_group" => $_SESSION["group"]], $this->approved_teacher_groups)
                ){
                    $_SESSION["previous_controller"] = "StudentGradesController";

                    // Fetching the grades, expectation rules, due dates and lower bound of the grades that belong to the subject - group pair
                    $students_grades = $this->GetResults($_SESSION["subject"], $_SESSION["group"]);
                    
                    $expectation_rules = $this->student_grades_model->GetExpectationRules($_SESSION["subject"], $_SESSION["group"]);
                    $task_due_dates = $this->student_grades_model->GetTaskDueDate($_SESSION["subject"], $_SESSION["group"]);
                    $grade_levels = $this->student_grades_model->GetGradeLevels($_SESSION["subject"], $_SESSION["group"])[0]??[];

                    $expectation_rules_tmp = [];
                    foreach($expectation_rules as $expectation_rule){
                        $expectation_rules_tmp[$expectation_rule["task_type"]] = $expectation_rule;
                    }
                    $expectation_rules = $expectation_rules_tmp;
                    
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
            // Neptun code, subject group and subject name must be set in the session, otherwise we cannot move forward
            if(isset($_SESSION["neptun_code"])){
                $this->SetMembers();
                if(
                        isset($_SESSION["group"]) && isset($_SESSION["subject"])
                    &&  in_array(["subject_id" => $_SESSION["subject"],"subject_group" => $_SESSION["group"]], $this->approved_teacher_groups)
                ){
                    $_SESSION["previous_controller"] = "StudentGradesController";

                    $current_subject = $_SESSION["subject"];
                    $current_group = $_SESSION["group"];

                    // Processing the points
                    $new_results = array();
                    foreach($_POST as $key => $value){
                        if(is_string($key) && is_string($value)){
                            $neptun = substr($key,0,6);
                            if(isset($new_results[$neptun])){
                                $key = substr($key,7);
                                $new_results[$neptun][$key] = $value;
                            }else{
                                $key = substr($key,7);
                                $new_results[$neptun] = array($key => $value);
                            }
                        }
                    }
            
                    // Getting the results of the students who belong to the group determined by the subject - group pair
                    $original_user_results = $this->GetResults($_SESSION["subject"], $_SESSION["group"]);
                    $query_array = array();

                    foreach($original_user_results as $neptun_code => $original_record){
                        // Only those students' points can be edited, who belong to the group determined by the subject - group pair
                        if(isset($new_results[$neptun_code])){
                            $results = $new_results[$neptun_code];

                            // Only numeric values can be passed through
                            $student_array = ["neptun_code" => $neptun_code, "group_number" => $current_group, "subject_id" => $current_subject, "task_point_pairs" => []];
                            foreach($results as $index => $result){
                               if(is_numeric($result) && isset($original_record[$index])){
                                    $student_array["task_point_pairs"][$index] = $result;
                                }else if(!is_numeric($result) && isset($original_record[$index])){
                                    $student_array["task_point_pairs"][$index] = $original_record[$index];
                                }
                            }      
                            array_push($query_array, $student_array);
                        }
                    }

                    $this->student_grades_model->UpdateResults($query_array);
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
                        if(is_string($key) && is_string($value)){
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
                    }
                
                    // Getting the expectation rules of the group determined by the subject - group pair
                    $original_expectation_rules = $this->student_grades_model->GetExpectationRules($_SESSION["subject"], $_SESSION["group"]);
                    $query_array = array();
                    foreach($original_expectation_rules as $index => $original_expectation_rule){
                        $task_type = $original_expectation_rule["task_type"];
                        
                        // Only those task types can be edited, which are in the expectation_rules table, and belong to the group determined by the subject - group pair
                        if(isset($new_expectation_rules[$task_type])){
                            $is_better = $new_expectation_rules[$task_type]["is_better"]??$original_expectation_rule["is_better"];
                            $minimum_for_pass = $new_expectation_rules[$task_type]["minimum_for_pass"]??$original_expectation_rule["minimum_for_pass"];
                            $maximum_value = $new_expectation_rules[$task_type]["maximum_value"]??$original_expectation_rule["maximum_value"];

                            // Validating the inputs
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

                    $this->student_grades_model->UpdateExpectationRules($query_array);
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
                        if(is_string($key) && is_string($value)){
                            $task = "";
                            if(is_numeric(strpos($key,"_due_to"))){
                                $task = explode("_due_to",$key)[0];
                            }
    
                            if($task !== ""){
                                $new_due_dates[$task] = $value;
                            }
                        }
                    }
                
                    // Getting the task due dates of those task that belong to the subject - group pair
                    $original_due_dates = $this->student_grades_model->GetTaskDueDate($_SESSION["subject"], $_SESSION["group"]);
                    $query_array = array();
                    foreach($original_due_dates as $index => $original_due_date){
                        $task_type = $original_due_date["task_type"];
                        if(isset($new_due_dates[$task_type])){
                            $due_date = $new_due_dates[$task_type];
                            
                            // Validating the date
                            $new_date = DateTime::createFromFormat("Y-m-d\TH:i:s", $due_date);
                            if($new_date){
                                $due_date = $new_date->format("Y-m-d H:i:s");
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

                    $this->student_grades_model->UpdateTaskDueDates($query_array);
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
                
                    // Getting the lower bound of the grades belinging to the group determined by the subject - group pair
                    $original_grade_points = $this->student_grades_model->GetGradeLevels($_SESSION["subject"], $_SESSION["group"])[0]??[];
                    
                    // Processing the data of the form
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

                    // Validating the points (excellent > good > satisfactory > pass)
                    $original_points = [$original_grade_points["pass_level_point"], $original_grade_points["satisfactory_level_point"], $original_grade_points["good_level_point"], $original_grade_points["excellent_level_point"]];
                    $points = [$pass_level_point, $satisfactory_level_point, $good_level_point, $excellent_level_point];
                    for($point_counter = 3; $point_counter > 0; $point_counter--){
                        $lower = $points[$point_counter - 1];
                        $upper = $points[$point_counter];

                        if($lower >= $upper){
                            $points[$point_counter] = $original_points[$point_counter];
                            $upper = $points[$point_counter];
                            if($lower >= $upper){
                                $points[$point_counter - 1] = $original_points[$point_counter - 1];
                            }
                        }
                    }

                    $query = "UPDATE grade_table 
                    SET pass_level_point = :point_0,
                    satisfactory_level_point = :point_1,
                    good_level_point = :point_2,
                    excellent_level_point = :point_3
                    WHERE subject_group_id = (SELECT subject_group_id FROM subject_groups WHERE subject_id = :current_subject
                    AND group_number = :current_group);";

                    $this->student_grades_model->UpdateDatabase($query, [":point_0"=>$points[0],":point_1"=>$points[1],":point_2"=>$points[2],":point_3"=>$points[3],":current_subject"=>$current_subject,":current_group"=>$current_group]);
                    //$this->student_grades_model->UpdataDatabase($query);
                    
                    header("Location: ./index.php?site=studentGrades&group=" . $_SESSION["group"] . "&subject=" . $_SESSION["subject"]);
                }else{
                    header("Location: ./index.php?site=notifications");
                }
            }else{
                header("Location: ./index.php");
            }
        }

        /**
         * This private method returns the grades of the students belonging to the given subject id - group number pair.
         * 
         * @param string $subject The id of the subject. Can be either "i", or "ii".
         * @param int $group The group's number.
         * 
         * @return array Returns the grades of the students belonging to the given subject id - group number pair.
         */
        private function GetResults($subject, $group){
            $students_grade_rows = $this->student_grades_model->GetResults($subject, $group);
            $students_grades = [];
            foreach($students_grade_rows as $row_counter => $students_grade_row){
                if(isset($students_grades[$students_grade_row["neptun_code"]])){
                    $students_grades[$students_grade_row["neptun_code"]] = array_merge($students_grades[$students_grade_row["neptun_code"]], [$students_grade_row["task_type"] => $students_grade_row["result"]]);
                }else{
                    $students_grades[$students_grade_row["neptun_code"]] = [
                        "subject_id" => $students_grade_row["subject_id"],
                        "group_number" => $students_grade_row["group_number"],
                        $students_grade_row["task_type"] => $students_grade_row["result"]
                    ];
                }
            }

            return $students_grades;
        }
    }

?>