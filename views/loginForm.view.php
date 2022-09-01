<?php

    $incorrect_parameters = $this->GetIncorrectParameters();
    $correct_parameters = $this->GetCorrectParameters();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./views/css/login.css" rel="stylesheet" type="text/css">
    <title>Belépés</title>
</head>
<body>
    <form id="login_form" action="./index.php?site=validateLogin" method="POST">
        <input type="text" id="user_input" name="neptun_code" value="<?=$correct_parameters['neptun_code']??"Neptun kód"?>">
        <?php if(isset($incorrect_parameters)):?>
            <?php if(in_array("wrong_1_no_data",$incorrect_parameters)):?>
                <label id="error_label">Adjon meg neptun kódot!</label>
            <?php elseif(in_array("wrong_1_no_neptun_code",$incorrect_parameters)):?>
                <label id="error_label">Adjon meg létező neptun kódot!</label>
            <?php endif?>
        <?php endif?>


        <div class="password_row">
            <input type="text" id="user_password" name="user_password" value="Jelszó">
            <input  type="image" id="show_password_image" src="./views/css/pics/opened_eye.png" alt="password hidden" width="100%" height="100%">
        </div>
        <?php if(isset($incorrect_parameters)):?>
            <?php if(in_array("wrong_2_no_password", $incorrect_parameters)):?>
                <label id="error_label">Adjon meg jelszót!</label>
            <?php elseif(in_array("wrong_2_not_same", $incorrect_parameters)):?>
                <label id="error_label">A jelszó nem megfelelő!</label>
            <?php endif?>
        <?php endif?>

        
        <div id="misc_holder">
            <label id="forgotten_password"><a>Elfelejtett jelszó</a></label>
            <label id="new_account"><a href="./index.php?site=register">Új fiók létrehozása</a></label>
        </div>

        <input type="submit" id="login_button" value="Belépés">
    </form>
<button id="back_button">Vissza</button>
</body>
<script type="module" src="./views/js/login.js"></script>
</html>