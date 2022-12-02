<?php
    /**
     * This is a controller class which is responsible for showing the index (home) page.
    */
    class IndexController {
        /**
         *
         * This method is responsible for showing the index (home) page.
         * 
         * Once a client is directed to this page, the session variables will be unset and destroyed.
         * 
         * @return void
        */
        public function Index() {
            $_SESSION["previous_controller"] = "IndexController";

            session_unset();
            session_destroy();

            include(ROOT_DIRECTORY . "/views/indexPage.view.php");
        }
    }

?>