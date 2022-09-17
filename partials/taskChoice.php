<div class="pdf_page_task_choice_container">
    <label class="pdf_page_task_choice_label" style="margin: 0%">Főtéma:</label>
    <select class="topic_select" style="width:19%; margin:0% 0% 0% 1%" name="<?=$section_name?>_main_topic">
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

    <label class="pdf_page_task_choice_label" style="margin: 0% 0% 0% 5%">Altéma:</label>
    <?php for($topic_counter = 0; $topic_counter < 10; $topic_counter++):?>
        <select class="subtopic_select" style="width:19%; margin:0% 0% 0% 1%; display:<?=$topic_counter == $previous_chosen_topic?"inline":"none"?>" name="<?=$section_name?>_subtopic" <?=$topic_counter != $previous_chosen_topic?"disabled=\"disabled\"":""?>>
                <?php for($subtopic_counter = 0; $subtopic_counter < count($sub_topics[$topic_counter + 1]); $subtopic_counter++):?>
                    <?php 
                        $previous_chosen_subtopic = 0;
                        if(isset($_SESSION["preview"][$section_name . "_subtopic"])){
                            $previous_chosen_subtopic = $_SESSION["preview"][$section_name . "_subtopic"];
                        }
                    ?>
                    <option value="<?=$subtopic_counter?>" <?=$subtopic_counter == $previous_chosen_subtopic?"selected":""?>><?=$sub_topics[$topic_counter + 1][$subtopic_counter]?></option>
                <?php endfor?>
        </select>
    <?php endfor?>

    <label class="pdf_page_task_choice_label" style="width: 20%; margin: 0% 0% 0% 5%">Hány feladat legyen generálva:</label>
    <input type="number" min="1" max="20" step="1" placeholder="4" style="width:9%; margin:0% 0% 0% 1%" name="<?=$section_name?>_task_quantity" value="<?=isset($_SESSION["preview"][$section_name . "_task_quantity"])?$_SESSION["preview"][$section_name . "_task_quantity"]:"4"?>">
</div>