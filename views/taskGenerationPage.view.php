<?php
    // Information about the current client
    $is_administrator = $this->GetIsAdministrator();
    $neptun_code = $this->GetNeptunCode();
    $user_data = $this->GetUserData();
    $pending_teacher_groups = $this->GetPendingTeacherGroups();
    $pending_student_groups = $this->GetPendingStudentGroups();
    $approved_teacher_groups = $this->GetApprovedTeacherGroups();
    $approved_teacher_subjects = $this->GetApprovedTeacherSubjects();
    $approved_student_groups = $this->GetApprovedStudentGroups();

    // All of the students of this teacher
    $all_students = $this->GetStudents();

    // All of the pending teachers
    $pending_teachers = $this->GetPendingTeachers();

    // Redirect to the notifications page, if the teacher requested a task generator page for which they do not have permission to use
    $this->RedirectToIfWrongParam("subject", $approved_teacher_subjects, "notifications");
    $this->RedirectToIfWrongParam("exam_type", ["big", "small", "seminar"], "notifications");

    // Only i and ii subject ids are permitted, otherwise the user will be redirected to the notifications page
    $subject = "";
    if(isset($_SESSION["subject"])){
        if($_SESSION["subject"] == "i"){
            $subject = "Diszkrét matematika I.";
        }elseif($_SESSION["subject"] == "ii"){
            $subject = "Diszkrét matematika II.";
        }else{
            header("Location: ./index.php?site=notifications");
        }
    }else{
        header("Location: ./index.php?site=notifications");
    }

    // This variable is used to highlight the "Feladatok összeállítása" navigation button
    $actual_page = "task_generation";
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
        <?php if(!isset($_SESSION["exam_type"])):?>
            <h1><?=$subject?> feladatsorok generálása</h1>
            <hr>
            <div class="card_row">
                <div class="big_card" id="big_exam_generation">
                    <label class="title">
                        Nagy zárthelyi feladatsor összeállítása
                    </label>
                </div>
                <div class="big_card" id="small_exam_generation">
                    <label class="title">
                        Kiszárthelyi feladatsor összeállítása
                    </label>
                </div>
                <div class="big_card" id="seminar_tasks_generation">
                    <label class="title">
                        Órai feladatsor összeállítása
                    </label>
                </div>
            </div>
        <?php else:?>
            <?php 
                $exam_type = "";
                if($_SESSION["exam_type"] === "big"){
                    $exam_type = "nagy zárthelyi";
                }elseif($_SESSION["exam_type"] === "small"){
                    $exam_type = "kis zárthelyi";
                }elseif($_SESSION["exam_type"] === "seminar"){
                    $exam_type = "órai feladatsor";
                }
            ?>
            <h1><?=$subject?> <?=$exam_type?> generálása</h1>
            <hr> 
            <div class="task_generator_container">
                <div class="task_generation_settings">
                    <?php if($_SESSION["exam_type"] === "big"):?>

                    <?php elseif($_SESSION["exam_type"] === "small"):?>

                    <?php elseif($_SESSION["exam_type"] === "seminar"):?>

                    <?php endif?>
                </div>
                <div class="preview">
                    
                </div>
            </div>
        <?php endif?>
    </main>
</body>
<script type="module" src="./views/js/mainContent.js"></script>
</html>