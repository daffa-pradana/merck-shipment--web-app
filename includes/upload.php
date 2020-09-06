<?php
require 'config.php'; // Config

if (isset($_POST['submit-upload'])){
    // Rep No
    $repNo = $_POST['rep_no'];
    // File state
    $fileSector = $_POST['file_sector'];
    // HAWB
    $fileHawb = $_POST['file_hawb'];
    // Aju No
    $fileAju = $_POST['file_aju'];
    // User info
    $userName = $_POST['user_name'];
    // File Info
    $file = $_FILES['upload-file'];
    $fileName = $_FILES['upload-file']['name'];
    $fileTmpName = $_FILES['upload-file']['tmp_name'];
    $fileSize = $_FILES['upload-file']['size'];
    $fileError = $_FILES['upload-file']['error'];
    $fileType = $_FILES['upload-file']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $loc = "input.php?select-".$fileSector."=".$repNo;
    $allowed = array('jpg', 'jpeg', 'png', 'pdf', 'xlsx', 'xlsm', 'xls', 'docx', 'zip');
    if (in_array($fileActualExt,$allowed)){
        if ($fileError === 0) {
            if ($fileSize < 8000000) {
                $fileDestination = 'uploads/'.$fileName;
                move_uploaded_file($fileTmpName, $fileDestination);
                $sql = $conn->query("INSERT into `files`(`rep_no`,`file_sector`,`file_hawb`,`file_aju`,`file_by`,`file_name`) VALUES ('$repNo','$fileSector','$fileHawb','$fileAju','$userName','$fileName')");
                // Message
                call_msg("success", "File attached successfully");
                // Redirect
                red_custom($loc);
                // header($loc);
            } else {
                // Message
                call_msg("warning", "You cannot attach file more than 8 MB");
                // Redirect
                red_custom($loc);
                // header($loc);
            }
        } else {
            // Message
            call_msg("error", "Attach file failed, something\'s not right");
            // Redirect
            red_custom($loc);
            // header($loc);
        }
    } else {
        // Message
        call_msg("warning", "You can\'t attach a file with that format");
        // Redirect
        red_custom($loc);
    }
}
?>