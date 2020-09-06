<?php
include 'config.php'; // Connection
require 'vendor/autoload.php'; // Require autoload.php from vendor

// Access all classes needed inside PHPSpreadsheet library
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
 
// Accepted excel file format
$file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

// Convert date excel into MySql Date
function convertDate($dateIn){
    if (strpos($dateIn, '/')){
        list($m, $d, $y) = explode("/", $dateIn);
        $dateOut = $y."-".sprintf("%02d", $m)."-".sprintf("%02d", $d);
    } else {
        $dateOut = "0000-00-00";
    }
    return $dateOut;
}

// Convert Null Number
function convertNum($numIn){
    if (is_numeric($numIn)){
        $numOut = $numIn;
    } else {
        $numOut = 0;
    }
    return $numOut;
}

// if file isset
if(isset($_FILES['excel_file']['name'])) {

    // Retrieving file extension
    $arr_file = explode('.', $_FILES['excel_file']['name']);
    $extension = end($arr_file);

    // Checking file type
    if(in_array($_FILES['excel_file']['type'], $file_mimes) && $extension == "xlsx"){
        
        // Move File
        $file_name = $_FILES['excel_file']['name'];
        $source_file = $_FILES['excel_file']['tmp_name'];
        $upload_dest = "uploads/".$file_name;
        move_uploaded_file($source_file, $upload_dest);

        // Check extension
        if('csv' == $extension) {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv(); // Object with csv class reader
        } else {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx(); // Object with xlsx class reader
        }
        
        // Load excel choosen file
        $spreadsheet = $reader->load($upload_dest);
        
        // Get data inside excel, and stored in this variable in array an form
        $sheetData = $spreadsheet->getActiveSheet()->toArray();

        // Get Sector
        $import_sector = $_POST['import-sector'];
        
        // -- Action
        if($import_sector == 'import' && isset($sheetData[0][71])){
            
            //counter
            $succ_c = 0;
            $fail_c = 0;

            // Import Activity Document
            for($i = 1;$i < count($sheetData);$i++){ 

                // -- Shipping info
                $shpMawb = addslashes($sheetData[$i][1]);
                $shpHawb = addslashes($sheetData[$i][2]);
                $shpAfsf = addslashes($sheetData[$i][3]);
                $shpFlve = addslashes($sheetData[$i][4]);
                $shpShpr = addslashes($sheetData[$i][5]);
                $shpAju = addslashes($sheetData[$i][6]);
                $shpQty = convertNum($sheetData[$i][7]);
                $shpPkgs = convertNum($sheetData[$i][8]);
                $shpWght = convertNum($sheetData[$i][9]);
                $shpCbm = convertNum($sheetData[$i][10]);
                $shpFwdr = addslashes($sheetData[$i][11]);
                $shpLcl = addslashes($sheetData[$i][12]);
                $shpEtd = convertDate($sheetData[$i][13]);
                $shpEta = convertDate($sheetData[$i][14]);
                $shpArrDate = convertDate($sheetData[$i][15]);
                $shpArrDay = addslashes($sheetData[$i][16]);
                $shpNoa = convertDate($sheetData[$i][17]);
                $shpApp = convertDate($sheetData[$i][18]);
                $shpPde = convertDate($sheetData[$i][19]);
                // -- License
                $lcsReq = addslashes($sheetData[$i][20]);
                $lcsBpom = convertDate($sheetData[$i][21]);
                $lcsCoo = convertDate($sheetData[$i][22]);
                $lcsKh = convertDate($sheetData[$i][23]);
                $lcsCompDoc = convertDate($sheetData[$i][24]);
                $lcsComp = convertDate($sheetData[$i][25]);
                // -- PIB
                $pibIssd = convertDate($sheetData[$i][26]);
                $pibConf = convertDate($sheetData[$i][27]);
                $pibRmrk = addslashes($sheetData[$i][28]);
                $pibBill = convertDate($sheetData[$i][29]);
                $pibPaid = convertDate($sheetData[$i][30]);
                $pibTrf = convertDate($sheetData[$i][31]);
                // -- SKEP
                $skepDate = convertDate($sheetData[$i][32]);
                $skepRmrk = addslashes($sheetData[$i][33]);
                // -- Inspection
                $inspDate = convertDate($sheetData[$i][34]);
                $inspRsn = addslashes($sheetData[$i][35]);
                // -- Supplier
                $supOrdr = addslashes($sheetData[$i][36]);
                $supInvNo = addslashes($sheetData[$i][37]);
                $supInvDate = convertDate($sheetData[$i][38]);
                $supCurr = addslashes($sheetData[$i][39]);
                $supVal = convertNum($sheetData[$i][40]);
                $supFrgt = convertNum($sheetData[$i][41]);
                $supTot = convertNum($sheetData[$i][42]);
                $supColl = addslashes($sheetData[$i][43]);
                // -- SPPB
                $sppbDate = convertDate($sheetData[$i][44]);
                // -- Release
                $rlsDlv = convertDate($sheetData[$i][45]);
                $rlsGrn = convertDate($sheetData[$i][46]);
                $rlsClrLt = convertNum($sheetData[$i][47]);
                $rlsDlvLt = convertNum($sheetData[$i][48]);
                $rlsGrnLt = convertNum($sheetData[$i][49]);
                // -- Custom Brokerages
                $cstmBrkr = addslashes($sheetData[$i][50]);
                $cstmInvNo = addslashes($sheetData[$i][51]);
                $cstmInvRcvd = addslashes($sheetData[$i][52]);
                // -- Storage
                $strgIn = convertDate($sheetData[$i][53]);
                $strgOut = convertDate($sheetData[$i][54]);
                $strgDays = convertNum($sheetData[$i][55]);
                // -- Valuation
                $valDate = convertDate($sheetData[$i][56]);
                $valRmrk = addslashes($sheetData[$i][57]);
                // -- Charges
                $chrgFrgt = convertNum($sheetData[$i][58]);
                $chrgImpr = convertNum($sheetData[$i][59]);
                $chrgBm = convertNum($sheetData[$i][60]);
                $chrgDuty = convertNum($sheetData[$i][61]);
                $chrgWh = convertNum($sheetData[$i][62]);
                $chrgVat = convertNum($sheetData[$i][63]);
                $chrgStrg = convertNum($sheetData[$i][64]);
                $chrgDlv = convertNum($sheetData[$i][65]);
                $chrgOthr = convertNum($sheetData[$i][66]);
                $chrgWoTax = convertNum($sheetData[$i][67]);
                $chrgPBm = convertNum($sheetData[$i][68]);
                $chrgPTot = convertNum($sheetData[$i][69]);
                $chrgRmrk = addslashes($sheetData[$i][70]);
                // -- Historical Background
                $histBg = addslashes($sheetData[$i][71]);
                
                $select_q = $conn->query("SELECT `shp_hawb` FROM `import` WHERE `shp_hawb` = '$shpHawb'");
                if ($select_q->num_rows == 0){
                    // Query
                    $query = "INSERT into `import`
                    (`shp_mawb`,
                    `shp_hawb`,
                    `shp_afsf`,
                    `shp_flve`,
                    `shp_shpr`,
                    `shp_aju`,
                    `shp_qty`,
                    `shp_pkgs`,
                    `shp_wght`,
                    `shp_cbm`,
                    `shp_fwdr`,
                    `shp_lcl`,
                    `shp_etd`,
                    `shp_eta`,
                    `shp_arr_date`,
                    `shp_arr_day`,
                    `shp_noa`,
                    `shp_app`,
                    `shp_pde`,
                    `lcs_req`,
                    `lcs_bpom`,
                    `lcs_coo`,
                    `lcs_kh`,
                    `lcs_comp_doc`,
                    `lcs_comp`,
                    `pib_issd`,
                    `pib_conf`,
                    `pib_rmrk`,
                    `pib_bill`,
                    `pib_paid`,
                    `pib_trf`,
                    `skep_date`,
                    `skep_rmrk`,
                    `insp_date`,
                    `insp_rsn`,
                    `sup_ordr`,
                    `sup_inv_no`,
                    `sup_inv_date`,
                    `sup_curr`,
                    `sup_val`,
                    `sup_frgt`,
                    `sup_tot`,
                    `sup_coll`,
                    `sppb_date`,
                    `rls_dlv`,
                    `rls_grn`,
                    `rls_clr_lt`,
                    `rls_dlv_lt`,
                    `rls_grn_lt`,
                    `cstm_brkr`,
                    `cstm_inv_no`,
                    `cstm_rcvd`,
                    `strg_in`,
                    `strg_out`,
                    `strg_days`,
                    `val_date`,
                    `val_rmrk`,
                    `chrg_frgt`,
                    `chrg_impr`,
                    `chrg_bm`,
                    `chrg_duty`,
                    `chrg_wh`,
                    `chrg_vat`,
                    `chrg_strg`,
                    `chrg_dlv`,
                    `chrg_othr`,
                    `chrg_wo_tax`,
                    `chrg_p_bm`,
                    `chrg_p_tot`,
                    `chrg_rmrk`,
                    `hist_bg`)
                    VALUES 
                    ('$shpMawb',
                    '$shpHawb',
                    '$shpAfsf',
                    '$shpFlve',
                    '$shpShpr',
                    '$shpAju',
                    '$shpQty',
                    '$shpPkgs',
                    '$shpWght',
                    '$shpCbm',
                    '$shpFwdr',
                    '$shpLcl',
                    '$shpEtd',
                    '$shpEta',
                    '$shpArrDate',
                    '$shpArrDay',
                    '$shpNoa',
                    '$shpApp',
                    '$shpPde',
                    '$lcsReq',
                    '$lcsBpom',
                    '$lcsCoo',
                    '$lcsKh',
                    '$lcsCompDoc',
                    '$lcsComp',
                    '$pibIssd',
                    '$pibConf',
                    '$pibRmrk',
                    '$pibBill',
                    '$pibPaid',
                    '$pibTrf',
                    '$skepDate',
                    '$skepRmrk',
                    '$inspDate',
                    '$inspRsn',
                    '$supOrdr',
                    '$supInvNo',
                    '$supInvDate',
                    '$supCurr',
                    '$supVal',
                    '$supFrgt',
                    '$supTot',
                    '$supColl',
                    '$sppbDate',
                    '$rlsDlv',
                    '$rlsGrn',
                    '$rlsClrLt',
                    '$rlsDlvLt',
                    '$rlsGrnLt',
                    '$cstmBrkr',
                    '$cstmInvNo',
                    '$cstmInvRcvd',
                    '$strgIn',
                    '$strgOut',
                    '$strgDays',
                    '$valDate',
                    '$valRmrk',
                    '$chrgFrgt',
                    '$chrgImpr',
                    '$chrgBm',
                    '$chrgDuty',
                    '$chrgWh',
                    '$chrgVat',
                    '$chrgStrg',
                    '$chrgDlv',
                    '$chrgOthr',
                    '$chrgWoTax',
                    '$chrgPBm',
                    '$chrgPTot',
                    '$chrgRmrk',
                    '$histBg')";
                
                    // Input Value
                    mysqli_query($conn, $query);

                    $succ_c++;
                } else {
                    $fail_c++;
                }
            }

            // Import data status
            $import_status = "Status - ".$succ_c." data success! & ".$fail_c." data failed!";

            // Message
            call_msg("success", $import_status);

        } elseif ($import_sector == 'export' && isset($sheetData[0][58]) && $sheetData[0][58] == 'Hist: Historical Background'){
            
            //counter
            $succ_c = 0;
            $fail_c = 0;

            // Export Activity Document
            for ($i = 1;$i < count($sheetData);$i++){
                // -- Shipping Info
                $shpMawb = addslashes($sheetData[$i][1]);
                $shpHawb = addslashes($sheetData[$i][2]);
                $shpAfsf = addslashes($sheetData[$i][3]);
                $shpFlve = addslashes($sheetData[$i][4]);
                $shpCons = addslashes($sheetData[$i][5]);
                $shpAju = addslashes($sheetData[$i][6]);
                $shpQty = convertNum($sheetData[$i][7]);
                $shpPkgs = convertNum($sheetData[$i][8]);
                $shpWght = convertNum($sheetData[$i][9]);
                $shpCbm = convertNum($sheetData[$i][10]);
                $shpFwdr = addslashes($sheetData[$i][11]);
                $shpLcl = addslashes($sheetData[$i][12]);
                $shpPick = convertDate($sheetData[$i][13]);
                $shpEtd = convertDate($sheetData[$i][14]);
                $shpEta = convertDate($sheetData[$i][15]);
                $shpArrDate = convertDate($sheetData[$i][16]);
                $shpArrDay = addslashes($sheetData[$i][17]);
                // -- Licenses
                $lcsReq = addslashes($sheetData[$i][18]);
                $lcsBpom = convertDate($sheetData[$i][19]);
                $lcsCoo = convertDate($sheetData[$i][20]);
                $lcsCompDoc = convertDate($sheetData[$i][21]);
                $lcsComp = convertDate($sheetData[$i][22]);
                // -- PEB
                $pebIssd = convertDate($sheetData[$i][23]);
                $pebConf = convertDate($sheetData[$i][24]);
                $pebRmrk = addslashes($sheetData[$i][25]);
                $pebTrf = convertDate($sheetData[$i][26]);
                // -- SKEP
                $skepDate = convertDate($sheetData[$i][27]);
                $skepRmrk = addslashes($sheetData[$i][28]);
                // -- Inspection
                $inspDate = convertDate($sheetData[$i][29]);
                $inspRsn = addslashes($sheetData[$i][30]);
                // -- Invoice
                $invOrdr = addslashes($sheetData[$i][31]);
                $invNo = addslashes($sheetData[$i][32]);
                $invDate = convertDate($sheetData[$i][33]);
                $invCurr = addslashes($sheetData[$i][34]);
                $invVal = convertNum($sheetData[$i][35]);
                $invFrgt = convertNum($sheetData[$i][36]);
                $invTot = convertNum($sheetData[$i][37]);
                $invColl = addslashes($sheetData[$i][38]);
                // -- NPE
                $npeDate = convertDate($sheetData[$i]['39']);
                // -- Recieved
                $rcvdDlv = convertDate($sheetData[$i]['40']);
                $rcvdGrn = convertDate($sheetData[$i]['41']);
                $rcvdClrLt = convertNum($sheetData[$i]['42']);
                $rcvdDlvLt = convertNum($sheetData[$i]['43']);
                $rcvdGrnLt = convertNum($sheetData[$i]['44']);
                // -- Custom Brokerages
                $cstmBrkr = addslashes($sheetData[$i][45]);
                $cstmInvNo = addslashes($sheetData[$i][46]);
                $cstmRcvd = addslashes($sheetData[$i][47]);
                // -- Storage
                $strgIn = convertDate($sheetData[$i][48]);
                $strgOut = convertDate($sheetData[$i][49]);
                $strgDays = convertNum($sheetData[$i][50]);
                // -- Valuation
                $valDate =  convertDate($sheetData[$i][52]);
                $valRmrk = addslashes($sheetData[$i][52]);
                // -- Charges
                $chrgFrgt = convertNum($sheetData[$i][53]);
                $chrgStrg = convertNum($sheetData[$i][54]);
                $chrgOthr = convertNum($sheetData[$i][55]);
                $chrgTot = convertNum($sheetData[$i][56]);
                $chrgRmrk = addslashes($sheetData[$i][57]);
                // -- Historical Background
                $histBg = addslashes($sheetData[$i][58]);
                
                $select_q = $conn->query("SELECT `shp_hawb` FROM `export` WHERE `shp_hawb` = '$shpHawb'");
                if ($select_q->num_rows == 0){
                    // Query
                    $query = "INSERT into `export`
                    (`shp_mawb`,
                    `shp_hawb`,
                    `shp_afsf`,
                    `shp_flve`,
                    `shp_cons`,
                    `shp_aju`,
                    `shp_qty`,
                    `shp_pkgs`,
                    `shp_wght`,
                    `shp_cbm`,
                    `shp_fwdr`,
                    `shp_lcl`,
                    `shp_pick`,
                    `shp_etd`,
                    `shp_eta`,
                    `shp_arr_date`,
                    `shp_arr_day`,
                    `lcs_req`,
                    `lcs_bpom`,
                    `lcs_coo`,
                    `lcs_comp_doc`,
                    `lcs_comp`,
                    `peb_issd`,
                    `peb_conf`,
                    `peb_rmrk`,
                    `peb_trf`,
                    `skep_date`,
                    `skep_rmrk`,
                    `insp_date`,
                    `insp_rsn`,
                    `inv_ordr`,
                    `inv_no`,
                    `inv_date`,
                    `inv_curr`,
                    `inv_val`,
                    `inv_frgt`,
                    `inv_tot`,
                    `inv_coll`,
                    `npe_date`,
                    `rcvd_dlv`,
                    `rcvd_grn`,
                    `rcvd_clr_lt`,
                    `rcvd_dlv_lt`,
                    `rcvd_grn_lt`,
                    `cstm_brkr`,
                    `cstm_inv_no`,
                    `cstm_rcvd`,
                    `strg_in`,
                    `strg_out`,
                    `strg_days`,
                    `val_date`,
                    `val_rmrk`,
                    `chrg_frgt`,
                    `chrg_strg`,
                    `chrg_othr`,
                    `chrg_tot`,
                    `chrg_rmrk`,
                    `hist_bg`)
                    VALUES
                    ('$shpMawb',
                    '$shpHawb',
                    '$shpAfsf',
                    '$shpFlve',
                    '$shpCons',
                    '$shpAju',
                    '$shpQty',
                    '$shpPkgs',
                    '$shpWght',
                    '$shpCbm',
                    '$shpFwdr',
                    '$shpLcl',
                    '$shpPick',
                    '$shpEtd',
                    '$shpEta',
                    '$shpArrDate',
                    '$shpArrDay',
                    '$lcsReq',
                    '$lcsBpom',
                    '$lcsCoo',
                    '$lcsCompDoc',
                    '$lcsComp',
                    '$pebIssd',
                    '$pebConf',
                    '$pebRmrk',
                    '$pebTrf',
                    '$skepDate',
                    '$skepRmrk',
                    '$inspDate',
                    '$inspRsn',
                    '$invOrdr',
                    '$invNo',
                    '$invDate',
                    '$invCurr',
                    '$invVal',
                    '$invFrgt',
                    '$invTot',
                    '$invColl',
                    '$npeDate',
                    '$rcvdDlv',
                    '$rcvdGrn',
                    '$rcvdClrLt',
                    '$rcvdDlvLt',
                    '$rcvdGrnLt',
                    '$cstmBrkr',
                    '$cstmInvNo',
                    '$cstmRcvd',
                    '$strgIn',
                    '$strgOut',
                    '$strgDays',
                    '$valDate',
                    '$valRmrk',
                    '$chrgFrgt',
                    '$chrgStrg',
                    '$chrgOthr',
                    '$chrgTot',
                    '$chrgRmrk',
                    '$histBg')";
                    
                    // Input Value
                    mysqli_query($conn, $query);
                    $succ_c++;
                } else {
                    $fail_c++;
                }
            }

            // Import data status
            $import_status = "Status - ".$succ_c." data success! & ".$fail_c." data failed!";

            // Message
            call_msg("success", $import_status);

        } else {
            
            // Message
            call_msg("warning", "Import data failed, data doesn't match with sector");
            
        }

        // Unlink File
        unlink($upload_dest);
        
        // Redirect
        red_input();

    } else {

        // Message 
        call_msg("warning", "Import data failed, invalid file format!");
        
        // Redirect
        red_input();
        
    }
    
}
?>