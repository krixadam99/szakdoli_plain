<?php
    $form_token = $this->GetFormToken();
    $approved_teacher_groups = $this->GetApprovedTeacherGroups();
    $approved_teacher_groups_per_subject = [];
    if(!isset($_SESSION["subject"]) && !isset($_SESSION["group"])){
        header("Location: ./index.php");
    }

    $expectation_rules_with_key = [];
    foreach($expectation_rules as $task_type_counter => $expectation_rule){
        $expectation_rules_with_key[$expectation_rule["task_type"]] = $expectation_rule;
    }

    $points = [];
    foreach($students_grades as $neptun_code => $student){
        $small_test_point = 0;
        foreach($student as $key => $value){
          if(is_numeric(strpos($key, "small_test"))){
            $small_test_point += $value;
          }
        }
        $middle_term_exam_point = max($student["middle_term_exam"],$student["middle_term_exam_correction"]);
        $final_term_exam_point = max($student["final_term_exam"],$student["final_term_exam_correction"]);

        $points[$neptun_code] = [];
        $points[$neptun_code]["small_test"] =  $small_test_point;
        $points[$neptun_code]["middle_term_exam"] =  $middle_term_exam_point;
        $points[$neptun_code]["final_term_exam"] = $final_term_exam_point;
        $points[$neptun_code]["sum"] = $student["extra"] + $middle_term_exam_point + $final_term_exam_point;
    }

    $actual_page = "student_grades";


    
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
    <link href="./views/css/studentGrades.css" rel="stylesheet" type="text/css">
    <title>Diákok eredményeinek kezelése</title>
</head>
<body>
    <?php include("./partials/header.php")?>

    <main>
        <?php include("./partials/groupSelection.php")?>
    
        <div id="non_header_navigation_row">
            <div class="non_header_navigation_row_button chosen" id="update_grades_button">
                <label>Eredmények frissítése</label>
            </div>
            <div class="non_header_navigation_row_button" id="update_expectation_rules_button">
                <label>Követelmények módosítása</label>
            </div>
            <div class="non_header_navigation_row_button" id="update_task_due_dates_button">
                <label>Feladatok időpontjainak módosítása</label>
            </div>
            <div class="non_header_navigation_row_button" id="update_grade_points_button">
                <label>Jegyek alsó ponthatárainak módosítása</label>
            </div>
        </div>

        <div class="non_header_navigation_div">
            <?php if(count($students_grades) != 0):?>
                <form id="grades_form" class="student_grades_form" action="./index.php?site=upgradeStudentGrades" method="POST">
                    <input type="hidden" name="token" value="<?=$form_token?>">

                    <label style="font-size: calc(15px + 0.3vw)">
                        <?=$_SESSION["subject"] === "i"?"Diszkrét matematika I.":"Diszkrét matematika II."?> - <?=$_SESSION["group"]?>. csoport eredményeinek kezelése
                    </label>
                    <hr>    
                
                    <div style="overflow-x:auto; margin-top:2%">
                        <table>
                            <tr class="header_row">
                                <th style="position: sticky;left: 0;background: rgba(255, 255, 255, 0.751);z-index: 1;backdrop-filter: blur(3px)">NEPTUN</th>
                                <th>TÁRGY</th>
                                <th>CSOPORT</th>
                                <th>ÉRDEMJEGY</th>
                                <th>JELENLÉT</th>
                                <th>EXTRA</th>
                                <th>ÉVKÖZI ZH</th>
                                <th>ÉVKÖZI JAVÍTÓ ZH</th>
                                <th>ÉVVÉGI ZH</th>
                                <th>ÉVVÉGI JAVÍTÓ ZH</th>
                                <th>1. KIS ZH</th>
                                <th>2. KIS ZH</th>
                                <th>3. KIS ZH</th>
                                <th>4. KIS ZH</th>
                                <th>5. KIS ZH</th>
                                <th>6. KIS ZH</th>
                                <th>7. KIS ZH</th>
                                <th>8. KIS ZH</th>
                                <th>9. KIS ZH</th>
                                <th>10. KIS ZH</th>
                            </tr>
                            <?php foreach($students_grades as $neptun_code => $student):?>
                                <tr id=<?=$student["group_number"]?> class="student_row">
                                    <td style="position: sticky;left: 0;background: rgba(255, 255, 255, 0.751);z-index: 1;backdrop-filter: blur(3px)">
                                        <?=$neptun_code?>
                                    </td>
                                    <td style="border-left:1px dashed black">
                                        <?=$student["subject_id"]=="i"?"Diszkrét matematika I.":"Diszkrét matematika II."?>
                                    </td>
                                    <td style="border-left:1px dashed black">
                                        <?=$student["group_number"]?>
                                    </td>
                                    <td style="border-left:1px dashed black">
                                        <?php if($student["practice_count"] < $expectation_rules["practice_count"]["minimum_for_pass"]):?>
                                            Nem kaphat érdemjegyet
                                        <?php else:?>
                                            <?php if(
                                                    $points[$neptun_code]["small_test"] < $expectation_rules["small_tests"]["minimum_for_pass"]
                                                ||  $points[$neptun_code]["middle_term_exam"] < $expectation_rules["middle_term_exam"]["minimum_for_pass"]
                                                ||  $points[$neptun_code]["final_term_exam"] < $expectation_rules["final_term_exam"]["minimum_for_pass"]
                                            ):?>
                                                1
                                            <?php else:?>
                                                <?php if($points[$neptun_code]["sum"] < $grade_levels["excellent_level_point"]):?>
                                                    <?php if($points[$neptun_code]["sum"] < $grade_levels["good_level_point"]):?>
                                                        <?php if($points[$neptun_code]["sum"] < $grade_levels["satisfactory_level_point"]):?>
                                                            <?php if($points[$neptun_code]["sum"] < $grade_levels["pass_level_point"]):?>
                                                                1
                                                            <?php else:?>
                                                                2
                                                            <?php endif?>
                                                        <?php else:?>
                                                            3
                                                        <?php endif?>
                                                    <?php else:?>
                                                        4
                                                    <?php endif?>
                                                <?php else:?>
                                                    5
                                                <?php endif?>
                                            <?php endif?>
                                        <?php endif?>
                                    </td>

                                    <td style="padding:0%">
                                        <input type="number" min="0" step="1" class="student_grade_input" name="<?=$neptun_code?>_practice_count" value="<?=$student["practice_count"]?>">
                                        </input>
                                    </td>
                                    <td style="padding:0%">
                                        <input type="number" min="0" step="1" class="student_grade_input" name="<?=$neptun_code?>_extra" value="<?=$student["extra"]?>">
                                        </input>
                                    </td>
                                    <td style="padding:0%">
                                        <input type="number" min="0" step="1" class="student_grade_input" name="<?=$neptun_code?>_middle_term_exam" value="<?=$student["middle_term_exam"]?>">
                                        </input>
                                    </td>
                                    <td style="padding:0%">
                                        <input type="number" min="0" step="1" class="student_grade_input" name="<?=$neptun_code?>_middle_term_exam_correction" value="<?=$student["middle_term_exam_correction"]?>">
                                        </input>
                                    </td>
                                    <td style="padding:0%">
                                        <input type="number" min="0" step="1" class="student_grade_input" name="<?=$neptun_code?>_final_term_exam" value="<?=$student["final_term_exam"]?>">
                                        </input>
                                    </td>
                                    <td style="padding:0%">
                                        <input type="number" min="0" step="1" class="student_grade_input" name="<?=$neptun_code?>_final_term_exam_correction" value="<?=$student["final_term_exam_correction"]?>">
                                        </input>
                                    </td>
                                    <td style="padding:0%">
                                        <input type="number" min="0" max="2" step="1" class="student_grade_input" name="<?=$neptun_code?>_small_test_1" value="<?=$student["small_test_1"]?>">
                                        </input>
                                    </td>
                                    <td style="padding:0%">
                                        <input type="number" min="0" max="2" step="1" class="student_grade_input" name="<?=$neptun_code?>_small_test_2" value="<?=$student["small_test_2"]?>">
                                        </input>
                                    </td>
                                    <td style="padding:0%">
                                        <input type="number" min="0" max="2" step="1" class="student_grade_input" name="<?=$neptun_code?>_small_test_3" value="<?=$student["small_test_3"]?>">
                                        </input>
                                    </td>
                                    <td style="padding:0%">
                                        <input type="number" min="0" max="2" step="1" class="student_grade_input" name="<?=$neptun_code?>_small_test_4" value="<?=$student["small_test_4"]?>">
                                        </input>
                                    </td>
                                    <td style="padding:0%">
                                        <input type="number" min="0" max="2" step="1" class="student_grade_input" name="<?=$neptun_code?>_small_test_5" value="<?=$student["small_test_5"]?>">
                                        </input>
                                    </td>
                                    <td style="padding:0%">
                                        <input type="number" min="0" max="2" step="1" class="student_grade_input" name="<?=$neptun_code?>_small_test_6" value="<?=$student["small_test_6"]?>">
                                        </input>
                                    </td>
                                    <td style="padding:0%">
                                        <input type="number" min="0" max="2" step="1" class="student_grade_input" name="<?=$neptun_code?>_small_test_7" value="<?=$student["small_test_7"]?>">
                                        </input>
                                    </td>
                                    <td style="padding:0%">
                                        <input type="number" min="0" max="2" step="1" class="student_grade_input" name="<?=$neptun_code?>_small_test_8" value="<?=$student["small_test_8"]?>">
                                        </input>
                                    </td>
                                    <td style="padding:0%">
                                        <input type="number" min="0" max="2" step="1" class="student_grade_input" name="<?=$neptun_code?>_small_test_9" value="<?=$student["small_test_9"]?>">
                                        </input>
                                    </td>
                                    <td style="padding:0%">
                                        <input type="number" min="0" max="2" step="1" class="student_grade_input" name="<?=$neptun_code?>_small_test_10" value="<?=$student["small_test_10"]?>">
                                        </input>
                                    </td>                            
                                </tr>
                            <?php endforeach?>
                        </table>
                    </div>
                    <button type="submit" class="finalize_button">Frissítés</button>
                </form>
            <?php else:?>
                <div class="notification_box">
                    <label>Nincsen elfogadott diák a <?=$_SESSION['subject']=="i"?"Diszkrét matematika I.":"Diszkrét matematika II."?> tárgy <?=$_SESSION['group']?> csoportjában!</label>
                </div>
            <?php endif?>
        </div>

        <div class="non_header_navigation_div"  style="display:none">
            <!-- Task expectation form -->
            <form id="expectation_rules_form" class="student_grades_form" action="./index.php?site=upgradeExpectationRules" method="POST">
                <input type="hidden" name="token" value="<?=$form_token?>"> 
            
                <label style="font-size: calc(15px + 0.3vw)">
                <?=$_SESSION["subject"] === "i"?"Diszkrét matematika I.":"Diszkrét matematika II."?> - <?=$_SESSION["group"]?>. csoport követelmények módosítása
                </label>
                <hr>    
            
                <div style="overflow-x:auto; margin-top:2%">
                    <table>
                        <tr class="header_row">
                            <th>KÖVETELMÉNY TÍPUSA</th>
                            <th>SZÜKSÉGES MINIMUM PONTSZÁM</th>
                            <th>MAXIMUM PONTSZÁM</th>
                        </tr>
                        <?php foreach($expectation_rules as $expectation_type => $expectation_rule):?>
                            <?php 
                                $id = $expectation_rule["task_type"];
                                switch($expectation_rule["task_type"]){
                                    case "extra":$task_type_name="Szorgalmi feladatok";break;
                                    case "final_term_exam":$task_type_name="Évvégi zárthelyi";break;
                                    case "middle_term_exam":$task_type_name="Évközi zárthelyi";break;
                                    case "final_term_exam_correction":$task_type_name="Évvégi zárthelyi javítás/pótlás";break;
                                    case "middle_term_exam_correction":$task_type_name="Évközi zárthelyi javítás/pótlás";break;
                                    case "practice_count":$task_type_name="Gyakorlati részvétel";break;
                                    case "small_tests":$task_type_name="Kis zárthelyik";break;
                                }
                            ?>
                            <?php if(!in_array($expectation_rule["task_type"],["final_term_exam_correction", "middle_term_exam_correction"])):?>
                                <tr id=<?=$id?> class="expectation_table_row">
                                    <td>
                                        <?php if($expectation_rule["task_type"] === "final_term_exam"):?>
                                            <?=$task_type_name?><br>
                                            Évvégi zárthelyi javítás/pótlás
                                        <?php elseif($expectation_rule["task_type"] === "middle_term_exam"):?>
                                            <?=$task_type_name?><br>
                                            Évközi zárthelyi javítás/pótlás
                                        <?php elseif(!in_array($expectation_rule["task_type"],["final_term_exam", "middle_term_exam", "final_term_exam_correction", "middle_term_exam_correction"])):?>
                                            <?=$task_type_name?>
                                        <?php endif?>
                                    </td>
                                    <td style="padding:0%">
                                        <input type="number" min="0" class="student_expectation_rules_input" name="<?=$id . "_minimum_for_pass"?>" value="<?=$expectation_rule["minimum_for_pass"]?>">
                                        </input>
                                    </td>
                                    <td style="padding:0%">
                                        <input type="number" min="0" class="student_expectation_rules_input" name="<?=$id . "_maximum_value"?>" value="<?=$expectation_rule["maximum_value"]?>">
                                        </input>
                                    </td> 
                                </tr>
                            <?php endif?>    
                        <?php endforeach?>
                    </table>
                </div>
                <button type="submit" class="finalize_button">Frissítés</button>
            </form>
        </div>
            
        <div class="non_header_navigation_div"  style="display:none">
            <!-- Task due date form -->
            <form id="task_due_date_form" class="student_grades_form" action="./index.php?site=upgradeTaskDueDates" method="POST">
                <input type="hidden" name="token" value="<?=$form_token?>">
            
                <label style="font-size: calc(15px + 0.3vw)">
                    <?=$_SESSION["subject"] === "i"?"Diszkrét matematika I.":"Diszkrét matematika II."?> - <?=$_SESSION["group"]?>. csoport feladatok időpontjainak módosítása
                </label>
                <hr>    
            
                <div style="overflow-x:auto; margin-top:2%">
                    <table>
                        <tr class="header_row">
                            <th>FELADAT TÍPUSA</th>
                            <th>ESEDÉKESSÉG</th>
                        </tr>
                        <?php ksort($task_due_dates, SORT_NATURAL )?>
                        <?php foreach($task_due_dates as $task_type => $task_due_date):?>
                            <?php 
                                $id = $task_due_date["task_type"];
                                switch($task_due_date["task_type"]){
                                    case "final_term_exam":$task_type_name="Évvégi zárthelyi";break;
                                    case "middle_term_exam":$task_type_name="Évközi zárthelyi";break;
                                    case "final_term_exam_correction":$task_type_name="Évvégi zárthelyi javítás/pótlás";break;
                                    case "middle_term_exam_correction":$task_type_name="Évközi zárthelyi javítás/pótlás";break;
                                    case "practice_task_1":$task_type_name="1. gyakorló feladatsor";break;
                                    case "practice_task_2":$task_type_name="2. gyakorló feladatsor";break;
                                    case "practice_task_3":$task_type_name="3. gyakorló feladatsor";break;
                                    case "practice_task_4":$task_type_name="4. gyakorló feladatsor";break;
                                    case "practice_task_5":$task_type_name="5. gyakorló feladatsor";break;
                                    case "practice_task_6":$task_type_name="6. gyakorló feladatsor";break;
                                    case "practice_task_7":$task_type_name="7. gyakorló feladatsor";break;
                                    case "practice_task_8":$task_type_name="8. gyakorló feladatsor";break;
                                    case "practice_task_9":$task_type_name="9. gyakorló feladatsor";break;
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
                                }
                            ?>
                            <tr id=<?=$id?> class="due_date_row">
                                <td>
                                    <?=$task_type_name?>
                                </td>
                                <td style="padding:0%">
                                    <input type="datetime-local" min="2022" max="2023" step="1" class="student_task_due_date_input" name="<?=$id . "_due_to"?>" value="<?=$task_due_date["due_to"]?>">
                                    </input>
                                </td>                            
                            </tr>
                        <?php endforeach?>
                    </table>
                </div>
                <button type="submit" class="finalize_button">Frissítés</button>
            </form>
        </div>

        <div class="non_header_navigation_div"  style="display:none">
            <!-- Grade levels form -->
            <form id="grade_levels_form" class="student_grades_form" action="./index.php?site=upgradeGradeLevels" method="POST">
                <input type="hidden" name="token" value="<?=$form_token?>">
            
                <label style="font-size: calc(15px + 0.3vw)">
                <?=$_SESSION["subject"] === "i"?"Diszkrét matematika I.":"Diszkrét matematika II."?> - <?=$_SESSION["group"]?>. csoport jegyek alsó ponthatárainak módosítása
                </label>
                <hr>    
            
                <div style="overflow-x:auto; margin-top:2%">
                    <table>
                        <?php $id = $grade_levels["subject_id"] . "_" . $grade_levels["group_number"]?>
                        <tr class="header_row">
                            <th>MINŐSÍTÉS</th>
                            <th>ALSÓ PONTHATÁR</th>
                        </tr>
                        <tr class=<?=$id?> class="grade_point_row">
                            <td>
                                Elégséges (2)
                            </td>
                            <td style="padding:0%">
                                <input type="number" class="grade_level_input" min="0" step="1" name="pass_level_point" value="<?=$grade_levels["pass_level_point"]?>">
                                </input>
                            </td>  
                        </tr>
                            
                        <tr class=<?=$id?> class="grade_point_row">
                            <td>
                                Közepes (3)
                            </td>
                            <td style="padding:0%">
                                <input type="number" class="grade_level_input" min="0" step="1" name="satisfactory_level_point" value="<?=$grade_levels["satisfactory_level_point"]?>">
                                </input>
                            </td> 
                        </tr> 

                        <tr class=<?=$id?> class="grade_point_row">
                            <td>
                                Jó (4)
                            </td>
                            <td style="padding:0%">
                                <input type="number" class="grade_level_input" min="0" step="1" name="good_level_point" value="<?=$grade_levels["good_level_point"]?>">
                                </input>
                            </td>  
                        </tr>
                        
                        <tr class=<?=$id?> class="grade_point_row">
                            <td>
                                Jeles (5)
                            </td>
                            <td style="padding:0%">
                                <input type="number" class="grade_level_input" min="0" step="1" name="excellent_level_point" value="<?=$grade_levels["excellent_level_point"]?>">
                                </input>
                            </td>  
                        </tr>
                    </table>
                </div>
                <button type="submit" class="finalize_button">Frissítés</button>
            </form>
        </div>
    </main>
    <script type="module" src="./views/js/mainContent.js"></script>
    <script type="module" src="./views/js/selectGroup.js"></script>
    <script type="module" src="./views/js/nonHeaderNavigation.js"></script>
</body>
</html>