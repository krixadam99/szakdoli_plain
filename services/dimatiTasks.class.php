<?php
    /**
     * This is a helper class which contains task generator functions related to Discrete Mathematics I..
     * 
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

            // Task data
            $task_array = array(
                "task_description" => "Add meg az eredményét a következő műveleteknek! Válaszodban a karaktereket ','-vel válaszd el!",
                "set_of_sets" => $set_task["data"][0], 
                "operations" => $set_task["data"][1]
            );
            $this->task_descriptions = $task_array;

            // Task solutions
            $this->task_solutions = $set_task["solutions"];

            // The definitions related to sets
            $this->definitions = [
                "<div class=\"defined\">
                    <label class=\"definition_label\">
                        Halmaz:
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
                        Halmazok közötti műveletek:
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

            // Task data
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
                        Reláció:
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Az (a,b) rendezett pár alatt a {{a}, {a,b}} halmazt értjük (számít a sorrend). Az A és B halmazok Descartes (direkt, vagy cartesian) szorzata egy olyan halmaz, amely olyan rendezett párokat tartalmaz, melyek első eleme az A, második eleme pedig a B halmazban van benne. Formálisan: A \u{2A2F} B = { (a,b): a \u{2208} A \u{2227} b \u{2208} B}.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Az \u{2A2F}<span class=\"bottom\">i=1</span><span class=\"exp\">n</span>A<span class=\"bottom\">i</span> halmazok Descartes- szorzatának egy (nemüres) részhalmazát a felsorolt halmazokon értelmezett relációnak nevezzük. Amennyiben csak két halmaz van, akkor a relációt binárisnak nevezzük. Ha pedig a halmazok mind ugyanazok, akkor a reláció homogén.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        \u{2205} \u{2260} R \u{2286} A \u{2A2F} B formálisan: R = { (a,b) \u{2208} A \u{2A2F} B | a \u{2208} A \u{2227} b \u{2208} B}. Ha az (a,b) benne van az R relációban, akkor (a,b) \u{2208} R, helyett gyakran az <i>a R b</i> jelölést alkalmazzuk (az a R relációban áll b-vel).
                    </label>
                </div>",
                "<div class=\"defined\">
                    <label class=\"definition_label\">
                        Bináris relációk alapvető definíciói:
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adott \u{2205} \u{2260} R \u{2286} A \u{2A2F} B. Ekkor Dom<span class=\"bottom\">R</span> = { a \u{2208} A | \u{2203} b \u{2208} B: (a,b) \u{2208} R}. Ezt nevezzük az <b>R reláció értelmezési tartományának</b>. Informálisan: készítünk egy halmazt az R relációt alkotó rendezett párok első elemeiből.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adott \u{2205} \u{2260} R \u{2286} A \u{2A2F} B. Ekkor Ran<span class=\"bottom\">R</span> = { b \u{2208} B | \u{2203} a \u{2208} A: (a,b) \u{2208} R}. Ezt nevezzük az <b>R reláció értékkészletének</b>. Informálisan: készítünk egy halmazt az R relációt alkotó rendezett párok második elemeiből.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adott \u{2205} \u{2260} R \u{2286} A \u{2A2F} B és az N halmaz. Ekkor R<span class=\"bottom\">N</span> = { (a,b) \u{2208} R | a \u{2208} N } \u{2286} R. Ezt nevezzük az <b>R reláció N halmazra vett megszorítása</b>. Informálisan: kivesszük azokat a rendezett párokat R-ből, amik első elemei benne vannak N-ben.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adott \u{2205} \u{2260} R \u{2286} A \u{2A2F} B. Ekkor R<span class=\"exp\">-1</span> = { (b,a) | (a,b) \u{2208} R } \u{2286} B \u{2A2F} A. Ezt nevezzük az <b>R reláció inverzének</b>. Informálisan: az R reláció rendezett párjainak elemeit megfordítjuk.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adott \u{2205} \u{2260} R \u{2286} A \u{2A2F} B és az I halmaz. Ekkor R(I) = { b | a  \u{2208} I \u{2227} (a,b) \u{2208} R } \u{2286} Ran<span class=\"bottom\">R</span>. Ezt nevezzük az <b>R reláció I halmazon felvett képének</b>. Informálisan: kivesszük az R reláció rendezett párjainak azon második elemeit, ahol az első elem benne van az I halmazban.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adott \u{2205} \u{2260} R \u{2286} A \u{2A2F} B és az D halmaz. Ekkor R<span class=\"exp\">-1</span>(D) = { a | b  \u{2208} D \u{2227} (a,b) \u{2208} R } \u{2286} Dom<span class=\"bottom\">R</span>. Ezt nevezzük az <b>R reláció D halmazon felvett ősképének</b>. Informálisan: kivesszük az R reláció rendezett párjainak azon első elemeit, ahol a második elem benne van a D halmazban.
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

            // Task data
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
                        Relációk kompozíciója:
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adott \u{2205} \u{2260} R \u{2286} A \u{2A2F} B és \u{2205} \u{2260} S \u{2286} C \u{2A2F} D relációk, ahol az A, B, C és D halmazok nem feltétlen különbözőek. Az S \u{2218} R kompozíció alatt a következő relációt értjük: S \u{2218} R = { (a,d) \u{2208} A \u{2A2F} D | \u{2203} b \u{2208} B: (a,b) \u{2208} R \u{2227} (b,d) \u{2208} S }. Például a nagybácsija reláció a testvére és szülője relációk kompozíciója. Informálisan: a jobb oldali tag rendezett párjainak második elemeit \"összekötjük\" a bal oldali reláció rendezett párjainak azonos első elemeivel. Majd az összekötés során kapott hármasok 1. és 3. elemeiből képzett rendezett párjai alkotják a kompozíciót. Tulajdonságok: asszociatív, valamint: (R \u{2218} S)<span class=\"exp\">-1</span> = S<span class=\"exp\">-1</span> \u{2218} R<span class=\"exp\">-1</span>.
                    </label>
                </div>",
                "<div class=\"defined\">
                    <label class=\"definition_label\">
                        Homogén relációk tulajdonságai:
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adott \u{2205} \u{2260} R \u{2286} A \u{2A2F} A. Ekkor az R relációt reflexívnek nevezzük, ha (\u{2200} a \u{2208} A): (a,a) \u{2208} R.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adott \u{2205} \u{2260} R \u{2286} A \u{2A2F} A. Ekkor az R relációt irreflexívnek nevezzük, ha (\u{2200} a \u{2208} A): (a,a) \u{2209} R.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adott \u{2205} \u{2260} R \u{2286} A \u{2A2F} A. Ekkor az R relációt szimmetrikusnak nevezzük, ha (\u{2200} a,b \u{2208} A): (a,b) \u{2208} R \u{2192} (b,a) \u{2208} R.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adott \u{2205} \u{2260} R \u{2286} A \u{2A2F} A. Ekkor az R relációt antiszimmetrikusnak nevezzük, ha (\u{2200} a,b \u{2208} A): ((a,b) \u{2208} R \u{2227} (b,a) \u{2208} R) \u{2194} (a = b).
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adott \u{2205} \u{2260} R \u{2286} A \u{2A2F} A. Ekkor az R relációt asszimmetrikusnak nevezzük, ha (\u{2200} a,b \u{2208} A): (a,b) \u{2208} R \u{2227} (b,a) \u{2209} R.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adott \u{2205} \u{2260} R \u{2286} A \u{2A2F} A. Ekkor az R relációt tranzitívnak nevezzük, ha (\u{2200} a,b,c \u{2208} A): ((a,b) \u{2208} R \u{2227} (b,c) \u{2208} R) \u{2192} (a,c) \u{2208} R.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adott \u{2205} \u{2260} R \u{2286} A \u{2A2F} A. Ekkor az R relációt dichotómnak nevezzük, ha (\u{2200} a,b \u{2208} A)(a \u{2260} b): (a,b) \u{2208} R \u{2228} (b,a) \u{2208} R közül legalább az egyik teljesül.
                    </label>
                </div>
                <div class=\"definition\">
                    <label class=\"definition_label\">
                        Adott \u{2205} \u{2260} R \u{2286} A \u{2A2F} A. Ekkor az R relációt trihotómnak nevezzük, ha (\u{2200} a,b \u{2208} A): (a,b) \u{2208} R \u{2228} (b,a) \u{2208} R \u{2228} a = b közül pontosan egy teljesül.
                    </label>
                </div>"
            ];
        }

        /**
         * 
         * This method is used to create the fourth set of tasks for Discrete mathematics I. related to definitions about functions.
         * 
         * ...Subtasks created here...
         * 
         * @return void 
        */
        private function CreateTaskFour(){
            $is_relation_function = $this->dimati_subtask_generator->CreateSubtask("3", "0", 3, true);
            $function_characteristics = $this->dimati_subtask_generator->CreateSubtask("3", "1", 3, true);

            $task_array = array(
                "task_description" => "Old meg a következő függvényekkel kapcsolatos feladatokat!",
                "first_subtasks" => $is_relation_function["data"],
                "second_subtasks" => $function_characteristics["data"],
            );

            $solution_array = array("first_subtasks" => [], "second_subtasks" => []);
            foreach($is_relation_function["solutions"] as $solution_counter => $solution){
                $solution_array["first_subtasks"] = array_merge($solution_array["first_subtasks"], array("solution_0_" . $solution_counter=> $solution));
            } 
            foreach($function_characteristics["solutions"] as $solution_counter => $solution){
                $solution_array["second_subtasks"] = array_merge($solution_array["second_subtasks"], array("solution_1_" . $solution_counter => $solution));
            }            

            $this->task_descriptions = $task_array;
            $this->task_solutions = $solution_array;
        }

        /**
         * 
         * This method is used to create the fifth set of tasks for Discrete mathematics I. related to basic operations between complex numbers given by their algebraic form.
         * 
         * ...Subtasks created here...
         * 
         * @return void 
        */
        private function CreateTaskFive(){
            $basic_complex_number_subtask = $this->dimati_subtask_generator->CreateSubtask("4", "0", 1, true);
            $complex_numbers_operations_subtask = $this->dimati_subtask_generator->CreateSubtask("4", "1", 1, true);

            $task_array = array(
                "task_description" => "Old meg a következő komplex számok algebrai alakjával kapcsolatos feladatokat!",
                "first_subtasks" => $basic_complex_number_subtask["data"],
                "second_subtasks" => $complex_numbers_operations_subtask["data"]
            );

            $this->task_descriptions = $task_array;
            $this->task_solutions = [$basic_complex_number_subtask["solutions"],$complex_numbers_operations_subtask["solutions"]];
        }

        /**
         * 
         * This method is used to create the sixth set of tasks for Discrete mathematics I. related to operations between complex numbers given by their trigonometric form.
         * 
         * ...Subtasks created here...
         * 
         * @return void 
        */
        private function CreateTaskSix(){
            $complex_numbers_trigonometric_form_subtask = $this->dimati_subtask_generator->CreateSubtask("5", "0", 1, true);
            $complex_numbers_operations_subtask = $this->dimati_subtask_generator->CreateSubtask("5", "1", 1, true);

            $task_array = array(
                "task_description" => "Old meg a következő komplex számok algebrai alakjával kapcsolatos feladatokat!",
                "first_subtasks" => $complex_numbers_trigonometric_form_subtask["data"],
                "second_subtasks" => $complex_numbers_operations_subtask["data"]
            );

            $this->task_descriptions = $task_array;
            $this->task_solutions = [$complex_numbers_trigonometric_form_subtask["solutions"],$complex_numbers_operations_subtask["solutions"]];
        }

        /**
         * 
         * This method is used to create the seventh set of tasks for Discrete mathematics I. related to the powers of complex numbers.
         * 
         * ...Subtasks created here...
         * 
         * @return void 
        */
        private function CreateTaskSeven(){
            $complex_numbers_powers_subtask = $this->dimati_subtask_generator->CreateSubtask("6", "0", 1, true);
            $complex_numbers_roots_subtask = $this->dimati_subtask_generator->CreateSubtask("6", "1", 1, true);

            $task_array = array(
                "task_description" => "Old meg a következő komplex számok algebrai alakjával kapcsolatos feladatokat!",
                "first_subtasks" => $complex_numbers_powers_subtask["data"],
                "second_subtasks" => $complex_numbers_roots_subtask["data"]
            );

            $this->task_descriptions = $task_array;
            $this->task_solutions = [$complex_numbers_powers_subtask["solutions"],$complex_numbers_roots_subtask["solutions"]];
        }

        /**
         * 
         * This method is used to create the eight set of tasks for Discrete mathematics I. related to the binomial and polynomial theorem and the application of Viete formula.
         * 
         * ...Subtasks created here...
         * 
         * @return void 
        */
        private function CreateTaskEight(){
            $binomial_theorem_subtask = $this->dimati_subtask_generator->CreateSubtask("7", "0", 2);
            $viete_formula_subtask = $this->dimati_subtask_generator->CreateSubtask("7", "1", 2);

            $task_array = array(
                "task_description" => "Old meg a következő binomiális tétellel és viéte formulákkal kapcsolatos feladatokat!",
                "first_subtasks" => $binomial_theorem_subtask["data"],
                "second_subtasks" => $viete_formula_subtask["data"]
            );

            $this->task_descriptions = $task_array;
            $this->task_solutions = [$binomial_theorem_subtask["solutions"],$viete_formula_subtask["solutions"]];
        }

        /**
         * 
         * This method is used to create the ninth set of tasks for Discrete mathematics I. related to...
         * 
         * ...Subtasks created here...
         * 
         * @return void 
        */
        private function CreateTaskNine(){
            $simple_graph_subtask = $this->dimati_subtask_generator->CreateSubtask("8", "0", 2);
            $paired_graph_subtask = $this->dimati_subtask_generator->CreateSubtask("8", "1", 2);
            $tree_graph_subtask = $this->dimati_subtask_generator->CreateSubtask("8", "2", 2);
            $directed_graph_subtask = $this->dimati_subtask_generator->CreateSubtask("8", "3", 2);

            $task_array = array(
                "task_description" => "Old meg a következő bgráfok megszerkeszthetőségével kapcsolatos feladatokat!",
                "first_subtasks" => $simple_graph_subtask["data"],
                "second_subtasks" => $tree_graph_subtask["data"],
                "third_subtasks" => $paired_graph_subtask["data"],
                "fourth_subtasks" => $directed_graph_subtask["data"]
            );

            $this->task_descriptions = $task_array;
            $this->task_solutions = [$simple_graph_subtask["solutions"], $tree_graph_subtask["solutions"], $paired_graph_subtask["solutions"], $directed_graph_subtask["solutions"]];
        }
    }

?>