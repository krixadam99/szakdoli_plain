<?php
    $form_token = $this->GetFormToken();

    $incorrect_parameters = $this->GetIncorrectParameters();
    $correct_parameters = $this->GetCorrectParameters();
    $error_params = array_keys($incorrect_parameters);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./views/css/header.css" rel="stylesheet" type="text/css">
    <link href="./views/css/body.css" rel="stylesheet" type="text/css">
    <link href="./views/css/messages.css" rel="stylesheet" type="text/css">
    <title>Üzenetek</title>
</head>
<body>
    <?php include("./partials/header.php")?>
    <?php if(!isset($_SESSION["write_message"])):?>
        <?php if(!isset($_SESSION["message_id"])):?>
            <div id="non_header_navigation_row" style="margin: 2% 4% 6% 4%;">
                <div class="non_header_navigation_row_button <?=$_SESSION["message_type"] === "received"?"chosen":""?>" id="inbox_button">
                    <label>Beérkező levelek</label>
                </div>
                <div class="non_header_navigation_row_button <?=$_SESSION["message_type"] === "sent"?"chosen":""?>" id="sent_button">
                    <label>Elküldött levelek</label>
                </div>
                <div class="non_header_navigation_row_button <?=$_SESSION["message_type"] === "deleted"?"chosen":""?>" id="deleted_button">
                    <label>Törölt levelek</label>
                </div>
            </div>

            <?php if($_SESSION["message_type"] === "received"):?>
                <form id="delete_incame_messages" action="./index.php?site=deleteMessages" method="POST">
                    <input type="hidden" name="token" value="<?=$form_token?>">

                    <?php foreach($incame_messages as $message_counter => $incame_message):?>
                        <?php
                            $actual_thread_count = $incame_message["thread_count"];
                        ?>
                        <div class="message_and_bubble_holder">
                            <div class="remove_message_bubble">
                                <input type="checkbox" class="remove_message_bubble_input" name="<?=$incame_message["message_id"]?>">
                            </div>
                            <div class="message_container <?=$incame_message["is_seen_by_receiver"] === "0"?"not_seen":"seen"?> clickable_message" id="<?=$incame_message["message_id"]?>">
                                <div class="message_from">
                                    Feladó: <?= $incame_message["neptun_code_from"]?>
                                </div>
                                <div class="message_separator"></div>
                                <div class="message_topic">
                                    Üzenet tárgya: <?= $incame_message["message_topic"]?>
                                </div>
                                <div class="message_separator"></div>
                                <div class="message_text">
                                    Üzenet részlet: <?=$incame_message["message_text"]?>
                                </div>
                                <div class="message_separator"></div>
                                <div class="message_date">
                                    Legutolsó üzenet elküldve: <?=$incame_message["sent_at"]?>
                                </div>
                                <div class="thread_count_bubble">
                                    <?=$actual_thread_count?>.
                                </div>
                            </div>
                        </div>
                    <?php endforeach?>
                    <div id="remove_selected_elements" style="cursor:pointer; display:none">
                        <img src="./views/css/pics/garbage.png" alt="remove selected elements" width="60%" height="80%" style="margin:10% 20%">    
                        <input type="submit" hidden>
                    </div>
                </form>
            <?php elseif($_SESSION["message_type"] === "sent"):?>
                <form id="delete_sent_messages" action="./index.php?site=deleteMessages" method="POST">
                    <input type="hidden" name="token" value="<?=$form_token?>">

                    <?php foreach($sent_messages as $message_counter => $sent_message):?>
                        <?php
                            $actual_thread_count = $sent_message["thread_count"];
                        ?>
                        <div class="message_and_bubble_holder">
                            <div class="remove_message_bubble">
                                <input type="checkbox" class="remove_message_bubble_input" name="<?=$sent_message["message_id"]?>">
                            </div>
                            <div class="message_container seen clickable_message" id="<?=$sent_message["message_id"]?>">
                                <div class="message_to">
                                    Címzett: <?= $sent_message["neptun_code_to"]?>
                                </div>
                                <div class="message_separator"></div>
                                <div class="message_topic">
                                    Üzenet tárgya: <?= $sent_message["message_topic"]?>
                                </div>
                                <div class="message_separator"></div>
                                <div class="message_text">
                                    Üzenet részlet: <?=$sent_message["message_text"]?>
                                </div>
                                <div class="message_separator"></div>
                                <div class="message_date">
                                    Legutolsó üzenet elküldve: <?=$sent_message["sent_at"]?>
                                </div>
                                <div class="thread_count_bubble">
                                    <?=$actual_thread_count?>.
                                </div>
                            </div>
                        </div>
                    <?php endforeach?>
                    <div id="remove_selected_elements" style="cursor:pointer; display:none">
                        <img src="./views/css/pics/garbage.png" alt="remove selected elements" width="60%" height="80%" style="margin:10% 20%">    
                        <input type="submit" hidden>
                    </div>
                </form>
            <?php elseif($_SESSION["message_type"] === "deleted"):?>
                <form id="recover__deleted_messages" action="./index.php?site=recoverDeletedMessages" method="POST">    
                    <input type="hidden" name="token" value="<?=$form_token?>">

                    <?php foreach($removed_messages as $message_counter => $removed_message):?>
                        <div class="message_and_bubble_holder">
                            <div class="check_message_bubble">
                                <input type="checkbox" class="check_message_bubble_input" name="<?=$removed_message["message_id"]?>">
                            </div>
                            <div class="message_container seen not_clickable_message" id="<?=$removed_message["message_id"]?>">
                                <div class="message_to">
                                    Címzett: <?= $removed_message["neptun_code_to"]?>
                                </div>
                                <div class="message_separator"></div>
                                <div class="message_topic">
                                    Üzenet tárgya: <?= $removed_message["message_topic"]?>
                                </div>
                                <div class="message_separator"></div>
                                <div class="message_text">
                                    Üzenet részlet: <?=$removed_message["message_text"]?>
                                </div>
                                <div class="message_separator"></div>
                                <div class="message_date">
                                    Legutolsó üzenet elküldve: <?=$removed_message["sent_at"]?>
                                </div>
                            </div>
                        </div>
                        <div id="recover_selected_elements" style="cursor:pointer; display:none">
                            <img src="./views/css/pics/recover_deleted_messages.png" alt="a recovery icon" width="60%" height="80%" style="margin:10% 20%">    
                            <input type="submit" hidden>
                        </div>
                    <?php endforeach?>
                </form>  
            <?php endif?>
            <div id="write_message_button" style="cursor:pointer">
                <img src="./views/css/pics/write_message.png" alt="write a message" width="60%" height="80%" style="margin:10% 20%">
            </div>
            <div class="pagination_button_row">
                <?php if($actual_page >= 4):?>
                    <div class="pagination_bubble" id="page_1">
                        <label>1</label>
                    </div>
                <?php endif?>
                <?php if($actual_page > 4):?>
                    <div class="pagination_bubble" id="page_<?=ceil(($actual_page + 1) / 2)?>">
                        <label>...</label>
                    </div>
                <?php endif?>
                <?php for($page_counter = $actual_page - 2; $page_counter <= $actual_page + 2 && $page_counter <= $maximum_number_of_page; $page_counter++):?>
                    <?php if($page_counter > 0):?>
                        <div class="pagination_bubble <?=$page_counter == $actual_page?"chosen_pagination_bubble":""?>" id="page_<?=$page_counter?>">
                            <label><?=$page_counter?></label>
                        </div>
                    <?php endif?>
                <?php endfor?>
                <?php if($maximum_number_of_page - $actual_page > 3):?>
                    <div class="pagination_bubble" id="page_<?=ceil(($actual_page + $maximum_number_of_page) / 2)?>">
                        <label>...</label>
                    </div>
                <?php endif?>
                <?php if($actual_page < $maximum_number_of_page - 2):?>
                    <div class="pagination_bubble" id="page_<?=$maximum_number_of_page?>">
                        <label><?=$maximum_number_of_page?></label>
                    </div>
                <?php endif?>
            </div>
        <?php else:?>
            <?php foreach($messages_belonging_to_message_id as $message_counter => $message):?>
                <div class="expandable_message_container" id="message_container_<?=$message["message_id"]?>_<?=$message["thread_count"]?>">
                    <div class="message_from">
                        <label>
                            Feladó: <?=$message["neptun_code_from"]===$_SESSION["neptun_code"]?"Én":$message["neptun_code_from"]?>
                        </label>
                    </div>
                    <div class="message_separator"></div>
                    <div class="message_to">
                        <label>
                            Címzett: <?=$message["neptun_code_to"]===$_SESSION["neptun_code"]?"Én":$message["neptun_code_to"]?>
                        </label>
                    </div>
                    <div class="message_separator"></div>
                    <div class="message_topic">
                        <label>
                            <b>Üzenet tárgya: <?= $message["message_topic"]?></b>
                        </label>
                    </div>
                    <div class="message_separator"></div>
                    <div class="message_text">
                        <label>
                            <?=$message["message_text"]?>
                        </label>
                    </div>
                    <div class="message_separator"></div>
                    <div class="message_date">
                        <label>
                            Üzenet elküldve: <?=$message["sent_at"]?>
                        </label>
                    </div>
                </div>
                <div class="message_container_expanded" id="expanded_container_<?=$message["message_id"]?>_<?=$message["thread_count"]?>" style="display:none">
                    <div>
                        <label>
                            Feladó: <?=$message["neptun_code_from"]===$_SESSION["neptun_code"]?"Én":$message["neptun_code_from"]?>
                        </label>
                    </div>
                    <div>
                        <label>
                            Címzett: <?=$message["neptun_code_to"]===$_SESSION["neptun_code"]?"Én":$message["neptun_code_to"]?>
                        </label>
                    </div>
                    <div>
                        <label>
                            <b>Üzenet tárgya: <?= $message["message_topic"]?></b>
                        </label>
                    </div>
                    <div>
                        <label>
                            Üzenet elküldve: <?=$message["sent_at"]?>
                        </label>
                    </div>
                    <div>
                        <label>
                            <?=$message["message_text"]?>
                        </label>
                    </div>
                </div>
            <?php endforeach?>
            <?php if($messages_belonging_to_message_id[0]["is_removed_by_receiver"] !== "1" && $messages_belonging_to_message_id[0]["is_removed_by_sender"] !== "1"):?>
                <div id="reply_div" style="display:none">
                    <?php include("./partials/newMessage.php")?>
                </div>
                <button id="reply_button">Válasz</button>
            <?php else:?>
                <div class="notification_box">
                    <label>Nem tud válaszolni az üzenetre!</label>
                </div>
            <?php endif?>
        <?php endif?>
    <?php else:?>
        <?php include("./partials/newMessage.php")?>
    <?php endif?>

    <script type="module" src="./views/js/mainContent.js"></script>
    <script type="module" src="./views/js/messages.js"></script>
</body>
</html>