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

        public function CreateSubtask($main_topic_number, $subtopic_number, $number_of_subtasks, $full_task = false){
            $subtask = [];
            switch($main_topic_number){
                case "0":{
                    switch($subtopic_number){
                        case "0": $subtask = $this->CreateSetSubtask($number_of_subtasks, $full_task);break;
                        default:break;
                    }
                }break;
                case "1":{
                    switch($subtopic_number){
                        case "0": $subtask = $this->CreateRelationBasicsSubtask($number_of_subtasks, $full_task);break;
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
         * @param int $number_of_subtasks The number of subtasks which is a positive whole number.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        private function CreateSetSubtask($number_of_subtasks, $full_task = false){
            $solutions = [];
            $descriptions = [];
            $printable_solutions = ["<b>Megoldás:</b>"];
            $this->dimat_helper_functions->SetMinimumNumber(-15);
            $this->dimat_helper_functions->SetMaximumNumber(15);
            
            $set_of_sets = [];
            $operation_dictionary = [];
            for($subtask_counter = 0; $subtask_counter < $number_of_subtasks; $subtask_counter++){
                $operation_names = ["union", "intersection", "substraction", "complementer", "symmetric difference"];
                $operation_counter = 0;

                //Make the operations and the solutions
                if($full_task){
                    $sets = $this->dimat_helper_functions->CreateSets(4, 10);
                    array_push($set_of_sets, $sets);
                    [$actual_operation_dictionary, $actual_solutions] = $this->CreateFullSetTask($sets, $subtask_counter);
                    array_push($operation_dictionary,$actual_operation_dictionary);
                    $solutions = array_merge($solutions,$actual_solutions);
                }else{
                    //Create 3-4 sets
                    //Each set has maximum 10 elements
                    $set_size = mt_rand(3,5);
                    $sets = $this->dimat_helper_functions->CreateSets($set_size, 10, true);
                    
                    $task_text = "<div class=\"paragraph\"><label class=\"group_number_label\">" . $subtask_counter + 1 . ". csoport: </label></div><div class=\"paragraph\">Adottak a ";
                    $set_counter = 0;
                    foreach($sets as $set_name => $set){
                        if($set_counter !== 0){
                            $task_text = $task_text . ", ";
                        }
                        $task_text = $task_text . $this->CreateSetText($set_name, $set, true);
                        $set_counter++;
                    }
                    $task_text = $task_text . " halmazok.</div>";

                    $printable_solution = "<div class=\"paragraph\"><label class=\"group_number_label\">" . $subtask_counter + 1 . ". csoport: </label></div>";
                    $actual_operation_dictionary = array("union" => [], "intersection" => [], "substraction" => [], "complementer" => [], "symmetric difference" => []);
                    for($counter = 0; $counter < 2; $counter++){
                        $operation_counter = mt_rand(0,4);
                        [$new_element, $solution_for_new_element] = $this->CreateOperandsAndOperationForSets($sets, $set_size, $operation_counter, $actual_operation_dictionary[$operation_names[$operation_counter]]);
                        array_push($actual_operation_dictionary[$operation_names[$operation_counter]], $new_element);

                        if($operation_counter === 3){
                            $task_text = $task_text . "<div class=\"paragraph\"><label class=\"group_number_label\">" . $counter + 1 . ". részfeladat: </label>Add meg a " . $new_element[0] . " halmaz komplementerét, ha az univerzum: " . $this->CreateSetText($new_element[0] . "<span class=\"bottom\">U</span>", $new_element[1]) . " </div>";
                            $printable_solution = $printable_solution . "<div class=\"paragraph\"><label class=\"group_number_label\">" . $counter + 1 . ". részfeladat: </label>" . $this->CreateSetText("<span style=\"border-top:1px solid black\">" . $new_element[0] . "</span>", $solution_for_new_element) . "</div>";    
                        }else{
                            $operator = "";
                            switch($operation_counter){
                                case 0: $operator = "\u{222A}";break;
                                case 1: $operator = "\u{2229}";break;
                                case 2: $operator = "\\";break;
                                case 4: $operator = "\u{0394}";break;
                                default:break;
                            }

                            $task_text = $task_text . "<div class=\"paragraph\"><label class=\"group_number_label\">" . $counter + 1 . ". részfeladat: </label>Add meg a " . $new_element[0] . " $operator " . $new_element[1] . " művelet eredményét!</div>";
                            $printable_solution = $printable_solution . "<div class=\"paragraph\"><label class=\"group_number_label\">" . $counter + 1 . ". részfeladat: </label>" . $this->CreateSetText($new_element[0] . " $operator " . $new_element[1], $solution_for_new_element) . "</div>";
                        }
                    }
                    
                    array_push($descriptions, $task_text);
                    array_push($printable_solutions, $printable_solution);
                }            
            }

            return array("data" => [$set_of_sets,$operation_dictionary] , "descriptions" => $descriptions, "solutions" => $solutions, "printable_solutions" => $printable_solutions);
        }

        /**
         * This private method will create ... for for the first subtask of the second task of Discrete Mathematics I.
         * 
         * @param int $number_of_subtasks The number of subtasks which is a positive whole number.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        private function CreateRelationBasicsSubtask($number_of_subtasks, $full_task = false){
            $solutions = [];
            $descriptions = [];
            $printable_solutions = ["<b>Megoldás:</b>"];
            $this->dimat_helper_functions->SetMinimumNumber(1);
            $this->dimat_helper_functions->SetMaximumNumber(20);
            
            $task_data = array("relations" => [], "sets" => []);
            for($subtask_counter = 0; $subtask_counter < $number_of_subtasks; $subtask_counter++){
                [$first_set, $second_set] = $this->dimat_helper_functions->CreateSets(2, mt_rand(6,10), false, false);
                $number_of_pairs = mt_rand(6, 12);
                $same = mt_rand(0, 1)==0?false:true;
                if($same){ // Is the relation homogenious?
                    $is_first = mt_rand(0,1)==0?true:false; // Based on the first relation?
                    if($is_first){
                        $second_set = $first_set;
                    }else{
                        $first_set = $second_set;
                    }
                }

                $relation = $this->dimat_helper_functions->CreateDescartesProduct($first_set, $second_set, $number_of_pairs);
                while(in_array($relation, $task_data["relations"])){
                    $relation = $this->dimat_helper_functions->CreateDescartesProduct($first_set, $second_set, $number_of_pairs);
                }
                $narrow_to_set = $this->dimat_helper_functions->GetPartOfSet($first_set, 8, false);
                $make_image_to_set = $this->dimat_helper_functions->GetPartOfSet($first_set, 8, false);
                $make_domain_to_set = $this->dimat_helper_functions->GetPartOfSet($second_set, 8, false);

                array_push($task_data["relations"], $relation);
                array_push($task_data["sets"], array("A" => $first_set, "A" => $second_set, "N" => $narrow_to_set, "I" => $make_image_to_set, "D" => $make_domain_to_set));
                $actual_sets = array("A" => $first_set, "B" => $second_set, "N" => $narrow_to_set, "I" => $make_image_to_set, "D" => $make_domain_to_set);

                //Make the operations and the solutions
                if($full_task){
                    $solutions = array_merge($solutions,[
                        "solution_" . $subtask_counter . "_0" => $this->dimat_helper_functions->GetDomainOfRelation($relation),
                        "solution_" . $subtask_counter . "_1" => $this->dimat_helper_functions->GetImageOfRelation($relation),
                        "solution_" . $subtask_counter . "_2" => $this->dimat_helper_functions->GetRestrictedRelation($relation, $narrow_to_set),
                        "solution_" . $subtask_counter . "_3" => $this->dimat_helper_functions->GetInverseRelation($relation),
                        "solution_" . $subtask_counter . "_4" => $this->dimat_helper_functions->GetImageBySet($relation, $make_image_to_set),
                        "solution_" . $subtask_counter . "_5" => $this->dimat_helper_functions->GetDomainBySet($relation, $make_domain_to_set)
                    ]);
                }else{
                    $task_text = "<div class=\"paragraph\"><label class=\"group_number_label\">" . $subtask_counter + 1 . ". csoport: </label></div>";
                    $printable_solution = "<div class=\"paragraph\"><label class=\"group_number_label\">" . $subtask_counter + 1 . ". csoport: </label></div>";
                    $set_counter = 0;
                    if($same){
                        $task_text = "<div class=\"paragraph\">Adott a " .  $this->CreateSetText("A", $actual_sets["A"]) . " halmazok, valamint a";
                        $task_text = $task_text . "R \u{2286} A \u{00D7} A, ";
                    }else{
                        $task_text = "<div class=\"paragraph\">Adott a " .  $this->CreateSetText("A", $actual_sets["A"])  . " és " . $this->CreateSetText("B", $actual_sets["B"]) . " halmazok, valamin a";
                        $task_text = $task_text . "R \u{2286} A \u{00D7} B, ";
                    }
                    $task_text = $task_text . $this->CreateRelationText("R", $relation) . "</div>";

                    $previous_task = "";
                    for($counter = 0; $counter < 2; $counter++){
                        $new_task = mt_rand(0,6);
                        while($new_task === $previous_task){
                            $new_task = mt_rand(0,6);
                        }
                        var_dump($new_task,$previous_task);
                        
                        $task_text_part = "";
                        switch($new_task){
                            case 0:{
                                $task_text_part = "Add meg a reláció értelmezési tartományát!";
                                $solution_text_part =  $this->CreateSetText("R<span class=\"bottom\">domain</span>", $this->dimat_helper_functions->GetDomainOfRelation($relation));
                            };break;
                            case 1:{
                                $task_text_part = "Add meg a reláció értékkészletét!";
                                $solution_text_part =  $this->CreateSetText("R<span class=\"bottom\">image</span>", $this->dimat_helper_functions->GetImageOfRelation($relation));
                            };break;
                            case 2:{
                                $task_text_part = "Add meg a reláció " . $this->CreateSetText("N", $actual_sets["N"]) . " halmazra vett megszorítását!";
                                $solution_text_part =  $this->CreateRelationText("R<span class=\"bottom\">" . $this->CreateSetText("N", $actual_sets["N"], false) . "</span>", $this->dimat_helper_functions->GetRestrictedRelation($relation, $narrow_to_set));
                            };break;
                            case 4:{
                                $task_text_part = "Add meg a reláció inverzét!";
                                $solution_text_part =  $this->CreateRelationText("R<span class=\"exp\">-1</span>", $this->dimat_helper_functions->GetInverseRelation($relation));
                            };break;
                            case 5:{
                                $task_text_part = "Add meg a reláció " . $this->CreateSetText("I", $actual_sets["I"]) . " halmazon felvett képét!";
                                $solution_text_part =  $this->CreateSetText("R<span class=\"bottom\">" . $this->CreateSetText("I", $actual_sets["I"], false) . "</span>", $this->dimat_helper_functions->GetImageBySet($relation, $make_image_to_set));
                            };break;
                            case 6:{
                                $task_text_part = "Add meg a reláció " . $this->CreateSetText("D", $actual_sets["D"]) . " halmazon felvett ősképét!";
                                $solution_text_part =  $this->CreateSetText("R<span class=\"bottom\">" . $this->CreateSetText("D", $actual_sets["D"], false) . "</span>", $this->dimat_helper_functions->GetDomainBySet($relation, $make_domain_to_set));
                            };break;
                            default:break;
                        }

                        $previous_task = $new_task;
                        $task_text = $task_text . "<div class=\"paragraph\"><label class=\"group_number_label\">" . $counter + 1 . ". részfeladat: </label>" . $task_text_part . "</div>";
                        $printable_solution = $printable_solution . "<div class=\"paragraph\"><label class=\"group_number_label\">" . $counter + 1 . ". részfeladat: </label>" . $solution_text_part . "</div>";
                    }
                    
                    array_push($descriptions, $task_text);
                    array_push($printable_solutions, $printable_solution);
                }            
            }

            return array("data" => $task_data , "descriptions" => $descriptions, "solutions" => $solutions, "printable_solutions" => $printable_solutions);
        }

        private function CreateFullSetTask($sets, $subtask_counter){            
            $operation_names = ["union", "intersection", "substraction", "complementer", "symmetric difference"];
            $number_of_sets = count($sets);
            $operation_dictionary = array("union" => [], "intersection" => [], "substraction" => [], "complementer" => [], "symmetric difference" => []);
            $solution_array = [];
            for($operation_counter = 0; $operation_counter < 5; $operation_counter++){
                [$new_element, $solution_for_new_element] = $this->CreateOperandsAndOperationForSets($sets, $number_of_sets,  $operation_counter, $operation_dictionary[$operation_names[$operation_counter]]);
                $solution_array["solution_" . $subtask_counter . "_" . $operation_counter] = $solution_for_new_element;
                array_push($operation_dictionary[$operation_names[$operation_counter]], $new_element);
            }

            return [$operation_dictionary, $solution_array];
        }

        /**
         * 
         */
        private function CreateOperandsAndOperationForSets($sets, $number_of_sets, $operation_index, $set_indices){
            $actual_set_names = array_keys($sets);
            
            $new_indices = $this->dimat_helper_functions->PickNewPairOfSets($set_indices, $number_of_sets);
            $new_element = [$actual_set_names[$new_indices[0]??""],$actual_set_names[$new_indices[1]]??""];
            
            $operands = [[],[]];
            if($operation_index === 3){
                $new_index = $this->dimat_helper_functions->PickNewSetElement($set_indices, $number_of_sets);
                $picked_set_name = $actual_set_names[$new_index];
                $universe = $this->dimat_helper_functions->GetUniverse($sets[$picked_set_name]);
                $new_element =  [$picked_set_name, $universe];
                $operands = [$sets[$picked_set_name]??[], $universe];
            }else{
                $operands = [$sets[$new_element[0]]??[],$sets[$new_element[1]]??[]];
            }

            $solution_for_new_element = $this->GetOperationSolutionForSets($operation_index, $operands);
            return [$new_element, $solution_for_new_element];
        }

        /**
         * 
         */
        private function GetOperationSolutionForSets($operation_index, $operands){
            $first_operand = $operands[0];
            $second_operand = $operands[1];
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
