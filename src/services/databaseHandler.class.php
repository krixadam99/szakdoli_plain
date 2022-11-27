<?php    
    /**
     * This is a class which is responsible for making the actual data fetching and updating the database.
    */
    class DatabaseHandler { 
        // These values should be replaced when someone wants to run the program locally, and create a database 
        private $server_name = "localhost";
        private $database_user_name = "kadam99";
        private $database_user_password = "H6-1aOs(71-a";
        private $database_name = "szakdoli";
        private $pdo_connection;
        
        /**
         * 
         * The contructor of the DataBaseHandler class.
         * 
         * @return void
         */
        public function __construct(){
            $this->pdo_connection = new PDO("mysql:host=" . $this->server_name . ";dbname=" . $this->database_name . "", $this->database_user_name, $this->database_user_password);
        }

        /**
         * This method is responsible for loading data from the database.
         * 
         * @param string $query The query to send to the database.
         * @param array $binding_params An array containing the binding parameters. The default is [].
         * 
         * @return array The data stored in an array.
         */
        public function LoadDataFromDatabaseWithPDO($query, $binding_params = []){
            $prepared_statement = $this->pdo_connection->prepare($query);
            $prepared_statement->execute($binding_params);
            return $prepared_statement->fetchAll(PDO::FETCH_ASSOC);
        }

        /**
         * This method is responsible for loading data from the database.
         * 
         * @param string $query The query to send to the database.
         * @param array $binding_params An array containing the binding parameters. The default is [].
         * 
         * @return bool A boolean value that determines whether updating the database was sucessful, or not.
         */
        public function UpdateDatabaseWithPDO($query, $binding_params = []){
            $prepared_statement = $this->pdo_connection->prepare($query);
            return $prepared_statement->execute($binding_params);
        }

    }
?>