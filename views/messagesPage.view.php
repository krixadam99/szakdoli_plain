<?php

    $messages_belonging_to_message_id = [];
    if(isset($_SESSION["message_id"])){
        $message_id = $_SESSION["message_id"];
        
        $is_altered = false;
        foreach($incame_messages as $message_counter => $message){
            if($message["message_id"] === $message_id && $message["belongs_to"] != 0){
                $message_id = $message["belongs_to"];
                $is_altered = true;
                break;
            }
        }
        if(!$is_altered){
            foreach($sent_messages as $message_counter => $message){
                if($message["message_id"] === $message_id && $message["belongs_to"] != 0){
                    $message_id = $message["belongs_to"];
                    $is_altered = true;
                    break;
                }
            }
        }
        $_SESSION["message_id"] = $message_id;
        
        
        // Collect all of the messages belonging to the given message id
        foreach($incame_messages as $message_counter => $message){
            if($message["belongs_to"] === $message_id || $message["message_id"] === $message_id && $message["belongs_to"] == 0){
                $messages_belonging_to_message_id[$message["thread_count"]] = $message;
            }
        }
        foreach($sent_messages as $message_counter => $message){
            if($message["belongs_to"] === $message_id || $message["message_id"] === $message_id && $message["belongs_to"] == 0){
                $messages_belonging_to_message_id[$message["thread_count"]] = $message;
            }
        }
        ksort($messages_belonging_to_message_id);
        //var_dump($messages_belonging_to_message_id);

        if(count($messages_belonging_to_message_id) !== 0){
            $_SESSION["thread_count_new"] = count($messages_belonging_to_message_id);
            $first_message = $messages_belonging_to_message_id[0];
            if($first_message["neptun_code_from"] === $_SESSION["neptun_code"]){
                $_SESSION["neptun_code_to"] = $first_message["neptun_code_to"];
            }else{
                $_SESSION["neptun_code_to"] = $first_message["neptun_code_from"];
            }

            if(     $first_message["neptun_code_from"] === $_SESSION["neptun_code"] && $first_message["is_removed_by_sender"] == "1"
                ||  $first_message["neptun_code_from"] !== $_SESSION["neptun_code"] && $first_message["is_removed_by_receiver"] == "1"){
                    header("Location: ./index.php?site=messages");
            }
        }else{
            header("Location: ./index.php?site=messages");
        }
    }else{
        if(!isset($_SESSION["write_message"])){
            $merged_messages = array_merge($incame_messages, $sent_messages);
            $final_messages = [];
    
            foreach($merged_messages as $message_counter => $message){
                if($message["belongs_to"] == "0"){
                    if(!in_array($message["message_id"], array_keys($final_messages))){
                        $final_messages[$message["message_id"]] = ["thread" => 0, "message" => $message];
                    }
                }else{
                    if(!in_array($message["belongs_to"], array_keys($final_messages))){
                        $final_messages[$message["belongs_to"]] = ["thread" => intval($message["thread_count"]), "message" => $message];
                    }else{
                        if(intval($message["thread_count"]) > $final_messages[$message["belongs_to"]]["thread"]){
                            
                            $final_messages[$message["belongs_to"]] = ["thread" => intval($message["thread_count"]), "message" => $message];
                        }
                    }
                }
            }
            
            $incame_messages = [];
            $sent_messages = [];
            foreach($final_messages as $message_main_id => $thread_message){
                $message = $thread_message["message"];
                $thread_count = $thread_message["thread"];
                if($message["neptun_code_from"] == $_SESSION["neptun_code"]){
                    array_push($sent_messages, ["message" => $message, "thread_count" =>$thread_count]);
                }else{
                    array_push($incame_messages, ["message" => $message, "thread_count" =>$thread_count]);
                }
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./views/css/header.css" rel="stylesheet" type="text/css">
    <link href="./views/css/body.css" rel="stylesheet" type="text/css">
    <title>Üzenetek</title>
</head>
<body>
    <?php include("./partials/header.php")?>
    <?php if(!isset($_SESSION["write_message"])):?>
        <?php if(!isset($_SESSION["message_id"])):?>
            <div id="non_header_navigation_row" style="margin: 2% 4% 6% 4%;">
                <div class="non_header_navigation_row_button chosen" id="inbox_button">
                    <label>Beérkező levelek</label>
                </div>
                <div class="non_header_navigation_row_button" id="sent_button">
                    <label>Elküldött levelek</label>
                </div>
                <div class="non_header_navigation_row_button" id="deleted_button">
                    <label>Törölt levelek</label>
                </div>
            </div>

            <div class="non_header_navigation_div">
                <form id="delete_incame_messages" action="./index.php?site=deleteMessages" method="POST">
                    <?php foreach($incame_messages as $message_counter => $message_thread_pair):?>
                        <?php
                            $message = $message_thread_pair["message"];
                            $actual_thread_count = $message_thread_pair["thread_count"] + 1;
                        ?>
                        <div class="message_and_bubble_holder">
                            <div class="remove_message_bubble">
                                <input type="checkbox" class="remove_message_bubble_input" name="<?=$message["message_id"]?>">
                            </div>
                            <div class="message_container <?=$message["is_seen_by_receiver"] === "0"?"not_seen":"seen"?> clickable_message" id="<?=$message["message_id"]?>">
                                <div class="message_from">
                                    Feladó: <?= $message["neptun_code_from"]?>
                                </div>
                                <div class="message_separator"></div>
                                <div class="message_topic">
                                    Tárgy: <?= $message["message_topic"]?>
                                </div>
                                <div class="message_separator"></div>
                                <div class="message_text">
                                    Üzenet részlet: <?=$message["message_text"]?>
                                </div>
                                <div class="thread_count_bubble">
                                    <?=$actual_thread_count?>.
                                </div>
                            </div>
                        </div>
                    <?php endforeach?>
                    <div class="remove_selected_elements" style="cursor:pointer; display:none">
                        <img src="./views/css/pics/garbage.png" alt="remove selected elements" width="60%" height="80%" style="margin:10% 20%">    
                        <input type="submit" hidden>
                    </div>
                </form>
            </div>
            <div class="non_header_navigation_div" style="display:none">
                <form id="delete_sent_messages" action="./index.php?site=deleteMessages" method="POST">
                    <?php foreach($sent_messages as $message_counter => $message_thread_pair):?>
                        <?php
                            $message = $message_thread_pair["message"];
                            $actual_thread_count = $message_thread_pair["thread_count"] + 1;
                        ?>
                        <div class="message_and_bubble_holder">
                            <div class="remove_message_bubble">
                                <input type="checkbox" class="remove_message_bubble_input" name="<?=$message["message_id"]?>">
                            </div>
                            <div class="message_container seen clickable_message" id="<?=$message["message_id"]?>">
                                <div class="message_to">
                                    Címzett: <?= $message["neptun_code_to"]?>
                                </div>
                                <div class="message_separator"></div>
                                <div class="message_topic">
                                    Tárgy: <?= $message["message_topic"]?>
                                </div>
                                <div class="message_separator"></div>
                                <div class="message_text">
                                    Üzenet részlet: <?=$message["message_text"]?>
                                </div>
                                <div class="thread_count_bubble">
                                    <?=$actual_thread_count?>.
                                </div>
                            </div>
                        </div>
                    <?php endforeach?>
                    <div class="remove_selected_elements" style="cursor:pointer; display:none">
                        <img src="./views/css/pics/garbage.png" alt="remove selected elements" width="60%" height="80%" style="margin:10% 20%">    
                        <input type="submit" hidden>
                    </div>
                </form>    
            </div>
            <div class="non_header_navigation_div" style="display:none">
                <form id="recover__deleted_messages" action="./index.php?site=recoverDeletedMessages" method="POST">    
                    <?php foreach($removed_messages as $message_counter => $message):?>
                        <?php if($message["thread_count"] == "0"):?>
                            <div class="message_and_bubble_holder">
                                <div class="check_message_bubble">
                                    <input type="checkbox" class="check_message_bubble_input" name="<?=$message["message_id"]?>">
                                </div>
                                <div class="message_container seen not_clickable_message" id="<?=$message["message_id"]?>">
                                    <div class="message_to">
                                        Címzett: <?= $message["neptun_code_to"]?>
                                    </div>
                                    <div class="message_separator"></div>
                                    <div class="message_topic">
                                        Tárgy: <?= $message["message_topic"]?>
                                    </div>
                                    <div class="message_separator"></div>
                                    <div class="message_text">
                                        Üzenet részlet: <?=$message["message_text"]?>
                                    </div>
                                </div>
                            </div>
                        <?php endif?>
                        <div class="recover_selected_elements" style="cursor:pointer; display:none">
                            <img src="./views/css/pics/garbage.png" alt="a recovery icon" width="60%" height="80%" style="margin:10% 20%">    
                            <input type="submit" hidden>
                        </div>
                    <?php endforeach?>
                </form>  
            </div>
            <div id="write_message_button" style="cursor:pointer">
                <img src="./views/css/pics/write_message.png" alt="write a message" width="60%" height="80%" style="margin:10% 20%">
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
                            <b>Cím: <?= $message["message_topic"]?></b>
                        </label>
                    </div>
                    <div class="message_separator"></div>
                    <div class="message_text">
                        <label>
                            <?=$message["message_text"]?>
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
                            <b>Cím: <?= $message["message_topic"]?></b>
                        </label>
                    </div>
                    <div>
                        <label>
                            <?=$message["message_text"]?>
                        </label>
                    </div>
                </div>
            <?php endforeach?>
            <div id="reply_div" style="display:none">
                <?php include("./partials/newMessage.php")?>
            </div>
            <button id="reply_button">Válasz</button>
        <?php endif?>
    <?php else:?>
        <?php include("./partials/newMessage.php")?>
    <?php endif?>

    <script type="module" src="./views/js/mainContent.js"></script>
    <script type="module" src="./views/js/nonHeaderNavigation.js"></script>
    <script type="module" src="./views/js/messages.js"></script>
</body>
</html>