<?php foreach($_SESSION["task"]["sets"] as $counter => $actual_sets):?>
    <?php foreach($actual_sets as $set_name => $set_elements):?>
        <?php if($set_name !== "B" || count(array_diff($actual_sets["A"],$actual_sets["B"]))!==0):?>
            <label class="task_label">
                <?= PrintSet($set_name, $set_elements)?>
            </label>
            <br>
        <?php endif?>
    <?php endforeach?>
    <label class="task_label">
        <?php if(count(array_diff($actual_sets["A"],$actual_sets["B"]))!==0):?>
            <?= PrintRelation("R", $_SESSION["task"]["relations"][$counter])?>
        <?php else:?>
            <?= PrintRelation("R", $_SESSION["task"]["relations"][$counter], true)?>
        <?php endif?>
    </label>
    <br>
    <?php for($subtask_counter = 0; $subtask_counter < 6; $subtask_counter++):?>
        <?php $task_counter = $counter . "_" . $subtask_counter?>
        <div class="small_task_container">
            <label class="task_label">
                <?=$counter + 1?>.<?=$subtask_counter + 1?>. részfeladat:
                <?php if($subtask_counter == 0):?>
                    Az R reláció értelmezési tartománya
                <?php elseif($subtask_counter == 1):?>
                    Az R reláció értékkészlete
                <?php elseif($subtask_counter == 2):?>
                    Az R reláció leszűkítése az N halmazra (itt (elem,elem) (pl.: (1,1), (1,2), ...) felsorolást írj)
                <?php elseif($subtask_counter == 3):?>
                    Az R reláció inverze (itt is (elem,elem) (pl.: (1,1), (1,2), ...) felsorolást írj)
                <?php elseif($subtask_counter == 4):?>
                    Az R reláció I halmazon felvett képe 
                <?php elseif($subtask_counter == 5):?>
                    Az R reláció D halmazon felvett ősképe 
                <?php endif?>
            </label>
            <br>
            <?php include("./partials/taskContents/solutionInput.php")?>
        </div>
    <?php endfor?>
<?php endforeach?>