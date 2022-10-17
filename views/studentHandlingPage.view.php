<?php
    $all_students = $this->GetStudents();
    
    $approved_teacher_groups = $this->GetApprovedTeacherGroups();
    $approved_teacher_groups_per_subject = [];
    if(!isset($_SESSION["subject"]) && !isset($_SESSION["group"])){
        header("Location: ./index.php");
    }

    $students = [];
    foreach($all_students as $index => $students_per_subjects_per_group){
        if($students_per_subjects_per_group["subject_name"] === $_SESSION["subject"] && $students_per_subjects_per_group["subject_group"] === $_SESSION["group"]){
            $students = $students_per_subjects_per_group["users"];
            break;
        }
    }

    $actual_page = "student_handling";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./views/css/header.css" rel="stylesheet" type="text/css">
    <link href="./views/css/body.css" rel="stylesheet" type="text/css">
    <title>Diákok kezelése</title>
</head>
<body>
    <?php include("./partials/header.php")?>
    <main>
        <?php include("./partials/groupSelection.php")?>
        <?php if(count($students) != 0):?>
            <form id="student_handling_form" action="./index.php?site=studentHandling" method="POST">
                <table>
                    <tr id="header_row">
                        <th>NEPTUN</th>
                        <th>TÁRGY</th>
                        <th>CSOPORT</th>
                        <th>DÖNTÉS</th>
                    </tr>
                    <?php foreach($students as $index => $student):?>
                        <?php if($student["application_request_status"] !== "WITHDRAWN"):?>
                            <tr id=<?=$student["subject_group"]?> class="student_row">
                                <td><?=$student["neptun_code"]?></td>
                                <td><?=$student["subject_name"]=="i"?"Diszkrét matematika I.":"Diszkrét matematika II."?></td>
                                <td><?=$student["subject_group"]?></td>
                                <td>
                                    <select id="student_handling_select" name=<?=$student["neptun_code"]?>>
                                        <?php if($student["application_request_status"] === "PENDING"):?>
                                            <option selected>-</option>
                                            <option >ELFOGADÁS</option>
                                            <option>ELUTASÍTÁS</option>
                                        <?php elseif($student["application_request_status"] === "APPROVED"):?>
                                            <option selected>-</option>
                                            <option>TÖRLÉS</option>
                                        <?php elseif($student["application_request_status"] === "DENIED"):?>
                                            <option selected>-</option>
                                            <option>VISSZAVÉTEL</option>
                                        <?php endif?>
                                    </select>
                                </td>
                            </tr>
                        <?php endif?>
                    <?php endforeach?>
                </table>
                <button type="submit" class="finalize_button">VÉGLEGESÍTÉS</button>
            </form>
        <?php else:?>
            <div id="notification_box">
                <label>Nincsen diák a <?=$_SESSION['subject']=="i"?"Diszkrét matematika I.":"Diszkrét matematika II."?> tárgy <?=$_SESSION['group']?> csoportjában!</label>
            </div>
        <?php endif?>
    </main>
    <script type="module" src="./views/js/mainContent.js"></script>
    <script type="module" src="./views/js/selectGroup.js"></script>
</body>
</html>