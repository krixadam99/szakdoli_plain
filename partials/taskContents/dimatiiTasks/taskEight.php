<?php $polynomials = $_SESSION["task"]["divide_polynomials"]?>
<?php $task_counter = 0?>
<?php $dividend_polynomial = $polynomials[0]?>
<?php $divisor_polynomial = $polynomials[1]?>
<label class="task_label">
    <?=1?>. részfeladat: Add meg a 
    <b>(<?php PrintPolynomialExpression($dividend_polynomial[0],$dividend_polynomial[1])?>) / (<?php PrintPolynomialExpression($divisor_polynomial[0],$divisor_polynomial[1])?>)</b>
    polinomosztás eredményét és maradékát a <?="\u{2124}"?><span class="bottom"><b><?=$polynomials[2]?></b></span>
    felett! A polinomok együtthatóit és a változó fokszámát a főegyütthatótól a konstans tagig haladva vesszővel elválasztva (együttható, változó fokszáma) alakban add meg (pl.: 2x<span class="exp">2</span>+3x+1 helyett írj (2,2),(3,1),(1,0)-t)!
</label>
<div class="small_task_container">
    <?php 
        $task_counter = $task_counter . "_0";
        $solution_label = "A hányadospolinom (együttható, fokszám) párosokkal megadva:";
        include("./partials/taskContents/solutionInput.php")
    ?>
    <?php 
        $task_counter = $task_counter . "_1";
        $solution_label = "A maradékpolinom (együttható, fokszám) párosokkal megadva:";
        include("./partials/taskContents/solutionInput.php")
    ?>
</div>

<!-- Hányszoros gyöke a (szám1) a (polinom1)-nek? -->
<!-- Határozzuk meg az a és b paraméterek értékét, hogy a (polinom1) polinomnak a (szám1) (szám2)-szeres gyöke legyen! -->

<?php $polynomials = $_SESSION["task"]["multiply_polynomials"]?>
<?php $task_counter = 3?>
<?php $mulitplicand_polynomial = $polynomials[0]?>
<?php $multiplier_polynomial = $polynomials[1]?>
<label class="task_label">
    <?=4?>. részfeladat: Add meg a 
    <b>(<?php PrintPolynomialExpression($mulitplicand_polynomial[0],$mulitplicand_polynomial[1])?>) * (<?php PrintPolynomialExpression($multiplier_polynomial[0],$multiplier_polynomial[1])?>)</b>
    polinomszorzás eredményét <?="\u{2124}"?><span class="bottom"><b><?=$polynomials[2]?></b></span>
    felett! Az eredménypolinom együtthatóit és a változók fokszámát a főegyütthatótól a konstans tagig haladva vesszővel elválasztva (együttható, változó fokszáma) alakban add meg (pl.: 2x<span class="exp">2</span>+3x+1 helyett írj (2,2),(3,1),(1,0)-t)!
</label>
<div class="small_task_container">
    <?php 
        $task_counter = $task_counter . "_0";
        $solution_label = "A szorzatpolinom (együttható, fokszám) párosokkal megadva:";
        include("./partials/taskContents/solutionInput.php")
    ?>
</div>