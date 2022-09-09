<?php foreach($_SESSION["task"]["gcd_pairs"] as $index => $pair):?>
    <label class="task_label">
        <?=$index + 1?>. részfeladat: Határozd meg a <?= $pair[0] . " és " . $pair[1]?> számok legnagyobb közös osztóját az Euklideszi algoritmussal, majd add meg a legkisebb közös többszörösüket!
    </label>
    <div class="small_task_container">
        <?php for($counter=0; $counter < $_SESSION["task"]["step_counts"][$index]; $counter++):?>
            <?php $task_counter = $index . "_" . $counter;?>
            <div class="multiple_solution_input_container">
                <?=$counter + 1?>. lépés:
                <input type="text" name=<?="solution_" . $task_counter . "_0"?> value="Összeg..." class="solution_input">
                =
                <input type="text" name=<?="solution_" . $task_counter . "_1"?> value="Szorzó..." class="solution_input">
                *
                <input type="text" name=<?="solution_" . $task_counter . "_2"?> value="Szorzandó..." class="solution_input">
                +
                <input type="text" name=<?="solution_" . $task_counter . "_3"?> value="Maradék..." class="solution_input">
            </div>
        <?php endfor?>
        <div class="solution_container">
            <label>lnko(<?=$pair[0]?>, <?=$pair[1]?>) = </label>
            <input type="text" name=<?="solution_" . $task_counter?> value="LNKO..." class="solution_input">
        </div>
        <div class="solution_container">
            <label>lkkt(<?=$pair[0]?>, <?=$pair[1]?>) = </label>
            <input type="text" name=<?="solution_" . $task_counter?> value="LKKT..." class="solution_input">
        </div>
    </div>
    <br>
<?php endforeach?>

<!-- Kibővített eukleidészi még táblázattal-->