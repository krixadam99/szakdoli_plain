<?php
    /**
     * This is a controller class which is responsible for showing the messages' page.
     * 
     * This controller extends the MainContentController, from which it inherits members that are related to a logged in user.
     * If someone navigates to the navigations page, although they are not logged in, then this controller redirects them to the login page.
     * On this page, messages (sent, incame and deleted) are displayed.
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
            $this->errors = [];
            $this->correct_parameters = [];
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
            if(isset($_SESSION["neptun_code"])){
                $this->SetMembers();
                
                if(isset($_SESSION["write_message"])){
                    unset($_SESSION["write_message"]);
                }

                if(isset($_SESSION["message_id"])){
                    $this->message_model->UpdataDatabase("UPDATE messages SET is_seen_by_receiver = \"1\" WHERE neptun_code_to = \"" . $_SESSION["neptun_code"] . "\" AND message_id = \""  . $_SESSION["message_id"] . "\"");
                }

                $sent_messages = $this->message_model->GetSentMessages($_SESSION["neptun_code"]);
                $incame_messages = $this->message_model->GetRecievedMessages($_SESSION["neptun_code"]);
                $removed_messages = $this->message_model->GetRemovedMessages($_SESSION["neptun_code"]);

                include(ROOT_DIRECTORY . "/views/messagesPage.view.php");
            }else{
                header("Location: ./index.php?site=login");
            }
        }

        /**
         *
         * This method shows the page for writing a message (basically the messages' page with ).
         * 
         * It also sets the members, which it inherited from the MainContentController, and are related to a logged in user.
         * If a client types the page name in the searchbar of the browser, but not logged in, then they will be redirected to the login page.
         *  
         * @return void
        */
        public function WriteMessage(){
            if(isset($_SESSION["neptun_code"])){
                $this->SetMembers();
                
                $_SESSION["write_message"] = true;
                $neptun_codes = $this->GetAssocitedNeptunCodes();
                
                include(ROOT_DIRECTORY . "/views/messagesPage.view.php");
            }else{
                header("Location: ./index.php?site=login");
            }
        }

        /**
         *
         * This method updates the messages table by a new message.
         * 
         * It also sets the members, which it inherited from the MainContentController, and are related to a logged in user.
         * If a client types the page name in the searchbar of the browser, but not logged in, then they will be redirected to the login page.
         *  
         * @return void
        */
        public function SendNewMessage(){
            //Neptun code must be set in the session, otherwise we cannot move forward
            if(isset($_SESSION["neptun_code"])){
                $neptun_codes = $this->GetAssocitedNeptunCodes();
                $success_parameters = [];

                $error_parameters = $this->ValidateInputs(
                    [
                        $_POST["message_to"]??-1 => [
                            "in_array" => $neptun_codes
                        ],
                        $_POST["message_topic"]??-2 => [
                            "not_placeholder" => ["","Üzenet témája..."],
                            "length" => ["<=","255"]
                        ],
                        $_POST["message_text"]??-3 => [
                            "not_placeholder" => ["","Üzenet szövege..."],
                            "length" => ["<=","2024"]
                        ]
                    ]
                );
                
                if(count($error_parameters) !== 0){
                    $_SESSION["error_parameters"] = $error_parameters;
                    $_SESSION["correct_parameters"] = $success_parameters;
                    header("Location: ./index.php?site=writeMessage");
                }else{
                    $new_message_query = "INSERT INTO messages(neptun_code_from, neptun_code_to, message_topic, message_text) VALUES(
                        \"" . $_SESSION["neptun_code"] . "\", 
                        \"" . $_POST["message_to"] . "\", 
                        \"" . $_POST["message_topic"] . "\", 
                        \"" . $_POST["message_text"] . "\"
                    )";

                    var_dump($new_message_query);

                    $this->message_model->UpdataDatabase($new_message_query);

                    header("Location: ./index.php?site=messages");
                }
            }else{
                header("Location: ./index.php");
            }
        }

        /**
         *
         * This method updates the messages table by a new message. This will be a reply message to a previous message
         *  
         * @return void
        */
        public function ReplyToMessage(){
            //Neptun code must be set in the session, otherwise we cannot move forward
            if(isset($_SESSION["neptun_code"])){
                if(isset($_SESSION["message_id"]) && $_SESSION["thread_count_new"] && $_SESSION["neptun_code_to"]){
                    $success_parameters = [];
    
                    $error_parameters = $this->ValidateInputs(
                        [
                            $_POST["message_topic"]??-2 => [
                                "not_placeholder" => ["","Üzenet témája..."],
                                "length" => ["<=","255"]
                            ],
                            $_POST["message_text"]??-3 => [
                                "not_placeholder" => ["","Üzenet szövege..."],
                                "length" => ["<=","2024"]
                            ]
                        ]
                    );
                    
                    if(count($error_parameters) !== 0){
                        $_SESSION["error_parameters"] = $error_parameters;
                        $_SESSION["correct_parameters"] = $success_parameters;
                        header("Location: ./index.php?site=messages&messageId=" . $_SESSION["message_id"]);
                    }else{
                        $reply_message_query = "INSERT INTO messages(neptun_code_from, neptun_code_to, belongs_to, message_topic, message_text, thread_count) VALUES(
                            \"" . $_SESSION["neptun_code"] . "\", 
                            \"" . $_SESSION["neptun_code_to"] . "\", 
                            \"" . $_SESSION["message_id"] . "\", 
                            \"" . $_POST["message_topic"] . "\",
                            \"" . $_POST["message_text"] . "\",
                            \"" . $_SESSION["thread_count_new"] . "\"
                        )";
    
                        $this->message_model->UpdataDatabase($reply_message_query);
    
                        header("Location: ./index.php?site=messages");
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
         * This method removes the selected messages.
         *  
         * @return void
        */
        public function DeleteMessages(){
            //Neptun code must be set in the session, otherwise we cannot move forward
            if(isset($_SESSION["neptun_code"])){
                $message_ids = array_keys($_POST);
                
                $merged_messages = $this->message_model->GetMessages($_SESSION["neptun_code"]);
                $message_id_indexed = [];
                foreach($merged_messages as $message_counter => $message){
                    $message_id_indexed[$message["message_id"]] = $message;
                }
                
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
                            if($message["message_id"] == $belongs_to || $message["belongs_to"] == $belongs_to){
                                if($_SESSION["neptun_code"] == $message["neptun_code_from"]){
                                    array_push($query_array,array("message_id" => $merged_messages[$message_counter]["message_id"], "is_removed_by_sender" => "1"));
                                }else{
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
         * This method eihter removes the selected messages permanently, or recovers them.
         *  
         * @return void
        */
        public function RecoverDeleteddMessages(){
            //Neptun code must be set in the session, otherwise we cannot move forward
            if(isset($_SESSION["neptun_code"])){
                $message_ids = array_keys($_POST);

                $merged_messages =  $this->message_model->GetMessages($_SESSION["neptun_code"]);
                $message_id_indexed = [];

                foreach($merged_messages as $message_counter => $message){
                    $message_id_indexed[$message["message_id"]] = $message;
                }

                
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
                            if($message["message_id"] == $belongs_to || $message["belongs_to"] == $belongs_to){
                                if($_SESSION["neptun_code"] == $message["neptun_code_from"]){
                                    array_push($query_array,array("message_id" => $merged_messages[$message_counter]["message_id"], "is_removed_by_sender" => "0"));
                                }else{
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
         * 
         */
        private function GetAssocitedNeptunCodes(){
            $all_neptun_codes_associated = $this->message_model->GetNeptunCodes($_SESSION["neptun_code"]);
            $neptun_codes = ["ADMIN"];

            $accosiated = $all_neptun_codes_associated[0];
            foreach($accosiated as $counter => $accosiated_neptun_code){
                array_push($neptun_codes,array_values($accosiated_neptun_code)[0]);
            }

            $teachers = $all_neptun_codes_associated[1];
            foreach($teachers as $counter => $teacher_neptun_code){
                $teacher_neptun_code = array_values($teacher_neptun_code)[0];
                if(!in_array($teacher_neptun_code,$neptun_codes)){
                    array_push($neptun_codes,$teacher_neptun_code);   
                }
            }

            return $neptun_codes;
        }

        private function ValidateInputs($validation_array){
            $errors = [];
            
            $input_counter = 1;
            foreach($validation_array as $input => $validation_rules){
                if(is_string($input)){
                    foreach($validation_rules as $attribute => $condition){
                        switch($attribute){
                            case "length":{
                                $left_side = strlen($input);
                                $relation = $condition[0]??">";
                                $right_side = $condition[1]??0;
                                if(is_numeric($right_side)){
                                    $right_side = intval($right_side);
                                }else{
                                    $right_side = 0;
                                }
                                
                                switch($relation){
                                    case ">":{
                                        if($left_side <= $right_side){
                                            array_push($errors, "wrong_$input_counter" . "_too_short");
                                        }
                                    };break;
                                    case "<":{
                                        if($left_side >= $right_side){
                                            array_push($errors, "wrong_$input_counter" . "_too_long");
                                        }
                                    };break;
                                    case ">=":{
                                        if($left_side < $right_side){
                                            array_push($errors, "wrong_$input_counter" . "_too_short");
                                        }
                                    };break;
                                    case "<=":{
                                        if($left_side > $right_side){
                                            array_push($errors, "wrong_$input_counter" . "_too_long");
                                        }
                                    };break;
                                    case "==":{
                                        if($left_side != $right_side){
                                            array_push($errors, "wrong_$input_counter" . "_not_equal");
                                        }
                                    };break;
                                    case "!=":{
                                        if($left_side == $right_side){
                                            array_push($errors, "wrong_$input_counter" . "_equal");
                                        }
                                    };break;
                                    default:break;
                                }
                            };break;
                            case "not_placeholder":{
                                $left_side = $input;
                                $place_holder = $condition;

                                if(is_string($place_holder)){
                                    if($left_side === $place_holder){
                                        array_push($errors, "wrong_$input_counter" . "_not_set");
                                    }
                                }elseif(is_array($place_holder)){
                                    if(in_array($left_side, $place_holder)){
                                        array_push($errors, "wrong_$input_counter" . "_not_set");
                                    }
                                }
                            };break;
                            case "in_array":{
                                $left_side = $input;
                                $array = $condition;
    
                                if(is_array($array)){
                                    if(!in_array($left_side, $array)){
                                        array_push($errors, "wrong_$input_counter" . "_not_in_array");
                                    }
                                }
                            };break;
                        }
                    }
                }else{
                    array_push($errors, "wrong_$input_counter" . "_not_found");
                }
        
                $input_counter += 1;
            }

            return $errors;
        }
    }

?>