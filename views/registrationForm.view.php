<?php

    $incorrect_parameters = $this->GetIncorrectParameters();
    $correct_parameters = $this->GetCorrectParameters();
    
    $dimat_i_groups = [];
    if(isset($this->dimat_i_groups)){
        $dimat_i_groups = $this->dimat_i_groups;
    }

    $dimat_ii_groups = [];
    if(isset($this->dimat_ii_groups)){
        $dimat_ii_groups = $this->dimat_ii_groups;
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./views/css/login_registration.css" rel="stylesheet" type="text/css">
    <title>Regisztráció</title>
</head>
<body>
    <form id="registration_form" action="./index.php?site=validateRegistration" method="POST">
        <div class="label_div">
            <label class="title_label">ADJON MEG NEPTUN KÓDOT!</label>
            <br>
            <label class="title_label">(6 karakter hosszú)</label>
        </div>
        <input type="text" id="neptun_code" name="neptun_code" value="<?=$correct_parameters["neptun_code"]??"Neptun kód"?>" placeholder="Neptun kód">
        <?php if(isset($incorrect_parameters)):?>
            <?php if(in_array('wrong_1_no_data',$incorrect_parameters)):?>
                <label class="error_label">Adjon meg neptun kódot!</label>
            <?php elseif(in_array('wrong_1_length',$incorrect_parameters)):?>
                <label class="error_label">A kód hossza nem megfelelő (6 karakter hosszú kell, hogy legyen)!</label>
            <?php elseif(in_array('wrong_1_already_in_use',$incorrect_parameters)):?>
                <label class="error_label">A neptun kódhoz tartozik már felhasználó!</label>
            <?php elseif(in_array('wrong_1_invalid_characters',$incorrect_parameters)):?>
                <label class="error_label">A neptun kód csak betűt és számot tartalmazhat!</label>
            <?php endif?>
        <?php endif?>

        <div class="label_div">
            <label class="title_label">ADJON MEG EMAIL CÍMET!</label>
        </div>
        <input type="text" id="user_email" name="user_email" value="<?=$correct_parameters["user_email"]??"Email cím"?>" placeholder="Email cím">
        <?php if(isset($incorrect_parameters)):?>
            <?php if(in_array('wrong_2_no_email',$incorrect_parameters)):?>
                <label class="error_label">Adjon meg email címet!</label>
            <?php elseif(in_array('wrong_2_wrong_format',$incorrect_parameters)):?>
                <label class="error_label">Az email cím formátuma nem megfelelő!</label>
            <?php elseif(in_array('wrong_2_already_in_use',$incorrect_parameters)):?>
                <label class="error_label">Az email cím már használatban van!</label>
            <?php endif?>
        <?php endif?>

        <div class="label_div">
            <label class="title_label">VÁLASSZON TÁRGYAT!</label>
        </div>
        <select id="subject_id" name="subject_id">
            <option id="dimat_i" <?=(isset($correct_parameters["subject_id"]) && $correct_parameters["subject_id"]=="0")?"selected":""?>>Diszkrét matematika I.</option>
            <option id="dimat_ii" <?=(isset($correct_parameters["subject_id"]) && $correct_parameters["subject_id"]=="1")?"selected":""?>>Diszkrét matematika II.</option>
        </select>
        <?php if(isset($incorrect_parameters)):?>
            <?php if(in_array('wrong_3_no_such_subject',$incorrect_parameters)):?>
                <label class="error_label">A kiválasztott tárgy nem létezik!</label>
            <?php elseif(in_array('wrong_3_no_subject_id',$incorrect_parameters)):?>
                <label class="error_label">Nincsen kiválasztott tárgy!</label>
            <?php endif?>
        <?php endif?>

        <div class="label_div">
            <label class="title_label">VÁLASSZON STÁTUSZT!</label>
        </div>
        <select id="user_status" name="user_status">
            <option id="student" <?=(isset($correct_parameters["user_status"]) && $correct_parameters["user_status"]=="Diák")?"selected":""?>>Diák</option>
            <option id="teacher" <?=(isset($correct_parameters["user_status"]) &&$correct_parameters["user_status"]=="Demonstrátor")?"selected":""?>>Demonstrátor</option>
        </select>
        <?php if(isset($incorrect_parameters)):?>
            <?php if(in_array('wrong_4_no_such_status',$incorrect_parameters)):?>
                <label class="error_label">A kiválasztott státusz nem megengedett!</label>
            <?php elseif(in_array('wrong_4_no_user_status',$incorrect_parameters)):?>
                <label class="error_label">Nincsen kiválasztott státusz!</label>
            <?php endif?>
        <?php endif?>

        <div id="subject_group_div" <?=(isset($correct_parameters["subject_id"]) && $correct_parameters["subject_id"]=="2")?"hidden":""?>>
            <div class="label_div">
                <label class="title_label">VÁLASSZON CSOPORTOT!</label>
            </div>
            <div id="student_groups" <?=(isset($correct_parameters["user_status"]) && $correct_parameters["user_status"]=="Demonstrátor")?"hidden":""?>>
                <div id="subject_1" <?=(isset($correct_parameters['subject_id']) && $correct_parameters['subject_id']=="1")?"hidden":""?>>
                    <select id="subject_group" name="student_group_i">
                        <option id="no_group" <?=!isset($correct_parameters['subject_group'])?"selected":""?>>-</option>
                        <?php foreach($dimat_i_groups as $key=>$group_number): ?>
                            <option <?=(isset($correct_parameters['subject_group']) && $correct_parameters['subject_group']=="$group_number[0]")?"selected":""?>><?=$group_number[0]?></option>
                        <?php endforeach?>
                    </select>
                </div>
                <div id="subject_2" <?=((isset($correct_parameters['subject_id']) && $correct_parameters['subject_id']=="0") || !isset($correct_parameters['subject_id']))?"hidden":""?>>
                    <select id="subject_group" name="student_group_ii">
                        <option id="no_group" <?=!isset($correct_parameters['subject_group'])?"selected":""?>>-</option>
                        <?php foreach($dimat_ii_groups as $key=>$group_number): ?>
                            <option <?=(isset($correct_parameters['subject_group']) && $correct_parameters['subject_group']=="$group_number[0]")?"selected":""?>><?=$group_number[0]?></option>
                        <?php endforeach?>
                    </select>
                </div>
            </div>
            <div id="teacher_groups" <?=((isset($correct_parameters["user_status"]) && $correct_parameters["user_status"]=="Diák") || !isset($correct_parameters["user_status"]))?"hidden":""?>>
                <select id="subject_group" name="teacher_group">
                    <?php for($count= 1; $count <= 30; $count++): ?>
                        <option <?=(isset($correct_parameters['subject_group']) && $correct_parameters['subject_group']=="$count")?"selected":""?>><?=$count?></option>
                    <?php endfor?>
                </select>
            </div>
            <?php if(isset($incorrect_parameters)):?>
                <?php if(in_array('wrong_5_no_such_group',$incorrect_parameters)):?>
                    <label class="error_label">A kiválasztott csoporthoz nincsen tanár rendelve!</label>
                <?php elseif(in_array('wrong_5_no_subject_group',$incorrect_parameters)):?>
                    <label class="error_label">Nincsen kiválasztott csoport!</label>
                <?php endif?>
            <?php endif?>
        </div>


        <div class="label_div">
            <label class="title_label">ADJON MEG JELSZÓT!</label>
            <br>
            <label class="title_label">(legalább 8 karakter hosszú, tartalmazzon legalább 1 kis- és nagybetűt, számot, valamint a "," "-" "." "?" és "!" karakterek valamelyikét)</label>
        </div>
        <div class="password_row">
            <input type="text" id="user_password" name="user_password" value="Jelszó" placeholder="Jelszó">
            <input type="image" id="show_password_image_first" src="./views/css/pics/opened_eye.png" alt="password hidden" width="100%" height="100%">
        </div>
        <?php if(isset($incorrect_parameters)):?>
            <?php if(in_array('wrong_6_no_password',$incorrect_parameters)):?>
                <label class="error_label">Adjon meg egy valid jelszót!</label>
            <?php elseif(in_array('wrong_6_length',$incorrect_parameters)):?>
                <label class="error_label">A jelszó hossza nem megfelelő!</label>
            <?php elseif(in_array('wrong_6_complexity',$incorrect_parameters)):?>
                <label class="error_label">A jelszó komplexitása nem megfelelő!</label>
            <?php endif?>
        <?php endif?>

        <div class="label_div">
            <label class="title_label">ADJA MEG ÚJRA A JELSZÓT!</label>
        </div>
        <div class="password_row">
            <input type="text" id="user_password_again" name="user_password_again" value="Jelszó megerősítése" placeholder="Jelszó megerősítése">
            <input type="image" id="show_password_image_second" src="./views/css/pics/opened_eye.png" alt="password hidden" width="100%" height="100%">
        </div>
        <?php if(isset($incorrect_parameters)):?>
            <?php if(in_array('wrong_7_no_password_validate',$incorrect_parameters)):?>
                <label class="error_label">Adjon meg megerősítő jelszót!</label>
            <?php elseif(in_array('wrong_7_not_same',$incorrect_parameters)):?>
                <label class="error_label">A jelszók nem egyeznek!</label>
            <?php endif?>
        <?php endif?>

        <input type="submit" id="register_button" value="Regisztrálás">
    </form>
<button id="back_button">Vissza</button>
</body>
<script type="module" src="./views/js/register.js"></script>
</html>