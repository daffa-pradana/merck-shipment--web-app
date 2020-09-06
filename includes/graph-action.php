<?php
// Config
require 'config.php';

// Default result
$result = "";
$result1 = "";
$result2 = "";

// Default Preferences
$agent = $_GET['select-agent'] ?? '';
$sector = $_GET['select-sector'] ?? '';
$year = $_GET['select-year'] ?? '';
$graph = $_GET['select-graph'] ?? '';
$agent = $_GET['select-agent'] ?? '';

// Generating graph
if(isset($_GET['set-graph']) && $_GET['select-agent'] != "Schenker & Speedmark"){
    // Get Value
    $result = array();
    // Choosen graph logic
    switch ($graph) {
        // % Delivery LT
        case "per_dlv_lt":
            // Check Parameter
            if($_GET['parameter'] != 0){
              $param = $_GET['parameter']; // Set Parameter
              // Month iteration
                for ($i = 1; $i <= 12; $i++){
                    // Month formatting
                    $month = sprintf("%02d", $i);
                    // All query
                    $q_all = "SELECT `rls_dlv_lt` FROM `import` WHERE (YEAR(`shp_eta`) = '$year') 
                                AND (MONTH(`shp_eta`) = '$month')
                                AND (`chrg_rmrk` = '$sector')
                                AND (`cstm_brkr` = '$agent')";
                    $q_all_res = $conn->query($q_all);
                    $q_all_sum = mysqli_num_rows($q_all_res);
                    // Pref query
                    $q_pre = "SELECT `rls_dlv_lt` FROM `import` WHERE (YEAR(`shp_eta`) = '$year')
                                AND (MONTH(`shp_eta`) = '$month')
                                AND (`rls_dlv_lt` != 0)
                                AND (`rls_dlv_lt` <= $param)
                                AND (`chrg_rmrk` = '$sector')
                                AND (`cstm_brkr` = '$agent')";
                    $q_pre_res = $conn->query($q_pre);
                    $q_pre_sum = mysqli_num_rows($q_pre_res);
                    // Precentage
                    if ($q_all_sum > 0){
                        $q_res = round((($q_pre_sum * 100) / $q_all_sum), 2);
                    } else {
                        $q_res = 0;
                    }
                    // Push into result array
                    array_push($result, $q_res);
                }
            } else {
                // Message
                call_msg("warning", "Please fill out the parameter field.");
                // Redirect
                red_graph();
            }
            break;
        // % Clearence LT
        case "per_clr_lt":
            // Check parameter
            if ($_GET['parameter'] != 0){
                $param = $_GET['parameter'];
                // Month iteration
                for ($i = 1; $i <= 12; $i++){
                    // Month formatting
                    $month = sprintf("%02d", $i);
                    // All query
                    $q_all = "SELECT `rls_clr_lt` FROM `import` WHERE (YEAR(`shp_eta`) = '$year') 
                                AND (MONTH(`shp_eta`) = '$month')
                                AND (`chrg_rmrk` = '$sector')
                                AND (`cstm_brkr` = '$agent')";
                    $q_all_res = $conn->query($q_all);
                    $q_all_sum = mysqli_num_rows($q_all_res);
                    // Pref query
                    $q_pre = "SELECT `rls_clr_lt` FROM `import` WHERE (YEAR(`shp_eta`) = '$year')
                                AND (MONTH(`shp_eta`) = '$month')
                                AND (`rls_clr_lt` != 0)
                                AND (`rls_clr_lt` <= $param)
                                AND (`chrg_rmrk` = '$sector')
                                AND (`cstm_brkr` = '$agent')";
                    $q_pre_res = $conn->query($q_pre);
                    $q_pre_sum = mysqli_num_rows($q_pre_res);
                    // Precentage
                    if ($q_all_sum > 0){
                        $q_res = round((($q_pre_sum * 100) / $q_all_sum), 2);
                    } else {
                        $q_res = 0;
                    }
                    // Push into result array
                    array_push($result, $q_res);
                }
            } else {
                // Message
                call_msg("warning", "Please fill out the parameter field.");
                // Redirect
                red_graph();
            }
            break;
        // Avg. Delivery LT
        case "avg_dlv_lt":
            // Month iteration
            for ($i = 1; $i <= 12; $i++){
                // Month formatting
                $month = sprintf("%02d", $i);
                // Average query
                $q = "SELECT AVG(`rls_dlv_lt`) AS `avg_dlv_lt` FROM `import` WHERE (YEAR(`shp_eta`) = '$year')
                        AND (MONTH(`shp_eta`) = '$month')
                        AND (`chrg_rmrk` = '$sector')
                        AND (`cstm_brkr` = '$agent')";
                $q_avg = $conn->query($q);
                $avg = $q_avg->fetch_assoc();
                // Rounding
                $round_avg = round($avg['avg_dlv_lt'], 2);
                // Push into result array
                array_push($result, $round_avg);
            }
            break;
        // Avg. Clearence LT
        case "avg_clr_lt":
            // Month iteration
            for ($i = 1; $i <= 12; $i++){
                // Month formatting
                $month = sprintf("%02d", $i);
                // Average query
                $q = "SELECT AVG(`rls_clr_lt`) AS `avg_clr_lt` FROM `import` WHERE (YEAR(`shp_eta`) = '$year')
                        AND (MONTH(`shp_eta`) = '$month')
                        AND (`chrg_rmrk` = '$sector')
                        AND (`cstm_brkr` = '$agent')";
                $q_avg = $conn->query($q);
                $avg = $q_avg->fetch_assoc();
                // Rounding
                $round_avg = round($avg['avg_clr_lt'], 2);
                // Push into result array
                array_push($result, $round_avg);
            }
            break;
        // Avg. Local Charge
        case "avg_loc_chrg":
            // Month iteration
            for ($i = 1; $i <= 12; $i++){
                // Month formatting
                $month = sprintf("%02d", $i);
                // Average query
                $q = "SELECT AVG(`chrg_wo_tax`) AS `avg_loc_chrg` FROM `import` WHERE (YEAR(`shp_eta`) = '$year')
                        AND (MONTH(`shp_eta`) = '$month')
                        AND (`chrg_rmrk` = '$sector')
                        AND (`cstm_brkr` = '$agent')";
                $q_avg = $conn->query($q);
                $avg = $q_avg->fetch_assoc();
                // Rounding
                $round_avg = round($avg['avg_loc_chrg'], 2);
                // Push into result array
                array_push($result, $round_avg);
            }
            break;
        // Avg. Import Duty
        case "avg_imp_duty":
            // Month iteration
            for ($i = 1; $i <= 12; $i++){
                // Month formatting
                $month = sprintf("%02d", $i);
                // Average query
                $q = "SELECT AVG(`chrg_impr`) AS `impr_duty_avg` FROM `import` WHERE (YEAR(`shp_eta`) = '$year')
                        AND (MONTH(`shp_eta`) = '$month')
                        AND (`chrg_rmrk` = '$sector')
                        AND (`cstm_brkr` = '$agent')";
                $q_avg = $conn->query($q);
                $avg = $q_avg->fetch_assoc();
                // Rounding
                $round_avg = round($avg['impr_duty_avg'], 2);
                // Push into result array
                array_push($result, $round_avg);
            }
            break;
        // Cost / Kg
        default:
            // Month iteration
            for ($i = 1; $i <= 12; $i++){
                // Month formatting
                $month = sprintf("%02d", $i);
                // Select query
                $q = "SELECT SUM(`chrg_wo_tax`) AS `cost_sum`,SUM(`shp_wght`) AS `kg_sum` FROM `import` WHERE (YEAR(`shp_eta`) = '$year')
                        AND (MONTH(`shp_eta`) = '$month')
                        AND (`chrg_rmrk` = '$sector')
                        AND (`cstm_brkr` = '$agent')";
                $q_cost_kg = $conn->query($q);
                if (mysqli_num_rows($q_cost_kg) == 0){
                    $cost_per_kg = 0;
                } else {
                    $cost_kg = $q_cost_kg->fetch_assoc();
                    $cost = $cost_kg['cost_sum'];
                    $kg = $cost_kg['kg_sum'];
                    if ($kg != 0){
                        $cost_per_kg = round(($cost/$kg), 2);
                    } else {
                        $cost_per_kg = 0;
                    }
                }
                // Push into result array
                array_push($result, $cost_per_kg);
            }
            break;
    }
    // Month Variable
    $jan = $result[0] ?? 0;
    $feb = $result[1] ?? 0;
    $mar = $result[2] ?? 0;
    $apr = $result[3] ?? 0;
    $may = $result[4] ?? 0;
    $jun = $result[5] ?? 0;
    $jul = $result[6] ?? 0;
    $aug = $result[7] ?? 0;
    $sep = $result[8] ?? 0;
    $oct = $result[9] ?? 0;
    $nov = $result[10] ?? 0;
    $dec = $result[11] ?? 0;
} else {
    // Get Value
    $result1 = array();
    $result2 = array();
    // Choosen graph logic
    switch ($graph) {
        // % Delivery LT
        case "per_dlv_lt":
            // Parameter
            if($_GET['parameter'] != 0){
                $param = $_GET['parameter']; // Set parameter
                // Month iteration
                for ($i = 1; $i <= 12; $i++){
                    // Month formatting
                    $month = sprintf("%02d", $i);
                    // Speedmark
                    // -- All query
                    $q1_all = "SELECT `rls_dlv_lt` FROM `import` WHERE (YEAR(`shp_eta`) = '$year')
                                AND (MONTH(`shp_eta`) = '$month')
                                AND (`chrg_rmrk` = '$sector')
                                AND (`cstm_brkr` = 'Speedmark')";
                    $q1_all_res = $conn->query($q1_all);
                    $q1_all_sum = mysqli_num_rows($q1_all_res);
                    // -- Pref query
                    $q1_pre = "SELECT `rls_dlv_lt` FROM `import` WHERE (YEAR(`shp_eta`) = '$year')
                                AND (MONTH(`SHP_ETA`) = '$month')
                                AND (`rls_dlv_lt` != 0)
                                AND (`rls_dlv_lt` <= $param)
                                AND (`cstm_brkr` = 'Speedmark')";
                    $q1_pre_res = $conn->query($q1_pre);
                    $q1_pre_sum = mysqli_num_rows($q1_pre_res);
                    // -- Precentage
                    if ($q1_all_sum > 0){
                        $q1_res = round((($q1_pre_sum * 100) / $q1_all_sum), 2);
                    } else {
                        $q1_res = 0;
                    }
                    // -- Push result
                    array_push($result1, $q1_res);
                    // Schenker
                    // -- All query
                    $q2_all = "SELECT `rls_dlv_lt` FROM `import` WHERE (YEAR(`shp_eta`) = '$year')
                                AND (MONTH(`shp_eta`) = '$month')
                                AND (`chrg_rmrk` = '$sector')
                                AND (`cstm_brkr` = 'Schenker')";
                    $q2_all_res = $conn->query($q2_all);
                    $q2_all_sum = mysqli_num_rows($q2_all_res);
                    // -- Pref query
                    $q2_pre = "SELECT `rls_dlv_lt` FROM `import` WHERE (YEAR(`shp_eta`) = '$year')
                                AND (MONTH(`SHP_ETA`) = '$month')
                                AND (`rls_dlv_lt` != 0)
                                AND (`rls_dlv_lt` <= $param)
                                AND (`cstm_brkr` = 'Schenker')";
                    $q2_pre_res = $conn->query($q2_pre);
                    $q2_pre_sum = mysqli_num_rows($q2_pre_res);
                    // -- Precentage
                    if ($q2_all_sum > 0){
                        $q2_res = round((($q2_pre_sum * 100) / $q2_all_sum), 2);
                    } else {
                        $q2_res = 0;
                    }
                    // -- Push result
                    array_push($result2, $q2_res);
                }
            } else {
                // Message
                call_msg("warning", "Please fill out the parameter field.");
                // Redirect
                red_graph();
            }
            break;
        // % Clearence LT
        case "per_clr_lt":
            // Parameter
            if($_GET['parameter'] != 0){
                $param = $_GET['parameter']; // Set parameter
                // Month iteration
                for ($i = 1; $i <= 12; $i++){
                    // Month formatting
                    $month = sprintf("%02d", $i);
                    // Speedmark
                    // -- All query
                    $q1_all = "SELECT `rls_clr_lt` FROM `import` WHERE (YEAR(`shp_eta`) = '$year')
                                AND (MONTH(`shp_eta`) = '$month')
                                AND (`chrg_rmrk` = '$sector')
                                AND (`cstm_brkr` = 'Speedmark')";
                    $q1_all_res = $conn->query($q1_all);
                    $q1_all_sum = mysqli_num_rows($q1_all_res);
                    // -- Pref query
                    $q1_pre = "SELECT `rls_clr_lt` FROM `import` WHERE (YEAR(`shp_eta`) = '$year')
                                AND (MONTH(`SHP_ETA`) = '$month')
                                AND (`rls_dlv_lt` != 0)
                                AND (`rls_dlv_lt` <= $param)
                                AND (`cstm_brkr` = 'Speedmark')";
                    $q1_pre_res = $conn->query($q1_pre);
                    $q1_pre_sum = mysqli_num_rows($q1_pre_res);
                    // -- Precentage
                    if ($q1_all_sum > 0){
                        $q1_res = round((($q1_pre_sum * 100) / $q1_all_sum), 2);
                    } else {
                        $q1_res = 0;
                    }
                    // -- Push result
                    array_push($result1, $q1_res);
                    // Schenker
                    // -- All query
                    $q2_all = "SELECT `rls_clr_lt` FROM `import` WHERE (YEAR(`shp_eta`) = '$year')
                                AND (MONTH(`shp_eta`) = '$month')
                                AND (`chrg_rmrk` = '$sector')
                                AND (`cstm_brkr` = 'Schenker')";
                    $q2_all_res = $conn->query($q2_all);
                    $q2_all_sum = mysqli_num_rows($q2_all_res);
                    // -- Pref query
                    $q2_pre = "SELECT `rls_clr_lt` FROM `import` WHERE (YEAR(`shp_eta`) = '$year')
                                AND (MONTH(`SHP_ETA`) = '$month')
                                AND (`rls_dlv_lt` != 0)
                                AND (`rls_dlv_lt` <= $param)
                                AND (`cstm_brkr` = 'Schenker')";
                    $q2_pre_res = $conn->query($q2_pre);
                    $q2_pre_sum = mysqli_num_rows($q2_pre_res);
                    // -- Precentage
                    if ($q2_all_sum > 0){
                        $q2_res = round((($q2_pre_sum * 100) / $q2_all_sum), 2);
                    } else {
                        $q2_res = 0;
                    }
                    // -- Push result
                    array_push($result2, $q2_res);
                }
            } else {
                // Message
                call_msg("warning", "Please fill out the parameter field.");
                // Redirect
                red_graph();
            }
            break;
        // Avg. Delivery LT
        case "avg_dlv_lt":
            // Month iteration
            for ($i = 1; $i <= 12; $i++){
                // Month formatting
                $month = sprintf("%02d", $i);
                // Speedmark
                // -- Average query
                $q1 = "SELECT AVG(`rls_dlv_lt`) AS `avg_dlv_lt` FROM `import` WHERE (YEAR(`shp_eta`) = '$year')
                        AND (MONTH(`shp_eta`) = '$month')
                        AND (`chrg_rmrk` = '$sector')
                        AND (`cstm_brkr` = 'Speedmark')";
                $q1_avg = $conn->query($q1);
                $avg1 = $q1_avg->fetch_assoc();
                // -- Rounding
                $round_avg1 = round($avg1['avg_dlv_lt'], 2);
                // -- Push result
                array_push($result1, $round_avg1);
                // Schenker
                // -- Average query
                $q2 = "SELECT AVG(`rls_dlv_lt`) AS `avg_dlv_lt` FROM `import` WHERE (YEAR(`shp_eta`) = '$year')
                        AND (MONTH(`shp_eta`) = '$month')
                        AND (`chrg_rmrk` = '$sector')
                        AND (`cstm_brkr` = 'Schenker')";
                $q2_avg = $conn->query($q2);
                $avg2 = $q2_avg->fetch_assoc();
                // -- Rounding
                $round_avg2 = round($avg2['avg_dlv_lt'], 2);
                // -- Push result
                array_push($result2, $round_avg2);
            }
            break;
        // Avg. Clearence LT
        case "avg_clr_lt":
            // Month iteration
            for ($i = 1; $i <= 12; $i++){
                // Month formatting
                $month = sprintf("%02d", $i);
                // Speedmark
                // -- Average query
                $q1 = "SELECT AVG(`rls_clr_lt`) AS `avg_clr_lt` FROM `import` WHERE (YEAR(`shp_eta`) = '$year')
                        AND (MONTH(`shp_eta`) = '$month')
                        AND (`chrg_rmrk` = '$sector')
                        AND (`cstm_brkr` = 'Speedmark')";
                $q1_avg = $conn->query($q1);
                $avg1 = $q1_avg->fetch_assoc();
                // -- Rounding
                $round_avg1 = round($avg1['avg_clr_lt'], 2);
                // -- Push result
                array_push($result1, $round_avg1);
                // Schenker
                // -- Average query
                $q2 = "SELECT AVG(`rls_clr_lt`) AS `avg_clr_lt` FROM `import` WHERE (YEAR(`shp_eta`) = '$year')
                        AND (MONTH(`shp_eta`) = '$month')
                        AND (`chrg_rmrk` = '$sector')
                        AND (`cstm_brkr` = 'Schenker')";
                $q2_avg = $conn->query($q2);
                $avg1 = $q2_avg->fetch_assoc();
                // -- Rounding
                $round_avg2 = round($avg2['avg_clr_lt'], 2);
                // -- Push result
                array_push($result2, $round_avg2);
            }
            break;
        // Avg. Local Charge
        case "avg_loc_chrg":
            // Month iteration
            for ($i = 1; $i <= 12; $i++){
                // Month formatting
                $month = sprintf("%02d", $i);
                // Speedmark
                // -- Average query
                $q1 = "SELECT AVG(`chrg_wo_tax`) AS `avg_loc_chrg` FROM `import` WHERE (YEAR(`shp_eta`) = '$year')
                        AND (MONTH(`shp_eta`) = '$month')
                        AND (`chrg_rmrk` = '$sector')
                        AND (`cstm_brkr` = 'Speedmark')";
                $q1_avg = $conn->query($q1);
                $avg1 = $q1_avg->fetch_assoc();
                // -- Rounding
                $round_avg1 = round($avg1['avg_loc_chrg'], 2);
                // -- Push result
                array_push($result1, $round_avg1);
                // Schenker
                // -- Average query
                $q2 = "SELECT AVG(`chrg_wo_tax`) AS `avg_loc_chrg` FROM `import` WHERE (YEAR(`shp_eta`) = '$year')
                        AND (MONTH(`shp_eta`) = '$month')
                        AND (`chrg_rmrk` = '$sector')
                        AND (`cstm_brkr` = 'Schenker')";
                $q2_avg = $conn->query($q2);
                $avg2 = $q2_avg->fetch_assoc();
                // -- Rounding
                $round_avg2 = round($avg2['avg_loc_chrg'], 2);
                // -- Push result
                array_push($result2, $round_avg2);
            }
            break;
        // Avg. Import Duty
        case "avg_imp_duty":
            // Month iteration
            for ($i = 1; $i <= 12; $i++){
                // Month formatting
                $month = sprintf("%02d", $i);
                // Speedmark
                // -- Average query
                $q1 = "SELECT AVG(`chrg_impr`) AS `impr_duty_avg` FROM `import` WHERE (YEAR(`shp_eta`) = '$year')
                        AND (MONTH(`shp_eta`) = '$month')
                        AND (`chrg_rmrk` = '$sector')
                        AND (`cstm_brkr` = 'Speedmark')";
                $q1_avg = $conn->query($q1);
                $avg1 = $q1_avg->fetch_assoc();
                // -- Rounding
                $round_avg1 = round($avg1['impr_duty_avg'], 2);
                // -- Push result
                array_push($result1, $round_avg1);
                // Schenker
                // -- Average query
                $q2 = "SELECT AVG(`chrg_impr`) AS `impr_duty_avg` FROM `import` WHERE (YEAR(`shp_eta`) = '$year')
                        AND (MONTH(`shp_eta`) = '$month')
                        AND (`chrg_rmrk` = '$sector')
                        AND (`cstm_brkr` = 'Schenker')";
                $q2_avg = $conn->query($q2);
                $avg2 = $q2_avg->fetch_assoc();
                // -- Rounding
                $round_avg2 = round($avg2['impr_duty_avg'], 2);
                // -- Push result
                array_push($result2, $round_avg2);
            }
            break;
        // Cost / Kg
        default:
            // Month iteration
            for ($i = 1; $i <= 12; $i++){
                // Month formatting
                $month = sprintf("%02d", $i);
                // Speedmark
                // -- Select query
                $q1 = "SELECT SUM(`chrg_wo_tax`) AS `cost_sum`,SUM(`shp_wght`) AS `kg_sum` FROM `import` WHERE (YEAR(`shp_eta`) = '$year')
                        AND (MONTH(`shp_eta`) = '$month')
                        AND (`chrg_rmrk` = '$sector')
                        AND (`cstm_brkr` = 'Speedmark')";
                $q1_cost_kg = $conn->query($q1);
                if (mysqli_num_rows($q1_cost_kg) == 0){
                    $cost1_per_kg = 0;
                } else {
                    $cost1_kg = $q1_cost_kg->fetch_assoc();
                    $cost1 = $cost1_kg['cost_sum'];
                    $kg1 = $cost1_kg['kg_sum'];
                    if ($kg1 != 0){
                        $cost1_per_kg = round(($cost1/$kg1), 2);
                    } else {
                        $cost1_per_kg = 0;
                    }
                }
                // -- Push result
                array_push($result1, $cost1_per_kg);
                // Schenker
                // -- Select query
                $q2 = "SELECT SUM(`chrg_wo_tax`) AS `cost_sum`,SUM(`shp_wght`) AS `kg_sum` FROM `import` WHERE (YEAR(`shp_eta`) = '$year')
                        AND (MONTH(`shp_eta`) = '$month')
                        AND (`chrg_rmrk` = '$sector')
                        AND (`cstm_brkr` = 'Schenker')";
                $q2_cost_kg = $conn->query($q2);
                if (mysqli_num_rows($q2_cost_kg) == 0){
                    $cost2_per_kg = 0;
                } else {
                    $cost2_kg = $q2_cost_kg->fetch_assoc();
                    $cost2 = $cost2_kg['cost_sum'];
                    $kg2 = $cost2_kg['kg_sum'];
                    if ($kg2 != 0){
                        $cost2_per_kg = round(($cost2/$kg2), 2);
                    } else {
                        $cost2_per_kg = 0;
                    }
                }
                // -- Push result
                array_push($result2, $cost2_per_kg);
            }
            break;
        
    }
    // Month variable
    // -- Speedmark
    $jan1 = $result1[0] ?? 0;
    $feb1 = $result1[1] ?? 0;
    $mar1 = $result1[2] ?? 0;
    $apr1 = $result1[3] ?? 0;
    $may1 = $result1[4] ?? 0;
    $jun1 = $result1[5] ?? 0;
    $jul1 = $result1[6] ?? 0;
    $aug1 = $result1[7] ?? 0;
    $sep1 = $result1[8] ?? 0;
    $oct1 = $result1[9] ?? 0;
    $nov1 = $result1[10] ?? 0;
    $dec1 = $result1[11] ?? 0;
    // -- Schenker
    $jan2 = $result2[0] ?? 0;
    $feb2 = $result2[1] ?? 0;
    $mar2 = $result2[2] ?? 0;
    $apr2 = $result2[3] ?? 0;
    $may2 = $result2[4] ?? 0;
    $jun2 = $result2[5] ?? 0;
    $jul2 = $result2[6] ?? 0;
    $aug2 = $result2[7] ?? 0;
    $sep2 = $result2[8] ?? 0;
    $oct2 = $result2[9] ?? 0;
    $nov2 = $result2[10] ?? 0;
    $dec2 = $result2[11] ?? 0;
}

// Unset Graph
if (isset($_GET["unset-graph"])){
    $result = $_GET["unset-graph"];
}

// Sector Indicator
function sectorInd($in){
    if ($in == "MCLS"){
        $out = "Chemicals";
    } else {
        $out = "Pharma";
    }
    echo $out;
}

// Graph Indicator
function graphInd($in){
    switch($in){
        case "per_dlv_lt":
            $out = "% Delivery LT";
            break;
        case "per_clr_lt":
            $out = "% Clearence LT";
            break;
        case "avg_dlv_lt":
            $out = "Avg. Delivery LT";
            break;
        case "avg_clr_lt":
            $out = "Avg. Clearence LT";
            break;
        case "avg_loc_chrg":
            $out = "Avg. Local Charge";
            break;
        case "avg_imp_duty":
            $out = "Avg. Import Duty";
            break;
        default:
            $out = "Cost / Kg";
            break;
    }
    echo $out;
}
?>