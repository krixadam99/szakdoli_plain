<?php foreach($_SESSION["task"]["first_subtasks"]["pairs_of_sets"] as $set_pair_counter => $pair_of_sets):?>
    <?php $select_counter = 0;?>
    <?php $bottom_index = $set_pair_counter + 1?>
    <div class="task_data">
        <?php foreach($pair_of_sets as $set_name => $set_elements):?>
            <label class="task_label">
                <?= PrintServices::CreatePrintableSet($set_name . "<sub>$bottom_index</sub>", $set_elements)?>
            </label>
        <?php endforeach?>

        <label class="task_label">
            <?="R<sub>$bottom_index</sub> \u{2286} A<sub>$bottom_index</sub> \u{00D7} B<sub>$bottom_index</sub>, "?>
            <?= PrintServices::CreatePrintableRelation("R<sub>$bottom_index</sub>", $_SESSION["task"]["first_subtasks"]["relations"][$set_pair_counter])?>
        </label>
    </div>
    <div class="small_task_container">
        <label class="task_label">
            1.<?= $set_pair_counter + 1 ?>. részfeladat: Függvény-e az R<?="<sub>$bottom_index</sub>"?> reláció?
        </label>
        <?php $task_counter = "0_$set_pair_counter";?>
        <?php $select_label = "Függvény?"?>
        <?php include("./views/taskContents/solutionSelect.php")?>
    </div>
<?php endforeach?>

<?php $function_characteristics = ["Szürjektív", "Injektív", "Bijektív"]?>
<?php foreach($_SESSION["task"]["second_subtasks"]["pairs_of_sets"] as $set_pair_counter => $pair_of_sets):?>
    <?php $select_counter = 0;?>
    <?php $bottom_index = $set_pair_counter + 1?>
    <div class="task_data">
        <?php foreach($pair_of_sets as $set_name => $set_elements):?>
            <label class="task_label">
                <?= PrintServices::CreatePrintableSet($set_name . "<sub>$bottom_index</sub>", $set_elements)?>
            </label>
        <?php endforeach?>

        <label class="task_label">
            <?="f<sub>$bottom_index</sub> \u{2208} A<sub>$bottom_index</sub> \u{2192} B<sub>$bottom_index</sub>, "?>
            <?= PrintServices::CreatePrintableRelation("f" . "<sub>$bottom_index</sub>", $_SESSION["task"]["second_subtasks"]["functions"][$set_pair_counter])?>
        </label>
    </div>
    <div class="small_task_container">
        <label class="task_label">
            2.<?= $set_pair_counter + 1 ?>. Határozd meg, hogy mely tulajdonság igaz az f<?="<sub>$bottom_index</sub>"?> függvényre!
        </label>
        <?php $task_counter = "1_$set_pair_counter";?>
        <?php foreach($function_characteristics as $index => $select_label):?>
            <?php $select_label = $select_label . "?"?>
            <?php include("./views/taskContents/solutionSelect.php")?>
            <?php $select_counter++;?>
        <?php endforeach?>
    </div>
<?php endforeach?>