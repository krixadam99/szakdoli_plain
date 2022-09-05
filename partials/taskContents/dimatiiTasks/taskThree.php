<?php foreach($_SESSION["task"]["first_parameter"] as $index => $pair):?>
    <label class="task_label">
        <?=$index + 1?>. részfeladat: Határozd meg a <?= $pair[0] . " és " . $pair[1]?> számok legnagyobb közös osztóját az Euklideszi algoritmussal, majd add meg a legkisebb közös többszörösüket!
    </label>
    <div class="small_task_container">
        <?php for($counter=0; $counter < $_SESSION["task"]["step_counts"][$index]; $counter++):?>
            <?php $task_counter = $index . "_" . $counter;?>
            <?php include("./partials/taskContents/solutionInput.php")?>
        <?php endfor?>
    </div>
    <br>
<?php endforeach?>