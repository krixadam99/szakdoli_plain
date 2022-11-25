<?php
    $form_token = $this->GetFormToken();

    $incorrect_parameters = $this->incorrect_parameters;
    $error_params = array_keys($incorrect_parameters);

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
    <link href="./views/css/userDetails.css" rel="stylesheet" type="text/css">
    <?php if(!isset($user_details_editing)):?>
        <title>Csoport hozzáadása</title>
    <?php else:?>
        <title>Személyes adatok szerkesztése</title>
    <?php endif?>
</head>
<body>
    <?php include("./partials/header.php")?>
    <?php if(!isset($user_details_editing)):?>
        <main>
            <h1>Csoporthoz való csatlakozás</h1>
            <hr>
        </main>

        <form id="group_addition_form" action="./index.php?site=validateGroupAddition" method="POST" style="margin: 2% 4%;width: 92%">
            <input type="hidden" name="token" value="<?=$form_token?>">
        
            <div>
                <div>
                    <label class="title_label">
                        Válassz sátuszt!
                    </label>
                </div>
                <select id="user_status" name="user_status">
                    <?php if($can_apply_to_group):?>
                        <option id="student" <?=(isset($correct_parameters["user_status"]) && $correct_parameters["user_status"]=="Diák")?"selected":""?>>Diák</option>
                    <?php endif?>
                    <?php if($can_add_group_for_dimat_i || $can_add_group_for_dimat_ii):?>
                        <option id="teacher" <?=(isset($correct_parameters["user_status"]) &&$correct_parameters["user_status"]=="Demonstrátor")?"selected":""?>>Demonstrátor</option>
                    <?php endif?>
                </select>
                <?php if(isset($incorrect_parameters)):?>
                    <?php if(in_array('user_status',$error_params)):?>
                        <label class="error_label"><?=$incorrect_parameters["user_status"]?></label>
                    <?php endif?>
                <?php endif?>
            </div>

            <div>
                <div>
                    <label class="title_label">
                        Válassz tárgyat!
                    </label>
                </div>
                <select id="subject_id" name="subject_id" style="margin: 1% auto 3% 0%">
                    <?php if($can_add_group_for_dimat_i):?>
                        <option id="dimat_i" <?=(isset($correct_parameters["subject_id"]) && $correct_parameters["subject_id"]=="0")?"selected":""?>>Diszkrét matematika I.</option>
                    <?php endif?>
                    <?php if($can_add_group_for_dimat_ii):?>
                        <option id="dimat_ii" <?=(isset($correct_parameters["subject_id"]) && $correct_parameters["subject_id"]=="1")?"selected":""?>>Diszkrét matematika II.</option>
                    <?php endif?>
                </select>
                <?php if(isset($incorrect_parameters)):?>
                    <?php if(in_array('subject_id',$error_params)):?>
                        <label class="error_label"><?=$incorrect_parameters["subject_id"]?></label>
                    <?php endif?>
                <?php endif?>
            </div>

            <div id="subject_group_div">
                <div class="label_div">
                    <label class="title_label">Válassz csoportot!</label>
                </div>
                <?php if($can_apply_to_group):?>
                    <div id="student_groups" <?=(isset($correct_parameters["user_status"]) && $correct_parameters["user_status"]==="Demonstrátor")?"hidden":""?>>
                        <div id="subject_1" <?=(isset($correct_parameters['subject_id']) && $correct_parameters['subject_id']=="0")?"hidden":""?>>
                            <select id="subject_group" name="student_group_i" style="margin: 1% auto 1% 0%">
                                <?php foreach($dimat_i_groups as $key=>$group_number): ?>
                                    <option <?=(isset($correct_parameters['subject_group']) && $correct_parameters['subject_group']=="" . $group_number["group_number"] . "")?"selected":""?>><?=$group_number["group_number"]?></option>
                                <?php endforeach?>
                            </select>
                            <?php if(isset($incorrect_parameters)):?>
                                <?php if(in_array('student_group_i',$error_params)):?>
                                    <label class="error_label"><?=$incorrect_parameters["student_group_i"]?></label>
                                <?php endif?>
                            <?php endif?>
                        </div>
                        <div id="subject_2" <?=((isset($correct_parameters['subject_id']) && $correct_parameters['subject_id']=="1") || !isset($correct_parameters['subject_id']))?"hidden":""?>>
                            <select id="subject_group" name="student_group_ii" style="margin: 1% auto 1% 0%">
                                <?php foreach($dimat_ii_groups as $key=>$group_number): ?>
                                    <option <?=(isset($correct_parameters['subject_group']) && $correct_parameters['subject_group']=="".$group_number["group_number"]."")?"selected":""?>><?=$group_number["group_number"]?></option>
                                <?php endforeach?>
                            </select>
                            <?php if(isset($incorrect_parameters)):?>
                                <?php if(in_array('student_group_ii',$error_params)):?>
                                    <label class="error_label"><?=$incorrect_parameters["student_group_ii"]?></label>
                                <?php endif?>
                            <?php endif?>
                        </div>
                    </div>
                <?php endif?>
                <?php if($can_add_group_for_dimat_i || $can_add_group_for_dimat_ii):?>
                    <div id="teacher_groups" <?=((isset($correct_parameters["user_status"]) && $correct_parameters["user_status"]==="Diák") || !isset($correct_parameters["user_status"]) && $can_apply_to_group)?"hidden":""?>>
                        <select id="subject_group" name="teacher_group" style="margin: 1% auto 1% 0%">
                            <?php for($count= 1; $count <= 30; $count++): ?>
                                <option <?=(isset($correct_parameters['subject_group']) && $correct_parameters['subject_group']=="$count")?"selected":""?>><?=$count?></option>
                            <?php endfor?>
                        </select>
                        <?php if(isset($incorrect_parameters)):?>
                            <?php if(in_array('teacher_group',$error_params)):?>
                                <label class="error_label"><?=$incorrect_parameters["teacher_group"]?></label>
                            <?php endif?>
                        <?php endif?>
                    </div>
                <?php endif?>
            </div>

            <input type="submit" class="apply_button" value="Csatlakozás">
        </form>
    <?php else:?>
        <main>
            <h1>Személyes adatok szerkesztése</h1>
            <hr>
        </main>
        
        <form id="user_details_editing_form" action="./index.php?site=validateNewUserInformation" method="POST">
            <input type="hidden" name="token" value="<?=$form_token?>">
        
            <div class="label_div">
                <label class="title_label">Add meg az új email-címet!</label>
            </div>    
            <input type="text" id="user_email" name="user_email" value="<?=$correct_parameters["user_email"]??$user_details["email_address"]?>" placeholder="<?=$user_details["email_address"]?>">
            <?php if(isset($incorrect_parameters)):?>
                <?php if(in_array('user_email',$error_params)):?>
                    <label class="error_label"><?=$incorrect_parameters["user_email"]?></label>
                <?php endif?>
            <?php endif?>

            <div class="label_div">
                <label class="title_label">Add meg az új jelszót!</label>
                <br>
                <label class="title_label">(legalább 8 karakter hosszú, tartalmazzon legalább 1 kis- és nagybetűt, számot, valamint a "," "-" "." "?" és "!" karakterek valamelyikét)</label>
            </div>
            <div class="password_row">
                <input type="text" id="user_password" name="user_password" value="Jelszó..." placeholder="Jelszó...">
                <input type="image" id="show_password_image_first" src="./views/css/pics/opened_eye.png" alt="password hidden" width="100%" height="100%">
            </div>
            <?php if(isset($incorrect_parameters)):?>
                <?php if(in_array('user_password',$error_params)):?>
                    <label class="error_label"><?=$incorrect_parameters["user_password"]?></label>
                <?php endif?>
            <?php endif?>

            <div class="label_div">
                <label class="title_label">Add meg újra a jelszót!</label>
            </div>
            <div class="password_row">
                <input type="text" id="user_password_again" name="user_password_again" value="Jelszó megerősítése..." placeholder="Jelszó megerősítése...">
                <input type="image" id="show_password_image_second" src="./views/css/pics/opened_eye.png" alt="password hidden" width="100%" height="100%">
            </div>
            <?php if(isset($incorrect_parameters)):?>
                <?php if(in_array('user_password_again',$error_params)):?>
                    <label class="error_label"><?=$incorrect_parameters["user_password_again"]?></label>
                <?php endif?>
            <?php endif?>

            <input type="submit" class="apply_button" value="Rögzítés">
        </form>
    <?php endif?>
</body>
<script type="module" src="./views/js/register.js"></script>
<script type="module" src="./views/js/mainContent.js"></script>
</html>