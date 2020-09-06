<?php
    // Config
    require 'config.php';

    // Autofill
    if(isset($_POST['import_forwarder'])){
      $impFwdrIn = addslashes($_POST['import_forwarder']);
      $impFwdrArr = array();
      $impFwdrDoc = "";
      $impFwdrQ = "SELECT `shp_fwdr` FROM `import` WHERE `shp_fwdr` LIKE '%".$impFwdrIn."%'";
      $res = mysqli_query($conn, $impFwdrQ);
      $impFwdrDoc = "<ul class='autofill-list'>";
      if (mysqli_num_rows($res) > 0) {
        while($row = mysqli_fetch_array($res)){
          if(!in_array($row['shp_fwdr'], $impFwdrArr)){
            array_push($impFwdrArr, $row['shp_fwdr']);
          }
        }
        for ($i = 0; $i < count($impFwdrArr); $i++){
          $impFwdrDoc .= '<li id="imprFwdrVal">'.$impFwdrArr[$i].'</li>';
        }
      } else {
        $impFwdrDoc .= ' ';
      }
      $impFwdrDoc .= '</ul>';
      echo $impFwdrDoc;
    }
?>