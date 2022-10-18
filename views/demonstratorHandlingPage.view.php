<?php
    $pending_teachers = $this->GetPendingTeachers();
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
        <h1>Demonstrátorok kezelése</h1>
        <hr>
        <?php if(count($pending_teachers) != 0):?>
            <form id="pending_form" action="./index.php?site=finalizePending" method="POST">
                <table>
                    <tr>
                        <th>NEPTUN</th>
                        <th>TÁRGY</th>
                        <th>CSOPORT</th>
                        <th>DÖNTÉS</th>
                    </tr>
                    <?php foreach($pending_teachers as $index => $pending_user_information):?>
                        <tr>
                            <td><?=$pending_user_information["neptun_code"]?></td>
                            <td><?=$pending_user_information["subject_id"]=="i"?"Diszkrét matematika I.":"Diszkrét matematika II."?></td>
                            <td><?=$pending_user_information["subject_group"]?></td>
                            <td>
                                <select id="pending_select" name=<?=$pending_user_information["neptun_code"].":".$pending_user_information["subject_id"]."_".$pending_user_information["subject_group"]?>>
                                    <option selected>-</option>
                                    <option>ELFOGADÁS</option>
                                    <option>ELUTASÍTÁS</option>
                                </select>
                            </td>
                        </tr>
                    <?php endforeach?>
                </table>
                <button type="submit" class="finalize_button">VÉGLEGESÍTÉS</button>
            </form>
        <?php else:?>
            <div id="notification_box">
                <label>Nincsen elbírálás allatt álló tanár!</label>
            </div>
        <?php endif?>
    </main>
</body>
<script type="module" src="./views/js/mainContent.js"></script>
</html>