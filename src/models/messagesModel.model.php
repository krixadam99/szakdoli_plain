<?php
    /**
     * This is a model class which is responsible for requesting data for the messages page and creating a new message row in the messages table.
     * 
     * This model extends the MainModel class.
    */
    class MessagesModel extends MainModel {
        /**
         * 
         * The contructor of the MessagesModel class.
         * 
         * It will call the MainModel class's constructor with which it will assign default values to the inherited members.
         * 
         * @return void
         */
        public function __construct(){
            parent::__construct();
        }
        
        /**
         * This public method returns the removed messages of the user from the messages table.
         * 
         * Messages will be fetched from the messages table.
         * The messages will be ordered by the sent_at date in descending manner.
         * Only those messages will be displayed for the given user that are the latest in their threads and removed by the user.
         * 
         * @param string $neptun_code The neptun code of the user.
         * @param int $start_at The index of the message from which the sytem will fetch messages
         * @param int $message_per_page The number of messages to fetch from the start.
         * 
         * 
         * @return array Returns an array containing the removed messages of the user.
         */
        public function GetRemovedMessages($neptun_code, $start_at, $message_per_page){
            $neptun_code = strtoupper($neptun_code);
            //$query = "SELECT * FROM messages WHERE ";
            //$query .= "messages.neptun_code_to = \"$neptun_code\" AND is_removed_by_receiver = \"1\" OR messages.neptun_code_from = \"$neptun_code\" AND is_removed_by_sender = \"1\"";
            
            $query  = "SELECT * FROM messages";
            $query .= " WHERE ((belongs_to, sent_at) IN (SELECT belongs_to, MAX(sent_at) AS sent_at FROM messages WHERE belongs_to != 0 GROUP BY belongs_to)"; // The latest message in a thread that belongs to other message
            $query .= " OR message_id NOT IN (SELECT DISTINCT first_table.message_id FROM messages first_table, messages second_table WHERE first_table.message_id = second_table.belongs_to) AND belongs_to = 0)"; // Messages that belong to no other message and do not have other message in their thread
            $query .= " AND messages.neptun_code_to = \"$neptun_code\" AND is_removed_by_receiver = \"1\" OR messages.neptun_code_from = \"$neptun_code\" AND is_removed_by_sender = \"1\"";
            $query .= " ORDER BY sent_at DESC";
            $query .= " LIMIT $start_at,  $message_per_page";

            return $this->database->LoadDataFromDatabaseWithPDO($query);
            //return $this->database->LoadDataFromDatabase($query);
        }

        /**
         * This public method returns the messages of the user from the messages table where they are the receiver.
         * 
         * Messages will be fetched from the messages table.
         * The messages will be ordered by the sent_at date in descending manner.
         * Only those messages will be displayed for the given user that are the latest in their threads and received by the user.
         * 
         * @param string $neptun_code The neptun code of the user.
         * @param int $start_at The index of the message from which the sytem will fetch messages
         * @param int $message_per_page The number of messages to fetch from the start.
         * 
         * 
         * @return array Returns an array containing the messages of the user where they are the receiver.
         */
        public function GetReceivedMessages($neptun_code, $start_at, $message_per_page){
            $neptun_code = strtoupper($neptun_code);
            //$query = "SELECT * FROM messages WHERE ";
            //$query .= "messages.neptun_code_to = \"$neptun_code\" AND is_removed_by_receiver = \"0\"";

            $query  = "SELECT * FROM messages";
            $query .= " WHERE ((belongs_to, sent_at) IN (SELECT belongs_to, MAX(sent_at) AS sent_at FROM messages WHERE belongs_to != 0 GROUP BY belongs_to)"; // The latest message in a thread that belongs to other message
            $query .= " OR message_id NOT IN (SELECT DISTINCT first_table.message_id FROM messages first_table, messages second_table WHERE first_table.message_id = second_table.belongs_to) AND belongs_to = 0)"; // Messages that belong to no other message and do not have other message in their thread
            $query .= " AND messages.neptun_code_to = \"$neptun_code\" AND is_removed_by_receiver = \"0\"";
            $query .= " ORDER BY sent_at DESC";
            $query .= " LIMIT $start_at,  $message_per_page";
            
            return $this->database->LoadDataFromDatabaseWithPDO($query);
            //return $this->database->LoadDataFromDatabase($query);
        }

        /**
         * This public method returns the messages of the user from the messages table where they are the sender.
         * 
         * Messages will be fetched from the messages table.
         * The messages will be ordered by the sent_at date in descending manner.
         * Only those messages will be displayed for the given user that are the latest in their threads and sent by the user.
         * 
         * @param string $neptun_code The neptun code of the user.
         * @param int $start_at The index of the message from which the sytem will fetch messages
         * @param int $message_per_page The number of messages to fetch from the start.
         * 
         * 
         * @return array Returns an array containing the messages of the user where they are the sender.
         */
        public function GetSentMessages($neptun_code, $start_at, $message_per_page){
            $neptun_code = strtoupper($neptun_code);
            //$query = "SELECT * FROM messages WHERE ";
            //$query .= "messages.neptun_code_from = \"$neptun_code\" AND is_removed_by_sender = \"0\"";

            $query  = "SELECT * FROM messages";
            $query .= " WHERE ((belongs_to, sent_at) IN (SELECT belongs_to, MAX(sent_at) AS sent_at FROM messages WHERE belongs_to != 0 GROUP BY belongs_to)"; // The latest message in a thread that belongs to other message
            $query .= " OR message_id NOT IN (SELECT DISTINCT first_table.message_id FROM messages first_table, messages second_table WHERE first_table.message_id = second_table.belongs_to) AND belongs_to = 0)"; // Messages that belong to no other message and do not have other message in their thread
            $query .= " AND messages.neptun_code_from = \"$neptun_code\" AND is_removed_by_sender = \"0\"";
            $query .= " ORDER BY sent_at DESC";
            $query .= " LIMIT $start_at,  $message_per_page";
            
            return $this->database->LoadDataFromDatabaseWithPDO($query);
            //return $this->database->LoadDataFromDatabase($query);
        }

        /**
         * This public method returns the message given by an id.
         * 
         * @param string $message_id The id of the selected message.
         * 
         * @return array Returns a message given by the id.
         */
        public function GetMessageById($message_id){
            $query = "SELECT * FROM messages WHERE ";
            $query .= "messages.message_id = \"$message_id\"";
            
            return $this->database->LoadDataFromDatabaseWithPDO($query)[0]??["belongs_to" => "-1"];
            //return $this->database->LoadDataFromDatabase($query)[0]??["belongs_to" => "-1"];
        }

        /**
         * This public method returns all of the messages of the user from the messages table.
         * 
         * Messages will be fetched from the messages table.
         * The messages will be ordered by the sent_at date in descending manner.
         * Only those messages will be displayed for the given user that are the latest in their threads and belong to the user.
         * 
         * @param string $neptun_code The neptun code of the user.
         * 
         * @return array Returns an array containing all of the messages of the user.
         */
        public function GetMessages($neptun_code){
            $neptun_code = strtoupper($neptun_code);
            //$query = "SELECT * FROM messages WHERE ";
            //$query .= "messages.neptun_code_from = \"$neptun_code\" OR messages.neptun_code_to = \"$neptun_code\"";

            $query  = "SELECT * FROM messages";
            $query .= " WHERE ((belongs_to, sent_at) IN (SELECT belongs_to, MAX(sent_at) AS sent_at FROM messages WHERE belongs_to != 0 GROUP BY belongs_to)"; // The latest message in a thread that belongs to other message
            $query .= " OR message_id NOT IN (SELECT DISTINCT first_table.message_id FROM messages first_table, messages second_table WHERE first_table.message_id = second_table.belongs_to) AND belongs_to = 0)"; // Messages that belong to no other message and do not have other message in their thread
            $query .= " AND messages.neptun_code_from = \"$neptun_code\" OR messages.neptun_code_to = \"$neptun_code\"";
            $query .= " ORDER BY sent_at DESC";
            
            return $this->database->LoadDataFromDatabaseWithPDO($query);
            //return $this->database->LoadDataFromDatabase($query);
        }

        /**
         * This public method returns the messages belonging to a given message id.
         * 
         * @param string $message_id The id of the selected message.
         * 
         * @return array Returns the messages belonging to the message given by the id.
         */
        public function GetMessagesBelongingToMessageId($message_id){
            $query = "SELECT * FROM messages WHERE";
            $query .= " messages.message_id = \"$message_id\"";
            $query .= " OR (belongs_to = (SELECT belongs_to FROM messages WHERE message_id = \"$message_id\") AND belongs_to != 0)";
            $query .= " OR message_id = (SELECT belongs_to FROM messages WHERE message_id = \"$message_id\")";
            $query .= " ORDER BY sent_at ASC";

            return $this->database->LoadDataFromDatabaseWithPDO($query);
        }

        /**
         * This public method returns the number of sent/received/deleted messages that would be displayed on the messaged page.
         * 
         * Messages will be fetched from the messages table.
         * Only those messages will be displayed for the given user that are the latest in their threads and sent by the user/ received by the user/ deleted by the user.
         * 
         * @param string $neptun_code The neptun code of the user.
         * @param string $type The type of the messages. Can be sent, received, or deleted.
         * 
         * @return array Returns an array containing the message_number number of fetched messages key - value pair
         */
        public function CountMessagesByType($neptun_code, $type){
            $query = "SELECT COUNT(*) message_number FROM messages";
            $query .= " WHERE ((belongs_to, sent_at) IN (SELECT belongs_to, MAX(sent_at) AS sent_at FROM messages WHERE belongs_to != 0 GROUP BY belongs_to)";
            $query .= " OR message_id NOT IN (SELECT DISTINCT first_table.message_id FROM messages first_table, messages second_table WHERE first_table.message_id = second_table.belongs_to) AND belongs_to = 0)";
            switch($type){
                case "sent":{
                    $query .= " AND messages.neptun_code_from = \"$neptun_code\" AND is_removed_by_sender = \"0\"";
                };break;
                case "received":{
                    $query .= " AND messages.neptun_code_to = \"$neptun_code\" AND is_removed_by_receiver = \"0\"";
                };break;
                case "deleted":{
                    $query .= " AND messages.neptun_code_to = \"$neptun_code\" AND is_removed_by_receiver = \"1\" OR messages.neptun_code_from = \"$neptun_code\" AND is_removed_by_sender = \"1\"";
                };break;
            }
            $query .= ";";

            return $this->database->LoadDataFromDatabaseWithPDO($query)[0]??["message_number" => 0];
        }


        /**
         * This public method returns the neptun codes of the users from the user_groups table who has connection with the given user.
         * 
         * @param string $neptun_code The neptun code of the user.
         * 
         * @return array Returns an array containing the neptun codes of the users from the user_groups table who either has some connection with the given user, or a teacher, or the administrator.
         */
        public function GetNeptunCodes($neptun_code){
            $neptun_code = strtoupper($neptun_code);
            
            $associated_query = "SELECT neptun_code FROM user_status 
            WHERE application_request_status = \"APPROVED\" 
            AND neptun_code != \"$neptun_code\"
            AND subject_group_id IN (SELECT subject_group_id FROM user_status WHERE neptun_code = \"$neptun_code\" AND  application_request_status = \"APPROVED\")";

            $teachers_query = "SELECT DISTINCT neptun_code FROM user_status JOIN subject_groups USING(subject_group_id) ";
            $teachers_query .= "WHERE neptun_code != \"$neptun_code\" ";
            $teachers_query .= "AND is_teacher=\"1\" ";
            $teachers_query .= "AND application_request_status = \"APPROVED\"";

            $administrators = array_values($this->database->LoadDataFromDatabaseWithPDO("SELECT neptun_code FROM users WHERE is_administrator = \"1\""));
            $associated_array = array_values($this->database->LoadDataFromDatabaseWithPDO($associated_query));
            $teachers_array = array_values($this->database->LoadDataFromDatabaseWithPDO($teachers_query));

            /*$administrators = array_values($this->database->LoadDataFromDatabase("SELECT neptun_code FROM users WHERE is_administrator = \"1\""));
            $associated_array = array_values($this->database->LoadDataFromDatabase($associated_query));
            $teachers_array = array_values($this->database->LoadDataFromDatabase($teachers_query));*/

            return [$administrators, $associated_array,$teachers_array];
        }

        /**
         * This public method will update the messages' table is_removed_by_sender and is_removed_by_receiver columns via the given query array.
         * 
         * @param array $query_array An indexed array containing associative arrays containing the column name - new value pairs.
         * @param bool $remove This parameter decides whether we should remove the message or recover it. The default is true (i.e., we should remove the message).
         * 
         * @return bool Returns whether the removing or recovering procedure was successful, or not.
        */
        public function RemoveRecoverMessages($query_array, $remove= true){
            $query = "BEGIN; ";
            foreach($query_array as $index => $record){
                $message_id = $record["message_id"];
                if(isset($record["is_removed_by_sender"])){
                    $query .= "UPDATE messages
                    SET is_removed_by_sender = ";
                    if($remove){
                        $query .= "1 ";
                    }else{
                        $query .= "0 ";
                    }
                    $query .= "WHERE message_id=\"$message_id\"; ";
                }else{
                    $query .= "UPDATE messages
                    SET is_removed_by_receiver = ";
                    if($remove){
                        $query .= "1 ";
                    }else{
                        $query .= "0 ";
                    }
                    $query .= "WHERE message_id=\"$message_id\"; ";
                }
            }
            $query .= "COMMIT;";
            
            return $this->database->UpdateDatabaseWithPDO($query, []);
            //return $this->database->UpdateDatabase($query, true);
        }
    }

?>