<?php $page = "users"; //Set page ?>
<?php include 'includes/header.php'; //Header?>
<?php include 'includes/config.php'; //Config ?>
<?php include 'includes/users-action.php'; //Action ?>
<!-- Script -->
<script type="text/javascript" src="js/users-action.js"></script>
<!-- Container -->
<div id="container">
  <div id="main">
    <!-- Content -->
    <div id="content">
      <!-- Box 1 -->
      <div id="box1" class="container-box layer-1">
        <div id="header">
          <h5 class="font-md header-left">Users</h5>
        </div>
        <div id="sub-content">
          <div id="custom-search" class="custom-search left-item">
            <form action="users.php" method="get" autocomplete="off">
              <input
                id="search-field"
                class="custom-input font-sm"
                name="src-name"
                type="text"
                placeholder="Enter username.."
              />
              <button id="search-btn" class="right-item" type="submit" name="search">
                <img src="img/icons/search.svg" alt="" />
              </button>
            </form>
          </div>
          <a href="users.php?change-state=Add" id="add-user" class="custom-link font-md left-item">
            <img src="img/icons/plus.svg" alt="" />
            <span>Add new user</span>
          </a>
        </div>
        <div id="custom-table-1" class="left-item font-sm">
          <table class="custom-table">
            <tr>
              <th id="tb1-col1">Username</th>
              <th id="tb1-col2">Authorization</th>
              <th id="tb1-col3"></th>
              <th id="tb1-col4"></th>
            </tr>
            <!-- Users Records Iteration-->
            <?php
              if(isset($_GET['search'])){
                $srcName = $_GET['src-name'];
                $result = $conn->query("SELECT * FROM `users` WHERE `user_name` LIKE '%$srcName%'");
              } else {
                $result = $conn->query("SELECT * FROM `users`");
              }
            ?>
            <?php while ($user = $result->fetch_assoc()): ?>  
              <tr>
                <td id="tb1-col1"><?php echo $user["user_name"]; ?></td>
                <td id="tb1-col2"><?php echo $user["user_auth"]; ?></td>
                <td id="tb1-col3">
                  <div class="<?php echo $user["user_stat"]; ?>">
                    <span><?php echo $user["user_stat"]; ?></span>
                  </div>
                </td>
                <td id="tb1-col4">
                  <a href="users.php?edit=<?php echo $user["user_no"];?>" class='edit-btn'>
                    <img src="img/icons/pencil-hover.svg">
                  </a>
                  <?php if($user['user_auth'] != 'Supervisor'):?>
                  <a href="users.php?delete=<?php echo $user["user_no"];?>" class="cross-btn">
                    <img src="img/icons/cross.svg">
                  </a>
                  <?php endif;?>
                </td>
              </tr>
            <?php endwhile; ?>
            <!-- Iterations Ends Here -->
          </table>
        </div>
      </div>
      <!-- Box 2 -->
      <div id="box2" class="container-box layer-1">
        <div id="header">
          <h5 class="font-md header-left">User Settings</h5>
        </div>
        <div id="sub-content">
          <form class="user-settings" action="users.php" method="post" autocomplete="off">
            <div class="custom-field font-md">
              <span class="field-label">Username</span>
              <div class="field">
                <input name="number" value="<?php echo $getNo;?>" type="text" style="display: none;">
                <input name="username" value="<?php echo $getName;?>" placeholder="Username" class="font-sm" type="text" />
              </div>
            </div>
            <div class="custom-field font-md">
              <span class="field-label">Status</span>
              <div class="field">
                <select name="status" id="" class="font-sm">
                  <?php 
                    // Checking Supervisor availability
                    $sql = $conn->query("SELECT * FROM `users` WHERE `user_auth` = 'Supervisor'");
                    if($sql->num_rows < 2){
                      $mod_sup = "unavailable";
                    } else {
                      $mod_sup = "available";
                    }
                  ?>
                  <option value="active" <?php if($getStat == "active"){echo "selected";} ?> >Active</option>
                  <?php if(($getAuth == "Supervisor" && $mod_sup == "available") || ($getAuth != "Supervisor")):?>
                    <option value="inactive" <?php if($getStat == "inactive"){echo "selected";} ?> >Inactive</option>
                  <?php endif;?>
                </select>
              </div>
            </div>
            <?php if($formState != 'Add'):?>
            <div class="custom-field font-md">
              <span class="field-label">Created on</span>
              <div class="field">
                <input class="font-sm" value="<?php echo $getTime;?>" type="text" disabled="disabled"/>
              </div>
            </div>
            <?php endif;?>
            <div class="custom-field font-md">
              <span class="field-label">MuId</span>
              <div class="field">
                <input name="muid" placeholder="Merck user ID" value="<?php echo $getMuid;?>" class="font-sm" type="text" />
              </div>
            </div>
            <div class="custom-field font-md">
              <span class="field-label">Authorization</span>
              <div class="field">
                <select name="authorization" id="" class="font-sm">
                  <?php
                    // Checking Supervisor availability
                    $sql = $conn->query("SELECT * FROM `users` WHERE `user_auth` = 'Supervisor'");
                    if($sql->num_rows < 2){
                      $mod_sup = "unavailable";
                    } else {
                      $mod_sup = "available";
                    }
                  ?>
                  <?php if($getAuth == "Supervisor" && $mod_sup == "available"):?>
                    <option value="Supervisor" selected>Supervisor</option>
                    <option value="Staff">Staff</option>
                    <option value="(3rd)Schenker">(3rd)Schenker</option>
                    <option value="(3rd)Speedmark">(3rd)Speedmark</option>
                  <?php elseif($getAuth == "Supervisor" && $mod_sup == "unavailable"):?>
                    <option value="Supervisor" <?php if($getAuth == "Supervisor"){echo "selected";} ?> >Supervisor</option>
                  <?php else:?>
                    <option value="Supervisor" <?php if($getAuth == "Supervisor"){echo "selected";} ?> >Supervisor</option>
                    <option value="Staff" <?php if($getAuth == "Staff"){echo "selected";} ?> >Staff</option>
                    <option value="(3rd)Schenker" <?php if($getAuth == "(3rd)Schenker"){echo "selected";} ?> >(3rd)Schenker</option>
                    <option value="(3rd)Speedmark" <?php if($getAuth == "(3rd)Speedmark"){echo "selected";} ?> >(3rd)Speedmark</option>
                  <?php endif;?>
                </select>
              </div>
            </div>
            <?php if($formState == "Edit"):?>
              <div id="update-pass" class="custom-field font-md" style="display: none;">
                <span class="field-label">Password</span>
                <div class="field">
                  <input name="password" placeholder="Enter new password" class="font-sm" type="text" />
                </div>
              </div>
            <?php else:?>
              <div class="custom-field font-md">
                <span class="field-label">Password</span>
                <div class="field">
                  <input name="password" placeholder="Enter password" class="font-sm" type="text" />
                </div>
              </div>
            <?php endif;?>
            <button
              name="<?php echo $formState; ?>"
              id="update-btn"
              type="submit"
              class="cyan-btn font-md right-item layer-2"
            >
              <?php echo $formState; ?> Profile
            </button>
            <?php if ($formState == "Edit"):?>
              <a id="show-pass" href="javascript:showPass()" class="custom-link font-md"><span>Change Password</span></a>
            <?php endif;?>
            <p id="alert-add" class="alert font-sm"><?php echo $alertAdd; ?></p>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include 'includes/footer.php'; //Footer?>
