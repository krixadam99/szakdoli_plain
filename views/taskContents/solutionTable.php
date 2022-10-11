<table class="solution_table">
    <tr>
        <?php foreach($table_header_cells as $index => $table_header_cell):?>
            <th>
                <?php echo($table_header_cell)?>
            </th>
        <?php endforeach?>
    </tr>
    <?php for($row_counter=0; $row_counter < $row_number; $row_counter++):?>
        <tr>
            <?php for($column_counter=0; $column_counter < $column_number; $column_counter++):?>
                <?php $width = $column_counter !== ($column_number - 1)?65/($column_number-3):15?>
                <?php if($column_counter > 1):?>
                    <td style="width:<?=$width?>%">
                        <?php $current_answer = $_SESSION["answers"]["answer_" . $task_counter . "_" . $row_counter . "_" . $column_counter-2]??"";?>
                        <input type="text" name=<?="solution_" . $task_counter . "_" . $row_counter . "_" . $column_counter-2 ?> value="<?=$current_answer["answer"]??"..."?>" class="<?=IsCorrect($current_answer)?>" <?=$current_answer !== ""?"readonly":""?>>
                    </td>
                <?php elseif($column_counter == 0):?>
                    <td style="width:10%">
                        <?php if(!$first_cell_should_be_filled):?>
                            x<span class="bottom"><?=$row_counter + 1?></span> = <?=$first_cell_datas[$row_counter]??""?>
                        <?php else:?>
                            <?php $current_answer = $_SESSION["answers"]["answer_" . $task_counter . "_0"]??"";?>
                            <input type="text" name=<?="solution_" . $task_counter . "_0" ?> value="<?=$current_answer["answer"]??"x = ..."?>" class="<?=IsCorrect($current_answer)?>" <?=$current_answer !== ""?"readonly":""?>>
                        <?php endif?>
                    </td>
                <?php elseif($column_counter == 1):?>
                    <td style="width:10%">
                        -
                    </td>
                <?php endif?>
            <?php endfor?>
        </tr>
    <?php endfor?>
</table>

