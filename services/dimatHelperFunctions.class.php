<?php
    class DimatHelperFunctions {
        private $set_names;
        private $complex_number_names;
        private $possible_abc_characters;
        private $maximum_number;
        private $minimum_number;
        
        public function __construct(){
            $this->maximum_number = 10;
            $this->minimum_number = 1;
            $this->set_names = ["A", "B", "C", "D"];
            $this->complex_number_names = ["v", "w", "x", "y", "z"];
            $this->possible_abc_characters = [
                "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n",
                "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z"                       
            ];
        }

        public function SetMaximumNumber($maximum_number){ $this->maximum_number = $maximum_number;}
        public function SetMinimumNumber($minimum_number){ $this->minimum_number = $minimum_number;}

        public function CreateSets($sets, $number_of_elements, $is_bag = false){
            $return_sets = [];
            foreach($sets as $index => $set){
                $new_set = [];
                for($element_counter = 0; $element_counter < $number_of_elements; $element_counter++){
                    $new_element = 0;
                    if(!$is_bag){
                        $new_element = $this->CreateNewRandomElement($new_set);
                    }else{
                        $new_element = $this->CreateRandomElement();
                    }
                    array_push($new_set, $new_element);
                }
                array_push($return_sets,$new_set);
            }
            return $return_sets;
        }

        public function GetPartOfSet($set, $number_of_elements){
            if($number_of_elements < count($set)){
                $return_set = [];
                for($element_counter = 0; $element_counter < $number_of_elements; $element_counter++){
                    $random_element = $set[mt_rand(0,count($set)-1)];
                    
                    while(in_array($random_element, $return_set)){
                        $random_element = $set[mt_rand(0,count($set)-1)];
                    }
                    array_push($return_set, $random_element);
                }
                return $return_set;
            }else{
                return $set;
            }
        }

        public function CreateNewPairOfSets($array, $first_set, $second_set){
            $is_new_pair = count($array) == 0;
            $first_index = array_search($first_set, $this->set_names);
            $second_index = array_search($second_set, $this->set_names);
            while(!$is_new_pair){
                $is_new_pair = !in_array([$first_set, $second_set], $array[0]);
                if(!$is_new_pair){
                    $first_index = mt_rand(0, 3);
                    $second_index = mt_rand(0, 3);
                    $first_set = $this->set_names[$first_index];
                    $second_set = $this->set_names[$second_index];
                    while($second_set == $first_set){
                        $second_index = mt_rand(0, 3);
                        $second_set = $this->set_names[$second_index];
                    }
                }
            }
            return [$first_index, $second_index];
        }

        public function CreateNewPairOfNumbers($array, $first_number, $second_number){
            $is_new_pair = !in_array([$first_number, $second_number], $array);
            $first_index = array_search($first_number, $this->complex_number_names);
            $second_index = array_search($second_number, $this->complex_number_names);
            while(!$is_new_pair){
                $is_new_pair = !in_array([$first_number, $second_number], $array);
                if(!$is_new_pair){
                    $first_index = mt_rand(0, 4);
                    $second_index = mt_rand(0, 4);
                    while($first_index == $second_index){
                        $first_index = mt_rand(0, 4);
                        $second_index = mt_rand(0, 4);
                    }
                    $first_number = $this->complex_number_names[$first_index];
                    $second_number = $this->complex_number_names[$second_index];
                }
            }
            return [$first_index, $second_index];
        }

        public function CreateNewSetElement($array, $first_set){
            $is_new_pair = count($array) == 0;
            $first_index = array_search($first_set, $this->set_names);
            
            while(!$is_new_pair){
                $is_new_pair = $first_set != $array[0][0];
                if(!$is_new_pair){
                    $first_index = mt_rand(0, 3);
                    $first_set = $this->set_names[$first_index];
                }
            }
            return $first_index;
        }

        public function CreateDescartesProduct($domain, $image, $number_of_elements){
            if($number_of_elements < count($domain)*count($image)){
                $relation = [];
    
                for($counter = 0; $counter < $number_of_elements; $counter++){
                    $random_element_domain = $domain[mt_rand(0,count($domain)-1)];
                    $random_element_image = $image[mt_rand(0,count($image)-1)];
                    while(in_array([$random_element_domain,$random_element_image],$relation)){
                        $random_element_domain = $domain[mt_rand(0,count($domain)-1)];
                        $random_element_image = $image[mt_rand(0,count($image)-1)];
                    }
                    array_push($relation, [$random_element_domain,$random_element_image]);
                }
    
                return $relation;
            }else{
                $relation = [];
    
                for($domain_counter = 0; $domain_counter < count($domain); $domain_counter++){
                    $domain_element = $domain[$domain_counter];
                    for($image_counter = 0; $image_counter < count($image); $image_counter++){
                        $image_element = $image[$image_counter];
                        array_push($relation, [$domain_element ,$image_element]);
                    }
                }

                return $relation;
            }
        }

        public function CreateComplexNumbers($number_of_elements){
            $complex_numbers = [];
            for($counter = 0; $counter < $number_of_elements; $counter++){
                $real_part = mt_rand($this->minimum_number, $this->maximum_number);
                $imaginary_part = mt_rand($this->minimum_number, $this->maximum_number);
                $complex_number = [$real_part, $imaginary_part];
                while(in_array($complex_number, $complex_numbers)){
                    $real_part = mt_rand($this->minimum_number, $this->maximum_number);
                    $imaginary_part = mt_rand($this->minimum_number, $this->maximum_number);
                    $complex_number = [$real_part, $imaginary_part];
                }
                array_push($complex_numbers, $complex_number);
            }
            return $complex_numbers;
        }

        public function GetUniverse($index, $sets=[]){
            $set_A = $sets[0];
            $set_B = $sets[1];
            $set_C = $sets[2];
            $set_D = $sets[3];

            switch($index){
                case 0: $first_operand = $set_A; break;
                case 1: $first_operand = $set_B; break;
                case 2: $first_operand = $set_C; break;
                case 3: $first_operand = $set_D; break;
                default: break;
            }
            
            $universe = [];
            $minimum_number = $this->maximum_number;
            $maximum_number = $this->minimum_number;
            $minimum_alphabetic = "z";
            $maximum_alpabetic = "a";
            foreach($first_operand as $index => $element){
                if(is_int($element)){
                    if($element < $minimum_number){
                        $minimum_number = $element;
                    }
                    if($element > $maximum_number){
                        $maximum_number = $element;
                    }
                }else{
                    if($element < $minimum_alphabetic){
                        $minimum_alphabetic = $element;
                    }
                    if($element > $maximum_alpabetic){
                        $maximum_alpabetic = $element;
                    }
                }
            }
            
            for($numeric_counter = $minimum_number; $numeric_counter <= $maximum_number; ++$numeric_counter ) array_push($universe, $numeric_counter);
            foreach($this->possible_abc_characters as $index => $possible_abc_character){
                if($possible_abc_character <= $maximum_alpabetic && $possible_abc_character >= $minimum_alphabetic){
                    array_push($universe, $possible_abc_character);
                }
            }

            return $universe;
        } 

        public function GetRelationTwoArrayForm($relation){
            $first_components = [];
            $second_components = [];
            foreach($relation as $index => $pair){
                array_push($first_components,$pair[0]);
                array_push($second_components,$pair[1]);
            }
            return [$first_components, $second_components];
        }

        public function GetImageBySet($relation, $set){
            $result_image = [];
            foreach($relation as $index => $pair){
                if(in_array($pair[0], $set) && !in_array($pair[1],$result_image)){
                    array_push($result_image, $pair[1]);
                }
            }
            return $result_image;
        }

        public function GetDomainBySet($relation, $set){
            $result_domain = [];
            foreach($relation as $index => $pair){
                if(in_array($pair[1], $set) && !in_array($pair[0],$result_domain)){
                    array_push($result_domain, $pair[0]);
                }
            }
            return $result_domain;
        }

        public function GetDomainOfRelation($relation){
            $domain = [];
            foreach($relation as $index => $pair){
                if(!in_array($pair[0], $domain)){
                    array_push($domain, $pair[0]);
                }
            }
            return $domain;
        }

        public function GetImageOfRelation($relation){
            $image = [];
            foreach($relation as $index => $pair){
                if(!in_array($pair[1], $image)){
                    array_push($image, $pair[1]);
                }
            }
            return $image;
        }

        public function GetRestrictedRelation($relation, $narrow_to_set){
            $return_relation = [];
            foreach($relation as $index => $pair){
                if(in_array($pair[0], $narrow_to_set)){
                    array_push($return_relation, $pair);
                }
            }
            return $return_relation;
        }

        public function GetInverseRelation($relation){
            $inverse_relation = [];
            foreach($relation as $index => $pair){
                array_push( $inverse_relation , [$pair[1],$pair[0]]);
            }
            return $inverse_relation;
        }

        public function CreateCompositionOfRelations($first_relation, $second_relation){
            $composition = [];
            foreach($second_relation as $index => $first_pair){
                foreach($first_relation as $index => $second_pair){
                    if($first_pair[1] == $second_pair[0]){
                        $new_pair = [$first_pair[0],$second_pair[1]];
                        if(!in_array($new_pair,$composition)){
                            array_push($composition, $new_pair);
                        }
                    }
                }
            }
            return $composition;
        }

        public function MakeRelationFromArrays($first_array, $second_array){
            $relation = [[],[]];
            foreach($first_array as $index => $element){
                array_push($relation[0], $element);
                array_push($relation[1], $second_array[$index]);
            }
            return $relation;
        }

        public function GetCharacteristics(){
            $is_reflexive = false;
            $is_irreflexive = false;
            $is_symmetric = false;
            $is_antisymmetric = false;
            $is_assymetric = false;
            $is_transitive = false;

            if(mt_rand(0,1)==1){
                $is_reflexive = true;
                //never assymetric, never irreflexive

                if(mt_rand(0,1)==1){
                    $is_symmetric = true;
                    if(mt_rand(0,1)==1){
                        $is_antisymmetric = true;
                        $is_transitive = true;
                    }else{
                        if(mt_rand(0,1)==1){
                            $is_transitive = true; //(1,1), (1,2), (2,1)
                        }
                    }
                }else{
                    $is_symmetric = false;
                    if(mt_rand(0,1)==1){
                        $is_antisymmetric = true;
                        if(mt_rand(0,1)==1){
                            $is_transitive = true; //(1,1), (1,2), (2,2)
                        }
                    }else{
                        if(mt_rand(0,1)==1){
                            $is_transitive = true; //(1,1), (1,2), (2,1), (2,2), (2,3), (1,3), (3,3)
                        }
                    }
                }
            }else{
                $is_reflexive = false;
                if(mt_rand(0,1)==1){
                    $is_irreflexive = true;
                    if(mt_rand(0,1)==1){
                        $is_symmetric = true;
                        //never antisymmetric, never assymetric, never  transitive
                    }else{
                        $is_symmetric = false;
                        if(mt_rand(0,1)==1){
                            $is_antisymmetric = true;
                            $is_assymetric = true;
                            if(mt_rand(0,1)==1){
                                $is_transitive = true; //(1,2)
                            }
                        }else{
                            //never assymetric
                        }
                    }
                }else{
                    //never assymetric
                    if(mt_rand(0,1)==1){
                        $is_symmetric = true;
                        if(mt_rand(0,1)==1){
                            $is_antisymmetric = true;
                            $is_transitive = true; //(1,1) (base=1,2,3)
                        }else{
                            if(mt_rand(0,1)==1){
                                $is_transitive = true; //(1,1), (1,2), (2,1), (2,2) (base=1,2,3)
                            }
                        }
                    }else{
                        $is_symmetric = false;
                        if(mt_rand(0,1)==1){
                            $is_antisymmetric = true;
                            $is_transitive = true; //(1,1), (1,2) (base=1,2,3)
                        }else{
                            if(mt_rand(0,1)==1){
                                $is_transitive = true; //(1,2), (2,1), (1,1), (2,2), (1,3), (2,3) (base=1,2,3)
                            }
                        }
                    }
                }
            }

            return array("Reflexív" => $is_reflexive,"Irreflexív" => $is_irreflexive,"Szimmetrikus" => $is_symmetric,"Antiszimmetrikus" => $is_antisymmetric,"Asszimetrikus" => $is_assymetric,"Tranzitív" => $is_transitive);
        }

        public function IsReflexiveRelation($base_set, $relation){
            foreach($base_set as $base_index => $base_element){
                if(!in_array([$base_element,$base_element], $relation)){
                    return false;
                }
            }
            return true;
        }

        public function IsIrreflexiveRelation($base_set, $relation){
            foreach($base_set as $base_index => $base_element){
                if(in_array([$base_element,$base_element], $relation)){
                    return false;
                }
            }
            return true;
        }

        public function IsSymmetricRelation($base_set, $relation){
            foreach($base_set as $first_counter => $first_element){
                foreach($base_set as $second_counter => $second_element){
                    if(in_array([$first_element,$second_element], $relation) && !in_array([$second_element,$first_element], $relation)){
                        return false;
                    }
                }
            }
            return true;
        }

        public function IsAntiSymmetricRelation($base_set, $relation){
            foreach($base_set as $first_counter => $first_element){
                foreach($base_set as $second_counter => $second_element){
                    if(in_array([$first_element,$second_element], $relation) && in_array([$second_element,$first_element], $relation) && $first_element != $second_element){
                        return false;
                    }
                }
            }
            return true;
        }

        public function IsAssymmetricRelation($base_set, $relation){
            foreach($base_set as $first_counter => $first_element){
                foreach($base_set as $second_counter => $second_element){
                    if(in_array([$first_element,$second_element], $relation) && in_array([$second_element,$first_element], $relation)){
                        return false;
                    }
                }
            }
            return true;
        }

        public function IsTransitiveRelation($base_set, $relation){
            foreach($base_set as $first_counter => $first_element){
                foreach($base_set as $second_counter => $second_element){
                    foreach($base_set as $third_counter => $third_element){
                        if(in_array([$first_element,$second_element], $relation) && in_array([$second_element,$third_element], $relation) && !in_array([$first_element,$third_element], $relation)){
                            return false;
                        }
                    }
                }
            }
            return true;
        }

        public function IsDichotomousRelation($base_set, $relation){
            foreach($base_set as $first_counter => $first_element){
                foreach($base_set as $second_counter => $second_element){
                    if(!in_array([$first_element,$second_element], $relation) && !in_array([$second_element,$first_element], $relation)){
                        return false;
                    }
                }
            }
            return true;
        }

        public function IsTrichotomousRelation($base_set, $relation){
            foreach($base_set as $first_counter => $first_element){
                foreach($base_set as $second_counter => $second_element){
                    $counter = 0;
                    if(in_array([$first_element,$second_element], $relation)){
                        $counter++;
                    }
                    if(in_array([$second_element,$first_element], $relation)){
                        $counter++;
                    }
                    if($first_element == $second_element){
                        $counter++;
                    }
                    if($counter != 1){
                        return false;
                    }
                }
            }
            return true;
        }

        public function IsEquivalenceRelation($base_set, $relation){
            return $this->IsReflexiveRelation($base_set, $relation) && $this->IsSymmetricRelation($base_set, $relation) && $this->IsTransitiveRelation($base_set, $relation);
        }

        public function IsPartlyOrderedRelation($base_set, $relation){
            return $this->IsReflexiveRelation($base_set, $relation) && $this->IsAntiSymmetricRelation($base_set, $relation) && $this->IsTransitiveRelation($base_set, $relation);
        }

        public function IsStrictlyPartlyOrderedRelation($base_set, $relation){
            return $this->IsIrreflexiveRelation($base_set, $relation) && $this->IsAntiSymmetricRelation($base_set, $relation) && $this->IsTransitiveRelation($base_set, $relation);
        }

        public function MakeFunction($domain, $image, $number_of_pairs){
            if($number_of_pairs <= count($domain)){
                $relation = [];
                $first_components = [];

                for($counter = 0; $counter < $number_of_pairs; $counter++){
                    $random_element_domain = $domain[mt_rand(0,count($domain)-1)];
                    $random_element_image = $image[mt_rand(0,count($image)-1)];
                    while(in_array($random_element_domain, $first_components)){
                        $random_element_domain = $domain[mt_rand(0,count($domain)-1)];
                        $random_element_image = $image[mt_rand(0,count($image)-1)];
                    }
                    array_push($relation, [$random_element_domain,$random_element_image]);
                    array_push($first_components, $random_element_domain);
                }
    
                return $relation;
            }else{
                return [];
            }

        }

        public function IsFunction($relation){
            $relation_first_components = $this->GetRelationTwoArrayForm($relation)[0];
            $found_elements = [];
            foreach($relation_first_components as $index => $element){
                if(in_array($element, $found_elements)){
                    return false;
                }
                array_push($found_elements, $element);
            }
            return true;
        }

        public function IsSurjective($relation, $image){
            if($this->IsFunction($relation)){
                $relation_second_components = $this->GetRelationTwoArrayForm($relation)[1];
                foreach($image as $index => $element){
                    if(!in_array($element, $relation_second_components)){
                        return false;
                    }
                }
                return true;
            }else{
                return false;
            }
        }

        public function IsInjective($relation){
            if($this->IsFunction($relation)){
                $relation_second_components = $this->GetRelationTwoArrayForm($relation)[1];
                $found_elements = [];
                foreach($relation_second_components as $index => $element){
                    if(in_array($element, $found_elements)){
                        return false;
                    }
                    array_push($found_elements, $element);
                }
                return true;
            }else{
                return false;
            }
        }

        public function IsBijective($relation, $image){
            return $this->IsSurjective($relation, $image) && $this->IsInjective($relation);
        }

        public function SolveQuadraticEquation($a, $b, $c){
            $return_values = [];
            $discriminator = $b**2 + -4*$a*$c;
            $is_pure_real = true;
            if($discriminator < 0){
                $is_pure_real = false;
                $discriminator *= -1;
            }

            if($is_pure_real){
                array_push($return_values, [(-1*$b+$discriminator)/(2*$a),0]);
                array_push($return_values, [(-1*$b-$discriminator)/(2*$a),0]);
            }else{
                array_push($return_values, [(-1*$b)/(2*$a),$discriminator/(2*$a)]);
                array_push($return_values, [(-1*$b)/(2*$a),(-1*$discriminator)/(2*$a)]);
            }

            return $return_values;
        }

        public function UseMoivre($operation, $first_number, $second_number, $power=0){
            $return_values = [];
            switch($operation){
                case "multiplication":{
                    $first_trigonometric_form = $this->GetTrigonometricForm($first_number);
                    $second_trigonometric_form = $this->GetTrigonometricForm($second_number);
                    array_push($return_values, $first_trigonometric_form[0]*$second_trigonometric_form[0]);
                    array_push($return_values, $first_trigonometric_form[1]*$second_trigonometric_form[1]);
                }break;
                case "division":{
                    $first_trigonometric_form = $this->GetTrigonometricForm($first_number);
                    $second_trigonometric_form = $this->GetTrigonometricForm($second_number);
                    array_push($return_values, $first_trigonometric_form[0]/$second_trigonometric_form[0]);
                    array_push($return_values, $first_trigonometric_form[1]-$second_trigonometric_form[1]);
                }break;
                case "power":{
                    $first_trigonometric_form = $this->GetTrigonometricForm($first_number);
                    if($power != 0){
                        array_push($return_values, $first_trigonometric_form[0]**$power);
                        array_push($return_values, $first_trigonometric_form[1]*$power);
                    }else{
                        array_push($return_values, 1, 0);
                    }
                }break;
                case "root":{
                    $first_trigonometric_form = $this->GetTrigonometricForm($first_number);
                    if($power != 0){
                        array_push($return_values, $first_trigonometric_form[0]/$power);
                        for($k=0; $k<abs($power); $k++){
                            array_push($return_values, ($first_trigonometric_form[1]+2*$k*pi())/$power);
                        }
                    }else{
                        array_push($return_values, 1, 0);
                    }
                }break;
                default:break;
            }
            return $return_values;
        }

        public function GetTrigonometricForm($algebraic_form = [0,0]){
            $length = sqrt($algebraic_form[0]**2 + $algebraic_form[1]**2);
            $argument = 0;
            if($algebraic_form[0] != 0){
                $argument = atan($algebraic_form[1]/$algebraic_form[0]);
            }else{
                $argument = pi()/2;
            }

            return [$length, $argument];
        }

        private function CreateNewRandomElement($set){
            $random_element = $this->CreateRandomElement();

            while(in_array($random_element, $set)) {
                $random_element = $this->CreateRandomElement();
            }
            return $random_element;
        }

        private function CreateRandomElement(){
            $element_type = mt_rand(0, 1);
            $random_element = 0;
            if($element_type == 0){//We will pick a number
                $random_element = mt_rand($this->minimum_number, $this->maximum_number);
            }else{//We will pick an (English) alphabet character
                $random_element = $this->possible_abc_characters[mt_rand(0, count($this->possible_abc_characters)-1)];
            }

            return $random_element;
        }
    };
?>