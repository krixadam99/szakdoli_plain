<?php
    /**
     * This is a helper class which contains task generator functions related to Discrete Mathematics II..
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

        /**
         * 
         * This method is responsible for creating a set of tasks based on the selected topic number.
         *  
         * @return void
         */
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
         * This method is responsible for creating the first set of tasks of Discrete Mathematics II. related to division, number of dividors and congruencies.
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
                        <li><label>(\u{2200} a, b, c \u{2208} \u{2124}) : a | b \u{2227} a | b \u{00B1} c \u{2192} a | c; </label></li>
                        <li><label>(\u{2200} a, b, c \u{2208} \u{2124}) : a | b \u{2227} c | d \u{2192} a * c | b * d; </label></li>
                        <li><label>(\u{2200} a, b, c \u{2208} \u{2124}) : a | b \u{2192} a | b * c. </label></li>
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
                        Ekkor egyértelműen tudunk adni olyan q és r számokat, hogy <b>a = q * b + r ((r \u{2208} \u{2124}): 0 \u{2264} r < |b| \u{2227} q \u{2208} \u{2124})</b>.
                        A q a kvóciens (hányados), az r a maradék.
                        Ha az <b>r = 0</b>, akkor visszakapjuk a maradék nélküli osztás képletét, ekkor <b>b | a</b>.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adottak a, b \u{2208} \u{2124} és m \u{2208} \u{2124}<sup>\u{2265}2</sup>. Azt mondjuk, hogy az a és b szám kongruens egymással m modulusra, ha ugyanazt a maradékot adják az m-mel való maradékos osztás során.
                        Ezt <i> a \u{2263} b (mod m)</i> fogjuk jelölni. Legyen a és b kongruens m-mel osztva.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adottak a, b \u{2208} \u{2124} és m \u{2208} \u{2124}<sup>\u{2265}2</sup>.
                        Legyen a és b kongruens m-mel osztva. Ekkor korábbi definíciónk szerint a = q<sub>a</sub> * m + r és b = q<sub>b</sub> * m + r.
                        Vegyük a két egyenlet különbségét, azaz a - b = q<sub>a</sub> * m + r - q<sub>b</sub> * m - r = (q<sub>a</sub> - q<sub>b</sub>) * m. 
                        Mivel a q<sub>a</sub> és q<sub>b</sub> egészek, így a különbségük is az, ezért létezik olyan egész, amellyel m-et megszorozva a - b-t kapunk, azaz m | a - b.
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
                        Legyen a \u{2208} \u{2124} \ {-1, 0, 1}, ekkor az előző szerint a = \u{220F}<sup>m</sup><sub>i=1</sub>p<sub>i</sub><sup>\u{03B1}<sub>i</sub></sup> (m \u{2265} 1, (i \u{2208} {1,...,m} \u{2282} \u{2115}): \u{2124}<sup>+</sup> \u{220B} p<sub>i</sub> páronként különböző prím \u{2227} \u{03B1}<sub>i</sub> \u{2265} 0 (a prímszám előfordulása a prímfelbontásban)). Ezt nevezzük az a szám <b>kanonikus felbontásának</b>.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Legyen a \u{2208} \u{2124} \ {-1, 0, 1}. Előbbi szerint: a = \u{220F}<sup>m</sup><sub>i=1</sub>p<sub>i</sub><sup>\u{03B1}<sub>i</sub></sup> (m \u{2265} 1, (i \u{2208} {1,...,m} \u{2282} \u{2115}): \u{2124}<sup>+</sup> \u{220B} p<sub>i</sub> páronként különböző prím \u{2227} \u{03B1}<sub>i</sub> \u{2265} 0 (a prímszám előfordulása a prímfelbontásban)).
                        Ekkor az a szám pozitív osztóinak számát egy egyszerű variációval megkapjuk. A kanonikus alakban lévő kitevőket változtatva, különböző osztókat kapunk meg. Ezeken túl pedig más osztó nem lehetséges, mivel a prímfelbontás egyértelmű. Így pedig az <b>összes pozitív osztó száma: d(a) =  \u{220F}<sup>m</sup><sub>i=1</sub>(\u{03B1}<sub>i</sub> + 1)</b> (ahol \u{03B1}<sub>i</sub> \u{2265} 0 (a prímszám előfordulása a prímfelbontásban).
                    </label>
                </div>"
            ];
        }

        /**
         * 
         * This method is responsible for creating the second set of tasks of Discrete Mathematics II. related to residue systems.
         * 
         * 3 types of subtask will be generated here (1, 1 and 2 subtasks respectively). These are: residue classes with a representative element for a complete residue system modulo n, residue classes with a representative element for a reduced residue system modulo n, size of a reduced residue system modulo n (where n is considerably big).
         * 
         * @return void
         */
        private function CreateTaskTwo(){    
            // Task creation part:
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

            // The definitions related to complete residue system, reduced residue system and Euler's phi function
            $this->definitions = [
                "<div class=\"defined\">
                    <label class=\"definition_label\">
                        Teljes és redukált maradékrendszerek
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Legyen \u{2124} \u{220B} n \u{2265} 2. Ekkor definiáljuk a ~ relációt a következő képpen: ~ \u{2286} \u{2124} \u{00D7} \u{2124}, ~ := { (a, b) \u{2208} \u{2124} \u{00D7} \u{2124} | n | a - b}, azaz pontosan akkor van (a, b) rendezett pár benne a ~ relációban, ha azonos maradékot adnak n-nel osztva (azaz kongruensek modulo n).
                        Ez a reláció ekvivalencia reláció (ezt a kongruenciák tulajdonságainál (4. téma) látjuk be), így meghatározhatunk egy osztályozást. 
                        Jelöljük a <span style=\"text-decoration: overline\">a</span>-val azt a halmazt, amely azokat az elemeket tartalmazza, melyek n-nel osztva a maradékot adnak, azaz <span style=\"text-decoration: overline\">a</span> = { b \u{2208} \u{2124} | n | a - b} = { ..., a - n, a, a + n, ...} = a + n * \u{2124} (az n * \u{2124} helyett használható az n * k (k \u{2208} \u{2124} jelölés is)). Ezt <b>maradékosztálynak</b> nevezzük.
                        Ekkor egy osztályozást határoz meg az egész számokon a következő szuperhalmaz: { { n-nel osztva 0 maradékot adó egészek}, ..., { n-nel osztva n-1 maradékot adó egészek} } = { <span style=\"text-decoration: overline\">0</span>, ..., <span style=\"text-decoration: overline\">n-1</span> }. Ezt a \u{2124}/<sub>n</sub>\u{2124}-nel jelöljük és <b>teljes maradékrendszernek</b> nevezzük.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">  
                        Legyen <span style=\"text-decoration: overline\">a</span>, <span style=\"text-decoration: overline\">b</span> \u{2208} \u{2124}/<sub>n</sub>\u{2124}, ekkor <span style=\"text-decoration: overline\">a</span> \u{00B1} <span style=\"text-decoration: overline\">b</span> = <span style=\"text-decoration: overline\">a \u{00B1} b</span> és <span style=\"text-decoration: overline\">a</span> * <span style=\"text-decoration: overline\">b</span> = <span style=\"text-decoration: overline\">a * b</span>.
                        Megjegyzendő, hogy a bal oldali szorzás és hozzáadás művelete nem azonos a jobb oldalival, hiszen az előbbi két halmaz között lett elvégezve (értelemszerűen az első halmaz minden eleméhez hozzáadjuk / megszorozzuk a második halmaz minden elemét/elemével), az utóbbi két egész között lesz végrehajtva. Az itt bevezetett (bal oldali) szorzás és hozzáadás műveletek kommutatívak, asszociatívak, diszrtibutívak, zártak és van neutrális elemük (előbbinél <span style=\"text-decoration: overline\">1</span>, utóbbinál <span style=\"text-decoration: overline\">0</span>). 
                        Viszont míg a hozzáadás esetén van minden elemnek inverzeleme, addig ez a szorzásra már nem igaz (pl.: <span style=\"text-decoration: overline\">0</span>). Ezért lesz szükségünk majd a redukált maradékrendszer fogalmának bevezetésére.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Legyen \u{2124} \u{220B} n \u{2265} 2. A (\u{2124}/<sub>n</sub>\u{2124})<sup>*</sup> = { <span style=\"text-decoration: overline\">a</span> \u{2208} \u{2124}/<sub>n</sub>\u{2124} | \u{2203} <span style=\"text-decoration: overline\">b</span> \u{2208} \u{2124}/<sub>n</sub>\u{2124}: <span style=\"text-decoration: overline\">a</span> * <span style=\"text-decoration: overline\">b</span> = <span style=\"text-decoration: overline\">1</span> }. Ezt <b>redukált maradékrendszernek</b> nevezzük.
                        Ebben azok a maradékosztályok vannak benne, amelyeknek van inverz elemük a szorzásra nézve.
                        Belátható, hogy (\u{2124}/<sub>n</sub>\u{2124})<sup>*</sup> = { <span style=\"text-decoration: overline\">a</span> \u{2208} \u{2124}/<sub>n</sub>\u{2124} | gcd(a,n) = 1 }, azaz azok a maradékosztályok vannak benne, amelyeknek az elemei relatív prímek n-hez, azaz nincsen az egységen kívül más közös osztójuk n-nel.
                    </label>
                </div>",
                "<div class=\"defined\">
                    <label class=\"definition_label\">
                        Euler- féle \u{03C6} függvény és redukált maradékrendszerek mérete
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Az Euler- féle \u{03C6} függvény megadja egy pozitív egész szám esetén, hogy hány darab pozitív, hozzá relatív prím létezik, azaz, hány olyan pozitív szám van, amelynek az egységen kívül nincsen már közös osztója a számmal.
                        Ez a \u{2124} \u{220B} p prím esetén p - 1 (különben nem lenne prím). Az 1-hez a függvény 1-et rendel.
                        Ha az \u{2124} \u{220B} a = p<sup>\u{03B1}</sup> alakú, ahol p prím és alfa pedig nemnegatív egész, akkor bebizonyítható, hogy <b>\u{03C6}(a)</b> = a - p<sup>\u{03B1} - 1</sup> = <b>p<sup>\u{03B1} - 1</sup> * (p - 1)</b>.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Az is bebizonyítható, hogy ez a függvény multiplikatív, azaz \u{03C6}(a * b) = \u{03C6}(a) * \u{03C6}(b) (a, b \u{2208} \u{2124}).
                        Végül az \u{2124}<sup>>1</sup> \u{220B} a = \u{220F}<sup>m</sup><sub>i=1</sub>p<sub>i</sub><sup>\u{03B1}<sub>i</sub></sup> (m \u{2265} 1, (i \u{2208} {1,...,m} \u{2282} \u{2115}): \u{2124}<sup>+</sup> \u{220B} p<sub>i</sub> páronként különböző prím \u{2227} \u{03B1}<sub>i</sub> \u{2265} 0 (a prímszám előfordulása a prímfelbontásban)) kanonikus alak alapján már bármely összetett számra meghatározható a pozitív, hozzá relatív prímek száma.
                        <b>\u{03C6}(a)
                        = \u{03C6}(\u{220F}<sup>m</sup><sub>i=1</sub>p<sub>i</sub><sup>\u{03B1}<sub>i</sub></sup>)
                        = \u{220F}<sup>m</sup><sub>i=1</sub>\u{03C6}(p<sub>i</sub><sup>\u{03B1}<sub>i</sub></sup>)
                        = \u{220F}<sup>m</sup><sub>i=1</sub>(p<sub>i</sub><sup>\u{03B1}<sub>i</sub> - 1</sup> * (p<sub>i</sub> - 1))</b>.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Korábbi tétel szerint (\u{2124}/<sub>n</sub>\u{2124})<sup>*</sup> = { <span style=\"text-decoration: overline\">a</span> \u{2208} \u{2124}/<sub>n</sub>\u{2124} | gcd(a,n) = 1 }, vagyis ahhoz, hogy megkapjuk a |(\u{2124}/<sub>n</sub>\u{2124})<sup>*</sup>|-et elég meghatározni a \u{03C6}(n)-et.
                    </label>
                </div>"
            ];
        }

        /**
         * 
         * This method is responsible for creating the third set of tasks of Discrete Mathematics II. related to Eucleidan algorithm.
         * 
         * 1 type of subtask will be generated here (3 subtasks). This is the Eucleidan algorithm.
         * 
         * @return void
         */
        private function CreateTaskThree(){
            // Task creation part:
            $gcd_pairs = $this->dimatii_subtasks_generator->CreateSubtask("2", "0", 3);

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

            // The definitions related to Eucleidan algorithm, gcd and lcm
            $this->definitions = [
                "<div class=\"defined\">
                    <label class=\"definition_label\">
                        Legnagyobb közös osztó és legkisebb közös többszörös
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adottak \u{2124} \u{220B} a, b számok. Jelölje ekkor ennek a két számnak a legnagyobb közös osztóját az a d \u{2208} \u{2124} szám amelyre teljesül, hogy:
                    </label>
                    <ul class=\"definition_list\">
                        <li><label>d \u{2265} 0 (egyértelmű);</label></li>
                        <li><label>d | a \u{2227} d | b (közös osztó);</label></li>
                        <li><label>(\u{2200} e \u{2208} \u{2124}): e | a \u{2227} e | b \u{2192} e | d (legnagyobb).</label></li>
                    </ul>
                    <label class=\"definition_label\">
                        Ha a legnagyobb közös osztó 1, akkor a két számot relatív prímnek nevezzük (legnagyobb közös osztó az egység). A legnagyobb közös osztóval osztva a két számot relatív prímek lesznek.
                        A legnagyobb közös osztót az <i>LNKO(a,b)</i>-vel, <i>gcd(a,b)</i>-mel, esetleg <i>(a,b)</i>-vel jelöljük.  A másodikat és az elsőt fogom használni. Ritkán a harmadikat is, bár az összetéveszthető a rendezett párokkal, vagy nyílt intervallummal.
                        Adott \u{2124} \u{220B} a gcd(0, a) = |a|. Nyilván |a| \u{2265} 0, és |a| a legnagyobb olyan szám, amely osztója a-nak. Végül azt is tudjuk, hogy bármely szám osztója a 0-nak, így a |a| is.
                        Az is bebizonyítható, hogy gcd(a, b) = gcd(a, b - k * a) (a, b, k \u{2208} \u{2124}). 
                        Ehhez vennünk kell a { d \u{2208} \u{2124}<sup>\u{2265}0</sup> : d | a \u{2227} d | b} és { d \u{2208} \u{2124}<sup>\u{2265}0</sup> : d | a \u{2227} d | b - a * k} halmazokat és be kell látni, hogy azonosak, így pedig a véges elemszámuk miatt a maximumuk (ami rendre gcd(a, b) és gcd(a, b - k * a)) is egyenlő.
                        Az Eukleidészi- algoritmus segítségével bizonyítjuk, hogy bármely két egész számnak van legnagyobb közös osztója.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adottak \u{2124} \u{220B} a, b számok. Jelölje ekkor ennek a két számnak a legkisebb közös többszörösét az az m \u{2208} \u{2124} szám amelyre teljesül, hogy:
                    </label>
                    <ul class=\"definition_list\">
                        <li><label>m \u{2265} 0 (egyértelmű);</label></li>
                        <li><label>a | m \u{2227} b | m (közös többszörös);</label></li>
                        <li><label>(\u{2200} e \u{2208} \u{2124}): a | e \u{2227} b | e \u{2192} m | e (lekisebb).</label></li>
                    </ul>
                    <label class=\"definition_label\">
                        A legkisebb közös többszöröst az <i>LKKT(a,b)</i>-vel, <i>lcm(a,b)</i>-mel, esetleg <i>[a,b]</i>-vel jelöljük. A másodikat és az elsőt fogom használni.
                        Adottak \u{2124} \u{220B} a, b, ekkor lcm(a,b) = |a * b| / gcd(a,b).
                    </label>
                </div>",
                "<div class=\"defined\">
                    <label class=\"definition_label\">
                        Eukleidészi- algoritmus
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adottak a \u{2124} \u{220B} a, b számok. Feltételezzük, hogy mind a kettő nemnegatív (ha negatívak, akkor vegyük az abszolútértéküket, ugyanis a legnagyobb közös osztó ugyanaz marad), valamint az a \u{2265} b.
                        Majd hajtsuk végre a következő maradékos osztásokat:<br>
                        a = q<sub>0</sub> * b + r<sub>0</sub>;<br>
                        b = q<sub>1</sub> * r<sub>0</sub> + r<sub>1</sub>;<br>
                        r<sub>0</sub> = q<sub>2</sub> * r<sub>1</sub> + r<sub>2</sub>;<br>
                        ...<br>
                        r<sub>i-2</sub> = q<sub>i</sub> * r<sub>i-1</sub> + r<sub>i</sub>.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Mivel itt végig maradékos osztást hajtottunk végre, ezért a korábbi tétel alapján |b| = b > |r<sub>0</sub>| = r<sub>0</sub> > ... > |r<sub>i</sub>| = r<sub>i</sub> \u{2265} 0,
                        tehát a maradékok egy szigorúan monoton csökkenő számsorozatot alkotnak, ebből pedig következik, hogy az algoritmus véges számú lépésben véget ér. Az i-t értelemszerűen érdemes úgy megválasztani, hogy az r<sub>i</sub> 0 legyen.
                        Felhasználva a korábbi tételeinket: gcd(a, b) = gcd(b, a - k<sub>0</sub> * b) [k<sub>0</sub> \u{2208} \u{2124}, ezért kicserélhető q<sub>0</sub>-ra] = gcd(b, a -  q<sub>0</sub> * b) 
                        = gcd(b, r<sub>0</sub>) = gcd(r<sub>0</sub>, b - k<sub>1</sub> * r<sub>0</sub>) [k<sub>1</sub> \u{2208} \u{2124}, ezért kicserélhető q<sub>1</sub>-re] = gcd(r<sub>0</sub>, b - q<sub>1</sub> * r<sub>0</sub>) 
                        = gcd(r<sub>0</sub>, r<sub>1</sub>) = ... = gcd(r<sub>i-1</sub>, r<sub>i</sub>) = gcd(r<sub>i-1</sub>, 0) = |r<sub>i-1</sub>| = r<sub>i-1</sub>.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Mivel az Eukleidészi- algoritmus véges lépésben véget ér bármely két egész szám esetén, ezért valóban bármely két szám esetén létezik a legnagyobb közös osztó.
                    </label>
                </div>",
                "<div class=\"defined\">
                    <label class=\"definition_label\">
                        Kibővített Eukleidészi- algoritmus
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        A gcd(a,b) meghatározásánál használt Eukleidészi- algoritmust felhasználva alkotjuk meg az itteni algoritmust. Azt szeretnénk elérni, hogy minden maradékot felírhassunk az a és b lineáris kombinációjaként.<br>
                        r<sub>-2</sub> := 1*a + 0*b = a (m<sub>-2</sub> := 1, n<sub>-2</sub> := 0);<br>
                        r<sub>-1</sub> := 0*a + 1*b = b (m<sub>-1</sub> := 0, n<sub>-1</sub> := 1);<br>
                        r<sub>0</sub> = a - q<sub>0</sub> * b (m<sub>0</sub> := 1, n<sub>0</sub> := -q<sub>0</sub>);<br>
                        r<sub>1</sub> = b - q<sub>1</sub> * r<sub>0</sub> = b - q<sub>1</sub> * (a - q<sub>0</sub> * b) =  b * (1 + q<sub>1</sub> * q<sub>0</sub>) - q<sub>1</sub> * a (m<sub>1</sub> := -q<sub>1</sub>, n<sub>1</sub> := 1 + q<sub>1</sub> * q<sub>0</sub>);<br>
                        ...<br>
                        Tegyük fel, hogy a k.-ik (0 \u{2264} k \u{2264} (i - 1)) lépésig (a k.-ik már nem) minden maradékot fel tudtunk írni a és b lineáris kombinációjaként, 
                        vagyis r<sub>k-2</sub> = m<sub>k-2</sub> * a + n<sub>k-2</sub> * b és r<sub>k-1</sub> = m<sub>k-1</sub> * a + n<sub>k-1</sub> * b.<br>
                        Ekkor az Eukleidészi- algoritmus szerint: r<sub>k</sub> = r<sub>k-2</sub> - q<sub>k</sub> * r<sub>k-1</sub>
                        = m<sub>k-2</sub> * a + n<sub>k-2</sub> * b - q<sub>k</sub> * (m<sub>k-1</sub> * a + n<sub>k-1</sub> * b)
                        = a * (m<sub>k-2</sub> - q<sub>k</sub> * m<sub>k-1</sub>) + b*(n<sub>k-2</sub> - q<sub>k</sub> * n<sub>k-1</sub>)
                        = a * m<sub>k</sub>  + b*n<sub>k</sub> (m<sub>k</sub> := m<sub>k-2</sub> - q<sub>k</sub> * m<sub>k-1</sub>, n<sub>k</sub> := n<sub>k-2</sub> - q<sub>k</sub> * n<sub>k-1</sub>).
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Mivel gcd(a,b) = r<sub>i-1</sub>, és r<sub>i-1</sub> a kibővített Eukleidészi- algoritmus szerint felírható az a és b lineáris kombinációjaként, ezért a legnagyobb közös osztó is.
                        Ezt nevezzük Bézout- azonosságnak: gcd(a,b) = a * x + b * y ( = a * m<sub>i-1</sub> + b * n<sub>i-1</sub>) (x, y \u{2208} \u{2124}).
                        Adottak a \u{2124} \u{220B} a, b, c számok, továbbá tudjuk, hogy c | a * b és gcd(c, a) = 1, ekkor c | b. Bézout szerint, ekkor 1 = c * x + a * y (x, y \u{2208} \u{2124}), mind a két oldalt b-vel szorozva pedig b = c * x * b + a * b * y, ahol a b a jobb oldal mindkét tagját osztja, így pedig a bal oldalt, azaz a b-t is.
                        Következmény: ha a p szám prím és osztója az a * b szorzatnak, akkor osztója a-nak, vagy b-nek is. Sőt ez kiterjeszthető többtényezős szorzatra is.
                    </label>
                </div>"
            ];
        }

        /**
         * 
         * This method is responsible for creating the fourth set of tasks of Discrete Mathematics II. related to linear congruences.
         * 
         * 1 type of subtask will be generated here (3 subtasks). This is solving linear congruences.
         * 
         * @return void
         */
        private function CreateTaskFour(){
            // Task creation part:
            $linear_congrences = $this->dimatii_subtasks_generator->CreateSubtask("3","0",3);

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

            // The definitions related to linear congruences
            $this->definitions = [
                "<div class=\"defined\">
                    <label class=\"definition_label\">
                        Kongruenciák tulajdonságai
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Korábban már vettünk kongruenciákat. Azt mondtuk, hogy az a és b számok kongruensek m modulussal, amennyiben azonos maradékot adnak m-mel osztva.
                        Azt is beláttuk, hogy (a, b \u{2208} \u{2124})(m \u{2208} \u{2124}<sup>\u{2265}2</sup>):a \u{2261} b (mod m) \u{2194} a = b + m * k (k \u{2208} \u{2124}) \u{2194} m | a - b. Jöjjön a kongruenciák néhány tulajdonsága.
                    </label>
                    <ul class=\"definition_list\">
                        <li><label>(\u{2200} a \u{2208} \u{2124})(\u{2200} m \u{2208} \u{2124}<sup>\u{2265}2</sup>): a \u{2261} a (mod m) (ugyanis: m | 0 = a - a) (reflexivitás);</label></li>
                        <li><label>(\u{2200} a, b \u{2208} \u{2124})(\u{2200} m \u{2208} \u{2124}<sup>\u{2265}2</sup>): a \u{2261} b (mod m) \u{2194} b \u{2261} a (mod m) (ugyanis: m | a - b \u{2194} m | b - a) (szimmetria);</label></li>
                        <li><label>(\u{2200} a, b, c \u{2208} \u{2124})(\u{2200} m \u{2208} \u{2124}<sup>\u{2265}2</sup>): a \u{2261} b (mod m) \u{2227} b \u{2261} c (mod m) \u{2192} a \u{2261} c (mod m) (ugyanis: (m | a - b \u{2227} m | b - c) \u{2194} (m * k + b = a (k \u{2208} \u{2124}) \u{2227} m * l + c = b (l \u{2208} \u{2124})) \u{2194} (m * (k + l) = a - c) \u{2194} m | a - c) (tranzitivitás);</label></li>
                        <li><label>(\u{2200} a, b, c \u{2208} \u{2124})(\u{2200} m \u{2208} \u{2124}<sup>\u{2265}2</sup>): a \u{2261} b (mod m) \u{2194} a \u{00B1} c \u{2261} b \u{00B1} c (mod m) (ugyanis: m | a - b \u{2194} m | a \u{00B1} c - (b \u{00B1} c) = a \u{00B1} c - b \u{2213} c = a - b);</label></li>
                        <li><label>(\u{2200} a, b, c \u{2208} \u{2124})(\u{2200} m \u{2208} \u{2124}<sup>\u{2265}2</sup>): a \u{2261} b (mod m) \u{2192} a * c \u{2261} b * c (mod m) (ugyanis: m | a - b \u{2192} m | a * c - b * c = (a - b) * c);</label></li>
                        <li><label>(\u{2200} a, b, c \u{2208} \u{2124})(\u{2200} m \u{2208} \u{2124}<sup>\u{2265}2</sup>): a * c \u{2261} b * c (mod m) \u{2192} a \u{2261} b (mod m/gcd(m,c)).</label></li>
                    </ul>
                </div>",
                "<div class=\"defined\">
                    <label class=\"definition_label\">
                        Lineáris kongruenciák megoldhatósága és lehetséges megoldása
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adottak a, b \u{2208} \u{2124} és m \u{2208} \u{2124}<sup>\u{2265}2</sup> számok. Ekkor az a * x \u{2261} b (mod m) kongruenciát lineárisnak nevezzük.
                        A feladat az, hogy megkeressük azokat az x számokat, amellyel igaz állítást kapunk, azaz a * x és b azonos maradékot ad m-mel osztva.
                        Nem mindig lesz megoldható ez a feladat. Az ekvivalenciákat követve: a * x \u{2261} b (mod m) \u{2194} m | a * x - b \u{2194} a * x +  (-y) * m = b. Vegyük az a és m legnagyobb közös osztóját (jelöljük d-vel), ekkor az egyenlet a következő formát veszi fel: d * a<sub>d</sub> * x + d * m<sub>d</sub> * y = b. 
                        A bal oldal osztható d-vel, így pedig a jobb oldalnak is oszthatónak kell lennie. Az a * x \u{2261} b (mod m) lineáris kongruencia pontosan akkor oldható meg, ha (a,m) | b.
                        \"Sima\" kongruenciák esetén nincs ekvivalencia, például a (3,9) | 6, de 3 és 6 nem ad azonos maradékot 9-cel osztva. Ott ez szükséges, de nem elégséges feltétel.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Egy lehetsége megoldása az (a, b \u{2208} \u{2124} és m \u{2208} \u{2124}<sup>\u{2265}2</sup>): a * x \u{2261} b (mod m) lineáris kongruenciának:<br>
                        1. lépés: ellenőrizzük, hogy (a, m) | b;<br>
                        2. lépés: ha a = 0, akkor |m| | b, ekkor megállhatunk, x bármi lehet; <br>
                        3. lépés: vesszük az a és b maradékát m-mel osztva;<br>
                        4. lépés: amíg a b nem osztható az a-val:<br>
                        4.1. lépés: b<sub>+</sub> := b;<br>
                        4.2. lépés: b<sub>-</sub> := b;<br>
                        4.3. lépés: amíg (a,b<sub>+</sub>) == 1 és (a,b<sub>-</sub>) == 1:<br>
                        4.3.1. lépés: b<sub>+</sub> := b<sub>+</sub> + m;<br>
                        4.3.2. lépés: b<sub>-</sub> := b<sub>-</sub> - m;<br>
                        4.4. lépés: ha (a,b<sub>+</sub>) == 1, akkor b := b<sub>+</sub>, különben b := b<sub>-</sub><br>
                        4.5. lépés: osztjuk a kongruenciát gcd(a, b)-vel;<br>
                        5. lépés: osztjuk a kongruenciát gcd(a,b) = a -val.
                    </label>
                </div>"
            ];
        }

        /**
         * 
         * This method is responsible for creating the fifth set of tasks of Discrete Mathematics II. related to linear diophantine equations.
         * 
         * 2 types of subtask will be generated here (2 and 1 subtasks respectively). These are: diophantine equations and number division into two numbers with plus condition.
         * 
         * @return void
         */
        private function CreateTaskFive(){
            // Task creation part:
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

            // The definitions related to linear congruences
            $this->definitions = [
            "<div class=\"defined\">
                <label class=\"definition_label\">
                    Diofantikus egyenlet megoldása
                </label>
            </div>
            <div class=\"definition\">
                <label class=\"definition_label\">
                    Adottak az a, b, c \u{2208} \u{2124} számok. Az a * x + b * y = c egyenletet lineáris diofantikus egyenletnek nevezzük. A feladat az, hogy megkeressük ennek az összes megoldását.
                    Ez az egyenlet pontosan akkor oldható meg, ha (a,b) | c.
                </label>
            </div>
            <div class=\"definition\">
                <label class=\"definition_label\">
                    (a, b, c \u{2208} \u{2124}): a * x + b * y = c I. lehetséges megoldása:<br>
                    1. lépés: ellenőrizzük, hogy (a,b) | c;<br>
                    2. lépés: átalakítás: a * x - c = b * y \u{2194} b | a * x - c \u{2194} a * x \u{2261} c (mod b);<br>
                    3. lépés: az a * x \u{2261} c (mod b) lineáris kongruencia megoldása;<br>
                    4. lépés: y = (c - a * x) / b egyenletben az x behelyettesítése.
                </label>
            </div>
            <div class=\"definition\">
                <label class=\"definition_label\">
                    (a, b, c \u{2208} \u{2124}): a * x + b * y = c II. lehetséges megoldása:<br>
                    1. lépés: ellenőrizzük, hogy (a,b) | c;<br>
                    2. lépés: meghatározni egy x<sub>0</sub> és y<sub>0</sub> alapmegoldást;<br>
                    2.1. lépés: kibővíttt Eukleidészi- algoritmussal határozzuk meg a megoldását a gcd(a,b) = a * x<sub>a</sub> + b * y<sub>b</sub> (x<sub>a</sub>, y<sub>b</sub> \u{2208} \u{2124});<br>
                    2.2. lépés: szorozzuk be mind a két oldalt (c/gcd(a,b))-val, így c = a * x<sub>a</sub> * (c/gcd(a,b)) + b * y<sub>b</sub> * (c/gcd(a,b)) (x<sub>a</sub>, y<sub>b</sub> \u{2208} \u{2124});<br>
                    2.3. lépés: az alap megoldások így: x<sub>0</sub> = x<sub>a</sub> * (c/gcd(a,b)) és y<sub>0</sub> = y<sub>b</sub> * (c/gcd(a,b));<br>
                    3. lépés: behelyettesítés az x = x<sub>0</sub> + k * (b/gcd(a,b)) és y = y<sub>0</sub> - k * (a/gcd(a,b)) egyenletekbe, ahol a k egy tetszőleges egész szám, ami közös a két egyenletben.
                </label>
            </div>"
        ];
        }

        /**
         * 
         * This method is responsible for creating the sixth set of tasks of Discrete Mathematics II. related to chinese remainder theorem.
         * 
         * 2 types of subtask will be generated here (1-1 subtask). These are: CRT and searching for a number satisfying 2 congruences simultaneously.
         * 
         * @return void
         */
        private function CreateTaskSix(){
            // Task creation part:
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

            // The definitions related to Chinese remainder theorem (CRT)
            $this->definitions = [
                "<div class=\"defined\">
                    <label class=\"definition_label\">
                        Kínai maradéktétel
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Legyen n, m \u{2264} 2 egészek úgy, hogy gcd(n,m) = 1. Ekkor az f: \u{2124}/<sub>n*m</sub>\u{2124} \u{2192} \u{2124}/<sub>n</sub>\u{2124} \u{00D7} \u{2124}/<sub>m</sub>\u{2124}, 
                        f(<span style=\"text-decoration: overline\">a</span>) = (<span style=\"text-decoration: overline\">a</span>,<span style=\"text-decoration: overline\">a</span>) egy bijektív függvény.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Egyértelműség:<br>
                        Tegyük fel, hogy (<span style=\"text-decoration: overline\">a</span>, <span style=\"text-decoration: overline\">b</span> \u{2208} \u{2124}/<sub>n*m</sub>\u{2124}): f(<span style=\"text-decoration: overline\">a</span>) = (<span style=\"text-decoration: overline\">a</span><sub>1</sub>,<span style=\"text-decoration: overline\">a</span><sub>2</sub>) \u{2260} (<span style=\"text-decoration: overline\">b</span><sub>1</sub>,<span style=\"text-decoration: overline\">b</span><sub>2</sub>) = f(<span style=\"text-decoration: overline\">b</span>), hogy <span style=\"text-decoration: overline\">a</span> = <span style=\"text-decoration: overline\">b</span> \u{2124}/<sub>n*m</sub>\u{2124}-ban.
                        <span style=\"text-decoration: overline\">a</span> = <span style=\"text-decoration: overline\">b</span> \u{2208} \u{2124}/<sub>n*m</sub>\u{2124}-ban \u{2194} n * m | a - b \u{2194} n * m * k + b = a (k \u{2208} \u{2124}). 
                        Ezt behelyettesítve az (<span style=\"text-decoration: overline\">a</span><sub>2</sub>,<span style=\"text-decoration: overline\">a</span><sub>2</sub>)-ba: <span style=\"text-decoration: overline\">n * m * k + b</span> \u{2208} \u{2124}/<sub>n</sub>\u{2124} és 
                        <span style=\"text-decoration: overline\">n * m * k + b</span> \u{2208} \u{2124}/<sub>m</sub>\u{2124}. Mind a két esetben kiesik az n * m * k tag, így valójában <span style=\"text-decoration: overline\">n * m * k + b</span> = <span style=\"text-decoration: overline\">b</span> \u{2208} \u{2124}/<sub>n</sub>\u{2124} és
                        <span style=\"text-decoration: overline\">n * m * k + b</span> = <span style=\"text-decoration: overline\">b</span> \u{2208} \u{2124}/<sub>m</sub>\u{2124}, azaz (<span style=\"text-decoration: overline\">a</span><sub>1</sub>,<span style=\"text-decoration: overline\">a</span><sub>2</sub>) = (<span style=\"text-decoration: overline\">b</span><sub>1</sub>,<span style=\"text-decoration: overline\">b</span><sub>2</sub>).
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Injektivitás:
                        Tegyük fel, hogy (<span style=\"text-decoration: overline\">a</span>, <span style=\"text-decoration: overline\">b</span> \u{2208} \u{2124}/<sub>n*m</sub>\u{2124}): f(<span style=\"text-decoration: overline\">a</span>) = (<span style=\"text-decoration: overline\">a</span><sub>1</sub>,<span style=\"text-decoration: overline\">a</span><sub>2</sub>) = f(<span style=\"text-decoration: overline\">b</span>), hogy <span style=\"text-decoration: overline\">a</span> \u{2260} <span style=\"text-decoration: overline\">b</span> \u{2124}/<sub>n*m</sub>\u{2124}-ban.
                        <span style=\"text-decoration: overline\">a</span> = <span style=\"text-decoration: overline\">b</span> \u{2208} \u{2124}/<sub>m</sub>\u{2124} \u{2194} m | a - b \u{2194} m * k = a - b (k \u{2208} \u{2124}) és
                        <span style=\"text-decoration: overline\">a</span> = <span style=\"text-decoration: overline\">b</span> \u{2208} \u{2124}/<sub>n</sub>\u{2124} \u{2194} n | a - b \u{2194} n * l = a - b (l \u{2208} \u{2124}).
                        Valamint a Bézout- azonosság szerint: gcd(n,m) = 1 = n * x + m * y (x, y \u{2208} \u{2124}), mind a két oldalt (a-b)-vel szorozzuk, (a - b) = (a - b) * n * x + (a - b) * m * y = m * k * n * x + n * l * m * y, a jobb oldal osztható (n * m)-mel, így pedig az egyenlőségjel miatt az a - b is.
                        m * n | a - b \u{2194} <span style=\"text-decoration: overline\">a</span> = <span style=\"text-decoration: overline\">b</span> \u{2208} \u{2124}/<sub>n*m</sub>\u{2124}, azaz <span style=\"text-decoration: overline\">a</span> = <span style=\"text-decoration: overline\">b</span> \u{2124}/<sub>n*m</sub>\u{2124}-ban.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Szürjektivitás:
                        Kell keresnünk minden (<span style=\"text-decoration: overline\">a</span><sub>1</sub>,<span style=\"text-decoration: overline\">a</span><sub>2</sub>) \u{2208} \u{2124}/<sub>n</sub>\u{2124} \u{00D7} \u{2124}/<sub>m</sub>\u{2124} párhoz egy megfelelő <span style=\"text-decoration: overline\">a</span> \u{2208} \u{2124}/<sub>n*m</sub>\u{2124} maradékosztályt.
                        A Bézout- azonosság szerint: gcd(n,m) = 1 = n * x + m * y (x, y \u{2208} \u{2124}), vagyis n * x \u{2261} 1 (mod m) és m * y \u{2261} 1 (mod n).
                        Vegyük az n * x * a<sub>2</sub> + m * y * a<sub>1</sub> számot. Nézzük meg ennek mi a függvény általi képe: f(<span style=\"text-decoration: overline\">n * x * a<sub>2</sub> + m * y * a<sub>1</sub></span>) = (<span style=\"text-decoration: overline\">n * x * a<sub>2</sub> + m * y * a<sub>1</sub></span>,<span style=\"text-decoration: overline\">n * x * a<sub>2</sub> + m * y * a<sub>1</sub></span>), ahol
                        <span style=\"text-decoration: overline\">n * x * a<sub>2</sub> + m * y * a<sub>1</sub></span> \u{2208} \u{2124}/<sub>n</sub>\u{2124} és <span style=\"text-decoration: overline\">n * x * a<sub>2</sub> + m * y * a<sub>1</sub></span> \u{2208} \u{2124}/<sub>m</sub>\u{2124}.
                        A fentieket persze átírhatjuk: <span style=\"text-decoration: overline\">n * x * a<sub>2</sub> + m * y * a<sub>1</sub></span> = <span style=\"text-decoration: overline\">0 + m * y * a<sub>1</sub></span> = <span style=\"text-decoration: overline\">1 * a<sub>1</sub></span> = <span style=\"text-decoration: overline\">a<sub>1</sub></span> \u{2208} \u{2124}/<sub>n</sub>\u{2124}, hasonlóan
                        <span style=\"text-decoration: overline\">n * x * a<sub>2</sub> + m * y * a<sub>1</sub></span> = <span style=\"text-decoration: overline\">n * x * a<sub>2</sub> + 0</span> = <span style=\"text-decoration: overline\">1 * a<sub>2</sub></span> = <span style=\"text-decoration: overline\">a<sub>2</sub></span> \u{2208} \u{2124}/<sub>n</sub>\u{2124}. Tehát a n * x * a<sub>2</sub> + m * y * a<sub>1</sub> megfelelő szám.
                    </label>
                </div>",
                "<div class=\"defined\">
                    <label class=\"definition_label\">
                        Kongruenciarendszer megoldása
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Legyen az n \u{2264} 2:<br>
                        (a<sub>1</sub>, b<sub>1</sub> \u{2208} \u{2124} és m<sub>1</sub> \u{2208} \u{2124}<sup>\u{2265}2</sup>): a<sub>1</sub> * x \u{2261} b<sub>1</sub> (mod m<sub>1</sub>)<br>
                        (a<sub>2</sub>, b<sub>2</sub> \u{2208} \u{2124} és m<sub>2</sub> \u{2208} \u{2124}<sup>\u{2265}2</sup>): a<sub>2</sub> * x \u{2261} b<sub>2</sub> (mod m<sub>2</sub>)<br>
                        ...<br>
                        (a<sub>n</sub>, b<sub>n</sub> \u{2208} \u{2124} és m<sub>n</sub> \u{2208} \u{2124}<sup>\u{2265}2</sup>): a<sub>n</sub> * x \u{2261} b<sub>n</sub> (mod m<sub>n</sub>)<br>
                        Keressük azokat a számokat, amely egyszerre teljesíti ezt a kongruenciarendszert.
                        A kongruenciarendszer megoldhatóságának első feltétele az, hogy a modulusok páronként relatív prímek. Ha van 2 amelynél a modulus nem relatív prím, akkor azt kell megnézni, hogy azonosak-e ezek a kongruenciák, amennyiben nem, akkor a rendszert nem lehet megoldani, különben valamelyik kongruenciát ki lehet venni.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">    
                        Megoldás algoritmusa:<br>
                        1. lépés: ellenőrizzük, hogy a modulusok páronként relatív prímek. Ha van 2 amelynél a modulus nem relatív prím, akkor azt kell megnézni, hogy azonosak-e ezek a kongruenciák, amennyiben nem, akkor a rendszert nem lehet megoldani, különben valamelyik kongruenciát ki lehet venni;<br>
                        2. lépés: oldjuk meg a kongruenciákat, itt ellenőrizzük, hogy a kongruenciák megoldhatók-e;<br>
                        3. lépés: i := 1;<br>
                        4. lépés: amíg 1-nél több kongruencia van (i < n):<br>
                        4.1. lépés: az első két kongruenciát vonjuk össze eggyé.<br>
                        4.1.1. lépés: kibővített eukleidészi algoritmussal keressük meg az i == 1 esetén az m<sub>1</sub> * x + m<sub>2</sub> * y = 1, az i > 1 esetén pedig az m<sub>1,i</sub> * x + m<sub>i+1</sub> * y = 1 egyenlet egy-egy alapmegoldását az x-re és y-ra;<br>
                        4.1.2. lépés: i == 1 esetén: b<sub>1,2</sub> = m<sub>1</sub> * x * b<sub>2</sub> + m<sub>2</sub> * y * b<sub>1</sub>, az i > 1 esetén pedig b<sub>1,i+1</sub> = m<sub>1,i</sub> * x * b<sub>i+1</sub> + m<sub>i+1</sub> * y * b<sub>1,i</sub>;<br>
                        4.1.3. lépés: i == 1 esetén: m<sub>1,2</sub> = m<sub>1</sub> * m<sub>2</sub>, az i > 1 esetén pedig m<sub>1,i+1</sub> = m<sub>1,i</sub> * m<sub>i+1</sub>;<br>
                        4.1.4. lépés: az összevont kongruencia: x \u{2261} b<sub>1,i+1</sub> (mod m<sub>1,i+1</sub>);<br>
                        4.2. lépés: az összevont kongruenciára cseréljük ki az első két kongruenciát;<br>
                        4.3. lépés: i := i + 1; <br>
                        5. lépés: a visszamart kongruencia a megoldás.
                    </label>
                </div>"
            ];
        }

        /**
         * 
         * This method is responsible for creating the seventh set of tasks of Discrete Mathematics II. related to horner table.
         * 
         * 2 types of subtask will be generated here (2 and 1 subtasks respectively). These are: Horner-schemes and polynomial dvision with Horner- scheme.
         *
         * @return void
         */
        private function CreateTaskSeven(){
            // Creating 2 polynomials with degree of 2 and 4.
            $horner_schemes_first = $this->dimatii_subtasks_generator->CreateSubtask("6", "0", 2);
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

            // The definitions related to polynomial expressions and Horner- schemes
            $this->definitions = [
                "<div class=\"defined\">
                    <label class=\"definition_label\">
                        Polinomok
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        A P[x] = a<sub>n</sub> * x<sup>n</sup> + ... + a<sub>1</sub> * x + a<sub>0</sub> (x \u{2208} \u{2124}) kifejezést az egészek felett értelmezett polinomnak nevezzük.
                        Tulajdonképpen a polinomot felírhatjuk olyan végtelen hosszú számsorozatként, ahol véges számú nem-nulla tag van. Amennyiben az x helyére beírunk egy értelmezés tartomány béli elemet, akkor a polinomot a helyen kiértékelve megkapjuk a helyettesítési értéket.
                        A polinom legmagasabb fokú tagja melletti számot a polinom főegyütthatójának, a nullad rendű tag együtthatóját pedig konstans tagnak nevezzük. Amennyiben egy értelmezési tartomány béli helyen a polinomnak a helyettesítési értéke 0, akkor azt a polinom gyökének nevezzük.
                        Az algebra alaptétele szerint egy n-ed rendű komplex számtest felett értelmezett polinomnak a multiplicitásokat beleszámítva pontosan n darab gyöke van.
                     </label>
                </div>",
                "<div class=\"defined\">
                    <label class=\"definition_label\">
                        Horner- rendezés
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        A P[x] = a<sub>n</sub> * x<sup>n</sup> + ... + a<sub>1</sub> * x + a<sub>0</sub> polinomot más alakban is fel tudjuk írni.
                        Horner- rendzés: P[x] = ((...(a<sub>n</sub> * x + a<sub>n-1</sub>)...) * x + a<sub>1</sub>) * x + a<sub>0</sub>.
                        Ebből rekurzívan megkapjuk a helyettesítési értéket:<br>
                        c<sub>n</sub> = a<sub>n</sub>;<br>
                        c<sub>n-1</sub> = c<sub>n</sub> * x + a<sub>n-1</sub>;<br>
                        c<sub>n-2</sub> = c<sub>n-1</sub> * x + a<sub>n-2</sub>;<br>
                        ...<br>
                        c<sub>1</sub> = c<sub>2</sub> * x + a<sub>1</sub>;<br>
                        c<sub>0</sub> = c<sub>1</sub> * x + a<sub>0</sub> = P[x].
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Az x<sub>0</sub> behelyettesítése során tulajdonképpen megkapjuk a P[x] / (x - x<sub>0</sub>) hányadospolinomot és maradékpolinomot. A helyettesítési érték lesz a maradék, a hányadospolinomot pedig a c<sub>n</sub> * x<sup>n-1</sup> + c<sub>n-1</sub> * x<sup>n-2</sup> + ... + c<sub>1</sub> határozza meg.
                    </label>
                </div>"
            ];
        }

        /**
         * 
         * This method is responsible for creating the eight set of tasks of Discrete Mathematics II. related to polinomial division and multiplication.
         * 
         * 2 types of subtask will be generated here (1 and 1 subtask respectively). These are: polynomial division and multiplication.
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

            // The definitions related to polynomial division and multiplication
            $this->definitions = [
                "<div class=\"defined\">
                    <label class=\"definition_label\">
                        Polinomok osztása és szorzása
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adottak a P[x] és R[x] polinomok. Ekkor attól függően, hogy mi a polinomok értelmezési tartománya eltérő lehet a hányadospolinom és maradékpolinom foka. 
                        A valós számtest felett például deg(P[x]/R[x]) = deg(P[x]) - deg(Q[x]). De a \u{2124}/<sub>n</sub>\u{2124} (n \u{2265} 2) esetén már csak azt lehet mondani, hogy deg(P[x]) - deg(Q[x]) \u{2265} deg(P[x]/R[x]).
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adottak a P[x] és R[x] polinomok. Itt attól függően, hogy mi a polinomok értelmezési tartománya eltérő lehet a szorzatpolinom foka. 
                        A valós számtest felett például deg(P[x] * R[x]) = deg(P[x]) + deg(Q[x]). De a \u{2124}/<sub>n</sub>\u{2124} (n \u{2265} 2) esetén már csak azt lehet mondani, hogy deg(P[x]) + deg(Q[x]) \u{2265} deg(P[x] * R[x]).
                    </label>
                </div>"
            ];
        }

        /**
         * 
         * This method is responsible for creating the ninth set of tasks of Discrete Mathematics II. related to interpolations.
         * 
         * 2 types of subtask will be generated here (1 and 1 subtask respectively). These are: Lagrange and Newton interpolation.
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
                       
            // Adding data to the task arrays
            $this->task_descriptions = $task_array;

            //Solutions part:
            $solution_array = [
                "Lagrange_interpolation" => $lagrange_interpolation["solutions"][0],
                "Newton_interpolation" => $newton_interpolation["solutions"][0]
            ];
            $this->task_solutions = $solution_array;

            
            // The definitions related to Lagrange and Newton interpolation
            $this->definitions = [
                "<div class=\"defined\">
                    <label class=\"definition_label\">
                        Lagrange- interpoláció
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adottak a (x<sub>1</sub>, y<sub>1</sub>), (x<sub>2</sub>, y<sub>2</sub>), ..., (x<sub>n + 1</sub>, y<sub>n + 1</sub>) pontok. Ekkor szeretnénk meghatározni azt az n-ed fokú görbét, amelyre illeszkednek a pontok.
                        Az első módszer a Lagrange- interpoláció lesz. Bevezetjük a Lagrange- alappolinomokat. Az i.-ik (i \u{2208} {1,..,n}) alappolinom olyan, hogy az i.-ik pontnál 1-et, a többi helyen pedig 0-t vesz fel. Sorra megszorozzuk az alappolinomokat a helyhez tartozó értékkel. Végül összeadjuk őket.<br>
                        (i \u{2208} {1,..,n}): l<sub>(x<sub>i</sub>,y<sub>i</sub>)</sub>[x] := l<sub>i</sub>[x] = (\u{220F}<sup>n</sup><sub>j=1, j \u{2260} i</sub>(x - x<sub>j</sub>))/(\u{220F}<sup>n</sup><sub>j=1, j \u{2260} i</sub>(x<sub>i</sub> - x<sub>j</sub>)). Valóban l<sub>i</sub>[x<sub>i</sub>] = 1 és (i \u{2260} j): l<sub>i</sub>[x<sub>j</sub>] = 0 a számláló miatt.
                        Az interpolációs polinom pedig: L[x] := \u{220F}<sup>n</sup><sub>i=1</sub>(y<sub>i</sub> * l<sub>i</sub>[x]). Ebbe a polinomba az x<sub>i</sub>-t helyettesítve egyedül az i.-ik tag nem lesz nulla (ugyanis (i \u{2260} j): l<sub>j</sub>[x<sub>i</sub>] = 0), az ottani alappolinom értéke pedig 1 (l<sub>i</sub>[x<sub>i</sub>] = 1), amelyet y<sub>i</sub>-vel megszorozva a helyettesítési érték valóban y<sub>i</sub> lesz.
                        Így ezen a polinomon valóban rajta vannak az említett pontok. 
                    </label>
                </div>
                ",
                "<div class=\"defined\">
                    <label class=\"definition_label\">
                        Newton- interpoláció
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                    </label>
                </div>"
            ];
        }
    }
?>