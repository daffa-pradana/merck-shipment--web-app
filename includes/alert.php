<?php
  // Message box
  $msg_type = $_SESSION['msg_type'] ?? "";
  $msg_display = $_SESSION['msg_display'] ?? "none";
  $msg_text = $_SESSION['msg_text'] ?? "";

  // Call message box
  function call_msg($type, $text) {
    // Message box display
    $_SESSION['msg_display'] = 'block';
    // Message type
    if ($type == "success"){
        $_SESSION['msg_type'] = "suc-msg";
        $_SESSION['msg_text'] = "Success: ".$text;
    } else if ($type == "warning"){
        $_SESSION['msg_type'] = "war-msg";
        $_SESSION['msg_text'] = "Warning: ".$text;
    } else {
        $_SESSION['msg_type'] = "err-msg";
        $_SESSION['msg_text'] = "Error: ".$text;
    }
  }
  // Close message box
  function close_msg($display){
    return $display;
  }

  // Calling close function
  if (isset($_GET['close_msg'])){
      $_SESSION['msg_display'] = close_msg($_GET['close_msg']);
      // Redirect
      red_current();
  }
?>