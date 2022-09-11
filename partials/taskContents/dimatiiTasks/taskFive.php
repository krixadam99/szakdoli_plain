<?php foreach($_SESSION["task"]["diophantine_equations"] as $index => $triplet):?>
    <label class="task_label">
        <?=$index + 1?>. részfeladat: Határozd meg a <?= $triplet[0] . " * x "?> <?=$triplet[1] < 0 ?" - " . abs($triplet[1]):" + " . $triplet[1]?> <?=" * y = " . $triplet[2]?> diofantikus egyenlet megoldását!
    </label>
    <div class="small_task_container">
        <?php $task_counter = $index;?>
        <div class="multiple_solution_input_container">
            <?="x \u{2261}"?> <input type="text" name=<?="solution_" . $task_counter . "_0_0"?> value="b..." class="solution_input">
            (mod
            <input type="text" name=<?="solution_" . $task_counter . "_0_1"?> value="modulo..." class="solution_input">
            )
        </div>
        <div class="multiple_solution_input_container">
            <?="x = "?> <input type="text" name=<?="solution_" . $task_counter . "_1_0"?> value="b..." class="solution_input">
            +
            <input type="text" name=<?="solution_" . $task_counter . "_1_1"?> value="modulo..." class="solution_input"> * k <?="(k \u{2208} \u{2124})"?>
        </div>
        <div class="multiple_solution_input_container">
            <?="y = "?> <input type="text" name=<?="solution_" . $task_counter . "_2_0"?> value="első tag..." class="solution_input">
            +
            <input type="text" name=<?="solution_" . $task_counter . "_2_1"?> value="második tag..." class="solution_input"> * k <?="(k \u{2208} \u{2124})"?>
        </div>
    </div>
    <br>
<?php endforeach?>

<div class="small_task_container">
    <?php $triplet = $_SESSION["task"]["partition_number"]?>
    <label class="task_label">
        3. részfeladat: Írd fel a 
        <?=$triplet[2]?>-<?=UseCorrectObjectSuffix($triplet[2])?> 2 szám összegeként úgy, hogy az egyik osztható legyen  
        <?=$triplet[0]?>-<?=UseCorrectAdverb($triplet[0])?>, a másik pedig 
        <?=$triplet[1]?>-<?=UseCorrectAdverb($triplet[1])?>!
    </label>
    <div class="small_task_container">
    <?php $task_counter = 2;?>
    <div class="multiple_solution_input_container">
        <?=$triplet[2] . " = "?> <input type="text" name=<?="solution_" . $task_counter . "_0"?> value="Az első szám..." class="solution_input">
        +
        <input type="text" name=<?="solution_" . $task_counter . "_1"?> value="Az második szám..." class="solution_input">
    </div>
</div>
</div>
<br>