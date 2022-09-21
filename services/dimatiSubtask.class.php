<?php

    class DimatiSubtask extends SubTask {
        private $dimat_helper_functions;
        
        /**
         * 
         * The contructor for DimatiiSubtask class.
         * 
         * @return void
         */
        public function __construct(){
            $this->dimat_helper_functions = new DimatiHelperFunctions();
        }

        public function CreateSubtask($main_topic_number, $subtopic_number, $number_of_subtasks){
            $subtask = [];
            switch($main_topic_number){
                case "0":{
                    switch($subtopic_number){
                        case "0": $this->CreateSetSubtask($number_of_subtasks);break;
                        default:break;
                    }
                }break;
                case "1":{
                    switch($subtopic_number){
                        default:break;
                    }
                }break;
                case "2":{
                    switch($subtopic_number){
                        
                        default:break;
                    }
                }break;
                case "3":{
                    switch($subtopic_number){
                        
                        default:break;
                    }
                }break;
                case "4":{
                    switch($subtopic_number){
                        
                        default:break;
                    }
                }break;
                case "5":{
                    switch($subtopic_number){
                        
                        default:break;
                    }
                }break;
                case "6":{
                    switch($subtopic_number){
                        
                        default:break;
                    }
                }break;
                case "7":{
                    switch($subtopic_number){
                        
                        default:break;
                    }
                }break;
                case "8":{
                    switch($subtopic_number){
                        
                        default:break;
                    }
                }break;
                case "9":{
                    switch($subtopic_number){
                        
                        default:break;
                    }
                }break;
                default:break;
            };

            return $subtask;
        }
        
        /**
         * This private method will create ... for for the first subtask of the first task of Discrete Mathematics I.
         * 
         * Firstly, it creates 3-4 sets with elements between
         * 
         * @param int $number_of_subtasks The number of subtasks which is a positive whole number.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        private function CreateSetSubtask($number_of_subtasks, $full_task = false){
            $division_pairs = [];
            $solutions = [];
            $descriptions = [];
            $printable_solutions = ["<b>Megoldás:</b>"];
            $this->dimat_helper_functions->SetMinimumNumber(-15);
            $this->dimat_helper_functions->SetMaximumNumber(15);
            
            for($subtask_counter = 0; $subtask_counter < $number_of_subtasks; $subtask_counter++){
                //Create 3-4 sets
                //Each set has maximum 10 elements
                $sets = $this->dimat_helper_functions->CreateSets(mt_rand(3,4), 10);
                
                //Make the operations and the solutions
                if($full_task){
                    [$operation_dictionary, $solution_array] = $this->CreateFullSetTask($sets);
                }else{

                }
                
                
                
                $task_text = "<div class=\"paragraph\"><label class=\"group_number_label\">" . $subtask_counter + 1 . ". csoport: </label></div><div class=\"paragraph\"><label class=\"task_description\">Add meg...</label></div>";
                $printable_solution = "<div class=\"paragraph\"><label class=\"group_number_label\">" . $subtask_counter + 1 . ". csoport: </label></div>";
                
                
                array_push($descriptions, $task_text);
                array_push($printable_solutions, $printable_solution);
            }

            return array("data" => $division_pairs , "descriptions" => $descriptions, "solutions" => $solutions, "printable_solutions" => $printable_solutions);
        }

        private function CreateFullSetTask($sets){            
            $operation_names = ["union", "intersection", "substraction", "complementer", "symmetric difference"];
            $number_of_sets = count($sets);
            $operation_dictionary = array("union" => [], "intersection" => [], "substraction" => [], "complementer" => [], "symmetric difference" => []);
            $solution_array = [];
            for($operation_counter = 0; $operation_counter < 10; $operation_counter++){
                $operation_index = $operation_counter%5;
                [$new_element, $solution_for_new_element] = $this->CreateOperandsAndOperationForSetss($sets, $number_of_sets,  $operation_index, $operation_dictionary[$operation_names[$operation_counter]]);
                $solution_array["solution_" . $operation_counter] = $solution_for_new_element;
                array_push($operation_dictionary[$operation_names[$operation_counter]], $new_element);
            }

            return [$operation_dictionary, $solution_array];
        }

        /**
         * 
         */
        private function CreateOperandsAndOperationForSetss($sets, $number_of_sets, $operation_index, $set_indices){
            //$set_names = $this->dimat_helper_functions->GetSetNames();
            
            $new_element = $this->dimat_helper_functions->PickNewPairOfSets($set_indices, $number_of_sets);
            $set_of_set_elements = array_values($sets);
            $operands = [[],[]];
            if($operation_index === 3 ){
                $new_index = $this->dimat_helper_functions->PickNewPairOfSets($set_indices, $number_of_sets);
                $universe = $this->dimat_helper_functions->GetUniverse($set_of_set_elements[$new_index]);
                $new_element =  [$new_index, $universe];
                $operands = [$set_of_set_elements[$new_index]??[], $universe];
            }else{
                $operands = [$set_of_set_elements[$new_element[0]]??[],$set_of_set_elements[$new_element[1]]??[]];
            }

            $solution_for_new_element = $this->GetOperationSolutionForSets($operation_index, $operands);
            return [$new_element, $solution_for_new_element];
        }

        /**
         * 
         */
        private function GetOperationSolutionForSets($operation_index, $sets){
            $first_operand = $sets[0];
            $second_operand = $sets[1];
            $solution = [];

            switch($operation_index){
                case "0":{
                    $solution = $first_operand;
                    foreach($second_operand as $index => $element){
                        if(!in_array($element,$solution)){
                            array_push($solution,$element);
                        }
                    }
                };break;
                case "1":{
                    $solution = [];
                    foreach($second_operand as $index => $element){
                        if(in_array($element, $first_operand)){
                            array_push($solution,$element);
                        }
                    }
                };break;
                case "2":{
                    $solution = [];
                    foreach($first_operand as $index => $element){
                        if(!in_array($element,$second_operand)){
                            array_push($solution,$element);
                        }
                    }
                };break;
                case "3":{
                    $solution = [];
                    $universe = $second_operand;
                    foreach($universe as $index => $element){
                        if(!in_array($element,$first_operand)){
                            array_push($solution,$element);
                        }
                    }
                };break;
                case "4":{
                    $solution = [];
                    
                    foreach($first_operand as $index => $element){
                        if(!in_array($element,$second_operand)){
                            array_push($solution,$element);
                        }
                    }

                    foreach($second_operand as $index => $element){
                        if(!in_array($element,$first_operand)){
                            array_push($solution,$element);
                        }
                    }
                };break;
            }

            return $solution;
        }
    }


?>
