<?php foreach($_SESSION["task"]["first_subtasks"] as $graph_counter => $graph):?>
    <div class="task_data">
        <label class="task_label">1.<?= $graph_counter + 1 ?>. részfeladat: Adott egy gráf a következő fokszámsorozattal: <?= PrintServices::CreatePrintableGraph($graph, "simple")?>.</label>
    </div>
    <div class="small_task_container">
        
        <?php 
            $task_counter = "0_$graph_counter";
            $select_counter = 0;
            $select_label = "Megszerkeszthető-e ez az egyszerű gráf?";
        ?>
        <?php include("./views/taskContents/solutionSelect.php")?>
    </div>
<?php endforeach?>

<?php foreach($_SESSION["task"]["second_subtasks"] as $graph_counter => $graph):?>
    <div class="task_data">
        <label class="task_label">2.<?= $graph_counter + 1 ?>. részfeladat: Adott egy gráf a következő fokszámsorozattal: <?= PrintServices::CreatePrintableGraph($graph, "tree")?>.</label>
    </div>
    <div class="small_task_container">
        
        <?php 
            $task_counter = "1_$graph_counter";
            $select_counter = 0;
            $select_label = "Megszerkeszthető-e ez a fagráf?";
        ?>
        <?php include("./views/taskContents/solutionSelect.php")?>
    </div>
<?php endforeach?>

<?php foreach($_SESSION["task"]["third_subtasks"] as $graph_counter => $graph):?>
    <div class="task_data">
        <label class="task_label">3.<?= $graph_counter + 1 ?>. részfeladat: Adott egy gráf a következő fokszámsorozattal: <?= PrintServices::CreatePrintableGraph($graph, "paired")?>.</label>
    </div>
    <div class="small_task_container">
        
        <?php 
            $task_counter = "2_$graph_counter";
            $select_counter = 0;
            $select_label = "Megszerkeszthető-e ez a páros gráf?";
        ?>
        <?php include("./views/taskContents/solutionSelect.php")?>
    </div>
<?php endforeach?>

<?php foreach($_SESSION["task"]["fourth_subtasks"] as $graph_counter => $graph):?>
    <div class="task_data">
        <label class="task_label">4.<?= $graph_counter + 1 ?>. részfeladat: Adott egy gráf a következő fokszámsorozattal: <?= PrintServices::CreatePrintableGraph($graph, "directed")?>.</label>
    </div>
    <div class="small_task_container">
        
        <?php 
            $task_counter = "3_$graph_counter";
            $select_counter = 0;
            $select_label = "Megszerkeszthető-e ez az irányított gráf?";
        ?>
        <?php include("./views/taskContents/solutionSelect.php")?>
    </div>
<?php endforeach?>