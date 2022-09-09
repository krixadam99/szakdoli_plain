<?php
    
    $is_administrator = $this->GetIsAdministrator();
    $neptun_code = $this->GetNeptunCode();
    $user_data = $this->GetUserData();
    $all_students = $this->GetStudents();
    $pending_teachers = $this->GetPendingTeachers();
    $pending_teacher_groups = $this->GetPendingTeacherGroups();
    $pending_student_groups = $this->GetPendingStudentGroups();
    $approved_teacher_groups = $this->GetApprovedTeacherGroups();
    $approved_teacher_subjects = $this->GetApprovedTeacherSubjects();
    $approved_student_groups = $this->GetApprovedStudentGroups();
    $approved_student_subject = $this->GetApprovedStudentSubject();
    
    $subject_name = "";
    $column_number = 4;
    $practice_topics = [];
    $topic_descriptions = [];
    if($approved_student_subject == "i"){
        $subject_name = "Diszkrét matematika I. gyakorlás";
        $topic_division = [4, 3, 1, 2];
        $practice_topics = [
            "Halmazok és műveletek", 
            "Relációk alapvető definíciói",
            "Relációk kompozíciója és relációk tulajdonságai",
            "Függvény, mint reláció",
            "Komplex számok alapvető tulajdonságai",
            "Komplex számok trigonometrikus alakja",
            "Komplex számok hatványozása és gyökvonás",
            "Binomiális tétel és faktoriális",
            "Gráfok alapvető tulajdonságai",
            "Gráfok megszerkeszthetősége"
        ];
        $topic_descriptions = [
            "Unió, metszet, különbség, komplementer, szimmetrikus differencia", 
            "Értelmezési tartomány, értékkészlet, megszorítás halmazra, inverz, kép és őskép",
            "Kompozíció, reflexivitás, szimmetria, antiszimmetria, asszimetria, tranzitivitás, dichotómia, trichotómia, ekvivalencia és rendezési reláció",
            "Függvények, injekció, szürjekció, bijekció",
            "Komplex számok alapműveletei: összeadás, kivonás, szorzás és osztás; komplex szám alapvető tulajdonságai; másodfokú egyenletek",
            "Komplex szám trigonometrikus alakjának megadása, komplex szám argumentuma, moivre-azonosságok",
            "Hatványozás és gyökvonás trigonometrikus alak segítségével",
            "Polinomok kifejtése, a binomiális tétel alkalmazása",
            "Fokszámok, komponensek száma, gráfok alapvető tulajdonságai",
            "Egyszerű gráf, páros gráf, fa, irányított gráf megszerkeszthetősége"
        ];
    }elseif($approved_student_subject == "ii"){
        $subject_name = "Diszkrét matematika II. gyakorlás";
        $topic_division = [6, 4];
        $practice_topics = [
            "Maradékos osztás és osztók száma", 
            "Redukált és teljes maradékrendszerek",
            "Eukleidészi algoritmus", 
            "Lineáris kongruenciák",
            "Lineáris diofantikus egyenletek",
            "Kínai maradéktétel",
            "Horner-táblázat használata", 
            "Polinomok osztása és szorzása", 
            "Lagrange- és Newton-féle interpolációs polinomok", 
            "Egyenletek gyökkeresése"
        ];
        $topic_descriptions = [
            "Maradékos osztások, prímfelbontás, pozitív osztók száma, kongruenciák", 
            "Maradékosztályok reprezentatív elemekkel, Euler-féle fí függvény, Redukált maradékrendszerek szorzása",
            "Legnagyobb közös osztó, legkisebb közös többszörös és az Eukleidészi algoritmus",
            "Lineáris kongruenciák megoldása, az Euler-Fermat és kis Fermat-tétel",
            "Lineáris diofantikus egyenletek megoldása",
            "Kínai maradéktétel alkalmazása: lineáris kongruenciarendszerek megoldása",
            "Polinomok helyettesítési értékének meghatározása Horner-táblázattal",
            "Polinomok (maradékos) osztása és szorzása",
            "Lagrange- és Newton- féle interpolációs polinom illesztése több pontra",
            "Viéte- formulák, Schönemann-Eisenstein és Gauss tétel, szimmetrikus és antiszimmetrikus egyenletek"
        ];
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
                            <div class="small_card" onclick="SmallCardClicked(this)" id=<?=$card_counter?>>
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
                    <div class= "task_container" style="<?php if(isset($_SESSION["was_correct"]) && $_SESSION["was_correct"] === true){echo "border: 2px solid green";}elseif(isset($_SESSION["was_correct"]) && $_SESSION["was_correct"] === false){echo "border: 2px solid red";}else{echo "border: 1px solid black";}?>">
                        <div class="title_and_progress">
                            <label class="title">Feladat</label>
                            <div class="level_container">
                                <label class="level_counter">
                                    <?= ProgressCalculator(floatval($practice_results["practice_" . ($_SESSION["topic"] + 1)]))[0]?>
                                </label>
                                <div class="level_bar">
                                    <div class="progress_line" style=
                                    <?="width:" . ProgressCalculator(floatval($practice_results["practice_" . ($_SESSION["topic"] + 1)]))[1] . "%"?>>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="task">
                            <?php if(isset($_SESSION["new_task"]) && $_SESSION["new_task"] != ""):?>
                                <form class="solution_form" method="POST" action="./index.php?site=handInSolution">
                                    <?php if($approved_student_subject=="i" || $approved_student_subject=="ii"):?>
                                        <label class="task_label"><?=$_SESSION["task"]["task_description"]?></label>
                                        <br>
                                        <br>
                                    <?php endif?>
                                    <?php include("./partials/taskContents/taskContent.php")?>
                                    <button type="submit" class="solution_button">Beküldés</button>
                                </form>
                            <?php else:?>
                                <?php include("./partials/taskContents/taskContent.php")?>
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
        window.location = "./index.php?site=practice&topic=" + element.id
    } 

    function NewTaskButtonClicked(element){
        window.location = "./index.php?site=practice&topic=" + element.id
    }
</script>
</html>