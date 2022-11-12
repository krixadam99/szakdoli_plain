<?php
    $pending_teacher_groups = $this->pending_teacher_groups;
    $pending_student_groups = $this->pending_student_groups;
    $approved_teacher_groups = $this->approved_teacher_groups;
    $approved_student_group = $this->approved_student_group;
    $denied_student_groups = $this->denied_student_groups;
    $withdrawn_student_groups = $this->withdrawn_student_groups;

    $actual_page = "notifications";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./views/css/header.css" rel="stylesheet" type="text/css">
    <link href="./views/css/body.css" rel="stylesheet" type="text/css">
    <title>Értesítések</title>
</head>
<body>
    <?php include("./partials/header.php")?>
    <main>
        <h1>Értesítések</h1>
        <hr>
        
        <!-- Requests that are currently pending -->
        <div id="notification_container">
            <?php foreach($pending_teacher_groups as $index => $pending_teacher_group):?>
                <div class="notification_box">
                    <label>Demonstrátori kérése a <?=$pending_teacher_group["subject_id"]=="i"?"Diszkrét matematika I.":"Diszkrét matematika II."?> tárgy <?=$pending_teacher_group["subject_group"]?>. csoport esetében elbírálás alatt áll!</label>
                </div>
            <?php endforeach?>
            <?php foreach($pending_student_groups as $index => $pending_student_group):?>
                <div class="notification_box">
                    <?php if($pending_student_group["subject_group"] === "0"):?>
                        <label>
                            Jelentkezzen valamelyik tárgy csoportjába a navigációs menü 1. sorában lévő + ikonra kattintva! Ha nem találja a megfelelő csoportot, akkor várja meg míg a csoporthoz hozzá lesz rendelve demonstrátor!
                        </label>
                    <?php else:?>
                        <label>
                            A 
                            <?php if($pending_student_group["subject_id"]=="i"):?>
                                Diszkrét matematika I.
                            <?php elseif($pending_student_group["subject_id"]=="ii"):?>
                                Diszkrét matematika II.
                            <?php endif?>
                            tárgy <?=$pending_student_group["subject_group"]?>. csoport-hoz való csatlakozási kérése elbírálás alatt áll!
                        </label>
                    <?php endif?>
                </div>
            <?php endforeach?>
        </div>
        
        <!-- Requests that are approved -->
        <div id="notification_container">
            <?php foreach($approved_teacher_groups as $index => $approved_teacher_group):?>
                <div class="notification_box">
                    <label>Demonstrátori kérése a <?=$approved_teacher_group["subject_id"]=="i"?"Diszkrét matematika I.":"Diszkrét matematika II."?> tárgy <?=$approved_teacher_group["subject_group"]?>. csoportjához elfogadásra került!</label>
                </div>
            <?php endforeach?>
            <?php if($approved_student_group !== ""):?>
                <div class="notification_box">
                    <label>
                        A 
                        <?php if($approved_student_group ==="i"):?>
                            Diszkrét matematika I.
                        <?php elseif($approved_student_group ==="ii"):?>
                            Diszkrét matematika II.
                        <?php endif?>
                        tárgy <?=$approved_student_group?>. csoport-hoz való csatlakozási kérése elfogadásra került!
                    </label>
                </div>
            <?php endif?>
        </div>

        <!-- Requests that were denied -->
        <div id="notification_container">
            <?php foreach($denied_student_groups as $index => $denied_student_group):?>
                <div class="notification_box">
                    <label>
                        A 
                        <?php if($denied_student_group["subject_id"]=="i"):?>
                            Diszkrét matematika I.
                        <?php elseif($denied_student_group["subject_id"]=="ii"):?>
                            Diszkrét matematika II.
                        <?php endif?>
                        tárgy <?=$denied_student_group["subject_group"]?>. csoport-hoz való csatlakozási kérése elutasításra került!
                    </label>
                </div>
            <?php endforeach?>
        </div>

        <!-- Requests that were withdrawn -->
        <div id="notification_container">
            <?php foreach($withdrawn_student_groups as $index => $withdrawn_student_group):?>
                <div class="notification_box">
                    <label>
                        A 
                        <?php if($withdrawn_student_group["subject_id"]=="i"):?>
                            Diszkrét matematika I.
                        <?php elseif($withdrawn_student_group["subject_id"]=="ii"):?>
                            Diszkrét matematika II.
                        <?php endif?>
                        tárgy <?=$withdrawn_student_group["subject_group"]?>. csoport-hoz való csatlakozási kérése visszavonásra került!
                    </label>
                </div>
            <?php endforeach?>
        </div>
        
        <!-- If there is no more group that is pending, then let's display that too -->
        <?php if(count($pending_teacher_groups) == 0 && count($pending_student_groups) == 0):?>
            <div class="notification_box">
                <label>Nincsen elbírálás allatt álló tárgya!</label>
            </div>
        <?php endif?>
    </main>
</body>
<script type="module" src="./views/js/mainContent.js"></script>
</html>