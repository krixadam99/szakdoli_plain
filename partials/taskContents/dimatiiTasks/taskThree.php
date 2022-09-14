<?php foreach($_SESSION["task"]["gcd_pairs"] as $index => $pair):?>
    <label class="task_label">
        <?=$index + 1?>. részfeladat: Határozd meg a <?= $pair[0] . " és " . $pair[1]?> számok legnagyobb közös osztóját az Euklideszi algoritmussal, majd add meg a legkisebb közös többszörösüket!
    </label>
    <div class="small_task_container">
        <?php for($counter=0; $counter < $_SESSION["task"]["step_counts"][$index]; $counter++):?>
            <?php 
                $task_counter = $index . "_" . $counter;
            ?>
            <div class="multiple_solution_input_container">
                <?=$counter + 1?>. lépés:
                <?php $current_answer = $_SESSION["answers"]["answer_" . $task_counter . "_0"]??"";?>
                <input type="text" name=<?="solution_" . $task_counter . "_0"?> value=<?=$current_answer["answer"]??"Összeg..."?> class="<?=IsCorrect($current_answer)?>" <?=$current_answer !== ""?"readonly":""?>>
                =
                <?php $current_answer = $_SESSION["answers"]["answer_" . $task_counter . "_1"]??"";?>
                <input type="text" name=<?="solution_" . $task_counter . "_1"?> value=<?=$current_answer["answer"]??"Szorzandó..."?> class="<?=IsCorrect($current_answer)?>" <?=$current_answer !== ""?"readonly":""?>>
                *
                <?php $current_answer = $_SESSION["answers"]["answer_" . $task_counter . "_2"]??"";?>
                <input type="text" name=<?="solution_" . $task_counter . "_2"?> value=<?=$current_answer["answer"]??"Szorzó..."?> class="<?=IsCorrect($current_answer)?>" <?=$current_answer !== ""?"readonly":""?>>
                +
                <?php $current_answer = $_SESSION["answers"]["answer_" . $task_counter . "_3"]??"";?>
                <input type="text" name=<?="solution_" . $task_counter . "_3"?> value=<?=$current_answer["answer"]??"Maradék..."?> class="<?=IsCorrect($current_answer)?>" <?=$current_answer !== ""?"readonly":""?>>
            </div>
        <?php endfor?>
        <div class="solution_container">
            <label>lnko(<?=$pair[0]?>, <?=$pair[1]?>) = </label>
            <?php $current_answer = $_SESSION["answers"]["answer_" .  $index . "_" . $_SESSION["task"]["step_counts"][$index]]??"";?>
            <input type="text" name=<?="solution_". $index . "_" . $_SESSION["task"]["step_counts"][$index]?> value=<?=$current_answer["answer"]??"LNKO..."?> class="<?=IsCorrect($current_answer)?>" <?=$current_answer !== ""?"readonly":""?>>
        </div>
        <div class="solution_container">
            <label>lkkt(<?=$pair[0]?>, <?=$pair[1]?>) = </label>
            <?php $current_answer = $_SESSION["answers"]["answer_" .  $index . "_" . $_SESSION["task"]["step_counts"][$index] + 1]??"";?>
            <input type="text" name=<?="solution_" . $index . "_" . $_SESSION["task"]["step_counts"][$index] + 1?> value=<?=$current_answer["answer"]??"LKKT..."?> class="<?=IsCorrect($current_answer)?>" <?=$current_answer !== ""?"readonly":""?>>
        </div>
    </div>
    <br>
<?php endforeach?>

<!-- Kibővített eukleidészi még táblázattal-->