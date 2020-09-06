<?php
    // Config
    require 'config.php';

    // Default Value
    $formState = "";
    $tableState = "show";
    $submitState = "";

    // Default Form Value
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
    $cstmRcvd = "";
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
    
    // Convert Null Date
    function convNullDate($dateIn){
        if ($dateIn == ""){
            $dateOut = "0000-00-00";
        } else {
            $dateOut = $dateIn;
        }
        return $dateOut;
    }
    
    // Convert Null Number
    function convNullNum($numIn){
        if (is_numeric($numIn)){
            $numOut = $numIn;
        } else {
            $numOut = 0;
        }
        return $numOut;
    }
    
    // --- Table View State ---
    if(isset($_GET["set-search"])){
        // Table State
        $tableState = "search";
        // Search In
        $searchIn = $_GET["search-in"];
        // Search By
        $searchBy = $_GET["search-by"];
        // Search Keyword
        $search = $_GET["search"];
        // Query Logic
        if ($searchIn == "Chemical - Import") {
          switch ($searchBy) {
            case "hawb":
              $query = "SELECT `rep_no`,`shp_hawb`,`shp_aju`,`shp_eta`,`sup_inv_no`,`sup_curr`,`sup_val`,`sppb_date` FROM `import` WHERE `chrg_rmrk` = 'MCLS' AND `shp_hawb` = '$search'";
              break;
            case "mawb":
              $query = "SELECT `rep_no`,`shp_hawb`,`shp_aju`,`shp_eta`,`sup_inv_no`,`sup_curr`,`sup_val`,`sppb_date` FROM `import` WHERE `chrg_rmrk` = 'MCLS' AND `shp_mawb` = '$search'";
              break;
            case "aju":
              $query = "SELECT `rep_no`,`shp_hawb`,`shp_aju`,`shp_eta`,`sup_inv_no`,`sup_curr`,`sup_val`,`sppb_date` FROM `import` WHERE `chrg_rmrk` = 'MCLS' AND `shp_aju` = '$search'";
              break;
            case "inv":
              $query = "SELECT `rep_no`,`shp_hawb`,`shp_aju`,`shp_eta`,`sup_inv_no`,`sup_curr`,`sup_val`,`sppb_date` FROM `import` WHERE `chrg_rmrk` = 'MCLS' AND `sup_inv_no` = '$search'";
              break;
            case "eta":
              $query = "SELECT `rep_no`,`shp_hawb`,`shp_aju`,`shp_eta`,`sup_inv_no`,`sup_curr`,`sup_val`,`sppb_date` FROM `import` WHERE `chrg_rmrk` = 'MCLS' AND `shp_eta` LIKE '%$search%'";
              break;
            default:
              $query = "SELECT `rep_no`,`shp_hawb`,`shp_aju`,`shp_eta`,`sup_inv_no`,`sup_curr`,`sup_val`,`sppb_date` FROM `import` WHERE `chrg_rmrk` = 'MCLS' AND `shp_hawb` = '$search'";
            break;
          }
        } elseif ($searchIn == "Chemical - Export") {
          switch ($searchBy) {
            case "hawb":
              $query = "SELECT `rep_no`,`shp_hawb`,`shp_aju`,`shp_eta`,`inv_no`,`inv_curr`,`inv_val`,`npe_date` FROM `export` WHERE `chrg_rmrk` = 'MCLS' AND `shp_hawb` = '$search'";
              break;
            case "mawb":
              $query = "SELECT `rep_no`,`shp_hawb`,`shp_aju`,`shp_eta`,`inv_no`,`inv_curr`,`inv_val`,`npe_date` FROM `export` WHERE `chrg_rmrk` = 'MCLS' AND `shp_mawb` = '$search'";
              break;
            case "aju":
              $query = "SELECT `rep_no`,`shp_hawb`,`shp_aju`,`shp_eta`,`inv_no`,`inv_curr`,`inv_val`,`npe_date` FROM `export` WHERE `chrg_rmrk` = 'MCLS' AND `shp_aju` = '$search'";
              break;
            case "inv":
              $query = "SELECT `rep_no`,`shp_hawb`,`shp_aju`,`shp_eta`,`inv_no`,`inv_curr`,`inv_val`,`npe_date` FROM `export` WHERE `chrg_rmrk` = 'MCLS' AND `inv_no` = '$search'";
              break;
            case "eta":
              $query = "SELECT `rep_no`,`shp_hawb`,`shp_aju`,`shp_eta`,`inv_no`,`inv_curr`,`inv_val`,`npe_date` FROM `export` WHERE `chrg_rmrk` = 'MCLS' AND `shp_eta` LIKE '%$search%'";
              break;
            default:
              $query = "SELECT `rep_no`,`shp_hawb`,`shp_aju`,`shp_eta`,`inv_no`,`inv_curr`,`inv_val`,`npe_date` FROM `export` WHERE `chrg_rmrk` = 'MCLS' AND `shp_hawb` = '$search'";
              break;
          }
        } elseif ($searchIn == "Pharma - Import") {
          switch ($searchBy) {
            case "hawb":
              $query = "SELECT `rep_no`,`shp_hawb`,`shp_aju`,`shp_eta`,`sup_inv_no`,`sup_curr`,`sup_val`,`sppb_date` FROM `import` WHERE `chrg_rmrk` = 'BRA' AND `shp_hawb` = '$search'";
              break;
            case "mawb":
              $query = "SELECT `rep_no`,`shp_hawb`,`shp_aju`,`shp_eta`,`sup_inv_no`,`sup_curr`,`sup_val`,`sppb_date` FROM `import` WHERE `chrg_rmrk` = 'BRA' AND `shp_mawb` = '$search'";
              break;
            case "aju":
              $query = "SELECT `rep_no`,`shp_hawb`,`shp_aju`,`shp_eta`,`sup_inv_no`,`sup_curr`,`sup_val`,`sppb_date` FROM `import` WHERE `chrg_rmrk` = 'BRA' AND `shp_aju` = '$search'";
              break;
            case "inv":
              $query = "SELECT `rep_no`,`shp_hawb`,`shp_aju`,`shp_eta`,`sup_inv_no`,`sup_curr`,`sup_val`,`sppb_date` FROM `import` WHERE `chrg_rmrk` = 'BRA' AND `sup_inv_no` = '$search'";
              break;
            case "eta":
              $query = "SELECT `rep_no`,`shp_hawb`,`shp_aju`,`shp_eta`,`sup_inv_no`,`sup_curr`,`sup_val`,`sppb_date` FROM `import` WHERE `chrg_rmrk` = 'BRA' AND `shp_eta` LIKE '%$search%'";
              break;
            default:
              $query = "SELECT `rep_no`,`shp_hawb`,`shp_aju`,`shp_eta`,`sup_inv_no`,`sup_curr`,`sup_val`,`sppb_date` FROM `import` WHERE `chrg_rmrk` = 'BRA' AND `shp_hawb` = '$search'";
              break;
          }
        } else {
          switch ($searchBy) {
            case "hawb":
              $query = "SELECT `rep_no`,`shp_hawb`,`shp_aju`,`shp_eta`,`inv_no`,`inv_curr`,`inv_val`,`npe_date` FROM `export` WHERE `chrg_rmrk` = 'BRA' AND `shp_hawb` = '$search'";
              break;
            case "mawb":
              $query = "SELECT `rep_no`,`shp_hawb`,`shp_aju`,`shp_eta`,`inv_no`,`inv_curr`,`inv_val`,`npe_date` FROM `export` WHERE `chrg_rmrk` = 'BRA' AND `shp_mawb` = '$search'";
              break;
            case "aju":
              $query = "SELECT `rep_no`,`shp_hawb`,`shp_aju`,`shp_eta`,`inv_no`,`inv_curr`,`inv_val`,`npe_date` FROM `export` WHERE `chrg_rmrk` = 'BRA' AND `shp_aju` = '$search'";
              break;
            case "inv":
              $query = "SELECT `rep_no`,`shp_hawb`,`shp_aju`,`shp_eta`,`inv_no`,`inv_curr`,`inv_val`,`npe_date` FROM `export` WHERE `chrg_rmrk` = 'BRA' AND `inv_no` = '$search'";
              break;
            case "eta":
              $query = "SELECT `rep_no`,`shp_hawb`,`shp_aju`,`shp_eta`,`inv_no`,`inv_curr`,`inv_val`,`npe_date` FROM `export` WHERE `chrg_rmrk` = 'BRA' AND `shp_eta` LIKE '%$search%'";
              break;
            default:
              $query = "SELECT `rep_no`,`shp_hawb`,`shp_aju`,`shp_eta`,`inv_no`,`inv_curr`,`inv_val`,`npe_date` FROM `export` WHERE `chrg_rmrk` = 'BRA' AND `shp_hawb` = '$search'";
              break;
          }
        }
        if ($userData['user_auth'] == "(3rd)Speedmark"){
          $query .= " AND `cstm_brkr` = 'Speedmark'";
        }
        $srcRes = $conn->query($query);
        $srcResSum = mysqli_num_rows($srcRes);
      } else {
        // Table State
        $tableState = "show";
        // Current Date
        $today = date('Y-m-d');
        // Import Chemicals
        // -- Query
        $impChemQ = "SELECT DATEDIFF(`shp_eta`,'$today') AS `diff`,`rep_no`,`shp_hawb`,`shp_aju`,`shp_eta`,`sup_inv_no`,`sup_curr`,`sup_val` FROM `import` WHERE `chrg_rmrk` = 'MCLS' AND `sppb_date` = '0000-00-00'";
        if($userData['user_auth'] == "(3rd)Speedmark"){
          $impChemQ .= " AND `cstm_brkr` = 'Speedmark'";
        }
        $impChemQ .= " ORDER BY `diff` ASC";
        $impChem = $conn->query($impChemQ);
        $impChemSum = mysqli_num_rows($impChem);
        // Import Pharma
        // -- Query
        $impPharQ = "SELECT DATEDIFF(`shp_eta`,'$today') AS `diff`,`rep_no`,`shp_hawb`,`shp_aju`,`shp_eta`,`sup_inv_no`,`sup_curr`,`sup_val` FROM `import` WHERE `chrg_rmrk` = 'BRA' AND `sppb_date` = '0000-00-00'";
        if($userData['user_auth'] == "(3rd)Speedmark"){
          $impPharQ .= " AND `cstm_brkr` = 'Speedmark'";
        }
        $impPharQ .= " ORDER BY `diff` ASC";
        $impPhar = $conn->query($impPharQ);
        $impPharSum = mysqli_num_rows($impPhar);
        // Export Chemicals
        // -- Query
        $expChemQ = "SELECT DATEDIFF(`shp_eta`,'$today') AS `diff`,`rep_no`,`shp_hawb`,`shp_aju`,`shp_eta`,`inv_no`,`inv_curr`,`inv_val` FROM `export` WHERE `chrg_rmrk` = 'MCLS' AND `npe_date` = '0000-00-00'";
        if($userData['user_auth'] == "(3rd)Speedmark"){
          $expChemQ .= " AND `cstm_brkr` = 'Speedmark'";
        }
        $expChemQ .= " ORDER BY `diff` ASC";
        $expChem = $conn->query($expChemQ);
        $expChemSum = mysqli_num_rows($expChem);
        // Export Pharma
        $expPharQ = "SELECT DATEDIFF(`shp_eta`,'$today') AS `diff`,`rep_no`,`shp_hawb`,`shp_aju`,`shp_eta`,`inv_no`,`inv_curr`,`inv_val` FROM `export` WHERE `chrg_rmrk` = 'BRA' AND `npe_date` = '0000-00-00'";
        if($userData['user_auth'] == "(3rd)Speedmark"){
          $expPharQ .= " AND `cstm_brkr` = 'Speedmark'";
        }
        $expPharQ .= " ORDER BY `diff` ASC";
        $expPhar = $conn->query($expPharQ);
        $expPharSum = mysqli_num_rows($expPhar);
      }

    // Unset Search State
    if (isset($_GET["unset-search"])){
        $tableState = $_GET["unset-search"];
        
    }

    // Add New Report
    if (isset($_GET["add-report"])){
      $submitState = "add";
      list($formState, $secState) = explode("/", $_GET["add-report"]);
      // $formState = $_GET["add-report"];
      $busSector = $formState;
    }

    // Delete File
    if (isset($_GET["delete-file"])){
      list($fileRep, $fileHawb, $fileName, $fileSec) = explode('/', $_GET["delete-file"]);
      $path = "uploads/".$fileName;
      if (!unlink($path)) {
        // Message
        call_msg("error", "Delete file failed, something's not right");
      } else {
        $sql = $conn->query("DELETE FROM `files` WHERE `file_name` = '$fileName' AND `file_hawb` = '$fileHawb'");
        // Message
        call_msg("success", "File deleted successfully!");
      }
      // Redirect
      red_selected($fileSec, $fileRep);
    }

    // --- Import Action ---
    // Input
    if (isset($_POST['submit-import'])){
        
        // User Value
        $crtdBy = $_POST['crt_by'];
        // Time Value
        $crtdTime = date("Y-m-d H:i:s");
        // Shipping Value
        $shpMawb = addslashes($_POST['shp_mawb']);
        $shpHawb = addslashes($_POST['shp_hawb']);
        $shpAfsf = addslashes($_POST['shp_afsf']);
        $shpFlve = addslashes($_POST['shp_flve']);
        $shpShpr = addslashes($_POST['shp_shpr']);
        $shpAju = addslashes($_POST['shp_aju']);
        $shpQty = convNullNum($_POST['shp_qty']);
        $shpPkgs = convNullNum($_POST['shp_pkgs']);
        $shpWght = convNullNum($_POST['shp_wght']);
        $shpCbm = convNullNum($_POST['shp_cbm']);
        $shpFwdr = addslashes($_POST['shp_fwdr']);
        $shpLcl = addslashes($_POST['shp_lcl']);
        $shpEtd = convNullDate($_POST['shp_etd']);
        $shpEta = convNullDate($_POST['shp_eta']);
        $shpArrDate = convNullDate($_POST['shp_arr_date']);
        $shpArrDay = addslashes($_POST['shp_arr_day']);
        $shpNoa = convNullDate($_POST['shp_noa']);
        $shpApp = convNullDate($_POST['shp_app']);
        $shpPde = convNullDate($_POST['shp_pde']);
        // License Value
        $lcsReq = addslashes($_POST['lcs_req']);
        $lcsBpom = convNullDate($_POST['lcs_bpom']);
        $lcsCoo = convNullDate($_POST['lcs_coo']);
        $lcsKh = convNullDate($_POST['lcs_kh']);
        $lcsCompDoc = convNullDate($_POST['lcs_comp_doc']);
        $lcsComp = convNullDate($_POST['lcs_comp']);
        // PIB Value
        $pibIssd = convNullDate($_POST['pib_issd']);
        $pibConf = convNullDate($_POST['pib_conf']);
        $pibRmrk = addslashes($_POST['pib_rmrk']);
        $pibBill = convNullDate($_POST['pib_bill']);
        $pibPaid = convNullDate($_POST['pib_paid']);
        $pibTrf = convNullDate($_POST['pib_trf']);
        // -- SKEP
        $skepDate = convNullDate($_POST['skep_date']);
        $skepRmrk = addslashes($_POST['skep_rmrk']);
        // -- Inspection
        $inspDate = convNullDate($_POST['insp_date']);
        $inspRsn = addslashes($_POST['insp_rsn']);
        // -- Supplier
        $supOrdr = addslashes($_POST['sup_ordr']);
        $supInvNo = addslashes($_POST['sup_inv_no']);
        $supInvDate = convNullDate($_POST['sup_inv_date']);
        $supCurr = addslashes($_POST['sup_curr']);
        $supVal = convNullNum($_POST['sup_val']);
        $supFrgt = convNullNum($_POST['sup_frgt']);
        $supTot = convNullNum($_POST['sup_tot']);
        $supColl = addslashes($_POST['sup_coll']);
        // -- SPPB
        $sppbDate = convNullDate($_POST['sppb_date']);
        // -- Release
        $rlsDlv = convNullDate($_POST['rls_dlv']);
        $rlsGrn = convNullDate($_POST['rls_grn']);
        $rlsClrLt = convNullNum($_POST['rls_clr_lt']);
        $rlsDlvLt = convNullNum($_POST['rls_dlv_lt']);
        $rlsGrnLt = convNullNum($_POST['rls_grn_lt']);
        // -- Custom Brokerages
        $cstmBrkr = addslashes($_POST['cstm_brkr']);
        $cstmInvNo = addslashes($_POST['cstm_inv_no']);
        $cstmRcvd = addslashes($_POST['cstm_rcvd']);
        // -- Storage
        $strgIn = convNullDate($_POST['strg_in']);
        $strgOut = convNullDate($_POST['strg_out']);
        $strgDays = convNullNum($_POST['strg_days']);
        // -- Valuation
        $valDate = convNullDate($_POST['val_date']);
        $valRmrk = addslashes($_POST['val_rmrk']);
        // -- Charges
        $chrgFrgt = convNullNum($_POST['chrg_frgt']);
        $chrgImpr = convNullNum($_POST['chrg_impr']);
        $chrgBm = convNullNum($_POST['chrg_bm']);
        $chrgDuty = convNullNum($_POST['chrg_duty']);
        $chrgWh = convNullNum($_POST['chrg_wh']);
        $chrgVat = convNullNum($_POST['chrg_vat']);
        $chrgStrg = convNullNum($_POST['chrg_strg']);
        $chrgDlv = convNullNum($_POST['chrg_dlv']);
        $chrgOthr = convNullNum($_POST['chrg_othr']);
        $chrgWoTax = convNullNum($_POST['chrg_wo_tax']);
        $chrgPBm = convNullNum($_POST['chrg_p_bm']);
        $chrgPTot = convNullNum($_POST['chrg_p_tot']);
        $chrgRmrk = addslashes($_POST['chrg_rmrk']);
        // -- Historical Background
        $histBg = addslashes($_POST['hist_bg']);
        
        $sql = "INSERT into `import`
        (`rep_crt_time`,
        `rep_crt_by`,
        `rep_mod_time`,
        `rep_mod_by`,
        `shp_mawb`,
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
        ('$crtdTime',
        '$crtdBy',
        '$crtdTime',
        '$crtdBy',
        '$shpMawb',
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
        '$cstmRcvd',
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
        
        // Execute query
        $exist_q = $conn->query("SELECT `shp_hawb` FROM `import` WHERE `shp_hawb` = '$shpHawb'");
        if ($exist_q->num_rows == 0){
            $input_q = $conn->query($sql);
            if (!$input_q) {
              // Message
              call_msg("error", "Create new report failed, something's not right.");
              // Redirect
              red_add("import");
            } else {
              // Fetching report number
              $red_q = $conn->query("SELECT `rep_no` FROM `import` WHERE `shp_hawb` = '$shpHawb'");
              $red_result = $red_q -> fetch_assoc();
              $red_no = $red_result['rep_no'];
              // Message
              call_msg("success", "New report created successfully!");
              // Redirect
              red_selected("import", $red_no);
            }
        } else {
          // Message
          call_msg("warning", "HAWB already exist, cannot create report with the same HAWB.");
          // Redirect
          red_add("import");
        }
        
    }
    // Select
    if (isset($_GET["select-import"])) {
      $repNo = $_GET["select-import"];
      $formState = "import";
      $submitState = "edit";
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
    // Update
    if (isset($_POST['update-import'])) {
      // Report Number
      $repNo = $_POST['rep_no'];
      // Modified By
      $modBy = $_POST['crt_by'];
      // Modified Time
      $modTime = date("Y-m-d H:i:s");
      // Shipping Value
      $shpMawb = addslashes($_POST['shp_mawb']);
      $shpHawb = addslashes($_POST['shp_hawb']);
      $shpAfsf = addslashes($_POST['shp_afsf']);
      $shpFlve = addslashes($_POST['shp_flve']);
      $shpShpr = addslashes($_POST['shp_shpr']);
      $shpAju = addslashes($_POST['shp_aju']);
      $shpQty = convNullNum($_POST['shp_qty']);
      $shpPkgs = convNullNum($_POST['shp_pkgs']);
      $shpWght = convNullNum($_POST['shp_wght']);
      $shpCbm = convNullNum($_POST['shp_cbm']);
      $shpFwdr = addslashes($_POST['shp_fwdr']);
      $shpLcl = addslashes($_POST['shp_lcl']);
      $shpEtd = convNullDate($_POST['shp_etd']);
      $shpEta = convNullDate($_POST['shp_eta']);
      $shpArrDate = convNullDate($_POST['shp_arr_date']);
      $shpArrDay = addslashes($_POST['shp_arr_day']);
      $shpNoa = convNullDate($_POST['shp_noa']);
      $shpApp = convNullDate($_POST['shp_app']);
      $shpPde = convNullDate($_POST['shp_pde']);
      // License Value
      $lcsReq = addslashes($_POST['lcs_req']);
      $lcsBpom = convNullDate($_POST['lcs_bpom']);
      $lcsCoo = convNullDate($_POST['lcs_coo']);
      $lcsKh = convNullDate($_POST['lcs_kh']);
      $lcsCompDoc = convNullDate($_POST['lcs_comp_doc']);
      $lcsComp = convNullDate($_POST['lcs_comp']);
      // PIB Value
      $pibIssd = convNullDate($_POST['pib_issd']);
      $pibConf = convNullDate($_POST['pib_conf']);
      $pibRmrk = addslashes($_POST['pib_rmrk']);
      $pibBill = convNullDate($_POST['pib_bill']);
      $pibPaid = convNullDate($_POST['pib_paid']);
      $pibTrf = convNullDate($_POST['pib_trf']);
      // -- SKEP
      $skepDate = convNullDate($_POST['skep_date']);
      $skepRmrk = addslashes($_POST['skep_rmrk']);
      // -- Inspection
      $inspDate = convNullDate($_POST['insp_date']);
      $inspRsn = addslashes($_POST['insp_rsn']);
      // -- Supplier
      $supOrdr = addslashes($_POST['sup_ordr']);
      $supInvNo = addslashes($_POST['sup_inv_no']);
      $supInvDate = convNullDate($_POST['sup_inv_date']);
      $supCurr = addslashes($_POST['sup_curr']);
      $supVal = convNullNum($_POST['sup_val']);
      $supFrgt = convNullNum($_POST['sup_frgt']);
      $supTot = convNullNum($_POST['sup_tot']);
      $supColl = addslashes($_POST['sup_coll']);
      // -- SPPB
      $sppbDate = convNullDate($_POST['sppb_date']);
      // -- Release
      $rlsDlv = convNullDate($_POST['rls_dlv']);
      $rlsGrn = convNullDate($_POST['rls_grn']);
      $rlsClrLt = convNullNum($_POST['rls_clr_lt']);
      $rlsDlvLt = convNullNum($_POST['rls_dlv_lt']);
      $rlsGrnLt = convNullNum($_POST['rls_grn_lt']);
      // -- Custom Brokerages
      $cstmBrkr = addslashes($_POST['cstm_brkr']);
      $cstmInvNo = addslashes($_POST['cstm_inv_no']);
      $cstmRcvd = addslashes($_POST['cstm_rcvd']);
      // -- Storage
      $strgIn = convNullDate($_POST['strg_in']);
      $strgOut = convNullDate($_POST['strg_out']);
      $strgDays = convNullNum($_POST['strg_days']);
      // -- Valuation
      $valDate = convNullDate($_POST['val_date']);
      $valRmrk = addslashes($_POST['val_rmrk']);
      // -- Charges
      $chrgFrgt = convNullNum($_POST['chrg_frgt']);
      $chrgImpr = convNullNum($_POST['chrg_impr']);
      $chrgBm = convNullNum($_POST['chrg_bm']);
      $chrgDuty = convNullNum($_POST['chrg_duty']);
      $chrgWh = convNullNum($_POST['chrg_wh']);
      $chrgVat = convNullNum($_POST['chrg_vat']);
      $chrgStrg = convNullNum($_POST['chrg_strg']);
      $chrgDlv = convNullNum($_POST['chrg_dlv']);
      $chrgOthr = convNullNum($_POST['chrg_othr']);
      $chrgWoTax = convNullNum($_POST['chrg_wo_tax']);
      $chrgPBm = convNullNum($_POST['chrg_p_bm']);
      $chrgPTot = convNullNum($_POST['chrg_p_tot']);
      $chrgRmrk = addslashes($_POST['chrg_rmrk']);
      // -- Historical Background
      $histBg = addslashes($_POST['hist_bg']);
        
      // Query
      $sql = "UPDATE `import`
      SET
      `rep_mod_time` = '$modTime',
      `rep_mod_by`= '$modBy',
      `shp_mawb`= '$shpMawb',
      `shp_afsf`= '$shpAfsf',
      `shp_flve`= '$shpFlve',
      `shp_shpr`= '$shpShpr',
      `shp_aju`= '$shpAju',
      `shp_qty`= '$shpQty',
      `shp_pkgs`= '$shpPkgs',
      `shp_wght`= '$shpWght',
      `shp_cbm`= '$shpCbm',
      `shp_fwdr`= '$shpFwdr',
      `shp_lcl`= '$shpLcl',
      `shp_etd`= '$shpEtd',
      `shp_eta`= '$shpEta',
      `shp_arr_date`= '$shpArrDate',
      `shp_arr_day`= '$shpArrDay',
      `shp_noa`= '$shpNoa',
      `shp_app`= '$shpApp',
      `shp_pde`= '$shpPde',
      `lcs_req`= '$lcsReq',
      `lcs_bpom`= '$lcsBpom',
      `lcs_coo`= '$lcsCoo',
      `lcs_kh`= '$lcsKh',
      `lcs_comp_doc`= '$lcsCompDoc',
      `lcs_comp`= '$lcsComp',
      `pib_issd`= '$pibIssd',
      `pib_conf`= '$pibConf',
      `pib_rmrk`= '$pibRmrk',
      `pib_bill`= '$pibBill',
      `pib_paid`= '$pibPaid',
      `pib_trf`= '$pibTrf',
      `skep_date`= '$skepDate',
      `skep_rmrk`= '$skepRmrk',
      `insp_date`= '$inspDate',
      `insp_rsn`= '$inspRsn',
      `sup_ordr`= '$supOrdr',
      `sup_inv_no`= '$supInvNo',
      `sup_inv_date`= '$supInvDate',
      `sup_curr`= '$supCurr',
      `sup_val`= '$supVal',
      `sup_frgt`= '$supFrgt',
      `sup_tot`= '$supTot',
      `sup_coll`= '$supColl',
      `sppb_date`= '$sppbDate',
      `rls_dlv`= '$rlsDlv',
      `rls_grn`= '$rlsGrn',
      `rls_clr_lt`= '$rlsClrLt',
      `rls_dlv_lt`= '$rlsDlvLt',
      `rls_grn_lt`= '$rlsGrnLt',
      `cstm_brkr`= '$cstmBrkr',
      `cstm_inv_no`= '$cstmInvNo',
      `cstm_rcvd`= '$cstmRcvd',
      `strg_in`= '$strgIn',
      `strg_out`= '$strgOut',
      `strg_days`= '$strgDays',
      `val_date`= '$valDate',
      `val_rmrk`= '$valRmrk',
      `chrg_frgt`= '$chrgFrgt', 
      `chrg_impr`= '$chrgImpr', 
      `chrg_bm`= '$chrgBm', 
      `chrg_duty`= '$chrgDuty', 
      `chrg_wh`= '$chrgWh', 
      `chrg_vat`= '$chrgVat', 
      `chrg_strg`= '$chrgStrg', 
      `chrg_dlv`= '$chrgDlv', 
      `chrg_othr`= '$chrgOthr', 
      `chrg_wo_tax`= '$chrgWoTax', 
      `chrg_p_bm`= '$chrgPBm', 
      `chrg_p_tot`= '$chrgPTot', 
      `chrg_rmrk`= '$chrgRmrk',
      `hist_bg`= '$histBg' 
      WHERE
      `rep_no` = $repNo ";
      
      // Execute query
      $update_q = $conn->query($sql);
      if (!$update_q) {
        // Message
        call_msg("error", "Update report failed, something's not right.");
      } else {
        // Message
        call_msg("success", "Report updated successfully!");
      }
      
      // Redirect
      red_selected("import", $repNo);
    }
    // Delete
    if (isset($_GET['delete-import'])) {
      $repNo = $_GET['delete-import'];
      // Fetching report hawb
      $sql = $conn->query("SELECT `shp_hawb` FROM `import` WHERE `rep_no` = $repNo");
      $rep_key = $sql->fetch_array();
      $rep_hawb = $rep_key['shp_hawb'];
      // Check if files still exist
      $exist_q = $conn->query("SELECT * FROM `files` WHERE `file_hawb` = '$rep_hawb'");
      if ($exist_q->num_rows > 0){
        // Message
        call_msg("warning", "Please delete all attached files before deleting the report");
        // Redirect
        red_selected("import", $repNo);
      } else {
        $delete_q = $conn->query("DELETE FROM `import` WHERE `rep_no` = $repNo");
        if (!$delete_q) {
          // Message
          call_msg("error", "Delete report failed, something's not right");
        } else {
          // Message
          call_msg("success", "Report deleted successfully");
        }
        // Redirect
        red_input();
      }
    }

    // --- Export Action ---
    // Input
    if (isset($_POST['submit-export'])){
   
        // User Value
        $crtdBy = $_POST['crt_by'];
        // Time Value
        $crtdTime = date("Y-m-d H:i:s");
        // Shipping Value
        $shpMawb = addslashes($_POST['shp_mawb']);
        $shpHawb = addslashes($_POST['shp_hawb']);
        $shpAfsf = addslashes($_POST['shp_afsf']);
        $shpFlve = addslashes($_POST['shp_flve']);
        $shpCons = addslashes($_POST['shp_cons']);
        $shpAju = addslashes($_POST['shp_aju']);
        $shpQty = convNullNum($_POST['shp_qty']);
        $shpPkgs = convNullNum($_POST['shp_pkgs']);
        $shpWght = convNullNum($_POST['shp_wght']);
        $shpCbm = convNullNum($_POST['shp_cbm']);
        $shpFwdr = addslashes($_POST['shp_fwdr']);
        $shpLcl = addslashes($_POST['shp_lcl']);
        $shpPick = convNullDate($_POST['shp_pick']);
        $shpEtd = convNullDate($_POST['shp_etd']);
        $shpEta = convNullDate($_POST['shp_eta']);
        $shpArrDate = convNullDate($_POST['shp_arr_date']);
        $shpArrDay = addslashes($_POST['shp_arr_day']);
        // Licenses Value
        $lcsReq = addslashes($_POST['lcs_req']);
        $lcsBpom = convNullDate($_POST['lcs_bpom']);
        $lcsCoo = convNullDate($_POST['lcs_coo']);
        $lcsCompDoc = convNullDate($_POST['lcs_comp_doc']);
        $lcsComp = convNullDate($_POST['lcs_comp']);
        // PEB Value
        $pebIssd = convNullDate($_POST['peb_issd']);
        $pebConf = convNullDate($_POST['peb_conf']);
        $pebRmrk = addslashes($_POST['peb_rmrk']);
        $pebTrf = convNullDate($_POST['peb_trf']);
        // SKEP Value
        $skepDate = convNullDate($_POST['skep_date']);
        $skepRmrk = addslashes($_POST['skep_rmrk']);
        // Inspection Value
        $inspDate = convNullDate($_POST['insp_date']);
        $inspRsn = addslashes($_POST['insp_rsn']);
        // Invoice Value
        $invOrdr = addslashes($_POST['inv_ordr']);
        $invNo = addslashes($_POST['inv_no']);
        $invDate = convNullDate($_POST['inv_date']);
        $invCurr = addslashes($_POST['inv_curr']);
        $invVal = convNullNum($_POST['inv_val']);
        $invFrgt = convNullNum($_POST['inv_frgt']);
        $invTot = convNullNum($_POST['inv_tot']);
        $invColl = addslashes($_POST['inv_coll']);
        // NPE Value
        $npeDate = convNullDate($_POST['npe_date']);
        // Recieved Value
        $rcvdDlv = convNullDate($_POST['rcvd_dlv']);
        $rcvdGrn = convNullDate($_POST['rcvd_grn']);
        $rcvdClrLt = convNullNum($_POST['rcvd_clr_lt']);
        $rcvdDlvLt = convNullNum($_POST['rcvd_dlv_lt']);
        $rcvdGrnLt = convNullNum($_POST['rcvd_grn_lt']);
        // Customs Value
        $cstmBrkr = addslashes($_POST['cstm_brkr']);
        $cstmInvNo = addslashes($_POST['cstm_inv_no']);
        $cstmRcvd = addslashes($_POST['cstm_rcvd']);
        // Storage Value
        $strgIn = convNullDate($_POST['strg_in']);
        $strgOut = convNullDate($_POST['strg_out']);
        $strgDays = convNullNum($_POST['strg_days']);
        // Valuation Value
        $valDate = convNullDate($_POST['val_date']);
        $valRmrk = addslashes($_POST['val_rmrk']);
        // Charges Value
        $chrgFrgt = convNullNum($_POST['chrg_frgt']);
        $chrgStrg = convNullNum($_POST['chrg_strg']);
        $chrgOthr = convNullNum($_POST['chrg_othr']);
        $chrgTot = convNullNum($_POST['chrg_tot']);
        $chrgRmrk = addslashes($_POST['chrg_rmrk']);
        // Historical Value
        $histBg = addslashes($_POST['hist_bg']);
        
        // Query
        $sql = "INSERT into `export`
        (`rep_crt_time`,
        `rep_crt_by`,
        `rep_mod_time`,
        `rep_mod_by`,
        `shp_mawb`,
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
        ('$crtdTime',
        '$crtdBy',
        '$crtdTime',
        '$crtdBy',
        '$shpMawb',
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
        
        // Execute query
        $exist_q = $conn->query("SELECT `shp_hawb` FROM `export` WHERE `shp_hawb` = '$shpHawb'");
        if ($exist_q->num_rows == 0){
            $input_q = $conn->query($sql);
            if (!$input_q) {
              // Message
              call_msg("error", "Create new report failed, something's not right.");
              // Redirect
              red_add("export");
            } else {
              // Fetching report number
              $red_q = $conn->query("SELECT `rep_no` FROM `export` WHERE `shp_hawb` = '$shpHawb'");
              $red_result = $red_q -> fetch_assoc();
              $red_no = $red_result['rep_no'];
              // Message
              call_msg("success", "New report created successfully!");
              // Redirect
              red_selected("export", $red_no);
            }
        } else {
          // Message
          call_msg("warning", "HAWB already exist, cannot create report with the same HAWB.");
          // Redirect
          red_add("export");
        }
        
    }
    // Select
    if (isset($_GET['select-export'])){
      $repNo = $_GET['select-export'];
      $formState = "export";
      $submitState = "edit";
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
    // Update
    if (isset($_POST['update-export'])){
        
        // Report Number
        $repNo = $_POST['rep_no'];
        // Modified By
        $modBy = $_POST['crt_by'];
        // Modified Time
        $modTime = date("Y-m-d H:i:s");
        // Shipping Value
        $shpMawb = addslashes($_POST['shp_mawb']);
        $shpHawb = addslashes($_POST['shp_hawb']);
        $shpAfsf = addslashes($_POST['shp_afsf']);
        $shpFlve = addslashes($_POST['shp_flve']);
        $shpCons = addslashes($_POST['shp_cons']);
        $shpAju = addslashes($_POST['shp_aju']);
        $shpQty = convNullNum($_POST['shp_qty']);
        $shpPkgs = convNullNum($_POST['shp_pkgs']);
        $shpWght = convNullNum($_POST['shp_wght']);
        $shpCbm = convNullNum($_POST['shp_cbm']);
        $shpFwdr = addslashes($_POST['shp_fwdr']);
        $shpLcl = addslashes($_POST['shp_lcl']);
        $shpPick = convNullDate($_POST['shp_pick']);
        $shpEtd = convNullDate($_POST['shp_etd']);
        $shpEta = convNullDate($_POST['shp_eta']);
        $shpArrDate = convNullDate($_POST['shp_arr_date']);
        $shpArrDay = addslashes($_POST['shp_arr_day']);
        // Licenses Value
        $lcsReq = addslashes($_POST['lcs_req']);
        $lcsBpom = convNullDate($_POST['lcs_bpom']);
        $lcsCoo = convNullDate($_POST['lcs_coo']);
        $lcsCompDoc = convNullDate($_POST['lcs_comp_doc']);
        $lcsComp = convNullDate($_POST['lcs_comp']);
        // PEB Value
        $pebIssd = convNullDate($_POST['peb_issd']);
        $pebConf = convNullDate($_POST['peb_conf']);
        $pebRmrk = addslashes($_POST['peb_rmrk']);
        $pebTrf = convNullDate($_POST['peb_trf']);
        // SKEP Value
        $skepDate = convNullDate($_POST['skep_date']);
        $skepRmrk = addslashes($_POST['skep_rmrk']);
        // Inspection Value
        $inspDate = convNullDate($_POST['insp_date']);
        $inspRsn = addslashes($_POST['insp_rsn']);
        // Invoice Value
        $invOrdr = addslashes($_POST['inv_ordr']);
        $invNo = addslashes($_POST['inv_no']);
        $invDate = convNullDate($_POST['inv_date']);
        $invCurr = addslashes($_POST['inv_curr']);
        $invVal = convNullNum($_POST['inv_val']);
        $invFrgt = convNullNum($_POST['inv_frgt']);
        $invTot = convNullNum($_POST['inv_tot']);
        $invColl = addslashes($_POST['inv_coll']);
        // NPE Value
        $npeDate = convNullDate($_POST['npe_date']);
        // Recieved Value
        $rcvdDlv = convNullDate($_POST['rcvd_dlv']);
        $rcvdGrn = convNullDate($_POST['rcvd_grn']);
        $rcvdClrLt = convNullNum($_POST['rcvd_clr_lt']);
        $rcvdDlvLt = convNullNum($_POST['rcvd_dlv_lt']);
        $rcvdGrnLt = convNullNum($_POST['rcvd_grn_lt']);
        // Customs Value
        $cstmBrkr = addslashes($_POST['cstm_brkr']);
        $cstmInvNo = addslashes($_POST['cstm_inv_no']);
        $cstmRcvd = addslashes($_POST['cstm_rcvd']);
        // Storage Value
        $strgIn = convNullDate($_POST['strg_in']);
        $strgOut = convNullDate($_POST['strg_out']);
        $strgDays = convNullNum($_POST['strg_days']);
        // Valuation Value
        $valDate = convNullDate($_POST['val_date']);
        $valRmrk = addslashes($_POST['val_rmrk']);
        // Charges Value
        $chrgFrgt = convNullNum($_POST['chrg_frgt']);
        $chrgStrg = convNullNum($_POST['chrg_strg']);
        $chrgOthr = convNullNum($_POST['chrg_othr']);
        $chrgTot = convNullNum($_POST['chrg_tot']);
        $chrgRmrk = addslashes($_POST['chrg_rmrk']);
        // Historical Value
        $histBg = addslashes($_POST['hist_bg']);
      
        // Query
        $sql = "UPDATE `export` SET
        `rep_mod_time`= '$modTime',
        `rep_mod_by`= '$modBy',
        `shp_mawb`= '$shpMawb',
        `shp_afsf`= '$shpAfsf',
        `shp_flve`= '$shpFlve',
        `shp_cons`= '$shpCons',
        `shp_aju`= '$shpAju',
        `shp_qty`= '$shpQty',
        `shp_pkgs`= '$shpPkgs',
        `shp_wght`= '$shpWght',
        `shp_cbm`= '$shpCbm',
        `shp_fwdr`= '$shpFwdr',
        `shp_lcl`= '$shpLcl',
        `shp_pick`= '$shpPick',
        `shp_etd`= '$shpEtd',
        `shp_eta`= '$shpEta',
        `shp_arr_date`= '$shpArrDate',
        `shp_arr_day`= '$shpArrDay',
        `lcs_req`= '$lcsReq',
        `lcs_bpom`= '$lcsBpom',
        `lcs_coo`= '$lcsCoo',
        `lcs_comp_doc`= '$lcsCompDoc',
        `lcs_comp`= '$lcsComp',
        `peb_issd`= '$pebIssd',
        `peb_conf`= '$pebConf',
        `peb_rmrk`= '$pebRmrk',
        `peb_trf`= '$pebTrf',
        `skep_date`= '$skepDate',
        `skep_rmrk`= '$skepRmrk',
        `insp_date`= '$inspDate',
        `insp_rsn`= '$inspRsn',
        `inv_ordr`= '$invOrdr',
        `inv_no`= '$invNo',
        `inv_date`= '$invDate',
        `inv_curr`= '$invCurr',
        `inv_val`= '$invVal',
        `inv_frgt`= '$invFrgt',
        `inv_tot`= '$invTot',
        `inv_coll`= '$invColl',
        `npe_date`= '$npeDate',
        `rcvd_dlv`= '$rcvdDlv',
        `rcvd_grn`= '$rcvdGrn',
        `rcvd_clr_lt`= '$rcvdClrLt',
        `rcvd_dlv_lt`= '$rcvdDlvLt',
        `rcvd_grn_lt`= '$rcvdGrnLt',
        `cstm_brkr`= '$cstmBrkr',
        `cstm_inv_no`= '$cstmInvNo',
        `cstm_rcvd`= '$cstmRcvd',
        `strg_in`= '$strgIn',
        `strg_out`= '$strgOut',
        `strg_days`= '$strgDays',
        `val_date`= '$valDate',
        `val_rmrk`= '$valRmrk',
        `chrg_frgt`= '$chrgFrgt',
        `chrg_strg`= '$chrgStrg',
        `chrg_othr`= '$chrgOthr',
        `chrg_tot`= '$chrgTot',
        `chrg_rmrk`= '$chrgRmrk',
        `hist_bg`= '$histBg'
        WHERE
        `rep_no` = $repNo";
        
        // Execute
        $update_q = $conn->query($sql);
        if (!$update_q) {
          // Message
          call_msg("error", "Update report failed, something's not right.");
        } else {
          // Message
          call_msg("success", "Report updated successfully!");
        }
        
        // Redirect
        red_selected("export", $repNo);
    }
    // Delete
    if (isset($_GET['delete-export'])){
      $repNo = $_GET['delete-export'];
      // Fetching report hawb
      $sql = $conn->query("SELECT `shp_hawb` FROM `export` WHERE `rep_no` = $repNo");
      $rep_key = $sql->fetch_array();
      $rep_hawb = $rep_key['shp_hawb'];
      // Check if files still exist
      $exist_q = $conn->query("SELECT * FROM `files` WHERE `file_hawb` = '$rep_hawb'");
      if ($exist_q->num_rows > 0){
        // Message
        call_msg("warning", "Please delete all attached files before deleting the report");
        // Redirect
        red_selected("export", $repNo);
      } else {
        $delete_q = $conn->query("DELETE FROM `export` WHERE `rep_no` = $repNo");
        if (!$delete_q) {
          // Message
          call_msg("error", "Delete report failed, something's not right");
        } else {
          // Message
          call_msg("success", "Report deleted succesfully");
        }
        // Redirect
        red_input();
      }
      
    }

?>
        