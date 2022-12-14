<label class="pdf_page_task_choice_label" style="margin: auto 0% auto 5%">Altéma:</label>
<div class="subtopic_box" style="width:19%;margin: auto 0% auto 1%">
    <?php for($topic_counter = 0; $topic_counter < 9; $topic_counter++):?>
        <?php if(count($sub_topics[$topic_counter]) === 1):?>
            <input value="<?=$sub_topics[$topic_counter][0]?>" style="width:100%; display:<?=$topic_counter == $previous_chosen_topic?"inline":"none"?>" class="subtopic_select" id="subtopic_select_<?=$topic_counter?>" name="main_topic_<?=$topic_counter?>_subtopic_0" <?=$topic_counter != $previous_chosen_topic?"disabled=\"disabled\"":"readonly"?>>
        <?php elseif(count($sub_topics[$topic_counter]) > 1):?>
            <select class="subtopic_select" id="subtopic_select_<?=$topic_counter?>" style="width:100%; display:<?=$topic_counter == $previous_chosen_topic?"inline":"none"?>" name="main_topic_<?=$topic_counter?>_subtopic" <?=$topic_counter != $previous_chosen_topic?"disabled=\"disabled\"":""?>>
                    <?php for($subtopic_counter = 0; $subtopic_counter < count($sub_topics[$topic_counter]); $subtopic_counter++):?>
                        <?php 
                            $previous_chosen_subtopic = 0;
                            if(isset($_SESSION["preview"]["main_topic_" . $topic_counter . "_subtopic"])){
                                $previous_chosen_subtopic = $_SESSION["preview"]["main_topic_" . $topic_counter . "_subtopic"];
                            }
                        ?>
                        <option value="<?=$subtopic_counter?>" <?=$subtopic_counter == $previous_chosen_subtopic?"selected":""?>><?=$sub_topics[$topic_counter][$subtopic_counter]?></option>
                    <?php endfor?>
            </select>
        <?php endif?>
    <?php endfor?>
</div>