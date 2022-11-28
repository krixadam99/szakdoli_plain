<?php $polynomials = $_SESSION["task"]["divide_polynomials"]?>
<?php $task_counter = 0?>
<?php $dividend_polynomial = $polynomials[0]?>
<?php $divisor_polynomial = $polynomials[1]?>
<label class="task_label">
    <?=1?>. részfeladat: Add meg a 
    <b>(<?php PrintServices::PrintPolynomialExpression($dividend_polynomial[0],$dividend_polynomial[1])?>) / (<?php PrintServices::PrintPolynomialExpression($divisor_polynomial[0],$divisor_polynomial[1])?>)</b>
    polinomosztás eredményét és maradékát az <?="\u{211D}"?>
    felett! A polinomok együtthatóit és a változó fokszámát a főegyütthatótól a konstans tagig haladva vesszővel elválasztva (együttható, változó fokszáma) alakban add meg (például: 2x<sup>2</sup>+3x+1 helyett írj (2,2),(3,1),(1,0)-t)!
</label>
<div class="small_task_container">
    <?php 
        $task_counter = "0_0";
        $solution_label = "A hányadospolinom (együttható, fokszám) párosokkal megadva:";
        include("./views/taskContents/solutionInput.php")
    ?>
    <?php 
        $task_counter = "0_1";
        $solution_label = "A maradékpolinom (együttható, fokszám) párosokkal megadva:";
        include("./views/taskContents/solutionInput.php")
    ?>
</div>

<?php $polynomials = $_SESSION["task"]["multiply_polynomials"]?>
<?php $task_counter = 1?>
<?php $mulitplicand_polynomial = $polynomials[0]?>
<?php $multiplier_polynomial = $polynomials[1]?>
<label class="task_label">
    <?=2?>. részfeladat: Add meg a 
    <b>(<?php PrintServices::PrintPolynomialExpression($mulitplicand_polynomial[0],$mulitplicand_polynomial[1])?>) * (<?php PrintServices::PrintPolynomialExpression($multiplier_polynomial[0],$multiplier_polynomial[1])?>)</b>
    polinomszorzás eredményét <?="\u{2124}"?><sub><b><?=$polynomials[2]?></b></sub>
    felett! Az eredménypolinom együtthatóit és a változók fokszámát a főegyütthatótól a konstans tagig haladva vesszővel elválasztva (együttható, változó fokszáma) alakban add meg (például: 2x<sup>2</sup>+3x+1 helyett írj (2,2),(3,1),(1,0)-t)!
</label>
<div class="small_task_container">
    <?php 
        $task_counter = $task_counter . "_0";
        $solution_label = "A szorzatpolinom (együttható, fokszám) párosokkal megadva:";
        include("./views/taskContents/solutionInput.php")
    ?>
</div>