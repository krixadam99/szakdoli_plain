<?php for($topic_counter = 0; $topic_counter < 9; $topic_counter++):?>
    <?php for($subtopic_counter = 0; $subtopic_counter < count($sub_topics[$topic_counter]); $subtopic_counter++):?>
        <div class="pdf_page_task_choice_container big_exam_tasks" style="display:<?=isset($_SESSION["preview"]["main_topic_" . $topic_counter . "_subtopic_" . $subtopic_counter])?"":"none"?>" id="big_exam_task_<?=$topic_counter?>_<?=$subtopic_counter?>">
            <label>Kiválasztott főtéma: </label>
            <input value="<?=$main_topics[$topic_counter]?>" name="main_topic_<?=$topic_counter?>" style="width:24%; margin:0% 1% 0% 2%; border:0px; cursor:default; outline:none" readonly <?=isset($_SESSION["preview"]["main_topic_" . $topic_counter . "_subtopic_" . $subtopic_counter])?"":"disabled"?>>
            <label>Kiválasztott altéma: </label>
            <input value="<?=$sub_topics[$topic_counter][$subtopic_counter]?>" name="main_topic_<?=$topic_counter?>_subtopic_<?=$subtopic_counter?>" style="width:40%; margin:0% 0% 0% 2%; border:0px; cursor:default; outline:none" readonly <?=isset($_SESSION["preview"]["main_topic_" . $topic_counter . "_subtopic_" . $subtopic_counter])?"":"disabled"?>>
            <button class="big_exam_button remove_task_buttons">x</button>
        </div>
    <?php endfor?>
<?php endfor?>