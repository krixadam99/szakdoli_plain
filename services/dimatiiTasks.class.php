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
                        Ekkor egyértelműen tudunk adni olyan q és r számokat, hogy <b>a = q * b + r ((r \u{2208} \u{2124}): 0 \u{2264} r < |b| \u{2227} q \u{2208} \u{2124})</b>.
                        A q a kvóciens (hányados), az r a maradék.
                        Ha az <b>r = 0</b>, akkor visszakapjuk a maradék nélküli osztás képletét, ekkor <b>b | a</b>.
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
         * 3 types of subtask will be generated here (1-1-2 subtasks). These are: residue classes with a representative element for a complete residue system modulo n, residue classes with a representative element for a reduced residue system modulo n, size of a reduced residue system modulo n (where n is considerably big).
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
                        Ekkor egy osztályozást határoz meg az egész számokon a következő szuperhalmaz: { { n-nel osztva 0 maradékot adó egészek}, ..., { n-nel osztva n-1 maradékot adó egészek} } = { <span style=\"text-decoration: overline\">0</span>, ..., <span style=\"text-decoration: overline\">n-1</span> }. Ezt a \u{2124}/<span class=\"bottom\">n</span>\u{2124}-nel jelöljük és <b>teljes maradékrendszernek</b> nevezzük.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">  
                        Legyen <span style=\"text-decoration: overline\">a</span>, <span style=\"text-decoration: overline\">b</span> \u{2208} \u{2124}/<span class=\"bottom\">n</span>\u{2124}, ekkor <span style=\"text-decoration: overline\">a</span> \u{00B1} <span style=\"text-decoration: overline\">b</span> = <span style=\"text-decoration: overline\">a \u{00B1} b</span> és <span style=\"text-decoration: overline\">a</span> * <span style=\"text-decoration: overline\">b</span> = <span style=\"text-decoration: overline\">a * b</span>.
                        Megjegyzendő, hogy a bal oldali szorzás és hozzáadás művelete nem azonos a jobb oldalival, hiszen az előbbi két halmaz között lett elvégezve (értelemszerűen az első halmaz minden eleméhez hozzáadjuk / megszorozzuk a második halmaz minden elemét/elemével), az utóbbi két egész között lesz végrehajtva. Az itt bevezetett (bal oldali) szorzás és hozzáadás műveletek kommutatívak, asszociatívak, diszrtibutívak, zártak és van neutrális elemük (előbbinél <span style=\"text-decoration: overline\">1</span>, utóbbinál <span style=\"text-decoration: overline\">0</span>). 
                        Viszont míg a hozzáadás esetén van minden elemnek inverzeleme, addig ez a szorzásra már nem igaz (pl.: <span style=\"text-decoration: overline\">0</span>). Ezért lesz szükségünk majd a redukált maradékrendszer fogalmának bevezetésére.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Legyen \u{2124} \u{220B} n \u{2265} 2. A (\u{2124}/<span class=\"bottom\">n</span>\u{2124})<span class=\"exp\">*</span> = { <span style=\"text-decoration: overline\">a</span> \u{2208} \u{2124}/<span class=\"bottom\">n</span>\u{2124} | \u{2203} <span style=\"text-decoration: overline\">b</span> \u{2208} \u{2124}/<span class=\"bottom\">n</span>\u{2124}: <span style=\"text-decoration: overline\">a</span> * <span style=\"text-decoration: overline\">b</span> = <span style=\"text-decoration: overline\">1</span> }. Ezt <b>redukált maradékrendszernek</b> nevezzük.
                        Ebben azok a maradékosztályok vannak benne, amelyeknek van inverz elemük a szorzásra nézve.
                        Belátható, hogy (\u{2124}/<span class=\"bottom\">n</span>\u{2124})<span class=\"exp\">*</span> = { <span style=\"text-decoration: overline\">a</span> \u{2208} \u{2124}/<span class=\"bottom\">n</span>\u{2124} | gcd(a,n) = 1 }, azaz azok a maradékosztályok vannak benne, amelyeknek az elemei relatív prímek n-hez, azaz nincsen az egységen kívül más közös osztójuk n-nel.
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
                        Ha az \u{2124} \u{220B} a = p<span class=\"exp\">\u{03B1}</span> alakú, ahol p prím és alfa pedig nemnegatív egész, akkor bebizonyítható, hogy <b>\u{03C6}(a)</b> = a - p<span class=\"exp\">\u{03B1} - 1</span> = <b>p<span class=\"exp\">\u{03B1} - 1</span> * (p - 1)</b>.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Az is bebizonyítható, hogy ez a függvény multiplikatív, azaz \u{03C6}(a * b) = \u{03C6}(a) * \u{03C6}(b) (a, b \u{2208} \u{2124}).
                        Végül az \u{2124}<span class=\"exp\">>1</span> \u{220B} a = \u{220F}<span class=\"exp\">m</span><span class=\"bottom\">i=1</span>p<span class=\"bottom\">i</span><span class=\"exp\">\u{03B1}<span class=\"bottom\">i</span></span> (m \u{2265} 1, (i \u{2208} {1,...,m} \u{2282} \u{2115}): \u{2124}<span class=\"exp\">+</span> \u{220B} p<span class=\"bottom\">i</span> páronként különböző prím \u{2227} \u{03B1}<span class=\"bottom\">i</span> \u{2265} 0 (a prímszám előfordulása a prímfelbontásban)) kanonikus alak alapján már bármely összetett számra meghatározható a pozitív, hozzá relatív prímek száma.
                        <b>\u{03C6}(a)
                        = \u{03C6}(\u{220F}<span class=\"exp\">m</span><span class=\"bottom\">i=1</span>p<span class=\"bottom\">i</span><span class=\"exp\">\u{03B1}<span class=\"bottom\">i</span></span>)
                        = \u{220F}<span class=\"exp\">m</span><span class=\"bottom\">i=1</span>\u{03C6}(p<span class=\"bottom\">i</span><span class=\"exp\">\u{03B1}<span class=\"bottom\">i</span></span>)
                        = \u{220F}<span class=\"exp\">m</span><span class=\"bottom\">i=1</span>(p<span class=\"bottom\">i</span><span class=\"exp\">\u{03B1}<span class=\"bottom\">i</span> - 1</span> * (p<span class=\"bottom\">i</span> - 1))</b>.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Korábbi tétel szerint (\u{2124}/<span class=\"bottom\">n</span>\u{2124})<span class=\"exp\">*</span> = { <span style=\"text-decoration: overline\">a</span> \u{2208} \u{2124}/<span class=\"bottom\">n</span>\u{2124} | gcd(a,n) = 1 }, vagyis ahhoz, hogy megkapjuk a |(\u{2124}/<span class=\"bottom\">n</span>\u{2124})<span class=\"exp\">*</span>|-et elég meghatározni a \u{03C6}(n)-et.
                    </label>
                </div>"
            ];
        }

        /**
         * 
         * This function is responsible for creating the third set of tasks of Discrete Mathematics II. related to Eucleidan algorithm.
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
                        Ehhez vennünk kell a { d \u{2208} \u{2124}<span class=\"exp\">\u{2265}0</span> : d | a \u{2227} d | b} és { d \u{2208} \u{2124}<span class=\"exp\">\u{2265}0</span> : d | a \u{2227} d | b - a * k} halmazokat és be kell látni, hogy azonosak, így pedig a véges elemszámuk miatt a maximumuk (ami rendre gcd(a, b) és gcd(a, b - k * a)) is egyenlő.
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
                        a = q<span class=\"bottom\">0</span> * b + r<span class=\"bottom\">0</span>;<br>
                        b = q<span class=\"bottom\">1</span> * r<span class=\"bottom\">0</span> + r<span class=\"bottom\">1</span>;<br>
                        r<span class=\"bottom\">0</span> = q<span class=\"bottom\">2</span> * r<span class=\"bottom\">1</span> + r<span class=\"bottom\">2</span>;<br>
                        ...<br>
                        r<span class=\"bottom\">i-2</span> = q<span class=\"bottom\">i</span> * r<span class=\"bottom\">i-1</span> + r<span class=\"bottom\">i</span>.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Mivel itt végig maradékos osztást hajtottunk végre, ezért a korábbi tétel alapján |b| = b > |r<span class=\"bottom\">0</span>| = r<span class=\"bottom\">0</span> > ... > |r<span class=\"bottom\">i</span>| = r<span class=\"bottom\">i</span> \u{2265} 0,
                        tehát a maradékok egy szigorúan monoton csökkenő számsorozatot alkotnak, ebből pedig következik, hogy az algoritmus véges számú lépésben véget ér. Az i-t értelemszerűen érdemes úgy megválasztani, hogy az r<span class=\"bottom\">i</span> 0 legyen.
                        Felhasználva a korábbi tételeinket: gcd(a, b) = gcd(b, a - k<span class=\"bottom\">0</span> * b) [k<span class=\"bottom\">0</span> \u{2208} \u{2124}, ezért kicserélhető q<span class=\"bottom\">0</span>-ra] = gcd(b, a -  q<span class=\"bottom\">0</span> * b) 
                        = gcd(b, r<span class=\"bottom\">0</span>) = gcd(r<span class=\"bottom\">0</span>, b - k<span class=\"bottom\">1</span> * r<span class=\"bottom\">0</span>) [k<span class=\"bottom\">1</span> \u{2208} \u{2124}, ezért kicserélhető q<span class=\"bottom\">1</span>-re] = gcd(r<span class=\"bottom\">0</span>, b - q<span class=\"bottom\">1</span> * r<span class=\"bottom\">0</span>) 
                        = gcd(r<span class=\"bottom\">0</span>, r<span class=\"bottom\">1</span>) = ... = gcd(r<span class=\"bottom\">i-1</span>, r<span class=\"bottom\">i</span>) = gcd(r<span class=\"bottom\">i-1</span>, 0) = |r<span class=\"bottom\">i-1</span>| = r<span class=\"bottom\">i-1</span>.
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
                        r<span class=\"bottom\">-2</span> := 1*a + 0*b = a (m<span class=\"bottom\">-2</span> := 1, n<span class=\"bottom\">-2</span> := 0);<br>
                        r<span class=\"bottom\">-1</span> := 0*a + 1*b = b (m<span class=\"bottom\">-1</span> := 0, n<span class=\"bottom\">-1</span> := 1);<br>
                        r<span class=\"bottom\">0</span> = a - q<span class=\"bottom\">0</span> * b (m<span class=\"bottom\">0</span> := 1, n<span class=\"bottom\">0</span> := -q<span class=\"bottom\">0</span>);<br>
                        r<span class=\"bottom\">1</span> = b - q<span class=\"bottom\">1</span> * r<span class=\"bottom\">0</span> = b - q<span class=\"bottom\">1</span> * (a - q<span class=\"bottom\">0</span> * b) =  b * (1 + q<span class=\"bottom\">1</span> * q<span class=\"bottom\">0</span>) - q<span class=\"bottom\">1</span> * a (m<span class=\"bottom\">1</span> := -q<span class=\"bottom\">1</span>, n<span class=\"bottom\">1</span> := 1 + q<span class=\"bottom\">1</span> * q<span class=\"bottom\">0</span>);<br>
                        ...<br>
                        Tegyük fel, hogy a k.-ik (0 \u{2264} k \u{2264} (i - 1)) lépésig (a k.-ik már nem) minden maradékot fel tudtunk írni a és b lineáris kombinációjaként, 
                        vagyis r<span class=\"bottom\">k-2</span> = m<span class=\"bottom\">k-2</span> * a + n<span class=\"bottom\">k-2</span> * b és r<span class=\"bottom\">k-1</span> = m<span class=\"bottom\">k-1</span> * a + n<span class=\"bottom\">k-1</span> * b.<br>
                        Ekkor az Eukleidészi- algoritmus szerint: r<span class=\"bottom\">k</span> = r<span class=\"bottom\">k-2</span> - q<span class=\"bottom\">k</span> * r<span class=\"bottom\">k-1</span>
                        = m<span class=\"bottom\">k-2</span> * a + n<span class=\"bottom\">k-2</span> * b - q<span class=\"bottom\">k</span> * (m<span class=\"bottom\">k-1</span> * a + n<span class=\"bottom\">k-1</span> * b)
                        = a * (m<span class=\"bottom\">k-2</span> - q<span class=\"bottom\">k</span> * m<span class=\"bottom\">k-1</span>) + b*(n<span class=\"bottom\">k-2</span> - q<span class=\"bottom\">k</span> * n<span class=\"bottom\">k-1</span>)
                        = a * m<span class=\"bottom\">k</span>  + b*n<span class=\"bottom\">k</span> (m<span class=\"bottom\">k</span> := m<span class=\"bottom\">k-2</span> - q<span class=\"bottom\">k</span> * m<span class=\"bottom\">k-1</span>, n<span class=\"bottom\">k</span> := n<span class=\"bottom\">k-2</span> - q<span class=\"bottom\">k</span> * n<span class=\"bottom\">k-1</span>).
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Mivel gcd(a,b) = r<span class=\"bottom\">i-1</span>, és r<span class=\"bottom\">i-1</span> a kibővített Eukleidészi- algoritmus szerint felírható az a és b lineáris kombinációjaként, ezért a legnagyobb közös osztó is.
                        Ezt nevezzük Bézout- azonosságnak: gcd(a,b) = a * x + b * y ( = a * m<span class=\"bottom\">i-1</span> + b * n<span class=\"bottom\">i-1</span>) (x, y \u{2208} \u{2124}).
                        Adottak a \u{2124} \u{220B} a, b, c számok, továbbá tudjuk, hogy c | a * b és gcd(c, a) = 1, ekkor c | b. Bézout szerint, ekkor 1 = c * x + a * y (x, y \u{2208} \u{2124}), mind a két oldalt b-vel szorozva pedig b = c * x * b + a * b * y, ahol a b a jobb oldal mindkét tagját osztja, így pedig a bal oldalt, azaz a b-t is.
                        Következmény: ha a p szám prím és osztója az a * b szorzatnak, akkor osztója a-nak, vagy b-nek is. Sőt ez kiterjeszthető többtényezős szorzatra is.
                    </label>
                </div>"
            ];
        }

        /**
         * 
         * This function is responsible for creating the fourth set of tasks of Discrete Mathematics II. related to linear congruences.
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
                        Azt is beláttuk, hogy (a, b \u{2208} \u{2124})(m \u{2208} \u{2124}<span class=\"exp\">\u{2265}2</span>):a \u{2261} b (mod m) \u{2194} a = b + m * k (k \u{2208} \u{2124}) \u{2194} m | a - b. Jöjjön a kongruenciák néhány tulajdonsága.
                    </label>
                    <ul class=\"definition_list\">
                        <li><label>(\u{2200} a \u{2208} \u{2124})(\u{2200} m \u{2208} \u{2124}<span class=\"exp\">\u{2265}2</span>): a \u{2261} a (mod m) (ugyanis: m | 0 = a - a) (reflexivitás);</label></li>
                        <li><label>(\u{2200} a, b \u{2208} \u{2124})(\u{2200} m \u{2208} \u{2124}<span class=\"exp\">\u{2265}2</span>): a \u{2261} b (mod m) \u{2194} b \u{2261} a (mod m) (ugyanis: m | a - b \u{2194} m | b - a) (szimmetria);</label></li>
                        <li><label>(\u{2200} a, b, c \u{2208} \u{2124})(\u{2200} m \u{2208} \u{2124}<span class=\"exp\">\u{2265}2</span>): a \u{2261} b (mod m) \u{2227} b \u{2261} c (mod m) \u{2192} a \u{2261} c (mod m) (ugyanis: (m | a - b \u{2227} m | b - c) \u{2194} (m * k + b = a (k \u{2208} \u{2124}) \u{2227} m * l + c = b (l \u{2208} \u{2124})) \u{2194} (m * (k + l) = a - c) \u{2194} m | a - c) (tranzitivitás);</label></li>
                        <li><label>(\u{2200} a, b, c \u{2208} \u{2124})(\u{2200} m \u{2208} \u{2124}<span class=\"exp\">\u{2265}2</span>): a \u{2261} b (mod m) \u{2194} a \u{00B1} c \u{2261} b \u{00B1} c (mod m) (ugyanis: m | a - b \u{2194} m | a \u{00B1} c - (b \u{00B1} c) = a \u{00B1} c - b \u{2213} c = a - b);</label></li>
                        <li><label>(\u{2200} a, b, c \u{2208} \u{2124})(\u{2200} m \u{2208} \u{2124}<span class=\"exp\">\u{2265}2</span>): a \u{2261} b (mod m) \u{2192} a * c \u{2261} b * c (mod m) (ugyanis: m | a - b \u{2192} m | a * c - b * c = (a - b) * c);</label></li>
                        <li><label>(\u{2200} a, b, c \u{2208} \u{2124})(\u{2200} m \u{2208} \u{2124}<span class=\"exp\">\u{2265}2</span>): a * c \u{2261} b * c (mod m) \u{2192} a \u{2261} b (mod m/gcd(m,c)).</label></li>
                    </ul>
                </div>",
                "<div class=\"defined\">
                    <label class=\"definition_label\">
                        Lineáris kongruenciák megoldhatósága és lehetséges megoldása
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adottak a, b \u{2208} \u{2124} és m \u{2208} \u{2124}<span class=\"exp\">\u{2265}2</span> számok. Ekkor az a * x \u{2261} b (mod m) kongruenciát lineárisnak nevezzük.
                        A feladat az, hogy megkeressük azokat az x számokat, amellyel igaz állítást kapunk, azaz a * x és b azonos maradékot ad m-mel osztva.
                        Nem mindig lesz megoldható ez a feladat. Az ekvivalenciákat követve: a * x \u{2261} b (mod m) \u{2194} m | a * x - b \u{2194} a * x +  (-y) * m = b. Vegyük az a és m legnagyobb közös osztóját (jelöljük d-vel), ekkor az egyenlet a következő formát veszi fel: d * a<span class=\"bottom\">d</span> * x + d * m<span class=\"bottom\">d</span> * y = b. 
                        A bal oldal osztható d-vel, így pedig a jobb oldalnak is oszthatónak kell lennie. Az a * x \u{2261} b (mod m) lineáris kongruencia pontosan akkor oldható meg, ha (a,m) | b.
                        \"Sima\" kongruenciák esetén nincs ekvivalencia, például a (3,9) | 6, de 3 és 6 nem ad azonos maradékot 9-cel osztva. Ott ez szükséges, de nem elégséges feltétel.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Egy lehetsége megoldása az (a, b \u{2208} \u{2124} és m \u{2208} \u{2124}<span class=\"exp\">\u{2265}2</span>): a * x \u{2261} b (mod m) lineáris kongruenciának:<br>
                        1. lépés: ellenőrizzük, hogy (a, m) | b;<br>
                        2. lépés: ha a = 0, akkor |m| | b, ekkor megállhatunk, x bármi lehet; <br>
                        3. lépés: vesszük az a és b maradékát m-mel osztva;<br>
                        4. lépés: amíg a b nem osztható az a-val:<br>
                        4.1. lépés: b<span class=\"bottom\">+</span> := b;<br>
                        4.2. lépés: b<span class=\"bottom\">-</span> := b;<br>
                        4.3. lépés: amíg (a,b<span class=\"bottom\">+</span>) == 1 és (a,b<span class=\"bottom\">-</span>) == 1:<br>
                        4.3.1. lépés: b<span class=\"bottom\">+</span> := b<span class=\"bottom\">+</span> + m;<br>
                        4.3.2. lépés: b<span class=\"bottom\">-</span> := b<span class=\"bottom\">-</span> - m;<br>
                        4.4. lépés: ha (a,b<span class=\"bottom\">+</span>) == 1, akkor b := b<span class=\"bottom\">+</span>, különben b := b<span class=\"bottom\">-</span><br>
                        4.5. lépés: osztjuk a kongruenciát gcd(a, b)-vel;<br>
                        5. lépés: osztjuk a kongruenciát gcd(a,b) = a -val.
                    </label>
                </div>"
            ];
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