<?php
    /**
     * This is a helper class which will generate a subtask related to Discrete mathematics I. given by the main topic, subtopic indices and the number of subtasks.
     * 
     * This class will be used by the DimatiTasks and TaskGenerationController classes.
     */
    class DimatiSubtaskGenerator {
        private $dimat_helper_functions;
        
        /**
         * 
         * The contructor for DimatiSubtaskGenerator class.
         * 
         * @return void
         */
        public function __construct(){
            $this->dimat_helper_functions = new DimatiHelperFunctions();
        }

        /**
         * This method is responsible for creating a set of appropriate subtasks related to Discrete mathematics I..
         * 
         * @param string $main_topic_number The main topic's number.
         * @param string $subtopic_number The subtopic's number.
         * @param int $number_of_subtasks The number of subtasks to be generated.
         * @param bool $full_task Whether to generate a full task, or not. For some subtasks it is possible to generate just a part of the subtask. The default is false.
         * 
         * @return array Returns an array containing the subtasks' data, the subtasks' descriptions, subtasks' solutions and the printable solution for each subtask.
         */
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
                        case "0": $subtask = $this->CreateBinomialTheoremSubtask($number_of_subtasks);break;
                        case "1": $subtask = $this->CreateVieteFormulaSubtask($number_of_subtasks);break;
                        default:break;
                    }
                }break;
                case "8":{
                    switch($subtopic_number){
                        case "0": $subtask = $this->CreateGraphSubtask($number_of_subtasks, "simple");break;
                        case "1": $subtask = $this->CreateGraphSubtask($number_of_subtasks, "paired");break;
                        case "2": $subtask = $this->CreateGraphSubtask($number_of_subtasks, "tree");break;
                        case "3": $subtask = $this->CreateGraphSubtask($number_of_subtasks, "directed");break;
                        default:break;
                    }
                }break;
                default:break;
            };

            return $subtask;
        }
        
        /**
         * This private method will generate a set of tasks related to the first main topic - first subtopic of Discrete Mathematics I.
         * 
         * Per subtask:
         * 
         * Not full task - Randomly generates 3, or 4 sets, pick two operations from ["union", "intersection", "substraction", "complementer", "symmetric difference"] and the operands for these operations.
         * Full task - Randomly generates 4 sets, then pick operands for each of the operation ["union", "intersection", "substraction", "complementer", "symmetric difference"]. 
         * 
         * @param int $number_of_subtasks The number of subtasks which is a positive whole number.
         * @param bool $full_task Whether to generate a full task, or not. The default is false.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        private function CreateSetSubtask($number_of_subtasks, $full_task = false){
            $solutions = [];
            $descriptions = [];
            $printable_solutions = ["<div class=\"editable_box\"><label class=\"editable_label\">Megoldás:</label></div>"];
            $this->dimat_helper_functions->SetMinimumNumber(-15);
            $this->dimat_helper_functions->SetMaximumNumber(15);
            
            $set_of_sets = [];
            $operation_dictionary = [];
            for($subtask_counter = 0; $subtask_counter < $number_of_subtasks; $subtask_counter++){
                $operation_names = ["union", "intersection", "substraction", "complementer", "symmetric difference"];
                $operation_counter = 0;

                //Make the operations and the solutions
                if($full_task){
                    //Create 4 sets of 3 - 10 elements, each of them is associative (has a name)
                    $sets = $this->dimat_helper_functions->CreateSets(4, 3, 10, true);
                    array_push($set_of_sets, $sets);

                    // Create the complete set task
                    [$actual_operation_dictionary, $actual_solutions] = $this->CreateFullSetTask($sets, $subtask_counter);
                    array_push($operation_dictionary,$actual_operation_dictionary);
                    $solutions = array_merge($solutions,$actual_solutions);
                }else{
                    //Create 3-4 sets of 3 - 10 elements, each of them is associative (has a name)
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

                    $task_text = "<div class=\"editable_box\"><label class=\"editable_label\">" . $subtask_counter + 1 . ". csoport: </label></div><div class=\"editable_box\"><label class=\"editable_label\">Adottak a ";
                    $task_text =  $task_text . $sets_text . " halmazok.</label></div>";
                    $printable_solution = "<div class=\"editable_box\"><label class=\"editable_label\">" . $subtask_counter + 1 . ". csoport: </label></div><div class=\"editable_box\"><label class=\"editable_label\">";
                    $printable_solution =  $printable_solution . $sets_text . "</label></div>";

                    $actual_operation_dictionary = array("union" => [], "intersection" => [], "substraction" => [], "complementer" => [], "symmetric difference" => []);
                    for($counter = 0; $counter < 2; $counter++){
                        $operation_counter = mt_rand(0,4);

                        // The solution for the task
                        [$new_element, $solution_for_new_element] = $this->CreateOperandsAndOperationForSets($sets, $set_size, $operation_counter, $actual_operation_dictionary[$operation_names[$operation_counter]]);
                        array_push($actual_operation_dictionary[$operation_names[$operation_counter]], $new_element);

                        if($operation_counter === 3){
                            $task_text = $task_text . "<div class=\"editable_box\"><label class=\"editable_label\">" . $counter + 1 . ". részfeladat: </label><label class=\"editable_label\">Add meg a " . $new_element[0] . " halmaz komplementerét, ha az univerzum: " . PrintServices::CreatePrintableSet($new_element[0] . "<sub>U</sub>", $new_element[1]) . "</label></div>";
                            $printable_solution = $printable_solution . "<div class=\"editable_box\"><label class=\"editable_label\">" . $counter + 1 . ". részfeladat: </label><label class=\"editable_label\">" . PrintServices::CreatePrintableSet("<span style=\"border-top:1px solid black\">" . $new_element[0] . "</span>", $solution_for_new_element) . "</label></div>";    
                        }else{
                            $operator = "";
                            switch($operation_counter){
                                case 0: $operator = "\u{222A}";break;
                                case 1: $operator = "\u{2229}";break;
                                case 2: $operator = "\\";break;
                                case 4: $operator = "\u{0394}";break;
                                default:break;
                            }

                            $task_text = $task_text . "<div class=\"editable_box\"><label class=\"editable_label\">" . $counter + 1 . ". részfeladat: </label><label class=\"editable_label\">Add meg a " . $new_element[0] . " $operator " . $new_element[1] . " művelet eredményét!</label></div>";
                            $printable_solution = $printable_solution . "<div class=\"editable_box\"><label class=\"editable_label\">" . $counter + 1 . ". részfeladat: </label><label class=\"editable_label\">" . PrintServices::CreatePrintableSet($new_element[0] . " $operator " . $new_element[1], $solution_for_new_element) . "</label></div>";
                        }
                    }
                    
                    array_push($descriptions, $task_text);
                    array_push($printable_solutions, $printable_solution);
                }            
            }

            return array("data" => [$set_of_sets,$operation_dictionary] , "descriptions" => $descriptions, "solutions" => $solutions, "printable_solutions" => $printable_solutions);
        }

        /**
         * This private method will generate a set of tasks related to the second main topic - first subtopic Discrete Mathematics I.
         * 
         * Per subtask:
         *
         * Creates 2 sets of 3 - [8,12] elements each.
         * Generates a relation of 6 - 12 elements from these 2 relations and 3 other sets of 4 elements each.
         * Full task - ask for all of the basic definitions of the created relation.
         * Not full task - ask for random 2 of the basic definitions of the created relation.
         * 
         * @param int $number_of_subtasks The number of subtasks which is a positive whole number.
         * @param bool $full_task Whether to generate a full task, or not. The default is false.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        private function CreateRelationBasicsSubtask($number_of_subtasks, $full_task = false){
            $solutions = [];
            $descriptions = [];
            $printable_solutions = ["<div class=\"editable_box\"><label class=\"editable_label\">Megoldás:</label></div>"];
            $this->dimat_helper_functions->SetMinimumNumber(1);
            $this->dimat_helper_functions->SetMaximumNumber(20);
            
            $task_data = array("relations" => [], "sets" => []);
            for($subtask_counter = 0; $subtask_counter < $number_of_subtasks; $subtask_counter++){
                // Create 2 sets of 3 - [8,12] elements, non of them is associative
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

                // Create relation
                $relation = $this->dimat_helper_functions->CreateDescartesProduct($first_set, $second_set, $number_of_pairs);
                $narrow_to_set = $this->dimat_helper_functions->GetPartOfSet($first_set, 4);
                $make_image_to_set = $this->dimat_helper_functions->GetPartOfSet($first_set, 4);
                $make_domain_to_set = $this->dimat_helper_functions->GetPartOfSet($second_set, 4);

                array_push($task_data["relations"], $relation);
                array_push($task_data["sets"], array("A" => $first_set, "B" => $second_set, "N" => $narrow_to_set, "I" => $make_image_to_set, "D" => $make_domain_to_set));
                $actual_sets = array("A" => $first_set, "B" => $second_set, "N" => $narrow_to_set, "I" => $make_image_to_set, "D" => $make_domain_to_set);

                //Make the operations and the solutions
                if($full_task){
                    // The solution for the task
                    $solutions = array_merge($solutions,[
                        "solution_" . $subtask_counter . "_0" => $this->dimat_helper_functions->GetDomainOfRelation($relation),
                        "solution_" . $subtask_counter . "_1" => $this->dimat_helper_functions->GetImageOfRelation($relation),
                        "solution_" . $subtask_counter . "_2" => $this->dimat_helper_functions->GetRestrictedRelation($relation, $narrow_to_set),
                        "solution_" . $subtask_counter . "_3" => $this->dimat_helper_functions->GetInverseRelation($relation),
                        "solution_" . $subtask_counter . "_4" => $this->dimat_helper_functions->GetImageBySet($relation, $make_image_to_set),
                        "solution_" . $subtask_counter . "_5" => $this->dimat_helper_functions->GetDomainBySet($relation, $make_domain_to_set)
                    ]);
                }else{
                    // Task description for the task generation page
                    $task_text = "<div class=\"editable_box\"><label class=\"editable_label\">" . $subtask_counter + 1 . ". csoport: </label></div>";
                    
                    // Task solution for the task generation page
                    $printable_solution = "<div class=\"editable_box\"><label class=\"editable_label\">" . $subtask_counter + 1 . ". csoport: </label></div>";
                    $set_counter = 0;
                    if($same){
                        $task_text = $task_text. "<div class=\"editable_box\"><label class=\"editable_label\">Adott a " .  PrintServices::CreatePrintableSet("A", $actual_sets["A"]) . " halmaz, valamint az ";
                        $task_text = $task_text . "R \u{2286} A \u{00D7} A, ";
                        $printable_solution = $printable_solution . "<div class=\"editable_box\"><label class=\"editable_label\">R \u{2286} A \u{00D7} A, ";
                    }else{
                        $task_text = $task_text . "<div class=\"editable_box\"><label class=\"editable_label\">Adott a " .  PrintServices::CreatePrintableSet("A", $actual_sets["A"])  . " és " . PrintServices::CreatePrintableSet("B", $actual_sets["B"]) . " halmazok, valamint az ";
                        $task_text = $task_text . "R \u{2286} A \u{00D7} B, ";
                        $printable_solution = $printable_solution . "<div class=\"editable_box\"><label class=\"editable_label\">R \u{2286} A \u{00D7} B, ";
                    }
                    $task_text = $task_text . PrintServices::CreatePrintableRelation("R", $relation) . " reláció.</label></div>";
                    $printable_solution = $printable_solution . PrintServices::CreatePrintableRelation("R", $relation) . "</label></div>";

                    $previous_task = -1;
                    for($counter = 0; $counter < 2; $counter++){
                        $new_task = mt_rand(0,5);
                        // Chose a new task
                        while($new_task === $previous_task){
                            $new_task = mt_rand(0,5);
                        }
                        
                        // The solution for the task
                        $task_text_part = "";
                        switch($new_task){
                            case 0:{
                                $task_text_part = "Add meg a reláció értelmezési tartományát!";
                                $solution_text_part =  PrintServices::CreatePrintableSet("R<sub>domain</sub>", $this->dimat_helper_functions->GetDomainOfRelation($relation));
                            };break;
                            case 1:{
                                $task_text_part = "Add meg a reláció értékkészletét!";
                                $solution_text_part =  PrintServices::CreatePrintableSet("R<sub>image</sub>", $this->dimat_helper_functions->GetImageOfRelation($relation));
                            };break;
                            case 2:{
                                $task_text_part = "Add meg a reláció " . PrintServices::CreatePrintableSet("N", $actual_sets["N"]) . " halmazra vett megszorítását!";
                                $solution_text_part =  PrintServices::CreatePrintableRelation("R<sub>" . PrintServices::CreatePrintableSet("N", $actual_sets["N"], false) . "</sub>", $this->dimat_helper_functions->GetRestrictedRelation($relation, $narrow_to_set));
                            };break;
                            case 3:{
                                $task_text_part = "Add meg a reláció inverzét!";
                                $solution_text_part =  PrintServices::CreatePrintableRelation("R<sup>-1</sup>", $this->dimat_helper_functions->GetInverseRelation($relation));
                            };break;
                            case 4:{
                                $task_text_part = "Add meg a reláció " . PrintServices::CreatePrintableSet("I", $actual_sets["I"]) . " halmazon felvett képét!";
                                $solution_text_part =  PrintServices::CreatePrintableSet("R(" . PrintServices::CreatePrintableSet("I", $actual_sets["I"], false) . ")", $this->dimat_helper_functions->GetImageBySet($relation, $make_image_to_set));
                            };break;
                            case 5:{
                                $task_text_part = "Add meg a reláció " . PrintServices::CreatePrintableSet("D", $actual_sets["D"]) . " halmazon felvett ősképét!";
                                $solution_text_part =  PrintServices::CreatePrintableSet("R<sup>-1</sup>(" . PrintServices::CreatePrintableSet("D", $actual_sets["D"], false) . ")", $this->dimat_helper_functions->GetDomainBySet($relation, $make_domain_to_set));
                            };break;
                            default:break;
                        }

                        $previous_task = $new_task;
                        $task_text = $task_text . "<div class=\"editable_box\"><label class=\"editable_label\">" . $counter + 1 . ". részfeladat: </label><label class=\"editable_label\">" . $task_text_part . "</label></div>";
                        $printable_solution = $printable_solution . "<div class=\"editable_box\"><label class=\"editable_label\">" . $counter + 1 . ". részfeladat: </label><label class=\"editable_label\">" . $solution_text_part . "</label></div>";
                    }
                    
                    array_push($descriptions, $task_text);
                    array_push($printable_solutions, $printable_solution);
                }            
            }

            return array("data" => $task_data , "descriptions" => $descriptions, "solutions" => $solutions, "printable_solutions" => $printable_solutions);
        }

        /**
         * This private method will generate a set of tasks related to the third main topic - first subtopic Discrete Mathematics I.
         * 
         * Per subtask:
         * 
         * Creates 3 sets of 4 - [8,12] elements each.
         * Creates two relations of 6 elements each. The first relation is created by the second and third set. The second relation is created by the first and second set. 
         * Makes the composition of the two relations.
         * 
         * @param int $number_of_subtasks The number of subtasks which is a positive whole number.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        private function CreateRelationCompositionSubtask($number_of_subtasks){
            $solutions = [];
            $descriptions = [];
            $printable_solutions = ["<div class=\"editable_box\"><label class=\"editable_label\">Megoldás:</label></div>"];
            
            $task_data = array("relation_pairs" => [], "set_triplets" => []);
            for($subtask_counter = 0; $subtask_counter < $number_of_subtasks; $subtask_counter++){
                // Create 3 sets of 4 - [8,12] elements, non of them is associative
                [$first_set, $second_set, $third_set] = $this->dimat_helper_functions->CreateSets(3, 4, mt_rand(8,12), false, false);
                
                // Create 2 relations, each of them is 6 elements
                // The first relation is created by the second and third set. The second relation is created by the first and second set. 
                $first_relation = $this->dimat_helper_functions->CreateDescartesProduct($second_set, $third_set, 6);
                $second_relation = $this->dimat_helper_functions->CreateDescartesProduct($first_set, $second_set, 6);
                array_push($task_data["relation_pairs"], [$first_relation, $second_relation]);
                array_push($task_data["set_triplets"], array("A" => $first_set, "B" => $second_set, "C" => $third_set));
                
                // Updating the task description for the task generation page
                $task_text = "<div class=\"editable_box\"><label class=\"editable_label\">" . $subtask_counter + 1 . ". csoport: </label></div>";
                $task_text = $task_text . "<div class=\"editable_box\"><label class=\"editable_label\">Adottak az " .  PrintServices::CreatePrintableSet("A", $first_set)  . ", " . PrintServices::CreatePrintableSet("B", $second_set) . " és " . PrintServices::CreatePrintableSet("C", $third_set) .  " halmazok, valamint az ";
                $task_text = $task_text . "R \u{2286} B \u{00D7} C, " . PrintServices::CreatePrintableRelation("R", $first_relation) . " és az  S \u{2286} A \u{00D7} B, " .PrintServices::CreatePrintableRelation("S", $second_relation) . " relációk.</label></div>";
                $task_text = $task_text . "<div class=\"editable_box\"><label class=\"editable_label\">Add meg az R \u{00B7} S kompozíció eredményét!</label></div>";
                
                // The solution for the task
                $composition = $this->dimat_helper_functions->CreateCompositionOfRelations($first_relation, $second_relation);
                
                // Updating the task solution for the task generation page
                $printable_solution = "<div class=\"editable_box\"><label class=\"editable_label\">" . $subtask_counter + 1 . ". csoport: </label></div>";
                $printable_solution = $printable_solution . "<div class=\"editable_box\"><label class=\"editable_label\">" .  PrintServices::CreatePrintableSet("A", $first_set)  . ", " . PrintServices::CreatePrintableSet("B", $second_set) . " és " . PrintServices::CreatePrintableSet("C", $third_set) .  ";</label></div>";
                $printable_solution = $printable_solution . "<div class=\"editable_box\"><label class=\"editable_label\">R \u{2286} B \u{00D7} C, " . PrintServices::CreatePrintableRelation("R", $first_relation) . " és S \u{2286} A \u{00D7} B, " .PrintServices::CreatePrintableRelation("S", $second_relation) . ".</label></div>";
                $printable_solution = $printable_solution . "<div class=\"editable_box\"><label class=\"editable_label\">R \u{00B7} S = {(x,z) \u{2208} A \u{00D7} C | y \u{2203} B: (x,y) \u{2208} S \u{2227} (y,z) \u{2208} R } = " . PrintServices::CreatePrintableRelation("R \u{00B7} S", $composition, false) . "</label></div>";
                
                array_push($descriptions, $task_text);
                array_push($printable_solutions, $printable_solution);
                array_push($solutions, $composition);
            }

            return array("data" => $task_data , "descriptions" => $descriptions, "solutions" => $solutions, "printable_solutions" => $printable_solutions);
        }

        /**
         * This private method will generate a set of tasks related to the third main topic - second subtopic of Discrete Mathematics I.
         * 
         * Per subtask:
         * 
         * Creates a set of 3 - 4 elements.
         * Creates a homogenious relation of 8 - 16 elements from the set. 
         * Determines the characteristics of this relation.
         * 
         * @param int $number_of_subtasks The number of subtasks which is a positive whole number.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        private function CreateRelationCharacteristicsSubtask($number_of_subtasks){
            $characteristic_array = ["reflexív", "irreflexív", "szimmetrikus", "antisszimmetrikus", "szigorúan antiszimmetrikus", "tranzitív", "dichotóm", "trichotóm", "ekvivalencia reláció"];
            $solutions = [];
            $descriptions = [];
            $printable_solutions = ["<div class=\"editable_box\"><label class=\"editable_label\">Megoldás:</label></div>"];
            
            $task_data = array("relations" => [], "base_sets" => []);
            for($subtask_counter = 0; $subtask_counter < $number_of_subtasks; $subtask_counter++){
                [$base_set] = $this->dimat_helper_functions->CreateSets(1, 3, 4, false, false);
                $relation = $this->dimat_helper_functions->CreateDescartesProduct($base_set, $base_set, mt_rand(6, count($base_set)**2));
                array_push($task_data["relations"], $relation);
                array_push($task_data["base_sets"], $base_set);
                
                $task_text = "<div class=\"editable_box\"><label class=\"editable_label\">" . $subtask_counter + 1 . ". csoport: </label></div>";
                $task_text = $task_text . "<div class=\"editable_box\"><label class=\"editable_label\">Adott az " .  PrintServices::CreatePrintableSet("A", $base_set) . " valamint az ";
                $task_text = $task_text . "R \u{2286} A \u{00D7} A, " . PrintServices::CreatePrintableRelation("R", $relation) . " homogén reláció.</label></div>";
                $task_text = $task_text . "<div class=\"editable_box\"><label class=\"editable_label\">Add meg, hogy a következő tulajdonságok közül mellyeket teljesíti a fenti reláció: reflexív, irreflexív, szimmetrikus, antisszimmetrikus, szigorúan antisszimmetrikus, tranzitív, dichotóm, trichotóm, ekvivalencia reláció.</label></div>";
                
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
                $printable_solution = "<div class=\"editable_box\"><label class=\"editable_label\">" . $subtask_counter + 1 . ". csoport: </label></div>";
                $printable_solution = $printable_solution . "<div class=\"editable_box\"><label class=\"editable_label\">" .  PrintServices::CreatePrintableSet("A", $base_set) . ";</label></div>";
                $printable_solution = $printable_solution . "<div class=\"editable_box\"><label class=\"editable_label\">R \u{2286} A \u{00D7} A, " . PrintServices::CreatePrintableRelation("R", $relation) . ".</label></div>";
                $printable_solution = $printable_solution . "<div class=\"editable_box\"><label class=\"editable_label\">Ez a reláció ";
                foreach($characteristics as $characteristic_counter => $characteristic){
                    if($characteristic_counter !== 0){
                        $printable_solution = $printable_solution . ", ";
                    }
                    if(!$characteristic){
                        $printable_solution = $printable_solution . "nem ";
                    }
                    $printable_solution = $printable_solution . $characteristic_array[$characteristic_counter];
                }
                $printable_solution = $printable_solution . ".</label></div>";
                
                array_push($descriptions, $task_text);
                array_push($printable_solutions, $printable_solution);
                array_push($solutions, $characteristics);
            }

            return array("data" => $task_data , "descriptions" => $descriptions, "solutions" => $solutions, "printable_solutions" => $printable_solutions);
        }

        /**
         * This private method will generate a set of tasks related to the third main topic - third subtopic of Discrete Mathematics I.
         * 
         * Per subtask:
         * 
         * Creates a set of 3 - 4 elements, then a list of characteristic - is satisfied pairs.
         * Finally, it determines all of the possible relations that satisfy all of the conditions in the list.
         * 
         * @param int $number_of_subtasks The number of subtasks which is a positive whole number.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        private function CreateRelationCreationSubtask($number_of_subtasks){
            $solutions = [];
            $descriptions = [];
            $printable_solutions = ["<div class=\"editable_box\"><label class=\"editable_label\">Megoldás:</label></div>"];
            
            $task_data = array("sets" => [], "characteristics" => []);
            for($subtask_counter = 0; $subtask_counter < $number_of_subtasks; $subtask_counter++){
                [$personal_set] = $this->dimat_helper_functions->CreateSets(1, 3, 4, false);
                $characteristics = $this->dimat_helper_functions->GetCharacteristics();

                $task_text = "<div class=\"editable_box\"><label class=\"editable_label\">" . $subtask_counter + 1 . ". csoport: </label></div>";
                $task_text = $task_text . "<div class=\"editable_box\"><label class=\"editable_label\">Adott az " .  PrintServices::CreatePrintableSet("A", $personal_set) . ".</label></div>";
                $task_text = $task_text . "<div class=\"editable_box\"><label class=\"editable_label\">Készíts olyan relációt, amely teljesíti a következő feltételeket:</label></div>";

                $characteristic_list = "<ul>";
                $characteristic_counter = 0;
                foreach($characteristics as $characteristic_name => $is_true){
                    $characteristic_list .= "<li class=\"editable_box\"><label class=\"editable_label\">";
                    if(!$is_true){
                        $characteristic_list .=  "Nem " . strtolower($characteristic_name);
                    }else{
                        $characteristic_list .= $characteristic_name;
                    }
                    $characteristic_list .= "</label></li>";
                }
                $characteristic_list .= "</ul>";

                $task_text .= $characteristic_list;
                $printable_solution = "<div class=\"editable_box\"><label class=\"editable_label\">" . $subtask_counter + 1 . ". csoport: </label></div><div class=\"editable_box\"><label class=\"editable_label\">" . PrintServices::CreatePrintableSet("A", $personal_set) . " és </label><label class=\"editable_label\">$characteristic_list</label><label class=\"editable_label\">Néhány lehetséges reláció:</label></div>";

                $all_possible_relation = $this->dimat_helper_functions->GetAllPossibleRelations($personal_set); 
                $filtered_relations = $this->dimat_helper_functions->FilterRelationsWithCharacteristics($personal_set, $all_possible_relation, $characteristics, 0);
                foreach($filtered_relations as $relation_counter => $filtered_relation){
                    if($relation_counter > 1){
                        break;
                    }

                    $printable_solution = $printable_solution . "<div class=\"editable_box\"><label class=\"editable_label\">" . PrintServices::CreatePrintableRelation("", $filtered_relation, false) . "</label></div>";
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
         * This private method will generate a set of tasks related to the fourth main topic - first subtopic of Discrete Mathematics I.
         * 
         * Per subtask:
         * 
         * Creates 2 sets of 3-7 elements each, then a relation of 2-4 elements from these sets.
         * Determines if the relation is a function, or not.
         * 
         * @param int $number_of_subtasks The number of subtasks which is a positive whole number.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        private function CreateIsFunctionSubtask($number_of_subtasks){
            $solutions = [];
            $descriptions = [];
            $printable_solutions = ["<div class=\"editable_box\"><label class=\"editable_label\">Megoldás:</label></div>"];
            
            $task_data = array("pairs_of_sets" => [], "relations" => []);
            for($subtask_counter = 0; $subtask_counter < $number_of_subtasks; $subtask_counter++){
                [$first_set, $second_set] = $this->dimat_helper_functions->CreateSets(2, 3, 7, false);
                $relation = $this->dimat_helper_functions->CreateDescartesProduct($first_set, $second_set, mt_rand(2, 4));
                array_push($task_data["relations"], $relation);
                array_push($task_data["pairs_of_sets"], array("A" => $first_set, "B" => $second_set));
                
                $task_text = "<div class=\"editable_box\"><label class=\"editable_label\">" . $subtask_counter + 1 . ". csoport: </label></div>";
                $task_text = $task_text . "<div class=\"editable_box\"><label class=\"editable_label\">Adottak az " .  PrintServices::CreatePrintableSet("A", $first_set)  . " és " . PrintServices::CreatePrintableSet("B", $second_set) . " halmazok, valamint az ";
                $task_text = $task_text . "R \u{2286} A \u{00D7} B, " . PrintServices::CreatePrintableRelation("R", $relation) . " reláció. Döntsd el, hogy a reláció függvény-e!</label></div>";

                $printable_solution = "<div class=\"editable_box\"><label class=\"editable_label\">" . $subtask_counter + 1 . ". csoport: </label></div>";
                $printable_solution = $printable_solution . "<div class=\"editable_box\"><label class=\"editable_label\">" .  PrintServices::CreatePrintableSet("A", $first_set)  . ", " . PrintServices::CreatePrintableSet("B", $second_set) . ";</label></div>";
                $printable_solution = $printable_solution . "<div class=\"editable_box\"><label class=\"editable_label\">" . "R \u{2286} A \u{00D7} B, " . PrintServices::CreatePrintableRelation("R", $relation) . ";</label></div>";
                $printable_solution = $printable_solution . "<div class=\"editable_box\"><label class=\"editable_label\">A reláció";
                
                $is_function = $this->dimat_helper_functions->IsFunction($relation);
                if($is_function){
                    $printable_solution = $printable_solution . " függvény.</label></div>"; 
                }else{
                    $printable_solution = $printable_solution . " nem függvény.</label></div>";
                }
                
                array_push($descriptions, $task_text);
                array_push($printable_solutions, $printable_solution);
                array_push($solutions, [$is_function]);
            }

            return array("data" => $task_data , "descriptions" => $descriptions, "solutions" => $solutions, "printable_solutions" => $printable_solutions);
        }

        /**
         * This private method will generate a set of tasks related to the fourth main topic - second subtopic of Discrete Mathematics I.
         * 
         * Per subtask:
         * 
         * Creates 2 sets of 6-12 elements each, then a a function of 4-6 elements from these sets.
         * Determines if the function is surjective, injective and bijective.
         * 
         * @param int $number_of_subtasks The number of subtasks which is a positive whole number.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        private function CreateFunctionCharacteristicsSubtask($number_of_subtasks){
            $characteristic_array = ["szürjektív", "injektív", "bijektív"];
            $solutions = [];
            $descriptions = [];
            $printable_solutions = ["<div class=\"editable_box\"><label class=\"editable_label\">Megoldás:</label></div>"];
            
            $task_data = array("pairs_of_sets" => [], "functions" => []);
            for($subtask_counter = 0; $subtask_counter < $number_of_subtasks; $subtask_counter++){
                [$first_set] = $this->dimat_helper_functions->CreateSets(1, 6, 12, false);
                [$second_set] = $this->dimat_helper_functions->CreateSets(1, 6, max(6,count($first_set)-6), false);
                
                $function = $this->dimat_helper_functions->MakeFunction($first_set, $second_set, mt_rand(4, 6)); 
                if(mt_rand(0,100) < 50){
                    while(!$this->dimat_helper_functions->IsSurjective($function, $second_set)){
                        $function = $this->dimat_helper_functions->MakeFunction($first_set, $second_set, mt_rand(4, 6));
                    }
                }
                
                array_push($task_data["functions"], $function);
                array_push($task_data["pairs_of_sets"], array("A" => $first_set, "B" => $second_set));
                

                $task_text = "<div class=\"editable_box\"><label class=\"editable_label\">" . $subtask_counter + 1 . ". csoport: </label></div>";
                $task_text = $task_text . "<div class=\"editable_box\"><label class=\"editable_label\">Adottak az " .  PrintServices::CreatePrintableSet("A", $first_set)  . " és " . PrintServices::CreatePrintableSet("B", $second_set) . " halmazok, valamint az ";
                $task_text = $task_text . "f \u{2208} A \u{2192} B, ";
                $task_text = $task_text . PrintServices::CreatePrintableRelation("f", $function) . " függvény. Döntsd el, hogy a függvény mely tulajdonságokat teljesíti: injektív, szürjektív, bijektív.</label></div>";

                $characteristics = array(
                    $this->dimat_helper_functions->IsSurjective($function, $second_set),
                    $this->dimat_helper_functions->IsInjective($function),
                    $this->dimat_helper_functions->IsBijective($function, $second_set)
                );
                
                $printable_solution = "<div class=\"editable_box\"><label class=\"editable_label\">" . $subtask_counter + 1 . ". csoport: </label></div>";
                $printable_solution = $printable_solution . "<div class=\"editable_box\"><label class=\"editable_label\">" .  PrintServices::CreatePrintableSet("A", $first_set)  . ", " . PrintServices::CreatePrintableSet("B", $second_set) . ";</label></div>";
                $printable_solution = $printable_solution . "<div class=\"editable_box\"><label class=\"editable_label\">f \u{2208} A \u{2192} B, " . PrintServices::CreatePrintableRelation("f", $function) . ".</label></div>";
                $printable_solution = $printable_solution . "<div class=\"editable_box\"><label class=\"editable_label\">Ez a függvény ";
                foreach($characteristics as $characteristic_counter => $characteristic){
                    if($characteristic_counter !== 0){
                        $printable_solution = $printable_solution . ", ";
                    }
                    if(!$characteristic){
                        $printable_solution = $printable_solution . "nem ";
                    }
                    $printable_solution = $printable_solution . $characteristic_array[$characteristic_counter];
                }
                $printable_solution = $printable_solution . ".</label></div>";
                
                array_push($descriptions, $task_text);
                array_push($printable_solutions, $printable_solution);
                array_push($solutions, $characteristics);
            }

            return array("data" => $task_data , "descriptions" => $descriptions, "solutions" => $solutions, "printable_solutions" => $printable_solutions);
        }

        /**
         * This private method will generate a set of tasks related to the fifth main topic - first subtopic of Discrete Mathematics I.
         * 
         * Per subtask:
         * 
         * Creates a complex number.
         * Full task - determines the basic traits of the created complex number.
         * Not full task - picks 2 from the basic traits and determines these for the created number.
         * 
         * @param int $number_of_subtasks The number of subtasks which is a positive whole number.
         * @param bool $full_task Whether to generate a full task, or not. The default is false.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        private function CreateComplexBasicCharacteristicsSubtask($number_of_subtasks, $full_task = false){
            $solutions = [];
            $descriptions = [];
            $printable_solutions = ["<div class=\"editable_box\"><label class=\"editable_label\">Megoldás:</label></div>"];

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
                    $task_text = "<div class=\"editable_box\"><label class=\"editable_label\">" . $subtask_counter + 1 . ". csoport: </label></div>";
                    $task_text = $task_text . "<div class=\"editable_box\"><label class=\"editable_label\">Adott a " .  PrintServices::CreatePrintableComplexNumberAlgebraic("x", $complex_number) . " komplex szám.</label></div>";
                    $printable_solution = "<div class=\"editable_box\"><label class=\"editable_label\">" . $subtask_counter + 1 . ". csoport: </label></div>";
                    $printable_solution = $printable_solution. "<div class=\"editable_box\"><label class=\"editable_label\">" .  PrintServices::CreatePrintableComplexNumberAlgebraic("x", $complex_number) . "</label></div>";

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
                                $solution_text_part =  "|x| = \u{221A}(" . $complex_number[0] . "<sup>2</sup> + " . $complex_number[1] . "<sup>2</sup>) = $length";
                            };break;
                            case 3:{
                                $task_text_part = "Add meg a komplex szám konjugáltját!";
                                $conjugate = [$complex_number[0], -1*$complex_number[1]];
                                $solution_text_part =  "<span style=\"border-top:1px solid black; \">x</span> = " . PrintServices::CreatePrintableComplexNumberAlgebraic("", $conjugate, false);
                            };break;
                            default:break;
                        }

                        $previous_task = $new_task;
                        $task_text = $task_text . "<div class=\"editable_box\"><label class=\"editable_label\">" . $counter + 1 . ". részfeladat: </label></div><div class=\"editable_box\"><label class=\"editable_label\">" . $task_text_part . "</label></div>";
                        $printable_solution = $printable_solution . "<div class=\"editable_box\"><label class=\"editable_label\">" . $counter + 1 . ". részfeladat: </label></div><div class=\"editable_box\"><label class=\"editable_label\">" . $solution_text_part . "</label></div>";
                    }
                    
                    array_push($descriptions, $task_text);
                    array_push($printable_solutions, $printable_solution);
                }            
            }

            return array("data" => $task_data , "descriptions" => $descriptions, "solutions" => $solutions, "printable_solutions" => $printable_solutions);
        }

        /**
         * This private method will generate a set of tasks related to the fifth main topic - second subtopic of Discrete Mathematics I.
         * 
         * Per subtask:
         * 
         * Creates 4 complex numbers.
         * Full task - picks operands for each operation from the ["addition", "multiplication", "substraction", "division"] array.
         * Not full task - picks 2 operations from the ["addition", "multiplication", "substraction", "division"] array then picks the operands from the created complex numbers.
         * 
         * @param int $number_of_subtasks The number of subtasks which is a positive whole number.
         * @param bool $full_task Whether to generate a full task, or not. The default is false.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        private function CreateComplexOperationsAlgebraicSubtask($number_of_subtasks, $full_task = false){
            $solutions = [];
            $descriptions = [];
            $printable_solutions = ["<div class=\"editable_box\"><label class=\"editable_label\">Megoldás:</label></div>"];
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

                    $task_text = "<div class=\"editable_box\"><label class=\"editable_label\">" . $subtask_counter + 1 . ". csoport: </label></div><div class=\"editable_box\"><label class=\"editable_label\">Adottak a ";
                    $task_text =  $task_text . $complex_numbers_text . " komplex számok.</label></div>";
                    $printable_solution = "<div class=\"editable_box\"><label class=\"editable_label\">" . $subtask_counter + 1 . ". csoport: </label></div><div class=\"editable_box\"><label class=\"editable_label\">";
                    $printable_solution =  $printable_solution . $complex_numbers_text . "</label></div>";

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

                        $task_text = $task_text . "<div class=\"editable_box\"><label class=\"editable_label\">" . $counter + 1 . ". részfeladat: </label></div><div class=\"editable_box\"><label class=\"editable_label\">Add meg a " . $new_element[0] . " $operator " . $new_element[1] . " művelet eredményét!</label></div>";
                        $printable_solution = $printable_solution . "<div class=\"editable_box\"><label class=\"editable_label\">" . $counter + 1 . ". részfeladat: </label></div><div class=\"editable_box\"><label class=\"editable_label\">" . PrintServices::CreatePrintableComplexNumberAlgebraic($new_element[0] . " $operator " . $new_element[1], $solution_for_new_element) . "</label></div>";
                    }
                    
                    array_push($descriptions, $task_text);
                    array_push($printable_solutions, $printable_solution);
                }            
            }

            return array("data" => [$quadruple_of_complex_numbers,$operation_dictionary] , "descriptions" => $descriptions, "solutions" => $solutions, "printable_solutions" => $printable_solutions);
        }

        /**
         * This private method will generate a set of tasks related to the sixth main topic - first subtopic of Discrete Mathematics I.
         * 
         * Per subtask:
         * 
         * Creates 2 complex numbers.
         * Then detemines the trigonometric forms for these.
         * 
         * @param int $number_of_subtasks The number of subtasks which is a positive whole number.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        private function CreateComplexTrigonometricFormSubtask($number_of_subtasks){
            $solutions = [];
            $descriptions = [];
            $printable_solutions = ["<div class=\"editable_box\"><label class=\"editable_label\">Megoldás:</label></div>"];

            $this->dimat_helper_functions->SetMinimumNumber(-100);
            $this->dimat_helper_functions->SetMaximumNumber(100 + $number_of_subtasks);
            
            $task_data = array("pairs_of_complex_numbers" => []);
            for($subtask_counter = 0; $subtask_counter < $number_of_subtasks; $subtask_counter++){
                $pair_of_complex_numbers = $this->dimat_helper_functions->CreateComplexNumbers(2);
                while(in_array($pair_of_complex_numbers,$task_data["pairs_of_complex_numbers"])){
                    $pair_of_complex_numbers = $this->dimat_helper_functions->CreateComplexNumbers(2);
                }
                array_push($task_data["pairs_of_complex_numbers"], $pair_of_complex_numbers);

                $task_text = "<div class=\"editable_box\"><label class=\"editable_label\">" . $subtask_counter + 1 . ". csoport: </label></div>";
                $task_text = $task_text . "<div class=\"editable_box\"><label class=\"editable_label\">Adottak az " .  PrintServices::CreatePrintableComplexNumberAlgebraic("x", $pair_of_complex_numbers[0]) . " és " . PrintServices::CreatePrintableComplexNumberAlgebraic("y", $pair_of_complex_numbers[0]) . " komplex számok.</label></div>";
                $printable_solution = "<div class=\"editable_box\"><label class=\"editable_label\">" . $subtask_counter + 1 . ". csoport: </label></div>";
                $printable_solution = $printable_solution. "<div class=\"editable_box\"><label class=\"editable_label\">" .  PrintServices::CreatePrintableComplexNumberAlgebraic("x", $pair_of_complex_numbers[0]) . ", " . PrintServices::CreatePrintableComplexNumberAlgebraic("y", $pair_of_complex_numbers[1]) . ".</label></div>";

                $trigonometric_forms = [$this->dimat_helper_functions->GetTrigonometricForm($pair_of_complex_numbers[0]), $this->dimat_helper_functions->GetTrigonometricForm($pair_of_complex_numbers[1])];
                $task_text = $task_text . "<div class=\"editable_box\"><label class=\"editable_label\">Add meg a fenti komplex számok trigonometrikus alakját!</label></div>";
                $printable_solution = $printable_solution. "<div class=\"editable_box\"><label class=\"editable_label\">x = " .  PrintServices::CreatePrintableComplexNumberTrigonometric("", $trigonometric_forms[0], true, false) . "</label></div>";
                $printable_solution = $printable_solution. "<div class=\"editable_box\"><label class=\"editable_label\">y = " .  PrintServices::CreatePrintableComplexNumberTrigonometric("", $trigonometric_forms[1], true, false) . "</label></div>";

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
         * This private method will generate a set of tasks related to the sixth main topic - second subtopic of Discrete Mathematics I.
         * 
         * Per subtask:
         * 
         * Creates 2 complex numbers.
         * Then detemines the product and quotient of the complex numbers by their trigonometric forms.
         * 
         * @param int $number_of_subtasks The number of subtasks which is a positive whole number.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        private function CreateComplexOperationsTrigonometricSubtask($number_of_subtasks){
            $solutions = [];
            $descriptions = [];
            $printable_solutions = ["<div class=\"editable_box\"><label class=\"editable_label\">Megoldás:</label></div>"];

            $this->dimat_helper_functions->SetMinimumNumber(-100);
            $this->dimat_helper_functions->SetMaximumNumber(100 + $number_of_subtasks);
            
            $task_data = array("pairs_of_complex_numbers" => []);
            for($subtask_counter = 0; $subtask_counter < $number_of_subtasks; $subtask_counter++){
                $pair_of_complex_numbers = $this->dimat_helper_functions->CreateComplexNumbers(2);
                while(in_array($pair_of_complex_numbers,$task_data["pairs_of_complex_numbers"])){
                    $pair_of_complex_numbers = $this->dimat_helper_functions->CreateComplexNumbers(2);
                }
                array_push($task_data["pairs_of_complex_numbers"], $pair_of_complex_numbers);

                $task_text = "<div class=\"editable_box\"><label class=\"editable_label\">" . $subtask_counter + 1 . ". csoport: </label></div>";
                $task_text = $task_text . "<div class=\"editable_box\"><label class=\"editable_label\">Adottak az " .  PrintServices::CreatePrintableComplexNumberAlgebraic("x", $pair_of_complex_numbers[0]) . " és " . PrintServices::CreatePrintableComplexNumberAlgebraic("y", $pair_of_complex_numbers[0]) . " komplex számok.</label></div>";
                $printable_solution = "<div class=\"editable_box\"><label class=\"editable_label\">" . $subtask_counter + 1 . ". csoport: </label></div>";
                $printable_solution = $printable_solution. "<div class=\"editable_box\"><label class=\"editable_label\">" .  PrintServices::CreatePrintableComplexNumberAlgebraic("x", $pair_of_complex_numbers[0]) . ", " . PrintServices::CreatePrintableComplexNumberAlgebraic("y", $pair_of_complex_numbers[1]) . ".</label></div>";

                $operations = [$this->dimat_helper_functions->UseMoivre("multiplication", $pair_of_complex_numbers[0], $pair_of_complex_numbers[1]), $this->dimat_helper_functions->UseMoivre("division", $pair_of_complex_numbers[0], $pair_of_complex_numbers[1])];
                $task_text = $task_text . "<div class=\"editable_box\"><label class=\"editable_label\">Add meg a fenti komplex számok szorzatát és hányadosát a trigonometrikus alakok segítségével!</label></div>";
                $printable_solution = $printable_solution. "<div class=\"editable_box\"><label class=\"editable_label\">x * y = " .  PrintServices::CreatePrintableComplexNumberTrigonometric("", $operations[0], true, false) . "</label></div>";
                $printable_solution = $printable_solution. "<div class=\"editable_box\"><label class=\"editable_label\">x / y = " .  PrintServices::CreatePrintableComplexNumberTrigonometric("", $operations[1], true, false) . "</label></div>";

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
         * This private method will generate a set of tasks related to the seventh main topic - first subtopic of Discrete Mathematics I.
         *
         * Per subtask:
         * 
         * Creates 1 complex number and 2 powers (natural numbers). The first power is between 3 and 4 (inclusively), the second is between 5 and 6 (inclusively).
         * Then detemines the powers of the complex number by its trigonometric form.
         * 
         * @param int $number_of_subtasks The number of subtasks which is a positive whole number.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        private function CreateComplexPowerTrigonometricSubtask($number_of_subtasks){
            $solutions = [];
            $descriptions = [];
            $printable_solutions = ["<div class=\"editable_box\"><label class=\"editable_label\">Megoldás:</label></div>"];

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

                $task_text = "<div class=\"editable_box\"><label class=\"editable_label\">" . $subtask_counter + 1 . ". csoport: </label></div>";
                $task_text = $task_text . "<div class=\"editable_box\"><label class=\"editable_label\">Adott az " .  PrintServices::CreatePrintableComplexNumberAlgebraic("x", $complex_number) . " komplex szám.</label></div>";
                $printable_solution = "<div class=\"editable_box\"><label class=\"editable_label\">" . $subtask_counter + 1 . ". csoport: </label></div>";
                $printable_solution = $printable_solution. "<div class=\"editable_box\"><label class=\"editable_label\">" .  PrintServices::CreatePrintableComplexNumberAlgebraic("x", $complex_number) . ".</label></div>";

                $operations = [$this->dimat_helper_functions->UseMoivre("power", $complex_number, 0, $first_power), $this->dimat_helper_functions->UseMoivre("power", $complex_number, 0, $second_power)];
                $task_text = $task_text . "<div class=\"editable_box\"><label class=\"editable_label\">Add meg az x<sup>$first_power</sup> és x<sup>$second_power</sup> hatványozások eredményét!</label></div>";
                $printable_solution = $printable_solution. "<div class=\"editable_box\"><label class=\"editable_label\">x<sup>$first_power</sup> = " .  PrintServices::CreatePrintableComplexNumberTrigonometric("", $operations[0], true, false) . "</label></div>";
                $printable_solution = $printable_solution. "<div class=\"editable_box\"><label class=\"editable_label\">x<sup>$second_power</sup>= " .  PrintServices::CreatePrintableComplexNumberTrigonometric("", $operations[1], true, false) . "</label></div>";

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
         * This private method will generate a set of tasks related to the seventh main topic - second subtopic of Discrete Mathematics I.
         * 
         * Per subtask:
         * 
         * Creates 1 complex number and 2 powers for the nth roots (natural numbers). The first power is between 3 and 4 (inclusively), the second is between 5 and 6 (inclusively).
         * Then detemines the nth roots of the complex number by its trigonometric form.
         * 
         * @param int $number_of_subtasks The number of subtasks which is a positive whole number.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        private function CreateComplexRootTrigonometricSubtask($number_of_subtasks){
            $solutions = [];
            $descriptions = [];
            $printable_solutions = ["<div class=\"editable_box\"><label class=\"editable_label\">Megoldás:</label></div>"];

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

                $task_text = "<div class=\"editable_box\"><label class=\"editable_label\">" . $subtask_counter + 1 . ". csoport: </label></div>";
                $task_text = $task_text . "<div class=\"editable_box\"><label class=\"editable_label\">Adott az " .  PrintServices::CreatePrintableComplexNumberAlgebraic("x", $complex_number) . " komplex szám.</label></div>";
                $printable_solution = "<div class=\"editable_box\"><label class=\"editable_label\">" . $subtask_counter + 1 . ". csoport: </label></div>";
                $printable_solution = $printable_solution. "<div class=\"editable_box\"><label class=\"editable_label\">" .  PrintServices::CreatePrintableComplexNumberAlgebraic("x", $complex_number) . ".</label></div>";

                $operations = [$this->dimat_helper_functions->UseMoivre("root", $complex_number, 0, $first_root), $this->dimat_helper_functions->UseMoivre("root", $complex_number, 0, $second_root)];
                $task_text = $task_text . "<div class=\"editable_box\"><label class=\"editable_label\">Add meg az <sup>$first_root</sup>\u{221A}x és <sup>$second_root</sup>\u{221A}x gyökvonás eredményét!</label></div>";
                
                $printable_solution = $printable_solution. "<div class=\"editable_box\"><label class=\"editable_label\"><sup>$first_root</sup>\u{221A}x = " . PrintServices::CreatePrintableComplexNumberTrigonometric("", ["<sup>$first_root</sup>\u{221A}|x|", "(\u{03C6} + 2*k*\u{03C0})/$first_root"], false, false) . "</label></div>";
                foreach($operations[0]["arguments"] as $root_counter => $root){
                    $printable_solution = $printable_solution . "<div class=\"editable_box\"><label class=\"editable_label\">k = $root_counter \u{2192} " . PrintServices::CreatePrintableComplexNumberTrigonometric("", [$operations[0]["size"], $root], false) . "</label></div>";
                }

                $printable_solution = $printable_solution. "<div class=\"editable_box\"><label class=\"editable_label\"><sup>$second_root</sup>\u{221A}x = " . PrintServices::CreatePrintableComplexNumberTrigonometric("", ["<sup>$second_root</sup>\u{221A}|x|", "(\u{03C6} + 2*k*\u{03C0})/$second_root"], false, false) . "</label></div>";
                foreach($operations[1]["arguments"] as $root_counter => $root){
                    $printable_solution = $printable_solution . "<div class=\"editable_box\"><label class=\"editable_label\">k = $root_counter \u{2192} " . PrintServices::CreatePrintableComplexNumberTrigonometric("", [$operations[1]["size"], $root], false) . "</label></div>";
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
         * This private method will generate a set of tasks related to the eight main topic - first subtopic of Discrete Mathematics I.
         * 
         * Creates 2 whole numbers (with variables x and y), then 3 exponents, 2 for the variables and 1 for the sum (positive whole numbers). It also creates the result variable's exponent (between 5 and 15 (inclusively)).
         * Determines the coefficient for the result expression by the binomial theorem.
         * 
         * @param int $number_of_subtasks The number of subtasks which is a positive whole number.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        private function CreateBinomialTheoremSubtask($number_of_subtasks){
            $solutions = [];
            $descriptions = [];
            $printable_solutions = ["<div class=\"editable_box\"><label class=\"editable_label\">Megoldás:</label></div>"];

            $minimum = -10;
            $maximum = 10 + $number_of_subtasks;
            
            $quadruplets = [];
            $task_data = ["coefficients" => [], "exponents" => [], "result_expressions_exponent" => []];
            for($subtask_counter = 0; $subtask_counter < $number_of_subtasks; $subtask_counter++){
                // Data formation
                $first_number = mt_rand($minimum,$maximum); // This is a_1
                $second_number = mt_rand($minimum,$maximum); // This is b_1
                $first_exponent = mt_rand(1,$maximum); // This is e_1
                $second_exponent = mt_rand(1,$maximum); // This is e_2
                while(in_array([$first_number, $second_number, $first_exponent, $second_exponent],$quadruplets) || $first_number === 0 || $second_number === 0){
                    $first_number = mt_rand($minimum,$maximum); // This is a_1
                    $second_number = mt_rand($minimum,$maximum); // This is b_1
                    $first_exponent = mt_rand(1,$maximum); // This is e_1
                    $second_exponent = mt_rand(1,$maximum); // This is e_2
                }
                $third_exponent = mt_rand(5,15); // This is c
                array_push($task_data["coefficients"], [$first_number,$second_number]);
                array_push($task_data["exponents"], [$first_exponent,$second_exponent, $third_exponent]);

                // a, b, c; a = a_1*x**e_1, b = b_1*x**e_2
                // d => (i=0..c) (c alatt i)*a**(c-i)*b**(i) = (c alatt i)*(a_1*x**e_1)**(c-i))*(b_1*x**e_2)**(i)
                // (c alatt i) * x**(e_1*(c-i)+e_2*i) * a_1**(c-i)) * b_1 ** i
                // e_1*(c-i)+e_2*i = e_1*c + i*(e_2-e_1)
                    // pl.: 7*27 + i*(3-7) = 189 - 4*i (i=0..27)
                // How to get a good exponent for d? It will have the form of e_1*c + i*(e_2-e_1) (i=0..c), so basically we have to choose an i between 0 and c, and calculate this sum
                // Or calculate all of the possible coefficient - exponent pair and choose a random exponent (let's choose this)
                $result_form = $this->dimat_helper_functions->GetBinomialTheorem([$first_number,$second_number], [$first_exponent,$second_exponent, $third_exponent]);
                $result_pair = $result_form[mt_rand(0,count($result_form)-1)];
                array_push($task_data["result_expressions_exponent"], $result_pair[1]);

                $task_text = "<div class=\"editable_box\"><label class=\"editable_label\">" . $subtask_counter + 1 . ". csoport: </label></div>";
                $task_text .= "<div class=\"editable_box\"><label class=\"editable_label\">Adott a ($first_number*x<sup>$first_exponent</sup> $second_number*x<sup>$second_exponent</sup>)<sup>$third_exponent</sup> kifejezés.</label></div>";
                $task_text .= "<div class=\"editable_box\"><label class=\"editable_label\"> Határozd meg az x<sup>" . $result_pair[1] . "</sup> együtthatóját!</label></div>";
                
                $printable_solution = "<div class=\"editable_box\"><label class=\"editable_label\">" . $subtask_counter + 1 . ". csoport: </label></div>";
                $printable_solution .= "<div class=\"editable_box\"><label class=\"editable_label\">($first_number*x<sup>$first_exponent</sup>" . PrintServices::PlusMinus($second_number) . abs($second_number) . "*x<sup>$second_exponent</sup>)<sup>$third_exponent</sup> = </label></div>";
                $printable_solution .= "<div class=\"editable_box\"><label class=\"editable_label\">(i=0..$third_exponent) ($third_exponent alatt i)*($first_number*x<sup>$first_exponent</sup>)<sup>(" . $third_exponent . "-i)</sup>*($second_number*x<sup>$second_exponent</sup>)<sup>i</sup> = </label></div>";
                $printable_solution .= "<div class=\"editable_box\"><label class=\"editable_label\">(i=0..$third_exponent) ($third_exponent alatt i)*x<sup>(" . $first_exponent*$third_exponent . PrintServices::PlusMinus($second_exponent-$first_exponent) . abs($second_exponent-$first_exponent) . "*i" . ")</sup>*";
                $printable_solution .= $first_number . "<sup>(" . $third_exponent . "-i)</sup>*$second_number<sup>i</sup></label></div>";
                $printable_solution .= "<div class=\"editable_box\"><label class=\"editable_label\">i: " . $first_exponent * $third_exponent . "+i*" . $second_exponent - $first_exponent . "=" . $result_pair[1] . "\u{2194}";
                $printable_solution .= "i*" . $second_exponent - $first_exponent . "=" . $result_pair[1] - $first_exponent * $third_exponent;
                
                if($second_exponent - $first_exponent !== 0){
                    $printable_solution .= "\u{2194}i=" . ($result_pair[1] - $first_exponent * $third_exponent) / ($second_exponent - $first_exponent);
                    $final_index = ($result_pair[1] - $first_exponent * $third_exponent) / ($second_exponent - $first_exponent);
                }else{
                    $final_index = $first_exponent * $third_exponent;
                }
               
                $printable_solution .= "\u{2192}</label></div><div class=\"editable_box\"><label class=\"editable_label\">($third_exponent alatt $final_index)*x<sup>(" . $first_exponent*$third_exponent . PrintServices::PlusMinus($second_exponent-$first_exponent) . abs($second_exponent-$first_exponent) . "*$final_index" . ")</sup>*";
                $printable_solution .= $first_number . "<sup>(" . $third_exponent . "-$final_index)</sup>*$second_number<sup>$final_index</sup> =" . $result_pair[0] . "x<sup>" . $result_pair[1] . "</sup></label></div>";


                array_push($descriptions, $task_text);
                array_push($printable_solutions, $printable_solution);
                $solutions = array_merge($solutions, array("solution_0_" . $subtask_counter => $result_pair[0]));
            }

            return array("data" => $task_data , "descriptions" => $descriptions, "solutions" => $solutions, "printable_solutions" => $printable_solutions);
        }

        /**
         * This private method will generate a set of tasks related to the eight main topic - second subtopic of Discrete Mathematics I.
         * 
         * Per subtask:
         * 
         * Creates a polynomial expression with degree between 3 and 5 (inclusively).
         * Determines the polynomial expression from its roots by the general Viéte- formula.
         * 
         * @param int $number_of_subtasks The number of subtasks which is a positive whole number.
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        private function CreateVieteFormulaSubtask($number_of_subtasks){
            $solutions = [];
            $descriptions = [];
            $printable_solutions = ["<div class=\"editable_box\"><label class=\"editable_label\">Megoldás:</label></div>"];

            $lower = -10;
            $upper = 10 + $number_of_subtasks;
            
            $polynomial_expressions = [];
            $task_data = ["polynomial_expression_roots" => [], "main_coefficients" => []];
            $dimatii_helper_functions = new DimatiiHelperFunctions();
            for($subtask_counter = 0; $subtask_counter < $number_of_subtasks; $subtask_counter++){
                $polynomial_degree = mt_rand(3,5);            
                $created_expression = $dimatii_helper_functions->CreatePolynomialExpression($polynomial_degree, $lower, $upper);
                $polynomial_expression = $created_expression[0];
                $roots = $created_expression[1];
                while(in_array($polynomial_expressions, $polynomial_expression)){
                    $polynomial_degree = mt_rand(3,5);            
                    $created_expression = $dimatii_helper_functions->CreatePolynomialExpression($polynomial_degree, $lower, $upper);
                    $polynomial_expression = $created_expression[0];
                    $roots = $created_expression[1];
                }
                array_push($polynomial_expressions, $polynomial_expression);

                $task_text = "<div class=\"editable_box\"><label class=\"editable_label\">" . $subtask_counter + 1 . ". csoport: </label></div>";
                $task_text .= "<div class=\"editable_box\"><label class=\"editable_label\">Adottak a " . PrintServices::CreatePrintablePlaces($roots) . " számok. ";
                $task_text .= "A Viète- formulák használatával határozd meg azt a polinomot, amelynek a fenti számok a gyökei és " . $polynomial_expression[0] . " a főegyütthatója!</label></div>";
                
                array_push($task_data["polynomial_expression_roots"], $roots);
                array_push($task_data["main_coefficients"], $polynomial_expression[0]);

                $printable_solution = "<div class=\"editable_box\"><label class=\"editable_label\">" . $subtask_counter + 1 . ". csoport: </label></div>";
                $printable_solution .= "<div class=\"editable_box\"><label class=\"editable_label\">P[x] =";
                for($root_counter = 0; $root_counter < count($roots); $root_counter++){
                    if($root_counter !== 0){
                        $printable_solution .= " * ";
                    }else{
                        $printable_solution .= $polynomial_expression[0] . " * ";
                    }
                    $printable_solution .= "(x" . PrintServices::PlusMinus(-1*$roots[$root_counter]) . abs($roots[$root_counter]) . ")";
                }
                $printable_solution .= "</label></div>";

                $indices = [];
                for($index_counter = 0; $index_counter < count($roots); ++$index_counter){
                    array_push($indices, $index_counter);
                }

                for($bottom_index_counter = 0; $bottom_index_counter <= $polynomial_degree; $bottom_index_counter++){
                    $printable_solution .= "<div class=\"editable_box\"><label class=\"editable_label\">";
                    $printable_solution .= "x<sub>" . $polynomial_degree - $bottom_index_counter . "</sub> = ";
                    
                    $solution_part_variable = "a";
                    $solution_part_value = $polynomial_expression[0];
                    $bottom_index_list = $this->dimat_helper_functions->DetermineCombinationOfList($indices, $bottom_index_counter);
                    foreach($bottom_index_list as $bottom_index_list_counter => $index_list){
                        if($bottom_index_list_counter !== 0){
                            $solution_part_variable .= " + ";
                            $solution_part_value .= "+";
                        }else{
                            $solution_part_variable .= "*(";
                            $solution_part_value .= "*(";
                        }
                        
                        foreach($index_list as $list_element_coutner => $element_index){
                            if($list_element_coutner !== 0){
                                $solution_part_variable .= "*";
                                $solution_part_value .= "*";
                            }
                            $solution_part_variable .= "x<sub> $element_index</sub>";
                            
                            $solution_part_value .= -1* $roots[$element_index];
                        }

                        if($bottom_index_list_counter === count($bottom_index_list) - 1){
                            $solution_part_variable .= ")";
                            $solution_part_value .= ")";
                        }
                    }
                    $printable_solution .= $solution_part_variable;
                    $printable_solution .= " = " . $solution_part_value;
                    
                    if($bottom_index_counter !== 0){
                        $printable_solution .= " = " . $polynomial_expression[$bottom_index_counter];
                    }
                    
                    $printable_solution .= "</label></div>";
                }
                $printable_solution .= "<div class=\"editable_box\"><label class=\"editable_label\">P[x] = " . PrintServices::CreatePrintablePolynomial($polynomial_expression) . "</label></div>";

                array_push($descriptions, $task_text);
                array_push($printable_solutions, $printable_solution);
                $solutions = array_merge($solutions, array("solution_1_" . $subtask_counter => $polynomial_expression));
            }

            return array("data" => $task_data , "descriptions" => $descriptions, "solutions" => $solutions, "printable_solutions" => $printable_solutions);
        }

        /**
         * This private method will generate a set of tasks related to the nineth main topic - first subtopic of Discrete Mathematics I.
         * 
         * Per subtask:
         * 
         * Creates a graph with 6 degrees. Each of theme is minimum 0.
         * While creating these, it also determines if the graph can be created, or not.
         * 
         * @param int $number_of_subtasks The number of subtasks which is a positive whole number.
         * @param string $graph_type The type of the graph. The default is "simple".
         * 
         * @return array Returns an associative array containing the data, the task text containing html elements, the raw solution and the solution's text containing html elements.
         */
        private function CreateGraphSubtask($number_of_subtasks, $graph_type = "simple"){
            $solutions = [];
            $descriptions = [];
            $printable_solutions = ["<div class=\"editable_box\"><label class=\"editable_label\">Megoldás:</label></div>"];
            
            $max = 8 + floor($number_of_subtasks / 8**6);
            $task_data = [];
            for($subtask_counter = 0; $subtask_counter < $number_of_subtasks; $subtask_counter++){
                [$graph, $solution] =  $this->dimat_helper_functions->CreateGraph(6,0,$max, $graph_type);
                if(in_array($graph, $task_data)){
                    [$graph, $solution] =  $this->dimat_helper_functions->CreateGraph(6,0,$max, $graph_type);
                }
                array_push($task_data, $graph);

                $task_text = "<div class=\"editable_box\"><label class=\"editable_label\">" . $subtask_counter + 1 . ". csoport: </label></div>";
                $degrees_text = "";
                $graph_type_text = "";

                switch($graph_type){
                    case "simple":{
                        $task_text .= "<div class=\"editable_box\"><label class=\"editable_label\">Adott egy gráf a következő fokszámsorozattal: ";
                        $degrees_text = PrintServices::CreatePrintableGraph($graph, "simple");
                        $graph_type_text = "egyszerű gráf";
                        $task_text .= $degrees_text;
                        $task_text .=  ". Megszerkeszthető-e ez az egyszerű gráf?</label></div>";
                    }break;
                    case "tree":{
                        $task_text .= "<div class=\"editable_box\"><label class=\"editable_label\">Adott egy gráf a következő fokszámsorozattal: ";
                        $degrees_text =  PrintServices::CreatePrintableGraph($graph, "tree");
                        $graph_type_text = "fagráf";
                        $task_text .= $degrees_text;
                        $task_text .= ". Megszerkeszthető-e ez a fagráf?</label></div>";
                    };break;
                    case "directed":{
                        $task_text .= "<div class=\"editable_box\"><label class=\"editable_label\">Adott egy gráf a következő fokszámsorozattal: ";
                        $degrees_text =  PrintServices::CreatePrintableGraph($graph, "directed");
                        $graph_type_text = "irányított gráf";
                        $task_text .= $degrees_text;
                        $task_text .= ". Megszerkeszthető-e ez az irányított gráf?</label></div>";
                    };break;
                    case"paired":{
                        $task_text .= "<div class=\"editable_box\"><label class=\"editable_label\">Adott egy gráf a következő fokszámsorozatokkal: ";
                        $degrees_text = PrintServices::CreatePrintableGraph($graph, "paired");
                        $graph_type_text = "páros gráf";
                        $task_text .= $degrees_text;
                        $task_text .= ". Megszerkeszthető-e ez a páros gráf?</label></div>";
                    };break;
                    default:break;
                }

                $printable_solution = "<div class=\"editable_box\"><label class=\"editable_label\">" . $subtask_counter + 1 . ". csoport: </label></div>";
                $printable_solution .= "<div class=\"editable_box\"><label class=\"editable_label\">A $degrees_text által adott $graph_type_text ";
                if($solution){
                    $printable_solution .= "megszerkeszthető";
                }else{
                    $printable_solution .= "nem szerkeszthető meg";
                } 
                $printable_solution .= ".</label></div>";

                array_push($descriptions, $task_text);
                array_push($printable_solutions, $printable_solution);
                array_push($solutions, $solution);
            }

            return array("data" => $task_data, "descriptions" => $descriptions, "solutions" => $solutions, "printable_solutions" => $printable_solutions);
        }

        /**
         * This private method creates the complete set task. 
         * 
         * It will create a subtask for each operation in the ["union", "intersection", "substraction", "complementer", "symmetric difference"] array.
         * 
         * @param array $sets The created sets from which the operands will be picked.
         * @param string $subtask_counter The index of the actual subtask.
         * 
         * @return array Returns an array containing the operations and the results of these operations.
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
         * This private method picks new operand(s) for the actual operation and returns the result of this operation.
         * 
         * @param array $sets The created sets from which the operands will be picked.
         * @param int $number_of_sets The number of created sets.
         * @param int $operation_index The index of the actual operation.
         * @param array $set_indices The indices pairs/ indices of the sets that were previously chosen for the actual operation.
         * 
         * @return array Returns an array containing the new operand(s) for the actual operation, and the result of the operation.
         */
        private function CreateOperandsAndOperationForSets($sets, $number_of_sets, $operation_index, $set_indices){
            // The names of the sets
            $actual_set_names = array_keys($sets);
            
            // Pick a new pair of indices from the [0, $number_of_sets] interval
            $new_indices = $this->dimat_helper_functions->PickNewPairOfIndices($set_indices, $number_of_sets);
            $new_element = [$actual_set_names[$new_indices[0]??""],$actual_set_names[$new_indices[1]]??""];
            
            $operands = [[],[]];
            if($operation_index === 3){ // Complementer, here we need only one operand
                $new_index = $this->dimat_helper_functions->PickNewElement($set_indices, $number_of_sets);
                $picked_set_name = $actual_set_names[$new_index];
                $universe = $this->dimat_helper_functions->GetUniverse($sets[$picked_set_name]);
                $new_element =  [$picked_set_name, $universe];
                $operands = [$sets[$picked_set_name]??[], $universe];
            }else{ // Union/ Intersection/ Substraction/ Symmetric difference, here we need 2 operands
                $operands = [$sets[$new_element[0]]??[],$sets[$new_element[1]]??[]];
            }

            $solution_for_new_element = $this->GetOperationSolutionForSets($operation_index, $operands);
            return [$new_element, $solution_for_new_element];
        }

        /**
         * This private method returns the result of the actual operation executed on the operands.
         * 
         * @param int $operation_index The index of the actual operation.
         * @param array $operands An array containing the operand(s).
         * 
         * @return array Returns an array containing the result of the actual operation executed on the operands.
         */
        private function GetOperationSolutionForSets($operation_index, $operands){
            $first_operand = $operands[0];
            $second_operand = $operands[1];
            $solution = [];

            switch($operation_index){
                case "0":{ // Union
                    $solution = $first_operand;
                    foreach($second_operand as $index => $element){
                        if(!in_array($element,$solution)){
                            array_push($solution,$element);
                        }
                    }
                };break;
                case "1":{ // Intersection
                    $solution = [];
                    foreach($second_operand as $index => $element){
                        if(in_array($element, $first_operand)){
                            array_push($solution,$element);
                        }
                    }
                };break;
                case "2":{ // Substraction
                    $solution = [];
                    foreach($first_operand as $index => $element){
                        if(!in_array($element,$second_operand)){
                            array_push($solution,$element);
                        }
                    }
                };break;
                case "3":{ // Complementer
                    $solution = [];
                    $universe = $second_operand;
                    foreach($universe as $index => $element){
                        if(!in_array($element,$first_operand)){
                            array_push($solution,$element);
                        }
                    }
                };break;
                case "4":{ // Symmetric difference
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
         * This private method creates the complete complex operations task. 
         * 
         * It will create a subtask for each operation in the ["addition", "multiplication", "substraction", "division"] array.
         * 
         * @param array $set_of_complex_numbers The created complex numbers from which the operands will be picked.
         * @param int $subtask_counter The index of the actual subtask.
         * 
         * @return array Returns an array containing the operations and the results of these operations.
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
         * This private method picks new operands for the actual operation and returns the result of this operation.
         * 
         * @param array $set_of_complex_numbers The created complex numbers from which the operands will be picked.
         * @param int $number_of_complex_numbers The number of created complex numbers.
         * @param int $operation_index The index of the actual operation.
         * @param array $complex_numbers_indices The indices pairs of the complex numbers that were previously chosen for the actual operation.
         * 
         * @return array Returns an array containing the new operands for the actual operation, and the result of the operation.
         */
        private function CreateOperandsAndOperationForComplexNumbers($set_of_complex_numbers, $number_of_complex_numbers, $operation_index, $complex_numbers_indices){
            // The name of the complex numbers
            $actual_complex_numbers_names = array_keys($set_of_complex_numbers);
            
            // Pick a new pair of indices from the [0, $number_of_complex_numbers] interval
            $new_indices = $this->dimat_helper_functions->PickNewPairOfIndices($complex_numbers_indices, $number_of_complex_numbers);
            $new_element = [$actual_complex_numbers_names[$new_indices[0]??""],$actual_complex_numbers_names[$new_indices[1]]??""];
            $operands = [$set_of_complex_numbers[$new_element[0]]??[],$set_of_complex_numbers[$new_element[1]]??[]];

            // The operands real and imaginary parts
            $first_number_real_part = $operands[0][0];
            $first_number_imaginary_part = $operands[0][1];
            $second_number_real_part = $operands[1][0];
            $second_number_imaginary_part = $operands[1][1];
            $result_real_part = 0;
            $result_imaginary_part = 0;

            switch($operation_index){
                case 0:{ // Addition
                    $result_real_part = $first_number_real_part + $second_number_real_part;
                    $result_imaginary_part = $first_number_imaginary_part + $second_number_imaginary_part;
                };break; 
                case 1:{ // Multiplication
                    $result_real_part = $first_number_real_part * $second_number_real_part - $first_number_imaginary_part * $second_number_imaginary_part;
                    $result_imaginary_part = $first_number_real_part * $second_number_imaginary_part + $first_number_imaginary_part * $second_number_real_part;
                };break;
                case 2:{ // Substraction
                    $result_real_part = $first_number_real_part - $second_number_real_part;
                    $result_imaginary_part = $first_number_imaginary_part - $second_number_imaginary_part;
                };break;
                case 3:{ // Division
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
