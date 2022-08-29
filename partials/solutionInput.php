<?php if(isset($_SESSION["answers"])):?>
    <?php if(isset($_SESSION["answers"]["answer_" . $task_counter])):?>
            <?php $current_answer= $_SESSION["answers"]["answer_" . $task_counter]?>
            <div class="solution_container">
                <label>Megoldásom:</label>
                <input type="text" name=<?="solution_" . $task_counter?> value="<?= $current_answer["answer"]?>" class=<?= $current_answer["correct"]?"correct":"wrong"?> readonly>
            </div>
            <label>A helyes válasz: 
                <?php $solution = $_SESSION["solution"]["solution_" . $task_counter]??""?>
                <?php if(!is_array($solution)):?>
                    <?=$solution?>
                <?php else:?>
                    <?php if(!is_array($solution[0])):?>
                        <?php if(!isset($array_complex)):?>
                            <?="{ "?>
                                <?php foreach($solution as $element_index => $element):?>
                                    <?=$element_index == 0?$element :", " . $element?>
                                <?php endforeach?>
                            <?=" }"?>
                        <?php else:?>
                            <?=$solution[0]?><?=$solution[1]>=0?" + ":" "?><?=$solution[1] . "i"?>
                        <?php endif?>
                        <br>
                        </label>
                    <?php elseif(is_array($solution[0])):?>
                        <label class="task_label">
                            <?="{ "?>
                                <?php foreach($solution as $element_index => $pair):?>
                                    <?=$element_index==0?"(":", ("?><?=$pair[0] . ", " . $pair[1] . ")"?>
                                <?php endforeach?>
                            <?=" }"?>
                        </label>
                        <br>
                    <?php endif?>   
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