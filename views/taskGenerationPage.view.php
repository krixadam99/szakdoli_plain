<?php
    // Approved teacher subjects
    $approved_teacher_subjects = $this->GetApprovedTeacherSubjects();

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
    <meta charset="utf-8">
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
                        <input type="number" min="1" max="100" step="1" value="12" id="font_size_input">
                        <input type="color" value="#000000" id="font_color_input">
                        <select id="font_family_select">
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
                        <div id="text_decoration">
                            <span id="underlined"><u>U</u></span>
                            <span id="crossed" style="text-decoration:line-through">T</span>
                            <span id="bold"><b>B</b></span>
                            <span id="italic"><i>I</i></span>
                        </div>
                        <div id="insert_character">
                            <div class="insert_character_buttons" id="special_character_button">
                                <label><?="\u{2200}"?></label>
                                <div class="special_characters">
                                    <div class="special_character_row">
                                        <div class="special_character_cell">
                                            <span entity="&forall;">&forall;</span>
                                        </div>
                                        <div class="special_character_cell">
                                            <span entity="&exist;">&exist;</span>
                                        </div>
                                        <div class="special_character_cell">
                                            <span entity="&prod;">&prod;</span>
                                        </div>
                                        <div class="special_character_cell">
                                            <span entity="&sum;">&sum;</span>
                                        </div>
                                    </div>
                                    <div class="special_character_row">
                                        <div class="special_character_cell">
                                            <span entity="&infin;">&infin;</span>
                                        </div>
                                        <div class="special_character_cell">
                                            <span entity="&deg;">&deg;</span>
                                        </div>
                                        <div class="special_character_cell">
                                            <span entity="&emptyset;">&emptyset;</span>
                                        </div>
                                        <div class="special_character_cell">
                                            <span entity="&in;">&in;</span>
                                        </div>
                                    </div>
                                    <div class="special_character_row">
                                        <div class="special_character_cell">
                                            <span entity="&notin;">&notin;</span>
                                        </div>
                                        <div class="special_character_cell">
                                            <span entity="&ni;">&ni;</span>
                                        </div>
                                        <div class="special_character_cell">
                                            <span entity="&notni;">&notni;</span>
                                        </div>
                                        <div class="special_character_cell">
                                            <span entity="&sub;">&sub;</span>
                                        </div>
                                    </div>
                                    <div class="special_character_row">
                                        <div class="special_character_cell">
                                            <span entity="&sube;">&sube;</span>
                                        </div>
                                        <div class="special_character_cell">
                                            <span entity="&sup;">&sup;</span>
                                        </div>
                                        <div class="special_character_cell">
                                            <span entity="&supe;">&supe;</span>
                                        </div>
                                        <div class="special_character_cell">
                                            <span entity="&nsub;">&nsub;</span>
                                        </div>
                                    </div>
                                    <div class="special_character_row">
                                        <div class="special_character_cell">
                                            <span entity="&nsube;">&nsube;</span>
                                        </div>
                                        <div class="special_character_cell">
                                            <span entity="&nsup;">&nsup;</span>
                                        </div>
                                        <div class="special_character_cell">
                                            <span entity="&nsupe;">&nsupe;</span>
                                        </div>
                                        <div class="special_character_cell">
                                            <span entity="&or;">&or;</span>
                                        </div>
                                    </div>
                                    <div class="special_character_row">
                                        <div class="special_character_cell">
                                            <span entity="&and;">&and;</span>
                                        </div>
                                        <div class="special_character_cell">
                                            <span entity="&not;">&not;</span>
                                        </div>
                                        <div class="special_character_cell">
                                            <span entity="&leftarrow;">&leftarrow;</span>
                                        </div>
                                        <div class="special_character_cell">
                                            <span entity="&rightarrow;">&rightarrow;</span>
                                        </div>
                                    </div>
                                    <div class="special_character_row">
                                        <div class="special_character_cell">
                                            <span entity="&leftrightarrow;">&leftrightarrow;</span>
                                        </div>
                                        <div class="special_character_cell">
                                            <span entity="&equiv;">&equiv;</span>
                                        </div>
                                        <div class="special_character_cell">
                                            <span entity="&nequiv;">&nequiv;</span>
                                        </div>
                                        <div class="special_character_cell">
                                            <span entity="&Assign;">&Assign;</span>
                                        </div>
                                    </div>
                                    <div class="special_character_row">
                                        <div class="special_character_cell">
                                            <span entity="&ne;">&ne;</span>
                                        </div>
                                        <div class="special_character_cell">
                                            <span entity="&gt;">&gt;</span>
                                        </div>
                                        <div class="special_character_cell">
                                            <span entity="&ge;">&ge;</span>
                                        </div>
                                        <div class="special_character_cell">
                                            <span entity="&lt;">&lt;</span>
                                        </div>
                                    </div>
                                    <div class="special_character_row">
                                        <div class="special_character_cell">
                                            <span entity="&le;">&le;</span>
                                        </div>
                                        <div class="special_character_cell">
                                            <span entity="&ngt;">&ngt;</span>
                                        </div>
                                        <div class="special_character_cell">
                                            <span entity="&nge;">&nge;</span>
                                        </div>
                                        <div class="special_character_cell">
                                            <span entity="&nlt;">&nlt;</span>
                                        </div>
                                    </div>
                                    <div class="special_character_row">
                                        <div class="special_character_cell">
                                            <span entity="&nle;">&nle;</span>
                                        </div>
                                        <div class="special_character_cell">
                                            <span entity="&cup;">&cup;</span>
                                        </div>
                                        <div class="special_character_cell">
                                            <span entity="&cap;">&cap;</span>
                                        </div>
                                        <div class="special_character_cell">
                                            <span entity="&plusmn;">&plusmn;</span>
                                        </div>
                                    </div>
                                    <div class="special_character_row">
                                        <div class="special_character_cell">
                                            <span entity="&alpha;">&alpha;</span>
                                        </div>
                                        <div class="special_character_cell">
                                            <span entity="&beta;">&beta;</span>
                                        </div>
                                        <div class="special_character_cell">
                                            <span entity="&gamma;">&gamma;</span>
                                        </div>
                                        <div class="special_character_cell">
                                            <span entity="&delta;">&delta;</span>
                                        </div>
                                    </div>
                                    <div class="special_character_row">
                                        <div class="special_character_cell">
                                            <span entity="&epsilon;">&epsilon;</span>
                                        </div>
                                        <div class="special_character_cell">
                                            <span entity="&zeta;">&zeta;</span>
                                        </div>
                                        <div class="special_character_cell">
                                            <span entity="&eta;">&eta;</span>
                                        </div>
                                        <div class="special_character_cell">
                                            <span entity="&theta;">&theta;</span>
                                        </div>
                                    </div>
                                    <div class="special_character_row">
                                        <div class="special_character_cell">
                                            <span entity="&iota;">&iota;</span>
                                        </div>
                                        <div class="special_character_cell">
                                            <span entity="&kappa;">&kappa;</span>
                                        </div>
                                        <div class="special_character_cell">
                                            <span entity="&lambda;">&lambda;</span>
                                        </div>
                                        <div class="special_character_cell">
                                            <span entity="&mu;">&mu;</span>
                                        </div> 
                                    </div>
                                    <div class="special_character_row">
                                        <div class="special_character_cell">
                                            <span entity="&nu;">&nu;</span>
                                        </div>
                                        <div class="special_character_cell">
                                            <span entity="&xi;">&xi;</span>
                                        </div>
                                        <div class="special_character_cell">
                                            <span entity="&omicron;">&omicron;</span>
                                        </div>    
                                        <div class="special_character_cell">
                                            <span entity="&pi;">&pi;</span>
                                        </div>
                                    </div>
                                    <div class="special_character_row">
                                        <div class="special_character_cell">
                                            <span entity="&rho;">&rho;</span>
                                        </div>    
                                        <div class="special_character_cell">
                                            <span entity="&sigma;">&sigma;</span>
                                        </div> 
                                        <div class="special_character_cell">
                                            <span entity="&tau;">&tau;</span>
                                        </div>     
                                        <div class="special_character_cell">
                                            <span entity="&upsilon;">&upsilon;</span>
                                        </div>
                                    </div>
                                    <div class="special_character_row">
                                        <div class="special_character_cell">
                                            <span entity="&phi;">&phi;</span>
                                        </div>
                                        <div class="special_character_cell">
                                            <span entity="&chi;">&chi;</span>
                                        </div>
                                        <div class="special_character_cell">
                                            <span entity="&psi;">&psi;</span>
                                        </div>
                                        <div class="special_character_cell">
                                            <span entity="&omega;">&omega;</span>
                                        </div> 
                                    </div>
                                    <div class="special_character_row">
                                        <div class="special_character_cell">
                                            <span entity="&varphi;">&varphi;</span>
                                        </div>
                                        <div class="special_character_cell">
                                            <span entity="&thetasym;">&thetasym;</span>
                                        </div>
                                        <div class="special_character_cell">
                                            <span entity="&upsih;">&upsih;</span>
                                        </div>
                                        <div class="special_character_cell">
                                            <span entity="&#8469;">&#8469;</span>
                                        </div> 
                                    </div>
                                    <div class="special_character_row">
                                        <div class="special_character_cell">
                                            <span entity="&#8469;">&#8484;</span>
                                        </div>
                                        <div class="special_character_cell">
                                            <span entity="&#8474;">&#8474;</span>
                                        </div>
                                        <div class="special_character_cell">
                                            <span entity="&#8477;">&#8477;</span>
                                        </div>
                                        <div class="special_character_cell">
                                            <span entity="&#8450;">&#8450;</span>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                            <label class="insert_character_buttons" id="exp_button">x<sup>n</sup></label>
                            <label class="insert_character_buttons" id="bottom_button">x<sub>n</sub></label>
                            <label class="insert_character_buttons" id="fraction_button">&frac12;</label>
                            <label class="insert_character_buttons" id="sub_sup_button">x<span class="upper_down_span"><span class="up_index">n</span><span class="down_index">i</span></span></label>
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
                            <span style="width:auto">Sortörés előtte: </span>
                            <input type="number" min="1" max="100" step="1" value="1" style="width:50%; margin: auto" id="linebreak_before_input">
                        </div>
                        <div id="linebreak_after">
                            <span style="width:auto">Sortörés utána: </span>
                            <input type="number" min="1" max="100" step="1" value="1" style="width:50%; margin: auto" id="linebreak_after_input">
                        </div>
                    </div>
                </div>
                <div id="page_container">
                    <div id="pdf_page_title_container">
                        <label id="pdf_page_title"><?=$_SESSION["preview"]["title_textarea"]?></label>
                    </div>
                    <?php if(isset($_SESSION["preview_tasks"])):?>
                        <?php if($_SESSION["exam_type"] !== "big"):?>
                            <?php foreach($_SESSION["preview_tasks"] as $main_task_counter => $main_task):?>
                                <?php if($_SESSION["exam_type"] !== "small"):?>
                                    <?= $main_task_counter + 1?>. feladatcsoport:
                                <?php endif?>
                                
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
                        <?php else:?>
                            <?php for($exam_counter = 0; $exam_counter < $_SESSION["preview"]["task_quantity"]??0; $exam_counter++):?>
                                <div class="editable_box" style="margin-top:3%">
                                    <label class="editable_label">
                                        <?= $exam_counter + 1?>. feladatsor
                                    </label>
                                </div>
                                <?php for($task_counter = 0; $task_counter < count($_SESSION["preview_tasks"]); $task_counter++):?>
                                    <?php
                                        $description = $_SESSION["preview_tasks"][$task_counter]["descriptions"][$exam_counter];
                                        $description = preg_replace("/[0-9]*\. csoport/", $task_counter + 1 . ". feladat", $description);
                                    ?>
                                    <?=$description?>
                                <?php endfor?>
                            <?php endfor?>

                            <?php for($exam_counter = 1; $exam_counter <= $_SESSION["preview"]["task_quantity"]??0; $exam_counter++):?>
                                <div class="editable_box" style="margin-top:3%">    
                                    <label class="editable_label">    
                                        <?= $exam_counter?>. feladatsor:
                                    </label>
                                </div>
                                <?php for($task_counter = 0; $task_counter < count($_SESSION["preview_tasks"]); $task_counter++):?>
                                    <?php 
                                        $printable_solution = $_SESSION["preview_tasks"][$task_counter]["printable_solutions"][$exam_counter];
                                        $printable_solution = preg_replace("/[0-9]*\. csoport/", $task_counter + 1 . ". feladat", $printable_solution);
                                    ?>
                                    <?=$printable_solution?>
                                <?php endfor?>
                            <?php endfor?>
                        <?php endif?>
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
                    <div class="pdf_page_section" style="margin-bottom:2%">
                        <label class="pdf_page_section_label">Feladatok kiválasztása</label>
                        <hr class="full_hr">
                    </div>
                    <?php include("./views/taskGeneration/chosenTasks.php")?>
                    <div class="pdf_page_task_choice_container" style="margin-top:2%">
                        <?php include("./partials/mainTopicSelect.php")?>
                        <?php include("./partials/subtopicSelect.php")?>
                        <button id="add_new_task" class="big_exam_button">+</button>
                    </div>
                    <div class="pdf_page_section" style="margin-top:5%">
                        <label style="width: 12%; margin: auto 2% auto 0%">Generálandó mennyiség (egységesen):</label>
                        <input type="number" min="1" max="20" step="1" placeholder="4" style="width:9%; margin:0% auto 0% 1%" name="task_quantity" value="<?=isset($_SESSION["preview"]["task_quantity"])?$_SESSION["preview"]["task_quantity"]:"4"?>">
                    </div>
                <?php elseif($_SESSION["exam_type"] === "small"):?>
                    <div class="pdf_page_section">
                        <label class="pdf_page_section_label">Feladat kiválasztása</label>
                        <hr class="full_hr">
                        <?php include("./views/taskGeneration/taskChoice.php")?>
                    </div>
                <?php elseif($_SESSION["exam_type"] === "seminar"):?>
                    <div class="pdf_page_section">
                        <label class="pdf_page_section_label">Feladat kiválasztása</label>
                        <hr class="full_hr">
                        <?php include("./views/taskGeneration/taskMultipleChoice.php")?>
                    </div>
                <?php endif?>
                
                <?php if(!isset($_SESSION["preview"]) || isset($_SESSION["preview"]) && count($_SESSION["preview"]) == 0):?>
                    <button id="generator_button" type="submit" style="margin-left:45%">Feladatsor generálása</button>
                <?php else:?>
                    <button id="new_task_generator_button" type="submit">Új feladatsor generálása</button>
                <?php endif?>
            </form>
        <?php endif?>
        <label>&lt</label>
    </main>
</body>
<script type="module" src="./views/js/mainContent.js"></script>
<script type="module" src="./views/js/taskGenerator.js"></script>
</html>