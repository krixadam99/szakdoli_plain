<?php if($approved_student_subject=="i" ):?>
    <?php if(intval($_SESSION["topic"]) == 0):?>
        <?php include("./partials/taskContents/dimatiTaskOne.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 1):?>
        <?php include("./partials/taskContents/dimatiTaskTwo.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 2):?> 
        <?php include("./partials/taskContents/dimatiTaskThree.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 3):?>
        <?php include("./partials/taskContents/dimatiTaskFour.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 4):?>
        <?php include("./partials/taskContents/dimatiTaskFive.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 5):?>
        <?php include("./partials/taskContents/dimatiTaskSix.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 6):?>
        <?php include("./partials/taskContents/dimatiTaskSeven.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 7):?>
        <?php include("./partials/taskContents/dimatiTaskEight.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 8):?>
        <?php include("./partials/taskContents/dimatiTaskNine.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 9):?>
        <?php include("./partials/taskContents/dimatiTaskTen.php");?>
    <?php endif?>
<?php elseif($approved_student_subject=="ii" ):?>
<?php endif?>