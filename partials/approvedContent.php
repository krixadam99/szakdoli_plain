<div id="notification_container">
    <?php foreach($approved_teacher_groups as $index => $approved_teacher_group):?>
        <div id="notification_box">
            <label>Demonstrátori kérése a <?=$approved_teacher_group["subject_name"]=="i"?"Diszkrét matematika I.":"Diszkrét matematika II."?> tárgy <?=$approved_teacher_group["subject_group"]?>. csoportjához elfogadásra került!</label>
        </div>
    <?php endforeach?>
    <?php foreach($approved_student_groups as $index => $approved_student_group):?>
        <div id="notification_box">
            <label>
                A 
                <?php if($approved_student_group["subject_name"]=="i"):?>
                    Diszkrét matematika I.
                <?php elseif($approved_student_group["subject_name"]=="ii"):?>
                    Diszkrét matematika II.
                <?php endif?>
                tárgy <?=$approved_student_group["subject_group"]?>. csoport-hoz való csatlakozási kérése elfogadásra került!
            </label>
        </div>
    <?php endforeach?>
</div>