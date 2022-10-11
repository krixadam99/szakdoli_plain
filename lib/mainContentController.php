<?php
    /**
     * 
     * This is a controller class which defines the basic data that will be used on almost every page (except index, login and registration pages).
     * 
     * The controllers throughout the project (except those that belong to the index, login, or registration pages) will inherit the protected members, and the protected and public methods.
     * Since we need to know the neptun code, whether the user is an administrator, the students whose status is pending and approved belonging to this user, the groups and subjects for which the user's teacher and student status is pending and approved, so we will set these members here for each controller class. 
    */
    class MainContentController {
        private $is_administrator;
        private $neptun_code;
        private $user_data;
        private $all_pending_teacher;
        private $pending_students;
        private $pending_teacher_groups;
        private $approved_teacher_groups;
        private $approved_teacher_subjects;
        private $pending_student_groups;
        private $approved_student_groups;
        private $approved_student_subject;
        private $practice_results;

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
         * This contructor also aissgns the members to default values.
         * 
         * @return void
        */
        protected function __construct(){
            $this->CheckURIParameters();
            
            $this->is_administrator = false; // Whether the user is the administrator, or not
            $this->neptun_code = ""; // Neptun code
            $this->user_data = []; // User data
            $this->all_pending_teacher = []; // All of the pending teachers
            $this->pending_students = []; // All of the pending students that belong to the user
            $this->pending_teacher_groups = []; // The group numbers for which the user's teacher status is pending
            $this->approved_teacher_groups = []; // The group numbers for which the user's teacher status is approved
            $this->approved_teacher_subjects = []; // The subject ids for which the user's teacher status is approved
            $this->pending_student_groups = []; // The group numbers for which the user's student status is pending
            $this->approved_student_groups = []; // The group numbers for which the user's student status is approved
            $this->approved_student_subject = ""; // The subject ids for which the user's student status is approved
            $this->practice_results = []; // The results of the user for each practice task

            $this->dimat_i_topics = [
                "Halmazok és műveletek", 
                "Relációk alapvető definíciói",
                "Relációk kompozíciója és relációk tulajdonságai",
                "Függvény, mint reláció",
                "Komplex számok alapvető tulajdonságai",
                "Komplex számok trigonometrikus alakja",
                "Komplex számok hatványozása és gyökvonás",
                "Binomiális tétel és faktoriális",
                "Gráfok alapvető tulajdonságai",
                "Gráfok megszerkeszthetősége"
            ];

            $this->dimat_i_subtopics = array(
                0 => ["Műveletek halmazok között"],
                1 => ["Relációk alapvető tulajdonságai"],
                2 => ["Relációk kompozíciója", "Relációk tulajdonságai", "Reláció készítése"],
                3 => ["Függvény-e a reláció", "Szürjektív, injektív és bijektív függvények"],
                4 => ["Komplex számok alapvető tulajdonságai", "Komplex számok közötti műveletek"],
                5 => ["Komplex szám trigonometrikus alakja", "Komplex számok szorzása és osztása trigonometrikus alak segítségével"],
                6 => ["Komplex számok hatványozása", "Komplex számok gyökvonása"],
                7 => ["A binomiális tétel alkalmazása, polinomok kifejtése"],
                8 => ["Gráfok alapvető tulajdonságai"],
                9 => ["Gráfok megszerkeszthetősége"]
            );

            $this->dimat_i_topics_descriptions = [
                "Unió, metszet, különbség, komplementer, szimmetrikus differencia", 
                "Értelmezési tartomány, értékkészlet, megszorítás halmazra, inverz, kép és őskép",
                "Kompozíció, reflexivitás, szimmetria, antiszimmetria, asszimetria, tranzitivitás, dichotómia, trichotómia, ekvivalencia és rendezési reláció",
                "Függvények, injekció, szürjekció, bijekció",
                "Komplex számok alapműveletei: összeadás, kivonás, szorzás és osztás; komplex szám alapvető tulajdonságai; másodfokú egyenletek",
                "Komplex szám trigonometrikus alakjának megadása, komplex szám argumentuma, moivre-azonosságok",
                "Hatványozás és gyökvonás trigonometrikus alak segítségével",
                "Polinomok kifejtése, a binomiális tétel alkalmazása",
                "Fokszámok, komponensek száma, gráfok alapvető tulajdonságai",
                "Egyszerű gráf, páros gráf, fa, irányított gráf megszerkeszthetősége"
            ];

            $this->dimat_ii_topics =  [
                "Maradékos osztás és osztók száma", 
                "Redukált és teljes maradékrendszerek",
                "Eukleidészi algoritmus", 
                "Lineáris kongruenciák",
                "Lineáris diofantikus egyenletek",
                "Kínai maradéktétel",
                "Horner- rendezés használata", 
                "Polinomok osztása és szorzása", 
                "Lagrange- és Newton-féle interpolációs polinomok", 
                "Egyenletek gyökkeresése"
            ];

            $this->dimat_ii_subtopics = array(
                0 => ["Maradékos osztások", "Pozitív szám prímfelbontása", "Pozitív osztók számának meghatározása", "Kongruens szám keresése", "..."],
                1 => ["Teljes maradékrendszer megadása reprezentatív elemekkel", "Redukált maradékrendszer megadása reprezentatív elemekkel", "Euler-féle fí függvény"],
                2 => ["Legnagyobb közös osztó, legkisebb közös többszörös és az Eukleidészi algoritmus", "Kibővített Eukleidészi algoritmus"],
                3 => ["Lineáris kongruenciák megoldása", "Euler-Fermat és kis Fermat-tétel"],
                4 => ["Lineáris diofantikus egyenletek megoldása", "Szám felbontása osztási feltétellel"],
                5 => ["Lineáris kongruenciarendszerek megoldása", "Olyan szám keresése, amely különböző számokkal osztva különböző maradékot ad"],
                6 => ["Polinomok helyettesítési értékének meghatározása Horner- rendezéssel", "Elsőfokú polinommal való osztás és Horner- rendezés"],
                7 => ["Polinomok (maradékos) osztása a valós számtest felett", "Polinomok szorzása egészek felett"],
                8 => ["Lagrange- féle interpolációs polinom illesztése több pontra", "Newton- féle interpolációs polinom illesztése több pontra"],
                9 => ["..."]
            );

            $this->dimat_ii_topics_descriptions = [
                "Maradékos osztások, pozitív szám prímfelbontása, pozitív osztók számának meghatározása, kongruens szám keresése", 
                "Teljes maradékrendszer megadása reprezentatív elemekkel, redukált maradékrendszer megadása reprezentatív elemekkel, Euler-féle fí függvény",
                "Legnagyobb közös osztó, legkisebb közös többszörös és az Eukleidészi algoritmus, a kibővített Eukleidészi algoritmus",
                "Lineáris kongruenciák megoldása, az Euler-Fermat és kis Fermat-tétel",
                "Lineáris diofantikus egyenletek megoldása",
                "Kínai maradéktétel alkalmazása: lineáris kongruenciarendszerek megoldása",
                "Polinomok helyettesítési értékének meghatározása Horner- rendezéssel",
                "Polinomok (maradékos) osztása és szorzása",
                "Lagrange- és Newton- féle interpolációs polinom illesztése több pontra",
                "Viéte- formulák, Schönemann-Eisenstein és Gauss tétel, szimmetrikus és antiszimmetrikus egyenletek"
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
         * This method returns the logged in user's neptun code.
         * 
         * @return string Returns the logged in user's neptun code.
        */
        public function GetNeptunCode(){ return $this->neptun_code; }

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
         * This method returns all the pending teachers.
         * 
         * @return array Returns an indexed array containing the neptun code, subject name and subject group from the status_pending table for users that are teachers and whose request is pending.
        */
        public function GetPendingTeachers(){ return $this->all_pending_teacher; }

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
         * This method returns the subject names and groups (pairs) where the user's student request was approved.
         * 
         * @return array Returns an indexed array containing the subject groups and subject name (pairs) where the user's status is student and it was approved.
        */
        public function GetApprovedStudentGroups(){ return $this->approved_student_groups; }

        /**
         * 
         * This method returns the subject names where the user's student request was approved.
         * 
         * @return array Returns an indexed array containing the subject names where the user's status is student and it was approved.
        */
        public function GetApprovedStudentSubject(){ return $this->approved_student_subject; }

        /**
         * 
         * This method returns the practice results for the logged in user.
         * 
         * @return array Returns an associative array containing the practice results of the user who is a student and whose student status is approved.
        */
        public function GetPracticeResults(){ return $this->practice_results; }

        /**
         * 
         * This method sets the class's members.
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
                                if($user_record["pending_status"] == "0"){ // The user's approved teacher rows
                                    array_push($this->approved_teacher_groups, array("subject_name" => $user_record["subject_name"], "subject_group" => $user_record["subject_group"]));
                                    if(!in_array($user_record["subject_name"],$this->approved_teacher_subjects)){
                                        array_push($this->approved_teacher_subjects, $user_record["subject_name"]);
                                    }
                                    
                                    // The students for the given subject id - subject group pair
                                    $pending_students_per_subject_group = $model->GetStudents($user_record["subject_name"], $user_record["subject_group"]);
                                    array_push($this->pending_students, array("subject_name" => $user_record["subject_name"], "subject_group" => $user_record["subject_group"], "users" => array_values($pending_students_per_subject_group)));
                                }else if($user_record["pending_status"] == "1"){ // The user's pending teacher rows
                                    array_push($this->pending_teacher_groups, array("subject_name" => $user_record["subject_name"], "subject_group" => $user_record["subject_group"]));
                                }
                            }else{ // The user's student rows
                                if($user_record["pending_status"] == "0"){  // The user's approved student rows
                                    $practice_results = $model->GetPracticeResults($this->neptun_code)[0]??[];
                                    foreach($practice_results as $key => $value){
                                        if(is_int(strpos($key, "practice_task"))){
                                            $this->practice_results[$key] = $value;
                                        }
                                    }

                                    array_push($this->approved_student_groups, array("subject_name" => $user_record["subject_name"], "subject_group" => $user_record["subject_group"]));
                                    $this->approved_student_subject = $user_record["subject_name"];
                                }else if($user_record["pending_status"] == "1"){  // The user's pending student rows
                                    array_push($this->pending_student_groups, array("subject_name" => $user_record["subject_name"], "subject_group" => $user_record["subject_group"]));
                                }
                            }
                        }
                    }else{
                        // Administrators should only see the teachers whose status is currently pending
                        $this->all_pending_teacher = $model->GetPendingTeachers();
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
                    if(intval($_SESSION["topic"]) > 9 || intval($_SESSION["topic"]) < 0){
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
        protected function RedirectToIfWrongParam($session_parameter_name, $acceptable_values, $where_to){
            if(isset($_SESSION[$session_parameter_name]) && !in_array($_SESSION[$session_parameter_name], $acceptable_values)){
                header("Location: ./index.php?site=$where_to");
                exit();
            }
        }
    }

?>