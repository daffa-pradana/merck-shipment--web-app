<?php
session_start();
    
  include 'includes/config.php';
  $msg = " ";
  // Login Logic
  if(isset($_POST['login'])){
    $userState = 'user';
    $_SESSION['state'] = $userState;
    $userId = $_POST['user_id'];
    $userPass = $_POST['user_pass'];

    $sql = $conn->query("SELECT * FROM `users` WHERE `user_id` = '$userId'");
    if ($sql->num_rows > 0){
      $data = $sql->fetch_array();
      if (password_verify($userPass, $data['user_pass']) && $data['user_stat'] == 'active'){
        $_SESSION['user_id'] = $data['user_id'];
        header("location: input.php");
      } elseif (password_verify($userPass, $data['user_pass']) && $data['user_stat'] == 'inactive') {
        $msg = "Sorry, your account has been deactivated";
      } else {
        $msg = "Sorry, wrong password";
      }
    } else {
      $msg = "Sorry, that ID is invalid.";
    }
  }
  // View Logic
  if(isset($_POST['view'])){
    $userState = 'viewer';
    $_SESSION['state'] = $userState;
    header("location: reports.php");
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>M - Shipment Report</title>
    <!--Favicon-->
    <link rel="shortcut icon" type="image/png" href="img/favicon/m-logo.png">
    <!-- Stylesheet -->
    <link
      rel="stylesheet"
      type="text/css"
      href="css/index.css?v=<?php echo time(); ?>"
    />
    <link
      rel="stylesheet"
      type="text/css"
      href="css/main.css?v=<?php echo time(); ?>"
    />
  </head>
  <body>
    <div id="container">
      <div id="main">
        <div id="box-main" class="layer-1">
          <div id="box-1">
            <img id="logo" src="img/logo-bg.svg" alt="logo" />
            <h1 id="logo-label" class="font-md">SHIPMENT REPORT</h1>
          </div>
          <div id="box-2">
            <h1 id="label-1" class="font-md">Welcome !</h1>
            <p id="caption-1" class="font-sm">
              Login to input and modify data, and click view to read, summarize
              and export data.
            </p>
            <form method="post" autocomplete="off">
              <div id="login-form">
                <div id="user-field">
                  <img src="img/icons/user.svg" alt="" />
                  <input
                    id="userId"
                    name="user_id"
                    type="text"
                    placeholder="ID"
                    class="font-sm"
                  />
                </div>
                <div id="pass-field">
                  <img src="img/icons/lock.svg" alt="" />
                  <input
                    id="userPass"
                    name="user_pass"
                    type="password"
                    placeholder="Password"
                    class="font-sm"
                  />
                </div>
                <div id="log-msg" class="font-sm"><?php echo $msg;?></div>
                <button
                  id="login"
                  type="submit"
                  name="login"
                  value="submit"
                  class="cyan-btn layer-2"
                >
                  Login
                </button>
                <button id="view" type="submit" name="view" class="white-btn layer-2">View</button>
              </div>
            </form>
          </div>
        </div>
        <div id="box-release">
          <span class="font-sm">Ver 1.0.2</span>
        </div>
      </div>
    </div>
  </body>
</html>
