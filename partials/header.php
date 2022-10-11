<header>
    <div id="header_line">
        <?php if(!$is_administrator):?>
            <div id="notifications_button">
                <img src="./views/css/pics/notifications_shape.png" alt="notifications_shape" id="notifications_shape">
                <span class="text_of_tooltip">
                    Visszanavigálás az értesítések oldalára
                </span>
            </div>
        <?php endif?>
        <div id="messages_button">
            <img src="./views/css/pics/messages.png" alt="messages_shape" id="messages_shape">
            <span class="text_of_tooltip">
                Navigálás az üzenetek oldalára
            </span>
        </div>
        <button id="sign_out_button">Kilépés</button>
    </div>
    
    <?php if(!$is_administrator):?>
        <div id="header_line">
            <?php if(count($approved_teacher_groups) != 0):?> <!-- there is at least one group assigned to this user -->
                <?php if(count($approved_teacher_subjects) === 2):?>
                    <nav id="generate_task" class="nav_with_submenu <?=$actual_page=="task_generation"?"actual_page":"not_actual_page"?>">
                        Feladatsor összeállítása
                        <div class="submenu">                    
                            <?php foreach($approved_teacher_subjects as $approved_teacher_subject):?>                            
                                <a class="submenu_row" href=<?="./index.php?site=taskGeneration&subject=" . $approved_teacher_subject?>><?=$approved_teacher_subject=="i"?"Diszkrét matematika I.":"Diszkrét matematika II."?></a>
                            <?php endforeach?>
                        </div>
                    </nav>
                <?php elseif(count($approved_teacher_subjects) === 1):?>
                    <nav id="generate_task" class="nav_without_submenu <?=$actual_page=="task_generation"?"actual_page":"not_actual_page"?>">
                        <a class="menu_cell" href=<?="./index.php?site=taskGeneration&subject=" . $approved_teacher_subjects[0]?>><?=$approved_teacher_subjects[0]=="i"?"Diszkrét matematika I.":"Diszkrét matematika II."?> feladatsor összeállítása</a>
                    </nav>
                <?php endif?>

                <?php if(count($approved_teacher_subjects) === 2):?>
                    <nav id="generate_task" class="nav_with_submenu <?=$actual_page=="student_handling"?"actual_page":"not_actual_page"?>">
                        Diákok kezelése
                        <div class="submenu">                    
                            <?php foreach($approved_teacher_subjects as $approved_teacher_subject):?>                            
                                <?php 
                                    foreach($approved_teacher_groups as $index => $approved_teacher_group){
                                        if($approved_teacher_group["subject_name"] === $approved_teacher_subject){
                                            $first_group = $approved_teacher_group["subject_group"];
                                            break;
                                        }
                                    }
                                ?>

                                <a class="submenu_row" href=<?="./index.php?site=studentHandling&subject=" . $approved_teacher_subject . "&group=" . $first_group?>><?=$approved_teacher_subject=="i"?"Diszkrét matematika I.":"Diszkrét matematika II."?></a>
                            <?php endforeach?>
                        </div>
                    </nav>
                <?php elseif(count($approved_teacher_subjects) === 1):?>
                    <nav id="generate_task" class="nav_without_submenu <?=$actual_page=="student_handling"?"actual_page":"not_actual_page"?>">
                        <?php 
                            foreach($approved_teacher_groups as $index => $approved_teacher_group){
                                if($approved_teacher_group["subject_name"] === $approved_teacher_subjects[0]){
                                    $first_group = $approved_teacher_group["subject_group"];
                                    break;
                                }
                            }
                        ?>

                        <a class="menu_cell" href=<?="./index.php?site=studentHandling&subject=" . $approved_teacher_subjects[0] . "&group=" . $first_group?>><?=$approved_teacher_subjects[0]=="i"?"Diszkrét matematika I.":"Diszkrét matematika II."?> diákok kezelése</a>    
                    </nav>
                <?php endif?>

                <?php if(count($approved_teacher_subjects) === 2):?>
                    <nav id="generate_task" class="nav_with_submenu <?=$actual_page=="student_grades"?"actual_page":"not_actual_page"?>">
                        Eredemények
                        <div class="submenu">                    
                            <?php foreach($approved_teacher_subjects as $approved_teacher_subject):?>                            
                                <?php 
                                    foreach($approved_teacher_groups as $index => $approved_teacher_group){
                                        if($approved_teacher_group["subject_name"] === $approved_teacher_subject){
                                            $first_group = $approved_teacher_group["subject_group"];
                                            break;
                                        }
                                    }
                                ?>

                                <a class="submenu_row" href=<?="./index.php?site=studentGrades&subject=" . $approved_teacher_subject . "&group=" . $first_group?>><?=$approved_teacher_subject=="i"?"Diszkrét matematika I.":"Diszkrét matematika II."?></a>
                            <?php endforeach?>
                        </div>
                    </nav>
                <?php elseif(count($approved_teacher_subjects) === 1):?>
                    <nav id="generate_task" class="nav_without_submenu <?=$actual_page=="student_grades"?"actual_page":"not_actual_page"?>">
                        <?php 
                            foreach($approved_teacher_groups as $index => $approved_teacher_group){
                                if($approved_teacher_group["subject_name"] === $approved_teacher_subjects[0]){
                                    $first_group = $approved_teacher_group["subject_group"];
                                    break;
                                }
                            }
                        ?>

                        <a class="menu_cell" href=<?="./index.php?site=studentGrades&subject=" . $approved_teacher_subjects[0] . "&group=" . $first_group?>><?=$approved_teacher_subjects[0]=="i"?"Diszkrét matematika I.":"Diszkrét matematika II."?> eredmények</a>    
                    </nav>
                <?php endif?>
            <?php endif?>
            
            <?php if(count($approved_student_groups) != 0):?> <!-- this user is assigned to at least one group -->
                <?php if(count($approved_teacher_groups) != 0):?>
                    <nav class="empty_nav"></nav>
                <?php endif?>
                <nav id="practice" class="nav_without_submenu <?=$actual_page=="practice"?"actual_page":"not_actual_page"?>">
                    <a class="menu_cell" href=<?="./index.php?site=practice"?>>Gyakorlás</a>
                </nav>

                <nav id="personal_grades" class="nav_without_submenu <?=$actual_page=="grades"?"actual_page":"not_actual_page"?>">
                    <a class="menu_cell" href=<?="./index.php?site=grades"?>>Saját eredményeim</a>
                </nav>
            <?php endif?>

            <!-- Group addition -->
            <!--
                - i - student is pending -> if group is not 0, then don't show the group addition, else show group addition with only appying to group submenu row
                - ii - student is pending -> Show group addition with only group adding submenu row
                - i - student is approved -> cannot be teacher, cannot be student (don't show group addition)
                - ii - student is approved -> can be i teacher, cannot be student (show group addition with only group adding submenu row)
                - i - student is denied -> 
                - ii - student is denied -> 

                - i - teacher is pending, ii - teacher is pending, i - teacher is approved -> Show group addition menu
                - ii - teacher is approved ->  Show group addition menu with only group adding submenu row
                - i - teacher is deined
                - ii - teacher is denied

            -->
            <?php
                $group_addition_conditions = MainContentController::GroupAdditionChecker($pending_student_groups, $approved_student_subject, $approved_teacher_subjects);
            
                $show_group_addition_menu = $group_addition_conditions[0];
                $can_apply_to_group = $group_addition_conditions[1];
                $can_add_group = $group_addition_conditions[2];
            ?>
            <?php if($show_group_addition_menu):?>
                <?php if(count($approved_teacher_groups) != 0 || count($approved_student_groups) != 0):?>
                    <nav class="empty_nav"></nav>
                <?php endif?>
                <nav id="group_addition" class="nav_with_submenu <?=$actual_page=="student_handling"?"actual_page":"not_actual_page"?>">
                    Csoport hozzáadása
                    <div class="submenu">
                        <?php if($can_apply_to_group):?>
                            <a class="submenu_row" href=<?="./index.php?site=groupAddition&action=addAsStudent"?>>Csoporthoz való csatlakozás hallgatóként</a>
                        <?php endif?>
                        <?php if($can_add_group):?>
                            <a class="submenu_row" href=<?="./index.php?site=groupAddition&action=addAsDemonstrator"?>>Csoporthoz való csatlakozás demonstrátorként</a>
                        <?php endif?>                 
                    </div>
                </nav>
            <?php endif?>

        </div>
    <?php endif?>
</header>