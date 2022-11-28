<form id="new_message_form" action="./index.php?site=<?=isset($_SESSION["message_id"])?"replyToMessage":"sendNewMessage"?>" method="POST">
    <input type="hidden" name="token" value="<?=$form_token?>">

    <div class="message_first_line">
        <div class="message_receiver_div">
            <?php if(!isset($_SESSION["message_id"])):?>
                <label class="message_label" style="margin: auto 2% auto 0%; ">
                    Adja meg a címzettet!
                </label>
                <select class="receiver_selector" name="message_to">
                    <?php foreach($neptun_codes as $element_counter => $neptun_code):?>
                        <?php if($_SESSION["neptun_code"] !== $neptun_code):?>
                            <option <?=$element_counter===0?"selected":""?>>
                                <?=$neptun_code?>
                            </option>
                        <?php endif?>
                    <?php endforeach?>
                </select>
                <?php if(isset($incorrect_parameters)):?>
                    <?php if(in_array('message_to',$error_params)):?>
                        <label class="error_label"><?=$incorrect_parameters["message_to"]?></label>
                    <?php endif?>
                <?php endif?>
            <?php else:?>
                <label class="message_label" style="margin: auto 2% auto 0%; ">
                    Címzett: <?=$message["neptun_code_from"]===$_SESSION["neptun_code"]?$message["neptun_code_to"]:$message["neptun_code_from"]?>
                </label>
            <?php endif?>
        </div>
        <div class="message_topic_div">
            <label class="message_label" style="margin: auto 2% auto auto; ">
                Adja meg az üzenet tárgyát!
            </label>
            <textarea class="message_topic_textarea" placeholder="Üzenet tárgy..." value="<?=$correct_parameters["message_topic"]??"Üzenet tárgya..."?>" name="message_topic" rows="1"><?=$correct_parameters["message_topic"]??""?></textarea>
            <?php if(isset($incorrect_parameters)):?>
                <?php if(in_array('message_topic',$error_params)):?>
                    <label class="error_label"><?=$incorrect_parameters["message_topic"]?></label>
                <?php endif?>
            <?php endif?>
        </div>
    </div>
    <div class="message__div">
        <label class="message_label" style="margin: auto auto auto 0%; ">
            Adja meg az üzenet szövegét!
        </label>
        <textarea class="message_text_textarea" placeholder="Üzenet szövege..." value="<?=$correct_parameters["message_text"]??"Üzenet szövege..."?>" rows="10" name="message_text"><?=$correct_parameters["message_text"]??""?></textarea>
        <?php if(isset($incorrect_parameters)):?>
            <?php if(in_array('message_text',$error_params)):?>
                <label class="error_label"><?=$incorrect_parameters["message_text"]?></label>
            <?php endif?>
        <?php endif?>
    </div>
    <button type="submit" class="finalize_button">Küldés</button>
</form>