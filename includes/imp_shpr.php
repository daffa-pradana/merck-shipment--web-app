<?php
    // Config
    require 'config.php';

    // Autofill
    if(isset($_POST['import_shipper'])){
      $impShprIn = addslashes($_POST['import_shipper']);
      $impShprArr = array();
      $impShprDoc = "";
      $impShprQ = "SELECT `shp_shpr` FROM `import` WHERE `shp_shpr` LIKE '%".$impShprIn."%'";
      $res = mysqli_query($conn, $impShprQ);
      $impShprDoc = "<ul class='autofill-list'>";
      if (mysqli_num_rows($res) > 0) {
        while($row = mysqli_fetch_array($res)){
          if(!in_array($row['shp_shpr'], $impShprArr)){
            array_push($impShprArr, $row['shp_shpr']);
          }
        }
        for ($i = 0; $i < count($impShprArr); $i++){
          $impShprDoc .= '<li id="imprShprVal">'.$impShprArr[$i].'</li>';
        }
      } else {
        $impShprDoc .= ' ';
      }
      $impShprDoc .= '</ul>';
      echo $impShprDoc;
    }
?>