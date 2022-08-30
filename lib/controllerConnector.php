<?php

    class ControllerConnector{
        private $paths = [];

        public function start_connection() {
            $current_site = $_GET["site"] ?? "index";
            $http_method = $_SERVER["REQUEST_METHOD"];

            foreach ($this->paths as $path) {
                if ($path["path"] === $current_site && $path["http-method"] === $http_method) {
                    $controller_name = $path["controller"];
                    $method_name = $path["method"];

                    $controller = new $controller_name();
                    $controller->$method_name();
                    return;
                }
            }

            if(isset($_SESSION["neptun_code"])){
                $controller = new NotificationsController();
                $controller->Notifications();
            }else{
                $controller = new IndexController();
                $controller->Index();
            }
            return;
        }

        public function get_method_connection($path, $controller, $method) {
            $this->paths[] = [
                "path" => $path,
                "http-method" => "GET",
                "controller" => $controller,
                "method" => $method
            ];
        }

        public function post_method_connection($path, $controller, $method) { 
            $this->paths[] = [
                "path" => $path,
                "http-method" => "POST",
                "controller" => $controller,
                "method" => $method
            ];
        }
    };

?>