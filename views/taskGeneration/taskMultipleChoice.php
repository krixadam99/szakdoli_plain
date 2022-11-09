<div class="pdf_page_task_choice_container">
    <?php include("./partials/mainTopicSelect.php")?>
</div>
<div class="pdf_page_task_choice_container">
    <div class="subtopic_box" style="width:100%;margin:0%">
        <?php for($topic_counter = 0; $topic_counter < 9; $topic_counter++):?>
            <div style="width:100%; display:<?=$topic_counter == $previous_chosen_topic?:"none"?>">
                <?php if(count($sub_topics[$topic_counter]) === 1):?>
                    <label class="pdf_page_task_choice_label" style="width: 12%; margin: auto 2% auto 0%">Altéma:</label>
                    <input value="<?=$sub_topics[$topic_counter][0]?>" style="width:20%; display:<?=$topic_counter == $previous_chosen_topic?"inline":"none"?>" class="subtopic_input" name="main_topic_<?=$topic_counter?>_subtopic_0" <?=$topic_counter != $previous_chosen_topic?"disabled=\"disabled\"":"readonly"?>>
                    <label class="pdf_page_task_choice_label" style="width: 20%; margin: 0% 0% 0% 2%">Hány feladat legyen generálva:</label>
                    <input type="number" min="1" max="20" step="1" placeholder="4" style="width:9%; margin:0% auto 0% 1%" name="main_topic_<?=$topic_counter?>_subtopic_0_task_quantity" value="<?=isset($_SESSION["preview"]["main_topic_$topic_counter" . "_subtopic_0_task_quantity"])?$_SESSION["preview"]["main_topic_$topic_counter" . "_subtopic_0_task_quantity"]:"4"?>">
                <?php elseif(count($sub_topics[$topic_counter]) > 1):?>
                    <?php for($subtopic_counter = 0; $subtopic_counter < count($sub_topics[$topic_counter]); $subtopic_counter++):?>
                        <div style="display:flex; margin: 1% 0%">
                            <label class="pdf_page_task_choice_label" style="width: 12%; margin: auto 2% auto 0%">Altéma kiválasztása:</label>
                            
                            <input type="checkbox" name="main_topic_<?=$topic_counter?>_subtopic_<?=$subtopic_counter?>" style="width: auto" value="<?=$sub_topics[$topic_counter][$subtopic_counter]?>" 
                            <?=isset($_SESSION["preview"]["main_topic_$topic_counter" . "_subtopic_$subtopic_counter"]) && $topic_counter == $_SESSION["preview"]["main_topic"]??""?"checked":""?>>
                            
                            <label style="width: auto;margin: auto auto auto 1%"><?=$sub_topics[$topic_counter][$subtopic_counter]?></label>
                            <label class="pdf_page_task_choice_label" style="width: 20%; margin: 0% 0% 0% auto">Hány feladat legyen generálva:</label>
                            
                            <input type="number" min="1" max="20" step="1" placeholder="4" style="width:9%; margin:0% 0% 0% 1%" name="main_topic_<?=$topic_counter?>_subtopic_<?=$subtopic_counter?>_task_quantity" 
                            value="<?=isset($_SESSION["preview"]["main_topic_$topic_counter" . "_subtopic_$subtopic_counter" . "_task_quantity"]) && $topic_counter == $_SESSION["preview"]["main_topic"]??""?$_SESSION["preview"]["main_topic_$topic_counter" . "_subtopic_$subtopic_counter" . "_task_quantity"]:"4"?>">
                        </div>
                    <?php endfor?>
                <?php endif?>
            </div>
        <?php endfor?>
    </div>
</div>