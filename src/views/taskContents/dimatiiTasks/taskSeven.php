<?php $polynomial_names = ["P[x]", "Q[x]", "R[x]"]?>
<?php $polynomials = $_SESSION["task"]["polynomials"]?>
<?php foreach($polynomials as $task_index => $polynomial_task_details):?>
    <?php $task_counter = $task_index?>
    <label class="task_label">
        <?=$task_index + 1?>. részfeladat: Add meg a <?=$polynomial_names[$task_index]?> = 
        <?= PrintServices::CreatePrintablePolynomial($polynomial_task_details[1])?> 
        polinom helyettesítési értékét a
        <?= PrintServices::CreatePrintablePlaces($polynomial_task_details[2])?>
        helyeken a Horner- elrendezeés segítségével!
    </label>
    <div class="small_task_container">
        <?php 
            $row_number = count($polynomial_task_details[2]);
            $column_number = $polynomial_task_details[0]+3;
            $table_header_cells = ["x"];
            $first_cell_datas = $polynomial_task_details[2];
            $first_cell_should_be_filled = false;
            for($column_counter = 1; $column_counter < $column_number-1; $column_counter++){
                array_push($table_header_cells, "p<sub>" .  $polynomial_task_details[0] - $column_counter + 1 . "</sub> = " . $polynomial_task_details[1][$column_counter - 1]);
            }
            array_push($table_header_cells, $polynomial_names[$task_index]);
            $cell_with_solution = true;
        ?>
        <?php include("./views/taskContents/solutionTable.php")?>
    </div>
<?php endforeach?>

<?php $divide_polynomials = $_SESSION["task"]["divide_polynomials"]?>
<?php $task_counter = 2?>
<label class="task_label">
    <?=3?>. részfeladat: Add meg a <?=$polynomial_names[2]?> = 
    <?= PrintServices::CreatePrintablePolynomial($divide_polynomials[1])?> polinom hányadospolinomát és maradékát az (x <?=$divide_polynomials[2][0] > 0 ?" - ":" + "?> <?=abs($divide_polynomials[2][0])?>) 
    polinommal osztva! Az osztáshoz használd a Horner- elrendezést!
</label>
<div class="small_task_container">
    <?php 
        $row_number = 1;
        $column_number = $divide_polynomials[0]+3;
        $table_header_cells = ["x"];
        $first_cell_should_be_filled = true;
        for($column_counter = 1; $column_counter < $column_number-1; $column_counter++){
            array_push($table_header_cells, "p<sub>" .  $divide_polynomials[0] - $column_counter + 1 . "</sub> = " . $divide_polynomials[1][$column_counter - 1]);
        }
        array_push($table_header_cells, $polynomial_names[2]);
    ?>
    <?php include("./views/taskContents/solutionTable.php")?>
    <?php 
        $solution_label = "A hányadospolinom (együttható, fokszám) párosokkal megadva:";
        $task_counter = "2_1";
        $cell_with_solution = true;
        include("./views/taskContents/solutionInput.php")
    ?>
    <?php 
        $solution_label = "A maradékpolinom (együttható, fokszám) párosokkal megadva:";
        $task_counter = "2_2";
        $cell_with_solution = true;
        include("./views/taskContents/solutionInput.php")
    ?>
</div>