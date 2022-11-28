<?php foreach($_SESSION["task"]["linear_congrences"] as $index => $triplet):?>
    <label class="task_label">
        <?=$index + 1?>. részfeladat: Határozd meg a <?= $triplet[0] . "*x \u{2261} " . $triplet[1] . " (mod " . $triplet[2] . ")"?> lineáris kongruencia megoldását!
    </label>
    <div class="small_task_container">
        <?php 
            $solution_id_remainder = $index . "_0";
            $solution_id_modulo = $index . "_1";
        ?>
        <?php include("./views/taskContents/congruence.php")?>
    </div>
    <br>
<?php endforeach?>