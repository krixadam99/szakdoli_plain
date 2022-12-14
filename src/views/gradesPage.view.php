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
    <title>Eredményeim</title>
</head>
<body>
    <?php include("./partials/header.php")?>
    <main>
        <div id="non_header_navigation_row" style="margin: 2% 4% 2% 4%;">
            <div class="non_header_navigation_row_button chosen" id="progress_button">
                <label>Előrehaladás</label>
            </div>
            <div class="non_header_navigation_row_button" id="results_button">
                <label>Eredmények</label>
            </div>
        </div>

        <div class="grades_div non_header_navigation_div" id="progress_div">
            <label style="font-size: calc(15px + 0.3vw)">
                Előrehaladás
            </label>
            <hr>

            <?php if(intval($results["practice_count"]) < $task_expectations_associative["practice_count"]["minimum_for_pass"]):?>
                <div class="notification_box">
                    <label>Még <?=$task_expectations_associative["practice_count"]["minimum_for_pass"] - intval($results["practice_count"])?> gyakorlaton kell megjelennie, hogy a jelenlétre vontakozó követelményt teljesítse!</label>
                </div>
            <?php else:?>
                <div class="notification_box">
                    <label>A jelenlétre vonatkozó követelményt teljesítette!</label>
                </div>
            <?php endif?>

            <?php if($small_tests_sum < $task_expectations_associative["small_tests"]["minimum_for_pass"]):?>
                <div class="notification_box">
                    <label>
                        Még <?=$task_expectations_associative["small_tests"]["minimum_for_pass"] - $small_tests_sum?> pontot kell elérnie a kis zárthelyiken, hogy a rájuk vonatkozó követelményt teljesítse!
                        <?php if($next_date !== ""):?>
                            A <?=$next_small_test_counter?>. kis zárthelyi időpontja: <?=$next_date?>.
                        <?php endif?>
                    </label>
                </div>
            <?php else:?>
                <div class="notification_box">
                    <label>A kis zárthelyire vonatkozó követelményt teljesítette!</label>
                </div>
            <?php endif?>

            

            <?php if($task_expectations_associative["middle_term_exam"]["due_to"] > date("Y-m-d H:i:s")):?>
                <div class="notification_box">
                    <label>Az évközi zárthelyi időpontja: <?=$task_expectations_associative["middle_term_exam"]["due_to"]?>!</label>
                </div>
            <?php endif?>

            <?php $middle_term_plus_a_week = date("Y-m-d H:i:s", strtotime($task_expectations_associative["middle_term_exam"]["due_to"] . " +7 day"))?>
            <?php if( $middle_term_plus_a_week <= date("Y-m-d H:i:s")):?>
                <?php if($task_expectations_associative["middle_term_exam"]["minimum_for_pass"] <= $results["middle_term_exam"]):?>
                    <div class="notification_box">
                        <label>Az évközi zárthelyit teljesítette! Az elért százaléka: <?=100*round($results["middle_term_exam"]/max($task_expectations_associative["middle_term_exam"]["maximum_value"],1),2)?>%.</label>
                    </div>
                <?php elseif($task_expectations_associative["middle_term_exam_correction"]["due_to"] > date("Y-m-d H:i:s")):?>
                    <div class="notification_box">
                        <label>
                            Önnek az évközi zárthelyit javítania/ pótolnia kell! Az elért pontja: <?=$results["middle_term_exam"]?>. 
                            A minimum pontszám: <?=$task_expectations_associative["middle_term_exam"]["minimum_for_pass"]?>.
                            A javító/ pótló dolgozat időpontja: <?=$task_expectations_associative["middle_term_exam_correction"]["due_to"]?>.
                        </label>
                    </div>
                <?php endif?>
            <?php endif?>

            <?php $middle_term_correction_plus_a_week = date("Y-m-d H:i:s", strtotime($task_expectations_associative["middle_term_exam_correction"]["due_to"] . " +7 day"))?>
            <?php if( $middle_term_correction_plus_a_week <= date("Y-m-d H:i:s") && $task_expectations_associative["middle_term_exam_correction"]["minimum_for_pass"] <= $results["middle_term_exam_correction"]):?>
                <div class="notification_box">
                    <label>Az évközi javító/ pót zárthelyit teljesítette! Az elért százaléka: <?=100*round($results["middle_term_exam_correction"]/max($task_expectations_associative["middle_term_exam_correction"]["maximum_value"],1),2)?>%.</label>
                </div>
            <?php endif?>

            <?php if($task_expectations_associative["final_term_exam"]["due_to"] > date("Y-m-d H:i:s")):?>
                <div class="notification_box">
                    <label>Az évvégi zárthelyi időpontja: <?=$task_expectations_associative["final_term_exam"]["due_to"]?>!</label>
                </div>
            <?php endif?>

            <?php $final_term_plus_a_week = date("Y-m-d H:i:s", strtotime($task_expectations_associative["final_term_exam"]["due_to"] . " +7 day"))?>
            <?php if($final_term_plus_a_week <= date("Y-m-d H:i:s")):?>
                <?php if($task_expectations_associative["final_term_exam"]["minimum_for_pass"] <= $results["final_term_exam"]):?>
                    <div class="notification_box">
                        <label>Az évvégi zárthelyit teljesítette! Az elért százaléka: <?=100*round($results["final_term_exam"]/max($task_expectations_associative["final_term_exam"]["maximum_value"],1),2)?>%.</label>
                    </div>
                <?php elseif($task_expectations_associative["final_term_exam_correction"]["due_to"] > date("Y-m-d H:i:s")):?>
                    <div class="notification_box">
                        <label>
                            Önnek az évvégi zárthelyit javítania/ pótolnia kell! Az elért pontja: <?=$results["final_term_exam"]?>. 
                            A minimum pontszám: <?=$task_expectations_associative["final_term_exam"]["minimum_for_pass"]?>.
                            A javító/ pótló dolgozat időpontja: <?=$task_expectations_associative["final_term_exam_correction"]["due_to"]?>.
                        </label>
                    </div>
                <?php endif?>
            <?php endif?>

            <?php $final_term_plus_a_week = date("Y-m-d H:i:s", strtotime($task_expectations_associative["final_term_exam_correction"]["due_to"] . " +7 day"))?>
            <?php if( $final_term_plus_a_week <= date("Y-m-d H:i:s") && $task_expectations_associative["final_term_exam_correction"]["minimum_for_pass"] <= $results["final_term_exam_correction"]):?>
                <div class="notification_box">
                    <label>Az évvégi javító/ pót zárthelyit teljesítette! Az elért százaléka: <?=100*round($results["final_term_exam_correction"]/max($task_expectations_associative["final_term_exam_correction"]["maximum_value"],1),2)?>%.</label>
                </div>
            <?php endif?>


        </div>
    
        <div class="grades_div non_header_navigation_div" style="display:none" id="results_div">
            <label style="font-size: calc(15px + 0.3vw)">
                Eredményeim
            </label>
            <hr>
            <div class="grades_tables_div">
                <table>
                    <tr class="header_row">
                        <th>FELADAT TÍPUSA</th>
                        <th>EREDMÉNY</th>
                    </tr>
                    <?php ksort($results, SORT_NATURAL )?>
                    <?php foreach($results as $task_type => $result):?>
                        <?php 
                            $task_type_name = "";
                            switch($task_type){
                                case "practice_count":$task_type_name="Jelenlét";break;
                                case "extra":$task_type_name="Szorgalmi feladatok";break;
                                case "final_term_exam":$task_type_name="Évvégi zárthelyi";break;
                                case "middle_term_exam":$task_type_name="Évközi zárthelyi";break;
                                case "final_term_exam_correction":$task_type_name="Évvégi zárthelyi javítás/pótlás";break;
                                case "middle_term_exam_correction":$task_type_name="Évközi zárthelyi javítás/pótlás";break;
                                case "small_test_1":$task_type_name="1. kis zárthelyi";break;
                                case "small_test_2":$task_type_name="2. kis zárthelyi";break;
                                case "small_test_3":$task_type_name="3. kis zárthelyi";break;
                                case "small_test_4":$task_type_name="4. kis zárthelyi";break;
                                case "small_test_5":$task_type_name="5. kis zárthelyi";break;
                                case "small_test_6":$task_type_name="6. kis zárthelyi";break;
                                case "small_test_7":$task_type_name="7. kis zárthelyi";break;
                                case "small_test_8":$task_type_name="8. kis zárthelyi";break;
                                case "small_test_9":$task_type_name="9. kis zárthelyi";break;
                                case "small_test_10":$task_type_name="10. kis zárthelyi";break;
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
                        <th>PONTSZÁM</th>
                    </tr>
                    <?php ksort($practice_points, SORT_NATURAL)?>
                    <?php foreach($practice_points as $task_type => $result):?>
                        <?php 
                            $task_type_name = "";
                            switch($task_type){
                                case "practice_task_1":$task_type_name="1. gyakorló feladatsor";break;
                                case "practice_task_2":$task_type_name="2. gyakorló feladatsor";break;
                                case "practice_task_3":$task_type_name="3. gyakorló feladatsor";break;
                                case "practice_task_4":$task_type_name="4. gyakorló feladatsor";break;
                                case "practice_task_5":$task_type_name="5. gyakorló feladatsor";break;
                                case "practice_task_6":$task_type_name="6. gyakorló feladatsor";break;
                                case "practice_task_7":$task_type_name="7. gyakorló feladatsor";break;
                                case "practice_task_8":$task_type_name="8. gyakorló feladatsor";break;
                                case "practice_task_9":$task_type_name="9. gyakorló feladatsor";break;
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