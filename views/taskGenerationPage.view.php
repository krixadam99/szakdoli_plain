<?php
    
    $is_administrator = $this->GetIsAdministrator();
    $neptun_code = $this->GetNeptunCode();
    
    $user_data = $this->GetUserData();

    $all_students = $this->GetStudents();
    
    $pending_teachers = $this->GetPendingTeachers();
    $pending_teacher_groups = $this->GetPendingTeacherGroups();
    $pending_student_groups = $this->GetPendingStudentGroups();
    
    $approved_teacher_groups = $this->GetApprovedTeacherGroups();
    $approved_teacher_subjects = $this->GetApprovedTeacherSubjects();
    $approved_student_groups = $this->GetApprovedStudentGroups();

    $subject = "";
    if(isset($_SESSION["subject"])){
        if($_SESSION["subject"] == "i"){
            $subject = "Diszkrét matematika I.";
        }else if($_SESSION["subject"] == "ii"){
            $subject = "Diszkrét matematika II.";
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
    <title>Feladat generálása</title>
</head>
<body>
    <?php include("./partials/header.php")?>
    <main>
        <h1><?=$subject?> feladatsorok generálása</h1>
        <hr>
        <div class="card_row">
            <div class="big_card">
                <label class="title">
                    Nagy zárthelyi feladatsor összeállítása
                </label>
            </div>
            <div class="big_card">
                <label class="title">
                    Kiszárthelyi feladatsor összeállítása
                </label>
            </div>
            <div class="big_card">
                <label class="title">
                    Órai feladatsor összeállítása
                </label>
            </div>
        </div>
    </main>
</body>
<script type="module" src="./views/js/mainContent.js"></script>
</html>