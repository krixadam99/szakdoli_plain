<?php
    $form_token = $this->GetFormToken();
    $actual_page = "grades";

    $task_expectations_associative = [];
    foreach($task_expectations as $expectation_counter => $expectation){
        $task_expectations_associative[$expectation["task_type"]] = $expectation;
    }

    $next_small_test = "";
    $next_small_test_counter = "";
    $next_date = "";
    $is_first_date = true;
    foreach($task_due_dates as $task_due_date){
        if(isset($task_expectations_associative[$task_due_date["task_type"]])){
            $task_expectations_associative[$task_due_date["task_type"]]["due_to"] = $task_due_date["due_to"];
        }

        if(is_numeric(strpos($task_due_date["task_type"],"small_test"))){
            $small_test_counter = explode("small_test_",$task_due_date["task_type"])[1];
            if($task_due_date["due_to"] >= date("Y-m-d H:i:s")){
                if($is_first_date){
                    $next_date = $task_due_date["due_to"];
                    $next_small_test = $task_due_date["task_type"];
                    $is_first_date = false;
                    $next_small_test_counter = explode("small_test_", $task_due_date["task_type"])[1];
                }else{
                    if($task_due_date["due_to"] < $next_date){
                        $next_date = $task_due_date["due_to"];
                        $next_small_test = $task_due_date["task_type"];
                        $next_small_test_counter = explode("small_test_", $task_due_date["task_type"])[1];
                    }else if($task_due_date["due_to"] == $next_date && $small_test_counter < $next_small_test_counter){
                        $next_date = $task_due_date["due_to"];
                        $next_small_test = $task_due_date["task_type"];
                        $next_small_test_counter = $small_test_counter;
                    }
                }
            }
        }
    }

    $small_tests_sum = 0;
    foreach($results as $task_type => $result){
        if(is_numeric(strpos($task_type, "small_test"))){
            $small_tests_sum  += $result;
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./views/css/header.css" rel="stylesheet" type="text/css">
    <link href="./views/css/body.css" rel="stylesheet" type="text/css">
    <link href="./views/css/notifications.css" rel="stylesheet" type="text/css">
    <link href="./views/css/grades.css" rel="stylesheet" type="text/css">
    <title>Eredm??nyeim</title>
</head>
<body>
    <?php include("./partials/header.php")?>
    <main>
        <div id="non_header_navigation_row" style="margin: 2% 4% 2% 4%;">
            <div class="non_header_navigation_row_button chosen" id="progress_button">
                <label>El??rehalad??s</label>
            </div>
            <div class="non_header_navigation_row_button" id="results_button">
                <label>Eredm??nyek</label>
            </div>
        </div>

        <div class="grades_div non_header_navigation_div" id="progress_div">
            <label style="font-size: calc(15px + 0.3vw)">
                El??rehalad??s
            </label>
            <hr>

            <?php if(intval($results["practice_count"]) < $task_expectations_associative["practice_count"]["minimum_for_pass"]):?>
                <div class="notification_box">
                    <label>M??g <?=$task_expectations_associative["practice_count"]["minimum_for_pass"] - intval($results["practice_count"])?> gyakorlaton kell megjelennie, hogy a jelenl??tre vontakoz?? k??vetelm??nyt teljes??tse!</label>
                </div>
            <?php else:?>
                <div class="notification_box">
                    <label>A jelenl??tre vonatkoz?? k??vetelm??nyt teljes??tette!</label>
                </div>
            <?php endif?>

            <?php if($small_tests_sum < $task_expectations_associative["small_tests"]["minimum_for_pass"]):?>
                <div class="notification_box">
                    <label>
                        M??g <?=$task_expectations_associative["small_tests"]["minimum_for_pass"] - $small_tests_sum?> pontot kell el??rnie a kis z??rthelyiken, hogy a r??juk vonatkoz?? k??vetelm??nyt teljes??tse!
                        <?php if($next_date !== ""):?>
                            A <?=$next_small_test_counter?>. kis z??rthelyi id??pontja: <?=$next_date?>.
                        <?php endif?>
                    </label>
                </div>
            <?php else:?>
                <div class="notification_box">
                    <label>A kis z??rthelyire vonatkoz?? k??vetelm??nyt teljes??tette!</label>
                </div>
            <?php endif?>

            

            <?php if($task_expectations_associative["middle_term_exam"]["due_to"] > date("Y-m-d H:i:s")):?>
                <div class="notification_box">
                    <label>Az ??vk??zi z??rthelyi id??pontja: <?=$task_expectations_associative["middle_term_exam"]["due_to"]?>!</label>
                </div>
            <?php endif?>

            <?php $middle_term_plus_a_week = date("Y-m-d H:i:s", strtotime($task_expectations_associative["middle_term_exam"]["due_to"] . " +7 day"))?>
            <?php if( $middle_term_plus_a_week <= date("Y-m-d H:i:s")):?>
                <?php if($task_expectations_associative["middle_term_exam"]["minimum_for_pass"] <= $results["middle_term_exam"]):?>
                    <div class="notification_box">
                        <label>Az ??vk??zi z??rthelyit teljes??tette! Az el??rt sz??zal??ka: <?=100*round($results["middle_term_exam"]/max($task_expectations_associative["middle_term_exam"]["maximum_value"],1),2)?>%.</label>
                    </div>
                <?php elseif($task_expectations_associative["middle_term_exam_correction"]["due_to"] > date("Y-m-d H:i:s")):?>
                    <div class="notification_box">
                        <label>
                            ??nnek az ??vk??zi z??rthelyit jav??tania/ p??tolnia kell! Az el??rt pontja: <?=$results["middle_term_exam"]?>. 
                            A minimum pontsz??m: <?=$task_expectations_associative["middle_term_exam"]["minimum_for_pass"]?>.
                            A jav??t??/ p??tl?? dolgozat id??pontja: <?=$task_expectations_associative["middle_term_exam_correction"]["due_to"]?>.
                        </label>
                    </div>
                <?php endif?>
            <?php endif?>

            <?php $middle_term_correction_plus_a_week = date("Y-m-d H:i:s", strtotime($task_expectations_associative["middle_term_exam_correction"]["due_to"] . " +7 day"))?>
            <?php if( $middle_term_correction_plus_a_week <= date("Y-m-d H:i:s") && $task_expectations_associative["middle_term_exam_correction"]["minimum_for_pass"] <= $results["middle_term_exam_correction"]):?>
                <div class="notification_box">
                    <label>Az ??vk??zi jav??t??/ p??t z??rthelyit teljes??tette! Az el??rt sz??zal??ka: <?=100*round($results["middle_term_exam_correction"]/max($task_expectations_associative["middle_term_exam_correction"]["maximum_value"],1),2)?>%.</label>
                </div>
            <?php endif?>

            <?php if($task_expectations_associative["final_term_exam"]["due_to"] > date("Y-m-d H:i:s")):?>
                <div class="notification_box">
                    <label>Az ??vv??gi z??rthelyi id??pontja: <?=$task_expectations_associative["final_term_exam"]["due_to"]?>!</label>
                </div>
            <?php endif?>

            <?php $final_term_plus_a_week = date("Y-m-d H:i:s", strtotime($task_expectations_associative["final_term_exam"]["due_to"] . " +7 day"))?>
            <?php if($final_term_plus_a_week <= date("Y-m-d H:i:s")):?>
                <?php if($task_expectations_associative["final_term_exam"]["minimum_for_pass"] <= $results["final_term_exam"]):?>
                    <div class="notification_box">
                        <label>Az ??vv??gi z??rthelyit teljes??tette! Az el??rt sz??zal??ka: <?=100*round($results["final_term_exam"]/max($task_expectations_associative["final_term_exam"]["maximum_value"],1),2)?>%.</label>
                    </div>
                <?php elseif($task_expectations_associative["final_term_exam_correction"]["due_to"] > date("Y-m-d H:i:s")):?>
                    <div class="notification_box">
                        <label>
                            ??nnek az ??vv??gi z??rthelyit jav??tania/ p??tolnia kell! Az el??rt pontja: <?=$results["final_term_exam"]?>. 
                            A minimum pontsz??m: <?=$task_expectations_associative["final_term_exam"]["minimum_for_pass"]?>.
                            A jav??t??/ p??tl?? dolgozat id??pontja: <?=$task_expectations_associative["final_term_exam_correction"]["due_to"]?>.
                        </label>
                    </div>
                <?php endif?>
            <?php endif?>

            <?php $final_term_plus_a_week = date("Y-m-d H:i:s", strtotime($task_expectations_associative["final_term_exam_correction"]["due_to"] . " +7 day"))?>
            <?php if( $final_term_plus_a_week <= date("Y-m-d H:i:s") && $task_expectations_associative["final_term_exam_correction"]["minimum_for_pass"] <= $results["final_term_exam_correction"]):?>
                <div class="notification_box">
                    <label>Az ??vv??gi jav??t??/ p??t z??rthelyit teljes??tette! Az el??rt sz??zal??ka: <?=100*round($results["final_term_exam_correction"]/max($task_expectations_associative["final_term_exam_correction"]["maximum_value"],1),2)?>%.</label>
                </div>
            <?php endif?>


        </div>
    
        <div class="grades_div non_header_navigation_div" style="display:none" id="results_div">
            <label style="font-size: calc(15px + 0.3vw)">
                Eredm??nyeim
            </label>
            <hr>
            <div class="grades_tables_div">
                <table>
                    <tr class="header_row">
                        <th>FELADAT T??PUSA</th>
                        <th>EREDM??NY</th>
                    </tr>
                    <?php ksort($results, SORT_NATURAL )?>
                    <?php foreach($results as $task_type => $result):?>
                        <?php 
                            $task_type_name = "";
                            switch($task_type){
                                case "practice_count":$task_type_name="Jelenl??t";break;
                                case "extra":$task_type_name="Szorgalmi feladatok";break;
                                case "final_term_exam":$task_type_name="??vv??gi z??rthelyi";break;
                                case "middle_term_exam":$task_type_name="??vk??zi z??rthelyi";break;
                                case "final_term_exam_correction":$task_type_name="??vv??gi z??rthelyi jav??t??s/p??tl??s";break;
                                case "middle_term_exam_correction":$task_type_name="??vk??zi z??rthelyi jav??t??s/p??tl??s";break;
                                case "small_test_1":$task_type_name="1. kis z??rthelyi";break;
                                case "small_test_2":$task_type_name="2. kis z??rthelyi";break;
                                case "small_test_3":$task_type_name="3. kis z??rthelyi";break;
                                case "small_test_4":$task_type_name="4. kis z??rthelyi";break;
                                case "small_test_5":$task_type_name="5. kis z??rthelyi";break;
                                case "small_test_6":$task_type_name="6. kis z??rthelyi";break;
                                case "small_test_7":$task_type_name="7. kis z??rthelyi";break;
                                case "small_test_8":$task_type_name="8. kis z??rthelyi";break;
                                case "small_test_9":$task_type_name="9. kis z??rthelyi";break;
                                case "small_test_10":$task_type_name="10. kis z??rthelyi";break;
                                default: $task_type_name = "";break;
                            }
                        ?>
                        <?php if($task_type_name !== ""):?>
                            <tr>
                                <td>
                                    <?=$task_type_name?>
                                </td>
                                <td>
                                    <?=$result?>
                                </td>                            
                            </tr>
                        <?php endif?>
                    <?php endforeach?>
                </table>

                <table>
                    <tr class="header_row">
                        <th>FELADATSOR</th>
                        <th>PONTSZ??M</th>
                    </tr>
                    <?php ksort($practice_points, SORT_NATURAL)?>
                    <?php foreach($practice_points as $task_type => $result):?>
                        <?php 
                            $task_type_name = "";
                            switch($task_type){
                                case "practice_task_1":$task_type_name="1. gyakorl?? feladatsor";break;
                                case "practice_task_2":$task_type_name="2. gyakorl?? feladatsor";break;
                                case "practice_task_3":$task_type_name="3. gyakorl?? feladatsor";break;
                                case "practice_task_4":$task_type_name="4. gyakorl?? feladatsor";break;
                                case "practice_task_5":$task_type_name="5. gyakorl?? feladatsor";break;
                                case "practice_task_6":$task_type_name="6. gyakorl?? feladatsor";break;
                                case "practice_task_7":$task_type_name="7. gyakorl?? feladatsor";break;
                                case "practice_task_8":$task_type_name="8. gyakorl?? feladatsor";break;
                                case "practice_task_9":$task_type_name="9. gyakorl?? feladatsor";break;
                                default: $task_type_name = "";break;
                            }
                        ?>
                        <?php if($task_type_name !== ""):?>
                            <tr>
                                <td>
                                    <?=$task_type_name?>
                                </td>
                                <td>
                                    <?=$result?>
                                </td>                            
                            </tr>
                        <?php endif?>
                    <?php endforeach?>
                </table>
            </div>
        </div>
    </main>
    <script type="module" src="./views/js/mainContent.js"></script>
    <script type="module" src="./views/js/nonHeaderNavigation.js"></script>
</body>
</html>