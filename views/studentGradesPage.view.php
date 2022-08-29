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

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./views/css/header.css" rel="stylesheet" type="text/css">
    <link href="./views/css/body.css" rel="stylesheet" type="text/css">
    <title>Diákok eredményei</title>
</head>
<body>
    <?php include("./partials/header.php")?>
    <main>
    </main>
</body>
<script type="module" src="./views/js/mainContent.js"></script>
</html>