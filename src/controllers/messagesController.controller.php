<?php
    /**
     * This is a controller class which is responsible for showing the messages' page.
     * 
     * This controller extends the MainContentController, from which it inherits members that are related to a logged in user.
     * If someone navigates to the navigations page, although they are not logged in, then this controller redirects them to the login page.
     * On this page, messages (sent, incame and temporarily deleted) are displayed.
    */
    class MessagesController extends MainContentController{
        private $message_model;
        
        /**
         * 
         * The contructor of the MessagesController class.
         * 
         * It will call the MainContentController class's constructor with which it will assign default values to the inherited members.
         * 
         * @return void
         */
        public function __construct(){
            parent::__construct();
            $this->message_model = new MessagesModel();
        }
        
        /**
         *
         * This method shows the messages' page.
         * 
         * It also sets the members, which it inherited from the MainContentController, and are related to a logged in user.
         * If a client types the page name in the searchbar of the browser, but not logged in, then they will be redirected to the login page.
         *  
         * @return void
        */
        public function Messages(){
            // Users, who are not logged in won't see this page, they will be redirected to the login page
            if(isset($_SESSION["neptun_code"]) && isset($_SESSION["message_type"])){
                $this->SetMembers();

                // The number of messages to display per page
                $message_per_page = 3;

                // Starting index and actual page
                $start_at = $_SESSION["start_at"]??0;
                if($start_at > 0){
                    $start_at -= 1;
                }
                $start_at = $start_at * $message_per_page;
                $actual_page = $_SESSION["start_at"]??1;

                
                // This page is not the "write message" page
                if(isset($_SESSION["write_message"])){
                    unset($_SESSION["write_message"]);
                }

                // If the user clicked on an incame message, then the system should update the is_seen_by_receiver flag
                if(isset($_SESSION["message_id"])){
                    $this->message_model->UpdateDatabase("UPDATE messages SET is_seen_by_receiver = \"1\" WHERE neptun_code_to = \"" . $_SESSION["neptun_code"] . "\" AND message_id = \""  . $_SESSION["message_id"] . "\"");
                    //$this->message_model->UpdataDatabase("UPDATE messages SET is_seen_by_receiver = \"1\" WHERE neptun_code_to = \"" . $_SESSION["neptun_code"] . "\" AND message_id = \""  . $_SESSION["message_id"] . "\"");
                }

                $count_messages = 0;
                // Fetch the sent, incame and (temporarily) removed messages
                if($_SESSION["message_type"] === "received"){
                    $incame_messages = $this->message_model->GetReceivedMessages($_SESSION["neptun_code"], $start_at, $message_per_page);
                    $count_messages = $this->message_model->CountMessagesByType($_SESSION["neptun_code"], "received")["message_number"];
                }else if($_SESSION["message_type"] === "sent"){
                    $sent_messages = $this->message_model->GetSentMessages($_SESSION["neptun_code"], $start_at, $message_per_page);
                    $count_messages = $this->message_model->CountMessagesByType($_SESSION["neptun_code"], "sent")["message_number"];
                }else if($_SESSION["message_type"] === "deleted"){
                    $removed_messages = $this->message_model->GetRemovedMessages($_SESSION["neptun_code"], $start_at, $message_per_page);
                    $count_messages = $this->message_model->CountMessagesByType($_SESSION["neptun_code"], "deleted")["message_number"];
                }
                $maximum_number_of_page = ceil($count_messages/$message_per_page);

                // Set messages belonging to message id, additionally, set session variables too
                if(isset($_SESSION["message_id"])){
                    $messages_belonging_to_message_id = $this->message_model->GetMessagesBelongingToMessageId($_SESSION["message_id"]);
                    $_SESSION["thread_count_new"] = $messages_belonging_to_message_id[count($messages_belonging_to_message_id)-1]["thread_count"] + 1;
                    
                    $last_message_neptun_code_to = $messages_belonging_to_message_id[0]["neptun_code_to"];
                    $last_message_neptun_code_from = $messages_belonging_to_message_id[0]["neptun_code_from"];

                    if($last_message_neptun_code_to !== $_SESSION["neptun_code"]){
                        $_SESSION["neptun_code_to"] = $last_message_neptun_code_to;
                    }else{
                        $_SESSION["neptun_code_to"] = $last_message_neptun_code_from;
                    }
                   
                }

                include(ROOT_DIRECTORY . "/views/messagesPage.view.php");
            }else{
                header("Location: ./index.php?site=login");
            }
        }

        /**
         *
         * This method shows the page for writing a message.
         * 
         * It also sets the members, which it inherited from the MainContentController, and are related to a logged in user.
         * If a client types the page name in the searchbar of the browser, but not logged in, then they will be redirected to the login page.
         *  
         * @return void
        */
        public function WriteMessage(){
            // Users, who are not logged in won't see this page, they will be redirected to the login page
            if(isset($_SESSION["neptun_code"])){
                $this->SetMembers();
                
                $_SESSION["write_message"] = true;
                $neptun_codes = $this->GetAssociteNeptunCodes();
                
                include(ROOT_DIRECTORY . "/views/messagesPage.view.php");
            }else{
                header("Location: ./index.php?site=login");
            }
        }

        /**
         *
         * This method updates the messages table by a new message.
         *  
         * @return void
        */
        public function SendNewMessage(){
            //Neptun code must be set in the session, otherwise we cannot move forward
            if(isset($_SESSION["neptun_code"])){
                foreach($_POST as $key => $value){
                    $_POST[$key] = htmlspecialchars(htmlspecialchars($value, ENT_SUBSTITUTE)); // Prepare against XSS attack
                }
                
                $neptun_codes = $this->GetAssociteNeptunCodes();

                // Validate the message
                // The message_to should be a string, must not be the logged in user's neptun code, and must be in the possible neptun codes' list
                // The topic must be a string, and the length must be less than, or equal to 255 characters, additionally it should not be the place holder (Üzenet témája...), or the empty string
                // The text must be a string, and the length must be less than, or equal to 2024 characters, additionally it should not be the place holder (Üzenet szövege...), or the empty string
                $this->ValidateInputs(
                    [
                        "message_to:címzett" => array($_POST["message_to"]??-1 => [
                            "type" => "string",
                            "in_array" => $neptun_codes,
                            "not_is_same" => $_SESSION["neptun_code"],
                        ]),
                        "message_topic:üzenet tárgya" => array($_POST["message_topic"]??-2 => [
                            "type" => "string",
                            "not_placeholder" => ["","Üzenet tárgya..."],
                            "length" => ["<=","255"]
                        ]),
                        "message_text: üzenet törzse" => array($_POST["message_text"]??-3 => [
                            "type" => "string",
                            "not_placeholder" => ["","Üzenet szövege..."],
                            "length" => ["<=","2024"]
                        ])
                    ]
                );
                
                // If any of the sent data was incorrect
                if(count($this->incorrect_parameters) !== 0){
                    $this->WriteMessage();
                }else{ // If all of the sent data was valid
                    // Creating the message
                    $new_message_query = "INSERT INTO messages(neptun_code_from, neptun_code_to, message_topic, message_text) VALUES(
                        :neptun_code, 
                        :message_to, 
                        :message_topic, 
                        :message_text
                    );";
                    $this->message_model->UpdateDatabase($new_message_query, [":neptun_code" => strtoupper($_SESSION["neptun_code"]), ":message_to" => strtoupper($_POST["message_to"]), ":message_topic" => $_POST["message_topic"], ":message_text" => $_POST["message_text"]]);
                    
                    header("Location: ./index.php?site=messages&messageType=sent");
                }
            }else{
                header("Location: ./index.php");
            }
        }

        /**
         *
         * This method updates the messages table by a new message. This will be a reply message to a previous message.
         * 
         * The reply message id is stored in the session, and is deleted when the user goes to another page.
         *  
         * @return void
        */
        public function ReplyToMessage(){
            //Neptun code must be set in the session, otherwise we cannot move forward
            if(isset($_SESSION["neptun_code"])){
                if(isset($_SESSION["message_id"]) && $_SESSION["thread_count_new"] && $_SESSION["neptun_code_to"]){
                    foreach($_POST as $key => $value){
                        $_POST[$key] = htmlspecialchars(htmlspecialchars($value, ENT_SUBSTITUTE)); // Prepare against XSS attack
                    }
                    
                    // Validate the reply message
                    // The topic must be a string, and the length must be less than, or equal to 255 characters, additionally it should not be the place holder (Üzenet témája...), or the empty string
                    // The text must be a string, and the length must be less than, or equal to 2024 characters, additionally it should not be the place holder (Üzenet szövege...), or the empty string
                    $this->ValidateInputs(
                        [
                            "message_topic:üzenet témája" => array($_POST["message_topic"]??-2 => [
                                "type" => "string",
                                "not_placeholder" => ["","Üzenet témája..."],
                                "length" => ["<=","255"]
                            ]),
                            "message_text: üzenet törzse" => array($_POST["message_text"]??-3 => [
                                "type" => "string",
                                "not_placeholder" => ["","Üzenet szövege..."],
                                "length" => ["<=","2024"]
                            ])
                        ]
                    );
                    
                    // If any of the sent data was incorrect
                    if(count($this->incorrect_parameters) !== 0){
                        $this->Messages();
                    }else{ // If all of the sent data was valid
                        // Get the message with the actual id
                        $message_with_id = $this->message_model->GetMessageById($_SESSION["message_id"]);
                        if($message_with_id["belongs_to"] >= 0){
                            // Send a reply only when the message (more precisely, the first message in the thread) is not removed by neither the sender, nor the receiver
                            $is_removed_by_receiver = "0";
                            $is_removed_by_sender = "0";
                            $not_first_message = false;
                            $first_in_thread = 0;
                            if($message_with_id["belongs_to"] == "0"){
                                $is_removed_by_receiver = $message_with_id["is_removed_by_receiver"];
                                $is_removed_by_sender = $message_with_id["is_removed_by_sender"];
                            }else{
                                $not_first_message = true;
                                $first_in_thread = $message_with_id["belongs_to"];

                                $message_with_id = $this->message_model->GetMessageById($message_with_id["belongs_to"]);
                                $is_removed_by_receiver = $message_with_id["is_removed_by_receiver"];
                                $is_removed_by_sender = $message_with_id["is_removed_by_sender"];
                            }
    
                            if($is_removed_by_receiver === "0" && $is_removed_by_sender === "0"){
                                // Creating the reply message            
                                $new_message_query = "INSERT INTO messages(neptun_code_from, neptun_code_to, belongs_to, message_topic, message_text, thread_count, is_removed_by_receiver) VALUES(
                                    :neptun_code, 
                                    :message_to, 
                                    :message_id,
                                    :message_topic, 
                                    :message_text,
                                    :thread_count,
                                    :is_removed_by_receiver
                                );";
                                
                                $belongs_to = $_SESSION["message_id"];
                                if($not_first_message){
                                    $belongs_to = $first_in_thread;
                                }
                                $this->message_model->UpdateDatabase($new_message_query, [":neptun_code" => strtoupper($_SESSION["neptun_code"]), ":message_to" => strtoupper($_SESSION["neptun_code_to"]), ":message_id" => $belongs_to, ":message_topic" => $_POST["message_topic"], ":message_text" => $_POST["message_text"], ":thread_count" => $_SESSION["thread_count_new"], ":is_removed_by_receiver" => $is_removed_by_receiver]);
                                //$this->message_model->UpdataDatabase($reply_message_query);
                            }
                        } 

                        header("Location: ./index.php?site=messages&messageType=sent");
                    }
                }else{
                    header("Location: ./index.php?site=messages");
                }
            }else{
                header("Location: ./index.php");
            }
        }

        /**
         *
         * This method removes the selected messages temporarily.
         * 
         * Only those messages will be removed, which belong to the logged in user, and are not deleted yet.
         *  
         * @return void
        */
        public function DeleteMessages(){
            //Neptun code must be set in the session, otherwise we cannot move forward
            if(isset($_SESSION["neptun_code"])){
                // The ids of the messages, the user wish to remove
                $message_ids = array_keys($_POST);
                
                // Get the actual messages belonging to the user
                $merged_messages = $this->message_model->GetMessages($_SESSION["neptun_code"]);
                
                // Filter those messages which id is in the array containing the ids the user wish to remove
                $message_id_indexed = [];
                foreach($merged_messages as $message_counter => $message){
                    $message_id_indexed[$message["message_id"]] = $message;
                }
                
                // The ids of the messages belonging to the user
                $possible_message_ids = array_keys($message_id_indexed);
                $query_array = [];
                foreach($message_ids as $id_counter => $message_id){
                    if(    is_numeric($message_id) 
                        && intval($message_id) >= 1 
                        && in_array($message_id, $possible_message_ids)
                    ){
                        $belongs_to = $message_id_indexed[$message_id]["belongs_to"];
                        if($belongs_to == 0){
                            $belongs_to = $message_id;
                        }

                        foreach($merged_messages as $message_counter => $message){
                            // From the messages that belong to the user, remove the ones, which have their ids in the array containing the ids the user wish to remove
                            // Also, remove all of the messages which are in the same thread as this message
                            if($message["message_id"] == $belongs_to || $message["belongs_to"] == $belongs_to){
                                if($_SESSION["neptun_code"] == $message["neptun_code_from"]){ // Remove the message for the sender
                                    array_push($query_array,array("message_id" => $merged_messages[$message_counter]["message_id"], "is_removed_by_sender" => "1"));
                                }else{ // Remove the message for the receiver
                                    array_push($query_array,array("message_id" => $merged_messages[$message_counter]["message_id"], "is_removed_by_receiver" => "1")); 
                                }
                            }
                        }
                    }
                }

                $this->message_model->RemoveRecoverMessages($query_array, true);

                header("Location: ./index.php?site=messages");
            }else{
                header("Location: ./index.php");
            }
        }

        /**
         *
         * This method recovers the selected (temporarily deleted) messages.
         * 
         * Only those messages will be recovered, which belong to the logged in user, and are temporarily deleted.
         *  
         * @return void
        */
        public function RecoverDeletedMessages(){
            //Neptun code must be set in the session, otherwise we cannot move forward
            if(isset($_SESSION["neptun_code"])){
                // The ids of the messages, the user wish to recover
                $message_ids = array_keys($_POST);

                // Get the actual messages belonging to the user
                $merged_messages =  $this->message_model->GetMessages($_SESSION["neptun_code"]);

                // Filter those messages which id is in the array containing the ids the user wish to recover
                $message_id_indexed = [];
                foreach($merged_messages as $message_counter => $message){
                    $message_id_indexed[$message["message_id"]] = $message;
                }

                // The ids of the messages belonging to the user
                $possible_message_ids = array_keys($message_id_indexed);
                $query_array = [];
                foreach($message_ids as $id_counter => $message_id){
                    if(    is_numeric($message_id) 
                        && intval($message_id) >= 1 
                        && in_array($message_id, $possible_message_ids)
                    ){
                        $belongs_to = $message_id_indexed[$message_id]["belongs_to"];
                        if($belongs_to == 0){
                            $belongs_to = $message_id;
                        }
                        foreach($merged_messages as $message_counter => $message){
                            // From the messages that belong to the user, recover the ones, which have their ids in the array containing the ids the user wish to recover
                            // Also, recover all of the messages which are in the same thread as this message
                            if($message["message_id"] == $belongs_to || $message["belongs_to"] == $belongs_to){
                                if($_SESSION["neptun_code"] == $message["neptun_code_from"]){ // Recover the message for the sender
                                    array_push($query_array,array("message_id" => $merged_messages[$message_counter]["message_id"], "is_removed_by_sender" => "0"));
                                }else{ // Recover the message for the receiver
                                    array_push($query_array,array("message_id" => $merged_messages[$message_counter]["message_id"], "is_removed_by_receiver" => "0")); 
                                }
                            }
                        }
                    }
                }

                $this->message_model->RemoveRecoverMessages($query_array, false);
                
                header("Location: ./index.php?site=messages");
            }else{
                header("Location: ./index.php");
            }
        }

        /**
         * This private method returns the users associated with the logged in user. The user will be able to send message to these users.
         * 
         * The associated users are: the teachers, the administrator, and the approved students belonging to the same subject group as the user. 
         * If the user is a teacher, then the approved students from their subject group also will be associated with them.
         * 
         * @return array Returns an array containing neptun codes.
         */
        private function GetAssociteNeptunCodes(){
            // Get all of the neptun codes
            $all_neptun_codes_associated = $this->message_model->GetNeptunCodes($_SESSION["neptun_code"]);
            $neptun_codes = [];
            
            // The neptun codes of the administrators
            $administrators = $all_neptun_codes_associated[0];
            foreach($administrators as $counter => $administrator_neptun_code){
                array_push($neptun_codes, strtoupper(array_values($administrator_neptun_code)[0]));
            }

            // The neptun codes of the users, that has approved status, and belongs to the same group as the logged in user
            // If the user is a teacher, then the neptun codes of all of their approved students
            $accosiated = $all_neptun_codes_associated[1];
            foreach($accosiated as $counter => $accosiated_neptun_code){
                array_push($neptun_codes,array_values($accosiated_neptun_code)[0]);
            }

            // The neptun codes of the teachers
            $teachers = $all_neptun_codes_associated[2];
            foreach($teachers as $counter => $teacher_neptun_code){
                $teacher_neptun_code = array_values($teacher_neptun_code)[0];
                if(!in_array($teacher_neptun_code,$neptun_codes)){
                    array_push($neptun_codes,$teacher_neptun_code);   
                }
            }

            return $neptun_codes;
        }
    }

?>