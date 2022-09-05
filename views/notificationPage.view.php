<?php
    
    $is_administrator = $this->GetIsAdministrator();
    $neptun_code = $this->GetNeptunCode();
    $user_data = $this->GetUserData();
    $pending_users = $this->GetPendingTeachers();
    $pending_teacher_groups = $this->GetPendingTeacherGroups();
    $pending_student_groups = $this->GetPendingStudentGroups();
    $approved_teacher_groups = $this->GetApprovedTeacherGroups();
    $approved_teacher_subjects = $this->GetApprovedTeacherSubjects();
    $approved_student_groups = $this->GetApprovedStudentGroups();

    $actual_page = "notifications";

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./views/css/header.css" rel="stylesheet" type="text/css">
    <link href="./views/css/body.css" rel="stylesheet" type="text/css">
    <title>Értesítések</title>
</head>
<body>
    <?php include("./partials/header.php")?>
    <main>
        <h1>Értesítések</h1>
        <hr>
        <?php if(!$is_administrator):?>
            <?php include("./partials/pendingContent.php")?>
            <?php include("./partials/approvedContent.php")?>
            <?php if(count($pending_teacher_groups) == 0 && count($pending_student_groups) == 0):?>
                <div id="notification_box">
                    <label>Nincsen elbírálás allatt álló tárgya!</label>
                </div>
            <?php endif?>
        <?php else:?>
            <?php if(count($pending_users) != 0):?>
                <?php include("./partials/pendingTable.php")?>
            <?php else:?>
                <div id="notification_box">
                    <label>Nincsen elbírálás allatt álló tanár!</label>
                </div>
            <?php endif?>
        <?php endif?>
    </main>
</body>
<script type="module" src="./views/js/mainContent.js"></script>
</html>