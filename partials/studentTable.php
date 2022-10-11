<form id="student_handling_form" action="./index.php?site=studentHandling" method="POST">
    <?php if(count($students) != 0):?>
        <table>
            <tr id="header_row">
                <th>NEPTUN</th>
                <th>TÁRGY</th>
                <th>CSOPORT</th>
                <th>DÖNTÉS</th>
            </tr>
            <?php foreach($students as $index => $student):?>
                <?php if($student["application_request_status"] !== "WITHDRAWN"):?>
                    <tr id=<?=$student["subject_group"]?>>
                    <td><?=$student["neptun_code"]?></td>
                    <td><?=$student["subject_name"]=="i"?"Diszkrét matematika I.":"Diszkrét matematika II."?></td>
                    <td><?=$student["subject_group"]?></td>
                    <td>
                        <select id="student_handling_select" name=<?=$student["neptun_code"]?>>
                            <?php if($student["application_request_status"] === "PENDING"):?>
                                <option selected>-</option>
                                <option >ELFOGADÁS</option>
                                <option>ELUTASÍTÁS</option>
                            <?php elseif($student["application_request_status"] === "APPROVED"):?>
                                <option selected>-</option>
                                <option>TÖRLÉS</option>
                            <?php elseif($student["application_request_status"] === "DENIED"):?>
                                <option selected>-</option>
                                <option>VISSZAVÉTEL</option>
                            <?php endif?>
                        </select>
                    </td>
                </tr>
                <?php endif?>
            <?php endforeach?>
        </table>
        <button type="submit" id="finalize_button">VÉGLEGESÍTÉS</button>
    <?php else:?>
        <div id="notification_box">
            <label>Nincsen diák a <?=$_SESSION['subject']=="i"?"Diszkrét matematika I.":"Diszkrét matematika II."?> tárgy <?=$_SESSION['group']?> csoportjában!</label>
        </div>
    <?php endif?>
</form>