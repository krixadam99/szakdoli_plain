<?php

    class DimatiSubtask {
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
                    $subtask = $this->CreateSetSubtask($number_of_subtasks, $full_task);
                }break;
                case "1":{
                    $subtask = $this->CreateRelationBasicsSubtask($number_of_subtasks, $full_task);
                }break;
                case "2":{
                    switch($subtopic_number){
                        case "0": $subtask = $this->CreateRelationCompositionSubtask($number_of_subtasks);break;
                        case "1": $subtask = $this->CreateRelationCharacteristicsSubtask($number_of_subtasks);break;
                        case "2": $subtask = $this->CreateRelationCreationSubtask($number_of_subtasks);break;
                        default:break;
                    }
                }break;
                case "3":{
                    switch($subtopic_number){
                        case "0": $subtask = $this->CreateIsFunctionSubtask($number_of_subtasks);break;
                        case "1": $subtask = $this->CreateFunctionCharacteristicsSubtask($number_of_subtasks);break;
                        default:break;
                    }
                }break;
                case "4":{
                    switch($subtopic_number){
                        case "0": $subtask = $this->CreateComplexBasicCharacteristicsSubtask($number_of_subtasks, $full_task);break;
                        case "1": $subtask = $this->CreateComplexOperationsAlgebraicSubtask($number_of_subtasks, $full_task);break;
                        default:break;
                    }
                }break;
                case "5":{
                    switch($subtopic_number){
                        case "0": $subtask = $this->CreateComplexTrigonometricFormSubtask($number_of_subtasks, $full_task);break;
                        case "1": $subtask = $this->CreateComplexOperationsTrigonometricSubtask($number_of_subtasks);break;
                        default:break;
                    }
                }break;
                case "6":{
                    switch($subtopic_number){
                        case "0": $subtask = $this->CreateComplexPowerTrigonometricSubtask($number_of_subtasks, $full_task);break;
                        case "1": $subtask = $this->CreateComplexRootTrigonometricSubtask($number_of_subtasks);break;
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
         * This private method will create ... for the first subtask of the first task of Discrete Mathematics I.
         * 
         * @param int $number_of_subtasks The number of subtasks which is a positive whole number.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        private function CreateSetSubtask($number_of_subtasks, $full_task = false){
            $solutions = [];
            $descriptions = [];
            $printable_solutions = ["<div class=\"paragraph\"><b>Megoldás:</b></div>"];
            $this->dimat_helper_functions->SetMinimumNumber(-15);
            $this->dimat_helper_functions->SetMaximumNumber(15);
            
            $set_of_sets = [];
            $operation_dictionary = [];
            for($subtask_counter = 0; $subtask_counter < $number_of_subtasks; $subtask_counter++){
                $operation_names = ["union", "intersection", "substraction", "complementer", "symmetric difference"];
                $operation_counter = 0;

                //Make the operations and the solutions
                if($full_task){
                    $sets = $this->dimat_helper_functions->CreateSets(4, 3, 10, true);
                    array_push($set_of_sets, $sets);
                    [$actual_operation_dictionary, $actual_solutions] = $this->CreateFullSetTask($sets, $subtask_counter);
                    array_push($operation_dictionary,$actual_operation_dictionary);
                    $solutions = array_merge($solutions,$actual_solutions);
                }else{
                    //Create 3-4 sets
                    //Each set has maximum 10 elements
                    $set_size = mt_rand(3,5);
                    $sets = $this->dimat_helper_functions->CreateSets($set_size, 3, 10, true);
                    
                    $sets_text = "";
                    $set_counter = 0;
                    foreach($sets as $set_name => $set){
                        if($set_counter !== 0){
                            $sets_text = $sets_text . ", ";
                        }
                        $sets_text = $sets_text . PrintServices::CreatePrintableSet($set_name, $set, true);
                        $set_counter++;
                    }

                    $task_text = "<div class=\"paragraph\"><label class=\"group_number_label\">" . $subtask_counter + 1 . ". csoport: </label></div><div class=\"paragraph\">Adottak a ";
                    $task_text =  $task_text . $sets_text . " halmazok.</div>";
                    $printable_solution = "<div class=\"paragraph\"><label class=\"group_number_label\">" . $subtask_counter + 1 . ". csoport: </label></div><div class=\"paragraph\">";
                    $printable_solution =  $printable_solution . $sets_text . "</div>";

                    $actual_operation_dictionary = array("union" => [], "intersection" => [], "substraction" => [], "complementer" => [], "symmetric difference" => []);
                    for($counter = 0; $counter < 2; $counter++){
                        $operation_counter = mt_rand(0,4);
                        [$new_element, $solution_for_new_element] = $this->CreateOperandsAndOperationForSets($sets, $set_size, $operation_counter, $actual_operation_dictionary[$operation_names[$operation_counter]]);
                        array_push($actual_operation_dictionary[$operation_names[$operation_counter]], $new_element);

                        if($operation_counter === 3){
                            $task_text = $task_text . "<div class=\"paragraph\"><label class=\"group_number_label\">" . $counter + 1 . ". részfeladat: </label>Add meg a " . $new_element[0] . " halmaz komplementerét, ha az univerzum: " . PrintServices::CreatePrintableSet($new_element[0] . "<span class=\"bottom\">U</span>", $new_element[1]) . " </div>";
                            $printable_solution = $printable_solution . "<div class=\"paragraph\"><label class=\"group_number_label\">" . $counter + 1 . ". részfeladat: </label>" . PrintServices::CreatePrintableSet("<span style=\"border-top:1px solid black\">" . $new_element[0] . "</span>", $solution_for_new_element) . "</div>";    
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
                            $printable_solution = $printable_solution . "<div class=\"paragraph\"><label class=\"group_number_label\">" . $counter + 1 . ". részfeladat: </label>" . PrintServices::CreatePrintableSet($new_element[0] . " $operator " . $new_element[1], $solution_for_new_element) . "</div>";
                        }
                    }
                    
                    array_push($descriptions, $task_text);
                    array_push($printable_solutions, $printable_solution);
                }            
            }

            return array("data" => [$set_of_sets,$operation_dictionary] , "descriptions" => $descriptions, "solutions" => $solutions, "printable_solutions" => $printable_solutions);
        }

        /**
         * This private method will create ... for the first subtask of the second task of Discrete Mathematics I.
         * 
         * @param int $number_of_subtasks The number of subtasks which is a positive whole number.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        private function CreateRelationBasicsSubtask($number_of_subtasks, $full_task = false){
            $solutions = [];
            $descriptions = [];
            $printable_solutions = ["<div class=\"paragraph\"><b>Megoldás:</b></div>"];
            $this->dimat_helper_functions->SetMinimumNumber(1);
            $this->dimat_helper_functions->SetMaximumNumber(20);
            
            $task_data = array("relations" => [], "sets" => []);
            for($subtask_counter = 0; $subtask_counter < $number_of_subtasks; $subtask_counter++){
                [$first_set, $second_set] = $this->dimat_helper_functions->CreateSets(2, 3, mt_rand(8,12), false, false);
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
                $narrow_to_set = $this->dimat_helper_functions->GetPartOfSet($first_set, 4, false);
                $make_image_to_set = $this->dimat_helper_functions->GetPartOfSet($first_set, 4, false);
                $make_domain_to_set = $this->dimat_helper_functions->GetPartOfSet($second_set, 4, false);

                array_push($task_data["relations"], $relation);
                array_push($task_data["sets"], array("A" => $first_set, "B" => $second_set, "N" => $narrow_to_set, "I" => $make_image_to_set, "D" => $make_domain_to_set));
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
                        $task_text = $task_text. "<div class=\"paragraph\">Adott a " .  PrintServices::CreatePrintableSet("A", $actual_sets["A"]) . " halmaz, valamint az ";
                        $task_text = $task_text . "R \u{2286} A \u{00D7} A, ";
                        $printable_solution = $printable_solution . "R \u{2286} A \u{00D7} A, ";
                    }else{
                        $task_text = $task_text . "<div class=\"paragraph\">Adott a " .  PrintServices::CreatePrintableSet("A", $actual_sets["A"])  . " és " . PrintServices::CreatePrintableSet("B", $actual_sets["B"]) . " halmazok, valamint az ";
                        $task_text = $task_text . "R \u{2286} A \u{00D7} B, ";
                        $printable_solution = $printable_solution . "R \u{2286} A \u{00D7} B, ";
                    }
                    $task_text = $task_text . PrintServices::CreatePrintableRelation("R", $relation) . "</div>";
                    $printable_solution = $printable_solution . PrintServices::CreatePrintableRelation("R", $relation);

                    $previous_task = "";
                    for($counter = 0; $counter < 2; $counter++){
                        $new_task = mt_rand(0,5);
                        while($new_task === $previous_task){
                            $new_task = mt_rand(0,5);
                        }
                        
                        $task_text_part = "";
                        switch($new_task){
                            case 0:{
                                $task_text_part = "Add meg a reláció értelmezési tartományát!";
                                $solution_text_part =  PrintServices::CreatePrintableSet("R<span class=\"bottom\">domain</span>", $this->dimat_helper_functions->GetDomainOfRelation($relation));
                            };break;
                            case 1:{
                                $task_text_part = "Add meg a reláció értékkészletét!";
                                $solution_text_part =  PrintServices::CreatePrintableSet("R<span class=\"bottom\">image</span>", $this->dimat_helper_functions->GetImageOfRelation($relation));
                            };break;
                            case 2:{
                                $task_text_part = "Add meg a reláció " . PrintServices::CreatePrintableSet("N", $actual_sets["N"]) . " halmazra vett megszorítását!";
                                $solution_text_part =  PrintServices::CreatePrintableRelation("R<span class=\"bottom\">" . PrintServices::CreatePrintableSet("N", $actual_sets["N"], false) . "</span>", $this->dimat_helper_functions->GetRestrictedRelation($relation, $narrow_to_set));
                            };break;
                            case 3:{
                                $task_text_part = "Add meg a reláció inverzét!";
                                $solution_text_part =  PrintServices::CreatePrintableRelation("R<span class=\"exp\">-1</span>", $this->dimat_helper_functions->GetInverseRelation($relation));
                            };break;
                            case 4:{
                                $task_text_part = "Add meg a reláció " . PrintServices::CreatePrintableSet("I", $actual_sets["I"]) . " halmazon felvett képét!";
                                $solution_text_part =  PrintServices::CreatePrintableSet("R(" . PrintServices::CreatePrintableSet("I", $actual_sets["I"], false) . ")", $this->dimat_helper_functions->GetImageBySet($relation, $make_image_to_set));
                            };break;
                            case 5:{
                                $task_text_part = "Add meg a reláció " . PrintServices::CreatePrintableSet("D", $actual_sets["D"]) . " halmazon felvett ősképét!";
                                $solution_text_part =  PrintServices::CreatePrintableSet("R<span class=\"exp\">-1</span>(" . PrintServices::CreatePrintableSet("D", $actual_sets["D"], false) . ")", $this->dimat_helper_functions->GetDomainBySet($relation, $make_domain_to_set));
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

        /**
         * This private method will create ... for the first subtask of the third task of Discrete Mathematics I.
         * 
         * @param int $number_of_subtasks The number of subtasks which is a positive whole number.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        private function CreateRelationCompositionSubtask($number_of_subtasks){
            $solutions = [];
            $descriptions = [];
            $printable_solutions = ["<div class=\"paragraph\"><b>Megoldás:</b></div>"];
            
            $task_data = array("relation_pairs" => [], "set_triplets" => []);
            for($subtask_counter = 0; $subtask_counter < $number_of_subtasks; $subtask_counter++){
                [$first_set, $second_set, $third_set] = $this->dimat_helper_functions->CreateSets(3, 4, mt_rand(8,12), false, false);
                $first_relation = $this->dimat_helper_functions->CreateDescartesProduct($second_set, $third_set, 6);
                $second_relation = $this->dimat_helper_functions->CreateDescartesProduct($first_set, $second_set, 6);
                array_push($task_data["relation_pairs"], [$first_relation, $second_relation]);
                array_push($task_data["set_triplets"], array("A" => $first_set, "B" => $second_set, "C" => $third_set));
                
                $task_text = "<div class=\"paragraph\"><label class=\"group_number_label\">" . $subtask_counter + 1 . ". csoport: </label></div>";
                $task_text = $task_text . "<div class=\"paragraph\">Adottak az " .  PrintServices::CreatePrintableSet("A", $first_set)  . ", " . PrintServices::CreatePrintableSet("B", $second_set) . " és " . PrintServices::CreatePrintableSet("C", $third_set) .  " halmazok, valamint az ";
                $task_text = $task_text . "R \u{2286} B \u{00D7} C, " . PrintServices::CreatePrintableRelation("R", $first_relation) . " és az  S \u{2286} A \u{00D7} B, " .PrintServices::CreatePrintableRelation("S", $second_relation) . " relációk.</div>";
                $task_text = $task_text . "<div class=\"paragraph\">Add meg az R \u{00B7} S kompozíció eredményét!</div>";
                
                $composition = $this->dimat_helper_functions->CreateCompositionOfRelations($first_relation, $second_relation);
                $printable_solution = "<div class=\"paragraph\"><label class=\"group_number_label\">" . $subtask_counter + 1 . ". csoport: </label></div>";
                $printable_solution = $printable_solution . "<div class=\"paragraph\">" .  PrintServices::CreatePrintableSet("A", $first_set)  . ", " . PrintServices::CreatePrintableSet("B", $second_set) . " és " . PrintServices::CreatePrintableSet("C", $third_set) .  ";</div>";
                $printable_solution = $printable_solution . "<div class=\"paragraph\">R \u{2286} B \u{00D7} C, " . PrintServices::CreatePrintableRelation("R", $first_relation) . " és S \u{2286} A \u{00D7} B, " .PrintServices::CreatePrintableRelation("S", $second_relation) . ".</div>";
                $printable_solution = $printable_solution . "<div class=\"paragraph\">R \u{00B7} S = {(x,z) \u{2208} A \u{00D7} C | y \u{2203} B: (x,y) \u{2208} S \u{2227} (y,z) \u{2208} R } = " . PrintServices::CreatePrintableRelation("R \u{00B7} S", $composition, false) . "</div>";
                
                array_push($descriptions, $task_text);
                array_push($printable_solutions, $printable_solution);
                array_push($solutions, $composition);
            }

            return array("data" => $task_data , "descriptions" => $descriptions, "solutions" => $solutions, "printable_solutions" => $printable_solutions);
        }

        /**
         * This private method will create ... for the second subtask of the third task of Discrete Mathematics I.
         * 
         * @param int $number_of_subtasks The number of subtasks which is a positive whole number.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        private function CreateRelationCharacteristicsSubtask($number_of_subtasks){
            $characteristic_array = ["reflexív", "irreflexív", "szimmetrikus", "antisszimmetrikus", "asszimmetrikus", "tranzitivitív", "dichotóm", "trichotóm", "ekvivalencia reláció"];
            $solutions = [];
            $descriptions = [];
            $printable_solutions = ["<div class=\"paragraph\"><b>Megoldás:</b></div>"];
            
            $task_data = array("relations" => [], "base_sets" => []);
            for($subtask_counter = 0; $subtask_counter < $number_of_subtasks; $subtask_counter++){
                [$base_set] = $this->dimat_helper_functions->CreateSets(1, 3, 4, false, false);
                $relation = $this->dimat_helper_functions->CreateDescartesProduct($base_set, $base_set, mt_rand(8, 16));
                array_push($task_data["relations"], $relation);
                array_push($task_data["base_sets"], $base_set);
                
                $task_text = "<div class=\"paragraph\"><label class=\"group_number_label\">" . $subtask_counter + 1 . ". csoport: </label></div>";
                $task_text = $task_text . "<div class=\"paragraph\">Adott az " .  PrintServices::CreatePrintableSet("A", $base_set) . " valamint az ";
                $task_text = $task_text . "R \u{2286} A \u{00D7} A, " . PrintServices::CreatePrintableRelation("R", $relation) . " reláció.</div>";
                $task_text = $task_text . "<div class=\"paragraph\">Add meg, hogy a következő tulajdonságok közül mellyeket teljesíti a fenti reláció: reflexív, irreflexív, szimmetrikus, antisszimmetrikus, asszimmetrikus, tranzitivitív, dichotóm, trichotóm, ekvivalencia reláció.</div>";
                
                // + What is missing...
                $characteristics = array(
                    $this->dimat_helper_functions->IsReflexiveRelation($base_set, $relation),
                    $this->dimat_helper_functions->IsIrreflexiveRelation($base_set, $relation),
                    $this->dimat_helper_functions->IsSymmetricRelation($base_set, $relation),
                    $this->dimat_helper_functions->IsAntisymmetricRelation($base_set, $relation),
                    $this->dimat_helper_functions->IsAssymmetricRelation($base_set, $relation),
                    $this->dimat_helper_functions->IsTransitiveRelation($base_set, $relation),
                    $this->dimat_helper_functions->IsDichotomousRelation($base_set, $relation),
                    $this->dimat_helper_functions->IsTrichotomousRelation($base_set, $relation),
                    $this->dimat_helper_functions->IsEquivalenceRelation($base_set, $relation)
                );
                $printable_solution = "<div class=\"paragraph\"><label class=\"group_number_label\">" . $subtask_counter + 1 . ". csoport: </label></div>";
                $printable_solution = $printable_solution . "<div class=\"paragraph\">" .  PrintServices::CreatePrintableSet("A", $base_set) . ";</div>";
                $printable_solution = $printable_solution . "<div class=\"paragraph\">R \u{2286} A \u{00D7} A, " . PrintServices::CreatePrintableRelation("R", $relation) . ".</div>";
                $printable_solution = $printable_solution . "<div class=\"paragraph\">Ez a reláció ";
                foreach($characteristics as $characteristic_counter => $characteristic){
                    if($characteristic_counter !== 0){
                        $printable_solution = $printable_solution . ", ";
                    }
                    if(!$characteristic){
                        $printable_solution = $printable_solution . "nem ";
                    }
                    $printable_solution = $printable_solution . $characteristic_array[$characteristic_counter];
                }
                $printable_solution = $printable_solution . ".</div>";
                
                array_push($descriptions, $task_text);
                array_push($printable_solutions, $printable_solution);
                array_push($solutions, $characteristics);
            }

            return array("data" => $task_data , "descriptions" => $descriptions, "solutions" => $solutions, "printable_solutions" => $printable_solutions);
        }

        /**
         * This private method will create ... for the third subtask of the third task of Discrete Mathematics I.
         * 
         * @param int $number_of_subtasks The number of subtasks which is a positive whole number.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        private function CreateRelationCreationSubtask($number_of_subtasks){
            $solutions = [];
            $descriptions = [];
            $printable_solutions = ["<div class=\"paragraph\"><b>Megoldás:</b></div>"];
            
            $task_data = array("sets" => [], "characteristics" => []);
            for($subtask_counter = 0; $subtask_counter < $number_of_subtasks; $subtask_counter++){
                [$personal_set] = $this->dimat_helper_functions->CreateSets(1, 3, 4, false);
                $characteristics = $this->dimat_helper_functions->GetCharacteristics();

                $task_text = "<div class=\"paragraph\"><label class=\"group_number_label\">" . $subtask_counter + 1 . ". csoport: </label></div>";
                $task_text = $task_text . "<div class=\"paragraph\">Adott az " .  PrintServices::CreatePrintableSet("A", $personal_set) . ".</div>";
                $task_text = $task_text . "<div class=\"paragraph\">Készíts olyan relációt, amely teljesíti a következő feltételeket:</div>";
                $task_text = $task_text . "<ul>";
                $characteristic_counter = 0;
                foreach($characteristics as $characteristic_name => $is_true){
                    $task_text = $task_text . "<li>";
                    if(!$is_true){
                        $task_text = $task_text . "Nem ";
                    }
                    if($characteristic_counter !== 0){
                        $task_text = $task_text . ", ";
                    }
                    $task_text = $task_text . $characteristic_name .  "</li>";
                }
                $task_text = $task_text . "</ul>";


                $printable_solution = "<div class=\"paragraph\"><label class=\"group_number_label\">" . $subtask_counter + 1 . ". csoport: </label></div><div class=\"paragraph\">Néhány lehetséges reláció:</div>";

                $all_possible_relation = $this->dimat_helper_functions->GetAllPossibleRelations($personal_set); 
                $filtered_relations = $this->dimat_helper_functions->FilterRelationsWithCharacteristics($personal_set, $all_possible_relation, $characteristics, 0);
                foreach($filtered_relations as $relation_counter => $filtered_relation){
                    if($relation_counter > 1){
                        break;
                    }

                    $printable_solution = $printable_solution . "<div class=\"paragraph\">" . PrintServices::CreatePrintableRelation("", $filtered_relation, false) . "</div>";
                }
                
                array_push($descriptions, $task_text);
                array_push($printable_solutions, $printable_solution);
                array_push($task_data["sets"], $personal_set);
                array_push($task_data["characteristics"], $characteristics);
                array_push($solutions, $filtered_relations);
            }

            return array("data" => $task_data , "descriptions" => $descriptions, "solutions" => $solutions, "printable_solutions" => $printable_solutions);
        }

        /**
         * This private method will create ... for the first subtask of the fourth task of Discrete Mathematics I.
         * 
         * @param int $number_of_subtasks The number of subtasks which is a positive whole number.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        private function CreateIsFunctionSubtask($number_of_subtasks){
            $solutions = [];
            $descriptions = [];
            $printable_solutions = ["<div class=\"paragraph\"><b>Megoldás:</b></div>"];
            
            $task_data = array("pairs_of_sets" => [], "relations" => []);
            for($subtask_counter = 0; $subtask_counter < $number_of_subtasks; $subtask_counter++){
                [$first_set, $second_set] = $this->dimat_helper_functions->CreateSets(2, 3, 7, false);
                $relation = $this->dimat_helper_functions->CreateDescartesProduct($first_set, $second_set, mt_rand(2, 4));
                array_push($task_data["relations"], $relation);
                array_push($task_data["pairs_of_sets"], array("A" => $first_set, "B" => $second_set));
                
                $task_text = "<div class=\"paragraph\"><label class=\"group_number_label\">" . $subtask_counter + 1 . ". csoport: </label></div>";
                $task_text = $task_text . "<div class=\"paragraph\">Adottak az " .  PrintServices::CreatePrintableSet("A", $first_set)  . " és " . PrintServices::CreatePrintableSet("B", $second_set) . " halmazok, valamint az ";
                $task_text = $task_text . "R \u{2286} A \u{00D7} B, " . PrintServices::CreatePrintableRelation("R", $relation) . " reláció. Döntsd el, hogy a reláció függvény-e!</div>";

                $printable_solution = "<div class=\"paragraph\"><label class=\"group_number_label\">" . $subtask_counter + 1 . ". csoport: </label></div>";
                $printable_solution = $printable_solution . "<div class=\"paragraph\">" .  PrintServices::CreatePrintableSet("A", $first_set)  . ", " . PrintServices::CreatePrintableSet("B", $second_set) . ";</div>";
                $printable_solution = $printable_solution . "<div class=\"paragraph\">" . "R \u{2286} A \u{00D7} B, " . PrintServices::CreatePrintableRelation("R", $relation) . ";</div>";
                $printable_solution = $printable_solution . "<div class=\"paragraph\">A reláció";
                
                $is_function = $this->dimat_helper_functions->IsFunction($relation);
                if($is_function){
                    $printable_solution = $printable_solution . " függvény.</div>"; 
                }else{
                    $printable_solution = $printable_solution . " nem függvény.</div>";
                }
                
                array_push($descriptions, $task_text);
                array_push($printable_solutions, $printable_solution);
                array_push($solutions, [$is_function]);
            }

            return array("data" => $task_data , "descriptions" => $descriptions, "solutions" => $solutions, "printable_solutions" => $printable_solutions);
        }

        /**
         * This private method will create ... for the second subtask of the fourth task of Discrete Mathematics I.
         * 
         * @param int $number_of_subtasks The number of subtasks which is a positive whole number.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        private function CreateFunctionCharacteristicsSubtask($number_of_subtasks){
            $characteristic_array = ["szürjektív", "injektív", "bijektív"];
            $solutions = [];
            $descriptions = [];
            $printable_solutions = ["<div class=\"paragraph\"><b>Megoldás:</b></div>"];
            
            $task_data = array("pairs_of_sets" => [], "functions" => []);
            for($subtask_counter = 0; $subtask_counter < $number_of_subtasks; $subtask_counter++){
                [$first_set, $second_set] = $this->dimat_helper_functions->CreateSets(2, 6, 12, false);
                
                $function = $this->dimat_helper_functions->MakeFunction($first_set, $second_set, mt_rand(4, 6));
                // Make injective with 50% possibility, make surjective with 50% similarly
                
                array_push($task_data["functions"], $function);
                array_push($task_data["pairs_of_sets"], array("A" => $first_set, "B" => $second_set));
                

                $task_text = "<div class=\"paragraph\"><label class=\"group_number_label\">" . $subtask_counter + 1 . ". csoport: </label></div>";
                $task_text = $task_text . "<div class=\"paragraph\">Adottak az " .  PrintServices::CreatePrintableSet("A", $first_set)  . " és " . PrintServices::CreatePrintableSet("B", $second_set) . " halmazok, valamint az ";
                $task_text = $task_text . "f \u{2208} A \u{2192} B, ";
                $task_text = $task_text . PrintServices::CreatePrintableRelation("f", $function) . " függvény. Döntsd el, hogy a függvény mely tulajdonságokat teljesíti: injektív, szürjektív, bijektív.</div>";

                $characteristics = array(
                    $this->dimat_helper_functions->IsSurjective($function, $second_set),
                    $this->dimat_helper_functions->IsInjective($function),
                    $this->dimat_helper_functions->IsBijective($function, $second_set)
                );
                
                $printable_solution = "<div class=\"paragraph\"><label class=\"group_number_label\">" . $subtask_counter + 1 . ". csoport: </label></div>";
                $printable_solution = $printable_solution . "<div class=\"paragraph\">" .  PrintServices::CreatePrintableSet("A", $first_set)  . ", " . PrintServices::CreatePrintableSet("B", $second_set) . ";</div>";
                $printable_solution = $printable_solution . "<div class=\"paragraph\">f \u{2208} A \u{2192} B, " . PrintServices::CreatePrintableRelation("f", $function) . ".</div>";
                $printable_solution = $printable_solution . "<div class=\"paragraph\">Ez a függvény ";
                foreach($characteristics as $characteristic_counter => $characteristic){
                    if($characteristic_counter !== 0){
                        $printable_solution = $printable_solution . ", ";
                    }
                    if(!$characteristic){
                        $printable_solution = $printable_solution . "nem ";
                    }
                    $printable_solution = $printable_solution . $characteristic_array[$characteristic_counter];
                }
                $printable_solution = $printable_solution . ".</div>";
                
                array_push($descriptions, $task_text);
                array_push($printable_solutions, $printable_solution);
                array_push($solutions, $characteristics);
            }

            return array("data" => $task_data , "descriptions" => $descriptions, "solutions" => $solutions, "printable_solutions" => $printable_solutions);
        }

        /**
         * This private method will create ... for the first subtask of the fifth task of Discrete Mathematics I.
         * 
         * @param int $number_of_subtasks The number of subtasks which is a positive whole number.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        private function CreateComplexBasicCharacteristicsSubtask($number_of_subtasks, $full_task = false){
            $solutions = [];
            $descriptions = [];
            $printable_solutions = ["<div class=\"paragraph\"><b>Megoldás:</b></div>"];

            $this->dimat_helper_functions->SetMinimumNumber(-100);
            $this->dimat_helper_functions->SetMaximumNumber(100 + $number_of_subtasks);
            
            $task_data = array("complex_numbers" => []);
            for($subtask_counter = 0; $subtask_counter < $number_of_subtasks; $subtask_counter++){
                [$complex_number] = $this->dimat_helper_functions->CreateComplexNumbers(1);
                while(in_array($complex_number,$task_data["complex_numbers"])){
                    [$complex_number] = $this->dimat_helper_functions->CreateComplexNumbers(1);
                }
                array_push($task_data["complex_numbers"], $complex_number);

                //Make the operations and the solutions
                if($full_task){
                    $current_real_part = $complex_number[0];
                    $current_imaginary_part = $complex_number[1];   
                    $length = sqrt($current_real_part**2+$current_imaginary_part**2);
                    $conjugate = [$current_real_part, -1*$current_imaginary_part];

                    $solutions = array_merge($solutions,[
                        "solution_0_" . $subtask_counter . "_0" => $current_real_part,
                        "solution_0_" . $subtask_counter . "_1" => $current_imaginary_part,
                        "solution_0_" . $subtask_counter . "_2" => $length,
                        "solution_0_" . $subtask_counter . "_3" => $conjugate,
                    ]);
                }else{
                    $task_text = "<div class=\"paragraph\"><label class=\"group_number_label\">" . $subtask_counter + 1 . ". csoport: </label></div>";
                    $task_text = $task_text . "<div class=\"paragraph\">Adott a " .  PrintServices::CreatePrintableComplexNumberAlgebraic("x", $complex_number) . " komplex szám</div>";
                    $printable_solution = "<div class=\"paragraph\"><label class=\"group_number_label\">" . $subtask_counter + 1 . ". csoport: </label></div>";
                    $printable_solution = $printable_solution. "<div class=\"paragraph\">" .  PrintServices::CreatePrintableComplexNumberAlgebraic("x", $complex_number) . "</div>";

                    $previous_task = "";
                    for($counter = 0; $counter < 2; $counter++){
                        $new_task = mt_rand(0,3);
                        while($new_task === $previous_task){
                            $new_task = mt_rand(0,3);
                        }
                        
                        $task_text_part = "";
                        switch($new_task){
                            case 0:{
                                $current_real_part = $complex_number[0];
                                $task_text_part = "Add meg a komplex szám valós részét!";
                                $solution_text_part = "Re(x) = " . $complex_number[0];
                            };break;
                            case 1:{
                                $task_text_part = "Add meg a komplex szám képzetes részét!";
                                $current_imaginary_part = $complex_number[1];   
                                $solution_text_part = "Im(x) = " . $complex_number[1];
                            };break;
                            case 2:{
                                $task_text_part = "Add meg a komplex szám hosszát!";
                                $length = sqrt($complex_number[0]**2+$complex_number[1]**2);
                                $solution_text_part =  "|x| = \u{221A}(" . $complex_number[0] . "<span class=\"exp\">2</span> + " . $complex_number[1] . "<span class=\"exp\">2</span>) = $length";
                            };break;
                            case 3:{
                                $task_text_part = "Add meg a komplex szám konjugáltját!";
                                $conjugate = [$complex_number[0], -1*$complex_number[1]];
                                $solution_text_part =  "<span style=\"border-top:1px solid black; \">x</span> = " . PrintServices::CreatePrintableComplexNumberAlgebraic("", $conjugate, false);
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

        /**
         * This private method will create ... for the second subtask of the fifth task of Discrete Mathematics I.
         * 
         * @param int $number_of_subtasks The number of subtasks which is a positive whole number.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        private function CreateComplexOperationsAlgebraicSubtask($number_of_subtasks, $full_task = false){
            $solutions = [];
            $descriptions = [];
            $printable_solutions = ["<div class=\"paragraph\"><b>Megoldás:</b></div>"];
            $this->dimat_helper_functions->SetMinimumNumber(-100);
            $this->dimat_helper_functions->SetMaximumNumber(100 + $number_of_subtasks);
            
            $quadruple_of_complex_numbers = [];
            $operation_dictionary = [];
            for($subtask_counter = 0; $subtask_counter < $number_of_subtasks; $subtask_counter++){
                $operation_names = ["addition", "multiplication", "substraction", "division"];
                $operation_counter = 0;
                $complex_numbers = $this->dimat_helper_functions->CreateComplexNumbers(4);
                $set_of_complex_numbers = array("v" => $complex_numbers[0], "w" => $complex_numbers[1], "x" => $complex_numbers[2], "y" => $complex_numbers[3]);
                array_push($quadruple_of_complex_numbers, $set_of_complex_numbers);

                //Make the operations and the solutions
                if($full_task){
                    [$actual_operation_dictionary, $actual_solutions] = $this->CreateFullComplexOperationsTask($set_of_complex_numbers, $subtask_counter);
                    array_push($operation_dictionary, $actual_operation_dictionary);
                    $solutions = array_merge($solutions, $actual_solutions);
                }else{                    
                    $complex_numbers_text = "";
                    $complex_number_counter = 0;
                    foreach($set_of_complex_numbers as $complex_number_name => $complex_numbers){
                        if($complex_number_counter !== 0){
                            $complex_numbers_text = $complex_numbers_text . ", ";
                        }
                        $complex_numbers_text = $complex_numbers_text . PrintServices::CreatePrintableComplexNumberAlgebraic($complex_number_name, $complex_numbers, true);
                        $complex_number_counter++;
                    }

                    $task_text = "<div class=\"paragraph\"><label class=\"group_number_label\">" . $subtask_counter + 1 . ". csoport: </label></div><div class=\"paragraph\">Adottak a ";
                    $task_text =  $task_text . $complex_numbers_text . " komplex számok.</div>";
                    $printable_solution = "<div class=\"paragraph\"><label class=\"group_number_label\">" . $subtask_counter + 1 . ". csoport: </label></div><div class=\"paragraph\">";
                    $printable_solution =  $printable_solution . $complex_numbers_text . "</div>";

                    $actual_operation_dictionary = array("addition" => [], "multiplication" => [], "substraction" => [], "division" => []);
                    for($counter = 0; $counter < 2; $counter++){
                        $operation_counter = mt_rand(0,3);
                        [$new_element, $solution_for_new_element] = $this->CreateOperandsAndOperationForComplexNumbers($set_of_complex_numbers, count($set_of_complex_numbers), $operation_counter, $actual_operation_dictionary[$operation_names[$operation_counter]]);
                        array_push($actual_operation_dictionary[$operation_names[$operation_counter]], $new_element);

                        $operator = "";
                        switch($operation_counter){
                            case 0: $operator = " + ";break;
                            case 1: $operator = " * ";break;
                            case 2: $operator = " - ";break;
                            case 3: $operator = " \\ ";break;
                            default:break;
                        }

                        $task_text = $task_text . "<div class=\"paragraph\"><label class=\"group_number_label\">" . $counter + 1 . ". részfeladat: </label>Add meg a " . $new_element[0] . " $operator " . $new_element[1] . " művelet eredményét!</div>";
                        $printable_solution = $printable_solution . "<div class=\"paragraph\"><label class=\"group_number_label\">" . $counter + 1 . ". részfeladat: </label>" . PrintServices::CreatePrintableComplexNumberAlgebraic($new_element[0] . " $operator " . $new_element[1], $solution_for_new_element) . "</div>";
                    }
                    
                    array_push($descriptions, $task_text);
                    array_push($printable_solutions, $printable_solution);
                }            
            }

            return array("data" => [$quadruple_of_complex_numbers,$operation_dictionary] , "descriptions" => $descriptions, "solutions" => $solutions, "printable_solutions" => $printable_solutions);
        }

        /**
         * This private method will create ... for the first subtask of the sixth task of Discrete Mathematics I.
         * 
         * @param int $number_of_subtasks The number of subtasks which is a positive whole number.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        private function CreateComplexTrigonometricFormSubtask($number_of_subtasks, $full_task = false){
            $solutions = [];
            $descriptions = [];
            $printable_solutions = ["<div class=\"paragraph\"><b>Megoldás:</b></div>"];

            $this->dimat_helper_functions->SetMinimumNumber(-100);
            $this->dimat_helper_functions->SetMaximumNumber(100 + $number_of_subtasks);
            
            $task_data = array("pairs_of_complex_numbers" => []);
            for($subtask_counter = 0; $subtask_counter < $number_of_subtasks; $subtask_counter++){
                $pair_of_complex_numbers = $this->dimat_helper_functions->CreateComplexNumbers(2);
                while(in_array($pair_of_complex_numbers,$task_data["pairs_of_complex_numbers"])){
                    $pair_of_complex_numbers = $this->dimat_helper_functions->CreateComplexNumbers(2);
                }
                array_push($task_data["pairs_of_complex_numbers"], $pair_of_complex_numbers);

                $task_text = "<div class=\"paragraph\"><label class=\"group_number_label\">" . $subtask_counter + 1 . ". csoport: </label></div>";
                $task_text = $task_text . "<div class=\"paragraph\">Adottok az " .  PrintServices::CreatePrintableComplexNumberAlgebraic("x", $pair_of_complex_numbers[0]) . " és " . PrintServices::CreatePrintableComplexNumberAlgebraic("y", $pair_of_complex_numbers[0]) . " komplex számok.</div>";
                $printable_solution = "<div class=\"paragraph\"><label class=\"group_number_label\">" . $subtask_counter + 1 . ". csoport: </label></div>";
                $printable_solution = $printable_solution. "<div class=\"paragraph\">" .  PrintServices::CreatePrintableComplexNumberAlgebraic("x", $pair_of_complex_numbers[0]) . ", " . PrintServices::CreatePrintableComplexNumberAlgebraic("y", $pair_of_complex_numbers[1]) . ".</div>";

                $trigonometric_forms = [$this->dimat_helper_functions->GetTrigonometricForm($pair_of_complex_numbers[0]), $this->dimat_helper_functions->GetTrigonometricForm($pair_of_complex_numbers[1])];
                $task_text = $task_text . "<div class=\"paragraph\">Add meg a fenti komplex számok trigonometrikus alakját!</div>";
                $printable_solution = $printable_solution. "<div class=\"paragraph\">x = " .  PrintServices::CreatePrintableComplexNumberTrigonometric("", $trigonometric_forms[0], true, false) . "</div>";
                $printable_solution = $printable_solution. "<div class=\"paragraph\">y = " .  PrintServices::CreatePrintableComplexNumberTrigonometric("", $trigonometric_forms[1], true, false) . "</div>";

                $solutions = array_merge($solutions,[
                    "solution_0_" . $subtask_counter . "_0" => $trigonometric_forms[0],
                    "solution_0_" . $subtask_counter . "_1" => $trigonometric_forms[1]
                ]);

                array_push($descriptions, $task_text);
                array_push($printable_solutions, $printable_solution);
            }

            return array("data" => $task_data , "descriptions" => $descriptions, "solutions" => $solutions, "printable_solutions" => $printable_solutions);
        }

        /**
         * This private method will create ... for the second subtask of the sixth task of Discrete Mathematics I.
         * 
         * @param int $number_of_subtasks The number of subtasks which is a positive whole number.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        private function CreateComplexOperationsTrigonometricSubtask($number_of_subtasks, $full_task = false){
            $solutions = [];
            $descriptions = [];
            $printable_solutions = ["<div class=\"paragraph\"><b>Megoldás:</b></div>"];

            $this->dimat_helper_functions->SetMinimumNumber(-100);
            $this->dimat_helper_functions->SetMaximumNumber(100 + $number_of_subtasks);
            
            $task_data = array("pairs_of_complex_numbers" => []);
            for($subtask_counter = 0; $subtask_counter < $number_of_subtasks; $subtask_counter++){
                $pair_of_complex_numbers = $this->dimat_helper_functions->CreateComplexNumbers(2);
                while(in_array($pair_of_complex_numbers,$task_data["pairs_of_complex_numbers"])){
                    $pair_of_complex_numbers = $this->dimat_helper_functions->CreateComplexNumbers(2);
                }
                array_push($task_data["pairs_of_complex_numbers"], $pair_of_complex_numbers);

                $task_text = "<div class=\"paragraph\"><label class=\"group_number_label\">" . $subtask_counter + 1 . ". csoport: </label></div>";
                $task_text = $task_text . "<div class=\"paragraph\">Adottok az " .  PrintServices::CreatePrintableComplexNumberAlgebraic("x", $pair_of_complex_numbers[0]) . " és " . PrintServices::CreatePrintableComplexNumberAlgebraic("y", $pair_of_complex_numbers[0]) . " komplex számok.</div>";
                $printable_solution = "<div class=\"paragraph\"><label class=\"group_number_label\">" . $subtask_counter + 1 . ". csoport: </label></div>";
                $printable_solution = $printable_solution. "<div class=\"paragraph\">" .  PrintServices::CreatePrintableComplexNumberAlgebraic("x", $pair_of_complex_numbers[0]) . ", " . PrintServices::CreatePrintableComplexNumberAlgebraic("y", $pair_of_complex_numbers[1]) . ".</div>";

                $operations = [$this->dimat_helper_functions->UseMoivre("multiplication", $pair_of_complex_numbers[0], $pair_of_complex_numbers[1]), $this->dimat_helper_functions->UseMoivre("division", $pair_of_complex_numbers[0], $pair_of_complex_numbers[1])];
                $task_text = $task_text . "<div class=\"paragraph\">Add meg a fenti komplex számok trigonometrikus alakját!</div>";
                $printable_solution = $printable_solution. "<div class=\"paragraph\">x * y = " .  PrintServices::CreatePrintableComplexNumberTrigonometric("", $operations[0], true, false) . "</div>";
                $printable_solution = $printable_solution. "<div class=\"paragraph\">x / y = " .  PrintServices::CreatePrintableComplexNumberTrigonometric("", $operations[1], true, false) . "</div>";

                $solutions = array_merge($solutions,[
                    "solution_1_" . $subtask_counter . "_0" => $operations[0],
                    "solution_1_" . $subtask_counter . "_1" => $operations[1]
                ]);

                array_push($descriptions, $task_text);
                array_push($printable_solutions, $printable_solution);
            }

            return array("data" => $task_data , "descriptions" => $descriptions, "solutions" => $solutions, "printable_solutions" => $printable_solutions);
        }

        /**
         * This private method will create ... for the first subtask of the seventh task of Discrete Mathematics I.
         * 
         * @param int $number_of_subtasks The number of subtasks which is a positive whole number.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        private function CreateComplexPowerTrigonometricSubtask($number_of_subtasks, $full_task = false){
            $solutions = [];
            $descriptions = [];
            $printable_solutions = ["<div class=\"paragraph\"><b>Megoldás:</b></div>"];

            $this->dimat_helper_functions->SetMinimumNumber(-10);
            $this->dimat_helper_functions->SetMaximumNumber(10 + $number_of_subtasks);
            
            $task_data = array("complex_numbers" => [], "powers" => []);
            for($subtask_counter = 0; $subtask_counter < $number_of_subtasks; $subtask_counter++){
                [$complex_number] = $this->dimat_helper_functions->CreateComplexNumbers(1);
                while(in_array($complex_number,$task_data["complex_numbers"])){
                    [$complex_number] = $this->dimat_helper_functions->CreateComplexNumbers(1);
                }
                $first_power = mt_rand(3,4);
                $second_power = mt_rand(5,6);
                array_push($task_data["complex_numbers"], $complex_number);
                array_push($task_data["powers"], [$first_power, $second_power]);

                $task_text = "<div class=\"paragraph\"><label class=\"group_number_label\">" . $subtask_counter + 1 . ". csoport: </label></div>";
                $task_text = $task_text . "<div class=\"paragraph\">Adott az " .  PrintServices::CreatePrintableComplexNumberAlgebraic("x", $complex_number) . " komplex szám.</div>";
                $printable_solution = "<div class=\"paragraph\"><label class=\"group_number_label\">" . $subtask_counter + 1 . ". csoport: </label></div>";
                $printable_solution = $printable_solution. "<div class=\"paragraph\">" .  PrintServices::CreatePrintableComplexNumberAlgebraic("x", $complex_number) . ".</div>";

                $operations = [$this->dimat_helper_functions->UseMoivre("power", $complex_number, 0, $first_power), $this->dimat_helper_functions->UseMoivre("power", $complex_number, 0, $second_power)];
                $task_text = $task_text . "<div class=\"paragraph\">Add meg az x<span class=\"exp\">$first_power</span> és x<span class=\"exp\">$second_power</span> hatványozások eredményét!</div>";
                $printable_solution = $printable_solution. "<div class=\"paragraph\">x<span class=\"exp\">$first_power</span> = " .  PrintServices::CreatePrintableComplexNumberTrigonometric("", $operations[0], true, false) . "</div>";
                $printable_solution = $printable_solution. "<div class=\"paragraph\">x<span class=\"exp\">$second_power</span>= " .  PrintServices::CreatePrintableComplexNumberTrigonometric("", $operations[1], true, false) . "</div>";

                $solutions = array_merge($solutions,[
                    "solution_0_" . $subtask_counter . "_0" => $operations[0],
                    "solution_0_" . $subtask_counter . "_1" => $operations[1]
                ]);

                array_push($descriptions, $task_text);
                array_push($printable_solutions, $printable_solution);
            }

            return array("data" => $task_data , "descriptions" => $descriptions, "solutions" => $solutions, "printable_solutions" => $printable_solutions);
        }

        /**
         * This private method will create ... for the second subtask of the seventh task of Discrete Mathematics I.
         * 
         * @param int $number_of_subtasks The number of subtasks which is a positive whole number.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        private function CreateComplexRootTrigonometricSubtask($number_of_subtasks, $full_task = false){
            $solutions = [];
            $descriptions = [];
            $printable_solutions = ["<div class=\"paragraph\"><b>Megoldás:</b></div>"];

            $this->dimat_helper_functions->SetMinimumNumber(-10);
            $this->dimat_helper_functions->SetMaximumNumber(10 + $number_of_subtasks);
            
            $task_data = array("complex_numbers" => [], "roots" => []);
            for($subtask_counter = 0; $subtask_counter < $number_of_subtasks; $subtask_counter++){
                [$complex_number] = $this->dimat_helper_functions->CreateComplexNumbers(1);
                while(in_array($complex_number,$task_data["complex_numbers"])){
                    [$complex_number] = $this->dimat_helper_functions->CreateComplexNumbers(1);
                }
                $first_root = mt_rand(3,4);
                $second_root = mt_rand(5,6);
                array_push($task_data["complex_numbers"], $complex_number);
                array_push($task_data["roots"], [$first_root, $second_root]);

                $task_text = "<div class=\"paragraph\"><label class=\"group_number_label\">" . $subtask_counter + 1 . ". csoport: </label></div>";
                $task_text = $task_text . "<div class=\"paragraph\">Adott az " .  PrintServices::CreatePrintableComplexNumberAlgebraic("x", $complex_number) . " komplex szám.</div>";
                $printable_solution = "<div class=\"paragraph\"><label class=\"group_number_label\">" . $subtask_counter + 1 . ". csoport: </label></div>";
                $printable_solution = $printable_solution. "<div class=\"paragraph\">" .  PrintServices::CreatePrintableComplexNumberAlgebraic("x", $complex_number) . ".</div>";

                $operations = [$this->dimat_helper_functions->UseMoivre("root", $complex_number, 0, $first_root), $this->dimat_helper_functions->UseMoivre("root", $complex_number, 0, $second_root)];
                $task_text = $task_text . "<div class=\"paragraph\">Add meg az <span class=\"exp\">$first_root</span>\u{221A}x és <span class=\"exp\">$second_root</span>\u{221A}x gyökvonás eredményét!</div>";
                
                $printable_solution = $printable_solution. "<div class=\"paragraph\"><span class=\"exp\">$first_root</span>\u{221A}x = " . PrintServices::CreatePrintableComplexNumberTrigonometric("", ["<span class=\"exp\">$first_root</span>\u{221A}|x|", "(\u{03C6} + 2*k*\u{03C0})/$first_root"], false, false) . "</div>";
                foreach($operations[0]["arguments"] as $root_counter => $root){
                    $printable_solution = $printable_solution . "<div class=\"paragraph\">k = $root_counter \u{2192} " . PrintServices::CreatePrintableComplexNumberTrigonometric("", [$operations[0]["size"], $root], false) . "</div>";
                }

                $printable_solution = $printable_solution. "<div class=\"paragraph\"><span class=\"exp\">$second_root</span>\u{221A}x = " . PrintServices::CreatePrintableComplexNumberTrigonometric("", ["<span class=\"exp\">$second_root</span>\u{221A}|x|", "(\u{03C6} + 2*k*\u{03C0})/$second_root"], false, false) . "</div>";
                foreach($operations[1]["arguments"] as $root_counter => $root){
                    $printable_solution = $printable_solution . "<div class=\"paragraph\">k = $root_counter \u{2192} " . PrintServices::CreatePrintableComplexNumberTrigonometric("", [$operations[1]["size"], $root], false) . "</div>";
                }

                $solutions = array_merge($solutions,[
                    "solution_1_" . $subtask_counter . "_0" => $operations[0],
                    "solution_1_" . $subtask_counter . "_1" => $operations[1]
                ]);

                array_push($descriptions, $task_text);
                array_push($printable_solutions, $printable_solution);
            }

            return array("data" => $task_data , "descriptions" => $descriptions, "solutions" => $solutions, "printable_solutions" => $printable_solutions);
        }

        /**
         * 
         */
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
            
            $new_indices = $this->dimat_helper_functions->PickNewPairOfIndices($set_indices, $number_of_sets);
            $new_element = [$actual_set_names[$new_indices[0]??""],$actual_set_names[$new_indices[1]]??""];
            
            $operands = [[],[]];
            if($operation_index === 3){
                $new_index = $this->dimat_helper_functions->PickNewElement($set_indices, $number_of_sets);
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

        /**
         * 
         */
        private function CreateFullComplexOperationsTask($set_of_complex_numbers, $subtask_counter){            
            $operation_names = ["addition", "multiplication", "substraction", "division"];
            $number_of_complex_numbers = count($set_of_complex_numbers);
            $operation_dictionary = array("addition" => [], "multiplication" => [], "substraction" => [], "division" => []);
            $solution_array = [];
            for($operation_counter = 0; $operation_counter < 4; $operation_counter++){
                [$new_element, $solution_for_new_element] = $this->CreateOperandsAndOperationForComplexNumbers($set_of_complex_numbers, $number_of_complex_numbers,  $operation_counter, $operation_dictionary[$operation_names[$operation_counter]]);
                $solution_array["solution_1_" . $subtask_counter . "_" . $operation_counter] = $solution_for_new_element;
                array_push($operation_dictionary[$operation_names[$operation_counter]], $new_element);
            }

            return [$operation_dictionary, $solution_array];
        }

        /**
         * 
         */
        private function CreateOperandsAndOperationForComplexNumbers($set_of_complex_numbers, $number_of_complex_numbers, $operation_index, $complex_numbers_indices){
            $actual_complex_numbers_names = array_keys($set_of_complex_numbers);
            
            $new_indices = $this->dimat_helper_functions->PickNewPairOfIndices($complex_numbers_indices, $number_of_complex_numbers);
            $new_element = [$actual_complex_numbers_names[$new_indices[0]??""],$actual_complex_numbers_names[$new_indices[1]]??""];
            $operands = [$set_of_complex_numbers[$new_element[0]]??[],$set_of_complex_numbers[$new_element[1]]??[]];

            $first_number_real_part = $operands[0][0];
            $first_number_imaginary_part = $operands[0][1];
            $second_number_real_part = $operands[1][0];
            $second_number_imaginary_part = $operands[1][1];
            $result_real_part = 0;
            $result_imaginary_part = 0;

            switch($operation_index){
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
                default:;break;
            }
            $solution_for_new_element = [$result_real_part, $result_imaginary_part];
            
            return [$new_element, $solution_for_new_element];   
        }
    }


?>
