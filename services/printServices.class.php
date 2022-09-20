<?php

    class PrintServices {
        /**
         * 
         */
        static function UseCorrectAdverb($number){
            $suffix = "";
            switch(intval($number) % 10){
                case 0: {
                    switch(intval($number) % 100){
                        case 0: $suffix = "al";break;
                        case 10: $suffix = "zel";break;
                        case 20: $suffix = "szal";break;
                        case 30: $suffix = "cal";break;
                        case 40: $suffix = "nel";break;
                        case 50: $suffix = "nel";break;
                        case 60: $suffix = "nal";break;
                        case 70: $suffix = "nel";break;
                        case 80: $suffix = "nal";break;
                        case 90: $suffix = "nel";break;
                    }
                };break;
                case 1: $suffix = "gyel";break;
                case 2: $suffix = "vel";break;
                case 3: $suffix = "mal";break;
                case 4: $suffix = "gyel";break;
                case 5: $suffix = "tel";break;
                case 6: $suffix = "tal";break;
                case 7: $suffix = "tel";break;
                case 8: $suffix = "cal";break;
                case 9: $suffix = "cel";break;
            }
            return $suffix;
        }
    
        /**
         * 
         */
        static function UseCorrectObjectSuffix($number){
            $suffix = "";
            switch(intval($number) % 10){
                case 0: {
                    switch(intval($number) % 100){
                        case 0: $suffix = "t";break;
                        case 10: $suffix = "et";break;
                        case 20: $suffix = "at";break;
                        case 30: $suffix = "at";break;
                        case 40: $suffix = "et";break;
                        case 50: $suffix = "et";break;
                        case 60: $suffix = "at";break;
                        case 70: $suffix = "et";break;
                        case 80: $suffix = "at";break;
                        case 90: $suffix = "et";break;
                    }
                };break;
                case 1: $suffix = "et";break;
                case 2: $suffix = "őt";break;
                case 3: $suffix = "at";break;
                case 4: $suffix = "et";break;
                case 5: $suffix = "öt";break;
                case 6: $suffix = "ot";break;
                case 7: $suffix = "et";break;
                case 8: $suffix = "at";break;
                case 9: $suffix = "et";break;
            }
            return $suffix;
        }

        /**
         * 
         */
        static function PrintPolynomialExpression($polynomial_degree, $polynomial_expression_coefficients){
            foreach($polynomial_expression_coefficients as $coefficient_index => $coefficient){
                $actual_index = $polynomial_degree - $coefficient_index;
                
                $prefix = "";
                if($coefficient_index != 0){
                    $prefix = $coefficient < 0?" - ":" + ";
                    $coefficient = abs($coefficient);
                }
                if($coefficient != 0){
                    $coefficient = $coefficient === 1 && $actual_index !== 0?"":$coefficient;
                    $coefficient = $coefficient === -1 && $coefficient_index === 0?"-":$coefficient;
                    $variable = $actual_index === 0?"":"x";
                    $expo = $actual_index <= 1?"":"<span class=\"exp\">$actual_index</span>";
                    echo($prefix . $coefficient . $variable . $expo);
                }
            }
        }
    
        /**
         * 
         */
        static function PrintPlaces($places){
            $return_string = "";
            foreach($places as $place_counter => $place){
                $prefix = $place_counter !== 0?', ':'';
                $prefix = $place_counter === (count($places) - 1)?' és ':$prefix;
                $return_string = $return_string . $prefix . $place;
            }
            return $return_string;
        }
    
        /**
         * 
         */
        static function PrintPoints($points){
            for($point_counter = 0; $point_counter < count($points); $point_counter++){
                $prefix = $point_counter !== 0?', ':'';
                echo($prefix . "(" . $points[$point_counter][0] . ", " . $points[$point_counter][1] . ")");
            }
        }
    
    }

?>