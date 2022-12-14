<?php foreach($_SESSION["task"]["first_subtasks"]["pairs_of_complex_numbers"] as $complex_number_pair_counter => $complex_numbers_pair):?>
    <?php $bottom_index = $complex_number_pair_counter + 1?>
    <div class="small_task_container">
        <label class="task_label">
            1.<?= $complex_number_pair_counter + 1 ?>. részfeladat: Add meg a
                <?= PrintServices::CreatePrintableComplexNumberAlgebraic("v<sub>$bottom_index</sub>", $complex_numbers_pair[0])?>, 
                <?= PrintServices::CreatePrintableComplexNumberAlgebraic("w<sub>$bottom_index</sub>", $complex_numbers_pair[1])?>
            komplex számok trigonometrikus alakját! A hosszt és argumentumot 2 tizedesjegyre kerekítsd, és vesszővel válaszd el (például: 4.111*(cos(1.2*pi)+i*sin(1.2*pi)) helyett írj 4.11, 1.2-et)!
        </label>
        <?php 
            $solution_label = "<label>v<sub>$bottom_index</sub> = </label>";
            $task_counter = "0_" . $complex_number_pair_counter . "_0";
            include("./views/taskContents/solutionInput.php");
        ?>
        <?php 
            $solution_label = "<label>w<sub>$bottom_index</sub> = </label>";
            $task_counter = "0_" . $complex_number_pair_counter . "_1";
            include("./views/taskContents/solutionInput.php");
        ?>
    </div>
<?php endforeach?>

<?php foreach($_SESSION["task"]["second_subtasks"]["pairs_of_complex_numbers"] as $complex_number_pair_counter => $complex_numbers_pair):?>
    <?php $bottom_index = $complex_number_pair_counter + 1?>
    <div class="small_task_container">
        <label class="task_label">
            2.<?= $complex_number_pair_counter + 1 ?>. részfeladat: Adottak a
                <?= PrintServices::CreatePrintableComplexNumberAlgebraic("v<sub>$bottom_index</sub>", $complex_numbers_pair[0])?>, 
                <?= PrintServices::CreatePrintableComplexNumberAlgebraic("w<sub>$bottom_index</sub>", $complex_numbers_pair[1])?>
            komplex számok! Számold ki a komplex számok szorzatát és hányadosát a trigonometrikus alak felhasználásával! A hosszt és argumentumot 2 tizedesjegyre kerekítsd, és vesszővel válaszd el (például: 4.111*(cos(1.2*pi)+i*sin(1.2*pi)) helyett írj 4.11, 1.2-et)!
        </label>
        <?php 
            $solution_label = "<label>v<sub>$bottom_index</sub> * w<sub>$bottom_index</sub> = </label>";
            $task_counter = "1_" . $complex_number_pair_counter . "_0";
            include("./views/taskContents/solutionInput.php");
        ?>
        <?php 
            $solution_label = "<label>v<sub>$bottom_index</sub> / w<sub>$bottom_index</sub> = </label>";
            $task_counter = "1_" . $complex_number_pair_counter . "_1";
            include("./views/taskContents/solutionInput.php");
        ?>
    </div>
<?php endforeach?>