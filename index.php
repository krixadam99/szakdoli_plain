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

        if(isset($_GET["exam_type"])){
            $_SESSION["exam_type"] = $_GET["exam_type"];
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
    $controller_connection->get_method_connection("index", "IndexController", "Index");
    $controller_connection->get_method_connection("login", "LoginController", "Login");
    $controller_connection->get_method_connection("forgottenPassword", "LoginController", "forgottenPassword");
    $controller_connection->get_method_connection("register", "RegistrationController", "Registration");
    
    $controller_connection->get_method_connection("demonstratorHandling", "AdministratorController", "DemonstratorHandling");
    $controller_connection->get_method_connection("notifications", "NotificationsController", "Notifications");
    $controller_connection->get_method_connection("messages", "MessagesController", "Messages");
    $controller_connection->get_method_connection("writeMessage", "MessagesController", "WriteMessage");
    $controller_connection->get_method_connection("groupAddition", "GroupAdditionController", "GroupAddition");
    $controller_connection->get_method_connection("taskGeneration", "TaskGenerationController", "TaskGeneration");
    $controller_connection->get_method_connection("printPage", "TaskGenerationController", "PrintPage");
    $controller_connection->get_method_connection("studentHandling", "StudentHandlingController", "StudentHandling");
    $controller_connection->get_method_connection("studentGrades", "StudentGradesController", "StudentGrades");
    $controller_connection->get_method_connection("practice", "PracticeController", "Practice");
    $controller_connection->get_method_connection("practiceShowAnswers", "PracticeController", "PracticeAnswers");
    $controller_connection->get_method_connection("grades", "GradesController", "Grades");
    
    //POST methods connection
    $controller_connection->post_method_connection("validateLogin", "LoginController", "ValidateLogin");
    $controller_connection->post_method_connection("validateForgottenPassword", "LoginController", "ValidateForgottenPassword");
    $controller_connection->post_method_connection("validateRegistration", "RegistrationController", "ValidateRegistration");
    $controller_connection->post_method_connection("finalizePending", "AdministratorController", "FinalizePending");
    $controller_connection->post_method_connection("sendNewMessage", "MessagesController", "SendNewMessage");
    $controller_connection->post_method_connection("replyToMessage", "MessagesController", "ReplyToMessage");
    $controller_connection->post_method_connection("validateGroupAddition", "GroupAdditionController", "ValidateGroupAddition");
    $controller_connection->post_method_connection("studentHandling", "StudentHandlingController", "HandleStudents");
    $controller_connection->post_method_connection("upgradeStudentGrades", "StudentGradesController", "UpdateResults");
    $controller_connection->post_method_connection("upgradeExpectationRules", "StudentGradesController", "UpdateExpectationRules");
    $controller_connection->post_method_connection("upgradeTaskDueDates", "StudentGradesController", "UpdateTaskDueDates");
    $controller_connection->post_method_connection("upgradeGradeLevels", "StudentGradesController", "UpdateGradeLevels");
    $controller_connection->post_method_connection("handInSolution", "PracticeController", "HandInSolution");
    $controller_connection->post_method_connection("createPreview", "TaskGenerationController", "CreatePreview");
    
    
    //Starting the connection
    $controller_connection->start_connection();
?>