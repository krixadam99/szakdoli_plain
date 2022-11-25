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
         *
         * This method is responsible for loading data from the database.
         * 
         * If the result is a boolean, and was unsuccessful, the user will be shown an error page.
         * 
         * @param string $query The query to send to the database.
         * @param string $data_type The array type of the returned value, can either be MYSQLI_ASSOC or MYSQLI_NUM.
         * 
         * @return array The data stored in an array.
        */
        /*public function LoadDataFromDatabase($query, $data_type = MYSQLI_ASSOC) {
            $connection = mysqli_connect($this->server_name, $this->database_user_name, $this->database_user_password,  $this->database_name);
            //$connection = mysql_connect_caesar();
            if(!$connection){
                exit("Connection wasn't successful: " . mysqli_connect_error());
            }

            //Making the query
            $result = mysqli_query($connection, $query);

            if(is_bool($result) && $result === false){
                exit("Fetching data from database was not successful!");
            }
        
            //Get the results
            $data = mysqli_fetch_all($result, $data_type);
            
            //Free result from memory
            mysqli_free_result($result);
        
            //Closing the connection
            mysqli_close($connection);
            
            return $data;
        }*/

        /**
         *
         * This method is responsible for loading data from the database.
         * 
         * @param string $query The query to send to the database.
         * @param bool $multi Whether the query is a multi line transaction, or a single line one.
         * 
         * @return bool A boolean value that determines whether updating the database was sucessful, or not.
        */
        /*public function UpdateDatabase($query, $multi = false) {
            $connection = mysqli_connect($this->server_name, $this->database_user_name, $this->database_user_password,  $this->database_name);
            if(!$connection){
                exit("Connection wasn't successful: " . mysqli_connect_error());
            }
            
            //Making the query
            $result = false;
            if($multi){
                $result = mysqli_multi_query($connection, $query);
            }else{
                $result = mysqli_query($connection, $query);
            }
            
            //Closing the connection
            mysqli_close($connection);

            return $result;
        }*/

        /**
         * This method is responsible for loading data from the database.
         * 
         * @param string $query The query to send to the database.
         * @param array $bind_params An array containing the binding parameters.
         * 
         * @return array The data stored in an array.
         */
        public function LoadDataFromDatabaseWithPDO($query, $bind_params = []){
            $prepared_statement = $this->pdo_connection->prepare($query);
            $prepared_statement->execute($bind_params);
            return $prepared_statement->fetchAll(PDO::FETCH_ASSOC);
        }

        /**
         * This method is responsible for loading data from the database.
         * 
         * @param string $query The query to send to the database.
         * @param array $bind_params An array containing the binding parameters.
         * 
         * @return bool A boolean value that determines whether updating the database was sucessful, or not.
         */
        public function UpdateDatabaseWithPDO($query, $bind_params = []){
            $prepared_statement = $this->pdo_connection->prepare($query);
            return $prepared_statement->execute($bind_params);
        }

    }
?>