<div class="multiple_solution_input_container">
    <?=$variable_name?> = <?php $current_answer_0 = $_SESSION["answers"]["answer_" . $first_operand]??"";?>
    <input type="text" name=<?="solution_" . $first_operand?> value=<?=$current_answer_0["answer"]??"b..."?> class="<?=IsCorrect($current_answer_0)?>" <?=$current_answer_0 !== ""?"readonly":""?>>
    +
    <?php $current_answer_1 = $_SESSION["answers"]["answer_" . $second_operand]??"";?>
    <input type="text" name=<?="solution_" . $second_operand?> value=<?=$current_answer_1["answer"]??"modulo..."?> class="<?=IsCorrect($current_answer_1)?>" <?=$current_answer_1 !== ""?"readonly":""?>>
    <?php if(isset($with_multiplier) && $with_multiplier):?>
        * k <?="(k \u{2208} \u{2124})"?>
    <?php endif?>
</div>
<?php if($current_answer_0 !== "" && $current_answer_1 !== ""):?>
    <label class="solution_label">
        <?=$variable_name?> = <?=$current_answer_0["solution_text"]?> + <?=$current_answer_1["solution_text"]?>
        <?php if(isset($with_multiplier) && $with_multiplier):?>
            * k <?="(k \u{2208} \u{2124})"?>
        <?php endif?>
    </label>
<?php endif?>