<?php if(isset($_SESSION["answers"])):?>
    <?php if(isset($_SESSION["answers"]["answer_" . $task_counter])):?>
            <?php $current_answer= $_SESSION["answers"]["answer_" . $task_counter]?>
            <div class="solution_container">
                <label><?=$solution_label??"Megoldásom: "?></label>
                <input type="text" name=<?="solution_" . $task_counter?> value="<?= $current_answer["answer"]?>" class=<?= $current_answer["correct"]?"correct":"wrong"?> readonly>
            </div>
            <div class="solution_label_container">
                <label class="task_label">Válaszod az átalakítást követően: 
                    <?php if($current_answer["answer"] !== "Megoldásom..."):?>
                        <?=$current_answer["answer_text"]??""?>
                    <?php else:?>
                        "Megoldásom..."
                    <?php endif?>
                </label>
                <label class="task_label">
                    <?php 
                        if(isset($answer_label)){
                            echo($answer_label);
                        }else{
                            echo("A helyes válasz: ");
                        }
                    ?>    
                    <?=$current_answer["solution_text"]??""?>
                </label>
            </div>
    <?php else:?>
        <div class="solution_container">
            <label>
                <?php 
                    if(isset($solution_label)){
                        echo($solution_label);
                    }else{
                        echo("Megoldásom: ");
                    }
                ?>
            </label>
                <input type="text" name=<?="solution_" . $task_counter?> value="Megoldásom..." class="solution_input">
        </div>
    <?php endif?>
<?php else:?>
    <div class="solution_container">
        <label><?=$solution_label??"Megoldásom: "?></label>
        <input type="text" name=<?="solution_" . $task_counter?> value="Megoldásom..." class="solution_input">
    </div>
<?php endif?>