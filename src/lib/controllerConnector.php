<?php
    /**
     * This is the class which is responsible for connecting the end points. This performs the routing.
    */
    class ControllerConnector{
        private $paths = [];

        /**
         *
         * This method is responsible for making the actual connections.
         * 
         * If there is no site key in the URI, or is present in the URI, however there is no end point for it, then the default page, that is, the index page, will be displayed.
         * For each valid site value the respective end point (controller) will be instantiated, and the appropriate caller method will be called upon creation.
         * 
         * @return void
        */
        public function StartConnection() {
            $current_site = $_GET["site"] ?? "index"; //The default site is the index page
            $method = $_SERVER["REQUEST_METHOD"];

            foreach ($this->paths as $path) {
                if ($path["path"] === $current_site && $path["method"] === $method) {
                    $controller_name = $path["controller"];
                    $controller_method = $path["controller_method"];

                    if($method === "GET"){
                        $_SESSION["form_generated_token"] = bin2hex(random_bytes(24));
                    }

                    if(     $method !== "POST" 
                        ||  ($method === "POST" 
                        &&  isset($_SESSION["form_generated_token"]) 
                        &&  isset($_POST["token"]) 
                        &&  $_POST["token"] === $_SESSION["form_generated_token"]
                        &&  isset($_SESSION["previous_controller"])
                        &&  $_SESSION["previous_controller"] === $controller_name
                        )
                    ){

                        $controller = new $controller_name();
                        $controller->$controller_method();
                        return;
                    }

                    
                    /*var_dump($method, $_SESSION["form_generated_token"]);

                    $controller = new $controller_name();
                    $controller->$controller_method();
                    return;*/
                    
                }
            }

            if(isset($_SESSION["neptun_code"])){ //If the user is logged in and they wanted to access a non-existent end point, then they will be redirected to the notifications page
                header("Location: ./index.php?site=notifications");
            }else{ //If the user is not logged in and they wanted to access a non-existent end point, then they will be redirected to the login page
                header("Location: ./index.php?site=login");
            }
            return;
        }

        /**
         *
         * This method is responsible for connecting the end points between views and controllers, when the http-method is GET.
         * 
         * If the HTTP method is a GET, then we connect the given path to the caller page and the controller.
         * We also states what method should be called upon the creation of the controller.
         * 
         * @param string $path The first end point.
         * @param Class $controller The other end point.
         * @param callable $controller_method The controller's method which should be called upon creation of the controller.
         * 
         * @return void
        */
        public function GetMethodConnection($path, $controller, $controller_method) {
            $this->paths[] = [
                "path" => $path,
                "method" => "GET",
                "controller" => $controller,
                "controller_method" => $controller_method
            ];
        }

        /**
         *
         * This method is responsible for connecting the end points between views and controllers, when the http-method is POST.
         * 
         * If the HTTP method is a POST, then we connect the given path to the caller page and the controller.
         * We also states what method should be called upon the creation of the controller.
         * 
         * @param string $path The first end point.
         * @param Class $controller The other end point.
         * @param callable $controller_method The controller's method which should be called upon creation of the controller.
         * 
         * @return void
        */
        public function PostMethodConnection($path, $controller, $controller_method) { 
            $this->paths[] = [
                "path" => $path,
                "method" => "POST",
                "controller" => $controller,
                "controller_method" => $controller_method
            ];
        }
    };

?>