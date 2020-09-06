<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
  if (!isset($_SESSION['state'])) {
    header('Location: index.php');
    exit();
  }
  // Get User Data
  $userState = $_SESSION['state'];
  if ($userState == 'user'){
    require 'auth/authorization.php';
    $userId = $_SESSION['user_id'];
    $userData = getUsersData($userId);
  }
  // Redirect functions
  include "redirect.php";
?>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>M - Shipment Report</title>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/png" href="img/favicon/m-logo.png">
    <!-- Stylesheet -->
    <link
      rel="stylesheet"
      type="text/css"
      href="css/main.css?v=<?php echo time(); ?>"
    />
    <?php if($page == "input"):?>
      <link
      rel="stylesheet"
      type="text/css"
      href="css/input.css?v=<?php echo time(); ?>"
      />
    <?php elseif($page == "reports"): ?>
      <link
      rel="stylesheet"
      type="text/css"
      href="css/reports.css?v=<?php echo time(); ?>"
      />
    <?php elseif($page == "graph"): ?>
      <link
      rel="stylesheet"
      type="text/css"
      href="css/graph.css?v=<?php echo time(); ?>"
      />
    <?php elseif($page == "users"): ?>
      <link
      rel="stylesheet"
      type="text/css"
      href="css/users.css?v=<?php echo time(); ?>"
      />
    <?php endif; ?>
    <script type="text/javascript" src="js/alert.js"></script>
    <script type="text/javascript" src="js/jquery-3.5.1.min.js"></script>
  </head>
  <body>
    <!-- Message Box -->
    <?php include 'alert.php'; ?>
    <div id="msg-box" class="layer-2 <?php echo $msg_type; ?>" style="display: <?php echo $msg_display;?>">
      <div id="msg-text">
        <span class="font-md"><?php echo $msg_text; ?></span>
      </div>
      <div id="msg-btn">
        <a class="font-md" href="?close_msg=none">X</a>
      </div>
    </div>
    <!-- Top Navbar -->
    <div id="top-nav" class="layer-1">
      <div id="user-label">
        <?php if($userState == 'user'):?>
          <span class="font-md"><?php echo $userData['user_name'];?></span>
          <p class="font-md"><?php echo $userData['user_auth'];?></p>
        <?php else:?>
          <span class="font-md">Welcome,</span>
          <p class="font-md">Readers!</p>
        <?php endif; ?>
      </div>
      <div id="logout">
        <a href="includes/logout.php?logout"><img src="img/icons/logout.svg" alt="" /></a>
      </div>
    </div>
    <!-- Side Navbar -->
    <div id="side-nav">
      <div id="logo-sm">
        <img src="img/logo-sm.svg" alt="logo-sm" />
      </div>
      <div id="side-menu">
        <!-- User Menu -->
        <?php if($userState == 'user'):?>
          <a href="input.php" class="<?php if($page == "input"){echo "side-active";}else{echo "side-btn";} ?>">
            <img src="img/icons/<?php if ($page == "input"){echo "input-active.svg";}else{echo "input-inactive.svg";} ?>" alt="" />
            <p class="font-md">Input</p>
          </a>
          <a href="reports.php" class="<?php if($page == "reports"){echo "side-active";}else{echo "side-btn";} ?>">
            <img src="img/icons/<?php if ($page == "reports"){echo "reports-active.svg";}else{echo "reports-inactive.svg";} ?>" alt="" />
            <p class="font-md">Reports</p>
          </a>
          <a href="graph.php" class="<?php if($page == "graph"){echo "side-active";}else{echo "side-btn";} ?>">
            <img src="img/icons/<?php if ($page == "graph"){echo "graph-active.svg";}else{echo "graph-inactive.svg";} ?>" alt="" />
            <p class="font-md">Graph</p>
          </a>
          <?php if($userData['user_auth'] == 'Supervisor'):?>
            <a href="users.php" class="<?php if($page == "users"){echo "side-active";}else{echo "side-btn";} ?>">
              <img src="img/icons/<?php if($page == "users"){echo "users-active.svg";}else{echo "users-inactive.svg";} ?>" alt="" />
              <p class="font-md">Users</p>
            </a>
          <?php endif;?>
        <!-- Viewer Menu -->
        <?php else:?>
          <a href="reports.php" class="<?php if($page == "reports"){echo "side-active";}else{echo "side-btn";} ?>">
            <img src="img/icons/<?php if ($page == "reports"){echo "reports-active.svg";}else{echo "reports-inactive.svg";} ?>" alt="" />
            <p class="font-md">Reports</p>
          </a>
          <a href="graph.php" class="<?php if($page == "graph"){echo "side-active";}else{echo "side-btn";} ?>">
            <img src="img/icons/<?php if ($page == "graph"){echo "graph-active.svg";}else{echo "graph-inactive.svg";} ?>" alt="" />
            <p class="font-md">Graph</p>
          </a>
        <?php endif;?>
      </div>
    </div>