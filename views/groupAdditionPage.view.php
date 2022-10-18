<?php

    $incorrect_parameters = $this->error_parameters;
    $correct_parameters = $this->success_parameters;
    $dimat_i_groups = [];
    if(isset($this->dimat_i_groups)){
        $dimat_i_groups = $this->dimat_i_groups;
    }
    $dimat_ii_groups = [];
    if(isset($this->dimat_ii_groups)){
        $dimat_ii_groups = $this->dimat_ii_groups;
    }

    $approved_teacher_subjects = $this->GetApprovedTeacherSubjects();
    $approved_student_subject = $this->GetApprovedStudentSubject();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./views/css/header.css" rel="stylesheet" type="text/css">
    <link href="./views/css/body.css" rel="stylesheet" type="text/css">
    <title>Csoport hozzáadása</title>
</head>
<body>
    <?php include("./partials/header.php")?>
    <main>
        <h1>Csoporthoz való csatlakozás</h1>
        <hr>
    </main>

    <form id="group_addition_form" action="./index.php?site=validateGroupAddition" method="POST" style="margin: 2% 4%;width: 92%">
        
        <div>
            <div>
                <label id="title_label">
                    Válassz sátuszt!
                </label>
            </div>
            <select id="user_status" name="user_status">
                <?php if($can_apply_to_group):?>
                    <option id="student" <?=(isset($correct_parameters["user_status"]) && $correct_parameters["user_status"]=="Diák")?"selected":""?>>Diák</option>
                <?php endif?>
                <?php if($can_add_group):?>
                    <option id="teacher" <?=(isset($correct_parameters["user_status"]) &&$correct_parameters["user_status"]=="Demonstrátor")?"selected":""?>>Demonstrátor</option>
                <?php endif?>
            </select>
            <?php if(isset($incorrect_parameters)):?>
                <?php if(in_array('wrong_1_no_such_status',$incorrect_parameters)):?>
                    <label id="error_label">A kiválasztott státusz nem megengedett!</label>
                <?php elseif(in_array('wrong_1_no_user_status',$incorrect_parameters)):?>
                    <label id="error_label">Nincsen kiválasztott státusz!</label>
                <?php endif?>
            <?php endif?>
        </div>

        <div>
            <div>
                <label id="title_label">
                    Válassz tárgyat!
                </label>
            </div>
            <select id="subject_id" name="subject_id" style="margin: 1% auto 3% 0%">
                <?php if(!in_array("i",$approved_teacher_subjects)):?>
                    <option id="dimat_i" <?=(isset($correct_parameters["subject_id"]) && $correct_parameters["subject_id"]=="0")?"selected":""?>>Diszkrét matematika I.</option>
                <?php endif?>
                <?php if($approved_student_subject !== "ii"):?>
                    <option id="dimat_ii" <?=(isset($correct_parameters["subject_id"]) && $correct_parameters["subject_id"]=="1")?"selected":""?>>Diszkrét matematika II.</option>
                <?php endif?>
            </select>
            <?php if(isset($incorrect_parameters)):?>
                <?php if(in_array('wrong_2_no_such_subject',$incorrect_parameters)):?>
                    <label id="error_label">A kiválasztott tárgy nem létezik!</label>
                <?php elseif(in_array('wrong_2_no_subject_id',$incorrect_parameters)):?>
                    <label id="error_label">Nincsen kiválasztott tárgy!</label>
                <?php endif?>
            <?php endif?>
        </div>

        <div id="subject_group_div">
            <div id="label_div">
                <label id="title_label">Válassz csoportot!</label>
            </div>
            <div id="student_groups" <?=(isset($correct_parameters["user_status"]) && $correct_parameters["user_status"]==="Demonstrátor" || !$can_apply_to_group)?"hidden":""?>>
                <div id="subject_1" <?=(isset($correct_parameters['subject_id']) && $correct_parameters['subject_id']=="1")?"hidden":""?>>
                    <select id="subject_group" name="student_group_i" style="margin: 1% auto 1% 0%">
                        <?php foreach($dimat_i_groups as $key=>$group_number): ?>
                            <option <?=(isset($correct_parameters['subject_group']) && $correct_parameters['subject_group']=="$group_number[0]")?"selected":""?>><?=$group_number[0]?></option>
                        <?php endforeach?>
                    </select>
                </div>
                <div id="subject_2" <?=((isset($correct_parameters['subject_id']) && $correct_parameters['subject_id']=="0") || !isset($correct_parameters['subject_id']))?"hidden":""?>>
                    <select id="subject_group" name="student_group_ii" style="margin: 1% auto 1% 0%">
                        <?php foreach($dimat_ii_groups as $key=>$group_number): ?>
                            <option <?=(isset($correct_parameters['subject_group']) && $correct_parameters['subject_group']=="$group_number[0]")?"selected":""?>><?=$group_number[0]?></option>
                        <?php endforeach?>
                    </select>
                </div>
            </div>
            <div id="teacher_groups" <?=((isset($correct_parameters["user_status"]) && $correct_parameters["user_status"]==="Diák") || !isset($correct_parameters["user_status"])|| !$can_add_group)?"hidden":""?>>
                <select id="subject_group" name="teacher_group" style="margin: 1% auto 1% 0%">
                    <?php for($count= 1; $count <= 30; $count++): ?>
                        <option <?=(isset($correct_parameters['subject_group']) && $correct_parameters['subject_group']=="$count")?"selected":""?>><?=$count?></option>
                    <?php endfor?>
                </select>
            </div>
            <?php if(isset($incorrect_parameters)):?>
                <?php if(in_array('wrong_3_no_such_group',$incorrect_parameters)):?>
                    <label id="error_label">A kiválasztott csoporthoz nincsen tanár rendelve!</label>
                <?php elseif(in_array('wrong_3_no_subject_group',$incorrect_parameters)):?>
                    <label id="error_label">Nincsen kiválasztott csoport!</label>
                <?php endif?>
            <?php endif?>
        </div>

        <input type="submit" id="apply_button" value="Csatlakozás">
    </form>
</body>
<script type="module" src="./views/js/register.js"></script>
<script type="module" src="./views/js/mainContent.js"></script>
</html>