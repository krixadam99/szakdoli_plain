<?php
    /**
     * This is the model which will be extended by the controllers belonging to the main part (i.e., not login, registration, index) throughout the project.
     * 
     * Every controller belonging to the main part (i.e., not login, registration, index) will instantiate its own model class. 
     * Each of these class will extend this model, so every one of them will inherit the public and protected methods implemented here.
     * It is possible, that some of them will not have further methods.
     */
    class MainModel {        
        protected $database;
        
        /**
         * The constructor method of the MainModel class.
         * 
         * @return void 
         */
        public function __construct(){
            $this->database = new DatabaseHandler();
        }

        /**
         * This public method fetches data from the database via the given query.
         * 
         * @param string $query The query with which data will be fetched from the database.
         * @param int $data_type The form of the returned array (either associative or indexed). The default is MYSQLI_ASSOC.
         * 
         * @return array Returns an array containing the data fetched from the database.
         */
        public function GetDataFromDatabase($query, $data_type = MYSQLI_ASSOC){
            return $this->database->LoadDataFromDatabase($query, $data_type);
        }

        /**
         * This public method fetches all of the rows from the users table, or users and user_groups joined tables that belongs to the user with the given neptun code.
         * 
         * The administrator will only be present in the users table, so for them data should be fetched only from the users table.
         * Every other user's data will be fetched from the users, user_status and subject_group joined table (the first two will be joined on the neptun_code, the last two on the subject_group_id attribute).
         * 
         * @param string $neptun_code The neptun code of the user.
         * 
         * @return array Returns an array containing the fetched rows.
         */
        public function GetUserData($neptun_code){
            $neptun_code = strtoupper($neptun_code);
            $query = "";
            if($neptun_code == "ADMIN"){
                $query = "SELECT * FROM users WHERE users.neptun_code = \"".$neptun_code."\"";
            }else{
                $query = "SELECT * FROM users JOIN user_status USING(neptun_code) JOIN subject_group USING(subject_group_id)
                WHERE users.neptun_code = \"".$neptun_code."\"";
            }
            return $this->database->LoadDataFromDatabase($query);
        }

        /**
         * This public method updates the database by the given query.
         * 
         * @param string $query The query with which data will be updated in the database.
         * 
         * @return bool Returns whether updating the database was successful, or not.
         */
        public function UpdataDatabase($query){
            return $this->database->UpdateDatabase($query);
        }
    }

?>