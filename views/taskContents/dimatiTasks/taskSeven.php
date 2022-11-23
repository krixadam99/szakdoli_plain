<?php foreach($_SESSION["task"]["first_subtasks"]["complex_numbers"] as $complex_number_counter => $complex_number):?>
    <?php 
        $bottom_index = $complex_number_counter + 1;
        $actual_power = $_SESSION["task"]["first_subtasks"]["powers"][$complex_number_counter];
    ?>
    <div class="small_task_container">
        <label class="task_label">
            1.<?= $complex_number_counter + 1 ?>. részfeladat: Add meg a
                (v<sub><?=$bottom_index?></sub>)<sup><?=$actual_power[0]?></sup> = 
                (<?= PrintServices::CreatePrintableComplexNumberAlgebraic("", $complex_number, false)?>) <sup><?=$actual_power[0]?></sup> és 
                (v<sub><?=$bottom_index?></sub>)<sup><?=$actual_power[1]?></sup> = 
                (<?= PrintServices::CreatePrintableComplexNumberAlgebraic("", $complex_number, false)?>) <sup><?=$actual_power[1]?></sup> 
            hatványozások eredményét a trigonometrikus alak segítségével! A hosszt és argumentumot 2 tizedesjegyre kerekítsd, és vesszővel válaszd el (példuául: 4.111*(cos(1.2*pi)+i*sin(1.2*pi)) helyett írj 4.11, 1.2-et)
        </label>
        <?php 
            $solution_label = "<label>v<sub>$bottom_index</sub><sup>" . $actual_power[0] . "</sup> = </label>";
            $task_counter = "0_" . $complex_number_counter . "_0";
            include("./views/taskContents/solutionInput.php");
        ?>
        <?php 
            $solution_label = "<label>v<sub>$bottom_index</sub><sup>" . $actual_power[1] . "</sup> = </label>";
            $task_counter = "0_" . $complex_number_counter . "_1";
            include("./views/taskContents/solutionInput.php");
        ?>
    </div>
<?php endforeach?>

<?php foreach($_SESSION["task"]["second_subtasks"]["complex_numbers"] as $complex_number_counter => $complex_number):?>
    <?php 
        $bottom_index = $complex_number_counter + 1;
        $actual_root = $_SESSION["task"]["second_subtasks"]["roots"][$complex_number_counter];
    ?>
    <div class="small_task_container">
        <label class="task_label">
            2.<?= $complex_number_counter + 1 ?>. részfeladat: Add meg a
                <sup><?=$actual_root[0]?></sup><?="\u{221A}"?>v<sub><?=$bottom_index?></sub> = 
                <sup><?=$actual_root[0]?></sup><?="\u{221A}"?>(<?= PrintServices::CreatePrintableComplexNumberAlgebraic("", $complex_number, false)?>) és 
                <sup><?=$actual_root[1]?></sup><?="\u{221A}"?>v<sub><?=$bottom_index?></sub> = 
                <sup><?=$actual_root[1]?></sup><?="\u{221A}"?>(<?= PrintServices::CreatePrintableComplexNumberAlgebraic("", $complex_number, false)?>)
            gyökvonások eredményét a trigonometrikus alak segítségével! A hosszt és argumentumot 2 tizedesjegyre kerekítsd, és vesszővel válaszd el (példuául: 4.111*(cos(1.2*pi)+i*sin(1.2*pi)) helyett írj 4.11, 1.2-et)
        </label>
        <?php 
            $solution_label = "<label><sup>" . $actual_root[0] . "</sup>\u{221A}v<sub>$bottom_index</sub> = </label>";
            $task_counter = "1_" . $complex_number_counter . "_0";
            include("./views/taskContents/solutionInput.php");
        ?>
        <?php 
            $solution_label = "<label><sup>" . $actual_root[1] . "</sup>\u{221A}v<sub>$bottom_index</sub> = </label>";
            $task_counter = "1_" . $complex_number_counter . "_1";
            include("./views/taskContents/solutionInput.php");
        ?>
    </div>
<?php endforeach?>

<?php var_dump($_SESSION["solution"])?>