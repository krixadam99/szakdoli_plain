<div class="multiple_solution_input_container">
    <?php $current_answer_0 = $_SESSION["answers"]["answer_" . $solution_id_remainder]??"";?>
    <?="x \u{2261}"?> <input type="text" name=<?="solution_" . $solution_id_remainder??""?> value="<?=$current_answer_0["answer"]??"b..."?>" class="<?=IsCorrect($current_answer_0)?>" <?=$current_answer_0 !== ""?"readonly":""?>>
    (mod
    <?php $current_answer_1 = $_SESSION["answers"]["answer_" . $solution_id_modulo]??"";?>
    <input type="text" name=<?="solution_" . $solution_id_modulo??""?> value="<?=$current_answer_1["answer"]??"mod..."?>" class="<?=IsCorrect($current_answer_1)?>" <?=$current_answer_1 !== ""?"readonly":""?>>
    )
</div>
<?php if($current_answer_0 !== "" && $current_answer_1 !== ""):?>
    <label class="solution_label"><?= PrintServices::CreatePrintableModuloEquivalence("x",$current_answer_0["solution_text"],$current_answer_1["solution_text"])?></label>
<?php endif?>