<?php 
    $class_name = "";
    $isset_answer = false;
    if(isset($_SESSION["answers"]["answer_" . $task_counter . "_" . $select_counter])){
        $isset_answer = true;
        $answer = $_SESSION["answers"]["answer_" . $task_counter . "_" . $select_counter]["answer"];
        $real_solution =  $_SESSION["answers"]["answer_" . $task_counter . "_" . $select_counter]["solution_text"];
        if(is_bool($real_solution)){
            if($real_solution){
                $real_solution = "Igen";
            }else{
                $real_solution = "Nem";
            }
        }
        
        $is_correct = $_SESSION["answers"]["answer_" . $task_counter . "_" . $select_counter]["correct"];
        if($is_correct){
            $class_name = "correct";
        }else{
            $class_name = "wrong";
        }
    }
?>
<div class="solution_container">
    <label><?=$select_label?></label>
    <select name=<?="solution_" . $task_counter . "_" . $select_counter?> <?=$class_name!=""?"class=\"$class_name\"":""?>> <?=$isset_answer?"disabled":""?>>
        <option <?=!$isset_answer?"":"selected"?>>-</option>
        <option <?=$isset_answer && $answer == "Igen"?"selected":""?>>Igen</option>
        <option <?=$isset_answer && $answer == "Nem"?"selected":""?>>Nem</option>
    </select>
</div>
<?php if($isset_answer):?>
    <label class="solution_label">
        A helyes válasz: <?=$real_solution?>   
    </label>
<?php endif?>