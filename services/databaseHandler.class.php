<?php

    class DatabaseHandler { 
        private $database;
        
        public function __construct($database){
            $this->database = $database;
        }
        
        /**
         *
         * This function is responsible for loading data from the database
         * 
         * If the result is a boolean, and was unsuccessful, the user will be shown an error page
         * 
         * @param string $query The query to send to the database
         * @param string $data_type The array type of the returned value, can either be MYSQLI_ASSOC or MYSQLI_NUM
         * @return array The data stored in an array
        */
        public function LoadDataFromDatabase($query, $data_type = MYSQLI_ASSOC) {
            $connection = mysqli_connect('localhost', "kadam99", "H6-1aOs(71-a",  $this->database);
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
        }

        /**
         *
         * This function is responsible for loading data from the database
         * 
         * @param string $query The query to send to the database
         * @param bool $multi Whether the query is a multi line transaction, or a single line one
         * @return bool A boolean value that tells us whether updating the database was sucessful, or not
        */
        public function UpdateDatabase($query, $multi = false) {
            $connection = mysqli_connect('localhost', "kadam99", "H6-1aOs(71-a",  $this->database);
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
        }
    }

?>