<label class="task_label">
    1. részfeladat: Határozd meg a következő teljes maradékrendszereket a maradékosztályok 1-1 reprezentatív elemének megadásával! Az elemeket vesszővel válaszd el!
</label>
<div class="small_task_container">
    <?php $task_counter = 0;?>
    <?php foreach($_SESSION["task"]["crs_numbers"] as $index => $number):?>
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
    <?php foreach($_SESSION["task"]["rrs_numbers"] as $index => $number):?>
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
    <?php foreach($_SESSION["task"]["rrs_size_numbers"] as $index => $number):?>
        <?="|(\u{2124}" . "/"?><span class="bottom"><?=$number?></span><?="\u{2124})*|"?> redukált maradék rendszer méretének megadása:
        <br>
        <?php include("./partials/taskContents/solutionInput.php")?>
    <?php endforeach?>
</div>
<br>

<?php $multiply_rrs = $_SESSION["task"]["multiply_rrs"]?>
<label class="task_label">
    4. részfeladat: Határozd meg a 
    <?="(\u{2124}" . "/"?><span class="bottom"><?=$multiply_rrs[2][0]?></span><?="\u{2124})*"?>
    és
    <?="(\u{2124}" . "/"?><span class="bottom"><?=$multiply_rrs[2][1]?></span><?="\u{2124})*"?> 
    redukált maradékrendszerek egyes szorzat maradékosztályainak egy-egy reprezentatív elemét!
</label>
<div class="small_task_container">
        <!-- Táblázat ide -->
</div>
<br>