<div class="small_task_container">
    <label class="task_label">
        <?php $first_task_triplets = $_SESSION["task"]["first_congruence_system_triplets"]?>
        1. részfeladat: Adj egy számot, ami 
        <?=$first_task_triplets[0][2] . "-" . PrintServices::UseCorrectAdverb($first_task_triplets[0][2])?> osztva 
        <?=$first_task_triplets[0][1] . "-" . PrintServices::UseCorrectObjectSuffix($first_task_triplets[0][1])?> és
        <?=$first_task_triplets[1][2] . "-" . PrintServices::UseCorrectAdverb($first_task_triplets[1][2])?> osztva 
        <?=$first_task_triplets[1][1] . "-" . PrintServices::UseCorrectObjectSuffix($first_task_triplets[1][1])?> ad maradékul!
    </label>

    <?php $task_counter = 0;?>
    <?php include("./views/taskContents/solutionInput.php")?>
</div>

<div class="small_task_container">
    <label class="task_label">
        2. részfeladat: Old meg a következő 3 lineáris kongruenciából álló kongruenciarendszert!
    </label>
    <?php foreach($_SESSION["task"]["second_congruence_system_triplets"] as $index => $triplet):?>
        <?= $triplet[0] . "*x \u{2261} " . $triplet[1] . " (mod " . $triplet[2] . ")"?>
        <br>
    <?php endforeach?>
</div>

<div class="small_task_container">
    <label class="task_label">
        A kongruenciák az átalakítást követően:
    </label>
    <?php $task_counter = 1;?>
    <?php for($counter = 0; $counter < 3; $counter++):?>
        <?php 
            $solution_id_remainder = $task_counter . "_" . $counter . "_0";
            $solution_id_modulo = $task_counter . "_" . $counter . "_1";
            include("./views/taskContents/congruence.php")
        ?>
    <?php endfor?>
</div>

<div class="small_task_container">
    <label class="task_label">
        Az első két kongruencia összevonását követő lineáris kongruencia:
    </label>
    <?php $task_counter = "1_" . 3;?>
    <?php 
        $solution_id_remainder = $task_counter . "_0";
        $solution_id_modulo = $task_counter . "_1";
        include("./views/taskContents/congruence.php")
    ?>
</div>

<div class="small_task_container">
    <label class="task_label">
        Az 1-2. összevont és harmadik lineáris kongruencia összevonását követő lineáris kongruencia:
    </label>
    <?php $task_counter = "1_" . 4;?>
    <?php 
        $solution_id_remainder = $task_counter . "_0";
        $solution_id_modulo = $task_counter . "_1";
        include("./views/taskContents/congruence.php")
    ?>
</div>