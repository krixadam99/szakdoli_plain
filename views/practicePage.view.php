<?php
    $approved_student_subject = $this->GetApprovedStudentSubject();
    
    $subject_name = "";
    $column_number = 4;
    $practice_topics = [];
    $topic_descriptions = [];
    if($approved_student_subject == "i"){
        $subject_name = "Diszkrét matematika I. gyakorlás";
        $topic_division = [4, 3, 1, 1];
        $practice_topics = $this->dimat_i_topics;
        $topic_descriptions = $this->dimat_i_topics_descriptions;
    }elseif($approved_student_subject == "ii"){
        $subject_name = "Diszkrét matematika II. gyakorlás";
        $topic_division = [6, 4];
        $practice_topics = $this->dimat_ii_topics;
        $topic_descriptions = $this->dimat_ii_topics_descriptions;
    }

    $practice_results = $this->GetPracticeResults();
    function ProgressCalculator($point){
        $counter = 1;
        $level = 1;
        $progress = 0;
        while($point - $counter >= 0){
            $point -= $counter;
            $level += 1;
            $counter += 1;
        }
        $progress = ($point/$counter)*100;
        return [$level, $progress];
    }

    $actual_page = "practice";

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./views/css/header.css" rel="stylesheet" type="text/css">
    <link href="./views/css/body.css" rel="stylesheet" type="text/css">
    <title>Gyakorlás</title>
</head>
<body>
    <?php include("./partials/header.php")?>
    <main>
        <?php if(!isset($_SESSION["topic"]) || (isset($_SESSION["topic"]) && $_SESSION["topic"] == "")):?>
            <h1><?=$subject_name?></h1>
            <hr>
            <?php $topic_counter = 0;?>
            <?php $card_counter = 0;?>
            <?php $topic = 0;?>
            <?php while($card_counter < count($practice_topics)):?>
                <div class="card_row">
                    <?php for($column_index = 0; $column_index < $column_number; ++$column_index):?>
                        <?php if($card_counter < count($practice_topics)):?>
                            <div class="small_card" onclick="SmallCardClicked(this)" id=<?="small_card_" . $card_counter?>>
                                <label class="title"><?=$practice_topics[$card_counter]?></label>
                                <label class="description"><?=$topic_descriptions[$card_counter]?></label>
                                <?php if($approved_student_subject=="i" || $approved_student_subject=="ii"):?>
                                    <div class="level_container">
                                        <label class="level_counter">
                                            <?= ProgressCalculator(floatval(array_values($practice_results)[$card_counter]))[0]?>
                                        </label>
                                        <div class="level_bar">
                                            <div class="progress_line" style=<?="width:" . ProgressCalculator(floatval(array_values($practice_results)[$card_counter]))[1] . "%"?>>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif?>
                            </div>
                            <?php 
                                $topic_counter++;
                                $card_counter++;
                            ?>
                        <?php else:?>
                            <?php
                                $topic_counter = 0;
                                $topic++;
                            ?>
                            <?php if($column_index != 0):?>
                                <?php for($column_index_new = $column_index; $column_index_new < $column_number; ++$column_index_new):?>
                                    <div class="place_holder_card"></div>
                                <?php endfor?>
                                <?php $column_index = $column_number;?>
                            <?php endif?>
                        <?php endif?>
                    <?php endfor?>
                    <?php if(isset( $topic_division[$topic]) && $topic_counter >= $topic_division[$topic]):?>
                        <?php
                            $topic_counter = 0;
                            $topic++;
                        ?>
                    <?php endif?>
                </div>
            <?php endwhile?>
        <?php elseif(isset($practice_topics[intval($_SESSION["topic"])])):?>
            <h1><?=$practice_topics[intval($_SESSION["topic"])]?></h1>
            <hr>
            <?php if($approved_student_subject=="i" || $approved_student_subject=="ii"):?>
                <div class="practice_container">
                    <div class="definitions_container">
                        <label class="title">Definíciók</label>
                        <label class="definitions"><?=isset($_SESSION["definitions"])?$_SESSION["definitions"]:""?></label>
                    </div>
                    <div class= "task_container">
                        <div class="title_and_progress">
                            <label class="title">Feladatok</label>
                            <div class="level_container">
                                <label class="level_counter">
                                    <?= ProgressCalculator(floatval($practice_results["practice_task_" . ($_SESSION["topic"] + 1)]))[0]?>
                                </label>
                                <div class="level_bar">
                                    <div class="progress_line" style=
                                    <?="width:" . ProgressCalculator(floatval($practice_results["practice_task_" . ($_SESSION["topic"] + 1)]))[1] . "%"?>>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="task">
                            <?php if($approved_student_subject=="i" || $approved_student_subject=="ii"):?>
                                <label class="task_label"><?=$_SESSION["task"]["task_description"]?></label>
                            <?php endif?>
                            <?php if(isset($_SESSION["is_new_task"]) && $_SESSION["is_new_task"]):?>
                                <form class="solution_form" method="POST" action="./index.php?site=handInSolution">
                                    <?php include("./views/taskContents/taskContent.php")?>
                                    <button type="submit" class="solution_button">Beküldés</button>
                                </form>
                            <?php else:?>
                                <?php include("./views/taskContents/taskContent.php")?>
                                <button class="request_new_task_button" onclick="NewTaskButtonClicked(this)" id=<?=$_SESSION["topic"]?>>Új feladat kérése</button>
                            <?php endif?>
                        </div>
                    </div>
                </div>
            <?php endif?>
        <?php endif?>
    </main>
</body>
<script type="module" src="./views/js/mainContent.js"></script>
<script>
    function SmallCardClicked(element){
        let id = element.id.split("small_card_")[1]
        window.location = "./index.php?site=practice&topic=" + id
    } 

    function NewTaskButtonClicked(element){
        window.location = "./index.php?site=practice&topic=" + element.id
    }
</script>
</html>