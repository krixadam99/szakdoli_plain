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
<?php $operations = $_SESSION["task"]["operations"]??"";?>
<?php if($operations != ""):?>
    <?php for($task_counter = 0;$task_counter<10; $task_counter++):?>
        <div class="small_task_container">
            <label class="task_label">
                <?php if($task_counter%5 == 0):?>
                    <?=$task_counter + 1?>. részfeladat: <?=$operations["union"][$task_counter/5][0]?> <?="\u{222A}"?> <?=$operations["union"][$task_counter/5][1]?>
                <?php elseif($task_counter%5 == 1):?>
                    <?=$task_counter + 1?>. részfeladat: <?=$operations["intersection"][$task_counter/5][0]?> <?="\u{2229}"?> <?=$operations["intersection"][$task_counter/5][1]?>
                <?php elseif($task_counter%5 == 2):?>
                    <?=$task_counter + 1?>. részfeladat: <?=$operations["substraction"][$task_counter/5][0]?> <?="\\"?> <?=$operations["substraction"][$task_counter/5][1]?>
                <?php elseif($task_counter%5 == 3):?>
                    <?=$task_counter + 1?>. részfeladat: 
                    <span style="text-decoration: overline">
                        <?=$operations["complementer"][$task_counter/5][0]?>
                    </span>
                    , ha 
                    <?="U = { "?>
                    <?php foreach($operations["complementer"][$task_counter/5][1] as $index => $element):?>
                        <?=$index == 0?$element :", " . $element?>
                    <?php endforeach?>
                    <?=" }"?>
                <?php elseif($task_counter%5 == 4):?>
                    <?=$task_counter + 1?>. részfeladat: <?=$operations["symmetric difference"][$task_counter/5][0]?> <?="\u{0394}"?> <?=$operations["symmetric difference"][$task_counter/5][1]?>
                <?php endif?>
            </label>
            <br>
            <?php include("./partials/solutionInput.php")?>
        </div>
    <?php endfor?>
<?php endif?>