<?php if(isset($_SESSION["task"])):?>
    <?php if($_SESSION["task"] == "task_generation"):?>
        <?php if(isset($_SESSION["subject"])):?>
            <h1><?=$_SESSION["subject"]=="i"?"Diszkrét matematika I.":"Diszkrét matematika II."?>    feladatsor összeállítása</h1>
            <hr>
            <div class="card_row">
                <div class="big_card">
                    Nagy zárthelyi összeállítása
                </div>
                <div class="big_card">
                    Kis zárthelyi összeállítása
                </div>
                <div class="big_card">
                    Órai feladat készítése
                </div>
            </div>
        <?php endif?>
    <?php elseif($_SESSION["task"] == "student_handling"):?>
    <?php elseif($_SESSION["task"] == "student_grades"):?>
    <?php elseif($_SESSION["task"] == "practice"):?>
        <?php if(isset($_SESSION["subject"])):?>
            <h1>
                <?php if($_SESSION["subject"] == "i"):?>
                    Diszkrét matematika I. feladatok gyakorlása
                <?php elseif($_SESSION["subject"] == "ii"):?>
                    Diszkrét matematika II. feladatok gyakorlása
                <?php else:?>
                    Diszkrét matematikai modellek és alkalmazások szemléltetések
                <?php endif?>
            </h1>
            <hr>
            <?php if($_SESSION["subject"] == "i"):?>
                <?php for($row_counter = 0; $row_counter < 3; $row_counter++):?>
                    <div class="card_row">
                        <?php for($column_counter = 0; $column_counter < 4; $column_counter++):?>
                            <div class="small_card">
                                ...text...
                            </div>
                        <?php endfor?>
                    </div>
                <?php endfor?>
            <?php elseif($_SESSION["subject"] == "ii"):?>
                <?php for($row_counter = 0; $row_counter < 3; $row_counter++):?>
                    <div class="card_row">
                        <?php for($column_counter = 0; $column_counter < 4; $column_counter++):?>
                            <div class="small_card">
                                ...text...
                            </div>
                        <?php endfor?>
                    </div>
                <?php endfor?>
            <?php else:?>
                <?php for($row_counter = 0; $row_counter < 2; $row_counter++):?>
                    <div class="card_row">
                        <?php for($column_counter = 0; $column_counter < 4; $column_counter++):?>
                            <div class="small_card">
                                ...text...
                            </div>
                        <?php endfor?>
                    </div>
                <?php endfor?>
            <?php endif?>        
        <?php endif?>
    <?php elseif($_SESSION["task"] == "grades"):?>
    <?php endif?>
<?php else:?>
    <h1>Értesítések</h1>
    <hr>
<?php endif?>