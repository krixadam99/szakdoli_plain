<label class="pdf_page_task_choice_label" style="margin: auto 0%;width:auto">Főtéma kiválasztása:</label>
<select class="topic_select" style="width:19%; margin-left: 1%" name="main_topic">
    <?php for($topic_counter = 0; $topic_counter < 9; $topic_counter++):?>
        <?php 
            $previous_chosen_topic = 0;
            if(isset($_SESSION["preview"]["main_topic"])){
                $previous_chosen_topic = $_SESSION["preview"]["main_topic"];
            }
        ?>
        <option value="<?=$topic_counter?>" <?=$topic_counter == $previous_chosen_topic?"selected":""?>><?=$main_topics[$topic_counter]?></option>
    <?php endfor?>
</select>