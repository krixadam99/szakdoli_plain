<div class="small_task_container">
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
<?php foreach($_SESSION["task"]["relations"] as $relation_name => $relation):?>
    <label class="task_label">
        <?=" $relation_name = { "?>
        <?php foreach($relation as $index => $pair):?>
            <?=$index==0?"(":", ("?><?=$pair[0] . ", " . $pair[1] . ")"?>
        <?php endforeach?>
        <?=" }"?>
    </label>
    <br>
<?php endforeach?>
<label class="task_label">
    1. részfeladat: Add meg az R<?="\u{00B7}"?>S kompozíciót!
</label>
<br>
<?php $task_counter = 0;?>
<?php include("./partials/solutionInput.php")?>
</div>
<br>

<?php foreach($_SESSION["task"]["characteristics_relation"] as $name => $elements):?>
    <label class="task_label">
        <?=" $name = { "?>
            <?php if(!is_array($elements[0])):?>
                <?php foreach($elements as $index => $element):?>
                    <?=$index==0?"":", "?><?=$element?>
                <?php endforeach?>
            <?php else:?>
                <?php foreach($elements as $index => $pair):?>
                    <?=$index==0?"(":", ("?><?=$pair[0] . ", " . $pair[1] . ")"?>
                <?php endforeach?>
            <?php endif?>
        <?=" }"?>
    </label>
    <br>
<?php endforeach?>
<div class="small_task_container">
    <label class="task_label">
        2. részfeladat: Add meg a Q reláció tulajdonságait!
    </label>
    <br>
    <?php $task_counter = 1;?>
    <?php $answer_counter = 1;?>
    <?php $relation_characteristics = ["Reflexív", "Irreflexív", "Szimmetrikus", "Antiszimmetrikus", "Asszimmetrikus", "Tranzitív", "Dichitóm", "Trichotóm", "Ekvivalencia reláció"]?>
    <?php $select_counter = 0;?>
    <?php foreach($relation_characteristics as $index => $select_label):?>
        <?php include("./partials/solutionSelect.php")?>
        <?php $select_counter++;?>
    <?php endforeach?>
</div>

<?php foreach($_SESSION["task"]["characteristics"] as $name => $elements):?>
    <label class="task_label">
            <?php if($name != "characteristics"):?>
                <?=" E = { "?>
                    <?php foreach($elements as $index => $element):?>
                        <?=$index==0?"":", "?><?=$element?>
                    <?php endforeach?>
                <?=" }"?>
            <?php else:?>
                <div class="small_task_container">
                    <label class="task_label">
                        3. részfeladat: Adj egy legalább 3 elemű relációt az E halmazon, amely teljesíti a következő feltételeket:
                    </label>
                    <br>
                    <?php $task_counter = 2;?>
                    <ul>
                    <?php foreach($elements as $characteristic => $is_true):?>
                        <?php if(is_bool($is_true)):?>
                            <li>
                                <?=!$is_true?"Nem " . strtolower($characteristic):$characteristic?>
                            </li>
                        <?php endif?>
                    <?php endforeach?>
                </ul>
                <?php include("./partials/solutionInput.php")?>
                </div>
            <?php endif?>
    </label>
    <br>
<?php endforeach?>