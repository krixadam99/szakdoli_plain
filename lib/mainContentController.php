<?php
    
    class MainContentController {
        private $is_administrator;
        private $neptun_code;
        private $user_data;
        private $pending_teachers;
        private $pending_students;
        private $pending_teacher_groups;
        private $approved_teacher_groups;
        private $approved_teacher_subjects;
        private $pending_student_groups;
        private $approved_student_groups;
        private $approved_student_subject;
        private $practice_results;

        protected function __construct(){
            $this->CheckURLParameters();
            
            $this->is_administrator = false;
            $this->neptun_code = "";
            $this->user_data = [];
            $this->pending_teachers = [];
            $this->pending_students = [];
            $this->pending_teacher_groups = [];
            $this->approved_teacher_groups = [];
            $this->approved_teacher_subjects = [];
            $this->pending_student_groups = [];
            $this->approved_student_groups = [];
            $this->approved_student_subject = "";
            $this->practice_results = [];
        }

        public function GetIsAdministrator(){ return $this->is_administrator; }
        public function GetNeptunCode(){ return $this->neptun_code; }
        public function GetUserData(){ return $this->user_data; }
        public function GetPendingTeachers(){ return $this->pending_teachers; }
        public function GetStudents(){ return $this->pending_students; }
        public function GetPendingTeacherGroups(){ return $this->pending_teacher_groups; }
        public function GetApprovedTeacherGroups(){ return $this->approved_teacher_groups; }
        public function GetApprovedTeacherSubjects(){ return $this->approved_teacher_subjects; }
        public function GetPendingStudentGroups(){ return $this->pending_student_groups; }
        public function GetApprovedStudentGroups(){ return $this->approved_student_groups; }
        public function GetApprovedStudentSubject(){ return $this->approved_student_subject; }
        public function GetPracticeResults(){ return $this->practice_results; }

        protected function SetMembers(){
            if(isset($_SESSION["neptun_code"])){                
                $this->neptun_code = $_SESSION["neptun_code"];
                $model = new MainModel("szakdoli");
                $this->user_data = $model->GetUserData($this->neptun_code);
                
                if(count($this->user_data) == 0){
                    header("Location: ./index.php");
                }else{
                    $this->is_administrator = $this->user_data[0]["is_administrator"] == "1";

                    if(!$this->is_administrator){
                        foreach($this->user_data as $key => $user_record){
                            if($user_record["user_status"] == "teacher"){
                                if($user_record["pending_status"] == "0"){
                                    array_push($this->approved_teacher_groups, array("subject_name" => $user_record["subject_name"], "subject_group" => $user_record["subject_group"]));
                                    if(!in_array($user_record["subject_name"],$this->approved_teacher_subjects)){
                                        array_push($this->approved_teacher_subjects, $user_record["subject_name"]);
                                    }

                                    $pending_students_per_subject_group = $model->GetStudents($user_record["subject_name"], $user_record["subject_group"]);
                                    array_push($this->pending_students, array("subject_name" => $user_record["subject_name"], "subject_group" => $user_record["subject_group"], "users" => array_values($pending_students_per_subject_group)));
                                }else if($user_record["pending_status"] == "1"){
                                    array_push($this->pending_teacher_groups, array("subject_name" => $user_record["subject_name"], "subject_group" => $user_record["subject_group"]));
                                }
                            }else{
                                if($user_record["pending_status"] == "0"){
                                    $practice_results = $model->GetPracticeResults($this->neptun_code)[0];
                                    foreach($practice_results as $key => $value){
                                        if(is_int(strpos($key, "practice"))){
                                            $this->practice_results[$key] = $value;
                                        }
                                    }

                                    array_push($this->approved_student_groups, array("subject_name" => $user_record["subject_name"], "subject_group" => $user_record["subject_group"]));
                                    $this->approved_student_subject = $user_record["subject_name"];

                                }else if($user_record["pending_status"] == "1"){
                                    array_push($this->pending_student_groups, array("subject_name" => $user_record["subject_name"], "subject_group" => $user_record["subject_group"]));
                                }
                            }
                        }
                    }else{
                        $this->pending_teachers = $model->GetPendingTeachers();
                    }
                }
            }else{
                header("Location: ./index.php");
            }
        }

        private function CheckURLParameters(){
            //Handling malicious user url inputs

            if(isset($_SESSION["subject"]) && $_SESSION["subject"] != ""){
                if($_SESSION["subject"] != "i" && $_SESSION["subject"] != "ii" && $_SESSION["subject"] != "dimmoa"){
                    header("Location: ./index.php?site=notifications");
                    exit();
                }
            }

            if(isset($_SESSION["topic"]) && $_SESSION["topic"] != ""){
                if(is_numeric($_SESSION["topic"])){
                    if(intval($_SESSION["topic"]) > 11 || intval($_SESSION["topic"]) < 0){
                        header("Location: ./index.php?site=notifications");
                        exit();
                    }
                }else{
                    header("Location: ./index.php?site=notifications");
                    exit();
                }
            }

            //The topic part is not betwenn 0 and 11, or not a number
            if(isset($_SESSION["group"]) && $_SESSION["group"] != ""){
                if(is_numeric($_SESSION["group"])){
                    if(intval($_SESSION["group"]) > 30 || intval($_SESSION["group"]) < 0){
                        header("Location: ./index.php?site=notifications");
                        exit();
                    }
                }else{
                    header("Location: ./index.php?site=notifications");
                    exit();
                }
            }
        }
    }

?>