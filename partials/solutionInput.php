<?php if(isset($_SESSION["answers"])):?>
    <?php if(isset($_SESSION["answers"]["answer_" . $task_counter])):?>
            <?php $current_answer= $_SESSION["answers"]["answer_" . $task_counter]?>
            <div class="solution_container">
                <label>Megoldásom:</label>
                <input type="text" name=<?="solution_" . $task_counter?> value="<?= $current_answer["answer"]?>" class=<?= $current_answer["correct"]?"correct":"wrong"?> readonly>
            </div>
            <label>A helyes válasz: 
                <?php if(!is_array($_SESSION["solution"]["solution_" . $task_counter][0])):?>
                    <?="{ "?>
                        <?php foreach($_SESSION["solution"]["solution_" . $task_counter] as $element_index => $element):?>
                            <?=$element_index == 0?$element :", " . $element?>
                        <?php endforeach?>
                    <?=" }"?>
                    <br>
                    </label>
                <?php elseif(is_array($_SESSION["solution"]["solution_" . $task_counter][0])):?>
                    <label class="task_label">
                        <?="{ "?>
                            <?php foreach($_SESSION["solution"]["solution_" . $task_counter] as $element_index => $pair):?>
                                <?=$element_index==0?"(":", ("?><?=$pair[0] . ", " . $pair[1] . ")"?>
                            <?php endforeach?>
                        <?=" }"?>
                    </label>
                    <br>
                <?php endif?>    
            </label>
            <br>
    <?php else:?>
        <div class="solution_container">
            <label>Megoldásom:</label>
            <input type="text" name=<?="solution_" . $task_counter?> value="Megoldásom..." class="solution_input">
        </div>
    <?php endif?>
<?php else:?>
    <div class="solution_container">
        <label>Megoldásom:</label>
        <input type="text" name=<?="solution_" . $task_counter?> value="Megoldásom..." class="solution_input">
    </div>
<?php endif?>