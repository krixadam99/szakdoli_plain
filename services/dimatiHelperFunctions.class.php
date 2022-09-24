<?php
    /**
     * This is a helper class which contains helper functions related to Discrete Mathematics I..
     * 
    */
    class DimatiHelperFunctions {
        /**
        * This variable contains all of the possible set names, which are uppercase English alphabet characters.
        *
        * @var array An array containing all of the uppercase English alphabet characters.
        */
        private $set_names;
        private $complex_number_names;

        /**
        * This variable contains all of the possible characters, which are lowercase English alphabet characters.
        *
        * @var array An array containing all of the lowercase English alphabet characters.
        */
        private $possible_abc_characters;
        private $maximum_number;
        private $minimum_number;

        /**
         * 
         * The contructor for DimatiHelperFunctions class.
         * 
         * The range for random numbers; set, complex number names and possible alphabetic characters are set here.
         * 
         * @return void
         */
        public function __construct(){
            $this->maximum_number = 10;
            $this->minimum_number = 1;
            $this->set_names = [
                "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N",
                "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z" 
            ];
            $this->complex_number_names = ["v", "w", "x", "y", "z"];
            $this->possible_abc_characters = [
                "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n",
                "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z"                       
            ];
        }

        /**
         *
         * This method is responsible for setting the lowe bound of the range from which numbers will be picked randomly.
         *  
         * @param int $maximum_number The lower bound for the range from which numbers will be picked randomly.
         * @return void
        */
        public function SetMinimumNumber($minimum_number){ $this->minimum_number = $minimum_number;}

        /**
         *
         * This method is responsible for setting the upper bound of the range from which numbers will be picked randomly.
         *  
         * @param int $maximum_number The upper bound for the range from which numbers will be picked randomly.
         * @return void
        */
        public function SetMaximumNumber($maximum_number){ $this->maximum_number = $maximum_number;}

        /**
         * 
         */
        public function GetSetNames(){ return $this->set_names;}

        /**
         * 
         */
        public function GetComplexNumberNames(){ return $this->complex_number_names;}

        /**
         * 
         */
        public function GetPossibleAbcCharacters(){ return $this->possible_abc_characters;}

        /**
         * 
         */
        public function GetMinimumNumber(){ return $this->minimum_number;}

        /**
         * 
         */
        public function GetMaximumNumber(){ return $this->maximum_number;}

        /**
         *
         * This method is responsible for creating sets.
         * 
         * Each of the sets will consist the same amount of elements.
         * It can also be set if the elements can repeat in the sets (bags), or not.
         *  
         * @param int $number_of_sets The number of sets that will be generated.
         * @param int $minimum_number_of_elements The minimum number of elements that will be put into the sets. The default is 3.
         * @param int $maximum_number_of_elements The maximum number of elements that will be put into the sets. The default is 5.
         * @param bool $is_associative This decides whether the sets are associative, or given by indices.
         * @param bool $is_bag If this is true, then the elements in the sets can repeat, else they can't. The default value for this parameter is false.
         * @return array Returns an associative array containing the sets and their names.
        */
        public function CreateSets($number_of_sets, $minimum_number_of_elements = 3, $maximum_number_of_elements = 5, $is_associative = false, $is_bag = false){
            $return_sets = [];
            $picked_names = [];

            for($set_counter = 0; $set_counter < $number_of_sets; $set_counter++){
                $new_set = [];
                if($is_associative){
                    $picked_name = $this->set_names[mt_rand(0,count($this->set_names) - 1)];
                    while(in_array($picked_name,$picked_names) && $number_of_sets < count($this->set_names)){
                        $picked_name = $this->set_names[mt_rand(0,count($this->set_names) - 1)];
                    }
                    array_push($picked_names, $picked_name);
                }

                $number_of_elements = mt_rand(abs($minimum_number_of_elements),abs($maximum_number_of_elements)); // Minimum min(3,$maximum_number_of_elements), and maxium max(3,$maximum_number_of_elements) elements
                for($element_counter = 0; $element_counter < $number_of_elements; $element_counter++){
                    $new_element = 0;
                    if(!$is_bag){
                        $new_element = $this->CreateNewRandomElement($new_set);
                    }else{
                        $new_element = $this->CreateRandomElement();
                    }
                    if($new_element != "%FULL%"){
                        array_push($new_set, $new_element);
                    }
                }
                
                if($is_associative){
                    $return_sets[$picked_name] = $new_set;
                }else{
                    array_push($return_sets, $new_set);
                }
            }
            return $return_sets;
        }

        /**
         *
         * This method is responsible for returning part of a set.
         * 
         * If the number of elements to be returned is greater, or equal to the size of the set, then the function returns the original set, else the function returns the requested number of random elements from the set.
         *  
         * @param array $set The set from which we want to get elements.
         * @param int $number_of_elements The number of elements that will be returned from the given set.
         * @return array A part of the set with the requested amount of elements.
        */
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

        /**
         * This public method creates a new pair of indices.
         * 
         * We get the number of created elements. This method will pick two indices between 0 and the number of the created sets, then it gives back if this pair is a new one.
         * Operations will be exectued between the sets with the first and second indices.
         * Additionally, this method checks, if new pairs can be picked or not.
         * 
         * @param array $chosen_indices An indexed array containing the previously chosen set index pairs in the form of [first_set_index, second_set_index].
         * @param int $number_of_elements A whole number, this is the number of created sets. We wish to pick a pair from the range of 0 and this number (inclusively).
         * 
         * @return array Returns an indexed array containing a new pair of indices.
         */
        public function PickNewPairOfIndices($chosen_indices, $number_of_elements){
            if(count($chosen_indices) < $number_of_elements*($number_of_elements - 1)){
                $first_index = mt_rand(0, $number_of_elements-1);
                $second_index = mt_rand(0, $number_of_elements-1);
                while($first_index == $second_index || in_array([$first_index, $second_index], $chosen_indices)){
                    $first_index = mt_rand(0, $number_of_elements-1);
                    $second_index = mt_rand(0, $number_of_elements-1);
                }
                return [$first_index, $second_index];
            }else{
                return ["",""];
            }
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


        /**
         * This public method creates a new index.
         * 
         * We get the number of created elements. This method will pick an index between 0 and the number of the created elements, then it gives back if this index is a new one.
         * Additionally, this method checks, if new index can be picked or not.
         * 
         * @param array $chosen_index An indexed array containing the previously chosen set indices.
         * @param int $number_of_elements A whole number, this is the number of created elements. We wish to pick a new index from the range of 0 and this number (inclusively).
         * 
         * @return array Returns an indexed array containing a new index.
         */
        public function PickNewElement($chosen_index, $number_of_elements){
            if(count($chosen_index) < $number_of_elements){
                $first_index = mt_rand(0, $number_of_elements-1);
                while(in_array($first_index, $chosen_index)){
                    $first_index = mt_rand(0, $number_of_elements-1);
                }
                return $first_index;
            }else{
                return "";
            }
        }

        /**
         *
         * This function is responsible for returning a part of a cartesian product.
         * 
         * If the number of elements is greater, or equal to the product of the first and second sets' size, then the function returns the cartesian product of the two set, else the function returns the requested number of ordered pairs, which first and second elements are randomly selected from the first and second sets respectively.
         * Non of the ordered pairs can be repeated.
         * 
         * @param array $first_set The set from which the pairs' first element will be chosen randomly.
         * @param array $image The image The set from which the pairs' second element will be chosen randomly.
         * @param int $number_of_elements The number of ordered pairs that will be returned.
         * @return array A relation containing ordered pairs consisting elements of the two given sets, the form of this array is: [[element, element],[element, elemen]]
        */
        public function CreateDescartesProduct($first_set, $second_set, $number_of_elements){
            if($number_of_elements < count($first_set)*count($second_set)){
                $relation = [];
    
                for($counter = 0; $counter < $number_of_elements; $counter++){
                    $first_set_random_element = $first_set[mt_rand(0,count($first_set)-1)];
                    $second_set_random_element = $second_set[mt_rand(0,count($second_set)-1)];
                    while(in_array([$first_set_random_element,$second_set_random_element],$relation)){
                        $first_set_random_element = $first_set[mt_rand(0,count($first_set)-1)];
                        $second_set_random_element = $second_set[mt_rand(0,count($second_set)-1)];
                    }
                    array_push($relation, [$first_set_random_element,$second_set_random_element]);
                }
    
                return $relation;
            }else{
                $relation = [];
    
                for($first_set_counter = 0; $first_set_counter < count($first_set); $first_set_counter++){
                    $first_set_element = $first_set[$first_set_counter];
                    for($second_set_counter = 0; $second_set_counter < count($second_set); $second_set_counter++){
                        $second_set_element = $second_set[$second_set_counter];
                        array_push($relation, [$first_set_element ,$second_set_element]);
                    }
                }

                return $relation;
            }
        }

        /**
         *
         * This function is responsible for creating a new complex number.
         * 
         * The function will create the real and imaginary part of each complex number.
         * If this pair has already been created, then a new pair will be generated, until it is not present in the returned array.
         *  
         * @param int $number_of_elements The number of complex numbers to return.
         * @return array Array containing the given number of complex numbers of the form [real part, imaginary part].
        */
        public function CreateComplexNumbers($number_of_elements){
            $range_length =  $this->maximum_number - $this->minimum_number + 1;
            $complex_numbers = [];

            if($number_of_elements <= $range_length * $range_length){ // Avoiding for-ever while loop
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
            }else{
                for($real_part_counter = $this->minimum_number; $real_part_counter <= $this->maximum_number; $real_part_counter++){
                    for($complex_part_counter = $this->minimum_number; $complex_part_counter <= $this->maximum_number; $complex_part_counter++){
                        array_push($complex_numbers, [$real_part_counter,$complex_part_counter]);
                    }
                }
            }
            return $complex_numbers;
        }

        /**
         *
         * This function is responsible for getting the universe of the given set.
         * 
         * For numbers, all of the numbers will be picked from the smallest number of the set to the biggest number of the set.
         * For alphabet charactes, all of the alphabet charatcers will be picked between the smallest and biggest alphabet characters of the set (small and big as their index in the alphabet).
         * 
         * @param array $set An indexed array containing the elements of the set.
         * @return array An array containing the universe of the given set of the form [element,element...].
        */
        public function GetUniverse($set){
            $universe = [];
            
            // Minimax search for numbers and alphabet characters
            $minimum_number = $this->maximum_number;
            $maximum_number = $this->minimum_number;
            $minimum_alphabetic = "z";
            $maximum_alpabetic = "a";
            foreach($set as $index => $element){
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
            
            for($numeric_counter = $minimum_number; $numeric_counter <= $maximum_number; ++$numeric_counter ){
                if(mt_rand(0,10) < 4 || in_array($numeric_counter,$set)){
                    array_push($universe, $numeric_counter);
                }
            }

            foreach($this->possible_abc_characters as $index => $possible_abc_character){
                if($possible_abc_character <= $maximum_alpabetic && $possible_abc_character >= $minimum_alphabetic){
                    if(mt_rand(0,10) < 4 || in_array($possible_abc_character,$set)){
                        array_push($universe, $possible_abc_character);
                    }
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

        /**
         * This public method returns all of the possible relations for a given base set
         */
        public function GetAllPossibleRelations($base_set){
            $all_relations = [[]];

            // Determine all possible combinations of the base set of size 2
            // These are combinations, that is, elements, where the order doesn't matter
            // But firstly, We need all pairs, that's why we need the inverses of the elements, also the reflexive elements
            $all_pairs = $this->DetermineCombinationOfList($base_set, 2);

            // [1,2,3,4] -> [[1,2],[1,3],[1,4],[2,3],[2,4],[3,4]] + [[2,1],[3,1],[4,1],[3,2],[4,2],[4,3]] + [[1,1], [2,2], [3,3], [4,4]]
            foreach($all_pairs as $element_counter => $pair){
                array_push($all_pairs, [$pair[1],$pair[0]]);
            }
            foreach($base_set as $element_counter => $element){
                array_push($all_pairs, [$element,$element]);
            }
            array_push($all_relations, $all_pairs);

            for($relation_size_counter = 1; $relation_size_counter < count($all_pairs); $relation_size_counter++){
                $all_relation_with_size = $this->DetermineCombinationOfList($all_pairs, $relation_size_counter); // Here literal combinations will be picked, so the order doesn't matter
                $all_relations = array_merge($all_relations, $all_relation_with_size);
            }

            return $all_relations;
        }

        /**
         * This public method will filter the relations by the characteristics.
         */
        public function FilterRelationsWithCharacteristics($base_set, $all_relations, $characteristics, $lower_bound){
            foreach($characteristics as $characteristic_name => $satisfies){
                $filtered_array = [];
                foreach($all_relations as $relation_counter => $relation){
                    if($lower_bound <= count($relation)){
                        $missed = false;
                        
                        switch($characteristic_name){
                            case "Reflexív":{
                                $missed = $this->IsReflexiveRelation($base_set, $relation) != $satisfies;
                            };break;
                            case "Irreflexív":{
                                $missed = $this->IsIrreflexiveRelation($base_set, $relation) != $satisfies;
                            };break;
                            case "Szimmetrikus":{
                                $missed = $this->IsSymmetricRelation($base_set, $relation) != $satisfies;
                            };break;
                            case "Antiszimmetrikus":{
                                $missed = $this->IsAntiSymmetricRelation($base_set, $relation) != $satisfies;
                            };break;
                            case "Asszimetrikus":{
                                $missed = $this->IsAssymmetricRelation($base_set, $relation) != $satisfies;
                            };break;
                            case "Tranzitív":{
                                $missed = $this->IsTransitiveRelation($base_set, $relation) != $satisfies;
                            };break;
                            default:;break;
                        }

                        if(!$missed){
                            array_push($filtered_array, $relation);
                        }
                    }
                }
                $all_relations = $filtered_array;
            }

            return $all_relations; 
        }

        public function SolveQuadraticEquation($a, $b, $c){
            $return_values = [];
            $discriminator = $b**2 - 4*$a*$c;
            $is_pure_real = true;
            if($discriminator < 0){
                $is_pure_real = false;
                $discriminator -= 1;
            }

            if($is_pure_real){
                array_push($return_values, [(-1*$b+sqrt($discriminator))/(2*$a),0]);
                if($discriminator != 0){
                    array_push($return_values, [(-1*$b-sqrt($discriminator))/(2*$a),0]);
                }
            }else{
                array_push($return_values, [(-1*$b)/(2*$a),sqrt($discriminator)/(2*$a)]);
                array_push($return_values, [(-1*$b)/(2*$a),(-1*sqrt($discriminator))/(2*$a)]);
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

        public function GetNthUnitRoot($n){
            $root = [];
            if($n>0 && is_int($n)){
                array_push($root, 1, (2*mt_rand(1, $n-1)*pi())/$n);
            }
            return $root;
        }

        /**
         * 
         * This private recursive method creates a list containing possible combinations of the elements of the given list, where the number of elements per list is also given. The order of these elements per combination does not matter!
         * 
         * The list will be iterated through by embedded iterations, where the "deepest level" is the same as the required amount of elements per combination.
         * Every iteration will start from the element following the "parent" iteration's actual element and ends at the element of the index of the original (list's size - original number of elements per combination + level of iteration (embedding count)).
         * The element pushing happens on the deppest level.
         * Since embedding n number of iterations is tedious and certainly not a good practice, the easiest way to implement this task is to make it recursive.
         * 
         * @param array $original_list The original list of which the method will give the combinations.
         * @param int $number_of_remained_iterations The number of remained iterations. This decreases by every recursive call.
         * @param array $actual_elements This is a list of elements. It is growing every turn, and will finally contain a combination when it gets to the deepest level of iterations. When this finally contains as many elements as originally was required, then it gets pushed to the return array.
         * @param int $previous_index The previous iteration's last element's index.
         * 
         * @return array An indexed array containing possible combinations of the original list's elements (required number of elements). In the final level all of the combinations are in the returned array.
        */
        private function DetermineCombinationOfList($original_list, $number_of_remained_iterations = 1, $actual_elements = [], $previous_index = 0){
            if($number_of_remained_iterations >= 1){ // At least 1 iterations remained
                if($number_of_remained_iterations < count($original_list)){ // The number of remained iterations is not greater than, or equal to the number of elements of the original list 
                    if($number_of_remained_iterations > 1){ // At least 2 iterations remained
                        $return_list = [];
                        for($counter = $previous_index; $counter < count($original_list) - $number_of_remained_iterations + 1; $counter++){
                            $temporary_list = $actual_elements; // NOT reference, also this is needed, or else we should pop the last element of $actual_elements in the end of each iteration
                            array_push($temporary_list, $original_list[$counter]);
                            $combination_list = $this->DetermineCombinationOfList($original_list, $number_of_remained_iterations - 1, $temporary_list, $counter + 1); // A part of the final list of combinations
                            $return_list = array_merge($return_list, $combination_list); // Merging the list of combinations with part of the possible combinations  
                        }
                        return $return_list;
                    }elseif($number_of_remained_iterations === 1){ // There is only 1 iteration left
                        $return_list = [];
                        for($counter = $previous_index; $counter < count($original_list); $counter++){
                            $temporary_list = $actual_elements; // NOT reference, also this is needed, or else we should pop the last element of $actual_elements in the end of each iteration
                            array_push($temporary_list, $original_list[$counter]);
                            array_push($return_list, $temporary_list);
                        }
                        return $return_list; // Returning a part of the final combination's list, this is the deepest level of iterations
                    }
                }else{
                    return [$original_list];
                }
            }
            
            return [];
        }

        /**
         * This private method will either pick a random number which is in the range of the class's minimum and maximum numbers (inclusive) or a random (English) lowercase alphabetic character. The number or alphabetic character choice is also randmoly made.
         * 
         * Additionally, this method checks if the set's size is smaller than the possible number of elements. This is a security check, to avoid a forever loop.
         * 
         * @param array $set An indexed array containing the elements of a set.
         * 
         * @return int|string Returns either a whole number which is in the range of the class's minimum and maximum numbers (inclusive) or a random (English) lowercase alphabetic character. Or it returns the "%FULL%" string which means, that no more element could be picked. 
         */
        private function CreateNewRandomElement($set){
            $number_range = $this->maximum_number - $this->minimum_number + 1;
            $alphabet_range = count($this->possible_abc_characters);

            // Check the size of the set (it should be smaller than the number of possible set elements).
            if(count($set) < $number_range + $alphabet_range){
                $random_element = $this->CreateRandomElement();

                while(in_array($random_element, $set)) {
                    $random_element = $this->CreateRandomElement();
                }
                return $random_element;
            }else{
                return "%FULL%";
            }
        }

        /**
         * This private method will either pick a random number which is in the range of the class's minimum and maximum numbers (inclusive) or a random (English) lowercase alphabetic character. The number or alphabetic vharacter choice is also randmoly made.
         * 
         * @return int|string Returns either a whole number which is in the range of the class's minimum and maximum numbers (inclusive) or a random (English) lowercase alphabetic character.
         */
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