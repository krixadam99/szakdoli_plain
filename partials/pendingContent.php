<div id="notification_container">
    <?php foreach($pending_teacher_groups as $index => $pending_teacher_group):?>
        <div id="notification_box">
            <label>Demonstrátori kérése a <?=$pending_teacher_group["subject_name"]=="i"?"Diszkrét matematika I.":"Diszkrét matematika II."?> tárgy <?=$pending_teacher_group["subject_group"]?>. csoport esetében elbírálás alatt áll!</label>
        </div>
    <?php endforeach?>
    <?php foreach($pending_student_groups as $index => $pending_student_groups):?>
        <div id="notification_box">
            <label>
                A 
                <?php if($pending_student_groups["subject_name"]=="i"):?>
                    Diszkrét matematika I.
                <?php elseif($pending_student_groups["subject_name"]=="ii"):?>
                    Diszkrét matematika II.
                <?php endif?>
                tárgy <?=$pending_student_groups["subject_group"]?>. csoport-hoz való csatlakozási kérése elbírálás alatt áll!
            </label>
        </div>
    <?php endforeach?>
</div>