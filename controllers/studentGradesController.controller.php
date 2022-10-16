<?php
    /**
     * This is a controller class which is responsible for showing the students' grades' page.
     * 
     * This controller extends the MainContentController, from which it inherits members that are related to a logged in user.
     * If someone navigates to the students' grades' page, although they are not logged in, then this controller redirects them to the login page.
     * If someone navigates to the students' grades' page, however they are not a teacher, then this controller redirects them to the notifications page.
    */
    class StudentGradesController extends MainContentController{
        private $student_grades;
        
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

                $model = new StudentGradesModel();
                $students_grades = $model->GetStudentsGrades($_SESSION["subject"], $_SESSION["group"]);

                //Only teachers can see this page, others will be redirected to the notifications page
                if(count($this->GetApprovedTeacherGroups()) != 0){
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
            if(    isset($_SESSION["neptun_code"]) 
                && isset($_SESSION["group"]) 
                && isset($_SESSION["subject"])
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
                $original_user_results = $student_grades_model->GetStudentsGrades($_SESSION["subject"], $_SESSION["group"]);
                $query_array = array();
                foreach($original_user_results as $index => $original_record){
                    if(isset($new_results[$original_record["neptun_code"]])){
                        $results = $new_results[$original_record["neptun_code"]];
                        
                        array_push($query_array, array(
                            "neptun_code" => $original_record["neptun_code"], 
                            "subject_group" => $current_group, 
                            "subject_name" => $current_subject, 
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
                header("Location: ./index.php");
            }
        }
    }

?>