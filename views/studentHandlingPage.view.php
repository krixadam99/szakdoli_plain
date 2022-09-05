<?php
    
    $neptun_code = $this->GetNeptunCode();
    $is_administrator = $this->GetIsAdministrator();
    $user_data = $this->GetUserData();
    $all_students = $this->GetStudents();
    $approved_teacher_groups = $this->GetApprovedTeacherGroups();
    $approved_teacher_subjects = $this->GetApprovedTeacherSubjects();
    $approved_student_groups = $this->GetApprovedStudentGroups();
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
        <div class="group_selector">
            <label>Válasszon csoportot</label>
            <select id="group_selector" onchange="ChangeRows(this.options[this.options.selectedIndex].value)">
                <?php foreach($approved_teacher_groups as $key => $approved_teacher_group):?>
                    <?php if($approved_teacher_group["subject_name"] == $_SESSION["subject"]):?>
                        <option <?=isset($_SESSION["group"]) && $_SESSION["group"] === $approved_teacher_group["subject_group"]?"selected":""?>><?=$approved_teacher_group["subject_group"]?></option>
                    <?php endif?>
                <?php endforeach?>
            </select>
        </div>
        <?php include("./partials/studentTable.php")?>
    </main>
</body>
<script type="module" src="./views/js/mainContent.js"></script>
<script>
    function ChangeRows(selected_group){
        let actual_path = window.location.href
        let new_path = actual_path.split("?")[0] + "?"
        let parts = actual_path.split("?")[1].split("&")
        let counter = 0
        for(let part of parts){
            if(part.includes("group")){
                new_path += "group=" + selected_group
                if(counter < parts.length -1){
                    new_path += "&"
                }
            }else{
                new_path += part
                if(counter < parts.length -1){
                    new_path += "&"
                }
            }
            counter += 1
        }
        window.location = new_path
    }
</script>
</html>