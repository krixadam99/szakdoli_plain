<?php
    $all_students = $this->GetStudents();
    $approved_teacher_groups = $this->GetApprovedTeacherGroups();
    
    $approved_teacher_groups_per_subject = [];
    if(!isset($_SESSION["subject"]) && !isset($_SESSION["group"])){
        header("Location: ./index.php");
    }

    $students = [];
    foreach($all_students as $index => $students_per_subjects_per_groups){
        foreach($students_per_subjects_per_groups["users"] as $index => $user){
            if($students_per_subjects_per_groups["subject_name"] === $_SESSION["subject"] && $students_per_subjects_per_groups["subject_group"] === $_SESSION["group"]){
                array_push($students, $user);
            }
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
        <h1><?=""?> csoport kiválasztása</h1>
        <hr>
        <select id="group_selector">
            <?php foreach($approved_teacher_groups as $key => $approved_teacher_group):?>
                <?php if($approved_teacher_group["subject_name"] == $_SESSION["subject"]):?>
                    <option <?=isset($_SESSION["group"]) && $_SESSION["group"] === $approved_teacher_group["subject_group"]?"selected":""?>><?=$approved_teacher_group["subject_group"]?></option>
                <?php endif?>
            <?php endforeach?>
        </select>
        <?php include("./partials/studentTable.php")?>
    </main>
</body>
<script type="module" src="./views/js/mainContent.js"></script>
</html>