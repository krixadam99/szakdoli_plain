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
                        Kis zárthelyi feladatsor összeállítása
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
            <div id="preview" style="<?=isset($_SESSION["preview"]) && count($_SESSION["preview"]) != 0?"width:85%":"display:none"?>">
                <div id="editor_panel">
                    <div id="text_editor">
                        <div id="font_size">
                            <label style="width:auto">Betűméret: </label>
                            <input type="number" min="1" max="100" step="1" value="12" style="width:50%; margin: auto" id="font_size_input">
                        </div>
                        <div id="font_color">
                            <label style="width:auto">Betűszín: </label>
                            <input type="color" value="#000000" style="width:50%; margin: auto" id="font_color_input">
                        </div>
                        <div id="font_family">
                            <label style="width:auto">Betűtípus: </label>
                            <select style="width:50%; margin: auto" id="font_family_select">
                                <option selected>Arial</option>
                                <option>Courier New</option>
                                <option>Garamond</option>    
                                <option>Georgia</option>
                                <option>Helvetica</option>
                                <option>Lucida Console</option>
                                <option>Monaco</option>
                                <option>Papyrus</option>
                                <option>Times New Roman</option>
                                <option>Verdana</option>
                            </select>
                        </div>
                        <div id="text_decoration">
                            <img src="./views/css/pics/underlined.png" alt="underlined_element" id="underlined">
                            <img src="./views/css/pics/crossed.png" alt="crossed_element" id="crossed">
                            <img src="./views/css/pics/bold.png" alt="bold" id="bold">
                            <img src="./views/css/pics/italic.png" alt="italic" id="italic">
                        </div>
                    </div>
                    <div id="alignment_editor">
                        <img src="./views/css/pics/left_alignment.jpg" alt="left_alignment" id="left_alignment">
                        <img src="./views/css/pics/center_alignment.jpg" alt="center_alignment" id="center_alignment">
                        <img src="./views/css/pics/right_alignment.jpg" alt="right_alignment" id="right_alignment">
                        <img src="./views/css/pics/justify_alignment.jpg" alt="justify_alignment" id="justify_alignment">
                    </div>
                    <div id="linebreak_editor">
                        <div id="linebreak_before">
                            <label style="width:auto">Sortörés előtte: </label>
                            <input type="number" min="1" max="100" step="3" value="6" style="width:50%; margin: auto" id="linebreak_before_input">
                        </div>
                        <div id="linebreak_after">
                            <label style="width:auto">Sortörés utána: </label>
                            <input type="number" min="1" max="100" step="3" value="6" style="width:50%; margin: auto" id="linebreak_after_input">
                        </div>
                    </div>
                </div>
                <div id="page_container">
                    <div id="pdf_page_title_container">
                        <label id="pdf_page_title"><?=$_SESSION["preview"]["title_textarea"]?></label>
                    </div>
                    <?php if(isset($_SESSION["preview_tasks"])):?>
                        <?php foreach($_SESSION["preview_tasks"] as $main_task_counter => $main_task):?>
                            <?= $main_task_counter + 1?>. feladatcsoport:
                            <?php 
                                $descriptions = $main_task["descriptions"]??[];
                                $printable_solutions = $main_task["printable_solutions"]??[];
                            ?>
                            <?php foreach($descriptions as $description_counter => $description):?>
                                <?=$description?>
                            <?php endforeach?>
                            <?php foreach($printable_solutions as $printable_solution_counter => $printable_solution):?>
                                <?=$printable_solution?>
                            <?php endforeach?>
                        <?php endforeach?>
                    <?php endif?>
                </div>
            </div>
            <?php if(isset($_SESSION["preview"]) && count($_SESSION["preview"]) != 0):?>
                <div class="pdf_page_button_container">
                    <button id="save_pdf_button">Előnézet mentése</button>
                </div>

                <label style="margin:2% auto 0% 4%;font-weight: normal;font-size: calc(20px + 0.3vw);">Új feladatsor készítése</label>
                <hr>
                <?php endif?>
            <form method="POST" id="task_generation_settings" action="./index.php?site=createPreview">                    
                <div class="pdf_page_section">
                    <label class="pdf_page_section_label">Feladatsor címe</label>
                    <hr class="full_hr">
                    <textarea class="task_generation_textarea" name="title_textarea" rows="1" placeholder="Ide írd a címet..."></textarea>
                </div>
            
                <?php if($_SESSION["exam_type"] === "big"):?>

                <?php elseif($_SESSION["exam_type"] === "small"):?>
                    <?php 
                        $section_name = "task_0";
                    ?>
                    <div class="pdf_page_section">
                        <label class="pdf_page_section_label">Feladat kiválasztása</label>
                        <hr class="full_hr">
                        <?php include("./partials/taskChoice.php")?>
                    </div>
                <?php elseif($_SESSION["exam_type"] === "seminar"):?>
                    <?php 
                        $section_name = "task_0";
                    ?>
                    <div class="pdf_page_section">
                        <label class="pdf_page_section_label">Feladat kiválasztása</label>
                        <hr class="full_hr">
                        <?php include("./partials/taskMultipleChoice.php")?>
                    </div>
                <?php endif?>
                
                <?php if(!isset($_SESSION["preview"]) || isset($_SESSION["preview"]) && count($_SESSION["preview"]) == 0):?>
                    <button id="generator_button" type="submit" style="margin-left:45%">Feladatsor generálása</button>
                <?php else:?>
                    <button id="new_task_generator_button" type="submit">Új feladatsor generálása</button>
                <?php endif?>
            </form>
        <?php endif?>
    </main>
</body>
<script type="module" src="./views/js/mainContent.js"></script>
<script type="module" src="./views/js/taskGenerator.js"></script>
</html>