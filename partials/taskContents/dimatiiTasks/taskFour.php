<?php foreach($_SESSION["task"]["linear_congrences"] as $index => $triplet):?>
    <label class="task_label">
        <?=$index + 1?>. részfeladat: Határozd meg a <?= $triplet[0] . "*x \u{2261} " . $triplet[1] . " (mod " . $triplet[2] . ")"?> kongruencia megoldását!
    </label>
    <div class="small_task_container">
        <?php $task_counter = $index;?>
        <div class="multiple_solution_input_container">
            <?php $current_answer = $_SESSION["answers"]["answer_" . $task_counter . "_0"]??"";?>
            <?="x \u{2261}"?> <input type="text" name=<?="solution_" . $task_counter . "_0"?> value=<?=$current_answer["answer"]??"b..."?> class="<?=IsCorrect($current_answer)?>" <?=$current_answer !== ""?"readonly":""?>>
            (mod
            <?php $current_answer = $_SESSION["answers"]["answer_" . $task_counter . "_1"]??"";?>
            <input type="text" name=<?="solution_" . $task_counter . "_1"?> value=<?=$current_answer["answer"]??"mod..."?> class="<?=IsCorrect($current_answer)?>" <?=$current_answer !== ""?"readonly":""?>>
            )
        </div>
    </div>
    <br>
<?php endforeach?>