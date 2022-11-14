<?php
    /**
     * This is a helper class which contains task generator functions related to Discrete Mathematics I..
    */
    class DimatiTasks extends Task{    
        private $dimati_subtask_generator;
            
        /**
         * 
         * The contructor for DimatiTasks class.
         * 
         * Here the inherited members will be set.
         * Set and complex number names are also set here.
         * Based on the $topic parameter a new set of tasks will be generated.
         * 
         * @param string $topic The topic id for task generation.
         * 
         * @return void
         */
        public function __construct($topic){
            $this->task_descriptions = [];
            $this->task_solutions= [];
            $this->definitions = "";
            $this->topic = $topic;
            $this->dimati_subtask_generator = new DimatiSubtaskGenerator();
            mt_srand(time()); // Seeding the random number generator with the current time (we may change this overtime...).
        }

        /**
         * This public method will generate a task with certain subtasks according to the topic member, which is set by the constructor method.
         * 
         * Every task generator method has 2 main parts: subtask data and solution generation, then the related definitions.
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
         * This method is used to create the first set of tasks for Discrete mathematics I. related to basic set operations. Only one subtask (full subtask) will be generated here.
         * 
         * The practiced operations are: union, intersection, difference, complementer and symmetric difference.
         * 
         * @return void 
        */
        private function CreateTaskOne(){
            $set_task = $this->dimati_subtask_generator->CreateSubtask("0", "0", 1, true);

            // Adding the data to the task array.
            $task_array = array(
                "task_description" => "Add meg az eredményét a következő műveleteknek! Válaszodban a karaktereket ','-vel válaszd el!",
                "set_of_sets" => $set_task["data"][0], 
                "operations" => $set_task["data"][1]
            );
            $this->task_descriptions = $task_array;

            // Task solutions
            $this->task_solutions = $set_task["solutions"];

            // The definitions related to sets:
            $this->definitions = [
                "<div class=\"defined\">
                    <label class=\"definition_label\">
                        Halmazok
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Alapfogalom, így nem lehet definiálni. Körülírva: jól meghatározható dolgok összessége. Minden elemet egyszer tartalmazhat (minden eleme egyértelműen hivatkozható), az elemek sorrendje nem számít.
                    </label>
                    <br>
                    <label class=\"definition_label\">
                        Egy halmazt megadhatunk az elemeinek felsorolásával, vagy az elemek egy jól meghatározható tulajdonságával. A halmazokat konvenció szerint nagy betűvel jelöljük, az üres halmazt pedig a {}, vagy a \u{2205} jelekkel.
                    </label>
                    <br>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        A \u{2282} B : azt mondjuk, hogy az A halmaz valódi részhalmaza a B halmaznak, ha A minden eleme benne van a B-ben is, de B-nek van olyan eleme, amely A-ban nincsen benne.
                    </label>
                    <br>
                    <label class=\"definition_label\">
                        A \u{2286} B : azt mondjuk, hogy az A halmaz részhalmaza a B halmaznak, ha A minden eleme benne van a B-ben is, de B-nek lehet, hogy van olyan eleme, amely A-ban nincsen benne.
                    </label>
                    <br>
                    <label class=\"definition_label\">
                        Az A és B halmazok azonosak, ha egyrészt elemszámuk megegyezik, másrészt az A elemei benne vannak B-ben és fordítva (formálisan: A = B \u{2194} A \u{2286} B \u{2227} B \u{2286} A \u{2227} |A| = |B|). Ezt a feltételt több bizonyításban is használjuk.   
                    </label>
                </div>",
                "<div class=\"defined\">
                    <label class=\"definition_label\">
                        Halmazok közötti műveletek
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        A \u{222A} B (unió) : Olyan elemek összessége, melyek benne vannak az A, vagy a B halmazban (megengedő vagy, OR). Formálisan: A \u{222A} B = { x: x \u{2208} A \u{2228} x \u{2208} B }. Tulajdonságai: kommutatív, asszociatív, idempotens (A \u{222A} A = A).
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        A \u{2229} B (metszet) : Olyan elemek összessége, melyek benne vannak az A és a B halmazban is. Formálisan: A \u{2229} B = { x: x \u{2208} A \u{2227} x \u{2208} B }. Tulajdonságai: kommutatív, asszociatív, idempotens (A \u{2229} A = A).
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        A \ B (különbség) : Olyan elemek összessége, melyek benne vannak az A halmazban, de nincsenek benne a B-ben. Formálisan: A \ B = { x: x \u{2208} A \u{2227} x \u{2209} B }. Tulajdonságai: nem kommutatív, asszociatív, nem idempotens (A \ A \u{2260} A ( = \u{2205})).
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        <span style=\"text-decoration: overline\">A</span> (komplementer): Olyan elemek összessége, amelyek nincsenek benne az A (A \u{2286} U) halmazban, de benne vannak az alaphalmazban (U-ban). Formálisan: <span style=\"text-decoration: overline\">A</span> = { x: x \u{2208} U \u{2227} x \u{2209} A } \u{2286} U.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        A \u{2206} B (szimmetrikus differencia) : Olyan elemek összessége, melyek benne vannak vagy az A, vagy a B halmazban, de csak az egyikben (kizáró vagy, XOR). Formálisan: A \u{222A} B = { x: (x \u{2208} A \u{2227} x \u{2209} B) \u{2228} (x \u{2208} B \u{2227} x \u{2209} A) } = { x: (x \u{2208} A \u{222A} B) \u{2227} (x \u{2209} A \u{2229} B) }. Tulajdonságai: kommutatív, asszociatív, nem idempotens (A \u{2206} A \u{2260} A ( = \u{2205})).
                    </label>
                </div>"
            
            ];
        }

        /**
         * 
         * This method is used to create the second set of tasks for Discrete mathematics I. related to basic definitions about relations. Only one subtask (full subtask) will be generated here.
         * 
         * The practiced definitions are: domain, range, restriction to a sdet, inverse, image and inverse image by a set.
         * 
         * @return void 
        */
        private function CreateTaskTwo(){
            $relation_task = $this->dimati_subtask_generator->CreateSubtask("1", "0", 1, true);

            // Adding the data to the task array.
            $task_array = array(
                "task_description" => "Sorold fel az elemeket a reláció definícióinál! Az elemeket ','-vel válaszd el, a rendezett párokat (elem,elem) alakban add meg!",
                "sets" => $relation_task["data"]["sets"],
                "relations" => $relation_task["data"]["relations"]
            );
            $this->task_descriptions = $task_array;

            // Task solutions
            $this->task_solutions = $relation_task["solutions"];

            // The definitions related to sets
            $this->definitions = [
                "<div class=\"defined\">
                    <label class=\"definition_label\">
                        Relációk
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Az (a,b) rendezett pár alatt a {{a}, {a,b}} halmazt értjük (számít a sorrend). Az A és B halmazok Descartes (direkt, vagy cartesian) szorzata egy olyan halmaz, amely olyan rendezett párokat tartalmaz, melyek első eleme az A, második eleme pedig a B halmazban van benne. Formálisan: A \u{2A2F} B = { (a,b): a \u{2208} A \u{2227} b \u{2208} B}.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Az \u{2A2F}<sub>i=1</sub><sup>n</sup>A<sub>i</sub> halmazok Descartes- szorzatának egy (nemüres) részhalmazát a felsorolt halmazokon értelmezett relációnak nevezzük. Amennyiben csak két halmaz van, akkor a relációt binárisnak nevezzük. Ha pedig a halmazok mind ugyanazok, akkor a reláció homogén.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        \u{2205} \u{2260} R \u{2286} A \u{2A2F} B formálisan: R = { (a,b) \u{2208} A \u{2A2F} B | a \u{2208} A \u{2227} b \u{2208} B}. Ha az (a,b) benne van az R relációban, akkor (a,b) \u{2208} R, helyett gyakran az <i>a R b</i> jelölést alkalmazzuk (az a R relációban áll b-vel).
                    </label>
                </div>",
                "<div class=\"defined\">
                    <label class=\"definition_label\">
                        Bináris relációk alapvető definíciói
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adott \u{2205} \u{2260} R \u{2286} A \u{2A2F} B. Ekkor Dom<sub>R</sub> = { a \u{2208} A | \u{2203} b \u{2208} B: (a,b) \u{2208} R}. Ezt nevezzük az <b>R reláció értelmezési tartományának</b>. Informálisan: készítünk egy halmazt az R relációt alkotó rendezett párok első elemeiből.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adott \u{2205} \u{2260} R \u{2286} A \u{2A2F} B. Ekkor Ran<sub>R</sub> = { b \u{2208} B | \u{2203} a \u{2208} A: (a,b) \u{2208} R}. Ezt nevezzük az <b>R reláció értékkészletének</b>. Informálisan: készítünk egy halmazt az R relációt alkotó rendezett párok második elemeiből.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adott \u{2205} \u{2260} R \u{2286} A \u{2A2F} B és az N halmaz. Ekkor R<sub>N</sub> = { (a,b) \u{2208} R | a \u{2208} N } \u{2286} R. Ezt nevezzük az <b>R reláció N halmazra vett megszorítása</b>. Informálisan: kivesszük azokat a rendezett párokat R-ből, amik első elemei benne vannak N-ben.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adott \u{2205} \u{2260} R \u{2286} A \u{2A2F} B. Ekkor R<sup>-1</sup> = { (b,a) \u{2208} B \u{2A2F} A | (a,b) \u{2208} R } \u{2286} B \u{2A2F} A. Ezt nevezzük az <b>R reláció inverzének</b>. Informálisan: az R reláció rendezett párjainak elemeit megfordítjuk. 
                        Megjegyzendő tehát, hogy Dom<sub>f<sup>-1</sup></sub> = Ran<sub>f</sub> és Ran<sub>f<sup>-1</sup></sub> = Dom<sub>f</sub>.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adott \u{2205} \u{2260} R \u{2286} A \u{2A2F} B és az I halmaz. Ekkor R(I) = { b \u{2208} B | a  \u{2208} I \u{2227} (a,b) \u{2208} R } \u{2286} Ran<sub>R</sub>. Ezt nevezzük az <b>R reláció I halmazon felvett képének</b>. Informálisan: kivesszük az R reláció rendezett párjainak azon második elemeit, ahol az első elem benne van az I halmazban.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adott \u{2205} \u{2260} R \u{2286} A \u{2A2F} B és az D halmaz. Ekkor R<sup>-1</sup>(D) = { a \u{2208} A | b  \u{2208} D \u{2227} (a,b) \u{2208} R } \u{2286} Dom<sub>R</sub>. Ezt nevezzük az <b>R reláció D halmazon felvett ősképének</b>. Informálisan: kivesszük az R reláció rendezett párjainak azon első elemeit, ahol a második elem benne van a D halmazban.
                    </label>
                </div>"
            ];
        }

        /**
         * 
         * This method is used to create the third set of tasks for Discrete mathematics I. related to characteristics and composition of relations.
         * 
         * 3 types of subtask will be generated here (1-1 subtask per type). These are: relation composition, relation characteristics, and relation creation based on the given characteristics. 
         * 
         * @return void 
        */
        private function CreateTaskThree(){
            $relation_composition = $this->dimati_subtask_generator->CreateSubtask("2", "0", 1, true);
            $relation_characteristics = $this->dimati_subtask_generator->CreateSubtask("2", "1", 1, true);
            $relation_creation = $this->dimati_subtask_generator->CreateSubtask("2", "2", 1, true);

            // Adding the data to the task array.
            $task_array = array(
                "task_description" => "Old meg a következő relációk kompozíciójával és tulajdonságaival kapcsolatos feladatokat!",
                "set_triplets" => $relation_composition["data"]["set_triplets"],
                "relation_pairs" => $relation_composition["data"]["relation_pairs"],
                "characteristics_relation" => $relation_characteristics["data"],
                "characteristics" => $relation_creation["data"]
            );
            $this->task_descriptions = $task_array;

            // Task solutions
            $solution_array = array("first_subtasks" => [], "second_subtasks" => [], "third_subtasks" => []);
            foreach($relation_composition["solutions"] as $solution_counter => $solution){
                $solution_array["first_subtasks"] = array_merge($solution_array["first_subtasks"], array("solution_0_" . $solution_counter => $solution));
            } 
            foreach($relation_characteristics["solutions"] as $solution_counter => $solution){
                $solution_array["second_subtasks"] = array_merge($solution_array["second_subtasks"], array("solution_1_" . $solution_counter => $solution));
            } 
            foreach($relation_creation["solutions"] as $solution_counter => $solution){
                $solution_array["third_subtasks"] = array_merge($solution_array["third_subtasks"], array("solution_2_" . $solution_counter => $solution));
            }            
            $this->task_solutions = $solution_array;

            // The definitions related to relation characteristics and composition
            $this->definitions = [
                "<div class=\"defined\">
                    <label class=\"definition_label\">
                        Relációk kompozíciója
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adott \u{2205} \u{2260} R \u{2286} A \u{2A2F} B és \u{2205} \u{2260} S \u{2286} C \u{2A2F} D relációk, ahol az A, B, C és D halmazok nem feltétlen különbözőek. Az S \u{2218} R kompozíció alatt a következő relációt értjük: S \u{2218} R = { (a,d) \u{2208} A \u{2A2F} D | \u{2203} b \u{2208} B: (a,b) \u{2208} R \u{2227} (b,d) \u{2208} S }. Például a nagybácsija reláció a testvére és szülője relációk kompozíciója. Informálisan: a jobb oldali tag rendezett párjainak második elemeit \"összekötjük\" a bal oldali reláció rendezett párjainak azonos első elemeivel. Majd az összekötés során kapott hármasok 1. és 3. elemeiből képzett rendezett párjai alkotják a kompozíciót. Tulajdonságok: asszociatív, valamint: (R \u{2218} S)<sup>-1</sup> = S<sup>-1</sup> \u{2218} R<sup>-1</sup>.
                    </label>
                </div>",
                "<div class=\"defined\">
                    <label class=\"definition_label\">
                        Homogén relációk tulajdonságai
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adott \u{2205} \u{2260} R \u{2286} A \u{2A2F} A. Ekkor az R relációt <b>reflexívnek</b> nevezzük, ha (\u{2200} a \u{2208} A): (a,a) \u{2208} R.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adott \u{2205} \u{2260} R \u{2286} A \u{2A2F} A. Ekkor az R relációt <b>irreflexívnek</b> nevezzük, ha (\u{2200} a \u{2208} A): (a,a) \u{2209} R.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adott \u{2205} \u{2260} R \u{2286} A \u{2A2F} A. Ekkor az R relációt <b>szimmetrikusnak</b> nevezzük, ha (\u{2200} a,b \u{2208} A): (a,b) \u{2208} R \u{2192} (b,a) \u{2208} R.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adott \u{2205} \u{2260} R \u{2286} A \u{2A2F} A. Ekkor az R relációt <b>antiszimmetrikusnak</b> nevezzük, ha (\u{2200} a,b \u{2208} A): ((a,b) \u{2208} R \u{2227} (b,a) \u{2208} R) \u{2194} (a = b).
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adott \u{2205} \u{2260} R \u{2286} A \u{2A2F} A. Ekkor az R relációt <b>asszimmetrikusnak</b> nevezzük, ha (\u{2200} a,b \u{2208} A): (a,b) \u{2208} R \u{2227} (b,a) \u{2209} R.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adott \u{2205} \u{2260} R \u{2286} A \u{2A2F} A. Ekkor az R relációt <b>tranzitívnak</b> nevezzük, ha (\u{2200} a,b,c \u{2208} A): ((a,b) \u{2208} R \u{2227} (b,c) \u{2208} R) \u{2192} (a,c) \u{2208} R.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adott \u{2205} \u{2260} R \u{2286} A \u{2A2F} A. Ekkor az R relációt <b>dichotómnak</b> nevezzük, ha (\u{2200} a,b \u{2208} A)(a \u{2260} b): (a,b) \u{2208} R \u{2228} (b,a) \u{2208} R közül legalább az egyik teljesül.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adott \u{2205} \u{2260} R \u{2286} A \u{2A2F} A. Ekkor az R relációt <b>trihotómnak</b> nevezzük, ha (\u{2200} a,b \u{2208} A): (a,b) \u{2208} R \u{2228} (b,a) \u{2208} R \u{2228} a = b közül pontosan egy teljesül.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adott \u{2205} \u{2260} R \u{2286} A \u{2A2F} A. Ekkor az R relációt <b>ekvivalencia relációnak</b> nevezzük, ha reflexív, szimmetrikus és tranzitív. 
                        Legyen a ~ reláció ekvivalencia reláció, ekkor meghatározhatunk az alaphalmazán egy osztályozást. Ez egy olyan szuperhalmaz, amelyben a halmazok diszjunktak, nem üresek és uniójuk kiadja az alaphalmazt.
                        Egy osztály: [x] = { y | y ~ x } = {y | (y,x) \u{2208} ~}.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adott \u{2205} \u{2260} R \u{2286} A \u{2A2F} A. Ekkor az R relációt <b>részben rendezési relációnak</b> nevezzük, ha reflexív, antiszimmetrikus és tranzitív. Ha emellett még irreflexív is, akkor <b>szigorú részben rendezési reláció</b> az R.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adott \u{2205} \u{2260} R \u{2286} A \u{2A2F} A. Ekkor az R relációt <b>rendezési relációnak</b> nevezzük, ha részben rendezés és dichotóm. Ha emellett még irreflexív is, akkor <b>szigorú rendezési reláció</b> az R.
                    </label>
                </div>"
            ];
        }

        /**
         * 
         * This method is used to create the fourth set of tasks for Discrete mathematics I. related to definitions about functions.
         * 
         * 2 types of subtask will be generated here (3-3 subtasks per type). These are: function definition and function basic characteristics (surjectivity, injectivity and bijectivity). 
         * 
         * @return void 
        */
        private function CreateTaskFour(){
            $is_relation_function = $this->dimati_subtask_generator->CreateSubtask("3", "0", 3, true);
            $function_characteristics = $this->dimati_subtask_generator->CreateSubtask("3", "1", 3, true);

            // Adding the data to the task array.
            $task_array = array(
                "task_description" => "Old meg a következő függvényekkel kapcsolatos feladatokat!",
                "first_subtasks" => $is_relation_function["data"],
                "second_subtasks" => $function_characteristics["data"],
            );
            $this->task_descriptions = $task_array;

            // Task solutions
            $solution_array = array("first_subtasks" => [], "second_subtasks" => []);
            foreach($is_relation_function["solutions"] as $solution_counter => $solution){
                $solution_array["first_subtasks"] = array_merge($solution_array["first_subtasks"], array("solution_0_" . $solution_counter=> $solution));
            } 
            foreach($function_characteristics["solutions"] as $solution_counter => $solution){
                $solution_array["second_subtasks"] = array_merge($solution_array["second_subtasks"], array("solution_1_" . $solution_counter => $solution));
            }            
            $this->task_solutions = $solution_array;

            // The definitions related to functions and function characteristics
            $this->definitions = [
                "<div class=\"defined\">
                    <label class=\"definition_label\">
                        Függvények
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adott az f \u{2286} D \u{2A2F} R reláció. Azt mondjuk, hogy az f reláció függvény, ha bármely két rendezett pár első eleme különböző (azaz egyértelmű, vagyis bármely rendezett pár meghatározható egyértelműen az első eleme alapján). 
                        Formálisan: (x,y) \u{2208} f \u{2227} (x,z) \u{2208} f \u{2194} y = z. A rendezett párok első elemei a helyek, a második elemek pedig az értékek.
                        Ha f függvény és (a,b) \u{2208} f, akkor az <i>a f b</i> helyett az <i>f(a) = b</i> jelölést használjuk. Ekkor azt mondjuk, hogy az f függvény a b értéket veszi fel az a helyen.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Ha az f \u{2286} D \u{2A2F} R reláció függvény, akkor ezt így jelöljük: f \u{2208} D \u{2192} R. Ha Dom<sub>f</sub> = D, akkor a f : D \u{2192} R jelölést használjuk. Ekkor a D az alaphalmaz, az R a képhalmaz.
                        Az f függvény képe: graph(f) = { {{x}, {x,f(x)}} | x \u{2208} D } = {(x, f(x)) | x \u{2208} D}. Egyváltozós (skalár) függvény (azaz bináris reláció) esetén, a helyek az abszcisszán, az értékek pedig az ordinátán helyezkednek el. A nulvektor pedig az origó.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Az f és g függvények azonosak, ha értelmezési tartományuk (azaz Dom<sub>f</sub> és Dom<sub>g</sub>) azonosak, valamint bármely értelmezési tartomány béli helyen a függvények azonos értéket vesznek fel.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        A függvényeknél a relációk korábbi definíciói (értelmezési tartomány, értékkészlet, inverz, megszorítás halmazra, halmazon felvett őskép és kép), valamint relációk kompozícója azonos az ott látottakkal (ez abból következik, hogy a függvények speciális relációk). Valójában minimálisan módosulnak a definíciók az <i>a f b</i> és <i>f(a) = b</i> jelölésváltás miatt.
                    </label>
                </div>",
                "<div class=\"defined\">
                    <label class=\"definition_label\">
                        Függvények alapvető tulajdonságai
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Az f \u{2208} D \u{2192} R függvény <b>szürjektív</b>, ha Ran<sub>f</sub> = R. Formálisan: (\u{2200} b \u{2208} R)(\u{2203} a \u{2208} D): f(a) = b. Ha f és g szürjektív függvények, akkor kompozíciójuk is szürjektív függvény.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Az f \u{2208} D \u{2192} R függvény <b>injektív</b> (vagy <b>invertálható</b>), ha az inverz relációja függvény, azaz az inverze egyértelmű, vagyis bármely rendezett pár meghatározható egyértelműen a második eleme alapján. Formálisan: (\u{2200} x, y \u{2208} Dom<sub>f</sub>): f(x) = f(y) \u{2194} x = y. Másképpen (\u{2200} x, y \u{2208} Dom<sub>f</sub>): x \u{2260} y \u{2192} f(x) \u{2260} f(y). Ha f és g injektív függvények, akkor kompozíciójuk is injektív függvény.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Az f \u{2208} D \u{2192} R függvény <b>bijektív</b>, ha az f szürjektív és injektív. A korábbiakból következik, hogy ha f és g bijektív függvények, akkor kompozíciójuk is bijektív függvény.
                    </label>
                </div>"
            ];
        }

        /**
         * 
         * This method is used to create the fifth set of tasks for Discrete mathematics I. related to basic operations between complex numbers given by their algebraic form.
         * 
         * 2 types of subtask will be generated here (1-1 subtasks per type). These are: complex number basic characteristics and operations between complex numbers. 
         * 
         * @return void 
        */
        private function CreateTaskFive(){
            $basic_complex_number_subtask = $this->dimati_subtask_generator->CreateSubtask("4", "0", 1, true);
            $complex_numbers_operations_subtask = $this->dimati_subtask_generator->CreateSubtask("4", "1", 1, true);

            // Adding the data to the task array.
            $task_array = array(
                "task_description" => "Old meg a következő komplex számok algebrai alakjával kapcsolatos feladatokat!",
                "first_subtasks" => $basic_complex_number_subtask["data"],
                "second_subtasks" => $complex_numbers_operations_subtask["data"]
            );
            $this->task_descriptions = $task_array;

            // Task solutions
            $this->task_solutions = [$basic_complex_number_subtask["solutions"],$complex_numbers_operations_subtask["solutions"]];

            // The definitions related to complex numbers' basic characteristics and operations between them
            $this->definitions = [
                "<div class=\"defined\">
                    <label class=\"definition_label\">
                        Komplex számok
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Pongyolán fogalmazva, minden számhalmaz esetén egy újabbat akkor vezettünk be, amikor valamilyen művelet korlátozva lett a számhalmazon (nem zárt már a számhalmazon).
                        A természetes számok körében az összeadás és szorzás zárt, de a kivonás kivezetett az egészek körébe (inverz hiánya a nem nulla természetes számoknál az összeadásra nézve). Az egészek zártak a hozzáadásra nézve, viszont az osztás nem mindig eredményezett egész számot (inverz hiánya nem nulla egészeknél a szorzásra nézve).
                        Így jutottunk el a racionális számokhoz, ahol pedig már az alapműveletek elvégezhetők voltak, viszont a hatványozásnál csak a egész kitevőt lehetett venni. Így pedig a nem egész kitevős hatványozás során jutunk el a valós számokhoz, melyek a racionális és irracionális számok uniója.
                        Fontos megjegyezni, hogy még mindig voltak korlátozások. Például páros gyököt csakis nemnegatív szám esetén vehettünk (ugyanis bármely szám páros kitevős hatványa nemnegatív, míg páratlan kitevős szám lehet negatív is).
                        Ahhoz, hogy a gyökvonást korlátozás nélkül elvégezhessük, be lett vezetve az imaginárius egység, az i, melynek négyzete a -1. A komplex számok halmaza tehát olyan számhalmaz, amely a valós és imaginárius számok halmazának uniója.
                        A bővítés során folyamatosan figyelni kellett arra, hogy a korábbi műveleti tulajdonságok megmaradjanak. A komplex számok közötti műveletek is így lettek definiálva. A szorzás és összeadás műveleteie így továbbra is teljesülnek a test axiómák (ZANIK - ábel csoport (az adott művelet zárt, asszociatív, van neutrális eleme, van inverz elem valamennyi elemnek, kommutatív), valamint a 2 művelet esetén van 2 oldali disztributivitás).
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        A fentiek szerint valamennyi valós szám felírható egy valós és egy imaginárius szám összegeként. Így a \u{2102} \u{220B} w = a + b * i (a, b \u{2208} \u{211D}), ahol Re(w) = a, a w szám valós, az Im(w) = b pedig a képzetes része. A valós számok esetén a képzetes rész 0.
                        <br>
                        A \u{2102} \u{220B} w = a + b * i (a, b \u{2208} \u{211D}) komplex szám konjugáltja alatt a <span style=\"text-decoration : overline\">w</span> = a - b*i komplex számot értjük.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        A \u{2102} \u{220B} w = a + b * i (a, b \u{2208} \u{211D}) komplex szám hossza alatt a \u{221A}(w*<span style=\"text-decoration : overline\">w</span>) = \u{221A}(a<sup>2</sup> + b<sup>2</sup>) valós számot értjük, ezt a |w|-vel jelöljük. Tulajdonságok: |a| = 0, pontosan akkor, ha az a = 0; (\u{2200} a, b \u{2208} \u{2102}):|a*b| = |a|*|b|; (\u{2200} a, b \u{2208} \u{2102}): |a|/|b| = |a/b|, végül a háromszög- egyenlőtlenség: (\u{2200} a, b \u{2208} \u{2102}): |a + b| \u{2264} |a| + |b|.
                    </label>
                </div>",
                "<div class=\"defined\">
                    <label class=\"definition_label\">
                        Komplex számok közötti műveletek
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        A komplex számok közötti műveleteket úgy kellett definiálni, hogy azok a valós számok esetén (tehát, amikor a képzetes rész 0) megtartsák a tulajdonságaikat.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adott \u{2102} \u{220B} w = a + b * i (a, b \u{2208} \u{211D}) és \u{2102} \u{220B} z = c + d * i (c, d \u{2208} \u{211D}). Ekkor a <b>w \u{00B1} z = (a \u{00B1} c) + i * (b \u{00B1} d)</b>.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adott \u{2102} \u{220B} w = a + b * i (a, b \u{2208} \u{211D}) és \u{2102} \u{220B} z = c + d * i (c, d \u{2208} \u{211D}). Ekkor a <b>w * z = (a * c - b * d) + i * (a * d + b * c)</b>.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                    Adott \u{2102} \u{220B} w = a + b * i (a, b \u{2208} \u{211D}) és \u{2102} \u{220B} z = c + d * i (c, d \u{2208} \u{211D}). Ekkor a <b>w / z</b> 
                    = (w * <span style=\"text-decoration : overline\">z</span>) / |z|<sup>2</sup>
                    = <b>((a * c + b * d) + i * (b * c - a * d)) / (c<sup>2</sup> + d<sup>2</sup>)</b>.
                    </label>
                </div>"
            ];
        }

        /**
         * 
         * This method is used to create the sixth set of tasks for Discrete mathematics I. related to operations between complex numbers given by their trigonometric form.
         * 
         * 2 types of subtask will be generated here (1-1 subtasks per type). These are: trigonometric forms, and multiplication and division with these forms.
         * 
         * @return void 
        */
        private function CreateTaskSix(){
            $complex_numbers_trigonometric_form_subtask = $this->dimati_subtask_generator->CreateSubtask("5", "0", 1, true);
            $complex_numbers_operations_subtask = $this->dimati_subtask_generator->CreateSubtask("5", "1", 1, true);

            // Adding the data to the task array.
            $task_array = array(
                "task_description" => "Old meg a következő komplex számok trigonometrikus alakjával kapcsolatos feladatokat!",
                "first_subtasks" => $complex_numbers_trigonometric_form_subtask["data"],
                "second_subtasks" => $complex_numbers_operations_subtask["data"]
            );
            $this->task_descriptions = $task_array;

            // Task solutions
            $this->task_solutions = [$complex_numbers_trigonometric_form_subtask["solutions"],$complex_numbers_operations_subtask["solutions"]];

            // The definitions related to complex numbers' trigonometric forms, and multiplication and division with these forms
            $this->definitions = [
                "<div class=\"defined\">
                    <label class=\"definition_label\">
                        Komplex számok trigonometrikus alakja
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Gauss- számsík: ha a derékszögű koordináta-rendszerben az x- tengelyen a valós számokat, az y- tengelyen pedig a képzetes egység számsorosait ábrázoljuk, akkor minden egyes pontnak a koordináta- rendszerben megfeleltethető egy komplex szám. Így a komplex számok valójában olyan síkvektorok, amelyek egyben helyvektorok is.
                        A komplex számokat ezután már jelölhetjük a két koordinátájukkal is. Például: \u{2102} \u{220B} w = a + b * i = (a, b) (a, b \u{2208} \u{211D}). Ez a komplex szám geometrikus alakja.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        A műveletek, valamint néhány tulajdonság geometriai értelemben sokkal szemléletesebb ebben az ábrázolásban: egy komplex szám hossza az őt reprezentáló vektor hossza (valós számok esetén továbbra is a 0-tól (origótól) vett távolság); 
                        a konjugált a vektor x tengelyre vett tükörképe; 
                        2 komplex szám szorzata (és a hatványozás is) forgatva való nyújtást jelent; 
                        2 vektor összeadása, az eltolással azonos;
                        komplex szám konjugálttal való szorzása esetén először vesszük a vektor merőleges vetületét az x- tengelyre, majd ezt nyújtjuk a vektor hosszával.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        A komplex szám argumentuma az x- tengellyel bezárt szöge. Ha tehát \u{2102} \u{220B} w = a + b * i = (a, b) (a, b \u{2208} \u{211D}), akkor a bezárt szög = <b>arctan(b/a) = arcsin(b/|w|) = arccos(a/|w|)</b>. A w argumentumát az <b>arg(w)</b>-vel jelöljük. Ezt pedig az egyszerűség kedvéért a \u{03C6} görög betűvel fogom jelölni.
                        Természetesen a korábbi összefüggésekből egyszerű átrendezések után adódik, hogy a = cos(\u{03C6}) * |w| és b = sin(\u{03C6}) * |w|, így <b>w = a + b * i = |w| * (cos(\u{03C6}) + i * sin(\u{03C6}))</b>.
                    </label>
                </div>",
                "<div class=\"defined\">
                    <label class=\"definition_label\">
                        Műveletek trigonometrikus alakkal
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Legyen \u{2102} \u{220B} w = |w| * (cos(\u{03C6}<sub>1</sub>) + i * sin(\u{03C6}<sub>1</sub>)) és \u{2102} \u{220B} z = |z| * (cos(\u{03C6}<sub>2</sub>) + i * sin(\u{03C6}<sub>2</sub>)).
                        Ekkor <b>w * z = |w| * |z| * (cos(\u{03C6}<sub>1</sub> + \u{03C6}<sub>2</sub>) + i * sin(\u{03C6}<sub>1</sub> + \u{03C6}<sub>2</sub>))</b>.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Legyen \u{2102} \u{220B} w = |w| * (cos(\u{03C6}<sub>1</sub>) + i * sin(\u{03C6}<sub>1</sub>)) és \u{2102} \u{220B} z = |z| * (cos(\u{03C6}<sub>2</sub>) + i * sin(\u{03C6}<sub>2</sub>)).
                        Ekkor <b>w / z = (|w| / |z|) * (cos(\u{03C6}<sub>1</sub> - \u{03C6}<sub>2</sub>) + i * sin(\u{03C6}<sub>1</sub> - \u{03C6}<sub>2</sub>))</b>.
                    </label>
                </div>"
            ];
        }

        /**
         * 
         * This method is used to create the seventh set of tasks for Discrete mathematics I. related to the powers of complex numbers.
         * 
         * 2 types of subtask will be generated here (1-1 subtasks per type). These are: raising complex numbers to powers and taking their roots by their trignometric forms.
         * 
         * @return void 
        */
        private function CreateTaskSeven(){
            $complex_numbers_powers_subtask = $this->dimati_subtask_generator->CreateSubtask("6", "0", 1, true);
            $complex_numbers_roots_subtask = $this->dimati_subtask_generator->CreateSubtask("6", "1", 1, true);

            // Adding the data to the task array.
            $task_array = array(
                "task_description" => "Old meg a következő komplex számok algebrai alakjával kapcsolatos feladatokat!",
                "first_subtasks" => $complex_numbers_powers_subtask["data"],
                "second_subtasks" => $complex_numbers_roots_subtask["data"]
            );
            $this->task_descriptions = $task_array;
            
            // Task solutions
            $this->task_solutions = [$complex_numbers_powers_subtask["solutions"],$complex_numbers_roots_subtask["solutions"]];

            // The definitions related to complex numbers' trigonometric forms, and multiplication and division with these forms
            $this->definitions = [
                "<div class=\"defined\">
                    <label class=\"definition_label\">
                        Komplex számok hatványozása trigonometrikus alak segítségével
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Legyen \u{2102} \u{220B} w = |w| * (cos(\u{03C6}) + i * sin(\u{03C6})).
                        Ekkor <b>(\u{2200} m \u{2208} \u{2124}): w<sup>m</sup> = |w|<sup>m</sup> * (cos(m * \u{03C6}) + i * sin(m * \u{03C6}))</b>.
                    </label>
                </div>",
                "<div class=\"defined\">
                    <label class=\"definition_label\">
                        Komplex számok gyökvonása trigonometrikus alak segítségével
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Legyen \u{2102} \u{220B} w = |w| * (cos(\u{03C6}) + i * sin(\u{03C6})).
                        Ekkor <b>(\u{2200} m \u{2208} \u{2124}): <sup>m</sup>\u{221A}w = <sup>m</sup>\u{221A}|w| (cos((\u{03C6} + 2 * k * \u{03C0}) / m) + i * sin((\u{03C6} + 2 * k * \u{03C0}) / m))</b> (k = 0,1,..,m-1).
                    </label>
                </div>",
                "<div class=\"defined\">
                    <label class=\"definition_label\">
                        Komplex szám rendje és egységgyökök
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Legyen \u{2102} \u{220B} w = |w| * (cos(\u{03C6}) + i * sin(\u{03C6})).
                        Ekkor a komplex szám rendjének azt a legkisebb pozitív egészet nevezzük, amelyre a számot emelve önmagát kapjuk. Ha nincsen ilyen szám, akkor végtelen a rend.
                        Mivel egy komplex szám hatványozás geometriai értelemben a forgatva nyújtás, így ahhoz, hogy a rend véges legyen, szükséges az, hogy a komplex szám hossza 1 legyen.
                        Ha \u{03C6} = (p / q) * 2 * \u{03C0} (ahol (p, q) = 1), akkor a w rendje q.
                        Tehát 1 hosszú komplexek esetén a hatványok periodikusan ismétlődnek, a periódus hosszát pedig a rend határozza meg.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Azt mondjuk, hogy a w komplex szám az n.-ik egységyök, ha w<sup>n</sup> = 1. Előzőek szerint ekkor: \u{03C6} = (p / n) * 2 * \u{03C0} alakú (ahol (p, n) = 1). 
                        Ha nincsen olyan osztója n-nek, amelyre a w-t emelve 1-et kapnánk, de a w n.-ik egységgyök, akkor a w-t n.-ik primitív egységgyöknek nevezzük.
                    </label>
                </div>"
            ];
        }

        /**
         * 
         * This method is used to create the eight set of tasks for Discrete mathematics I. related to the binomial and polynomial theorem and the application of Viete formula.
         * 
         * 2 types of subtask will be generated here (2-2 subtasks per type). These are: binomial theorem and the usage of viéte formula.
         * 
         * @return void 
        */
        private function CreateTaskEight(){
            $binomial_theorem_subtask = $this->dimati_subtask_generator->CreateSubtask("7", "0", 2);
            $viete_formula_subtask = $this->dimati_subtask_generator->CreateSubtask("7", "1", 2);

            // Adding the data to the task array.
            $task_array = array(
                "task_description" => "Old meg a következő binomiális tétellel és viéte formulákkal kapcsolatos feladatokat!",
                "first_subtasks" => $binomial_theorem_subtask["data"],
                "second_subtasks" => $viete_formula_subtask["data"]
            );

            $this->task_descriptions = $task_array;

            // Task solutions
            $this->task_solutions = [$binomial_theorem_subtask["solutions"],$viete_formula_subtask["solutions"]];

            
            // The definitions related to complex numbers' trigonometric forms, and multiplication and division with these forms
            $this->definitions = [
                "<div class=\"defined\">
                    <label class=\"definition_label\">
                        Binomiális tétel
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adott az \u{2124} \u{220B} k szám. Ekkor a k szám faktoriálisa alatt a következőt értjük: k! = 0 (ha k < 0) és k! = \u{220F}<sup>k</sup><sub>i=1</sub>i (ha k > 0) és 1, ha k = 0.
                        Adottak az n, m \u{220B} \u{2124} egészek, ahol n \u{2265} m. Ekkor a (n alatt az m) = n! / (m! * (n - m)!) egészet binomiális együtthatónak nevezzük. Erre az \u{276C} n alatt m \u{276D} jelölést használjuk az oldalon. 
                        Tulajdonságok: \u{276C} n alatt m \u{276D} = \u{276C} n alatt (m-n) \u{276D}; \u{276C} (n-1) alatt m \u{276D} + \u{276C} (n-1) alatt (m-1) \u{276D} = \u{276C} n alatt m \u{276D}.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        <b>Binomiális tétel: (a + b)<sup>n</sup> = \u{220F}<sup>n</sup><sub>i=0</sub>\u{276C} n alatt i \u{276D}a<sup>i</sup>b<sup>n-i</sup></b>, 
                        ugyanis az i.-ik (i \u{2208} {0,1,...,n}) lépés során, i darab zárójel esetén választunk a-t és n-i esetén b-t. Ismétlés nélküli kombináció esetén pedig n darab zárójelből i darabot \u{276C} n alatt i \u{276D} féle képpen lehet kiválasztani.
                        Tulajdonságok: (1+1)<sup>n</sup> = 2<sup>n</sup> = \u{220F}<sup>n</sup><sub>i=0</sub>\u{276C} n alatt i \u{276D} = \u{276C} n alatt 0 \u{276D} + ... + \u{276C} n alatt n \u{276D}, azaz egy halmaz részhalmazainak száma 2<sup>halmaz elemszáma</sup> (0 elemű, 1 elemű, ..., n elemű részhalmazok száma);
                        0<sup>n</sup> = \u{220F}<sup>n</sup><sub>i=0</sub>\u{276C} n alatt i \u{276D}1<sup>i</sup>(-1)<sup>n-i</sup> = \u{276C} n alatt 0 \u{276D} - \u{276C} n alatt 1 \u{276D} + ... \u{00B1} \u{276C} n alatt n \u{276D}, azaz egy halmaz páros és páratlan elemszámú részhalmazainak száma azonos.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Polinomiális tétel: (a<sub>1</sub> + ... + a<sub>k</sub>)<sup>n</sup> = \u{220F}<sub>i<sub>1</sub>+...+i<sub>k</sub> = n</sub>(x<sub>1</sub><sup>i<sub>1</sub></sup>*...*x<sub>k</sub><sup>i<sub>k</sub></sup>) * n!/(i<sub>1</sub>!*...*i<sub>k</sub>!).
                    </label>
                </div>",
                "<div class=\"defined\">
                    <label class=\"definition_label\">
                        Általánosított Viéte- formula
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adott egy n-ed fokú polinom az a<sub>n</sub> * (x - x<sub>1</sub>) * (x - x<sub>2</sub>) * ... * (x - x<sub>n</sub>) szorzatalakban.
                        Ekkor megszeretnénk kapni a polinom a<sub>n</sub> * x<sup>n</sup> + ... + a<sub>1</sub> * x + a<sub>0</sub> összegalakját, azaz az a<sub>i</sub>-ket (i \u{2208} {0,1,...,n}). 
                        Az a<sub>i</sub> esetén ehhez i darab zárójelben kell x-et választani, a többiben pedig a konstans tagot. Ez persze azt jelenti, hogy n - i darab konstans tagot választunk és ebből \u{276C} n alatt i \u{276D} van.
                        Azaz egy olyan \u{276C} n alatt i \u{276D} tagú összeget kapunk az i.-ik együttható meghatározásánál, melyben minden tag n - i darab gyököt tartalmazó szorzat (összes lehetséges n - i elemszámú kombinációját kivesszük az n darab gyöknek, majd az egyes kombinációkban lévő elemeket szorozzuk össze).
                        Eszerint az i.-ik (i \u{2208} {0,1,...,n}) együttható képlete:
                        <b>a<sub>i</sub> = a<sub>n</sub> * (-1)<sup>(n-i)</sup> * \u{2211}<sub>1 \u{2264} j<sub>1</sub> < j<sub>2</sub> < ... < j<sub>(n - i)</sub> \u{2264} n</sub>x<sub>j<sub>1</sub></sub>* ... *x<sub>j<sub>(n-i)</sub></sub></b>.
                    </label>
                </div>"
            ];
        }

        /**
         * 
         * This method is used to create the ninth set of tasks for Discrete mathematics I. related to...
         * 
         * 4 types of subtask will be generated here (2 subtasks per type). These are: can we create the simple, paired, tree and directed graphs given by their degrees.
         * 
         * @return void 
        */
        private function CreateTaskNine(){
            $simple_graph_subtask = $this->dimati_subtask_generator->CreateSubtask("8", "0", 2);
            $paired_graph_subtask = $this->dimati_subtask_generator->CreateSubtask("8", "1", 2);
            $tree_graph_subtask = $this->dimati_subtask_generator->CreateSubtask("8", "2", 2);
            $directed_graph_subtask = $this->dimati_subtask_generator->CreateSubtask("8", "3", 2);

            // Adding the data to the task array.
            $task_array = array(
                "task_description" => "Old meg a következő bgráfok megszerkeszthetőségével kapcsolatos feladatokat!",
                "first_subtasks" => $simple_graph_subtask["data"],
                "second_subtasks" => $tree_graph_subtask["data"],
                "third_subtasks" => $paired_graph_subtask["data"],
                "fourth_subtasks" => $directed_graph_subtask["data"]
            );
            $this->task_descriptions = $task_array;

            // Task solutions
            $this->task_solutions = [$simple_graph_subtask["solutions"], $tree_graph_subtask["solutions"], $paired_graph_subtask["solutions"], $directed_graph_subtask["solutions"]];
        
            // The definitions related to graphs, and necessary and sufficients conditions for creating simple, paired, tree and directed graphs. 
            $this->definitions = [
                "<div class=\"defined\">
                    <label class=\"definition_label\">
                        Gráfok
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Gráfok megszerkeszthetősége:
                    </label>
                </div>",
                "<div class=\"defined\">
                    <label class=\"definition_label\">
                        Egyszerű gráf megszerkeszthetősége:
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                    </label>
                </div>",
                "<div class=\"defined\">
                    <label class=\"definition_label\">
                        Páros gráf megszerkeszthetősége:
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                    </label>
                </div>",
                "<div class=\"defined\">
                    <label class=\"definition_label\">
                        Fagráf megszerkeszthetősége:
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                    </label>
                </div>",
                "<div class=\"defined\">
                    <label class=\"definition_label\">
                        Irányított gráf megszerkeszthetősége:
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