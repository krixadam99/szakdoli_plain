<?php $polynomial_names = ["P[x]", "Q[x]", "R[x]"]?>
<?php $polynomials = $_SESSION["task"]["polynomials"]?>
<?php foreach($polynomials as $task_index => $polynomial_task_details):?>
    <?php $task_counter = $task_index?>
    <label class="task_label">
        <?=$task_index + 1?>. részfeladat: Add meg a <?=$polynomial_names[$task_index]?> = 
        <?php PrintServices::CreatePrintablePolynomial($polynomial_task_details[1])?> 
        polinom helyettesítési értékét a
        <?= PrintServices::CreatePrintablePlaces($polynomial_task_details[2])?>
        helyeken a Horner-táblázat segítségével!
    </label>
    <div class="small_task_container">
        <?php 
            $row_number = count($polynomial_task_details[2]);
            $column_number = $polynomial_task_details[0]+3;
            $table_header_cells = ["x"];
            $first_cell_datas = $polynomial_task_details[2];
            $first_cell_should_be_filled = false;
            for($column_counter = 1; $column_counter < $column_number-1; $column_counter++){
                array_push($table_header_cells, "p<span class=\"bottom\">" .  $polynomial_task_details[0] - $column_counter + 1 . "</span> = " . $polynomial_task_details[1][$column_counter - 1]);
            }
            array_push($table_header_cells, $polynomial_names[$task_index]);
        ?>
        <?php include("./partials/taskContents/solutionTable.php")?>
    </div>
<?php endforeach?>

<?php $divide_polynomials = $_SESSION["task"]["divide_polynomials"]?>
<?php $task_counter = 2?>
<label class="task_label">
    <?=3?>. részfeladat: Add meg a <?=$polynomial_names[2]?> = 
    <?php PrintServices::CreatePrintablePolynomialByPairs($divide_polynomials[0],$divide_polynomials[1])?> polinom hányadospolinomát és maradékát az (x <?=$divide_polynomials[2][0] > 0 ?" - ":" + "?> <?=abs($divide_polynomials[2][0])?>) 
    polinommal osztva! Az osztáshoz használd a Horner-táblázatot!
</label>
<div class="small_task_container">
    <?php 
        $row_number = 1;
        $column_number = $divide_polynomials[0]+3;
        $table_header_cells = ["x"];
        $first_cell_should_be_filled = true;
        for($column_counter = 1; $column_counter < $column_number-1; $column_counter++){
            array_push($table_header_cells, "p<span class=\"bottom\">" .  $divide_polynomials[0] - $column_counter + 1 . "</span> = " . $divide_polynomials[1][$column_counter - 1]);
        }
        array_push($table_header_cells, $polynomial_names[2]);
    ?>
    <?php include("./partials/taskContents/solutionTable.php")?>
    <?php 
        $solution_label = "A hányadospolinom (együttható, fokszám) párosokkal megadva:";
        $task_counter = "2_1";
        include("./partials/taskContents/solutionInput.php")
    ?>
    <?php 
        $solution_label = "A maradékpolinom (együttható, fokszám) párosokkal megadva:";
        $task_counter = "2_2";
        include("./partials/taskContents/solutionInput.php")
    ?>
</div>