<?php foreach($_SESSION["task"]["first_subtasks"]["coefficients"] as $first_task_counter => $coefficients):?>
    <?php $exponents = $_SESSION["task"]["first_subtasks"]["exponents"][$first_task_counter]?>
    <?php $result_expression_exponent = $_SESSION["task"]["first_subtasks"]["result_expressions_exponent"][$first_task_counter]?>
    <div class="small_task_container">
        <label class="task_label">
            1.<?= $first_task_counter + 1 ?>. részfeladat: Add meg a
            (<?=$coefficients[0]?>*x<span class="exp"><?=$exponents[0]?></span>
            <?=PrintServices::PlusMinus($coefficients[1])?><?=abs($coefficients[1])?>*x<span class="exp"><?=$exponents[1]?></span>)
            <span class="exp"><?=$exponents[2]?></span> kifejezésben az x<span class="exp"><?=$result_expression_exponent?></span> tag együtthatóját!
        </label>
        <?php 
            $solution_label = "<label>x<span class=\"exp\">" . $result_expression_exponent . "</span> * </label>";
            $task_counter = "0_" . $first_task_counter;
            include("./views/taskContents/solutionInput.php");
        ?>
    </div>
<?php endforeach?>

<?php foreach($_SESSION["task"]["second_subtasks"]["polynomial_expression_roots"] as $second_task_counter => $polynomial_expression_roots):?>
    <?php $main_coefficient = $_SESSION["task"]["second_subtasks"]["main_coefficients"][$second_task_counter]?>
    <div class="small_task_container">
        <label class="task_label">
            2.<?= $second_task_counter + 1 ?>. részfeladat: Add meg a Viéte formulák segítségével azt a polinomot, amelynek a <b>zérushelyei:
            <?= PrintServices::CreatePrintablePlaces($polynomial_expression_roots)?></b> és a <b>főegyütthatója <?=$main_coefficient?></b>! 
            Az polinom együtthatóit és a változók fokszámát a főegyütthatótól a konstans tagig haladva vesszővel elválasztva (együttható, változó fokszáma) alakban add meg (pl.: 2x<span class="exp">2</span>+3x+1 helyett írj (2,2),(3,1),(1,0)-t)
        </label>
        <?php 
            $solution_label = "<label>P[x] = </label>";
            $task_counter = "1_" . $second_task_counter;
            include("./views/taskContents/solutionInput.php");
        ?>
    </div>
<?php endforeach?>