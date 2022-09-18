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
            $main_topics = $this->dimat_i_topics;
            $sub_topics = $this->dimat_i_subtopics;
        }elseif($_SESSION["subject"] == "ii"){
            $subject = "Diszkrét matematika II.";
            $main_topics = $this->dimat_ii_topics;
            $sub_topics = $this->dimat_ii_subtopics;
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
                <form method="POST" id="task_generation_settings" style="<?=isset($_SESSION["preview"]) && count($_SESSION["preview"]) != 0?"width:48%":"width:85%"?>" action="./index.php?site=createPreview">
                    <?php $section_name = "header"?>
                    <div class="pdf_page_section">
                        <label class="pdf_page_section_label">Fejléc</label>
                        <hr class="full_hr">
                        <?php include("./partials/styleBox.php")?>
                        <textarea id="header_text_area" name="header_text" rows="8"><?=isset($_SESSION["preview"]["header_text"])?$_SESSION["preview"]["header_text"]:"Ide írd a fejléc szövegét..."?></textarea>
                    </div>

                    <?php $section_name = "title"?>
                    <div class="pdf_page_section">
                        <label class="pdf_page_section_label">Cím</label>
                        <hr class="full_hr">
                        <?php include("./partials/styleBox.php")?>
                        <textarea id="title_text_area" name="title_text" rows="1"><?=isset($_SESSION["preview"]["title_text"])?$_SESSION["preview"]["title_text"]:"Ide írd a címet..."?></textarea>
                    </div>
                    
                    <?php if($_SESSION["exam_type"] === "big"):?>

                    <?php elseif($_SESSION["exam_type"] === "small"):?>
                        <?php 
                            $section_name = "task_0";
                        ?>
                        <div class="pdf_page_section">
                            <label class="pdf_page_section_label">Feladat kiválasztása (az itt beállított stílus egységesen lesz alkalmazva)</label>
                            <hr class="full_hr">
                            <?php include("./partials/styleBox.php")?>
                            <?php include("./partials/taskChoice.php")?>
                        </div>
                    <?php elseif($_SESSION["exam_type"] === "seminar"):?>

                    <?php endif?>
                    
                    <?php $section_name = "footer"?>
                    <div class="pdf_page_section" style="margin-bottom: 3%">
                        <label class="pdf_page_section_label">Lábléc</label>
                        <hr class="full_hr">
                        <?php include("./partials/styleBox.php")?>
                        <textarea id="footer_text_area" name="footer_text" rows="8"><?=isset($_SESSION["preview"]["footer_text"])?$_SESSION["preview"]["footer_text"]:"Ide írd a lábléc szövegét..."?></textarea>
                    </div>
                    <?php if(!isset($_SESSION["preview"]) || isset($_SESSION["preview"]) && count($_SESSION["preview"]) == 0):?>
                        <button id="generator_button" type="submit" style="margin-left:45%">Feladatsor generálása</button>
                    <?php endif?>
                </form>
                <div id="preview" style="<?=isset($_SESSION["preview"]) && count($_SESSION["preview"]) != 0?"width:48%":"display:none"?>">
                        <!--div id="editor_panel">
                            <div id="font_editor">
                                <div id="font_color">
                                </div>
                            </div>
                            <div id="text_editor">
                                <div id="left_align">
                                </div>
                                <div id="center_align">
                                </div>
                                <div id="right_align">
                                </div>
                                <div id="justify_align">
                                </div>
                            </div>
                        </div>
                        <div id="a4_document">
                            <div class="a4_page">
                            </div>
                            <div class="a4_page">
                            </div>
                            <div class="a4_page">
                            </div>
                        </div-->
                        <div>
                            <?php if(isset($_SESSION["preview_tasks"])):?>

                                <?php foreach($_SESSION["preview_tasks"] as $main_task_counter => $task):?>
                                    <?=$main_task_counter + 1?>. feladatcsoport:
                                    <br>
                                    <?php
                                        $task["task_description"] = explode("\n", $task["task_description"]);
                                        $task["task_solution"] = explode("\n", $task["task_solution"]);
                                    ?>
                                    <b><?=$task["task_description"][0]?></b>
                                    <br>
                                    <?php for($group_counter = 1; $group_counter < count($task["task_description"]); $group_counter++):?>
                                        <?=$group_counter?>. csoport:
                                        <br>
                                        <?=$task["task_description"][$group_counter]?>
                                        <br>
                                    <?php endfor?>

                                    <b><?=$task["task_solution"][0]?></b>
                                    <br>
                                    <?php for($group_counter = 1; $group_counter < count($task["task_solution"]); $group_counter++):?>
                                        <?=$group_counter?>. csoport:
                                        <br>
                                        <?=$task["task_solution"][$group_counter]?>
                                        <br>
                                    <?php endfor?>
                                <?php endforeach?>
                            <?php endif?>
                        </div>
                </div>
            </div>
            <?php if(isset($_SESSION["preview"]) && count($_SESSION["preview"]) != 0):?>
                <div class="pdf_page_button_container">
                    <button id="save_pdf_button">Előnézet mentése</button>
                    <button id="new_task_generator_button">Új feladatsor generálása</button>
                </div>
            <?php endif?>
        <?php endif?>
    </main>
</body>
<script type="module" src="./views/js/mainContent.js"></script>
</html>