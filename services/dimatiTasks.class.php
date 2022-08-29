<?php

    class DimatiTasks extends Tasks{        
        private $set_names;
        private $dimat_helper_functions;

        public function __construct($topic){
            $this->SetTaskDescription([]);
            $this->SetTaskSolution([]);
            $this->SetDefinitions("");

            $this->set_names = ["A", "B", "C", "D"];
            $this->dimat_helper_functions = new DimatHelperFunctions();

            mt_srand(time()); //Seeding the random number generator with the current time (we may change this overtime...)
            
            switch($topic){
                case "0":{
                    $this->SetOperations();
                };
                break;
                case "1":{
                    $this->RelationBasics();
                };
                break;
                case "2":{
                    $this->RelationComposition();
                };
                break;
                case "3":{
                    $this->FunctionAsRelation();
                };
                break;
                case "4":{
                    $this->ComplexNumbersBasics();
                };
                break;
                case "5":{
                    $this->ComplexNumbersTrigonometry();
                };
                break;
                case "6":{
                    $this->ComplexNumbersPowers();
                };
                break;
                case "7":{
                    $this->BinomialTheorem();
                };
                break;
                case "8":{
                    $this->GraphsBasics();
                };
                break;
                case "9":{
                    $this->GraphsExistence();
                };
                break;
                default:break;
            }
        }

        private function SetOperations(){
            //We will have 4 sets
            //Each set has 10 elements
            [$set_A, $set_B, $set_C, $set_D] = $this->dimat_helper_functions->CreateSets([[], [], [], []], 10, false);
            
            //Make the operations and the solutions
            $operation_dictionary = array("union" => [], "intersection" => [], "substraction" => [], "complementer" => [], "symmetric difference" => []);
            $solution_array = [];
            for($operation_counter = 0; $operation_counter < 10; $operation_counter++){
                $operation = $operation_counter%5;
                
                $first_index = mt_rand(0, 3);
                $second_index = mt_rand(0, 3);
                $first_set = $this->set_names[$first_index];
                $second_set = $this->set_names[$second_index];
                while($second_set == $first_set){
                    $second_index = mt_rand(0, 3);
                    $second_set = $this->set_names[$second_index];
                }

                switch($operation){
                    case 0:{
                        $new_indices = $this->dimat_helper_functions->CreateNewPairOfSets($operation_dictionary["union"], $first_set, $second_set);
                        array_push($operation_dictionary["union"], [$this->set_names[$new_indices[0]],$this->set_names[$new_indices[1]]]);
                        $solution_array["solution_" . $operation_counter] = $this->GetSolutionForSets($new_indices, "union", [$set_A, $set_B, $set_C, $set_D]);
                    };break;
                    case 1:{
                        $new_indices = $this->dimat_helper_functions->CreateNewPairOfSets($operation_dictionary["intersection"], $first_set, $second_set);
                        array_push($operation_dictionary["intersection"], [$this->set_names[$new_indices[0]],$this->set_names[$new_indices[1]]]);
                        $solution_array["solution_" . $operation_counter] = $this->GetSolutionForSets($new_indices, "intersection", [$set_A, $set_B, $set_C, $set_D]);
                    };break;
                    case 2:{
                        $new_indices = $this->dimat_helper_functions->CreateNewPairOfSets($operation_dictionary["substraction"], $first_set, $second_set);
                        array_push($operation_dictionary["substraction"], [$this->set_names[$new_indices[0]],$this->set_names[$new_indices[1]]]);
                        $solution_array["solution_" . $operation_counter] = $this->GetSolutionForSets($new_indices, "substraction", [$set_A, $set_B, $set_C, $set_D]);
                    };break;
                    case 3:{
                        $new_index = $this->dimat_helper_functions->CreateNewSetElement($operation_dictionary["complementer"], $first_set);
                        $universe = $this->dimat_helper_functions->GetUniverse($new_index, [$set_A, $set_B, $set_C, $set_D]);
                        array_push($operation_dictionary["complementer"], [$this->set_names[$new_index], $universe]);
                        $solution_array["solution_" . $operation_counter] = $this->GetSolutionForSets([$new_index], "complementer", [$set_A, $set_B, $set_C, $set_D], $universe);
                    };break;
                    case 4:{
                        $new_indices = $this->dimat_helper_functions->CreateNewPairOfSets($operation_dictionary["symmetric difference"], $first_set, $second_set);
                        array_push($operation_dictionary["symmetric difference"], [$this->set_names[$new_indices[0]],$this->set_names[$new_indices[1]]]);
                        $solution_array["solution_" . $operation_counter] = $this->GetSolutionForSets($new_indices, "symmetric difference", [$set_A, $set_B, $set_C, $set_D]);
                    };break;
                    default:break;
                }
            }

            $task_array = array(
                "task_description" => "Add meg az eredményét a következő műveleteknek! Válaszodban a karaktereket ','-vel válaszd el!",
                "sets" => array("A" => $set_A, "B" => $set_B, "C" => $set_C, "D" => $set_D), 
                "operations" => $operation_dictionary
            );

            $this->SetTaskDescription($task_array);
            $this->SetTaskSolution($solution_array);
        }

        private function RelationBasics(){
            //Set generation
            $this->dimat_helper_functions->SetMaximumNumber(20);
            $this->dimat_helper_functions->SetMinimumNumber(1);
            [$set_A, $set_B] = $this->dimat_helper_functions->CreateSets([[],[]], 20, false);

            $number_of_pairs = mt_rand(6, 12);
            $same = mt_rand(0, 1)==0?false:true;
            $first_set = [];
            $second_set = [];
            if($same){
                $is_A = mt_rand(0,1)==0?true:false;
                if($is_A){
                    $first_set = $set_A;
                    $second_set = $set_A;
                }else{
                    $first_set = $set_B;
                    $second_set = $set_B;
                }
            }else{
                $first_set = $set_A;
                $second_set = $set_B;
            }

            $relation = $this->dimat_helper_functions->CreateDescartesProduct($first_set, $second_set, $number_of_pairs);
            
            $narrow_to_set = $this->dimat_helper_functions->GetPartOfSet($first_set, 8, false);
            $make_image_to_set = $this->dimat_helper_functions->GetPartOfSet($first_set, 8, false);
            $make_domain_to_set = $this->dimat_helper_functions->GetPartOfSet($second_set, 8, false);

            $task_array = array(
                "task_description" => "Sorold fel az elemeket a reláció definícióinál! Az elemeket ','-vel válaszd el, a rendezett párokat (elem,elem) alakban add meg!",
                "sets" => array("A" => $first_set, "B" => $second_set, "N" => $narrow_to_set, "I" => $make_image_to_set, "D" => $make_domain_to_set),
                "relation" => $relation
            );

            $solution_array = array(
                "solution_0" => $this->dimat_helper_functions->GetDomainOfRelation($relation),
                "solution_1" => $this->dimat_helper_functions->GetImageOfRelation($relation),
                "solution_2" => $this->dimat_helper_functions->GetRestrictedRelation($relation, $narrow_to_set),
                "solution_3" => $this->dimat_helper_functions->GetInverseRelation($relation),
                "solution_4" => $this->dimat_helper_functions->GetImageBySet($relation, $make_image_to_set),
                "solution_5" => $this->dimat_helper_functions->GetDomainBySet($relation, $make_domain_to_set)
            );

            $this->SetTaskDescription($task_array);
            $this->SetTaskSolution($solution_array);
        }

        private function RelationComposition(){
            [$set_A, $set_B, $set_C] = $this->dimat_helper_functions->CreateSets([[], [], []], 5, false);

            //Composition
            $first_relation = $this->dimat_helper_functions->CreateDescartesProduct($set_B, $set_C, 6);
            $second_relation = $this->dimat_helper_functions->CreateDescartesProduct($set_A, $set_B, 6);
            $composition = $this->dimat_helper_functions->CreateCompositionOfRelations($first_relation, $second_relation);
            
            //Determine the characteristics
            $base_set = $this->dimat_helper_functions->CreateSets([[]], 3, false)[0];
            $third_relation = $this->dimat_helper_functions->CreateDescartesProduct($base_set, $base_set, mt_rand(4, 10));
            $solution_1 = array(
                $this->dimat_helper_functions->IsReflexiveRelation($base_set, $third_relation),
                $this->dimat_helper_functions->IsIrreflexiveRelation($base_set, $third_relation),
                $this->dimat_helper_functions->IsSymmetricRelation($base_set, $third_relation),
                $this->dimat_helper_functions->IsAntisymmetricRelation($base_set, $third_relation),
                $this->dimat_helper_functions->IsAssymmetricRelation($base_set, $third_relation),
                $this->dimat_helper_functions->IsTransitiveRelation($base_set, $third_relation),
                $this->dimat_helper_functions->IsDichotomousRelation($base_set, $third_relation),
                $this->dimat_helper_functions->IsTrichotomousRelation($base_set, $third_relation),
                $this->dimat_helper_functions->IsEquivalenceRelation($base_set, $third_relation)
            );
            
            //Determine a proper relation with certain characteristics
            $personal_set = $this->dimat_helper_functions->CreateSets([[]], 4, false)[0];
            $characteristics = $this->dimat_helper_functions->GetCharacteristics();
            
            $task_array = array(
                "task_description" => "Old meg a következő feladatokat!",
                "sets" => array("A" => $set_A, "B" => $set_B, "C" => $set_C),
                "relations" => array(
                    "R \u{2286} B \u{00D7} C, R" => $first_relation, 
                    "S \u{2286} A \u{00D7} B, S" => $second_relation),
                "characteristics_relation" => array("D" => $base_set, "Q \u{2286} D \u{00D7} D, Q" => $third_relation),
                "characteristics" => array("E" => $personal_set, "characteristics" => $characteristics)
            );

            $solution_array = array(
                "solution_0" => $composition,
                "solution_1" => $solution_1,
                "solution_2" => [$personal_set, $characteristics]
            );

            $this->SetTaskDescription($task_array);
            $this->SetTaskSolution($solution_array);
        }

        private function FunctionAsRelation(){
            $set_A = $this->dimat_helper_functions->CreateSets([[]], 10, false)[0];
            $set_B = $this->dimat_helper_functions->CreateSets([[]], mt_rand(4, 7), false)[0];

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

            $this->SetTaskDescription($task_array);
            $this->SetTaskSolution($solution_array);
        }

        private function ComplexNumbersBasics(){
            
        }

        private function ComplexNumbersTrigonometry(){
            
        }

        private function ComplexNumbersPowers(){
            
        }

        private function BinomialTheorem(){
            
        }

        private function GraphsBasics(){
            
        }

        private function GraphsExistence(){
            
        }

        private function GetSolutionForSets($indices, $operation, $sets, $universe = []){
            $set_A = $sets[0];
            $set_B = $sets[1];
            $set_C = $sets[2];
            $set_D = $sets[3];
            $first_operand = [];
            $second_operand = [];
            $solution = [];

            if(count($indices) == 2){                
                switch($indices[0]){
                    case 0: $first_operand = $set_A; break;
                    case 1: $first_operand = $set_B; break;
                    case 2: $first_operand = $set_C; break;
                    case 3: $first_operand = $set_D; break;
                    default: break;
                }    
                
                switch($indices[1]){
                    case 0: $second_operand = $set_A; break;
                    case 1: $second_operand = $set_B; break;
                    case 2: $second_operand = $set_C; break;
                    case 3: $second_operand = $set_D; break;
                    default: break;
                }
            }else if(count($indices) == 1){
                switch($indices[0]){
                    case 0: $first_operand = $set_A; break;
                    case 1: $first_operand = $set_B; break;
                    case 2: $first_operand = $set_C; break;
                    case 3: $first_operand = $set_D; break;
                    default: break;
                }   
            }

            switch($operation){
                case "union":{
                    $solution = $first_operand;
                    foreach($second_operand as $index => $element){
                        if(!in_array($element,$solution)){
                            array_push($solution,$element);
                        }
                    }
                };break;
                case "intersection":{
                    $solution = [];
                    foreach($second_operand as $index => $element){
                        if(in_array($element, $first_operand)){
                            array_push($solution,$element);
                        }
                    }
                };break;
                case "substraction":{
                    $solution = [];
                    foreach($first_operand as $index => $element){
                        if(!in_array($element,$second_operand)){
                            array_push($solution,$element);
                        }
                    }
                };break;
                case "complementer":{
                    $solution = [];
                    foreach($universe as $index => $element){
                        if(!in_array($element,$first_operand)){
                            array_push($solution,$element);
                        }
                    }
                };break;
                case "symmetric difference":{
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