<?php
// Functions To Convert Date Format

// -- Display Date Time From SQL DB
function convDateTimeSQL($dateIn){
    if ($dateIn != "0000-00-00 00:00:00"){
        list($date, $time) = explode(" ", $dateIn);
        list($y, $m, $d) = explode("-", $date);
        list($h, $i, $s) = explode(":", $time);
        $dateOut = $d."/".$m."/".$y." ".$h.":".$i;
    } else {
        $dateOut = "-";
    }
    return $dateOut;
}

// -- Display Date From SQL DB
function convDateSQL($dateIn){
    if ($dateIn != "0000-00-00"){
        list($y, $m, $d) = explode("-", $dateIn);
        $dateOut = $d."/".$m."/".$y;
    } else {
        $dateOut = "-";
    }
    return $dateOut;
}
?>