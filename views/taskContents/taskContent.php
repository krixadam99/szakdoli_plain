<?php
    function IsCorrect($current_answer){
        if(isset($current_answer["correct"])){
            if($current_answer["correct"]){
                return  "correct";
            }else{
                return "wrong";
            }
        }else{
            return "solution_input";
        }
    }
?>

<?php if($approved_student_subject=="i" ):?>
    <?php if(intval($_SESSION["topic"]) == 0):?>
        <?php include("./views/taskContents/dimatiTasks/taskOne.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 1):?>
        <?php include("./views/taskContents/dimatiTasks/taskTwo.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 2):?> 
        <?php include("./views/taskContents/dimatiTasks/taskThree.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 3):?>
        <?php include("./views/taskContents/dimatiTasks/taskFour.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 4):?>
        <?php include("./views/taskContents/dimatiTasks/taskFive.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 5):?>
        <?php include("./views/taskContents/dimatiTasks/taskSix.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 6):?>
        <?php include("./views/taskContents/dimatiTasks/taskSeven.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 7):?>
        <?php include("./views/taskContents/dimatiTasks/taskEight.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 8):?>
        <?php include("./views/taskContents/dimatiTasks/taskNine.php");?>
    <?php endif?>
<?php elseif($approved_student_subject=="ii" ):?>
    <?php if(intval($_SESSION["topic"]) == 0):?>
        <?php include("./views/taskContents/dimatiiTasks/taskOne.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 1):?>
        <?php include("./views/taskContents/dimatiiTasks/taskTwo.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 2):?> 
        <?php include("./views/taskContents/dimatiiTasks/taskThree.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 3):?>
        <?php include("./views/taskContents/dimatiiTasks/taskFour.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 4):?>
        <?php include("./views/taskContents/dimatiiTasks/taskFive.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 5):?>
        <?php include("./views/taskContents/dimatiiTasks/taskSix.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 6):?>
        <?php include("./views/taskContents/dimatiiTasks/taskSeven.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 7):?>
        <?php include("./views/taskContents/dimatiiTasks/taskEight.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 8):?>
        <?php include("./views/taskContents/dimatiiTasks/taskNine.php");?>
    <?php elseif(intval($_SESSION["topic"]) == 9):?>
        <?php include("./views/taskContents/dimatiiTasks/taskTen.php");?>
    <?php endif?>
<?php endif?>