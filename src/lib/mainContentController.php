<?php
    /**
     * 
     * This is a controller class which defines the basic data that will be used on almost every page (except index, login and registration pages).
     * 
     * The controllers throughout the project (except those that belong to the index, login, or registration pages) will inherit the protected members, and the protected and public methods.
     * Since we need to know in the main part the neptun code, whether the user is an administrator, the students whose status is pending and approved belonging to this user, the groups and subjects for which the user's teacher and student status is pending and approved, so we will set these members here for each controller class. 
    */
    class MainContentController extends FormValidator {
        protected $is_administrator;
        
        protected $user_data;

        protected $pending_teacher_groups;
        protected $pending_student_groups;
        protected $approved_teacher_groups;
        protected $approved_teacher_subjects;
        protected $approved_student_group;
        protected $approved_student_subject;
        protected $withdrawn_student_groups;
        protected $denied_student_groups;

        protected $dimat_i_topics;
        protected $dimat_i_topics_descriptions;
        protected $dimat_i_subtopics;
        protected $dimat_ii_topics;
        protected $dimat_ii_topics_descriptions;
        protected $dimat_ii_subtopics;

        /**
         * 
         * The contructor of the MainContentController class.
         * 
         * It will check the URI parameters if the group, topic or subject value is incorrect, then the user will be automatically rediected to the notifications page.
         * This contructor also assigns the members to default values.
         * 
         * @return void
        */
        protected function __construct(){
            $this->CheckURIParameters();
            
            $this->is_administrator = false; // Whether the user is the administrator, or not
            $this->user_data = []; // General user data
            $this->pending_teacher_groups = []; // The group numbers for which the user's teacher status is pending
            $this->pending_student_groups = []; // The group numbers and subject pairs for which the user's student status is pending
            $this->approved_teacher_groups = []; // The group numbers for which the user's teacher status is approved
            $this->approved_teacher_subjects = []; // The subject ids for which the user's teacher status is approved
            $this->approved_student_group = ""; // The group number for which the user's student status is approved
            $this->approved_student_subject = ""; // The subject id for which the user's student status is approved
            $this->withdrawn_student_groups = []; // The group numbers and subject pairs for which the user's student status is withdrawn
            $this->denied_student_groups = []; // The group numbers and subject pairs for which the user's student status is denied
            
            $this->form_token = $_SESSION["form_generated_token"]??"";

            // Discrete mathematics I. main topics
            $this->dimat_i_topics = [
                "Halmazok ??s m??veletek", 
                "Rel??ci??k alapvet?? defin??ci??i",
                "Rel??ci??k kompoz??ci??ja ??s homog??n rel??ci??k tulajdons??gai",
                "F??ggv??ny, mint rel??ci??",
                "Komplex sz??mok alapvet?? tulajdons??gai",
                "Komplex sz??mok trigonometrikus alakja",
                "Komplex sz??mok hatv??nyoz??sa ??s gy??kvon??s",
                "Binomi??lis t??tel ??s Vi??te- formul??k",
                "Gr??fok megszerkeszthet??s??ge"
            ];

            // Discrete mathematics I. subtopics
            $this->dimat_i_subtopics = array(
                0 => ["M??veletek halmazok k??z??tt"],
                1 => ["Rel??ci??k alapvet?? tulajdons??gai"],
                2 => ["Rel??ci??k kompoz??ci??ja", "Homog??n rel??ci??k tulajdons??gai", "Rel??ci?? k??sz??t??se"],
                3 => ["F??ggv??ny-e a rel??ci??", "Sz??rjekt??v, injekt??v ??s bijekt??v f??ggv??nyek"],
                4 => ["Komplex sz??mok alapvet?? tulajdons??gai", "Komplex sz??mok k??z??tti m??veletek"],
                5 => ["Komplex sz??m trigonometrikus alakja", "Komplex sz??mok szorz??sa ??s oszt??sa trigonometrikus alak seg??ts??g??vel"],
                6 => ["Komplex sz??mok hatv??nyoz??sa", "Komplex sz??mok gy??kvon??sa"],
                7 => ["A binomi??lis t??tel alkalmaz??sa", "Vi??te- formul??k alkalmaz??sa"],
                8 => ["Egyszer?? gr??f megszerkeszthet??s??ge", "P??ros gr??f megszerkeszthet??s??ge", "Fagr??f megszerkeszthet??s??ge", "Ir??ny??tott gr??f megszerkeszthet??s??ge"]
            );

            // Discrete mathematics I. topics explanation
            $this->dimat_i_topics_descriptions = [
                "Uni??, metszet, k??l??nbs??g, komplementer, szimmetrikus differencia", 
                "??rtelmez??si tartom??ny, ??rt??kk??szlet, megszor??t??s halmazra, inverz, k??p ??s ??sk??p",
                "Rel??ci??k kompoz??ci??ja; homog??n rel??ci?? tulajdons??gai: reflexivit??s, szimmetria, antiszimmetria, szigor?? antiszimmetria, tranzitivit??s, dichot??mia, trichot??mia, ekvivalencia ??s rendez??si rel??ci??",
                "F??ggv??nyek, injekci??, sz??rjekci??, bijekci??",
                "Komplex sz??mok alapm??veletei: ??sszead??s, kivon??s, szorz??s ??s oszt??s; komplex sz??m alapvet?? tulajdons??gai",
                "Komplex sz??m trigonometrikus alakj??nak megad??sa, komplex sz??m argumentuma, Moivre-azonoss??gok",
                "Hatv??nyoz??s ??s gy??kvon??s trigonometrikus alak seg??ts??g??vel",
                "A binomi??lis t??tel ??s Vi??te- formul??k alkalmaz??sa",
                "Egyszer?? gr??f, p??ros gr??f, fa, ir??ny??tott gr??f megszerkeszthet??s??ge"
            ];

            // Discrete mathematics II. main topics
            $this->dimat_ii_topics =  [
                "Marad??kos oszt??s ??s oszt??k sz??ma", 
                "Reduk??lt ??s teljes marad??krendszerek",
                "Euklideszi algoritmus", 
                "Line??ris kongruenci??k",
                "Line??ris diofantikus egyenletek",
                "K??nai marad??kt??tel",
                "Horner- elrendez??s haszn??lata", 
                "Polinomok oszt??sa ??s szorz??sa", 
                "Lagrange- ??s Newton-f??le interpol??ci??s polinomok"
            ];

            // Discrete mathematics II. subtopics
            $this->dimat_ii_subtopics = array(
                0 => ["Marad??kos oszt??sok", "Pozit??v sz??m pr??mfelbont??sa", "Pozit??v oszt??k sz??m??nak meghat??roz??sa", "Kongruens sz??m keres??se"],
                1 => ["Teljes marad??krendszer megad??sa reprezentat??v elemekkel", "Reduk??lt marad??krendszer megad??sa reprezentat??v elemekkel", "Euler-f??le f?? f??ggv??ny"],
                2 => ["Legnagyobb k??z??s oszt??, legkisebb k??z??s t??bbsz??r??s ??s az euklideszi algoritmus"],
                3 => ["Line??ris kongruenci??k megold??sa"],
                4 => ["Line??ris diofantikus egyenletek megold??sa", "Sz??m felbont??sa oszt??si felt??tellel"],
                5 => ["Line??ris kongruenciarendszerek megold??sa", "Olyan sz??m keres??se, amely k??l??nb??z?? sz??mokkal osztva k??l??nb??z?? marad??kot ad"],
                6 => ["Polinomok helyettes??t??si ??rt??k??nek meghat??roz??sa Horner- elrendez??ssel", "Els??fok?? polinommal val?? oszt??s ??s Horner- elrendez??s"],
                7 => ["Polinomok (marad??kos) oszt??sa a val??s sz??mtest felett", "Polinomok szorz??sa eg??szek felett"],
                8 => ["Lagrange- f??le interpol??ci??s polinom illeszt??se t??bb pontra", "Newton- f??le interpol??ci??s polinom illeszt??se t??bb pontra"]
            );

            // Discrete mathematics II. topics explanation
            $this->dimat_ii_topics_descriptions = [
                "Marad??kos oszt??sok, pozit??v sz??m pr??mfelbont??sa, pozit??v oszt??k sz??m??nak meghat??roz??sa, kongruens sz??m keres??se", 
                "Teljes marad??krendszer megad??sa reprezentat??v elemekkel, reduk??lt marad??krendszer megad??sa reprezentat??v elemekkel, Euler-f??le f?? f??ggv??ny",
                "Legnagyobb k??z??s oszt??, legkisebb k??z??s t??bbsz??r??s ??s az euklideszi algoritmus",
                "Line??ris kongruenci??k megold??sa",
                "Line??ris diofantikus egyenletek megold??sa",
                "K??nai marad??kt??tel alkalmaz??sa: line??ris kongruenciarendszerek megold??sa",
                "Polinomok helyettes??t??si ??rt??k??nek meghat??roz??sa Horner- elrendez??ssel",
                "Polinomok (marad??kos) oszt??sa ??s szorz??sa",
                "Lagrange- ??s Newton- f??le interpol??ci??s polinom illeszt??se t??bb pontra"
            ];
        }

        /**
         * 
         * This method returns whether the logged in user is an administrator, or not.
         * 
         * @return string Returns a string that can be either 1 or 0, where 0 means that the logged in user is not an administrator, and 1 means that the user is an administrator.
        */
        public function GetIsAdministrator(){ return $this->is_administrator; }

        /**
         * 
         * This method returns data about the user.
         * 
         * The returned data differs on the basis that the user is an administrator, or not.
         * For administrators this returns the neptun code, email address, password, is administrator attributes as a single record, since records are unique in the users table.
         * For non-administrators this returns the neptun code, email address, password, is administrator, user status, subject group, subject name and pending status attributes as a set of records, a user can teach multiple groups, but can be a student of only one group and only one subject.
         * 
         * @return array Returns an indexed array containing the data from the users table if the user is administrator, and the data from the joined version of the users and status_pending table if the user is not an administrator.
        */
        public function GetUserData(){ return $this->user_data; }

        /**
         * 
         * This method returns students for one of the logged in user's group.
         * 
         * @return array Returns an indexed array containing the neptun code, user status, subject group, subject name and pending status from the status_pending table for users that are students and who belong to the teacher's group.
        */
        public function GetStudents(){ return $this->pending_students; }

        /**
         * 
         * This method returns the subject name and group (pairs) where the user's teacher request is pending.
         * 
         * @return array Returns an indexed array containing the subject group and subject name (pairs) where the user's status is teacher and it is pending.
        */
        public function GetPendingTeacherGroups(){ return $this->pending_teacher_groups; }

        /**
         * 
         * This method returns the subject name and group (pairs) where the user's teacher request was approved.
         * 
         * @return array Returns an indexed array containing the subject group and subject name (pairs) where the user's status is teacher and it is approved.
        */
        public function GetApprovedTeacherGroups(){ return $this->approved_teacher_groups; }

        /**
         * 
         * This method returns the subject names where the user's teacher request was approved.
         * 
         * @return array Returns an indexed array containing the subject groups where the user's status is teacher and it is approved.
        */
        public function GetApprovedTeacherSubjects(){ return $this->approved_teacher_subjects; }

        /**
         * 
         * This method returns the subject names and groups (pairs) where the user's student request is pending.
         * 
         * @return array Returns an indexed array containing the subject groups and subject name (pairs) where the user's status is student and it is pending.
        */
        public function GetPendingStudentGroups(){ return $this->pending_student_groups; }

        /**
         * 
         * This method returns the group where the user's student request was approved.
         * 
         * @return string Returns the group for which the user's student status is approved.
        */
        public function GetApprovedStudentGroup(){ return $this->approved_student_group; }

        /**
         * 
         * This method returns the subject names where the user's student request was approved.
         * 
         * @return array Returns an indexed array containing the subject names where the user's status is student and it was approved.
        */
        public function GetApprovedStudentSubject(){ return $this->approved_student_subject; }

        /**
         * 
         * This method returns the subject names and groups (pairs) where the user's student request is withdrawn.
         * 
         * @return array Returns an indexed array containing the subject groups and subject name (pairs) where the user's status is student and it is withdrawn.
        */
        public function GetWithdrawnStudentGroups(){ return $this->withdrawn_student_groups; }

        /**
         * 
         * This method returns the subject names and groups (pairs) where the user's student request is denied.
         * 
         * @return array Returns an indexed array containing the subject groups and subject name (pairs) where the user's status is student and it is denied.
        */
        public function GetDeniedStudentGroups(){ return $this->denied_student_groups; }

        /**
         * 
         * This method sets the class's members previously introduced in the constructor.
         * 
         * @return void
        */
        protected function SetMembers(){
            if(isset($_SESSION["neptun_code"])){                
                $this->neptun_code = $_SESSION["neptun_code"];
                $model = new MainModel();
                $this->user_data = $model->GetUserData($this->neptun_code); // Here, the users and user_groups table will be joined, and all of the rows will be selected, where the neptun_code column contains the actual user's neptun code
                
                if(count($this->user_data) == 0){
                    header("Location: ./index.php");
                }else{
                    $this->is_administrator = $this->user_data[0]["is_administrator"] == "1";

                    if(!$this->is_administrator){
                        foreach($this->user_data as $key => $user_record){ // Iterating through the array containing the fetched rows
                            if($user_record["is_teacher"] == 1){ // The user's teacher rows
                                if($user_record["application_request_status"] == "APPROVED"){ // The user's approved teacher rows
                                    array_push($this->approved_teacher_groups, array("subject_id" => $user_record["subject_id"], "subject_group" => $user_record["group_number"]));
                                    if(!in_array($user_record["subject_id"],$this->approved_teacher_subjects)){
                                        array_push($this->approved_teacher_subjects, $user_record["subject_id"]);
                                    }
                                }else if($user_record["application_request_status"] == "PENDING"){ // The user's pending teacher rows
                                    array_push($this->pending_teacher_groups, array("subject_id" => $user_record["subject_id"], "subject_group" => $user_record["group_number"]));
                                }
                            }else{ // The user's student rows
                                if($user_record["application_request_status"] == "APPROVED"){  // The user's approved student rows
                                    $this->approved_student_group = $user_record["group_number"];
                                    $this->approved_student_subject = $user_record["subject_id"];
                                }else if($user_record["application_request_status"] == "PENDING"){  // The user's pending student rows
                                    array_push($this->pending_student_groups, array("subject_id" => $user_record["subject_id"], "subject_group" => $user_record["group_number"]));
                                }else if($user_record["application_request_status"] == "WITHDRAWN"){ // The user's withdrawn student rows
                                    array_push($this->withdrawn_student_groups, array("subject_id" => $user_record["subject_id"], "subject_group" => $user_record["group_number"]));
                                }else if($user_record["application_request_status"] == "DENIED"){ // The user's denied student rows
                                    array_push($this->denied_student_groups, array("subject_id" => $user_record["subject_id"], "subject_group" => $user_record["group_number"]));
                                }
                            }
                        }
                    }
                }
            }else{
                header("Location: ./index.php");
            }
        }

        /**
         * 
         * This method checks if the URI values for subject, topic and group keys are correct.
         * 
         * @return void
        */
        private function CheckURIParameters(){
            // Handling malicious user uri inputs.
            // The subject must be either i or ii.
            if(isset($_SESSION["subject"]) && $_SESSION["subject"] != ""){
                if($_SESSION["subject"] != "i" && $_SESSION["subject"] != "ii"){
                    header("Location: ./index.php?site=notifications");
                    exit();
                }
            }

            // The topic must be a numeric value, and it must be between 0 and 9 (inclusively).
            if(isset($_SESSION["topic"]) && $_SESSION["topic"] != ""){
                if(is_numeric($_SESSION["topic"])){
                    if(intval($_SESSION["topic"]) > 8 || intval($_SESSION["topic"]) < 0){
                        header("Location: ./index.php?site=notifications");
                        exit();
                    }
                }else{
                    header("Location: ./index.php?site=notifications");
                    exit();
                }
            }

            // The group must be a numeric value, and it must be 0 and 30 (inclusively).
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

            // The message type must be in the array of "sent", "received", or "deleted"
            if(isset($_SESSION["message_type"]) && $_SESSION["message_type"] != ""){
                if(!in_array($_SESSION["message_type"], ["sent","received","deleted"])){
                    header("Location: ./index.php?site=notifications");
                    exit();
                }
            }

            // The start at page must be a numeric value
            if(isset($_SESSION["start_at"]) && $_SESSION["start_at"] != ""){
                if(!is_numeric($_SESSION["start_at"])){
                    header("Location: ./index.php?site=notifications");
                    exit();
                }
            }
        }

        /**
         * This method will redirect the users to the given page if the session variable's value at the given key is not in the acceptable.
         * 
         * @param string $session_parameter_name The key of the session parameter we wish to check.
         * @param array $acceptable_values An array containing the acceptable values for the given session variable.
         * @param string $where_to The name of the page to redirect to, if the session variable was not appropriate.
         * 
         * @return void
         */
        protected function RedirectToIfWrongParam($session_parameter_name,  $acceptable_values, $where_to){
            if(isset($_SESSION[$session_parameter_name]) && !in_array($_SESSION[$session_parameter_name], $acceptable_values)){
                header("Location: ./index.php?site=$where_to");
                exit();
            }
        }

        /**
         * This method returns whether the user can apply to a group as a demonstrator, or as a student.
         *
         * If a user has penging status as a student for the first subject group, then they can apply to a group as a demonstrator, or as a student.
         * If a user is approved as a student for discrete mathematics I., then they can't apply to any group.
         * If a user is approved as a student for discrete mathematics II., then they can't apply to any group as a student, and can apply to discrete mathematics I. group as a teacher.
         * If a user is approved as a teacher for discrete mathematics II., then they can't apply to any group as a student.
         * In any other cases, the user can apply to a group as a demonstrator, or as a student.
         * 
         * @param array $pending_student_groups The groups for which the user's student status is pending.
         * @param string $approved_student_subject The subject name for which the user's student status is approved.
         * @param array $approved_teacher_subjects The subject names for which the user's teacher status is approved.
         * 
         * @return array Returns an array containing 3 booleans: if the group addition icon should be shown in the menu, if the user can apply to a group as a student, and if the user can apply to a group as a teacher.
         */
        static function GroupAdditionChecker($pending_student_groups, $approved_student_subject, $approved_teacher_subjects){
            $show_group_addition_menu = true;
            $can_add_group_for_dimat_i = true;
            $can_add_group_for_dimat_ii = true;
            $can_apply_to_dimat_i = true;
            $can_apply_to_dimat_ii = true;
        
            $pending_student_subject_ids = [];
            $no_group = false;

            foreach($pending_student_groups as $group_counter => $group_id_pair){
                if(!in_array($group_id_pair["subject_id"], $pending_student_subject_ids) && $group_id_pair["subject_id"] !== ""){
                    array_push($pending_student_subject_ids,$group_id_pair["subject_id"]);
                }
                if($group_id_pair["subject_id"] === ""){
                    $no_group = true;
                }
            }

            // If the user's student/teacher status is approved for Discrete mathematics II. (or this status is pending), then don't let them to apply to a group as a student
            if(    in_array("ii", $approved_teacher_subjects) 
                || "ii" === $approved_student_subject
                || in_array("ii", $pending_student_subject_ids)){
                $can_apply_to_dimat_i = false;
                $can_apply_to_dimat_ii = false;
                if(in_array("ii", $pending_student_subject_ids) || "ii" === $approved_student_subject){
                    $can_add_group_for_dimat_ii = false;
                }
            }

            if(in_array("i", $approved_teacher_subjects)){
                $can_apply_to_dimat_i = false;
            }


            // If the user's student status is approved for Discrete mathematics I. (or this status is pending), then don't show the group addition page
            if("i" === $approved_student_subject || in_array("i", $pending_student_subject_ids)){
                $show_group_addition_menu = false;
            }

            // Those, who couldn't apply to a desired group, should be able to do so later
            if($no_group){
                $show_group_addition_menu = true;
                $can_apply_to_dimat_i = true;
                $can_apply_to_dimat_ii = true;
            }

            return [$show_group_addition_menu, $can_apply_to_dimat_i, $can_apply_to_dimat_ii, $can_add_group_for_dimat_i, $can_add_group_for_dimat_ii];
        }
    }

?>