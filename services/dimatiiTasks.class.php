<?php
    /**
     * This is a helper class which contains task generator functions related to Discrete Mathematics II..
     * 
    */
    class DimatiiTasks extends Task {        
        private $dimatii_subtasks_generator;

        /**
         * 
         * The contructor for DimatiiTasks class.
         * 
         * Here the inherited members will be set.
         * Based on the $topic parameter a new set of tasks will be generated,
         * 
         * @param string $topic The topic id for task generation.
         * 
         * @return void
         */
        public function __construct($topic){
            $this->task_descriptions = [];
            $this->task_solutions = [];
            $this->definitions = "";
            $this->solution_texts = [];
            $this->topic = $topic;
            $this->dimatii_subtasks_generator = new DimatiiSubtaskGenerator();
            mt_srand(time()); // Seeding the random number generator with the current time.
        }

        public function PracticePageTaskGeneration(){
            switch($this->topic){
                case "0":{
                    $this->CreateTaskOne();
                };
                break;
                case "1":{
                    $this->CreateTaskTwo();
                };
                break;
                case "2":{
                    $this->CreateTaskThree();
                };
                break;
                case "3":{
                    $this->CreateTaskFour();
                };
                break;
                case "4":{
                    $this->CreateTaskFive();
                };
                break;
                case "5":{
                    $this->CreateTaskSix();
                };
                break;
                case "6":{
                    $this->CreateTaskSeven();
                };
                break;
                case "7":{
                    $this->CreateTaskEight();
                };
                break;
                case "8":{
                    $this->CreateTaskNine();
                };
                break;
                default:break;
            }
        }

        /**
         * 
         * This function is responsible for creating the first set of tasks of Discrete Mathematics II. related to division, number of dividors and congruencies.
         * 
         * 4 types of subtask will be generated here (2 subtasks per type). These are: dividing whole numbers among whole numbers, and getting the quotients and residues, prime factorization for positive whole numbers, number of positive divisors for positive whole numbers and one example for 2 congruences to get a valid statement.
         * 
         * @return void
         */
        private function CreateTaskOne(){
            $divide_pairs = $this->dimatii_subtasks_generator->CreateSubtask("0", "0", 2);
            $prime_factorization_numbers = $this->dimatii_subtasks_generator->CreateSubtask("0", "1", 2);
            $positive_divisor_count_numbers = $this->dimatii_subtasks_generator->CreateSubtask("0", "2", 2);
            $congruency_pairs = $this->dimatii_subtasks_generator->CreateSubtask("0", "3", 2);

            // Adding the data to the task array.
            $task_array = array(
                "task_description" => "Old meg a következő osztással, osztók számával és kongruencia definíciójával kapcsolatos feladatokat!",
                "divide_pairs" => $divide_pairs["data"],
                "prime_factorization_numbers" => $prime_factorization_numbers["data"],
                "positive_divisor_count_numbers" => $positive_divisor_count_numbers["data"],
                "congruency_pairs" => $congruency_pairs["data"]
            );
            $this->task_descriptions = $task_array;

            //Solutions part:
            $solution_array = [
                "divide_pairs_solution" => $divide_pairs["solutions"],
                "prime_factorization_solution" => $prime_factorization_numbers["solutions"],
                "positive_divisor_count_solution" => $positive_divisor_count_numbers["solutions"],
                "congruence" => $congruency_pairs["data"]
            ];
            $this->task_solutions = $solution_array;

            $this->solution_texts = array(
                "prime_factorization_numbers" => $prime_factorization_numbers["printable_solutions"],
            );

            // The definitions related to division without remainder, canonical form and number of divisors, division with remainder and congruences
            $this->definitions = [
                "<div class=\"defined\">
                    <label class=\"definition_label\">
                        Osztás egészek körében maradék nélkül
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adottak a, b \u{2208} \u{2124} számok. Azt mondjuk, hogy az <b>a szám osztható b-vel</b>, vagy <b>b osztója a-nak</b>, vagy <b>b osztja az a</b>-t, ha létezik olyan <b>c \u{2208} \u{2124}</b> szám, hogy <b>b * c = a</b> (a többszöröse b-nek). 
                        Ha a osztható b-vel, akkor erre a <i>b</i> | <i>a</i> jelölést használjuk
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Oszthatóság tulajdonságai (ezek könnyen beláthatók az előbbi definíció felhasználásával):
                    </label>
                    <ul class=\"definition_list\">
                        <li><label>(\u{2200} a \u{2208} \u{2124}) : a | a (reflexivitás); </label></li>
                        <li><label>(\u{2200} a, b \u{2208} \u{2124}) : a | b \u{2227} b | a \u{2194} a = \u{00B1} b; </label></li>
                        <li><label>(\u{2200} a, b, c \u{2208} \u{2124}) : a | b \u{2227} b | c \u{2194} a | c (tranzitivitás); </label></li>
                        <li><label>(\u{2200} a, b, c \u{2208} \u{2124}) : a | b \u{2227} a | c \u{2194} a | b \u{00B1} c; </label></li>
                        <li><label>(\u{2200} a, b, c \u{2208} \u{2124}) : a | b \u{2227} a | b \u{00B1} c \u{2194} a | c; </label></li>
                        <li><label>(\u{2200} a, b, c \u{2208} \u{2124}) : a | b \u{2227} c | d \u{2194} a * c | b * d; </label></li>
                        <li><label>(\u{2200} a, b, c \u{2208} \u{2124}) : a | b \u{2194} a | b * c. </label></li>
                    </ul>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Keressük meg azokat a számokat, amelyek osztják a 0, azaz olyan <i>a</i> egészeket, amelyekre teljesül, hogy (c \u{2208} \u{2124}) : a * c = 0. Természetesen bármely a egész esetén ott van a 0, mint egész, amellyel az egészet megszorozva 0-t kapjunk, vagyis <b>minden egész szám osztója a 0-nak</b>.
                        Most keressük meg azokat a számokat, amelyeknek osztója a 0, azaz olyan <i>a</i> egészeket, amelyekre teljesül, hogy (c \u{2208} \u{2124}) : 0 * c = a. Itt a bal oldal mindig 0, így csak az a = 0 esetén kapunk egyenlőséget, vagyis <b>a 0 csak a 0-nak osztója</b>.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Keressük meg azokat a számokat, amelyek osztják az 1-gyet, azaz olyan <i>a</i> egészeket, amelyekre teljesül, hogy (c \u{2208} \u{2124}) : a * c = 1. Látható, hogy ekkor az egészek körében csak az 1 és -1 esetén lesz ilyen c egész szám. Tehát <b>csak \u{00B1} 1 osztója az 1-nek</b>.
                        Most keressük meg azokat a számokat, amelyeknek osztója a \u{00B1}1, azaz olyan <i>a</i> egészeket, amelyekre teljesül, hogy (c \u{2208} \u{2124}) : \u{00B1}1 * c = a. Ha c = a, akkor mindig teljesül az egyenlőség, tehát <b>bármely számnak osztója a \u{00B1}1</b>.
                        <b>Az egység egy olyan szám, amely bármely másik számnak osztója.</b> Ezért a \u{00B1}1-et egységnek nevezzük. Egészek körében csak ezek az egységek (ugyanis 1-nél nagyobb <i>a</i> egészek estén nincsen olyan <i>c</i> egész szám, hogy azzal megszorozva <i>a</i>-t pl.: 1-et kapjunk).
                        <b>Két számot egymás asszociáltjának nevezzük, ha egymás egységszorosai.</b>
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        A p \u{2208} \u{2124} számot <b>prím</b>nek (vagy törzsszámnak) nevezzük amennyiben teljesül rá, hogy <b>p = a * b  \u{2192} p = a  \u{2228} p = b (a, b \u{2208} \u{2124})</b>.
                        <b>A felbonthatatlan (irreducibilis) szám olyan szám, amelynek az egység(ek)en és az asszociáltakon kívül nincsen más osztója.</b> 
                        Egészek körében az is igaz, hogy a prímszámoknak nincsen az egységeken és asszociáltjukon kívül más osztójuk, így felbonthatatlan számok.
                        A 0-nak végtelen sok osztója van, a \u{00B1}1-nek pedig csak az asszociáltjaik. Összetett számnak nevezzük az olyan egész számokat, amelyek nem prímszámok, nem az egységek és nem 0. 
                    </label>
                </div>",
                "<div class=\"defined\">
                    <label class=\"definition_label\">
                        Maradékos osztás egészek körében
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adottak az a, b \u{2208} \u{2124} számok. A feladat az, hogy osszuk el az a-t maradékosan a b-vel az egészek körében.
                        Ekkor az <b>a = q * b + r</b> alakot tudjuk felírni, amelyben q a kvóciens (hányados) és r a maradék. Míg a <b>q egy egész</b>, addig r-re ennél több megkötést teszünk.
                        A maradékra teljesülnie kell a <b>0 \u{2264} r < |b|</b> egyenlőtlenségnek is (b természetesen nem lehet 0). Ha az <b>r = 0</b>, akkor visszakapjuk a maradék nélküli oszthatóság képletét, ekkor <b>b | a</b>.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adottak a, b \u{2208} \u{2124} és m \u{2208} \u{2124}<span class=\"exp\">\u{2265}2</span>. Azt mondjuk, hogy az a és b szám kongruens egymással m modulusra, ha ugyanazt a maradékot adják az m-mel való maradékos osztás során.
                        Ezt <i> a \u{2263} b (mod m)</i> fogjuk jelölni. Legyen a és b kongruens m-mel osztva.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adottak a, b \u{2208} \u{2124} és m \u{2208} \u{2124}<span class=\"exp\">\u{2265}2</span>.
                        Legyen a és b kongruens m-mel osztva. Ekkor korábbi definíciónk szerint a = q<span class=\"bottom\">a</span> * m + r és b = q<span class=\"bottom\">b</span> * m + r.
                        Vegyük a két egyenlet különbségét, azaz a - b = q<span class=\"bottom\">a</span> * m + r - q<span class=\"bottom\">b</span> * m - r = (q<span class=\"bottom\">a</span> - q<span class=\"bottom\">b</span>) * m. 
                        Mivel a q<span class=\"bottom\">a</span> és q<span class=\"bottom\">b</span> egészek, így a különbségük is az, ezért létezik olyan egész, amellyel m-et megszorozva a - b-t kapunk, azaz m | a - b.
                        Röviden: <b>a \u{2263} b (mod m) \u{2194} a = b + m * k (k \u{2208} \u{2124}) \u{2194}  m | a - b</b>.
                    </label>
                </div>",
                "<div class=\"defined\">
                    <label class=\"definition_label\">
                        Kanonikus alak, osztók száma és prímfelbontás
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Számelmélet alaptétele: bármely nem-nulla, nem egység egész szám felbontható prímszámok szorzatára, ahol a sorrendtől, az egységektől, valamint az asszociáltaktól eltekintve a felbontás egyértelmű (létezés és egyértelműség).
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Legyen a \u{2208} \u{2124} \ {-1, 0, 1}, ekkor az előző szerint a = \u{220F}<span class=\"exp\">m</span><span class=\"bottom\">i=1</span>p<span class=\"bottom\">i</span><span class=\"exp\">\u{03B1}<span class=\"bottom\">i</span></span> (m \u{2265} 1, (i \u{2208} {1,...,m} \u{2282} \u{2115}): \u{2124}<span class=\"exp\">+</span> \u{220B} p<span class=\"bottom\">i</span> páronként különböző prím \u{2227} \u{03B1}<span class=\"bottom\">i</span> \u{2265} 0 (a prímszám előfordulása a prímfelbontásban)). Ezt nevezzük az a szám <b>kanonikus felbontásának</b>.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Legyen a \u{2208} \u{2124} \ {-1, 0, 1}. Előbbi szerint: a = \u{220F}<span class=\"exp\">m</span><span class=\"bottom\">i=1</span>p<span class=\"bottom\">i</span><span class=\"exp\">\u{03B1}<span class=\"bottom\">i</span></span> (m \u{2265} 1, (i \u{2208} {1,...,m} \u{2282} \u{2115}): \u{2124}<span class=\"exp\">+</span> \u{220B} p<span class=\"bottom\">i</span> páronként különböző prím \u{2227} \u{03B1}<span class=\"bottom\">i</span> \u{2265} 0 (a prímszám előfordulása a prímfelbontásban)).
                        Ekkor az a szám pozitív osztóinak számát egy egyszerű variációval megkapjuk. A kanonikus alakban lévő kitevőket változtatva, különböző osztókat kapunk meg. Ezeken túl pedig más osztó nem lehetséges, mivel a prímfelbontás egyértelmű. Így pedig az <b>összes pozitív osztó száma: d(a) =  \u{220F}<span class=\"exp\">m</span><span class=\"bottom\">i=1</span>(\u{03B1}<span class=\"bottom\">i</span> + 1)</b> (ahol \u{03B1}<span class=\"bottom\">i</span> \u{2265} 0 (a prímszám előfordulása a prímfelbontásban).
                    </label>
                </div>"
            ];
        }

        /**
         * 
         * This function is responsible for creating the second set of tasks of Discrete Mathematics II. related to residue systems.
         * 
         * Subtasks related to residue systems:
         * Giving the residue classes with a representative element for a complete residue system modulo n;
         * Giving the residue classes with a representative element for a reduced residue system modulo n;
         * Giving the size of a reduced residue system modulo n (where n is considerably big).
         * 
         * @return void
         */
        private function CreateTaskTwo(){    
            // Task creation part:
            // 2 numbers for complete residue system subtask (1 number/ subtask);
            // 2 numbers for reduced residue system subtask (1 number/ subtask);
            // 2 numbers for reduced residue system size subtask (1 number/ subtask);
            $crs_numbers = $this->dimatii_subtasks_generator->CreateSubtask("1", "0", 1);
            $rrs_numbers = $this->dimatii_subtasks_generator->CreateSubtask("1", "1", 1);
            $rrs_size_numbers = $this->dimatii_subtasks_generator->CreateSubtask("1", "2", 2);

            // Adding the data to the task array.
            $task_array = array(
                "task_description" => "Old meg a következő maradékrendszerekkel kapcsolatos feladatokat!",
                "crs_numbers" => $crs_numbers["data"],
                "rrs_numbers" => $rrs_numbers["data"],
                "rrs_size_numbers" => $rrs_size_numbers["data"]
            );
            $this->task_descriptions = $task_array;

            //Solutions part:
            $solution_array = [
                "crs_systems" => $crs_numbers["solutions"][0],
                "rrs_systems" => $rrs_numbers["solutions"][0],
                "rrs_size_numbers" => $rrs_size_numbers["solutions"]
            ];
            $this->task_solutions = $solution_array;
        }

        /**
         * 
         * This function is responsible for creating the third set of tasks of Discrete Mathematics II. related to Eucleidan algorithm.
         * 
         * Subtasks related to Eucleidan algorithm:
         * Creating 3 distinct pairs of numbers for which we want to determine the gcd with the Eucleidan algorithm;
         * Creating 1 pair for which the student will have to determine the extended eucleidan algorithm.
         * 
         * @return void
         */
        private function CreateTaskThree(){
            // Task creation part:
            // 3 pairs of numbers for gcd (1 pair of numbers/ subtask);
            $gcd_pairs = $this->dimatii_subtasks_generator->CreateSubtask("2", "0", 3);
            
            // 1 pair of numbers for extended eucleidan algorithm (1 pair of numbers/ subtask)

            $step_counts = [];
            foreach($gcd_pairs["solutions"][0] as $pair_counter => $algorithm){
                array_push($step_counts, count($algorithm));
            }

            // Adding the data to the task array.
            $task_array = array(
                "task_description" => "Old meg a következő Eukleidészi algoritmussal kapcsolatos feladatokat!",
                "gcd_pairs" => $gcd_pairs["data"],
                "step_counts" => $step_counts
            );
            $this->task_descriptions = $task_array;

            //Solutions part:
            $solution_array = [
                "eucleidan_algorithm" => $gcd_pairs["solutions"][0],
                "gcd" => $gcd_pairs["solutions"][1],
                "lcm" => $gcd_pairs["solutions"][2] 
            ];
            $this->task_solutions = $solution_array;
        }

        /**
         * 
         * This function is responsible for creating the fourth set of tasks of Discrete Mathematics II. related to linear congruences.
         * 
         * Subtasks related to linear congruences:
         * Creating 3 distinct triplets containing non-zero whole numbers representing congruences, where the modulo is positive, for the linear congruences subtask.
         * Creating 2 distinct pairs of numbers for Euler-Fermat theorem subtask.
         * 
         * @return void
         */
        private function CreateTaskFour(){
            // Task creation part:
            // 3 distinct triplets of numbers for linear congruences (1 triplet of numbers/ subtask).
            $linear_congrences = $this->dimatii_subtasks_generator->CreateSubtask("3","0",3);

            // 2 pairs of numbers for Euler-Fermat theorem (1 pair of numbers/ subtask).

            // 1 pair of numbers for raising to power with the rapid algorithm.

            // Adding the data to the task array.
            $task_array = array(
                "task_description" => "Old meg a következő lineáris kongruenciákkal kapcsolatos feladatokat!",
                "linear_congrences" => $linear_congrences["data"],
            );
            $this->task_descriptions = $task_array;

            //Solutions part:
            $solution_array = [
                "linear_congruences" => $linear_congrences["solutions"][0], 
                "solutions" => $linear_congrences["solutions"][1],
            ];
            $this->task_solutions = $solution_array;
        }

        /**
         * 
         * This function is responsible for creating the fifth set of tasks of Discrete Mathematics II. related to linear diophantine equations.
         * 
         * Subtasks related to linear diophantine equations:
         * Creating 1 triplet containing whole numbers that are at least 2, for partitioning a number into smaller numbers.
         * Creating 2 distinct triplets of numbers for diophantine equations. These triplets represent congruences, that are solvable.
         * 
         * @return void
         */
        private function CreateTaskFive(){
            // Task creation part:
            // 1 triplet of numbers of whole numbers at least 2 for artitioning a number into smaller numbers (1 triplet of numbers/ subtask).
            // 2 triplet of numbers of whole numbers between -50 and 50 representing congruences, that are solvable (1 triplet of numbers/ subtask).
            $diophantine_equations = $this->dimatii_subtasks_generator->CreateSubtask("4", "0", 2); // ax \equiv b (mod c)
            $third_subtask = $this->dimatii_subtasks_generator->CreateSubtask("4", "1", 1);

            // Adding the data to the task array.
            $task_array = array(
                "task_description" => "Old meg a következő diofantoszi egyenletekkel kapcsolatos feladatokat!",
                "diophantine_equations" => $diophantine_equations["data"],
                "partition_number" => $third_subtask["data"][0]
            );
            $this->task_descriptions = $task_array;

            array_push($diophantine_equations["solutions"], $third_subtask["solutions"][0]);
            //Solutions part:
            $solution_array = [
                "diophantine_equations" => $diophantine_equations["solutions"],
            ];
            $this->task_solutions = $solution_array;
        }

        /**
         * 
         * This function is responsible for creating the sixth set of tasks of Discrete Mathematics II. related to chinese remainder theorem.
         * 
         * Subtasks related to chinese remainder theorem:
         * Creating 1 triplet containing whole numbers that are at least 2, for getting numbers that satisfy 2 simultaneous congruences.
         * Creating 1 triplet containing whole numbers that are between -50 and 50, for getting numbers that satisfy 4 simultaneous congruences.
         * 
         * @return void
         */
        private function CreateTaskSix(){
            // Task creation part:
            // 1 triplet of whole numbers that are at least 2 representing congruences for getting numbers that satisfy 2 simultaneous congruences (1 triplet of numbers/ subtask).
            // 1 triplet of whole numbers that are between -50 and 50 representing congruences for getting numbers that satisfy 4 simultaneous congruences (1 triplet of numbers/ subtask).
            $first_congruence_system_triplets = $this->dimatii_subtasks_generator->CreateSubtask("5", "1", 1);
            $second_congruence_system_triplets = $this->dimatii_subtasks_generator->CreateSubtask("5", "0", 1);

            // Adding the data to the task array.
            $task_array = array(
                "task_description" => "Old meg a következő kínai maradékrendszerrel kapcsolatos feladatokat!",
                "divide_triplets" => $first_congruence_system_triplets["data"][0],
                "first_congruence_system_triplets" => $first_congruence_system_triplets["data"][0],
                "second_congruence_system_triplets" => $second_congruence_system_triplets["data"][0]
            );
            $this->task_descriptions = $task_array;

            //Solutions part:
            $solution_array = [
                "first_crt_solution" => $first_congruence_system_triplets["solutions"][0],
                "second_crt_solution" => $second_congruence_system_triplets["solutions"][0],
            ];
            $this->task_solutions = $solution_array;
        }

        /**
         * 
         * This function is responsible for creating the seventh set of tasks of Discrete Mathematics II. related to horner table.
         * 
         * Subtasks related to horner's scheme:
         * Creating 2 polynomial expressions and picking whole numbers from the range -20 and 20, where the first is of degree 2, and the second is of degree 4. The number of inputs for polynomial expression is the same as its degree.
         * Creating 1 polynomial expression of degree 5 and picking a whole number from the range -20 and 20. 
         *
         * @return void
         */
        private function CreateTaskSeven(){
            // Creating 2 polynomials with degree of 2 and 4.
            // Picking 2 and 4 wole numbers from the range of -10 and 10, where for the first case 0, for the second case 2 needs to be actual roots of the first and second polynomial expressions respectively.
            $horner_schemes_first = $this->dimatii_subtasks_generator->CreateSubtask("6", "0", 2);
           
            // Creating 1 polynomial.
            // Creating 1 input between -10 and 10.
            $horner_schemes_second = $this->dimatii_subtasks_generator->CreateSubtask("6", "1", 1);

            // Task array declaration.
            $task_array = array(
                "task_description" => "Old meg a következő Horner-táblázattal kapcsolatos feladatokat!",
                "polynomials" => $horner_schemes_first["data"],
                "divide_polynomials" => $horner_schemes_second["data"][0]
            );

            // Adding data to the task array.
            $this->task_descriptions = $task_array;

            //Solutions part:
            $solution_array = [
                "first_horner_scheme" => $horner_schemes_first["solutions"][0],
                "second_horner_scheme" => $horner_schemes_first["solutions"][1],
                "third_horner_scheme" => [$horner_schemes_second["data"][0][2], $horner_schemes_second["solutions"][0]],
            ];
            $this->task_solutions = $solution_array;
        }

        /**
         * 
         * This function is responsible for creating the eight set of tasks of Discrete Mathematics II. related to polinomial division and multiplication.
         * 
         * Subtasks related to polinomial division and multiplication:
         * Creating 2 polynomial expressions for polynomial division. The first one's degree is between 3 and 5.
         * Creating 2 polynomial expression for polynomial multiplication. The second one's degree is between 1 and 3.
         * 
         * @return void
         */
        private function CreateTaskEight(){
            $polynomial_division_subtask = $this->dimatii_subtasks_generator->CreateSubtask("7", "0", 1);
            $polynomial_multiplication_subtask = $this->dimatii_subtasks_generator->CreateSubtask("7", "1", 1);
            
            $task_array = array(
                "task_description" => "Old meg a következő polinomok osztásával és szorzásával kapcsolatos feladatokat!",
                "divide_polynomials" => $polynomial_division_subtask["data"][0],
                "multiply_polynomials" => $polynomial_multiplication_subtask["data"][0],
            );

            // Adding data to the task array.
            $this->task_descriptions = $task_array;

            //Solutions part:
            $solution_array = [
                "polynomial_division" => $polynomial_division_subtask["solutions"][0],
                "polynomial_multiplication" => $polynomial_multiplication_subtask["solutions"][0]
            ];

            $this->task_solutions = $solution_array;
        }

        /**
         * 
         * This function is responsible for creating the ninth set of tasks of Discrete Mathematics II. related to interpolations.
         * 
         * ...Subtasks created here...
         * 
         * @return void
         */
        private function CreateTaskNine(){
            $lagrange_interpolation = $this->dimatii_subtasks_generator->CreateSubtask("8", "0", 1);
            $newton_interpolation = $this->dimatii_subtasks_generator->CreateSubtask("8", "1", 1);
            
            $task_array = array(
                "task_description" => "Old meg a következő Lagrange- és Newton- féle interpolációkkal kapcsolatos feladatokat!",
                "lagrange_points" => $lagrange_interpolation["data"][0],
                "newton_points" => $newton_interpolation["data"][0],
            );
                       
            // Adding data to the task array.s
            $this->task_descriptions = $task_array;

            //Solutions part:
            $solution_array = [
                "Lagrange_interpolation" => $lagrange_interpolation["solutions"][0],
                "Newton_interpolation" => $newton_interpolation["solutions"][0]
            ];

            $this->task_solutions = $solution_array;
        }
    }
?>