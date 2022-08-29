<?php foreach($_SESSION["task"]["sets"] as $set_name => $elements):?>
    <label class="task_label">
        <?=$set_name . " = { "?>
        <?php foreach($elements as $index => $element):?>
            <?=$index == 0?$element :", " . $element?>
        <?php endforeach?>
        <?=" }"?>
    </label>
    <br>
<?php endforeach?>
<br>
<label class="task_label">
    <?=" R \u{2286} A \u{00D7} B, R = { "?>
    <?php foreach($_SESSION["task"]["relation"] as $index => $pair):?>
        <?=$index==0?"(":", ("?><?=$pair[0] . ", " . $pair[1] . ")"?>
    <?php endforeach?>
    <?=" }"?>
</label>
<br>
<br>
<?php for($task_counter = 0; $task_counter < 6; $task_counter++):?>
    <div class="small_task_container">
        <label class="task_label">
            <?=$task_counter + 1?>. részfeladat:
            <?php if($task_counter == 0):?>
                Az R reláció értelmezési tartománya
            <?php elseif($task_counter == 1):?>
                Az R reláció értékkészlete
            <?php elseif($task_counter == 2):?>
                Az R reláció leszűkítése az N halmazra (itt (elem,elem) (pl.: (1,1), (1,2), ...) felsorolást írj)
            <?php elseif($task_counter == 3):?>
                Az R reláció inverze (itt is (elem,elem) (pl.: (1,1), (1,2), ...) felsorolást írj)
            <?php elseif($task_counter == 4):?>
                Az R reláció I halmazon felvett képe 
            <?php elseif($task_counter == 5):?>
                Az R reláció D halmazon felvett ősképe 
            <?php endif?>
        </label>
        <br>
        <?php include("./partials/solutionInput.php")?>
    </div>
<?php endfor?>