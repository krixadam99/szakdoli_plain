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
                "Halmazok és műveletek", 
                "Relációk alapvető definíciói",
                "Relációk kompozíciója és homogén relációk tulajdonságai",
                "Függvény, mint reláció",
                "Komplex számok alapvető tulajdonságai",
                "Komplex számok trigonometrikus alakja",
                "Komplex számok hatványozása és gyökvonás",
                "Binomiális tétel és Viète- formulák",
                "Gráfok megszerkeszthetősége"
            ];

            // Discrete mathematics I. subtopics
            $this->dimat_i_subtopics = array(
                0 => ["Műveletek halmazok között"],
                1 => ["Relációk alapvető tulajdonságai"],
                2 => ["Relációk kompozíciója", "Homogén relációk tulajdonságai", "Reláció készítése"],
                3 => ["Függvény-e a reláció", "Szürjektív, injektív és bijektív függvények"],
                4 => ["Komplex számok alapvető tulajdonságai", "Komplex számok közötti műveletek"],
                5 => ["Komplex szám trigonometrikus alakja", "Komplex számok szorzása és osztása trigonometrikus alak segítségével"],
                6 => ["Komplex számok hatványozása", "Komplex számok gyökvonása"],
                7 => ["A binomiális tétel alkalmazása", "Viète- formulák alkalmazása"],
                8 => ["Egyszerű gráf megszerkeszthetősége", "Páros gráf megszerkeszthetősége", "Fagráf megszerkeszthetősége", "Irányított gráf megszerkeszthetősége"]
            );

            // Discrete mathematics I. topics explanation
            $this->dimat_i_topics_descriptions = [
                "Unió, metszet, különbség, komplementer, szimmetrikus differencia", 
                "Értelmezési tartomány, értékkészlet, megszorítás halmazra, inverz, kép és őskép",
                "Relációk kompozíciója; homogén reláció tulajdonságai: reflexivitás, szimmetria, antiszimmetria, szigorú antiszimmetria, tranzitivitás, dichotómia, trichotómia, ekvivalencia és rendezési reláció",
                "Függvények, injekció, szürjekció, bijekció",
                "Komplex számok alapműveletei: összeadás, kivonás, szorzás és osztás; komplex szám alapvető tulajdonságai",
                "Komplex szám trigonometrikus alakjának megadása, komplex szám argumentuma, Moivre-azonosságok",
                "Hatványozás és gyökvonás trigonometrikus alak segítségével",
                "A binomiális tétel és Viète- formulák alkalmazása",
                "Egyszerű gráf, páros gráf, fa, irányított gráf megszerkeszthetősége"
            ];

            // Discrete mathematics II. main topics
            $this->dimat_ii_topics =  [
                "Maradékos osztás és osztók száma", 
                "Redukált és teljes maradékrendszerek",
                "Euklideszi algoritmus", 
                "Lineáris kongruenciák",
                "Lineáris diofantikus egyenletek",
                "Kínai maradéktétel",
                "Horner- elrendezés használata", 
                "Polinomok osztása és szorzása", 
                "Lagrange- és Newton-féle interpolációs polinomok"
            ];

            // Discrete mathematics II. subtopics
            $this->dimat_ii_subtopics = array(
                0 => ["Maradékos osztások", "Pozitív szám prímfelbontása", "Pozitív osztók számának meghatározása", "Kongruens szám keresése"],
                1 => ["Teljes maradékrendszer megadása reprezentatív elemekkel", "Redukált maradékrendszer megadása reprezentatív elemekkel", "Euler-féle fí függvény"],
                2 => ["Legnagyobb közös osztó, legkisebb közös többszörös és az euklideszi algoritmus"],
                3 => ["Lineáris kongruenciák megoldása"],
                4 => ["Lineáris diofantikus egyenletek megoldása", "Szám felbontása osztási feltétellel"],
                5 => ["Lineáris kongruenciarendszerek megoldása", "Olyan szám keresése, amely különböző számokkal osztva különböző maradékot ad"],
                6 => ["Polinomok helyettesítési értékének meghatározása Horner- elrendezéssel", "Elsőfokú polinommal való osztás és Horner- elrendezés"],
                7 => ["Polinomok (maradékos) osztása a valós számtest felett", "Polinomok szorzása egészek felett"],
                8 => ["Lagrange- féle interpolációs polinom illesztése több pontra", "Newton- féle interpolációs polinom illesztése több pontra"]
            );

            // Discrete mathematics II. topics explanation
            $this->dimat_ii_topics_descriptions = [
                "Maradékos osztások, pozitív szám prímfelbontása, pozitív osztók számának meghatározása, kongruens szám keresése", 
                "Teljes maradékrendszer megadása reprezentatív elemekkel, redukált maradékrendszer megadása reprezentatív elemekkel, Euler-féle fí függvény",
                "Legnagyobb közös osztó, legkisebb közös többszörös és az euklideszi algoritmus",
                "Lineáris kongruenciák megoldása",
                "Lineáris diofantikus egyenletek megoldása",
                "Kínai maradéktétel alkalmazása: lineáris kongruenciarendszerek megoldása",
                "Polinomok helyettesítési értékének meghatározása Horner- elrendezéssel",
                "Polinomok (maradékos) osztása és szorzása",
                "Lagrange- és Newton- féle interpolációs polinom illesztése több pontra"
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