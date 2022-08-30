<?php $array_trigonometric = true?>
<?php $complex_number_names = ["v", "w", "x", "y", "z"]?>
<?php foreach($_SESSION["task"]["complex_numbers"] as $complex_number_counter => $complex_number):?>
    <label class="task_label">
        <?=$complex_number_names[$complex_number_counter] . " = " . $complex_number[0]?><?=$complex_number[1]>=0?" + ":" "?><?=$complex_number[1] . "*i"?>
    </label>
    <br>
<?php endforeach?>
<br>

<?php $task_counter = 0;?>
<label class="task_label">
    1. részfeladat: Add meg a fenti komplex számok trigonometrikus alakját! A hosszt és argumentumot 2 tizedesjegyre kerekítsd, és vesszővel válaszd el (példuául: 4.111*(cos(30.111°)+i*sin(30.111°)) helyett írj 4.11, 30.11-et)!
</label>
<br>
<?php foreach($_SESSION["task"]["complex_numbers"] as $complex_number_counter => $complex_number):?>
    <div class="small_task_container">
        <label class="task_label">
            <?=$complex_number[0]?><?=$complex_number[1]>=0?" + ":" "?><?=$complex_number[1] . "*i"?> trigonometrikus alakja:
        </label>
        <?php include("./partials/solutionInput.php")?>
    </div>
    <?php $task_counter++;?>
<?php endforeach?>
<br>

<label class="task_label">
    2. részfeladat: Végezd el a követekező műveleteket a Moivre-azonosságok segítségével! Az eredmény trigonometrikus alakját add meg! A hosszt és argumentumot 2 tizedesjegyre kerekítsd, és vesszővel válaszd el (példuául: 4.111*(cos(30.111°)+i*sin(30.111°)) helyett írj 4.11, 30.11-et)!
</label>
<?php $operations = $_SESSION["task"]["operations"]??"";?>
<?php for($subtask_counter = 0; $subtask_counter<4; $subtask_counter++):?>
    <div class="small_task_container">
        <label class="task_label">
            <?php if($subtask_counter%2 == 0):?>
                <?=$operations["multiplication"][$subtask_counter/2][0]?> * <?=$operations["multiplication"][$subtask_counter/2][1]?>
            <?php elseif($subtask_counter%2 == 1):?>
                <?=$operations["division"][$subtask_counter/2][0]?> / <?=$operations["division"][$subtask_counter/2][1]?>
            <?php endif?>
        </label>
        <br>
        <?php include("./partials/solutionInput.php")?>
        <?php $task_counter++;?>
    </div>
<?php endfor?>