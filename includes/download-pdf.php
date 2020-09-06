<?php
	include 'config.php'; // Connection
    require '../dompdf/autoload.inc.php'; // Require autoload.inc.php
    
    // Access needed class
	use Dompdf\Dompdf; // Use dom pdf
    
    // Convert date format
	function convertPDFDate($dateIn) {
		if ($dateIn == '0000-00-00') {
			$dateOut = '-';
		} else {
			list($y, $m, $d) = explode("-", $dateIn);
        	$dateOut = $d." / ".$m." / ".$y;
		}
		return $dateOut;
	}

    // Execute download as PDF
	if (isset($_GET['download_pdf'])){

        // Create an object with spreadsheet variable
        $dompdf = new Dompdf();

        // Get HAWB Number
        $shp_hawb = $_GET['download_pdf'];
        
        // Generate File Name
        $pdf_name = 'Shipment Summary '.$shp_hawb.'.pdf';

		// Query
		$query = mysqli_query($conn,"SELECT * FROM `import` WHERE `shp_hawb` = '$shp_hawb'");
		if(mysqli_num_rows($query) == 1){
			// Fetch data
			$data = mysqli_fetch_array($query);
			$repNo = $data['rep_no'];
			$shp_flve = $data['shp_flve'];
			$sup_ordr = $data['sup_ordr'];
			$sup_inv_no = $data['sup_inv_no'];
			$shp_shpr = $data['shp_shpr'];
			$shp_pkgs = $data['shp_pkgs'];
			$shp_wght = $data['shp_wght'];
			$shp_eta = convertPDFDate($data['shp_eta']);
			$shp_etd = convertPDFDate($data['shp_etd']);
			$shp_arr_date = convertPDFDate($data['shp_arr_date']);
			$lcs_req = $data['lcs_req'];
			$lcs_bpom = convertPDFDate($data['lcs_bpom']);
			$lcs_comp = convertPDFDate($data['lcs_comp']);
			$pib_issd = convertPDFDate($data['pib_issd']);
			$pib_conf = convertPDFDate($data['pib_conf']);
			$pib_paid = convertPDFDate($data['pib_paid']);
			$skep_date = convertPDFDate($data['skep_date']);
			$pib_trf = convertPDFDate($data['pib_trf']);
			$insp_date = convertPDFDate($data['insp_date']);
			$sppb_date = convertPDFDate($data['sppb_date']);
			$rls_dlv = convertPDFDate($data['rls_dlv']);
        }
		
		//Wrapping HTML for PDF
		ob_start();

		// HTML Document
		$html = '<html>
				<head>
		        	<link rel="stylesheet" type="text/css" media="dompdf" href="../css/pdf_file.css">
		        </head>
		        <body>
				 <div class="container">
					<table class="title">
					    <tr>
					        <td>SHIPMENT FOLLOW UP</td>
					    <tr>
					</table>
					<table class="header font-sm">
						<tr>
							<td class="h-col1 label">BL / AWB</td>
							<td class="h-col2">: '.$shp_hawb.'</td>
							<td class="h-col3"></td>
							<td class="h-col4"></td>
						</tr>
						<tr>
							<td class="h-col1 label">VESSEL / FLIGHT NO</td>
							<td class="h-col2">: '.$shp_flve.'</td>
							<td class="h-col3"></td>
							<td class="h-col4"></td>
						</tr>
						<tr>
							<td class="h-col1 label">PO NO.</td>
							<td class="h-col2">: '.$sup_ordr.'</td>
							<td class="h-col3"></td>
							<td class="h-col4"></td>
						</tr>
						<tr>
							<td class="h-col1 label">FROM</td>
							<td class="h-col2">: '.$shp_shpr.'</td>
							<td class="h-col3"></td>
							<td class="h-col4"></td>
						</tr>
						<tr>
							<td class="h-col1 label">COLLY / WEIGHT</td>
							<td class="h-col2">: '.$shp_pkgs.' Pk / '.$shp_wght.' KGS</td>
							<td class="h-col3"></td>
							<td class="h-col4"></td>
						</tr>
						<tr>
							<td class="h-col1 label">ETA</td>
							<td class="h-col2">: '.$shp_eta.'</td>
							<td class="h-col3"></td>
							<td class="h-col4"></td>
						</tr>
						<tr>
							<td class="h-col1 label">ATA</td>
							<td class="h-col2">: '.$shp_arr_date.'</td>
							<td class="label">ETD</td>
							<td class="h-col4">: '.$shp_etd.'</td>
						</tr>
					</table>
					<table class="body font-sm">
						<tr>
							<td class="b-col1">1</td>
							<td class="b-col2">Send PO</td>
							<td class="b-col3"></td>
						</tr>
						<tr>
							<td class="b-col1">2</td>
							<td class="b-col2">Send Additional Order</td>
							<td class="b-col3"></td>
						</tr>
						<tr>
							<td class="b-col1">3</td>
							<td class="b-col2">Received Order Confirmation</td>
							<td class="b-col3"></td>
						</tr>
						<tr>
							<td class="b-col1">4</td>
							<td class="b-col2">Received NOA from Supplier / Forwarder</td>
							<td class="b-col3"></td>
						</tr>
						<tr>
							<td class="b-col1">5</td>
							<td class="b-col2">Received NOA from Schenker</td>
							<td class="b-col3"></td>
						</tr>
						<tr>
							<td class="b-col1">6</td>
							<td class="b-col2">Received Copy Invoice / Packing List / BL / AWB</td>
							<td class="b-col3"></td>
						</tr>
						<tr>
							<td class="b-col1">7</td>
							<td class="b-col2">Received Original Invoice / Packing List / BL / AWB</td>
							<td class="b-col3"></td>
						</tr>
						<tr>
							<td class="b-col1">8</td>
							<td class="b-col2">COA Prepared</td>
							<td class="b-col3"></td>
						</tr>
						<tr>
							<td class="b-col1">9</td>
							<td class="b-col2">SK Rcvd</td>
							<td class="b-col3"></td>
						</tr>
						<tr>
							<td class="b-col1">10</td>
							<td class="b-col2">Proceed Insurance to Finance</td>
							<td class="b-col3"></td>
						</tr>
						<tr>
							<td class="b-col1">11</td>
							<td class="b-col2">Received Insurance from Finance</td>
							<td class="b-col3"></td>
						</tr>
						<tr>
							<td class="b-col1">12</td>
							<td class="b-col2">Received Local Permit from Marketing</td>
							<td class="b-col3"></td>
						</tr>
						<tr>
							<td class="b-col1">13</td>
							<td class="b-col2">Permits required :</td>
							<td class="b-col3">'.$lcs_req.'</td>
						</tr>
						<tr>
							<td class="b-col1"></td>
							<td class="b-col2">Apply</td>
							<td class="b-col3"></td>
						</tr>
						<tr>
							<td class="b-col1"></td>
							<td class="b-col2">BPOM Complete Date</td>
							<td class="b-col3">'.$lcs_bpom.'</td>
						</tr>
						<tr>
							<td class="b-col1"></td>
							<td class="b-col2">License Complete Date</td>
							<td class="b-col3">'.$lcs_comp.'</td>
						</tr>
						<tr>
							<td class="b-col1">14</td>
							<td class="b-col2">Hand over original docs to Schenker</td>
							<td class="b-col3"></td>
						</tr>
						<tr>
							<td class="b-col1"></td>
							<td class="b-col2">Original BL / AWB</td>
							<td class="b-col3"></td>
						</tr>
						<tr>
							<td class="b-col1"></td>
							<td class="b-col2">Original Invoice</td>
							<td class="b-col3"></td>
						</tr>
						<tr>
							<td class="b-col1"></td>
							<td class="b-col2">Original Packing List</td>
							<td class="b-col3"></td>
						</tr>
						<tr>
							<td class="b-col1"></td>
							<td class="b-col2">COA + MSDS</td>
							<td class="b-col3"></td>
						</tr>
						<tr>
							<td class="b-col1"></td>
							<td class="b-col2">Insurance</td>
							<td class="b-col3"></td>
						</tr>
						<tr>
							<td class="b-col1"></td>
							<td class="b-col2">Permits</td>
							<td class="b-col3"></td>
						</tr>
						<tr>
							<td class="b-col1">15</td>
							<td class="b-col2">Hand over original docs to WH</td>
							<td class="b-col3"></td>
						</tr>
						<tr>
							<td class="b-col1">16</td>
							<td class="b-col2">Hand over original docs to QC / QA</td>
							<td class="b-col3"></td>
						</tr>
						<tr>
							<td class="b-col1">17</td>
							<td class="b-col2">PIB Issued</td>
							<td class="b-col3">'.$pib_issd.'</td>
						</tr>
						<tr>
							<td class="b-col1">18</td>
							<td class="b-col2">PIB Confirmed</td>
							<td class="b-col3">'.$pib_conf.'</td>
						</tr>
						<tr>
							<td class="b-col1">19</td>
							<td class="b-col2">Duty Paid / BPN</td>
							<td class="b-col3">'.$pib_paid.'</td>
						</tr>
						<tr>
							<td class="b-col1">20</td>
							<td class="b-col2">SKEP Barang Larangan</td>
							<td class="b-col3">'.$skep_date.'</td>
						</tr>
						<tr>
							<td class="b-col1">21</td>
							<td class="b-col2">PIB Transfer</td>
							<td class="b-col3">'.$pib_trf.'</td>
						</tr>
						<tr>
							<td class="b-col1">22</td>
							<td class="b-col2">Inspection</td>
							<td class="b-col3">'.$insp_date.'</td>
						</tr>
						<tr>
							<td class="b-col1">23</td>
							<td class="b-col2">SPPB</td>
							<td class="b-col3">'.$sppb_date.'</td>
						</tr>
						<tr>
							<td class="b-col1">24</td>
							<td class="b-col2">Delivery to Warehouse</td>
							<td class="b-col3">'.$rls_dlv.'</td>
						</tr>
					</table>
					<br>
					<div class="note"><span>INV# '.$sup_inv_no.'</span></div>
                 </div>
                </body>
				</html>';
		$dompdf->loadHtml($html);
        
		// Set size and orientation
        $dompdf->setPaper('A4', 'potrait');
        
		// Render HTML to PDF
        $dompdf->render();

        // Clean output Buffer
        ob_end_clean();

		// PDF File output
		$dompdf->stream($pdf_name);
		
		// Redirect
		red_selected("import", $repNo);
	}
?>