<?php
    function UseCorrectAdverb($number){
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

    function UseCorrectObjectSuffix($number){
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

    function PrintSet($set_name, $elements){
        $set = $set_name . " = { ";
        foreach($elements as $index => $element){
            if($index !== 0){
                $set = $set . ", ";
            }
            $set = $set . $element;
        }
        $set = $set . "}";
        return $set;
    }

    function PrintPolynomialExpression($polynomial_degree, $polynomial_expression_coefficients){
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

    function PrintPlaces($places){
        $return_string = "";
        foreach($places as $place_counter => $place){
            $prefix = $place_counter !== 0?', ':'';
            $prefix = $place_counter === (count($places) - 1)?' és ':$prefix;
            $return_string = $return_string . $prefix . $place;
        }
        return $return_string;
    }

    function PrintPoints($points){
        for($point_counter = 0; $point_counter < count($points); $point_counter++){
            $prefix = $point_counter !== 0?', ':'';
            echo($prefix . "(" . $points[$point_counter][0] . ", " . $points[$point_counter][1] . ")");
        }
    }

    function IsCorrect($current_answer){
        if(isset($current_answer["correct"])){
            if($current_answer["correct"]){
                return  "correct";
            }else{
                return "wrong";
            }
        }else{
            return "solution_input";
        }
    }
?>

<?php if($approved_student_subject=="i" ):?>
    <?php if(intval($_SESSION["topic"]) == 0):?>
        <?php include("./partials/taskContents/dimatiTasks/taskOne.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 1):?>
        <?php include("./partials/taskContents/dimatiTasks/taskTwo.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 2):?> 
        <?php include("./partials/taskContents/dimatiTasks/taskThree.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 3):?>
        <?php include("./partials/taskContents/dimatiTasks/taskFour.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 4):?>
        <?php include("./partials/taskContents/dimatiTasks/taskFive.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 5):?>
        <?php include("./partials/taskContents/dimatiTasks/taskSix.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 6):?>
        <?php include("./partials/taskContents/dimatiTasks/taskSeven.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 7):?>
        <?php include("./partials/taskContents/dimatiTasks/taskEight.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 8):?>
        <?php include("./partials/taskContents/dimatiTasks/taskNine.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 9):?>
        <?php include("./partials/taskContents/dimatiTasks/taskTen.php");?>
    <?php endif?>
<?php elseif($approved_student_subject=="ii" ):?>
    <?php if(intval($_SESSION["topic"]) == 0):?>
        <?php include("./partials/taskContents/dimatiiTasks/taskOne.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 1):?>
        <?php include("./partials/taskContents/dimatiiTasks/taskTwo.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 2):?> 
        <?php include("./partials/taskContents/dimatiiTasks/taskThree.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 3):?>
        <?php include("./partials/taskContents/dimatiiTasks/taskFour.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 4):?>
        <?php include("./partials/taskContents/dimatiiTasks/taskFive.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 5):?>
        <?php include("./partials/taskContents/dimatiiTasks/taskSix.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 6):?>
        <?php include("./partials/taskContents/dimatiiTasks/taskSeven.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 7):?>
        <?php include("./partials/taskContents/dimatiiTasks/taskEight.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 8):?>
        <?php include("./partials/taskContents/dimatiiTasks/taskNine.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 9):?>
        <?php include("./partials/taskContents/dimatiiTasks/taskTen.php");?>
    <?php endif?>
<?php endif?>