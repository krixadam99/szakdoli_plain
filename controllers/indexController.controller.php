<?php
    
    class IndexController{
        /**
         *
         * This function is responsible for showing the index (home) page 
         * 
         * Once a client is directed to this page, the session variables will be cleared
         * 
         * @return void
        */
        public function Index(){
            session_unset();
            session_destroy();
            
            include(ROOT_DIRECTORY . "/views/indexPage.view.php");
        }
    }

?>