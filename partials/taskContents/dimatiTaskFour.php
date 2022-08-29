
<?php foreach($_SESSION["task"]["sets"] as $set_name => $elements):?>
    <label class="task_label">
        <?=$set_name . " = { "?>
        <?php foreach($elements as $index => $element):?>
            <?=$index == 0?$element :", " . $element?>
        <?php endforeach?>
        <?=" }"?>
    </label>
    <br>
<?php endforeach?>
<br>
<label class="task_label">
    1. részfeladat: Add meg, hogy a következő relációk közül melyek függvények!
</label>
<div class="small_task_container">
    <?php $task_counter = 0;?>
    <?php $answer_counter = 0;?>
    <?php $select_counter = 0;?>
    <?php foreach($_SESSION["task"]["relations"] as $relation_name => $relation):?>
        <label class="task_label">
            <?=" $relation_name = { "?>
            <?php foreach($relation as $index => $pair):?>
                <?=$index==0?"(":", ("?><?=$pair[0] . ", " . $pair[1] . ")"?>
            <?php endforeach?>
            <?=" }"?>
        </label>
        <?php $select_label = "Függvény-e"?>
        <?php include("./partials/solutionSelect.php")?>
        <?php $select_counter++;?>
    <?php endforeach?>
</div>

<div class="small_task_container">
    <label class="task_label">
        2. részfeladat: Határozd meg a következő függvényeknél, hogy mely tulajdonság igazak rájuk!
    </label>
    <br>
    <?php $task_counter = 1;?>
    <?php $function_characteristics = ["Szürjektív", "Injektív", "Bijektív"]?>
    <?php foreach($_SESSION["task"]["functions"] as $function_name => $function):?>
        <?php $select_counter = 0;?>
        <label class="task_label">
            <?=" $function_name = { "?>
            <?php foreach($function as $index => $pair):?>
                <?=$index==0?"(":", ("?><?=$pair[0] . ", " . $pair[1] . ")"?>
            <?php endforeach?>
            <?=" }"?>
        </label>
        <?php foreach($function_characteristics as $index => $select_label):?>
            <?php include("./partials/solutionSelect.php")?>
            <?php $select_counter++;?>
        <?php endforeach?>
        <?php $task_counter++;?>
    <?php endforeach?>
</div>