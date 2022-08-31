<?php if(isset($_SESSION["answers"])):?>
    <?php if(isset($_SESSION["answers"]["answer_" . $task_counter])):?>
            <?php $current_answer= $_SESSION["answers"]["answer_" . $task_counter]?>
            <div class="solution_container">
                <label>Megoldásom:</label>
                <input type="text" name=<?="solution_" . $task_counter?> value="<?= $current_answer["answer"]?>" class=<?= $current_answer["correct"]?"correct":"wrong"?> readonly>
            </div>
            <label>Válaszod az átalakítást követően: 
                <?=$current_answer["answer_text"]??""?>
            </label>
            <br>
            <label>A helyes válasz: 
                <?=$current_answer["solution_text"]??""?>
            </label>
            <br>
    <?php else:?>
        <div class="solution_container">
            <label>Megoldásom:</label>
            <input type="text" name=<?="solution_" . $task_counter?> value="Megoldásom..." class="solution_input">
        </div>
    <?php endif?>
<?php else:?>
    <div class="solution_container">
        <label>Megoldásom:</label>
        <input type="text" name=<?="solution_" . $task_counter?> value="Megoldásom..." class="solution_input">
    </div>
<?php endif?>