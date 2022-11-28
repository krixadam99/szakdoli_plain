<?php    
    session_start();

    //The path of the root directory
    define('ROOT_DIRECTORY', __DIR__);   

    //Set some SESSION variables, like subject name etc.
    //Do not let the user overwrite the session variables, when making a post request (like by letting them to overwrite the action url) 
    if(count($_POST) === 0){
        //If subject, group, topic, or exam_type is set in the url, then let's overwrite it, else let's clear them 
        if(isset($_GET["subject"])){
            $_SESSION["subject"] = $_GET["subject"];
        }else{
            $_SESSION["subject"] = "";
        }
    
        if(isset($_GET["group"])){
            $_SESSION["group"] = $_GET["group"];
        }else{  
            $_SESSION["group"] = "";
        }

        if(isset($_GET["topic"])){
            $_SESSION["topic"] = $_GET["topic"];
        }else{
            $_SESSION["topic"] = "";
        }

        if(isset($_GET["examType"])){
            $_SESSION["exam_type"] = $_GET["examType"];
        }else{
            unset($_SESSION["exam_type"]);
        }

        if(isset($_GET["groupAdditionAction"])){
            $_SESSION["group_addition_action"] = $_GET["groupAdditionAction"];
        }else{
            unset($_SESSION["group_addition_action"]);
        }

        if(isset($_GET["messageId"])){
            $_SESSION["message_id"] = $_GET["messageId"];
        }else{
            unset($_SESSION["message_id"]);
        }

        if(isset($_GET["messageType"])){
            $_SESSION["message_type"] = $_GET["messageType"];
        }

        if(isset($_GET["startAt"])){
            $_SESSION["start_at"] = $_GET["startAt"];
        }else{
            unset($_SESSION["start_at"]);
        }
    }

    //Auto-loading classes 
    spl_autoload_register("autoload_function");
    function autoload_function($class_name) {
        $model_class_path = "./models/" . strtolower($class_name[0]) . substr($class_name,1) . '.model.php';
        $controller_path = "./controllers/" . strtolower($class_name[0]) . substr($class_name,1) . '.controller.php';
        $view_path = "./views/" . strtolower($class_name[0]) . substr($class_name,1) . '.view.php';
        $lib_path = "./lib/" . strtolower($class_name[0]) . substr($class_name,1) . '.php';
        $util_classes = "./services/" . strtolower($class_name[0]) . substr($class_name,1) . '.class.php';

        if(file_exists($model_class_path)){
            require_once($model_class_path);
        }

        if(file_exists($lib_path)){
            require_once($lib_path);
        }

        if(file_exists($controller_path)){
            require_once($controller_path);
        }

        if(file_exists($view_path)){
            require_once($view_path);
        }

        if(file_exists($util_classes)){
            require_once($util_classes);
        }
    }

    //Connecting the end-points of views and controllers
    $controller_connection = new ControllerConnector();
    
    //GET methods connection
    $controller_connection->GetMethodConnection("index", "IndexController", "Index");
    $controller_connection->GetMethodConnection("login", "LoginController", "Login");
    $controller_connection->GetMethodConnection("forgottenPassword", "LoginController", "forgottenPassword");
    $controller_connection->GetMethodConnection("register", "RegistrationController", "Registration");
    
    $controller_connection->GetMethodConnection("demonstratorHandling", "AdministratorController", "DemonstratorHandling");

    $controller_connection->GetMethodConnection("notifications", "NotificationsController", "Notifications");

    $controller_connection->GetMethodConnection("messages", "MessagesController", "Messages");
    $controller_connection->GetMethodConnection("writeMessage", "MessagesController", "WriteMessage");

    $controller_connection->GetMethodConnection("groupAddition", "UserDetailsController", "GroupAddition");
    $controller_connection->GetMethodConnection("personalInformation", "UserDetailsController", "PersonalInformation");

    $controller_connection->GetMethodConnection("taskGeneration", "TaskGenerationController", "TaskGeneration");
    $controller_connection->GetMethodConnection("printPage", "TaskGenerationController", "PrintPage");

    $controller_connection->GetMethodConnection("studentHandling", "StudentHandlingController", "StudentHandling");

    $controller_connection->GetMethodConnection("studentGrades", "StudentGradesController", "StudentGrades");

    $controller_connection->GetMethodConnection("practice", "PracticeController", "Practice");
    $controller_connection->GetMethodConnection("practiceShowAnswers", "PracticeController", "PracticeAnswers");

    $controller_connection->GetMethodConnection("grades", "GradesController", "Grades");
    
    //POST methods connection
    $controller_connection->PostMethodConnection("validateLogin", "LoginController", "ValidateLogin");
    $controller_connection->PostMethodConnection("validateForgottenPassword", "LoginController", "ValidateForgottenPassword");
    $controller_connection->PostMethodConnection("validateRegistration", "RegistrationController", "ValidateRegistration");

    $controller_connection->PostMethodConnection("finalizePending", "AdministratorController", "FinalizePending");

    $controller_connection->PostMethodConnection("sendNewMessage", "MessagesController", "SendNewMessage");
    $controller_connection->PostMethodConnection("replyToMessage", "MessagesController", "ReplyToMessage");
    $controller_connection->PostMethodConnection("deleteMessages", "MessagesController", "DeleteMessages");
    $controller_connection->PostMethodConnection("recoverDeletedMessages", "MessagesController", "RecoverDeletedMessages");

    $controller_connection->PostMethodConnection("validateGroupAddition", "UserDetailsController", "ValidateGroupAddition");
    $controller_connection->PostMethodConnection("validateNewUserInformation", "UserDetailsController", "ValidateNewPersonalInformation");

    $controller_connection->PostMethodConnection("studentHandling", "StudentHandlingController", "HandleStudents");

    $controller_connection->PostMethodConnection("upgradeStudentGrades", "StudentGradesController", "UpdateResults");
    $controller_connection->PostMethodConnection("upgradeExpectationRules", "StudentGradesController", "UpdateExpectationRules");
    $controller_connection->PostMethodConnection("upgradeTaskDueDates", "StudentGradesController", "UpdateTaskDueDates");
    $controller_connection->PostMethodConnection("upgradeGradeLevels", "StudentGradesController", "UpdateGradeLevels");

    $controller_connection->PostMethodConnection("handInSolution", "PracticeController", "HandInSolution");

    $controller_connection->PostMethodConnection("createPreview", "TaskGenerationController", "CreatePreview");
    
    //Starting the connection
    $controller_connection->StartConnection();
?>