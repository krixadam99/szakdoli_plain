<div class="pdf_page_task_choice_container">
    <label class="pdf_page_task_choice_label" style="margin: 0%;width:auto">Főtéma kiválasztása:</label>
    <select class="topic_select" style="width:19%; margin:0% auto 0% 2%" name="<?=$section_name?>_main_topic">
        <?php for($topic_counter = 0; $topic_counter < 10; $topic_counter++):?>
            <?php 
                $previous_chosen_topic = 0;
                if(isset($_SESSION["preview"][$section_name . "_main_topic"])){
                    $previous_chosen_topic = $_SESSION["preview"][$section_name . "_main_topic"];
                }
            ?>
            <option value="<?=$topic_counter?>" <?=$topic_counter == $previous_chosen_topic?"selected":""?>><?=$main_topics[$topic_counter]?></option>
        <?php endfor?>
    </select>
</div>
<div class="pdf_page_task_choice_container">
    <div class="subtopic_box" style="width:100%;margin:0%">
        <?php for($topic_counter = 0; $topic_counter < 10; $topic_counter++):?>
            <?php 
                $section_subtopic_counter = 0;
                $section_name = "task_$section_subtopic_counter";
            ?>
            <div style="width:100%; display:<?=$topic_counter == $previous_chosen_topic?:"none"?>">
                <?php if(count($sub_topics[$topic_counter]) === 1):?>
                    <label class="pdf_page_task_choice_label" style="width: 12%; margin: auto 2% auto 0%">Altéma:</label>
                    <input value="<?=$sub_topics[$topic_counter][0]?>" style="width:20%; display:<?=$topic_counter == $previous_chosen_topic?"inline":"none"?>" class="subtopic_input" name="<?=$section_name?>_subtopic" <?=$topic_counter != $previous_chosen_topic?"disabled=\"disabled\"":"readonly"?>>
                    <label class="pdf_page_task_choice_label" style="width: 20%; margin: 0% 0% 0% 2%">Hány feladat legyen generálva:</label>
                    <input type="number" min="1" max="20" step="1" placeholder="4" style="width:9%; margin:0% auto 0% 1%" name="<?=$section_name?>_task_quantity" value="<?=isset($_SESSION["preview"][$section_name . "_task_quantity"])?$_SESSION["preview"][$section_name . "_task_quantity"]:"4"?>">
                <?php elseif(count($sub_topics[$topic_counter]) > 1):?>
                    <?php for($subtopic_counter = 0; $subtopic_counter < count($sub_topics[$topic_counter]); $subtopic_counter++):?>
                        <div style="display:flex; margin: 1% 0%">
                            <label class="pdf_page_task_choice_label" style="width: 12%; margin: auto 2% auto 0%">Altéma kiválasztása:</label>
                            <input type="checkbox" name="<?=$section_name?>_subtopic" style="width: auto" value="<?=$sub_topics[$topic_counter][$subtopic_counter]?>">
                            <label style="width: auto;margin: auto auto auto 1%"><?=$sub_topics[$topic_counter][$subtopic_counter]?></label>
                            <label class="pdf_page_task_choice_label" style="width: 20%; margin: 0% 0% 0% auto">Hány feladat legyen generálva:</label>
                            <input type="number" min="1" max="20" step="1" placeholder="4" style="width:9%; margin:0% 0% 0% 1%" name="<?=$section_name?>_task_quantity" value="<?=isset($_SESSION["preview"][$section_name . "_task_quantity"])?$_SESSION["preview"][$section_name . "_task_quantity"]:"4"?>">
                        </div>
                        <?php 
                            $section_subtopic_counter++;
                            $section_name = "task_$section_subtopic_counter";
                        ?>
                    <?php endfor?>
                <?php endif?>
            </div>

        <?php endfor?>
    </div>
</div>