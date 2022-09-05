<?php if($approved_student_subject=="i" ):?>
    <?php if(intval($_SESSION["topic"]) == 0):?>
        <?php include("./partials/taskContents/dimatiTasks/taskOne.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 1):?>
        <?php include("./partials/taskContents/dimatiTasks/taskTwo.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 2):?> 
        <?php include("./partials/taskContents/dimatiTasks/taskThree.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 3):?>
        <?php include("./partials/taskContents/dimatiTasks/taskFour.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 4):?>
        <?php include("./partials/taskContents/dimatiTasks/taskFive.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 5):?>
        <?php include("./partials/taskContents/dimatiTasks/taskSix.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 6):?>
        <?php include("./partials/taskContents/dimatiTasks/taskSeven.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 7):?>
        <?php include("./partials/taskContents/dimatiTasks/taskEight.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 8):?>
        <?php include("./partials/taskContents/dimatiTasks/taskNine.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 9):?>
        <?php include("./partials/taskContents/dimatiTasks/taskTen.php");?>
    <?php endif?>
<?php elseif($approved_student_subject=="ii" ):?>
    <?php if(intval($_SESSION["topic"]) == 0):?>
        <?php include("./partials/taskContents/dimatiiTasks/taskOne.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 1):?>
        <?php include("./partials/taskContents/dimatiiTasks/taskTwo.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 2):?> 
        <?php include("./partials/taskContents/dimatiiTasks/taskThree.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 3):?>
        <?php include("./partials/taskContents/dimatiiTasks/taskFour.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 4):?>
        <?php include("./partials/taskContents/dimatiiTasks/taskFive.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 5):?>
        <?php include("./partials/taskContents/dimatiiTasks/taskSix.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 6):?>
        <?php include("./partials/taskContents/dimatiiTasks/taskSeven.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 7):?>
        <?php include("./partials/taskContents/dimatiiTasks/taskEight.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 8):?>
        <?php include("./partials/taskContents/dimatiiTasks/taskNine.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 9):?>
        <?php include("./partials/taskContents/dimatiiTasks/taskTen.php");?>
    <?php endif?>
<?php endif?>