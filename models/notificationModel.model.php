<?php
    /**
     * This is a model class which is responsible for requesting data for the notifications page.
     * 
     * This model extends the MainModel class.
     * Here only the basic data should be requested from the database for the logged in user, so this model calls the MainModel's contructor.
     * Data request will be performed by the methods which were inherited from the MainModel.
    */
    class NotificationModel extends MainModel{
        public function __construct($database = ""){
            parent::__construct($database);
        }
    }

?>