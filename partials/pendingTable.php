<form id="pending_form" action="./index.php?site=finalizePending" method="POST">
    <table>
        <tr>
            <th>NEPTUN</th>
            <th>TÁRGY</th>
            <th>CSOPORT</th>
            <th>DÖNTÉS</th>
        </tr>
        <?php foreach($pending_users as $index => $pending_user_information):?>
            <tr>
                <td><?=$pending_user_information["neptun_code"]?></td>
                <td><?=$pending_user_information["subject_name"]=="i"?"Diszkrét matematika I.":"Diszkrét matematika II."?></td>
                <td><?=$pending_user_information["subject_group"]?></td>
                <td>
                    <select id="pending_select" name=<?=$pending_user_information["neptun_code"].":".$pending_user_information["subject_name"]."_".$pending_user_information["subject_group"]?>>
                        <option selected>-</option>
                        <option>ELFOGADÁS</option>
                        <option>ELUTASÍTÁS</option>
                    </select>
                </td>
            </tr>
        <?php endforeach?>
    </table>
    <button type="submit" id="finalize_button">VÉGLEGESÍTÉS</button>
</form>