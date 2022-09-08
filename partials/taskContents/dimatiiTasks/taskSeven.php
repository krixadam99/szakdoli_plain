<?php $polynomial_names = ["P[x]", "Q[x]"]?>
<?php foreach($_SESSION["task"]["polynomials"] as $task_index => $polynomial_task_details):?>
    <?php $task_counter = $task_index?>
    <label class="task_label">
        <?=$task_index + 1?>. részfeladat: Add meg a <?=$polynomial_names[$task_index]?> = 
        <?php
        $polynomial_degree = $polynomial_task_details[0];
        foreach($polynomial_task_details[1] as $coefficient_index => $coefficient){
            $actual_index = $polynomial_degree - $coefficient_index;
            
            $prefix = "";
            if($coefficient_index != 0){
                $prefix = $coefficient < 0?" - ":" + ";
                $coefficient = abs($coefficient);
            }
            if($coefficient != 0){
                $coefficient = $coefficient === 1 && $actual_index !== 0?"":$coefficient;
                $coefficient = $coefficient === -1 && $coefficient_index === 0?"-":$coefficient;
                $variable = $actual_index === 0?"":"x";
                $expo = $actual_index <= 1?"":"<span class=\"exp\">$actual_index</span>";
                echo($prefix . $coefficient . $variable . $expo);
            }
        }?> 
        polinom helyettesítési értékét a
        <?php
        for($place_counter = 0; $place_counter < count($polynomial_task_details[2]); $place_counter++){
            $prefix = $place_counter !== 0?', ':'';
            echo($prefix . $polynomial_task_details[2][$place_counter]);
        }?>
        helyeken a Horner-táblázat segítségével!
    </label>
    <div class="small_task_container">
        <?php 
            $row_number = count($polynomial_task_details[2]);
            $column_number = $polynomial_task_details[0]+3;
            $table_header_cells = ["x"];
            $first_cell_datas = $polynomial_task_details[2];
            for($column_counter = 1; $column_counter < $column_number-1; $column_counter++){
                array_push($table_header_cells, "p<span class=\"bottom\">" .  $polynomial_task_details[0] - $column_counter + 1 . "</span> = " . $polynomial_task_details[1][$column_counter - 1]);
            }
            array_push($table_header_cells, $polynomial_names[$task_index]);
        ?>
        <?php include("./partials/taskContents/solutionTable.php")?>
    </div>
<?php endforeach?>