<?php foreach($_SESSION["task"]["set_of_sets"] as $subtask_counter => $actual_sets):?>
    <div class="task_data">
        <label class="task_label">Adottak a következő halmazok:</label>
        <?php foreach($actual_sets as $set_name => $set_elements):?>
            <label class="task_label">
                <?= PrintServices::CreatePrintableSet($set_name, $set_elements)?>
            </label>
        <?php endforeach?> 
    </div>
    <?php $operation_counter = 0?>
    <?php foreach($_SESSION["task"]["operations"][$subtask_counter] as $operation_name => $operation):?>
        <?php $task_counter = $subtask_counter . "_" . $operation_counter?>
        <?php $counter_text = $subtask_counter + 1 . "." . $operation_counter + 1?>
        <div class="small_task_container">
            <label class="task_label">
                <?php if($operation_name === "union"):?>
                    <?=$counter_text?>. részfeladat: <?=$operation[$operation_counter/5][0]?> <?="\u{222A}"?> <?=$operation[$operation_counter/5][1]?>
                <?php elseif($operation_name === "intersection"):?>
                    <?=$counter_text?>. részfeladat: <?=$operation[$operation_counter/5][0]?> <?="\u{2229}"?> <?=$operation[$operation_counter/5][1]?>
                <?php elseif($operation_name === "substraction"):?>
                    <?=$counter_text?>. részfeladat: <?=$operation[$operation_counter/5][0]?> <?="\\"?> <?=$operation[$operation_counter/5][1]?>
                <?php elseif($operation_name === "complementer"):?>
                    <?=$counter_text?>. részfeladat: 
                    <span style="text-decoration: overline">
                        <?=$operation[$operation_counter/5][0]?>
                    </span>
                    , ha 
                    <?="U = { "?>
                    <?php foreach($operation[$operation_counter/5][1] as $index => $element):?>
                        <?=$index == 0?$element :", " . $element?>
                    <?php endforeach?>
                    <?=" }"?>
                <?php elseif($operation_name === "symmetric difference"):?>
                    <?=$counter_text?>. részfeladat: <?=$operation[$operation_counter/5][0]?> <?="\u{0394}"?> <?=$operation[$operation_counter/5][1]?>
                <?php endif?>
            </label>
            <?php include("./views/taskContents/solutionInput.php")?>
        </div>
        <?php $operation_counter++?>
    <?php endforeach?>
<?php endforeach?>