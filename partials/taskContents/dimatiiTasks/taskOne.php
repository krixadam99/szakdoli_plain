<label class="task_label">
    1. részfeladat: Határozd meg a következő osztások esetén a maradékot!  
</label>
<div class="small_task_container">
    <?php $task_counter = 0;?>
    <?php foreach($_SESSION["task"]["divide_pairs"] as $index => $pair):?>
        <?=$pair[0]?> / <?=$pair[1]?> osztás maradéka:
        <br>
        <?php include("./partials/taskContents/solutionInput.php")?>
    <?php endforeach?>
</div>
<br>

<label class="task_label">
    2. részfeladat: Határozd meg a következő számok esetén a prímfelbontásokat! A hatványalapot és kitevőt <b>(alap, kitevő)</b> alakban add meg, a rendezett párokat vesszővel válaszd el (pl.: 2<span class="exp">2</span>*3<span class="exp">2</span> helyett írj (2,2),(3,2)-t)!
</label>
<div class="small_task_container">
    <?php $task_counter = 1;?>
    <?php foreach($_SESSION["task"]["prime_factorization_numbers"] as $index => $number):?>
        <?=$number?> prímfelbontása:
        <br>
        <?php include("./partials/taskContents/solutionInput.php")?>
    <?php endforeach?>
</div>
<br>

<label class="task_label">
    3. részfeladat: Határozd meg a következő számok esetén a pozitív osztók számát!
</label>
<div class="small_task_container">
    <?php $task_counter = 2;?>
    <?php foreach($_SESSION["task"]["divisor_count_numbers"] as $index => $number):?>
        <?=$number?> osztóinak száma:
        <br>
        <?php include("./partials/taskContents/solutionInput.php")?>
    <?php endforeach?>
</div>
<br>

<label class="task_label">
    4. részfeladat: Adj meg egy-egy (a bal oldalon lévő számtól eltérő) számot a következő kongruenciákban, hogy igaz állítást kapj!
</label>
<div class="small_task_container">
    <?php $task_counter = 3;?>
    <?php foreach($_SESSION["task"]["congruency_pairs"] as $index => $pair):?>
        <?=$pair[0] . " \u{2261}"?> x (mod <?= $pair[1]?>), ahol x: <?php include("./partials/taskContents/solutionInput.php")?>
    <?php endforeach?>
</div>
<br>

<label class="task_label">
    5. részfeladat: Melyik az a legkisebb pozitív egész szám, aminek az osztóinak száma (szám1) és nem osztható (szám2)-vel?
</label>
<!-- 1 számpár ide -->