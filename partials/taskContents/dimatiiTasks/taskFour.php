<?php foreach($_SESSION["task"]["linear_congrences"] as $index => $triplet):?>
    <label class="task_label">
        <?=$index + 1?>. részfeladat: Határozd meg a <?= $triplet[0] . "*x \u{2261} " . $triplet[1] . "(mod " . $triplet[2] . ")"?> kongruencia megoldását!
    </label>
    <div class="small_task_container">
        <?php $task_counter = $index;?>
        <div class="multiple_solution_input_container">
            <?="x \u{2261}"?> <input type="text" name=<?="solution_" . $task_counter . "_0"?> value="b..." class="solution_input">
            (mod
            <input type="text" name=<?="solution_" . $task_counter . "_1"?> value="modulo..." class="solution_input">
            )
        </div>
    </div>
    <br>
<?php endforeach?>

<?php $first = $_SESSION["task"]["solution"][0]?>
<?php $second = $_SESSION["task"]["solution"][1]?>
<?php print_r($first)?>
<?php print_r($second)?>