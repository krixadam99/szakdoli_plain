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
        }

        /**
         * 
         * This method is used to create the ninth set of tasks for Discrete mathematics I. related to graph creation.
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
        }
    }

?>