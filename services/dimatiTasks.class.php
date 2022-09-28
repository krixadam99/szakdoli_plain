<?php
    /**
     * This is a helper class which contains task generator functions related to Discrete Mathematics I..
     * 
    */
    class DimatiTasks extends Task{        
        private $complex_number_names;
        private $dimat_helper_functions;

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
            $this->task_description = [];
            $this->task_solutions= [];
            $this->definitions = "";
            $this->topic = $topic;

            $this->complex_number_names = ["v", "w", "x", "y", "z"]; // The complex number names used throughout the task generation.
            $this->dimat_helper_functions = new DimatiHelperFunctions();
            $this->dimati_subtasks = new DimatiSubtask();

            mt_srand(time()); // Seeding the random number generator with the current time (we may change this overtime...).
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
                case "9":{
                    $this->CreateTaskTen();
                };
                break;
                default:break;
            }
        }

        /**
         * 
         * This method is used to create the first set of tasks for Discrete mathematics I. related to basic set operations.
         * 
         * ...Subtasks created here...
         * 
         * @return void 
        */
        private function CreateTaskOne(){
            $set_task = $this->dimati_subtasks->CreateSubtask("0", "0", 1, true);

            $task_array = array(
                "task_description" => "Add meg az eredményét a következő műveleteknek! Válaszodban a karaktereket ','-vel válaszd el!",
                "set_of_sets" => $set_task["data"][0], 
                "operations" => $set_task["data"][1]
            );

            $this->task_description = $task_array;
            $this->task_solutions = $set_task["solutions"];
        }

        /**
         * 
         * This method is used to create the second set of tasks for Discrete mathematics I. related to basic definitions about relation.
         * 
         * ...Subtasks created here...
         * 
         * @return void 
        */
        private function CreateTaskTwo(){
            $relation_task = $this->dimati_subtasks->CreateSubtask("1", "0", 1, true);

            $task_array = array(
                "task_description" => "Sorold fel az elemeket a reláció definícióinál! Az elemeket ','-vel válaszd el, a rendezett párokat (elem,elem) alakban add meg!",
                "sets" => $relation_task["data"]["sets"],
                "relations" => $relation_task["data"]["relations"]
            );

            $this->task_description = $task_array;
            $this->task_solutions = $relation_task["solutions"];
        }

        /**
         * 
         * This method is used to create the third set of tasks for Discrete mathematics I. related to characteristics and composition of relations.
         * 
         * ...Subtasks created here...
         * 
         * @return void 
        */
        private function CreateTaskThree(){
            $relation_composition = $this->dimati_subtasks->CreateSubtask("2", "0", 1, true);
            $relation_characteristics = $this->dimati_subtasks->CreateSubtask("2", "1", 1, true);
            $relation_creation = $this->dimati_subtasks->CreateSubtask("2", "2", 1, true);

            $task_array = array(
                "task_description" => "Old meg a következő relációk kompozíciójával és tulajdonságaival kapcsolatos feladatokat!",
                "set_triplets" => $relation_composition["data"]["set_triplets"],
                "relation_pairs" => $relation_composition["data"]["relation_pairs"],
                "characteristics_relation" => $relation_characteristics["data"],
                "characteristics" => $relation_creation["data"]
            );

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

            $this->task_description = $task_array;
            $this->task_solutions = $solution_array;
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
            $set_A = $this->dimat_helper_functions->CreateSets(1, 10, false)[0];
            $set_B = $this->dimat_helper_functions->CreateSets(1, mt_rand(4, 7), false)[0];

            $first_relation = $this->dimat_helper_functions->CreateDescartesProduct($set_A, $set_B, mt_rand(3, 6));
            $second_relation = $this->dimat_helper_functions->CreateDescartesProduct($set_A, $set_B, mt_rand(3, 6));
            $third_relation = $this->dimat_helper_functions->CreateDescartesProduct($set_A, $set_B, mt_rand(3, 6));
            
            $first_function_relation = $this->dimat_helper_functions->MakeFunction($set_A, $set_B, mt_rand(4, 10));
            $second_function_relation = $this->dimat_helper_functions->MakeFunction($set_A, $set_B, mt_rand(4, 10));
            $third_function_relation = $this->dimat_helper_functions->MakeFunction($set_A, $set_B, mt_rand(4, 10));

            $task_array = array(
                "task_description" => "Old meg a következő feladatokat!",
                "sets" => array("A" => $set_A, "B" => $set_B),
                "relations" => array(
                    "R \u{2286} A \u{00D7} B, R" => $first_relation, 
                    "S \u{2286} A \u{00D7} B, S" => $second_relation,
                    "T \u{2286} A \u{00D7} B, T" => $third_relation),
                "functions" => array(
                    "f \u{2208} A \u{2192} B" => $first_function_relation,
                    "g \u{2208} A \u{2192} B" => $second_function_relation,
                    "h \u{2208} A \u{2192} B" => $third_function_relation,
                )
            );

            $solution_array = array(
                "solution_0" => array(
                    $this->dimat_helper_functions->IsFunction($first_relation),
                    $this->dimat_helper_functions->IsFunction($second_relation),
                    $this->dimat_helper_functions->IsFunction($third_relation)
                ),
                "solution_1" => array(
                    "first_function" => array(
                        $this->dimat_helper_functions->IsSurjective($first_function_relation, $set_B),
                        $this->dimat_helper_functions->IsInjective($first_function_relation),
                        $this->dimat_helper_functions->IsBijective($first_function_relation, $set_B)
                    ),
                    "second_function" => array(
                        $this->dimat_helper_functions->IsSurjective($second_function_relation, $set_B),
                        $this->dimat_helper_functions->IsInjective($second_function_relation),
                        $this->dimat_helper_functions->IsBijective($second_function_relation, $set_B)
                    ),
                    "third_function" => array(
                        $this->dimat_helper_functions->IsSurjective($third_function_relation, $set_B),
                        $this->dimat_helper_functions->IsInjective($third_function_relation),
                        $this->dimat_helper_functions->IsBijective($third_function_relation, $set_B)
                    )
                )
            );

            $this->task_description = $task_array;
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
            $this->dimat_helper_functions->SetMaximumNumber(100);
            $this->dimat_helper_functions->SetMinimumNumber(-100);
            $complex_numbers = $this->dimat_helper_functions->CreateComplexNumbers(5);

            $solution_array = [];

            $random_number = mt_rand(0, 4);
            $current_real_part = $complex_numbers[$random_number][0];
            $current_imaginary_part = $complex_numbers[$random_number][1];   
            $length = sqrt($current_real_part**2+$current_imaginary_part**2);
            $conjugate = [$current_real_part, -1*$current_imaginary_part];
            $solution_array["solution_0" ] = $current_real_part;
            $solution_array["solution_1"] = $current_imaginary_part;
            $solution_array["solution_2"] = $length;
            $solution_array["solution_3"] = $conjugate;

            $operation_dictionary = array("addition" => [], "multiplication" => [], "substraction" => [],"division" => []);
            for($operation_counter = 0; $operation_counter < 8; $operation_counter++){
                $operation = $operation_counter%4;
                
                $first_index = mt_rand(0, 4);
                $second_index = mt_rand(0, 4);
                while($first_index == $second_index){
                    $first_index = mt_rand(0, 4);
                    $second_index = mt_rand(0, 4);
                }
                $first_number = $this->complex_number_names[$first_index];
                $second_number = $this->complex_number_names[$second_index];

                switch($operation){
                    case 0:{
                        $new_indices = $this->dimat_helper_functions->CreateNewPairOfNumbers($operation_dictionary["addition"], $first_number, $second_number);
                        array_push($operation_dictionary["addition"], [$this->complex_number_names[$new_indices[0]],$this->complex_number_names[$new_indices[1]]]);
                    };break;
                    case 1:{
                        $new_indices = $this->dimat_helper_functions->CreateNewPairOfNumbers($operation_dictionary["multiplication"], $first_number, $second_number);
                        array_push($operation_dictionary["multiplication"], [$this->complex_number_names[$new_indices[0]],$this->complex_number_names[$new_indices[1]]]);
                    };break;
                    case 2:{
                        $new_indices = $this->dimat_helper_functions->CreateNewPairOfNumbers($operation_dictionary["substraction"], $first_number, $second_number);
                        array_push($operation_dictionary["substraction"], [$this->complex_number_names[$new_indices[0]],$this->complex_number_names[$new_indices[1]]]);
                    };break;
                    case 3:{
                        $new_indices = $this->dimat_helper_functions->CreateNewPairOfNumbers($operation_dictionary["division"], $first_number, $second_number);
                        array_push($operation_dictionary["division"], [$this->complex_number_names[$new_indices[0]],$this->complex_number_names[$new_indices[1]]]);
                    };break;
                    default:break;
                }
                $first_number_real_part = $complex_numbers[$new_indices[0]][0];
                $first_number_imaginary_part = $complex_numbers[$new_indices[0]][1];
                $second_number_real_part = $complex_numbers[$new_indices[1]][0];
                $second_number_imaginary_part = $complex_numbers[$new_indices[1]][1];
                $result_real_part = 0;
                $result_imaginary_part = 0;
                switch($operation){
                    case 0:{
                        $result_real_part = $first_number_real_part + $second_number_real_part;
                        $result_imaginary_part = $first_number_imaginary_part + $second_number_imaginary_part;
                    };break;
                    case 1:{
                        $result_real_part = $first_number_real_part * $second_number_real_part - $first_number_imaginary_part * $second_number_imaginary_part;
                        $result_imaginary_part = $first_number_real_part * $second_number_imaginary_part + $first_number_imaginary_part * $second_number_real_part;
                    };break;
                    case 2:{
                        $result_real_part = $first_number_real_part - $second_number_real_part;
                        $result_imaginary_part = $first_number_imaginary_part - $second_number_imaginary_part;
                    };break;
                    case 3:{
                        $length_of_second_number = $second_number_real_part**2 + $second_number_imaginary_part**2;
                        $result_real_part = (1/$length_of_second_number)*($first_number_real_part * $second_number_real_part + $first_number_imaginary_part * $second_number_imaginary_part);
                        $result_imaginary_part = (1/$length_of_second_number)*($first_number_imaginary_part * $second_number_real_part - $first_number_real_part * $second_number_imaginary_part);
                    };break;
                    default:break;
                }
                $solution_array["solution_" . $operation_counter + 4] = [$result_real_part, $result_imaginary_part];
            }

            $a = mt_rand(-100, 100);
            while($a == 0){
                $a = mt_rand(-100, 100);
            }
            $b = mt_rand(-100, 100);
            $c = mt_rand(-100, 100);
            $solution_array["solution_12"] =  $this->dimat_helper_functions->SolveQuadraticEquation($a,$b,$c);

            $task_array = array(
                "task_description" => "Old meg a következő feladatokat!",
                "complex_numbers" => $complex_numbers,
                "random_number" => $random_number,
                "operations" => $operation_dictionary,
                "coefficients" => [$a, $b, $c]
            );

            $this->task_description = $task_array;
            $this->task_solutions = $solution_array;
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
            $this->dimat_helper_functions->SetMaximumNumber(100);
            $this->dimat_helper_functions->SetMinimumNumber(-100);
            $complex_numbers = $this->dimat_helper_functions->CreateComplexNumbers(5);

            $solution_array = [];

            for($complex_number_counter = 0; $complex_number_counter<5; $complex_number_counter++){  
                $solution_array["solution_".$complex_number_counter] = $this->dimat_helper_functions->GetTrigonometricForm($complex_numbers[$complex_number_counter]);
            }

            $operation_dictionary = array("multiplication" => [], "division" => []);
            for($operation_counter = 0; $operation_counter < 4; $operation_counter++){
                $operation = $operation_counter%2;
                
                $first_index = mt_rand(0, 4);
                $second_index = mt_rand(0, 4);
                while($first_index == $second_index){
                    $first_index = mt_rand(0, 4);
                    $second_index = mt_rand(0, 4);
                }
                $first_number = $this->complex_number_names[$first_index];
                $second_number = $this->complex_number_names[$second_index];

                switch($operation){
                    case 0:{
                        $new_indices = $this->dimat_helper_functions->CreateNewPairOfNumbers($operation_dictionary["multiplication"], $first_number, $second_number);
                        array_push($operation_dictionary["multiplication"], [$this->complex_number_names[$new_indices[0]],$this->complex_number_names[$new_indices[1]]]);
                    };break;
                    case 1:{
                        $new_indices = $this->dimat_helper_functions->CreateNewPairOfNumbers($operation_dictionary["division"], $first_number, $second_number);
                        array_push($operation_dictionary["division"], [$this->complex_number_names[$new_indices[0]],$this->complex_number_names[$new_indices[1]]]);
                    }
                    default:break;
                }
                $first_number = $complex_numbers[$new_indices[0]];
                $second_number = $complex_numbers[$new_indices[1]];
                $result = [];
                switch($operation){
                    case 0:{
                        $result = $this->dimat_helper_functions->UseMoivre("multiplication", $first_number, $second_number);
                    };break;
                    case 1:{
                        $result = $this->dimat_helper_functions->UseMoivre("division", $first_number, $second_number);
                    }
                    default:break;
                }
                $solution_array["solution_" . $operation_counter + 5] = $result;
            }

            $task_array = array(
                "task_description" => "Old meg a következő komplex számok trigonometrikus alakjával kapcsolatos feladatokat!",
                "complex_numbers" => $complex_numbers,
                "operations" => $operation_dictionary
            );

            $this->task_description = $task_array;
            $this->task_solutions = $solution_array;
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
            $this->dimat_helper_functions->SetMaximumNumber(100);
            $this->dimat_helper_functions->SetMinimumNumber(-100);
            $complex_numbers = $this->dimat_helper_functions->CreateComplexNumbers(3);

            $solution_array = [];

            $operation_dictionary = array("power" => [], "root" => []);
            for($operation_counter = 0; $operation_counter < 3; $operation_counter++){                                
                $index = mt_rand(0, 2);
                $power = mt_rand(7, 12);
                $complex_number = $this->complex_number_names[$index];
                while(in_array([$complex_number, $power], $operation_dictionary["power"])){
                    $index = mt_rand(0, 2);
                    $power = mt_rand(7, 12);
                    $complex_number = $this->complex_number_names[$index];
                }
                array_push($operation_dictionary["power"], [$complex_number, $power]);
                $result = $this->dimat_helper_functions->UseMoivre("power", $complex_numbers[$index], $power);
                $solution_array["solution_" . $operation_counter] = $result;
            }

            for($operation_counter = 0; $operation_counter < 2; $operation_counter++){                                
                $index = mt_rand(0, 2);
                $power = mt_rand(2, 6);
                $complex_number = $this->complex_number_names[$index];
                while(in_array([$complex_number, $power], $operation_dictionary["root"])){
                    $index = mt_rand(0, 2);
                    $power = mt_rand(2, 6);
                    $complex_number = $this->complex_number_names[$index];
                }
                array_push($operation_dictionary["root"], [$complex_number, $power]);
                $result = $this->dimat_helper_functions->UseMoivre("root", $complex_numbers[$index], $power);
                $solution_array["solution_" . $operation_counter + 3] = $result;
            }

            $task_array = array(
                "task_description" => "Old meg a következő komplex számok hatványaival kapcsolatos feladatokat!",
                "complex_numbers" => $complex_numbers,
                "operations" => $operation_dictionary
            );

            $this->task_description = $task_array;
            $this->task_solutions = $solution_array;      
        }

        /**
         * 
         * This method is used to create the eight set of tasks for Discrete mathematics I. related to...
         * 
         * ...Subtasks created here...
         * 
         * @return void 
        */
        private function CreateTaskEight(){
            
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
            
        }

        /**
         * 
         * This method is used to create the tenth set of tasks for Discrete mathematics I. related to...
         * 
         * ...Subtasks created here...
         * 
         * @return void 
        */
        private function CreateTaskTen(){
            
        }
    }

?>