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
        $merged_messages = array_merge($incame_messages, $sent_messages);
        $final_messages = [];
        foreach($merged_messages as $message_counter => $message){
            if($message["belongs_to"] == "0"){
                $final_messages[$message["message_id"]] = ["thread" => "0", "message" => $message];
            }else{
                if(!in_array($message["belongs_to"], array_keys($final_messages))){
                    $final_messages[$message["belongs_to"]] = ["thread" => $message["thread_count"], "message" => $message];
                }else{
                    if($message["thread_count"] > $final_messages[$message["belongs_to"]]["thread"]){
                        $final_messages[$message["belongs_to"]] = ["thread" => $message["thread_count"], "message" => $message];
                    }
                }
            }
        }

        var_dump($final_messages);
        
        $incame_messages = [];
        $sent_messages = [];
        foreach($final_messages as $message_main_id => $thread_message){
            $message = $thread_message["message"];
            if($message["neptun_code_from"] == $_SESSION["neptun_code"]){
                array_push($sent_messages, $message);
            }else{
                array_push($incame_messages, $message);
            }
        }

        var_dump($incame_messages,$incame_messages)
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
                <?php foreach($incame_messages as $message_counter => $message):?>
                    <?php if($message["belongs_to"] === "0"):?> <!-- First in the thread -->
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
                        </div>
                    <?php endif?>
                <?php endforeach?>
            </div>
            <div class="non_header_navigation_div" style="display:none">
                <?php foreach($sent_messages as $message_counter => $message):?>
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
                    </div>
                <?php endforeach?>
            </div>
            <div class="non_header_navigation_div" style="display:none">
                <?php foreach($romeved_messages as $message_counter => $message):?>
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
                <?php endforeach?>
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