<?php $array_complex = true?>
<?php $complex_number_names = ["v", "w", "x", "y", "z"]?>
<?php foreach($_SESSION["task"]["complex_numbers"] as $complex_number_counter => $complex_number):?>
    <label class="task_label">
        <?=$complex_number_names[$complex_number_counter] . " = " . $complex_number[0]?><?=$complex_number[1]>=0?" + ":" "?><?=$complex_number[1] . "*i"?>
    </label>
    <br>
<?php endforeach?>
<br>

<?php $task_counter = 0;?>
<div class="small_task_container">
    <?php $complex_number_counter = $_SESSION["task"]["random_number"];?>
    <label class="task_label">
        1. részfeladat: Add meg a <?=$complex_number_names[$complex_number_counter]?> komplex szám alapvető tulajdonságait!
    </label>
    <br>
    <label class="task_label">Re(<?=$complex_number_names[$complex_number_counter]?>)</label>
    <?php include("./partials/solutionInput.php")?>
    <label class="task_label">Im(<?=$complex_number_names[$complex_number_counter]?>)</label>
    <?php $task_counter++;?>
    <?php include("./partials/solutionInput.php")?>
    <label class="task_label">|<?=$complex_number_names[$complex_number_counter]?>|</label>
    <?php $task_counter++;?>
    <?php include("./partials/solutionInput.php")?>
    <label class="task_label" style="text-decoration: overline"><?=$complex_number_names[$complex_number_counter]?></label>
    <?php $task_counter++;?>
    <?php include("./partials/solutionInput.php")?>
</div>
<br>

<?php $task_counter++;?>
<label class="task_label">
    2. részfeladat: Add meg a következő műveletek eredményét! Megoldásodban a valós- és képzetes részt vesszővel válaszd el (például: 1 + 2i helyett 1, 2)!
</label>
<?php $operations = $_SESSION["task"]["operations"]??"";?>
<?php for($subtask_counter = 0; $subtask_counter<8; $subtask_counter++):?>
    <div class="small_task_container">
        <label class="task_label">
            <?php if($subtask_counter%4 == 0):?>
                <?=$operations["addition"][$subtask_counter/4][0]?> + <?=$operations["addition"][$subtask_counter/4][1]?>
            <?php elseif($subtask_counter%4 == 1):?>
                <?=$operations["multiplication"][$subtask_counter/4][0]?> * <?=$operations["multiplication"][$subtask_counter/4][1]?>
            <?php elseif($subtask_counter%4 == 2):?>
                <?=$operations["substraction"][$subtask_counter/4][0]?> - <?=$operations["substraction"][$subtask_counter/4][1]?>
            <?php elseif($subtask_counter%4 == 3):?>
                <?=$operations["division"][$subtask_counter/4][0]?> / <?=$operations["division"][$subtask_counter/4][1]?>
            <?php endif?>
        </label>
        <br>
        <?php include("./partials/solutionInput.php")?>
        <?php $task_counter++;?>
    </div>
<?php endfor?>

<label class="task_label">
    3. részfeladat: Old meg a következő másodfokú egyenletet a komplex számok halmazán! Válaszodban a valós- és képzetes részt 2 tizedesjegy pontossággal add meg!
</label>
<?php $coefficients = $_SESSION["task"]["coefficients"]??"";?>
<div class="small_task_container">
    <label class="task_label"><?=$coefficients[0] . "*x^2"?> + <?=$coefficients[1] . "*x"?> + <?=$coefficients[2] . " = 0"?></label>
    <?php include("./partials/solutionInput.php")?>
</div>