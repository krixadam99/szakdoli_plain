<label class="task_label">
    1. részfeladat: Határozd meg a következő teljes maradékrendszereket a maradékosztályok 1-1 reprezentatív elemének megadásával! Az elemeket vesszővel válaszd el!
</label>
<div class="small_task_container">
    <?php $task_counter = 0;?>
    <?php foreach($_SESSION["task"]["first_parameter"] as $index => $number):?>
        <?="\u{2124}" . "/"?><span class="bottom"><?= $number?></span><?="\u{2124}"?> teljes maradék rendszer megadása:
        <br>
        <?php include("./partials/taskContents/solutionInput.php")?>
    <?php endforeach?>
</div>
<br>

<label class="task_label">
        2. részfeladat: Határozd meg a következő redukált maradékrendszereket a maradékosztályok 1-1 reprezentatív elemének megadásával! Az elemeket vesszővel válaszd el!
    </label>
<div class="small_task_container">
    <?php $task_counter = 1;?>
    <?php foreach($_SESSION["task"]["second_parameter"] as $index => $number):?>
        <?="(\u{2124}" . "/"?><span class="bottom"><?= $number?></span><?="\u{2124})*"?>redukált maradék rendszer megadása:
        <br>
        <?php include("./partials/taskContents/solutionInput.php")?>
    <?php endforeach?>
</div>
<br>

<label class="task_label">
        3. részfeladat: Határozd meg a következő redukált maradékrendszerek méretét az Euler- féle fí függvény segítségével!
    </label>
<div class="small_task_container">
    <?php $task_counter = 2;?>
    <?php foreach($_SESSION["task"]["third_parameter"] as $index => $number):?>
        <?="|(\u{2124}" . "/"?><span class="bottom"><?=$number?></span><?="\u{2124})*|"?> redukált maradék rendszer méretének megadása:
        <br>
        <?php include("./partials/taskContents/solutionInput.php")?>
    <?php endforeach?>
</div>
<br>

<label class="task_label">
    4. részfeladat: Határozd meg a következő hatványok maradékát!
</label>
<div class="small_task_container">
    <?php $task_counter = 3;?>
    <?php foreach($_SESSION["task"]["fourth_parameter"] as $index => $pair):?>
        <?=$pair[0]?><span class="exp"><?=$pair[1]?></span> / <?=$_SESSION["task"]["fourth_mods"][$index]?> hányados maradéka:
        <br>
        <?php include("./partials/taskContents/solutionInput.php")?>
    <?php endforeach?>
</div>
<br>