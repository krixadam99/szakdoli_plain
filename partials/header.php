<header>
    <div id="header_line">
        <button id="sign_out_button">Kilépés</button>
    </div>
    
    <?php if(!$is_administrator):?>
        <div id="header_line">
            <?php if(count($approved_teacher_groups) != 0):?> <!-- there is at least one group assigned to this user -->
                <nav id="generate_task" class="nav_with_submenu">
                    Feladatsor összeállítása
                    <div class="submenu">                    
                        <?php foreach($approved_teacher_subjects as $approved_teacher_subject):?>                            
                            <a class="submenu_row" href=<?="./index.php?site=taskGeneration&subject=" . $approved_teacher_subject?>><?=$approved_teacher_subject=="i"?"Diszkrét matematika I.":"Diszkrét matematika II."?></a>
                        <?php endforeach?>
                    </div>
                </nav>

                <nav id="students" class="nav_with_submenu">
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

                <nav id="student_grades" class="nav_with_submenu">
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

            <?php endif?>
            <?php if(count($approved_student_groups) != 0):?> <!-- this user is assigned to at least one group -->
                <?php if(count($approved_teacher_groups) != 0):?>
                    <nav id="empty_nav"></nav>
                <?php endif?>
                <nav id="practice" class="nav_without_submenu">
                    <a class="menu_cell" href=<?="./index.php?site=practice"?>>Gyakorlás</a>
                </nav>

                <nav id="personal_grades" class="nav_without_submenu">
                    <a class="menu_cell" href=<?="./index.php?site=grades"?>>Saját eredményeim</a>
                </nav>
            <?php endif?>
        </div>
    <?php endif?>
</header>