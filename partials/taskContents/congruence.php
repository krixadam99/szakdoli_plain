<?php $current_answer = $_SESSION["answers"]["answer_" . $solution_id_remainder]??"";?>
<?="x \u{2261}"?> <input type="text" name=<?="solution_" . $solution_id_remainder??""?> value="<?=$current_answer["answer"]??"b..."?>" class="<?=IsCorrect($current_answer)?>" <?=$current_answer !== ""?"readonly":""?>>
(mod
<?php $current_answer = $_SESSION["answers"]["answer_" . $solution_id_modulo]??"";?>
<input type="text" name=<?="solution_" . $solution_id_modulo??""?> value="<?=$current_answer["answer"]??"mod..."?>" class="<?=IsCorrect($current_answer)?>" <?=$current_answer !== ""?"readonly":""?>>
)