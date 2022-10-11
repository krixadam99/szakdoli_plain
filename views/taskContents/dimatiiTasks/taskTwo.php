<label class="task_label">
    1. részfeladat: Határozd meg a következő teljes maradékrendszert a maradékosztályok 1-1 reprezentatív elemének megadásával! Az elemeket vesszővel válaszd el!
</label>
<?php $task_counter = 0;?>
<?php foreach($_SESSION["task"]["crs_numbers"] as $crs_index => $number):?>
    <div class="small_task_container">
        <?="\u{2124}" . "/"?><span class="bottom"><?= $number?></span><?="\u{2124}"?> teljes maradék rendszer megadása:
        <br>
        <?php include("./views/taskContents/solutionInput.php")?>
    </div>
<?php endforeach?>
<br>

<label class="task_label">
    2. részfeladat: Határozd meg a következő redukált maradékrendszert a maradékosztályok 1-1 reprezentatív elemének megadásával! Az elemeket vesszővel válaszd el!
</label>
<?php $task_counter = 1;?>
<?php foreach($_SESSION["task"]["rrs_numbers"] as $rrs_index => $number):?>
    <div class="small_task_container">
        <?="(\u{2124}" . "/"?><span class="bottom"><?= $number?></span><?="\u{2124})*"?> redukált maradék rendszer megadása:
        <br>
        <?php include("./views/taskContents/solutionInput.php")?>
    </div>
<?php endforeach?>
<br>

<label class="task_label">
    3. részfeladat: Határozd meg a következő redukált maradékrendszerek méretét az Euler- féle fí függvény segítségével!
</label>
<?php foreach($_SESSION["task"]["rrs_size_numbers"] as $rrs_size_index => $number):?>
    <div class="small_task_container">
        <?php $task_counter = 2 . "_" . $rrs_size_index;?>
        <?="|(\u{2124}" . "/"?><span class="bottom"><?=$number?></span><?="\u{2124})*|"?> redukált maradék rendszer méretének megadása:
        <br>
        <?php include("./views/taskContents/solutionInput.php")?>
    </div>
<?php endforeach?>
<br>