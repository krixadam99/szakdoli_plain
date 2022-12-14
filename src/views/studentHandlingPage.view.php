<?php
    $form_token = $this->GetFormToken();

    // Approved teacher subjects
    $approved_teacher_subjects = $this->GetApprovedTeacherSubjects();
    
    // Redirect if the requested subject is not in the approved subject
    $this->RedirectToIfWrongParam("subject", $approved_teacher_subjects, "notifications");

    $students = [];
    foreach($all_students as $index => $students_per_subjects_per_group){
        if($students_per_subjects_per_group["subject_id"] === $_SESSION["subject"] && $students_per_subjects_per_group["subject_group"] === $_SESSION["group"]){
            $students = $students_per_subjects_per_group["users"];
            break;
        }
    }

    $not_withdrawn_students = [];
    foreach($students as $student){
        if($student["application_request_status"] !== "WITHDRAWN"){
            array_push($not_withdrawn_students, $student);
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
    <link href="./views/css/notifications.css" rel="stylesheet" type="text/css">
    <link href="./views/css/pendingStatus.css" rel="stylesheet" type="text/css">
    <title>Diákok kérésének kezelése</title>
</head>
<body>
    <?php include("./partials/header.php")?>
    <main>
        <?php include("./partials/groupSelection.php")?>
        <?php if(count($not_withdrawn_students) != 0):?>
            <form id="student_handling_form" action="./index.php?site=studentHandling" method="POST">
                <input type="hidden" name="token" value="<?=$form_token?>">
            
                <table>
                    <tr id="header_row">
                        <th>NEPTUN</th>
                        <th>TÁRGY</th>
                        <th>CSOPORT</th>
                        <th>DÖNTÉS</th>
                    </tr>
                    <?php foreach($not_withdrawn_students as $index => $student):?>
                        <tr id=<?=$student["group_number"]?> class="student_row">
                            <td><?=$student["neptun_code"]?></td>
                            <td><?=$student["subject_id"]=="i"?"Diszkrét matematika I.":"Diszkrét matematika II."?></td>
                            <td><?=$student["group_number"]?></td>
                            <td>
                                <select id="student_handling_select" name=<?=$student["neptun_code"]?>>
                                    <?php if($student["application_request_status"] === "PENDING"):?>
                                        <option selected>-</option>
                                        <option>Elfogadás</option>
                                        <option>Elutasítás</option>
                                    <?php elseif($student["application_request_status"] === "APPROVED"):?>
                                        <option selected>-</option>
                                        <option>Törlés</option>
                                    <?php elseif($student["application_request_status"] === "DENIED"):?>
                                        <option selected>-</option>
                                        <option>Visszavétel</option>
                                    <?php endif?>
                                </select>
                            </td>
                        </tr>
                    <?php endforeach?>
                </table>
                <button type="submit" class="finalize_button">Frissítés</button>
            </form>
        <?php else:?>
            <div class="notification_box">
                <label>Nem jelentkezett még diák a <?=$_SESSION['subject']=="i"?"Diszkrét matematika I.":"Diszkrét matematika II."?> tárgy <?=$_SESSION['group']?> csoportjába!</label>
            </div>
        <?php endif?>
    </main>
    <script type="module" src="./views/js/mainContent.js"></script>
    <script type="module" src="./views/js/selectGroup.js"></script>
</body>
</html>