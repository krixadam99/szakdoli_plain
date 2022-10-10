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
    
    <link href="./views/css/login_registration.css" rel="stylesheet" type="text/css">
    <title>Belépés</title>
</head>
<body>
    <?php if(isset($with_success_bar) && $with_success_bar):?>
        <div id="success_div">
            <label>Az új jelszót kilüdtük a <?=$email_address?> email címre!</label>
        </div>
    <?php endif?>

    <?php if(!isset($forgotten_password_page) || isset($forgotten_password_page) && !$forgotten_password_page):?>
        <form id="login_form" action="./index.php?site=validateLogin" method="POST">
            <input type="text" id="user_input" name="neptun_code" value="<?=$correct_parameters['neptun_code']??"Neptun kód"?>" placeholder="Neptun kód">
            <?php if(isset($incorrect_parameters)):?>
                <?php if(in_array("wrong_1_no_data",$incorrect_parameters)):?>
                    <label id="error_label">Adjon meg neptun kódot!</label>
                <?php elseif(in_array("wrong_1_no_neptun_code",$incorrect_parameters)):?>
                    <label id="error_label">Adjon meg létező neptun kódot!</label>
                <?php endif?>
            <?php endif?>


            <div class="password_row">
                <input type="text" id="user_password" name="user_password" value="Jelszó" placeholder="Jelszó">
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
                <label id="forgotten_password"><a href="./index.php?site=forgottenPassword">Elfelejtett jelszó</a></label>
                <label id="new_account"><a href="./index.php?site=register">Új fiók létrehozása</a></label>
            </div>

            <input type="submit" id="login_button" value="Belépés">
        </form>
    <?php else:?>
        <form id="forgotten_password_form" action="./index.php?site=validateForgottenPassword" method="POST">
            <div class="label_div">
                <label>
                    A jelszó kiküldéséhez adja meg a neptun kódját!
                </label>
            </div>
        
            <input type="text" id="user_input" name="neptun_code" value="<?=$correct_parameters['neptun_code']??"Neptun kód"?>" placeholder="Neptun kód">
            <?php if(isset($incorrect_parameters)):?>
                <?php if(in_array("wrong_1_no_data",$incorrect_parameters)):?>
                    <label id="error_label">Adjon meg neptun kódot!</label>
                <?php elseif(in_array("wrong_1_no_neptun_code",$incorrect_parameters)):?>
                    <label id="error_label">Adjon meg létező neptun kódot!</label>
                <?php endif?>
            <?php endif?>

            <input type="submit" id="submit_button" value="Új jelszó küldése">
        </form>
    <?php endif?>
    <button id="back_button">Vissza</button>
</body>
<script type="module" src="./views/js/login.js"></script>
</html>