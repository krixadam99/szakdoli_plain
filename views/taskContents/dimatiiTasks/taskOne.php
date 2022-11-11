<label class="task_label">
    1. részfeladat: Határozd meg a következő osztások esetén a maradékot!  
</label>
<div class="small_task_container">
    <?php foreach($_SESSION["task"]["divide_pairs"] as $division_index => $pair):?>
        <div class="multiple_solution_input_container">
            <?php 
                $task_counter = "0_$division_index" . "_0";
                $current_answer_0_0_0= $_SESSION["answers"]["answer_" . $task_counter]??"";
            ?>
            <?=$pair[0]?> = <?=$pair[1]?> * <input type="text" name="<?="solution_" . $task_counter?>" value="<?=$current_answer_0_0_0["answer"]??"hányados..."?>" class="<?=IsCorrect($current_answer_0_0_0)?>" <?=$current_answer_0_0_0 !== ""?"readonly":""?>>
            
            +

            <?php 
                $task_counter = "0_$division_index". "_1" ;
                $current_answer_0_0_1= $_SESSION["answers"]["answer_" . $task_counter]??"maradék...";
            ?>
            <input type="text" name="<?="solution_" . $task_counter?>" value="<?=$current_answer_0_0_1["answer"]??"maradék..."?>" class="<?=IsCorrect($current_answer_0_0_1)?>">
        </div>
        <?php if(isset($_SESSION["answers"]["answer_" . $task_counter])):?>
            <label class="solution_label">A helyes megoldás: <?=$pair[0]?> = <?=$pair[1]?> * <?=$current_answer_0_0_0["solution_text"]?> + <?=$current_answer_0_0_1["solution_text"]?></label>
        <?php endif?>
    <?php endforeach?>
</div>
<br>

<label class="task_label">
    2. részfeladat: Határozd meg a következő számok esetén a prímfelbontásokat! A hatványalapot és kitevőt <b>(alap, kitevő)</b> alakban add meg, a rendezett párokat vesszővel válaszd el (pl.: 2<sup>2</sup>*3<sup>2</sup> helyett írj (2,2),(3,2)-t)!
</label>
<?php foreach($_SESSION["task"]["prime_factorization_numbers"] as $prime_factorization_index => $number):?>
    <div class="small_task_container">
        <?php 
            $task_counter = 1 . "_" . $prime_factorization_index;
            $solution_label = $number . ' prímfelbontása:';
            include("./views/taskContents/solutionInput.php");
        ?>
    </div>
<?php endforeach?>
<br>

<label class="task_label">
    3. részfeladat: Határozd meg a következő számok esetén a pozitív osztók számát!
</label>
<?php foreach($_SESSION["task"]["positive_divisor_count_numbers"] as $divisor_count_index => $number):?>
    <div class="small_task_container">
        <?php
            $task_counter = 2 . "_" . $divisor_count_index; 
            $solution_label = $number . ' osztóinak száma:';
            include("./views/taskContents/solutionInput.php");
        ?>
    </div>
<?php endforeach?>
<br>

<label class="task_label">
    4. részfeladat: Adj meg egy-egy (a bal oldalon lévő számtól eltérő) számot a következő kongruenciákban, hogy igaz állítást kapj!
</label>
<?php $task_counter = 3;?>
<?php foreach($_SESSION["task"]["congruency_pairs"] as $congruence_index => $pair):?>
    <div class="small_task_container">
        <?php 
            $task_counter = "3_$congruence_index";
            $current_answer= $_SESSION["answers"]["answer_" . $task_counter]??"";
        ?>
        <div class="single_solution_input_container">
            <?=$pair[0] . " \u{2261}"?> <input type="text" name="<?="solution_" . $task_counter?>" value=<?=$current_answer["answer"]??"b..."?> class="<?=IsCorrect($current_answer)?>" <?=$current_answer !== ""?"readonly":""?>> (mod <?= $pair[1]?>)
        </div>
    </div>
<?php endforeach?>
<br>