<?php $lagrange_points = $_SESSION["task"]["lagrange_points"]?>
<label class="task_label">
    1. részfeladat: Illessz polinomot a <?= PrintServices::PrintPoints($lagrange_points)?> pontokra a Lagrange-féle interpolációval! 
    Míg megfelelő ponthoz tartozó alappolinomot az <i>l</i><sub>pont</sub>[x], addig a Lagrange-féle interpolációs polinomot az <i>L</i>[x] jelöli.
    A polinomok együtthatóit és a változók fokszámát a főegyütthatótól a konstans tagig haladva vesszővel elválasztva (együttható, változó fokszáma) alakban add meg (például: 2x<sup>2</sup>+3x+1 helyett írj (2,2),(3,1),(1,0)-t)!
    Az együtthatókat 2 tizedesjegy pontossággal add meg!
</label>
<div class="small_task_container">
    <?php for($point_counter = 0; $point_counter < count($lagrange_points); $point_counter++):?>
        <?php 
            $task_counter = "0_" . $point_counter;
            $solution_label = "<i>l</i><sub>(" . $lagrange_points[$point_counter][0] . ", " . $lagrange_points[$point_counter][1] . ")</sub>[x] = ";
            include("./views/taskContents/solutionInput.php")
        ?>
    <?php endfor?>
    <?php 
        $task_counter = "0_" . count($lagrange_points);
        $solution_label = "<i>L</i>[x] = ";
        include("./views/taskContents/solutionInput.php")
    ?>
</div>

<?php $newton_points = $_SESSION["task"]["newton_points"]?>
<?php $task_counter = 1?>
<label class="task_label">
    2. részfeladat: Illessz polinomot a <?= PrintServices::PrintPoints($newton_points)?> pontokra a Newton-féle interpolációval!
    Az interpolációs polinom (<i>N</i>[x]) együtthatóit és a változók fokszámát a főegyütthatótól a konstans tagig haladva vesszővel elválasztva (együttható, változó fokszáma) alakban add meg (például: 2x<sup>2</sup>+3x+1 helyett írj (2,2),(3,1),(1,0)-t)!
    Az együtthatókat 2 tizedesjegy pontossággal add meg!
</label>
<div class="small_task_container">
    <table class="stair_table">
        <tr>
            <?php for($column_counter=0; $column_counter < count($newton_points) + 1; $column_counter++):?>
                <?php if($column_counter === 0):?>
                    <th>x<sub>i</sub></th>
                <?php elseif($column_counter === 1):?>
                    <th>y<sub>i</sub></th>
                <?php else:?>
                    <th><?=$column_counter - 1?>. lépés</th>
                <?php endif?>
            <?php endfor?>
        </tr>
        <?php $input_counter = 0?>
        <?php for($row_counter=0; $row_counter < 2*count($newton_points); $row_counter++):?>
            <tr>
                <?php for($column_counter=0; $column_counter < count($newton_points) + 1; $column_counter++):?>
                    <?php $width = $column_counter === 0 || $column_counter === 1?10:80/count($newton_points)?>
                    <?php if($column_counter === 0 || $column_counter === 1):?>
                        <?php if($row_counter % 2 === 0):?>
                            <td 
                                style="border-left: 1px solid black; border-top: 1px solid black; width: <?=$width?>%; border-right: 1px solid black">
                            <?=$newton_points[$row_counter/2][$column_counter]??""?>
                            </td>
                        <?php else:?>
                            <td 
                                style="border-left: 1px solid black; width: <?=$width?>%;border-right: 1px solid black;
                                <?php if($row_counter === 2*count($newton_points) - 1){echo("border-bottom: 1px solid black; padding-top:3%");}?>
                                ">
                            </td>
                        <?php endif?>
                    <?php else:?>
                        <?php if($row_counter - $column_counter > -2 && $row_counter < 2*count($newton_points) - ($column_counter-1)):?>
                            <?php if(abs($column_counter - $row_counter) % 2 === 1):?>
                                <td 
                                    style="border-top: 1px solid black; width: <?=$width?>%; border-right: 1px solid black">
                                    <?php 
                                        $id = $task_counter . "_" . ($column_counter - 2) . "_" . floor(($row_counter - $column_counter + 1)/2);
                                        $current_answer = $_SESSION["answers"]["answer_" . $id]??"";
                                    ?>
                                    <input type="text" name="<?="solution_" . $id?>" value="<?=$current_answer["answer"]??"..."?>" class="<?=IsCorrect($current_answer)?>" <?=$current_answer !== ""?"readonly":""?>>
                                    
                                    <?php if(isset($current_answer["answer"])):?>
                                        <label style="color: grey"><?= $current_answer["solution_text"]?></label>
                                    <?php endif?>
                                    
                                    <?php $input_counter++?>
                                </td>
                            <?php else:?>
                                <td 
                                    class = "no_content_cell"
                                    style="
                                        width: <?=$width?>%;
                                        <?php if($row_counter === 2*count($newton_points) - ($column_counter-1) - 1){echo("border-bottom: 1px solid black");}?>
                                    ">
                                </td>
                            <?php endif?>
                        <?php else:?>
                            <td style = "border: 0px"></td>
                        <?php endif?>
                    <?php endif?>
                <?php endfor?>
            </tr>
        <?php endfor?>
    </table>
    <?php 
        $task_counter = "1_" . count($newton_points) - 1;
        $solution_label = "<i>N</i>[x] = ";
        include("./views/taskContents/solutionInput.php")
    ?>
</div>