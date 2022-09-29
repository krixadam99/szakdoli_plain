<?php $subtask_counter = 0?>
<?php foreach($_SESSION["task"]["diophantine_equations"] as $index => $triplet):?>
    <label class="task_label">
        <?=$index + 1?>. részfeladat: Határozd meg a <?= $triplet[0] . " * x "?> <?=$triplet[1] < 0 ?" - " . abs($triplet[1]):" + " . $triplet[1]?> <?=" * y = " . $triplet[2]?> diofantikus egyenlet megoldását!
    </label>
    <div class="small_task_container">
        <?php 
            $solution_id_remainder = $index . "_0_0";
            $solution_id_modulo = $index . "_0_1";
        ?>
        <?php include("./partials/taskContents/congruence.php")?>

        <?php 
            $first_operand = $index . "_1_0";
            $second_operand = $index . "_1_1";
            $variable_name = "x";
            $with_multiplier = true;
        ?>
        <?php include("./partials/taskContents/additionInputs.php")?>

        <?php 
            $first_operand = $index . "_2_0";
            $second_operand = $index . "_2_1";
            $variable_name = "y";
            $with_multiplier = true;
        ?>
        <?php include("./partials/taskContents/additionInputs.php")?>

    </div>
    <?php $subtask_counter++?>
<?php endforeach?>

<div class="small_task_container">
    <?php $triplet = $_SESSION["task"]["partition_number"]?>
    <label class="task_label">
        <?=$subtask_counter + 1?>. részfeladat: Írd fel a 
        <?=$triplet[2]?>-<?= PrintServices::UseCorrectObjectSuffix($triplet[2])?> 2 szám összegeként úgy, hogy az egyik osztható legyen  
        <?=$triplet[0]?>-<?= PrintServices::UseCorrectAdverb($triplet[0])?>, a másik pedig 
        <?=$triplet[1]?>-<?= PrintServices::UseCorrectAdverb($triplet[1])?>!
    </label>
    <div class="small_task_container">
        <?php 
            $first_operand = $subtask_counter . "_0";
            $second_operand = $subtask_counter . "_1";
            $variable_name = $triplet[2];
            $with_multiplier = false;

        ?>
        <?php include("./partials/taskContents/additionInputs.php")?>
    </div>
</div>