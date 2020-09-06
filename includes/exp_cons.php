<?php
    // Config
    require 'config.php';

    // Autofill
    if(isset($_POST['export_consignee'])){
      $expConsIn = addslashes($_POST['export_consignee']);
      $expConsArr = array();
      $expConsDoc = "";
      $expConsQ = "SELECT `shp_cons` FROM `export` WHERE `shp_cons` LIKE '%".$expConsIn."%'";
      $res = mysqli_query($conn, $expConsQ);
      $expConsDoc = "<ul class='autofill-list'>";
      if (mysqli_num_rows($res) > 0) {
        while($row = mysqli_fetch_array($res)){
          if(!in_array($row['shp_cons'], $expConsArr)){
            array_push($expConsArr, $row['shp_cons']);
          }
        }
        for ($i = 0; $i < count($expConsArr); $i++){
          $expConsDoc .= '<li id="expConsVal">'.$expConsArr[$i].'</li>';
        }
      } else {
        $expConsDoc .= ' ';
      }
      $expConsDoc .= '</ul>';
      echo $expConsDoc;
    }
?>