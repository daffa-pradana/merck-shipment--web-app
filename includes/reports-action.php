<?php
    // Config
    require 'config.php';

    // User Auth
    $auth = $userData['user_auth'] ?? '';

    // Default Value
    $tableState = "show";
    $reportState = "";

    // Default Rep Value
    // -- Created
    $crtdBy = "";
    $crtdTime = "";
    // -- Modified
    $modBy = "";
    $modTime = "";
    // -- Shipping
    $shpMawb = "";
    $shpHawb = "";
    $shpAfsf = "";
    $shpFlve = "";
    $shpShpr = "";
    $shpCons = "";
    $shpAju = "";
    $shpQty = "";
    $shpPkgs = "";
    $shpWght = "";
    $shpCbm = "";
    $shpFwdr = "";
    $shpLcl = "";
    $shpPick = "";
    $shpEtd = "";
    $shpEta = "";
    $shpArrDate = "";
    $shpArrDay = "";
    $shpNoa = "";
    $shpApp = "";
    $shpPde = "";
    // -- Supplier
    $supOrdr = "";
    $supInvNo = "";
    $supInvDate = "";
    $supCurr = "";
    $supVal = "";
    $supFrgt = "";
    $supTot = "";
    $supColl = "";
    // -- Invoice
    $invOrdr = "";
    $invNo = "";
    $invDate = "";
    $invCurr = "";
    $invVal = "";
    $invFrgt = "";
    $invTot = "";
    $invColl = "";
    // -- Customs
    $cstmBrkr = "";
    $cstmInvNo = "";
    $cstmInvRcvd = "";
    // -- Charges
    $chrgFrgt = "";
    $chrgImpr = "";
    $chrgBm = "";
    $chrgDuty = "";
    $chrgWh = "";
    $chrgVat = "";
    $chrgStrg = "";
    $chrgDlv = "";
    $chrgOthr = "";
    $chrgWoTax = "";
    $chrgPBm = "";
    $chrgPTot = "";
    $chrgTot = "";
    $chrgRmrk = "";
    // -- Licenses
    $lcsReq = "";
    $lcsBpom = "";
    $lcsCoo = "";
    $lcsKh = "";
    $lcsCompDoc = "";
    $lcsComp = "";
    // -- PIB
    $pibIssd = "";
    $pibConf = "";
    $pibRmrk = "";
    $pibBill = "";
    $pibPaid = "";
    $pibTrf = "";
    // -- PEB
    $pebIssd = "";
    $pebConf = "";
    $pebRmrk = "";
    $pebTrf = "";
    // -- SKEP
    $skepDate = "";
    $skepRmrk = "";
    // -- Inspection
    $inspDate = "";
    $inspRsn = "";
    // -- SPPB
    $sppbDate = "";
    // -- NPE
    $npeDate = "";
    // -- Release
    $rlsDlv = "";
    $rlsGrn = "";
    $rlsClrLt = "";
    $rlsDlvLt = "";
    $rlsGrnLt = "";
    // -- Recieved
    $rcvdDlv = "";
    $rcvdGrn = "";
    $rcvdClrLt = "";
    $rcvdDlvLt = "";
    $rcvdGrnLt = "";
    // -- Storage
    $strgIn = "";
    $strgOut = "";
    $strgDays = "";
    // -- Valuation
    $valDate = "";
    $valRmrk = "";
    // -- Historical
    $histBg = "";

    function val($input){
        if ($input == "0000-00-00" || $input == "") {
            $input = "-";
        } else {
            $input = $input;
        }
        echo $input;
    }

    // -- Report View State --
    if(isset($_GET["set-search"])){
        // Table State
        $tableState = "search";
        // Get Value
        $dateFrom = $_GET['date_from'];
        $dateTo = $_GET['date_to'];
        $afsf = $_GET['afsf'];
        $sector = $_GET['sector'];
        $agent = $_GET['agent'];
        switch ($sector){
            case "imp":
                $busSec = "import";
                $remark = "";
                break;
            case "exp":
                $busSec = "export";
                $remark = "";
                break;
            case "chemImp":
                $busSec = "import";
                $remark = "MCLS";
                break;
            case "pharImp":
                $busSec = "import";
                $remark = "BRA";
                break;
            case "chemExp":
                $busSec = "export";
                $remark = "MCLS";
                break;
            case "pharExp":
                $busSec = "export";
                $remark = "BRA";
                break;
            default:
                $busSec = "import";
                $remark = "MCLS";
                break;
        }
        // Query
        $query = "SELECT * FROM `$busSec` WHERE (`shp_eta` BETWEEN '$dateFrom' AND '$dateTo')";
        // AF/SF Selection
        if($afsf != "All") {
          $query .= " AND (`shp_afsf` LIKE '%$afsf%')";                    
        }
        // Custom Agent Selection
        if($agent != "All") {
          $query .= " AND (`cstm_brkr` LIKE '%$agent%')";                    
        }
        // Sector Selection
        if($remark != "") {
          $query .= " AND (`chrg_rmrk` LIKE '%$remark%')";
        }
        $srcRes = $conn->query($query);
        $srcResSum = mysqli_num_rows($srcRes);
      } else {
        // Table State
        $tableState = "show";
        // Current Date
        $today = date('Y-m-d');
        // Import Chemicals
        $impChemQ = "SELECT * FROM `import` WHERE `chrg_rmrk` = 'MCLS' AND `sppb_date` = '0000-00-00'";
        if ($auth == "(3rd)Speedmark"){
          $impChemQ .= " AND `cstm_brkr` = 'Speedmark'";
          $impChem = $conn->query("SELECT DATEDIFF(`shp_eta`,'$today') AS `diff`,`rep_no`,`shp_hawb`,`shp_aju`,`shp_eta`,`sup_inv_no`,`sup_curr`,`sup_val` FROM `import` WHERE `chrg_rmrk` = 'MCLS' AND `sppb_date` = '0000-00-00' AND `cstm_brkr` = 'Speedmark' ORDER BY `diff` ASC");
        } else {
          $impChem = $conn->query("SELECT DATEDIFF(`shp_eta`,'$today') AS `diff`,`rep_no`,`shp_hawb`,`shp_aju`,`shp_eta`,`sup_inv_no`,`sup_curr`,`sup_val` FROM `import` WHERE `chrg_rmrk` = 'MCLS' AND `sppb_date` = '0000-00-00' ORDER BY `diff` ASC");
        }
        $impChemSum = mysqli_num_rows($impChem);
        // Import Pharma
        $impPharQ = "SELECT * FROM `import` WHERE `chrg_rmrk` = 'BRA' AND `sppb_date` = '0000-00-00'";
        if ($auth == "(3rd)Speedmark"){
          $impPharQ .= " AND `cstm_brkr` = 'Speedmark'";
          $impPhar = $conn->query("SELECT DATEDIFF(`shp_eta`,'$today') AS `diff`,`rep_no`,`shp_hawb`,`shp_aju`,`shp_eta`,`sup_inv_no`,`sup_curr`,`sup_val` FROM `import` WHERE `chrg_rmrk` = 'BRA' AND `sppb_date` = '0000-00-00' AND `cstm_brkr` = 'Speedmark' ORDER BY `diff` ASC");
        } else {
          $impPhar = $conn->query("SELECT DATEDIFF(`shp_eta`,'$today') AS `diff`,`rep_no`,`shp_hawb`,`shp_aju`,`shp_eta`,`sup_inv_no`,`sup_curr`,`sup_val` FROM `import` WHERE `chrg_rmrk` = 'BRA' AND `sppb_date` = '0000-00-00' ORDER BY `diff` ASC");
        }
        $impPharSum = mysqli_num_rows($impPhar);
        // Export Chemicals
        $expChemQ = "SELECT * FROM `export` WHERE `chrg_rmrk` = 'MCLS' AND `npe_date` = '0000-00-00'";
        if ($auth == "(3rd)Speedmark"){
          $expChemQ .= " AND `cstm_brkr` = 'Speedmark'";
          $expChem = $conn->query("SELECT DATEDIFF(`shp_eta`,'$today') AS `diff`,`rep_no`,`shp_hawb`,`shp_aju`,`shp_eta`,`inv_no`,`inv_curr`,`inv_val` FROM `export` WHERE `chrg_rmrk` = 'MCLS' AND `npe_date` = '0000-00-00' AND `cstm_brkr` = 'Speedmark' ORDER BY `diff` ASC");  
        } else {
          $expChem = $conn->query("SELECT DATEDIFF(`shp_eta`,'$today') AS `diff`,`rep_no`,`shp_hawb`,`shp_aju`,`shp_eta`,`inv_no`,`inv_curr`,`inv_val` FROM `export` WHERE `chrg_rmrk` = 'MCLS' AND `npe_date` = '0000-00-00' ORDER BY `diff` ASC");
        }
        $expChemSum = mysqli_num_rows($expChem);
        // Export Pharma
        $expPharQ = "SELECT * FROM `export` WHERE `chrg_rmrk` = 'BRA' AND `npe_date` = '0000-00-00'";
        if($auth == "(3rd)Speedmark"){
          $expPharQ .= " AND `cstm_brkr` = 'Speedmark'";
          $expPhar = $conn->query("SELECT DATEDIFF(`shp_eta`,'$today') AS `diff`,`rep_no`,`shp_hawb`,`shp_aju`,`shp_eta`,`inv_no`,`inv_curr`,`inv_val` FROM `export` WHERE `chrg_rmrk` = 'BRA' AND `npe_date` = '0000-00-00' AND `cstm_brkr` = 'Speedmark' ORDER BY `diff` ASC");
        } else {
          $expPhar = $conn->query("SELECT DATEDIFF(`shp_eta`,'$today') AS `diff`,`rep_no`,`shp_hawb`,`shp_aju`,`shp_eta`,`inv_no`,`inv_curr`,`inv_val` FROM `export` WHERE `chrg_rmrk` = 'BRA' AND `npe_date` = '0000-00-00' ORDER BY `diff` ASC");
        }        
        $expPharSum = mysqli_num_rows($expPhar);
    }
    
    // -- Import Action
    // Select
    if (isset($_GET["select-import"])) {
        $repNo = $_GET["select-import"];
        $reportState = "import";
        $sql = $conn->query("SELECT * FROM `import` WHERE `rep_no` = $repNo");
        if ($sql->num_rows > 0) {
          $row = $sql->fetch_array();
          // Created By
          $crtdBy = $row['rep_crt_by'];
          // Created time
          $crtdTime = $row['rep_crt_time'];
          // Modified By
          $modBy = $row['rep_mod_by'];
          // Modified Time
          $modTime = $row['rep_mod_time'];
          // Shipping Value
          $shpMawb = $row['shp_mawb'];
          $shpHawb = $row['shp_hawb'];
          $shpAfsf = $row['shp_afsf'];
          $shpFlve = $row['shp_flve'];
          $shpShpr = $row['shp_shpr'];
          $shpAju = $row['shp_aju'];
          $shpQty = $row['shp_qty'];
          $shpPkgs = $row['shp_pkgs'];
          $shpWght = $row['shp_wght'];
          $shpCbm = $row['shp_cbm'];
          $shpFwdr = $row['shp_fwdr'];
          $shpLcl = $row['shp_lcl'];
          $shpEtd = $row['shp_etd'];
          $shpEta = $row['shp_eta'];
          $shpArrDate = $row['shp_arr_date'];
          $shpArrDay = $row['shp_arr_day'];
          $shpNoa = $row['shp_noa'];
          $shpApp = $row['shp_app'];
          $shpPde = $row['shp_pde'];
          // Supplier Value
          $supOrdr = $row['sup_ordr'];
          $supInvNo = $row['sup_inv_no'];
          $supInvDate = $row['sup_inv_date'];
          $supCurr = $row['sup_curr'];
          $supVal = $row['sup_val'];
          $supFrgt = $row['sup_frgt'];
          $supTot = $row['sup_tot'];
          $supColl = $row['sup_coll'];
          // Customs Value
          $cstmBrkr = $row['cstm_brkr'];
          $cstmInvNo = $row['cstm_inv_no'];
          $cstmRcvd = $row['cstm_rcvd'];
          // Charges Value
          $chrgFrgt = $row['chrg_frgt'];
          $chrgImpr = $row['chrg_impr'];
          $chrgBm = $row['chrg_bm'];
          $chrgDuty = $row['chrg_duty'];
          $chrgWh = $row['chrg_wh'];
          $chrgVat = $row['chrg_vat'];
          $chrgStrg = $row['chrg_strg'];
          $chrgDlv = $row['chrg_dlv'];
          $chrgOthr = $row['chrg_othr'];
          $chrgWoTax = $row['chrg_wo_tax'];
          $chrgPBm = $row['chrg_p_bm'];
          $chrgPTot = $row['chrg_p_tot'];
          $chrgRmrk = $row['chrg_rmrk'];
          // Licenses Value
          $lcsReq = $row['lcs_req'];
          $lcsBpom = $row['lcs_bpom'];
          $lcsCoo = $row['lcs_coo'];
          $lcsKh = $row['lcs_kh'];
          $lcsCompDoc = $row['lcs_comp_doc'];
          $lcsComp = $row['lcs_comp'];
          // PIB Values
          $pibIssd = $row['pib_issd'];
          $pibConf = $row['pib_conf'];
          $pibRmrk = $row['pib_rmrk'];
          $pibBill = $row['pib_bill'];
          $pibPaid = $row['pib_paid'];
          $pibTrf = $row['pib_trf'];
          // SKEP Values
          $skepDate = $row['skep_date'];
          $skepRmrk = $row['skep_rmrk'];
          // Inspection Values
          $inspDate = $row['insp_date'];
          $inspRsn = $row['insp_rsn'];
          // SPPB Values
          $sppbDate = $row['sppb_date'];
          // Release Values
          $rlsDlv = $row['rls_dlv'];
          $rlsGrn = $row['rls_grn'];
          $rlsClrLt = $row['rls_clr_lt'];
          $rlsDlvLt = $row['rls_dlv_lt'];
          $rlsGrnLt = $row['rls_grn_lt'];
          // Storage Values
          $strgIn = $row['strg_in'];
          $strgOut = $row['strg_out'];
          $strgDays = $row['strg_days'];
          // Valuation Values
          $valDate = $row['val_date'];
          $valRmrk = $row['val_rmrk'];
          // Historical Values
          $histBg = $row['hist_bg'];
        }
        if ($chrgRmrk == "MCLS"){
          $busSector = "Chemical - Import";
        } else {
          $busSector = "Pharma - Import";
        }
    }

    // -- Export Action
    // Select
    if (isset($_GET['select-export'])){
        $repNo = $_GET['select-export'];
        $reportState = "export";
        $sql = $conn->query("SELECT * FROM `export` WHERE `rep_no` = $repNo");
        if ($sql->num_rows > 0) {
          $row = $sql->fetch_array();
          // Created By
          $crtdBy = $row['rep_crt_by'];
          // Created Time
          $crtdTime = $row['rep_crt_time'];
          // Modified By
          $modBy = $row['rep_mod_by'];
          // Modified Time
          $modTime = $row['rep_mod_time'];
          // Shipping Value
          $shpMawb = $row['shp_mawb'];
          $shpHawb = $row['shp_hawb'];
          $shpAfsf = $row['shp_afsf'];
          $shpFlve = $row['shp_flve'];
          $shpCons = $row['shp_cons'];
          $shpAju = $row['shp_aju'];
          $shpQty = $row['shp_qty'];
          $shpPkgs = $row['shp_pkgs'];
          $shpWght = $row['shp_wght'];
          $shpCbm = $row['shp_cbm'];
          $shpFwdr = $row['shp_fwdr'];
          $shpLcl = $row['shp_lcl'];
          $shpPick = $row['shp_pick'];
          $shpEtd = $row['shp_etd'];
          $shpEta = $row['shp_eta'];
          $shpArrDate = $row['shp_arr_date'];
          $shpArrDay = $row['shp_arr_day'];
          // Invoice Value
          $invOrdr = $row['inv_ordr'];
          $invNo = $row['inv_no'];
          $invDate = $row['inv_date'];
          $invCurr = $row['inv_curr'];
          $invVal = $row['inv_val'];
          $invFrgt = $row['inv_frgt'];
          $invTot = $row['inv_tot'];
          $invColl = $row['inv_coll'];
          // Customs Value
          $cstmBrkr = $row['cstm_brkr'];
          $cstmInvNo = $row['cstm_inv_no'];
          $cstmRcvd = $row['cstm_rcvd'];
          // Charges Value
          $chrgFrgt = $row['chrg_frgt'];
          $chrgStrg = $row['chrg_strg'];
          $chrgOthr = $row['chrg_othr'];
          $chrgTot = $row['chrg_tot'];
          $chrgRmrk = $row['chrg_rmrk'];
          // Licenses Value
          $lcsReq = $row['lcs_req'];
          $lcsBpom = $row['lcs_bpom'];
          $lcsCoo = $row['lcs_coo'];
          $lcsCompDoc = $row['lcs_comp_doc'];
          $lcsComp = $row['lcs_comp'];
          // PEB Value
          $pebIssd = $row['peb_issd'];
          $pebConf = $row['peb_conf'];
          $pebRmrk = $row['peb_rmrk'];
          $pebTrf = $row['peb_trf'];
          // SKEP Value
          $skepDate = $row['skep_date'];
          $skepRmrk = $row['skep_rmrk'];
          // Inspection Value
          $inspDate = $row['insp_date'];
          $inspRsn = $row['insp_rsn'];
          // NPE Value
          $npeDate = $row['npe_date'];
          // Recieved Value
          $rcvdDlv = $row['rcvd_dlv'];
          $rcvdGrn = $row['rcvd_grn'];
          $rcvdClrLt = $row['rcvd_clr_lt'];
          $rcvdDlvLt = $row['rcvd_dlv_lt'];
          $rcvdGrnLt = $row['rcvd_grn_lt'];
          // Storage Value
          $strgIn = $row['strg_in'];
          $strgOut = $row['strg_out'];
          $strgDays = $row['strg_days'];
          // Valuation Value
          $valDate = $row['val_date'];
          $valRmrk = $row['val_rmrk'];
          // Historical Value
          $histBg = $row['hist_bg'];
        }
        if ($chrgRmrk == "MCLS"){
          $busSector = "Chemical - Export";
        } else {
          $busSector = "Pharma - Export";
        }
    }

    // Download File
    if (isset($_GET['download-file'])){
      $filename = basename($_GET['download-file']);
      $filepath = 'uploads' . $filename;
      if (!empty($filename) && file_exists($filepath)){
        
        header("Cache-Control: public");
        header("Content-Description: FIle Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/zip");
        header("Content-Transfer-Emcoding");
        readfile($filepath);
        exit;
      }
    }
?>