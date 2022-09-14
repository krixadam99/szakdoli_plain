<?php foreach($_SESSION["task"]["diophantine_equations"] as $index => $triplet):?>
    <label class="task_label">
        <?=$index + 1?>. részfeladat: Határozd meg a <?= $triplet[0] . " * x "?> <?=$triplet[1] < 0 ?" - " . abs($triplet[1]):" + " . $triplet[1]?> <?=" * y = " . $triplet[2]?> diofantikus egyenlet megoldását!
    </label>
    <div class="small_task_container">
        <?php $task_counter = $index;?>
        <div class="multiple_solution_input_container">
            <?php $current_answer = $_SESSION["answers"]["answer_" . $task_counter . "_0_0"]??"";?>
            <?="x \u{2261}"?> <input type="text" name=<?="solution_" . $task_counter . "_0_0"?> value=<?=$current_answer["answer"]??"b..."?> class="<?=IsCorrect($current_answer)?>" <?=$current_answer !== ""?"readonly":""?>>
            (mod
            <?php $current_answer = $_SESSION["answers"]["answer_" . $task_counter . "_0_1"]??"";?>
            <input type="text" name=<?="solution_" . $task_counter . "_0_1"?> value=<?=$current_answer["answer"]??"modulo..."?> class="<?=IsCorrect($current_answer)?>" <?=$current_answer !== ""?"readonly":""?>>
            )
        </div>
        <div class="multiple_solution_input_container">
            <?php $current_answer = $_SESSION["answers"]["answer_" . $task_counter . "_1_0"]??"";?>
            <?="x = "?> <input type="text" name=<?="solution_" . $task_counter . "_1_0"?> value=<?=$current_answer["answer"]??"b..."?> class="<?=IsCorrect($current_answer)?>" <?=$current_answer !== ""?"readonly":""?>>
            +
            <?php $current_answer = $_SESSION["answers"]["answer_" . $task_counter . "_1_1"]??"";?>
            <input type="text" name=<?="solution_" . $task_counter . "_1_1"?> value=<?=$current_answer["answer"]??"modulo..."?> class="<?=IsCorrect($current_answer)?>" <?=$current_answer !== ""?"readonly":""?>> * k <?="(k \u{2208} \u{2124})"?>
        </div>
        <div class="multiple_solution_input_container">
            <?php $current_answer = $_SESSION["answers"]["answer_" . $task_counter . "_2_0"]??"";?>
            <?="y = "?> <input type="text" name=<?="solution_" . $task_counter . "_2_0"?> value=<?=$current_answer["answer"]??"első tag..."?> class="<?=IsCorrect($current_answer)?>" <?=$current_answer !== ""?"readonly":""?>>
            +
            <?php $current_answer = $_SESSION["answers"]["answer_" . $task_counter . "_2_1"]??"";?>
            <input type="text" name=<?="solution_" . $task_counter . "_2_1"?> value=<?=$current_answer["answer"]??"második tag..."?> class="<?=IsCorrect($current_answer)?>" <?=$current_answer !== ""?"readonly":""?>> * k <?="(k \u{2208} \u{2124})"?>
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
        <?php $current_answer = $_SESSION["answers"]["answer_" . $task_counter . "_0"]??"";?>
        <?=$triplet[2] . " = "?> <input type="text" name=<?="solution_" . $task_counter . "_0"?> value="<?=$current_answer["answer"]??"Az első szám..."?>" class="<?=IsCorrect($current_answer)?>" <?=$current_answer !== ""?"readonly":""?>>
        +
        <?php $current_answer = $_SESSION["answers"]["answer_" . $task_counter . "_1"]??"";?>
        <input type="text" name=<?="solution_" . $task_counter . "_1"?> value="<?=$current_answer["answer"]??"A második szám..."?>" class="<?=IsCorrect($current_answer)?>" <?=$current_answer !== ""?"readonly":""?>>
    </div>
</div>
</div>
<br>