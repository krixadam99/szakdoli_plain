<?php if($approved_student_subject=="i" ):?>
    <?php if(intval($_SESSION["topic"]) == 0):?>
        <?php include("./views/taskContents/dimatiDefinitions/taskOne.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 1):?>
        <?php include("./views/taskContents/dimatiDefinitions/taskTwo.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 2):?> 
        <?php include("./views/taskContents/dimatiDefinitions/taskThree.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 3):?>
        <?php include("./views/taskContents/dimatiDefinitions/taskFour.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 4):?>
        <?php include("./views/taskContents/dimatiDefinitions/taskFive.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 5):?>
        <?php include("./views/taskContents/dimatiDefinitions/taskSix.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 6):?>
        <?php include("./views/taskContents/dimatiDefinitions/taskSeven.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 7):?>
        <?php include("./views/taskContents/dimatiDefinitions/taskEight.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 8):?>
        <?php include("./views/taskContents/dimatiDefinitions/taskNine.php");?>
    <?php endif?>
<?php elseif($approved_student_subject=="ii" ):?>
    <?php if(intval($_SESSION["topic"]) == 0):?>
        <?php include("./views/taskContents/dimatiiDefinitions/taskOne.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 1):?>
        <?php include("./views/taskContents/dimatiiDefinitions/taskTwo.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 2):?> 
        <?php include("./views/taskContents/dimatiiDefinitions/taskThree.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 3):?>
        <?php include("./views/taskContents/dimatiiDefinitions/taskFour.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 4):?>
        <?php include("./views/taskContents/dimatiiDefinitions/taskFive.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 5):?>
        <?php include("./views/taskContents/dimatiiDefinitions/taskSix.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 6):?>
        <?php include("./views/taskContents/dimatiiDefinitions/taskSeven.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 7):?>
        <?php include("./views/taskContents/dimatiiDefinitions/taskEight.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 8):?>
        <?php include("./views/taskContents/dimatiiDefinitions/taskNine.php");?>
    <?php endif?>
<?php endif?>