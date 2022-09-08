<table class="solution_table">
    <tr>
        <?php foreach($table_header_cells as $index => $table_header_cell):?>
            <th><?php echo($table_header_cell)?></th>
        <?php endforeach?>
    </tr>
    <?php for($row_counter=0; $row_counter < $row_number; $row_counter++):?>
        <tr>
            <?php for($column_counter=0; $column_counter < $column_number; $column_counter++):?>
                <?php $width = $column_counter !== ($column_number - 1)?80/($column_number-1):20?>
                <?php if($column_counter > 1):?>
                    <td style="width:<?=$width?>%"><input type="text" name=<?="solution_" . $task_counter . "_" . $row_counter . "_" . $column_counter-2 ?> value="..." class="solution_input"></td>
                <?php elseif($column_counter == 0):?>
                    <td style="width:<?=$width?>%">x<span class="bottom"><?=$row_counter + 1?></span> = <?=$first_cell_datas[$row_counter]??""?></td>
                <?php elseif($column_counter == 1):?>
                    <td style="width:<?=$width?>%">-</td>
                <?php endif?>
            <?php endfor?>
        </tr>
    <?php endfor?>
</table>