<?php foreach($_SESSION["task"]["first_subtasks"]["pairs_of_sets"] as $set_pair_counter => $pair_of_sets):?>
    <?php $select_counter = 0;?>
    <?php $bottom_index = $set_pair_counter + 1?>
    <div class="task_data">
        <?php foreach($pair_of_sets as $set_name => $set_elements):?>
            <label class="task_label">
                <?= PrintServices::CreatePrintableSet($set_name . "<span class=\"bottom\">$bottom_index</span>", $set_elements)?>
            </label>
        <?php endforeach?>

        <label class="task_label">
            <?="R<span class=\"bottom\">$bottom_index</span> \u{2286} A<span class=\"bottom\">$bottom_index</span> \u{00D7} B<span class=\"bottom\">$bottom_index</span>, "?>
            <?= PrintServices::CreatePrintableRelation("R<span class=\"bottom\">$bottom_index</span>", $_SESSION["task"]["first_subtasks"]["relations"][$set_pair_counter])?>
        </label>
    </div>
    <div class="small_task_container">
        <label class="task_label">
            1.<?= $set_pair_counter + 1 ?>. részfeladat: Függvény-e az R reláció?
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
                <?= PrintServices::CreatePrintableSet($set_name . "<span class=\"bottom\">$bottom_index</span>", $set_elements)?>
            </label>
        <?php endforeach?>

        <label class="task_label">
            <?="f<span class=\"bottom\">$bottom_index</span> \u{2208} A<span class=\"bottom\">$bottom_index</span> \u{2192} B<span class=\"bottom\">$bottom_index</span>, "?>
            <?= PrintServices::CreatePrintableRelation("f" . "<span class=\"bottom\">$bottom_index</span>", $_SESSION["task"]["second_subtasks"]["functions"][$set_pair_counter])?>
        </label>
    </div>
    <div class="small_task_container">
        <label class="task_label">
            2.<?= $set_pair_counter + 1 ?>. Határozd meg, hogy mely tulajdonság igaz az f függvényre!
        </label>
        <?php $task_counter = "1_$set_pair_counter";?>
        <?php foreach($function_characteristics as $index => $select_label):?>
            <?php $select_label = $select_label . "?"?>
            <?php include("./views/taskContents/solutionSelect.php")?>
            <?php $select_counter++;?>
        <?php endforeach?>
    </div>
<?php endforeach?>