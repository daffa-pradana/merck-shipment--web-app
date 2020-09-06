<?php
    
    function getUsersData($userId){
        require 'includes/config.php';
        $sql = $conn->query("SELECT * FROM `users` WHERE `user_id` = '$userId'");
        $data = $sql->fetch_array();
        if(!empty($data)){
            return $data;
        }
        return NULL;
    }

?>