<?php foreach($_SESSION["task"]["set_triplets"] as $set_triplet_counter => $set_triplet):?>
    <div class="task_data">
        <label class="task_label">Adottak a következő halmazok:</label>
        <?php foreach($set_triplet as $set_name => $set_elements):?>
            <label class="task_label">
                <?= PrintServices::CreatePrintableSet($set_name, $set_elements)?>
            </label>
        <?php endforeach?>

        <label class="task_label">Valamint a következő relációk:</label>
        <label class="task_label">
            <?="R \u{2286} B \u{00D7} C, "?>
            <?= PrintServices::CreatePrintableRelation("R", $_SESSION["task"]["relation_pairs"][$set_triplet_counter][0])?>
        </label>
        <label class="task_label">
            <?="S \u{2286} A \u{00D7} B, "?>
            <?= PrintServices::CreatePrintableRelation("S", $_SESSION["task"]["relation_pairs"][$set_triplet_counter][1])?>
        </label>
    </div>
    <div class="small_task_container">
        <label class="task_label">
            1.<?= $set_triplet_counter + 1 ?>. részfeladat: Add meg az R<?="\u{00B7}"?>S kompozíciót!
        </label>
        <?php $task_counter = "0_$set_triplet_counter";?>
        <?php $solution_label = "R \u{00B7} S = "?>
        <?php include("./partials/taskContents/solutionInput.php")?>
    </div>
<?php endforeach?>

<?php foreach($_SESSION["task"]["characteristics_relation"]["base_sets"] as $base_set_counter => $base_set):?>
    <div class="task_data">
        <label class="task_label">Adott a következő halmaz:</label>
        <label class="task_label">
            <?= PrintServices::CreatePrintableSet("A", $base_set, true)?>
        </label>

        <label class="task_label">Valamint a következő reláció:</label>
        <label class="task_label">
            <?="Q \u{2286} A \u{00D7} A, "?>
            <?= PrintServices::CreatePrintableRelation("Q", $_SESSION["task"]["characteristics_relation"]["relations"][$base_set_counter])?>
        </label>
    </div>
    <div class="small_task_container">
        <label class="task_label">
            2.<?= $base_set_counter + 1 ?>. részfeladat: Add meg a Q reláció tulajdonságait!
        </label>
        <?php $task_counter = "1_$base_set_counter";?>
        <?php $relation_characteristics = ["Reflexív", "Irreflexív", "Szimmetrikus", "Antiszimmetrikus", "Asszimmetrikus", "Tranzitív", "Dichitóm", "Trichotóm", "Ekvivalencia reláció"]?>
        <?php $select_counter = 0;?>
        <?php foreach($relation_characteristics as $index => $select_label):?>
            <?php include("./partials/taskContents/solutionSelect.php")?>
            <?php $select_counter++;?>
        <?php endforeach?>
    </div>
<?php endforeach?>

<?php foreach($_SESSION["task"]["characteristics"]["sets"] as $base_set_counter => $base_set):?>
    <div class="task_data">
        <label class="task_label">Adott a következő halmaz:</label>
        <label class="task_label">
            <?= PrintServices::CreatePrintableSet("A", $base_set, true)?>
        </label>
        <label class="task_label">Valamint a következő tulajdonságok:</label>
        <ul>
            <?php foreach($_SESSION["task"]["characteristics"]["characteristics"][$base_set_counter] as $characteristic => $is_true):?>
                <?php if(is_bool($is_true)):?>
                    <?php 
                        $is_set_characteristics = false;
                        if(isset($_SESSION["answers"])){
                            if(isset($_SESSION["answers"]["answer_" . "2_$base_set_counter"])){
                                $is_set_characteristics = true;
                                $was_correct = $_SESSION["answers"]["answer_" . "2_$base_set_counter"]["correct_array"][$characteristic];
                            }
                        }
                    ?>
                    <?php if($is_set_characteristics):?>
                        <?php if($was_correct):?>
                            <li style="color:green;">
                        <?php else:?>
                            <li style="color:red;">
                        <?php endif?>
                    <?php else:?>
                        <li>
                    <?php endif?>
                    <?=!$is_true?"Nem " . strtolower($characteristic):$characteristic?>
                    </li>
                <?php endif?>
            <?php endforeach?>
        </ul>
    </div>
    <div class="small_task_container">
        <label class="task_label">
            3.<?= $base_set_counter + 1 ?>. Adj egy olyan relációt az A halmazon, amely teljesíti a fenti feltételeket!
        </label>
        <?php 
            $task_counter = "2_$base_set_counter";
            $answer_label = "Néhány lehetséges megoldás:";
        ?>
        <?php $solution_label = "R = "?>
        <?php include("./partials/taskContents/solutionInput.php")?>
        <?php 
            unset($answer_label);
        ?>
    </div>
<?php endforeach?>