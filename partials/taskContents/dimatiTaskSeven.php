<?php $array_trigonometric = true?>
<?php $complex_number_names = ["v", "w", "x"]?>
<?php foreach($_SESSION["task"]["complex_numbers"] as $complex_number_counter => $complex_number):?>
    <label class="task_label">
        <?=$complex_number_names[$complex_number_counter] . " = " . $complex_number[0]?><?=$complex_number[1]>=0?" + ":" "?><?=$complex_number[1] . "*i"?>
    </label>
    <br>
<?php endforeach?>
<br>

<?php $operations = $_SESSION["task"]["operations"]??"";?>
<?php $task_counter = 0;?>
<label class="task_label">
    1. részfeladat: Add meg a következő hatványozások eredményét! A hosszt és argumentumot 2 tizedesjegyre kerekítsd, és vesszővel válaszd el (példuául: 4.111*(cos(30.111°)+i*sin(30.111°)) helyett írj 4.11, 30.11-et)!
</label>
<br>
<?php for($subtask_counter = 0; $subtask_counter<3; $subtask_counter++):?>
    <div class="small_task_container">
        <label class="task_label">
            <?=$operations["power"][$subtask_counter][0]?> ^ <?=$operations["power"][$subtask_counter][1]?>
        </label>
        <br>
        <?php include("./partials/solutionInput.php")?>
        <?php $task_counter++;?>
    </div>
<?php endfor?>
<br>

<label class="task_label">
    2. részfeladat: Add meg a következő gyökvonások eredményét! Az eredmény trigonometrikus alakját add meg! A hosszt és argumentumokat 2 tizedesjegyre kerekítsd, a hosszt az argumentumktól pontos-vesszővel, az argumentumokat ,-vel válaszd el (példuául: <?="\u{221A}"?>-1 esetén 1; 90, 270-et írj))!
</label>
<?php for($subtask_counter = 0; $subtask_counter<2; $subtask_counter++):?>
    <div class="small_task_container">
        <label class="task_label">
            <?=$operations["root"][$subtask_counter][0]?> ^ 1/<?=$operations["root"][$subtask_counter][1]?>
        </label>
        <br>
        <?php include("./partials/solutionInput.php")?>
        <?php $task_counter++;?>
    </div>
<?php endfor?>
<br>