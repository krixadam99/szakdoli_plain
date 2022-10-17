<?php
    /**
     * This is a model class which is responsible for requesting data for the messages page and creating a new message row in the messages table.
     * 
     * This model extends the MainModel class.
    */
    class MessagesModel extends MainModel {
        /**
         * This public method returns the removed messages of the user from the messages table.
         * 
         * @param string $neptun_code The neptun code of the user.
         * 
         * @return array Returns an array containing the removed messages of the user.
         */
        public function GetRemovedMessages($neptun_code){
            $neptun_code = strtoupper($neptun_code);
            $query = "SELECT * FROM messages WHERE ";
            $query .= "messages.neptun_code_to = \"$neptun_code\" AND is_removed_by_receiver = \"1\" OR messages.neptun_code_from = \"$neptun_code\" AND is_removed_by_sender = \"1\"";
            return $this->database->LoadDataFromDatabase($query);
        }

        /**
         * This public method returns the messages of the user from the messages table where they are the receiver.
         * 
         * @param string $neptun_code The neptun code of the user.
         * 
         * @return array Returns an array containing the messages of the user where they are the receiver.
         */
        public function GetRecievedMessages($neptun_code){
            $neptun_code = strtoupper($neptun_code);
            $query = "SELECT * FROM messages WHERE ";
            $query .= "messages.neptun_code_to = \"$neptun_code\" AND is_removed_by_receiver = \"0\"";
            return $this->database->LoadDataFromDatabase($query);
        }

        /**
         * This public method returns the messages of the user from the messages table where they are the sender.
         * 
         * @param string $neptun_code The neptun code of the user.
         * 
         * @return array Returns an array containing the messages of the user where they are the sender.
         */
        public function GetSentMessages($neptun_code){
            $neptun_code = strtoupper($neptun_code);
            $query = "SELECT * FROM messages WHERE ";
            $query .= "messages.neptun_code_from = \"$neptun_code\" AND is_removed_by_sender = \"0\"";
            return $this->database->LoadDataFromDatabase($query);
        }

        /**
         * This public method returns the neptun codes of the users from the user_groups table who has some connection to the given user.
         * 
         * @param string $neptun_code The neptun code of the user.
         * 
         * @return array Returns an array containing the neptun codes of the users from the user_groups table who either has some connection to the given user, or a teacher, or the administrator.
         */
        public function GetNeptunCodes($neptun_code){
            $neptun_code = strtoupper($neptun_code);
            
            $associated_query = "SELECT DISTINCT second_table.neptun_code FROM user_groups first_table,user_groups second_table ";
            $associated_query .= "WHERE first_table.neptun_code != second_table.neptun_code ";
            $associated_query .= "AND first_table.neptun_code = \"$neptun_code\" ";
            $associated_query .= "AND first_table.subject_name = second_table.subject_name ";
            $associated_query .= "AND first_table.subject_group = second_table.subject_group ";
            $associated_query .= "AND first_table.application_request_status = \"APPROVED\" ";
            $associated_query .= "AND second_table.application_request_status = \"APPROVED\"";
            
            $teachers_query = "SELECT DISTINCT neptun_code FROM user_groups ";
            $teachers_query .= "WHERE neptun_code != \"$neptun_code\" ";
            $teachers_query .= "AND is_teacher=\"1\" ";
            $teachers_query .= "AND application_request_status = \"APPROVED\"";

            $associated_array = array_values($this->database->LoadDataFromDatabase($associated_query));
            $teachers_array = array_values($this->database->LoadDataFromDatabase($teachers_query));

            return [$associated_array,$teachers_array];
        }
    }

?>