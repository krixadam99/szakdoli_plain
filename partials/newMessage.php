<form id="new_message_form" action="./index.php?site=<?=isset($_SESSION["message_id"])?"replyToMessage":"sendNewMessage"?>" method="POST">
    <div class="message_first_line">
        <div class="message_receiver_div">
            <?php if(!isset($_SESSION["message_id"])):?>
                <label class="message_label" style="margin: auto 2% auto 0%; ">
                    Add meg a címzettet!
                </label>
                <select class="receiver_selector" name="message_to">
                    <?php foreach($neptun_codes as $element_counter => $neptun_code):?>
                        <option <?=$element_counter===0?"selected":""?>>
                            <?=$neptun_code?>
                        </option>
                    <?php endforeach?>
                </select>
            <?php else:?>
                <label class="message_label" style="margin: auto 2% auto 0%; ">
                    Címzett: <?=$message["neptun_code_from"]===$_SESSION["neptun_code"]?$message["neptun_code_to"]:$message["neptun_code_from"]?>
                </label>
            <?php endif?>
        </div>
        <div class="message_topic_div">
            <label class="message_label" style="margin: auto 2% auto auto; ">
                Add meg az üzenet címét!
            </label>
            <textarea class="message_topic_textarea" placeholder="Üzenet témája..." value="Üzenet témája..." name="message_topic" rows="1"></textarea>
        </div>
    </div>
    <div class="message__div">
        <label class="message_label" style="margin: auto auto auto 0%; ">
            Add meg az üzenet szövegét!
        </label>
        <textarea class="message_text_textarea" placeholder="Üzenet szövege..." value="Üzenet szövege..." rows="10" name="message_text"></textarea>
    </div>
    <button type="submit" class="finalize_button">Küldés</button>
</form>