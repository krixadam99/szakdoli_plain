<?php foreach($_SESSION["task"]["sets"] as $counter => $actual_sets):?>
    <div class="task_data">
        <?php foreach($actual_sets as $set_name => $set_elements):?>
            <?php if($set_name !== "B" || count(array_diff($actual_sets["A"],$actual_sets["B"]))!==0):?>
                <label class="task_label">
                    <?= PrintServices::CreatePrintableSet($set_name, $set_elements)?>
                </label>
            <?php endif?>
        <?php endforeach?>
        <label class="task_label">
            <?php if(count(array_diff($actual_sets["A"],$actual_sets["B"]))!==0):?>
                <?="R \u{2286} A \u{00D7} B, "?>
                <?= PrintServices::CreatePrintableRelation("R", $_SESSION["task"]["relations"][$counter])?>
            <?php else:?>
                <?="R \u{2286} A \u{00D7} A, "?>
                <?= PrintServices::CreatePrintableRelation("R", $_SESSION["task"]["relations"][$counter])?>
            <?php endif?>
        </label>
    </div>
    <?php for($subtask_counter = 0; $subtask_counter < 6; $subtask_counter++):?>
        <?php $task_counter = $counter . "_" . $subtask_counter?>
        <div class="small_task_container">
            <label class="task_label">
                <?=$counter + 1?>.<?=$subtask_counter + 1?>. részfeladat:
                <?php if($subtask_counter == 0):?>
                    <?php $solution_label = "Dom<sub>R</sub> = "?>
                    Az R reláció értelmezési tartománya:
                <?php elseif($subtask_counter == 1):?>
                    <?php $solution_label = "Ran<sub>R</sub> = "?>
                    Az R reláció értékkészlete:
                <?php elseif($subtask_counter == 2):?>
                    <?php $solution_label = "R<sub>" . PrintServices::CreatePrintableSet("", $_SESSION["task"]["sets"][$counter]["N"], false) . "</sub> = "?>
                    Az R reláció leszűkítése az N halmazra (itt (elem,elem) (pl.: (1,1), (1,2), ...) felsorolást írj):
                <?php elseif($subtask_counter == 3):?>
                    <?php $solution_label = "R<sup>-1</sup> = "?>
                    Az R reláció inverze (itt is (elem,elem) (pl.: (1,1), (1,2), ...) felsorolást írj):
                <?php elseif($subtask_counter == 4):?>
                    <?php $solution_label = "R(I) = "?>
                    Az R reláció I halmazon felvett képe:
                <?php elseif($subtask_counter == 5):?>
                    <?php $solution_label = "R<sup>-1</sup>(D) = "?>
                    Az R reláció D halmazon felvett ősképe:
                <?php endif?>
            </label>
            <?php include("./views/taskContents/solutionInput.php")?>
        </div>
    <?php endfor?>
<?php endforeach?>