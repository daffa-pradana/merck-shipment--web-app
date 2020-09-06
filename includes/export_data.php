<?php
include 'config.php'; // DB Connection
require 'vendor/autoload.php'; // Require autoload.php from vendor

// Access all classes needed inside PHPSpreadsheet library
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Convert date excel into MySql Date
function convertDate($dateIn){
    if ($dateIn == "0000-00-00"){
        $dateOut = "";
    } else {
        list($y, $m, $d) = explode("-", $dateIn);
        $dateOut = ltrim($m, "0")."/".ltrim($d, "0")."/".$y;
    }
    return $dateOut;
}

// File details
$xFileName = "";
$xFileSize = "";
$xFileDest = "";

// Extract Import Data
if(isset($_GET['extract-import'])){
    
    // Set Query
    $query = $_GET['extract-import'];

    // Create an object with spreadsheet variable
    $spreadsheet = new Spreadsheet();

    // Create sheet variable used as an activesheet in excel file
    $sheet = $spreadsheet->getActiveSheet();
    
    // Create table header
	$sheet->setCellValue('A1', 'No');
	$sheet->setCellValue('B1', 'Shp: MAWB / BL No.');
	$sheet->setCellValue('C1', 'Shp: HAWB');
	$sheet->setCellValue('D1', 'Shp: AF / SF');
	$sheet->setCellValue('E1', 'Shp: Flight no / Vessel');
	$sheet->setCellValue('F1', 'Shp: Shipper');
	$sheet->setCellValue('G1', 'Shp: Aju no');
	$sheet->setCellValue('H1', 'Shp: Qty items');
	$sheet->setCellValue('I1', 'Shp: Total Pkgs');
	$sheet->setCellValue('J1', 'Shp: Total weight (kg)');
	$sheet->setCellValue('K1', 'Shp: Cbm');
	$sheet->setCellValue('L1', 'Shp: Forwarder agent');
	$sheet->setCellValue('M1', 'Shp: LCL');
	$sheet->setCellValue('N1', 'Shp: ETD');
	$sheet->setCellValue('O1', 'Shp: ETA');
	$sheet->setCellValue('P1', 'Shp: ATA');
	$sheet->setCellValue('Q1', 'Shp: Arrival Day');
	$sheet->setCellValue('R1', 'Shp: NOA Received Date');
	$sheet->setCellValue('S1', 'Shp: App Received Date');
	$sheet->setCellValue('T1', 'Shp: BC1.1 AT PDE Manifest');
	$sheet->setCellValue('U1', 'Lcs: Required (from)');
	$sheet->setCellValue('V1', 'Lcs: BPOM Complete Date');
	$sheet->setCellValue('W1', 'Lcs: COO Received Date');
	$sheet->setCellValue('X1', 'Lcs: KH Date');
	$sheet->setCellValue('Y1', 'Lcs: Complete Doc Date');
	$sheet->setCellValue('Z1', 'Lcs: Complete Date');
	$sheet->setCellValue('AA1', 'Pib: Issued');
	$sheet->setCellValue('AB1', 'Pib: Confirm');
	$sheet->setCellValue('AC1', 'Pib: Remarks');
	$sheet->setCellValue('AD1', 'Pib: Billing');
	$sheet->setCellValue('AE1', 'Pib: Paid');
	$sheet->setCellValue('AF1', 'Pib: Transfer');
	$sheet->setCellValue('AG1', 'Skep: Date');
	$sheet->setCellValue('AH1', 'Skep: Remarks');
	$sheet->setCellValue('AI1', 'Insp: Date');
	$sheet->setCellValue('AJ1', 'Insp: Reasons');
	$sheet->setCellValue('AK1', 'Sup: Order no');
	$sheet->setCellValue('AL1', 'Sup: Invoice no');
	$sheet->setCellValue('AM1', 'Sup: Invoice Date');
	$sheet->setCellValue('AN1', 'Sup: Currency');
	$sheet->setCellValue('AO1', 'Sup: Value of goods');
	$sheet->setCellValue('AP1', 'Sup: Freight');
	$sheet->setCellValue('AQ1', 'Sup: Total');
	$sheet->setCellValue('AR1', 'Sup: Collect/Pre');
	$sheet->setCellValue('AS1', 'Sppb: Date');
	$sheet->setCellValue('AT1', 'Rls: Delivery');
	$sheet->setCellValue('AU1', 'Rls: GRN');
	$sheet->setCellValue('AV1', 'Rls: Clearence LT');
	$sheet->setCellValue('AW1', 'Rls: Delivery LT');
	$sheet->setCellValue('AX1', 'Rls: GRN LT');
	$sheet->setCellValue('AY1', 'Cstm: Brokerages agent');
	$sheet->setCellValue('AZ1', 'Cstm: Invoice no');
	$sheet->setCellValue('BA1', 'Cstm: Received');
	$sheet->setCellValue('BB1', 'Strg: In');
	$sheet->setCellValue('BC1', 'Strg: Out');
	$sheet->setCellValue('BD1', 'Strg: Num Days');
	$sheet->setCellValue('BE1', 'Val: Date');
	$sheet->setCellValue('BF1', 'Val: Remarks');
	$sheet->setCellValue('BG1', 'Chrg: Freight cost');
	$sheet->setCellValue('BH1', 'Chrg: Import Duty');
	$sheet->setCellValue('BI1', 'Chrg: BM Duty');
	$sheet->setCellValue('BJ1', 'Chrg: Duty & Tax');
	$sheet->setCellValue('BK1', 'Chrg: WH Tax');
	$sheet->setCellValue('BL1', 'Chrg: VAT');
	$sheet->setCellValue('BM1', 'Chrg: Storage cost');
	$sheet->setCellValue('BN1', 'Chrg: Delivery charges / Local');
	$sheet->setCellValue('BO1', 'Chrg: Others');
	$sheet->setCellValue('BP1', 'Chrg: Total(w/o duty_tax)');
	$sheet->setCellValue('BQ1', 'Chrg: % BM');
	$sheet->setCellValue('BR1', 'Chrg: % Total');
	$sheet->setCellValue('BS1', 'Chrg: Remarks');
    $sheet->setCellValue('BT1', 'Hist: Historical Background');
    
    // Query to select data from database
	$db_data = mysqli_query($conn, $query);
	$i = 2; // Starting cell
	$no = 1; // Index or number

    // Extract data
    while($row = mysqli_fetch_array($db_data)){
        // Store data into excel sheet
        $sheet->setCellValue('A'.$i, $no++);
        $sheet->setCellValue('B'.$i, $row['shp_mawb']);
        $sheet->setCellValue('C'.$i, $row['shp_hawb']);
        $sheet->setCellValue('D'.$i, $row['shp_afsf']);
        $sheet->setCellValue('E'.$i, $row['shp_flve']);
        $sheet->setCellValue('F'.$i, $row['shp_shpr']);
        $sheet->setCellValue('G'.$i, $row['shp_aju']);
        $sheet->setCellValue('H'.$i, $row['shp_qty']);
        $sheet->setCellValue('I'.$i, $row['shp_pkgs']);
        $sheet->setCellValue('J'.$i, $row['shp_wght']);
        $sheet->setCellValue('K'.$i, $row['shp_cbm']);
        $sheet->setCellValue('L'.$i, $row['shp_fwdr']);
        $sheet->setCellValue('M'.$i, $row['shp_lcl']);
        $sheet->setCellValue('N'.$i, convertDate($row['shp_etd']));
        $sheet->setCellValue('O'.$i, convertDate($row['shp_eta']));
        $sheet->setCellValue('P'.$i, convertDate($row['shp_arr_date']));
        $sheet->setCellValue('Q'.$i, $row['shp_arr_day']);
        $sheet->setCellValue('R'.$i, convertDate($row['shp_noa']));
        $sheet->setCellValue('S'.$i, convertDate($row['shp_app']));
        $sheet->setCellValue('T'.$i, convertDate($row['shp_pde']));
        $sheet->setCellValue('U'.$i, $row['lcs_req']);
        $sheet->setCellValue('V'.$i, convertDate($row['lcs_bpom']));
        $sheet->setCellValue('W'.$i, convertDate($row['lcs_coo']));
        $sheet->setCellValue('X'.$i, convertDate($row['lcs_kh']));
        $sheet->setCellValue('Y'.$i, convertDate($row['lcs_comp_doc']));
        $sheet->setCellValue('Z'.$i, convertDate($row['lcs_comp']));
        $sheet->setCellValue('AA'.$i, convertDate($row['pib_issd']));
        $sheet->setCellValue('AB'.$i, convertDate($row['pib_conf']));
        $sheet->setCellValue('AC'.$i, $row['pib_rmrk']);
        $sheet->setCellValue('AD'.$i, convertDate($row['pib_bill']));
        $sheet->setCellValue('AE'.$i, convertDate($row['pib_paid']));
        $sheet->setCellValue('AF'.$i, convertDate($row['pib_trf']));
        $sheet->setCellValue('AG'.$i, convertDate($row['skep_date']));
        $sheet->setCellValue('AH'.$i, $row['skep_rmrk']);
        $sheet->setCellValue('AI'.$i, convertDate($row['insp_date']));
        $sheet->setCellValue('AJ'.$i, $row['insp_rsn']);
        $sheet->setCellValue('AK'.$i, $row['sup_ordr']);
        $sheet->setCellValue('AL'.$i, $row['sup_inv_no']);
        $sheet->setCellValue('AM'.$i, convertDate($row['sup_inv_date']));
        $sheet->setCellValue('AN'.$i, $row['sup_curr']);
        $sheet->setCellValue('AO'.$i, $row['sup_val']);
        $sheet->setCellValue('AP'.$i, $row['sup_frgt']);
        $sheet->setCellValue('AQ'.$i, $row['sup_tot']);
        $sheet->setCellValue('AR'.$i, $row['sup_coll']);
        $sheet->setCellValue('AS'.$i, convertDate($row['sppb_date']));
        $sheet->setCellValue('AT'.$i, convertDate($row['rls_dlv']));
        $sheet->setCellValue('AU'.$i, convertDate($row['rls_grn']));
        $sheet->setCellValue('AV'.$i, $row['rls_clr_lt']);
        $sheet->setCellValue('AW'.$i, $row['rls_dlv_lt']);
        $sheet->setCellValue('AX'.$i, $row['rls_grn_lt']);
        $sheet->setCellValue('AY'.$i, $row['cstm_brkr']);
        $sheet->setCellValue('AZ'.$i, $row['cstm_inv_no']);
        $sheet->setCellValue('BA'.$i, $row['cstm_rcvd']);
        $sheet->setCellValue('BB'.$i, convertDate($row['strg_in']));
        $sheet->setCellValue('BC'.$i, convertDate($row['strg_out']));
        $sheet->setCellValue('BD'.$i, $row['strg_days']);
        $sheet->setCellValue('BE'.$i, convertDate($row['val_date']));
        $sheet->setCellValue('BF'.$i, $row['val_rmrk']);
        $sheet->setCellValue('BG'.$i, $row['chrg_frgt']);
        $sheet->setCellValue('BH'.$i, $row['chrg_impr']);
        $sheet->setCellValue('BI'.$i, $row['chrg_bm']);
        $sheet->setCellValue('BJ'.$i, $row['chrg_duty']);
        $sheet->setCellValue('BK'.$i, $row['chrg_wh']);
        $sheet->setCellValue('BL'.$i, $row['chrg_vat']);
        $sheet->setCellValue('BM'.$i, $row['chrg_strg']);
        $sheet->setCellValue('BN'.$i, $row['chrg_dlv']);
        $sheet->setCellValue('BO'.$i, $row['chrg_othr']);
        $sheet->setCellValue('BP'.$i, $row['chrg_wo_tax']);
        $sheet->setCellValue('BQ'.$i, $row['chrg_p_bm']);
        $sheet->setCellValue('BR'.$i, $row['chrg_p_tot']);
        $sheet->setCellValue('BS'.$i, $row['chrg_rmrk']);
        $sheet->setCellValue('BT'.$i, $row['hist_bg']);
        $i++;
    }
    // Set border style
	$styleArray = [
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
        ],
    ];
    $i = $i - 1;
    $sheet->getStyle('A1:BT'.$i)->applyFromArray($styleArray);

    // Render file into xlsx
    $writer = new Xlsx($spreadsheet);
    $code = date("his");
    $xFileName = 'Exported Data-'.$code.'.xlsx';
    $xFileDest = "uploads/".$xFileName;

    // Save or Export excel file
    $writer->save($xFileDest);
}

// Extract Export Data
if(isset($_GET['extract-export'])){
    
    // Set Query
    $query = $_GET['extract-export'];

    // Create an object with spreadsheet variable
    $spreadsheet = new Spreadsheet();

    // Create sheet variable used as an activesheet in excel file
    $sheet = $spreadsheet->getActiveSheet();
    
    // Create table header
	$sheet->setCellValue('A1', 'No');
	$sheet->setCellValue('B1', 'Shp: MAWB / BL No.');
	$sheet->setCellValue('C1', 'Shp: HAWB');
	$sheet->setCellValue('D1', 'Shp: AF / SF');
	$sheet->setCellValue('E1', 'Shp: Flight no / Vessel');
	$sheet->setCellValue('F1', 'Shp: Consignee');
	$sheet->setCellValue('G1', 'Shp: Aju no');
	$sheet->setCellValue('H1', 'Shp: Qty items');
	$sheet->setCellValue('I1', 'Shp: Total Pkgs');
	$sheet->setCellValue('J1', 'Shp: Total weight (kg)');
	$sheet->setCellValue('K1', 'Shp: Cbm');
	$sheet->setCellValue('L1', 'Shp: Forwarder agent');
	$sheet->setCellValue('M1', 'Shp: LCL');
    $sheet->setCellValue('N1', 'Shp: Stuffing / Pickup');
    $sheet->setCellValue('O1', 'Shp: ETD');
    $sheet->setCellValue('P1', 'Shp: ETA');
    $sheet->setCellValue('Q1', 'Shp: ATA');
    $sheet->setCellValue('R1', 'Shp: Arrival Day');
    $sheet->setCellValue('S1', 'Lcs: Required (from)');
    $sheet->setCellValue('T1', 'Lcs: BPOM Complete Date');
    $sheet->setCellValue('U1', 'Lcs: COO Received Date');
    $sheet->setCellValue('V1', 'Lcs: Complete Doc Date');
    $sheet->setCellValue('W1', 'Lcs: Complete Date');
    $sheet->setCellValue('X1', 'Peb: Issued');
    $sheet->setCellValue('Y1', 'Peb: Confirm');
    $sheet->setCellValue('Z1', 'Peb: Remark');
    $sheet->setCellValue('AA1', 'Peb: Transfer');
    $sheet->setCellValue('AB1', 'Skep: Date');
    $sheet->setCellValue('AC1', 'Skep: Remarks');
    $sheet->setCellValue('AD1', 'Insp: Date');
    $sheet->setCellValue('AE1', 'Insp: Reasons');
    $sheet->setCellValue('AF1', 'Inv: Order no');
    $sheet->setCellValue('AG1', 'Inv: Invoice no');
    $sheet->setCellValue('AH1', 'Inv: Invoice Date');
    $sheet->setCellValue('AI1', 'Inv: Currency');
    $sheet->setCellValue('AJ1', 'Inv: Value of goods');
    $sheet->setCellValue('AK1', 'Inv: Freight');
    $sheet->setCellValue('AL1', 'Inv: Total');
    $sheet->setCellValue('AM1', 'Inv: Collect / Pre');
    $sheet->setCellValue('AN1', 'Npe: Date');
    $sheet->setCellValue('AO1', 'Rcvd: Delivery');
    $sheet->setCellValue('AP1', 'Rcvd: GRN Date');
    $sheet->setCellValue('AQ1', 'Rcvd: Clearence LT');
    $sheet->setCellValue('AR1', 'Rcvd: Delivery LT');
    $sheet->setCellValue('AS1', 'Rcvd: GRN LT');
    $sheet->setCellValue('AT1', 'Cstm: Brokerages agent');
    $sheet->setCellValue('AU1', 'Cstm: Invoice no');
    $sheet->setCellValue('AV1', 'Cstm: Invoice received');
    $sheet->setCellValue('AW1', 'Strg: In');
    $sheet->setCellValue('AX1', 'Strg: Out');
    $sheet->setCellValue('AY1', 'Strg: Num Days');
    $sheet->setCellValue('AZ1', 'Val: Date');
    $sheet->setCellValue('BA1', 'Val: Remarks');
    $sheet->setCellValue('BB1', 'Chrg: Freight Cost');
    $sheet->setCellValue('BC1', 'Chrg: Storage Cost');
    $sheet->setCellValue('BD1', 'Chrg: Others');
    $sheet->setCellValue('BE1', 'Chrg: Total');
    $sheet->setCellValue('BF1', 'Chrg: Remarks');
    $sheet->setCellValue('BG1', 'Hist: Historical Background');
    
    // Query to select data from database
	$db_data = mysqli_query($conn, $query);
	$i = 2; // Starting cell
	$no = 1; // Index or number

    // Extract data
    while($row = mysqli_fetch_array($db_data)){
        // Store data into excel sheet
        $sheet->setCellValue('A'.$i, $no++);
        $sheet->setCellValue('B'.$i, $row['shp_mawb']);
        $sheet->setCellValue('C'.$i, $row['shp_hawb']);
        $sheet->setCellValue('D'.$i, $row['shp_afsf']);
        $sheet->setCellValue('E'.$i, $row['shp_flve']);
        $sheet->setCellValue('F'.$i, $row['shp_cons']);
        $sheet->setCellValue('G'.$i, $row['shp_aju']);
        $sheet->setCellValue('H'.$i, $row['shp_qty']);
        $sheet->setCellValue('I'.$i, $row['shp_pkgs']);
        $sheet->setCellValue('J'.$i, $row['shp_wght']);
        $sheet->setCellValue('K'.$i, $row['shp_cbm']);
        $sheet->setCellValue('L'.$i, $row['shp_fwdr']);
        $sheet->setCellValue('M'.$i, $row['shp_lcl']);
        $sheet->setCellValue('N'.$i, convertDate($row['shp_pick']));
        $sheet->setCellValue('O'.$i, convertDate($row['shp_etd']));
        $sheet->setCellValue('P'.$i, convertDate($row['shp_eta']));
        $sheet->setCellValue('Q'.$i, convertDate($row['shp_arr_date']));
        $sheet->setCellValue('R'.$i, $row['shp_arr_day']);
        $sheet->setCellValue('S'.$i, $row['lcs_req']);
        $sheet->setCellValue('T'.$i, convertDate($row['lcs_bpom']));
        $sheet->setCellValue('U'.$i, convertDate($row['lcs_coo']));
        $sheet->setCellValue('V'.$i, convertDate($row['lcs_comp_doc']));
        $sheet->setCellValue('W'.$i, convertDate($row['lcs_comp']));
        $sheet->setCellValue('X'.$i, convertDate($row['peb_issd']));
        $sheet->setCellValue('Y'.$i, convertDate($row['peb_conf']));
        $sheet->setCellValue('Z'.$i, $row['peb_rmrk']);
        $sheet->setCellValue('AA'.$i, convertDate($row['peb_trf']));
        $sheet->setCellValue('AB'.$i, convertDate($row['skep_date']));
        $sheet->setCellValue('AC'.$i, $row['skep_rmrk']);
        $sheet->setCellValue('AD'.$i, convertDate($row['insp_date']));
        $sheet->setCellValue('AE'.$i, $row['insp_rsn']);
        $sheet->setCellValue('AF'.$i, $row['inv_ordr']);
        $sheet->setCellValue('AG'.$i, $row['inv_no']);
        $sheet->setCellValue('AH'.$i, convertDate($row['inv_date']));
        $sheet->setCellValue('AI'.$i, $row['inv_curr']);
        $sheet->setCellValue('AJ'.$i, $row['inv_val']);
        $sheet->setCellValue('AK'.$i, $row['inv_frgt']);
        $sheet->setCellValue('AL'.$i, $row['inv_tot']);
        $sheet->setCellValue('AM'.$i, $row['inv_coll']);
        $sheet->setCellValue('AN'.$i, convertDate($row['npe_date']));
        $sheet->setCellValue('AO'.$i, convertDate($row['rcvd_dlv']));
        $sheet->setCellValue('AP'.$i, convertDate($row['rcvd_grn']));
        $sheet->setCellValue('AQ'.$i, $row['rcvd_clr_lt']);
        $sheet->setCellValue('AR'.$i, $row['rcvd_dlv_lt']);
        $sheet->setCellValue('AS'.$i, $row['rcvd_grn_lt']);
        $sheet->setCellValue('AT'.$i, $row['cstm_brkr']);
        $sheet->setCellValue('AU'.$i, $row['cstm_inv_no']);
        $sheet->setCellValue('AV'.$i, $row['cstm_rcvd']);
        $sheet->setCellValue('AW'.$i, convertDate($row['strg_in']));
        $sheet->setCellValue('AX'.$i, convertDate($row['strg_out']));
        $sheet->setCellValue('AY'.$i, $row['strg_days']);
        $sheet->setCellValue('AZ'.$i, convertDate($row['val_date']));
        $sheet->setCellValue('BA'.$i, $row['val_rmrk']);
        $sheet->setCellValue('BB'.$i, $row['chrg_frgt']);
        $sheet->setCellValue('BC'.$i, $row['chrg_strg']);
        $sheet->setCellValue('BD'.$i, $row['chrg_othr']);
        $sheet->setCellValue('BE'.$i, $row['chrg_tot']);
        $sheet->setCellValue('BF'.$i, $row['chrg_rmrk']);
        $sheet->setCellValue('BG'.$i, $row['hist_bg']);
        $i++;
    }
    // Set border style
	$styleArray = [
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
        ],
    ];
    $i = $i - 1;
    $sheet->getStyle('A1:BG'.$i)->applyFromArray($styleArray);

    // Render file into xlsx
    $writer = new Xlsx($spreadsheet);
    $code = date("his");
    $xFileName = 'Exported Data-'.$code.'.xlsx';
    $xFileDest = "uploads/".$xFileName;

    // Save or Export excel file
    $writer->save($xFileDest);
}

// Unlink-file
if(isset($_GET['unlink-file'])){
    unlink($_GET['unlink-file']);
    $xFileDest = "";
}
?>