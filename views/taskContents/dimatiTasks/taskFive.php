<?php foreach($_SESSION["task"]["first_subtasks"]["complex_numbers"] as $complex_number_counter => $complex_number):?>
    <?php $bottom_index = $complex_number_counter + 1?>
    <div class="small_task_container">
        <label class="task_label">
            1.<?= $complex_number_counter + 1 ?>. részfeladat: Add meg a
                <?= PrintServices::CreatePrintableComplexNumberAlgebraic("v<span class=\"bottom\">$bottom_index</span>", $complex_number)?>
            komplex szám tulajdonságait!
        </label>
        <?php 
            $solution_label = "<label>Re(v<span class=\"bottom\">$bottom_index</span>) = </label>";
            $task_counter = "0_" . $complex_number_counter . "_0";
            include("./views/taskContents/solutionInput.php");
        ?>
        <?php 
            $solution_label = "<label>Im(v<span class=\"bottom\">$bottom_index</span>) = </label>";
            $task_counter = "0_" . $complex_number_counter . "_1";
            include("./views/taskContents/solutionInput.php");
        ?>
        <?php 
            $solution_label = "<label>|v<span class=\"bottom\">$bottom_index</span>| = </label>";
            $task_counter = "0_" . $complex_number_counter . "_2";
            include("./views/taskContents/solutionInput.php");
        ?>
        <?php
            $solution_label = "<label style=\"text-decoration: overline;margin:0%\" >v</label><span class=\"bottom\">$bottom_index</span><label style=\"margin-right:2%\"> = </label>"; 
            $task_counter = "0_" . $complex_number_counter . "_3";
            include("./views/taskContents/solutionInput.php");
        ?>
    </div>
<?php endforeach?>

<?php foreach($_SESSION["task"]["second_subtasks"][0] as $quadrupel_of_complex_numbers_counter => $quadrupel_of_complex_numbers):?>
    <?php $bottom_index = $quadrupel_of_complex_numbers_counter + 1?>
    <div class="small_task_container">
        <label class="task_label">
            2.<?= $quadrupel_of_complex_numbers_counter + 1 ?>. részfeladat: Adottak a következő komplex számok:
            <?php $complex_number_counter = 0?>
            <?php foreach($quadrupel_of_complex_numbers as $complex_number_name => $complex_number):?>
                <?php if($complex_number_counter !== 0):?>
                    , 
                <?php endif?>
                <?= PrintServices::CreatePrintableComplexNumberAlgebraic("$complex_number_name<span class=\"bottom\">$bottom_index</span>", $complex_number)?>
                <?php $complex_number_counter++?>
            <?php endforeach?> add meg az alábbi műveletek eredményét!
        </label>
    </div>



    <?php $operation_counter = 0;?>
    <?php $operations = $_SESSION["task"]["second_subtasks"][1][$quadrupel_of_complex_numbers_counter]??"";?>
    <?php foreach($operations as $operation_name => $operation):?>
        <?php $task_counter = "1_" . $quadrupel_of_complex_numbers_counter . "_" . $operation_counter?>
        <div class="small_task_container">
            <?php 
                $operands = $operation[0];
            ?>
            <?php if($operation_name === "addition"):?>
                <?php 
                    $solution_label = "<label >" . $operands[0] . "<span class=\"bottom\">$bottom_index</span> + " . $operands[1] . "<span class=\"bottom\">$bottom_index</span> = </label>";
                ?>
            <?php elseif($operation_name === "multiplication"):?>
                <?php 
                    $solution_label = "<label>" . $operands[0] . "<span class=\"bottom\">$bottom_index</span> * " . $operands[1] . "<span class=\"bottom\">$bottom_index</span> = </label>";
                ?>
            <?php elseif($operation_name === "substraction"):?>
                <?php 
                    $solution_label = "<label>" . $operands[0] . "<span class=\"bottom\">$bottom_index</span> - " . $operands[1] . "<span class=\"bottom\">$bottom_index</span> = </label>";
                ?>
            <?php elseif($operation_name === "division"):?>
                <?php 
                    $solution_label = "<label>" . $operands[0] . "<span class=\"bottom\">$bottom_index</span> / " . $operands[1] . "<span class=\"bottom\">$bottom_index</span> = </label>";
                ?>
            <?php endif?>
            <?php include("./views/taskContents/solutionInput.php")?>
        </div>
        <?php $task_counter++;?>
        <?php $operation_counter++?>
    <?php endforeach?>
<?php endforeach?>