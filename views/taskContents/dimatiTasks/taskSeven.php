<?php foreach($_SESSION["task"]["first_subtasks"]["complex_numbers"] as $complex_number_counter => $complex_number):?>
    <?php 
        $bottom_index = $complex_number_counter + 1;
        $actual_power = $_SESSION["task"]["first_subtasks"]["powers"][$complex_number_counter];
    ?>
    <div class="small_task_container">
        <label class="task_label">
            1.<?= $complex_number_counter + 1 ?>. részfeladat: Add meg a
                (v<span class=bottom><?=$bottom_index?></span>)<span class="exp"><?=$actual_power[0]?></span> = 
                (<?= PrintServices::CreatePrintableComplexNumberAlgebraic("", $complex_number, false)?>) <span class="exp"><?=$actual_power[0]?></span> és 
                (v<span class=bottom><?=$bottom_index?></span>)<span class="exp"><?=$actual_power[1]?></span> = 
                (<?= PrintServices::CreatePrintableComplexNumberAlgebraic("", $complex_number, false)?>) <span class="exp"><?=$actual_power[1]?></span> 
            hatványozások eredményét a trigonometrikus alak segítségével! A hosszt és argumentumot 2 tizedesjegyre kerekítsd, és vesszővel válaszd el (példuául: 4.111*(cos(1.2*pi)+i*sin(1.2*pi)) helyett írj 4.11, 1.2-et)
        </label>
        <?php 
            $solution_label = "<label>v<span class=\"bottom\">$bottom_index</span><span class=\"exp\">" . $actual_power[0] . "</span> = </label>";
            $task_counter = "0_" . $complex_number_counter . "_0";
            include("./views/taskContents/solutionInput.php");
        ?>
        <?php 
            $solution_label = "<label>v<span class=\"bottom\">$bottom_index</span><span class=\"exp\">" . $actual_power[1] . "</span> = </label>";
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
                <span class="exp"><?=$actual_root[0]?></span><?="\u{221A}"?>v<span class=bottom><?=$bottom_index?></span> = 
                <span class="exp"><?=$actual_root[0]?></span><?="\u{221A}"?>(<?= PrintServices::CreatePrintableComplexNumberAlgebraic("", $complex_number, false)?>) és 
                <span class="exp"><?=$actual_root[1]?></span><?="\u{221A}"?>v<span class=bottom><?=$bottom_index?></span> = 
                <span class="exp"><?=$actual_root[1]?></span><?="\u{221A}"?>(<?= PrintServices::CreatePrintableComplexNumberAlgebraic("", $complex_number, false)?>)
            gyökvonások eredményét a trigonometrikus alak segítségével! A hosszt és argumentumot 2 tizedesjegyre kerekítsd, és vesszővel válaszd el (példuául: 4.111*(cos(1.2*pi)+i*sin(1.2*pi)) helyett írj 4.11, 1.2-et)
        </label>
        <?php 
            $solution_label = "<label><span class=\"exp\">" . $actual_root[0] . "</span>\u{221A}v<span class=\"bottom\">$bottom_index</span> = </label>";
            $task_counter = "1_" . $complex_number_counter . "_0";
            include("./views/taskContents/solutionInput.php");
        ?>
        <?php 
            $solution_label = "<label><span class=\"exp\">" . $actual_root[1] . "</span>\u{221A}v<span class=\"bottom\">$bottom_index</span> = </label>";
            $task_counter = "1_" . $complex_number_counter . "_1";
            include("./views/taskContents/solutionInput.php");
        ?>
    </div>
<?php endforeach?>