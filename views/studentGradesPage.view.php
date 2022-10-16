<?php
    $approved_teacher_groups = $this->GetApprovedTeacherGroups();
    $approved_teacher_groups_per_subject = [];
    if(!isset($_SESSION["subject"]) && !isset($_SESSION["group"])){
        header("Location: ./index.php");
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
    <title>Diákok eredményei</title>
</head>
<body>
    <?php include("./partials/header.php")?>
    <main>
        <?php include("./partials/groupSelection.php")?>
        
        <?php if(count($students_grades) != 0):?>
            <form id="student_grades_form" action="./index.php?site=studentGrades" method="POST">
                <label style="font-size: calc(15px + 0.3vw)">
                <?=$_SESSION["subject"] === "i"?"Diszkrét matematika I.":"Diszkrét matematika II."?> - <?=$_SESSION["group"]?>. csoport eredményeinek kezelése
                </label>
                <hr>    
            
                <div style="overflow-x:auto; margin-top:2%">
                    <table>
                        <tr id="header_row">
                            <th style="position: sticky;left: 0;background: rgba(255, 255, 255, 0.751);z-index: 1;backdrop-filter: blur(3px)">NEPTUN</th>
                            <th>TÁRGY</th>
                            <th>CSOPORT</th>
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
                        <?php foreach($students_grades as $index => $student):?>
                            <tr id=<?=$student["subject_group"]?> class="student_row">
                                <td style="position: sticky;left: 0;background: rgba(255, 255, 255, 0.751);z-index: 1;backdrop-filter: blur(3px)"><?=$student["neptun_code"]?></td>
                                <td style="border-left:1px dashed black"><?=$student["subject_name"]=="i"?"Diszkrét matematika I.":"Diszkrét matematika II."?></td>
                                <td style="border-left:1px dashed black"><?=$student["subject_group"]?></td>
                                <td style="padding:0%"><input type="number" min="0" max="14" step="1" class="student_grade_input" name="<?=$student["neptun_code"]?>_grade_input_practice" value="<?=$student["practice_count"]?>"></input></td>
                                <td style="padding:0%"><input type="number" min="0" max="10" step="1" class="student_grade_input" name="<?=$student["neptun_code"]?>_grade_input_extra" value="<?=$student["extra"]?>"></input></td>
                                <td style="padding:0%"><input type="number" min="0" step="1" class="student_grade_input" name="<?=$student["neptun_code"]?>_grade_input_middle_term" value="<?=$student["middle_term_exam"]?>"></input></td>
                                <td style="padding:0%"><input type="number" min="0" step="1" class="student_grade_input" name="<?=$student["neptun_code"]?>_grade_input_middle_term_corr" value="<?=$student["middle_term_exam_correction"]?>"></input></td>
                                <td style="padding:0%"><input type="number" min="0" step="1" class="student_grade_input" name="<?=$student["neptun_code"]?>_grade_input_final_term" value="<?=$student["final_term_exam"]?>"></input></td>
                                <td style="padding:0%"><input type="number" min="0" step="1" class="student_grade_input" name="<?=$student["neptun_code"]?>_grade_input_final_term_corr" value="<?=$student["final_term_exam_correction"]?>"></input></td>
                                <td style="padding:0%"><input type="number" min="0" max="2" step="1" class="student_grade_input" name="<?=$student["neptun_code"]?>_grade_input_small_test_1" value="<?=$student["small_test_1"]?>"></input></td>
                                <td style="padding:0%"><input type="number" min="0" max="2" step="1" class="student_grade_input" name="<?=$student["neptun_code"]?>_grade_input_small_test_2" value="<?=$student["small_test_2"]?>"></input></td>
                                <td style="padding:0%"><input type="number" min="0" max="2" step="1" class="student_grade_input" name="<?=$student["neptun_code"]?>_grade_input_small_test_3" value="<?=$student["small_test_3"]?>"></input></td>
                                <td style="padding:0%"><input type="number" min="0" max="2" step="1" class="student_grade_input" name="<?=$student["neptun_code"]?>_grade_input_small_test_4" value="<?=$student["small_test_4"]?>"></input></td>
                                <td style="padding:0%"><input type="number" min="0" max="2" step="1" class="student_grade_input" name="<?=$student["neptun_code"]?>_grade_input_small_test_5" value="<?=$student["small_test_5"]?>"></input></td>
                                <td style="padding:0%"><input type="number" min="0" max="2" step="1" class="student_grade_input" name="<?=$student["neptun_code"]?>_grade_input_small_test_6" value="<?=$student["small_test_6"]?>"></input></td>
                                <td style="padding:0%"><input type="number" min="0" max="2" step="1" class="student_grade_input" name="<?=$student["neptun_code"]?>_grade_input_small_test_7" value="<?=$student["small_test_7"]?>"></input></td>
                                <td style="padding:0%"><input type="number" min="0" max="2" step="1" class="student_grade_input" name="<?=$student["neptun_code"]?>_grade_input_small_test_8" value="<?=$student["small_test_8"]?>"></input></td>
                                <td style="padding:0%"><input type="number" min="0" max="2" step="1" class="student_grade_input" name="<?=$student["neptun_code"]?>_grade_input_small_test_9" value="<?=$student["small_test_9"]?>"></input></td>
                                <td style="padding:0%"><input type="number" min="0" max="2" step="1" class="student_grade_input" name="<?=$student["neptun_code"]?>_grade_input_small_test_10" value="<?=$student["small_test_10"]?>"></input></td>                            
                            </tr>
                        <?php endforeach?>
                    </table>
                </div>
                <button type="submit" id="finalize_button">RÖGZÍTÉS</button>
            </form>
        <?php else:?>
            <div id="notification_box">
                <label>Nincsen elfogadott diák a <?=$_SESSION['subject']=="i"?"Diszkrét matematika I.":"Diszkrét matematika II."?> tárgy <?=$_SESSION['group']?> csoportjában!</label>
            </div>
        <?php endif?>

        <!-- Követelmény tábla -->
    </main>
    <script type="module" src="./views/js/mainContent.js"></script>
    <script type="module" src="./views/js/selectGroup.js"></script>
</body>
</html>