<?php foreach($_SESSION["task"]["first_triplets"] as $index => $triplet):?>
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
    <?php $triplet = $_SESSION["task"]["second_triplet"]?>
    <label class="task_label">
        3. részfeladat: Bontsd fel a <?=$triplet[2]?>-t 2 szám összegére úgy, hogy az egyik osztható a <?=$triplet[1]?>, a másik pedig <?=$triplet[2]?> számmal!
    </label>
    Az első szám: <!-- simple input-->
    A második szám <!-- simple input-->
</div>
<br>

<?php $first = $_SESSION["task"]["solution"][0][0]?>
<?php $second = $_SESSION["task"]["solution"][0][1]?>
<?php print_r($first[count($first)-1])?>
<?php print_r($second)?>