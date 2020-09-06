<?php
    // Config
    require 'config.php';

    // Autofill
    if(isset($_POST['export_forwarder'])){
    $expFwdrIn = addslashes($_POST['export_forwarder']);
    $expFwdrArr = array();
    $expFwdrDoc = "";
    $expFwdrQ = "SELECT `shp_fwdr` FROM `export` WHERE `shp_fwdr` LIKE '%".$expFwdrIn."%'";
    $res = mysqli_query($conn, $expFwdrQ);
    $expFwdrDoc = "<ul class='autofill-list'>";
    if (mysqli_num_rows($res) > 0) {
        while($row = mysqli_fetch_array($res)){
        if(!in_array($row['shp_fwdr'], $expFwdrArr)){
            array_push($expFwdrArr, $row['shp_fwdr']);
        }
        }
        for ($i = 0; $i < count($expFwdrArr); $i++){
        $expFwdrDoc .= '<li id="expFwdrVal">'.$expFwdrArr[$i].'</li>';
        }
    } else {
        $expFwdrDoc .= ' ';
    }
    $expFwdrDoc .= '</ul>';
    echo $expFwdrDoc;
    }
?>