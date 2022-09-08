<label class="task_label">
    <?php $first_task_triplets = $_SESSION["task"]["first_congruence_system_triplets"]?>
    1. részfeladat: Adj egy számot, ami 
    <?=$first_task_triplets[0][2] . "-" . UseCorrectAdverb($first_task_triplets[0][2])?> osztva 
    <?=$first_task_triplets[0][1] . "-" . UseCorrectObjectSuffix($first_task_triplets[0][1])?> és
    <?=$first_task_triplets[1][2] . "-" . UseCorrectAdverb($first_task_triplets[1][2])?> osztva 
    <?=$first_task_triplets[1][1] . "-" . UseCorrectObjectSuffix($first_task_triplets[1][1])?> ad maradékul!
</label>
<div class="small_task_container">
    <?php $task_counter = 0;?>
    <?php include("./partials/taskContents/solutionInput.php")?>
</div>

<label class="task_label">
    2. részfeladat: Old meg a következő 4 lineáris kongruenciából álló kongruenciarendszert!
</label>
<div class="small_task_container">
    <?php foreach($_SESSION["task"]["second_congruence_system_triplets"] as $index => $triplet):?>
        <?= $triplet[0] . "*x \u{2261} " . $triplet[1] . " (mod " . $triplet[2] . ")"?>
        <br>
    <?php endforeach?>
</div>

<label class="task_label">
    A kongruenciák az átalakítást követően:
</label>
<div class="small_task_container">
    <?php $task_counter = 1;?>
    <?php for($counter = 0; $counter < 4; $counter++):?>
        <div class="multiple_solution_input_container">
            <?="x \u{2261}"?> <input type="text" name=<?="solution_" . $task_counter . "_" . $counter . "_0"?> value="b..." class="solution_input">
            (mod
            <input type="text" name=<?="solution_" . $task_counter . "_" . $counter . "_1"?> value="modulo..." class="solution_input">
            )
        </div>
    <?php endfor?>
</div>

<label class="task_label">
    Az első két kongruencia összevonását követő lineáris kongruencia:
</label>
<?php $task_counter = 2;?>
<div class="multiple_solution_input_container">
    <?="x \u{2261}"?> <input type="text" name=<?="solution_" . $task_counter . "_0"?> value="b..." class="solution_input">
    (mod
    <input type="text" name=<?="solution_" . $task_counter . "_1"?> value="modulo..." class="solution_input">
    )
</div>

<label class="task_label">
    Az 1-2. összevont és harmadik lineáris kongruencia összevonását követő lineáris kongruencia:
</label>
<?php $task_counter = 3;?>
<div class="multiple_solution_input_container">
    <?="x \u{2261}"?> <input type="text" name=<?="solution_" . $task_counter . "_0"?> value="b..." class="solution_input">
    (mod
    <input type="text" name=<?="solution_" . $task_counter . "_1"?> value="modulo..." class="solution_input">
    )
</div>

<label class="task_label">
    Az 1-3. összevont és negyedik lineáris kongruencia összevonását követő lineáris kongruencia (a kongruenciarendszer megoldása):
</label>
<?php $task_counter = 4;?>
<div class="multiple_solution_input_container">
    <?="x \u{2261}"?> <input type="text" name=<?="solution_" . $task_counter . "_0"?> value="b..." class="solution_input">
    (mod
    <input type="text" name=<?="solution_" . $task_counter . "_1"?> value="modulo..." class="solution_input">
    )
</div>