<?php
    // Config
    require 'config.php';

    // Default Value
    $formState = "Add";
    $alertAdd = $_SESSION['alert'] ?? "";
    $srcName = "";
    $getNo = "";
    $getName = "";
    $getPass = "";
    $getStat = "";
    $getTime = "";
    $getMuid = "";
    $getAuth = "";
    
    // Changing State
    if (isset($_GET["change-state"])){
        $formState = $_GET["change-state"];
    }

    // Add New User
    if (isset($_POST["Add"])) {
        $crtName = $_POST["username"];
        $crtStat = $_POST["status"];
        $crtPass = $_POST["password"];
        $crtMuid = $_POST["muid"];
        $crtAuth = $_POST["authorization"];
        $crtHashPass = password_hash($crtPass,PASSWORD_BCRYPT);
        $crtTime = date("Y-m-d");
        $check = $conn->query("SELECT `user_name`, `user_id` FROM `users` WHERE `user_name` = '$crtName' OR `user_id` = '$crtMuid'");
        if ($check->num_rows > 0 ){
            $_SESSION['alert'] = "Sorry, that username or id is taken";
        } else {
            $sql = $conn->query("INSERT INTO `users` 
            (`user_id`, 
            `user_name`, 
            `user_pass`, 
            `user_auth`, 
            `user_stat`,
            `user_time`)
            VALUES
            ('$crtMuid',
            '$crtName',
            '$crtHashPass',
            '$crtAuth',
            '$crtStat',
            '$crtTime')");
            unset($_SESSION['alert']);
            if (!$sql) {
                // Message
                call_msg("error", "Create user failed, something's not right.");
            } else {
                // Message
                call_msg("success", "New user created successfully!");
            }
        }
        // Redirect
        red_users();
    }

    // Get User Data
    if (isset($_GET["edit"])) {
        $getNo = $_GET["edit"];
        $formState = "Edit";
        $sql = $conn->query("SELECT * FROM `users` WHERE `user_no` = $getNo");
        if ($sql->num_rows > 0) {
            $row = $sql->fetch_array();
            $getName = $row['user_name'];
            $getPass = $row['user_name'];
            $getStat = $row['user_stat'];
            $getTime = $row['user_time'];
            $getMuid = $row['user_id'];
            $getAuth = $row['user_auth'];
        }
    }

    // Edit User Data
    if (isset($_POST["Edit"])) {
        $editNo = $_POST['number'];
        $editName = $_POST['username'];
        $editStat = $_POST['status'];
        $editPass = $_POST['password'];
        $editMuid = $_POST['muid'];
        $editAuth = $_POST['authorization'];
        if ($editPass != "") {
            $editHashPass = password_hash($editPass, PASSWORD_BCRYPT);
            $sql = $conn->query("UPDATE `users` 
            SET 
            `user_id` = '$editMuid',
            `user_name` = '$editName',
            `user_pass` = '$editPass',
            `user_auth` = '$editAuth',
            `user_stat` = '$editStat'
            WHERE
            `user_no` = $editNo
            ");
            if (!$sql) {
                // Message
                call_msg("error", "Update user failed, something's not right.");
            } else {
                // Message
                call_msg("success", "User updated successfully!");
            }
        } else {
            $sql = $conn->query("UPDATE `users` 
            SET 
            `user_id` = '$editMuid',
            `user_name` = '$editName',
            `user_auth` = '$editAuth',
            `user_stat` = '$editStat'
            WHERE
            `user_no` = $editNo
            ");
            if (!$sql) {
                // Message
                call_msg("error", "Update user failed, something's not right.");
            } else {
                // Message
                call_msg("success", "User updated successfully!");
            }
        }
        // Redirect
        red_users();  
    }

    // Delete User Data
    if (isset($_GET["delete"])) {
        $deleteNo = $_GET["delete"];
        $sql = $conn->query("DELETE FROM `users` WHERE `user_no` = $deleteNo");
        if (!$sql) {
            // Message
            call_msg("error", "Delete user failed, something's not right.");
        } else {
            // Message
            call_msg("success", "User deleted successfully!");
        }
        // Redirect
        red_users();
    }
?>