<?php
    $approved_teacher_groups = $this->GetApprovedTeacherGroups();
    if(!isset($_SESSION["subject"]) && !isset($_SESSION["group"])){
        header("Location: ./index.php");
    }
?>

<h1><?=$_SESSION["subject"] === "i"?"Diszkrét matematika I.":"Diszkrét matematika II."?> csoport kiválasztása</h1>
<hr>
<select id="group_selector">
    <?php foreach($approved_teacher_groups as $key => $approved_teacher_group):?>
        <?php if($approved_teacher_group["subject_id"] == $_SESSION["subject"]):?>
            <option <?=isset($_SESSION["group"]) && $_SESSION["group"] === $approved_teacher_group["subject_group"]?"selected":""?>><?=$approved_teacher_group["subject_group"]?></option>
        <?php endif?>
    <?php endforeach?>
</select>