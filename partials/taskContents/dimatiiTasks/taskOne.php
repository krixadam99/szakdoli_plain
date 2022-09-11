<label class="task_label">
    1. részfeladat: Határozd meg a következő osztások esetén a maradékot!  
</label>
<div class="small_task_container">
    <?php foreach($_SESSION["task"]["divide_pairs"] as $division_index => $pair):?>
        <div class="multiple_solution_input_container">
            <?=$pair[0]?> = <?=$pair[1]?> * <input type="text" name=<?="solution_0_" . $division_index . "_0"?> value="hányados..." class="solution_input">
            +
            <input type="text" name=<?="solution_0_" . $division_index . "_1"?> value="maradék..." class="solution_input">
        </div>
    <?php endforeach?>
</div>
<br>

<label class="task_label">
    2. részfeladat: Határozd meg a következő számok esetén a prímfelbontásokat! A hatványalapot és kitevőt <b>(alap, kitevő)</b> alakban add meg, a rendezett párokat vesszővel válaszd el (pl.: 2<span class="exp">2</span>*3<span class="exp">2</span> helyett írj (2,2),(3,2)-t)!
</label>
<div class="small_task_container">
    <?php foreach($_SESSION["task"]["prime_factorization_numbers"] as $prime_factorization_index => $number):?>
        <?php 
            $task_counter = 1 . "_" . $prime_factorization_index;
            $solution_label = $number . ' prímfelbontása:';
            include("./partials/taskContents/solutionInput.php");
        ?>
    <?php endforeach?>
</div>
<br>

<label class="task_label">
    3. részfeladat: Határozd meg a következő számok esetén a pozitív osztók számát!
</label>
<div class="small_task_container">
    <?php foreach($_SESSION["task"]["positive_divisor_count_numbers"] as $divisor_count_index => $number):?>
        <?php
            $task_counter = 2 . "_" . $divisor_count_index; 
            $solution_label = $number . ' osztóinak száma:';
            include("./partials/taskContents/solutionInput.php");
        ?>
    <?php endforeach?>
</div>
<br>

<label class="task_label">
    4. részfeladat: Adj meg egy-egy (a bal oldalon lévő számtól eltérő) számot a következő kongruenciákban, hogy igaz állítást kapj!
</label>
<div class="small_task_container">
    <?php $task_counter = 3;?>
    <?php foreach($_SESSION["task"]["congruency_pairs"] as $index => $pair):?>
        <?php foreach($_SESSION["task"]["divide_pairs"] as $division_index => $pair):?>
            <div class="single_solution_input_container">
                <?=$pair[0] . " \u{2261}"?> <input type="text" name=<?="solution_3_" . $division_index . "_0"?> value="b..." class="solution_input"> (mod <?= $pair[1]?>)
            </div>
        <?php endforeach?>
    <?php endforeach?>
</div>
<br>

<label class="task_label">
    5. részfeladat: Hány olyan osztója van (szám1)-nek, ami nem osztható (egyik osztója)-val?
</label>
<!-- 1 számpár ide -->