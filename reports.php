<?php $page = "reports"; //Set page?>
<?php include 'includes/header.php'; //Header ?>
<?php include 'includes/config.php'; //Config ?>
<?php include 'includes/reports-action.php'; //Action?>
<?php include 'includes/export_data.php'; //Export Data?>
<?php include 'includes/duedate.php'; //Duedate Func?>
<?php include 'includes/date-convert.php'; //Convert Date Func?>

<!-- Container -->
<div id="container">
  <div id="main">
    <!-- Floating box (Export Data) -->
    <?php if($xFileDest != ""):?>
    <div id="export-data" class="layer-2">
      <div class="float-header">
        <span class="font-md left-item">Export data (.xlsx)</span>
        <a href="reports.php?unlink-file=<?php echo $xFileDest;?>" class="close-btn right-item">
          <img src="img/icons/close-cyan.svg" alt="">
        </a>
      </div>
      <div class="float-body">
        <table>
          <tr>
            <td><img src="img/icons/excel-file.svg" alt=""></td>
            <td>
              <span class="font-sm"><?php echo $xFileName?></span><br><br>
              <span class="font-sm"><?php echo $xFileSize?></span>
            </td>
          </tr>
        </table>
        <div class="float-action">
          <a href="reports.php?unlink-file=<?php echo $xFileDest;?>" class="cancel-action font-md">Cancel</a>
          <a href="<?php echo $xFileDest;?>" class="execute-action font-md">Download</a>
        </div>
      </div>
    </div>
    <?php endif;?>
    <!-- Content -->
    <div id="content">
      <!-- Box 1 -->
      <div id="box1" class="container-box layer-1">
        <div id="header">
          <h5 class="font-md header-left">Search Report</h5>
        </div>
        <div id="sub-content">
          <form action="reports.php" method="get" autocomplete="off">
            <div class="custom-field font-md long">
              <span class="field-label">From (Period)</span>
              <div class="field">
                <input type="date" name="date_from" id="">
              </div>
            </div>
            <div class="custom-field font-md long">
              <span class="field-label">To (Period)</span>
              <div class="field">
                <input type="date" name="date_to" id="">
              </div>
            </div>
            <div class="custom-field font-md short">
              <span class="field-label">AF/SF</span>
              <div class="field">
                <select name="afsf" id="src-afsf" class="font-sm">
                  <option value="All">All</option>
                  <option value="AF">AF</option>
                  <option value="SF">SF</option>
                  <option value="SF/CD">SF/CD</option>
                  <option value="AF/CD">AF/CD</option>
                  <option value="Courier">Courier</option>
                </select>
              </div>
            </div>
            <div class="custom-field font-md long">
              <span class="field-label">Sector</span>
              <div class="field">
                <select name="sector" id="src-sector" class="font-sm">
                  <option value="imp">Import</option>
                  <option value="exp">Export</option>
                  <option value="chemImp">Chemical - Import</option>
                  <option value="chemExp">Chemical - Export</option>
                  <option value="pharImp">Pharma - Import</option>
                  <option value="pharExp">Pharma - Import</option>
                </select>
              </div>
            </div>
            <div class="custom-field font-md x-long">
              <span class="field-label">Custom Agent</span>
              <div class="field">
                <select name="agent" id="src-fwdr" class="font-sm">
                  <?php if($auth == "(3rd)Speedmark"):?>
                    <option value="Speedmark">Speedmark</option>
                  <?php else:?>
                    <option value="All">All</option>
                    <option value="Schenker">Schenker</option>
                    <option value="Speedmark">Speedmark</option>
                  <?php endif;?>
                </select>
              </div>
            </div>
            <button class="cyan-btn font-md layer-2" name="set-search" id="search-btn" type="submit">
              Search reports
            </button>
          </form>
        </div>
      </div>
      <!-- Box 2 -->
      <div id="box2" class="container-box layer-1">
        <div id="header">
          <h5 class="font-md header-left">Shipment Reports</h5>
          <input type="text" id="table-state" value="<?php echo $tableState;?>" style="display: none;">
          <?php if ($tableState == "show"):?>
          <div class="custom-select header-left">
            <select name="sector" id="select-sector" onchange="selectSector();">
              <option value="chemImp">Chemical - Import</option>
              <option value="chemExp">Chemical - Export</option>
              <option value="pharImp">Pharma - Import</option>
              <option value="pharExp">Pharma - Export</option>
            </select>
          </div>
          <span class="font-sm header-right indicator">Pending Reports: <span id="pending-indicator"></span></span>
          <?php else:?>
          <span class="font-sm header-right indicator">Total Results: <span id="result-indicator"><?php echo $srcResSum;?></span></span>
          <?php endif;?>
        </div>
        <div id="sub-content">
          <!-- Table Header -->
          <div id="custom-table-1" class="left-item font-sm table-header">
            <table class="custom-table">
              <tr>
                <th id="tb1-col1">Aju No.</th>
                <th id="tb1-col2">HAWB/BL No.</th>
                <th id="tb1-col3">Invoice No.</th>
                <th id="tb1-col4">Invoice Value</th>
                <th id="tb1-col5">SPPB (Due)</th>
                <th id="tb1-col6"></th>
              </tr>
            </table>
          </div>
          <?php if($tableState != "search"):?>
            <!-- Pending Indicator -->
            <span id="imp-chem-sum" style="display: none;"><?php echo $impChemSum;?></span>
            <span id="imp-phar-sum" style="display: none;"><?php echo $impPharSum;?></span>
            <span id="exp-chem-sum" style="display: none;"><?php echo $expChemSum;?></span>
            <span id="exp-phar-sum" style="display: none;"><?php echo $expPharSum;?></span>
          <?php endif;?>
          <!-- Table Content -->
          <?php if($tableState == "search"):?>
          <!-- Search Result Table -->
          <div id="srcResTb">
            <!-- Search Result Found -->
            <?php if($srcResSum > 0):?>
            <div id="custom-table-1" class="left-item font-sm table-records">
              <?php if($busSec == "import"):?>
              <!-- Import Table -->
              <table class="custom-table">
              <?php while ($rep = $srcRes->fetch_assoc()):?>
                <tr>
                  <td id="tb1-col1"><?php echo $rep["shp_aju"]; ?></td>
                  <td id="tb1-col2"><?php echo $rep["shp_hawb"]; ?></td>
                  <td id="tb1-col3"><?php echo $rep["sup_inv_no"]; ?></td>
                  <td id="tb1-col4">
                    <?php echo $rep["sup_curr"] . " " . number_format($rep["sup_val"]) ; ?>
                  </td>
                  <td id="tb1-col5">
                    <?php if ($rep["sppb_date"] == "0000-00-00"):?>
                    <div class="<?php echo dueStatus($rep["shp_eta"])[0];?>">
                      <span><?php echo dueStatus($rep["shp_eta"])[1];?></span>
                    </div>
                    <?php else:?>
                    <div class="submitted">
                      <span>SPPB Submitted</span>
                    </div>
                    <?php endif;?>
                  </td>
                  <td id="tb1-col6"><a href="reports.php?select-import=<?php echo $rep["rep_no"];?>">Select</a></td>
                </tr>
              <?php endwhile;?>
              </table>
              <?php else:?>
              <!-- Export Table -->
              <table class="custom-table">
              <?php while ($rep = $srcRes->fetch_assoc()):?>
                <tr>
                  <td id="tb1-col1"><?php echo $rep["shp_aju"]; ?></td>
                  <td id="tb1-col2"><?php echo $rep["shp_hawb"]; ?></td>
                  <td id="tb1-col3"><?php echo $rep["inv_no"]; ?></td>
                  <td id="tb1-col4">
                    <?php echo $rep["inv_curr"] . " " . number_format($rep["inv_val"]) ; ?>
                  </td>
                  <td id="tb1-col5">
                    <?php if($rep["npe_date"] == "0000-00-00"):?>
                    <div class="<?php echo dueStatus($rep["shp_eta"])[0];?>">
                      <span><?php echo dueStatus($rep["shp_eta"])[1];?></span>
                    </div>
                    <?php else:?>
                    <div class="submitted">
                      <span>NPE Submitted</span>
                    </div>
                    <?php endif;?>
                  </td>
                  <td id="tb1-col6"><a href="reports.php?select-export=<?php echo $rep["rep_no"];?>">Select</a></td>
                </tr>
              <?php endwhile;?>
              </table>
              <?php endif;?>
            </div>
            <a href="reports.php?extract-<?php echo $busSec;?>=<?php echo $query;?>" id="export-btn" class="custom-link font-md left-item">
              <img src="img/icons/export.svg" alt="" />
              <span>Export to excel</span>
            </a>
            <?php else:?>
            <!-- Search Result Not Found -->
            <div class="default-vector left-item">
              <img src="img/vectors/cant-found.svg" alt="">
              <p class="font-md">Sorry, the report's you searched for is not exist.</p>
            </div>
            <?php endif;?>
          </div>
          <?php else:?>
          <!-- Import Chemical Table -->
          <div id="impChemTb">
            <?php if($impChemSum > 0):?>
            <div id="custom-table-1" class="left-item font-sm table-records">
              <table class="custom-table">
              <?php while ($rep = $impChem->fetch_assoc()):?>
                 <tr>
                  <td id="tb1-col1"><?php echo $rep["shp_aju"]; ?></td>
                  <td id="tb1-col2"><?php echo $rep["shp_hawb"]; ?></td>
                   <td id="tb1-col3"><?php echo $rep["sup_inv_no"]; ?></td>
                  <td id="tb1-col4">
                     <?php echo $rep["sup_curr"] . " " . number_format($rep["sup_val"]) ; ?>
                   </td>
                   <td id="tb1-col5">
                     <div class="<?php echo dueStatus($rep["shp_eta"])[0];?>">
                      <span><?php echo dueStatus($rep["shp_eta"])[1];?></span>
                     </div>
                  </td>
                   <td id="tb1-col6"><a href="reports.php?select-import=<?php echo $rep["rep_no"];?>">Select</a></td>
                 </tr>
              <?php endwhile;?>
               </table>
             </div>
             <a href="reports.php?extract-import=<?php echo $impChemQ;?>" id="export-btn" class="custom-link font-md left-item">
              <img src="img/icons/export.svg" alt="" />
              <span>Export to excel</span>
             </a>
             <?php else:?>
             <div class="default-vector left-item">
               <img src="img/vectors/pending-clear.svg" alt="">
              <p class="font-md">Looks like we don't have any pending reports</p>
             </div>
            <?php endif;?>
          </div>
          <!-- Import Pharma Table -->
          <div id="impPharTb" style="display: none;">
            <?php if($impPharSum > 0):?>
            <div id="custom-table-1" class="left-item font-sm table-records">
              <table class="custom-table">
              <?php while ($rep = $impPhar->fetch_assoc()):?>
                <tr>
                  <td id="tb1-col1"><?php echo $rep["shp_aju"]; ?></td>
                  <td id="tb1-col2"><?php echo $rep["shp_hawb"]; ?></td>
                  <td id="tb1-col3"><?php echo $rep["sup_inv_no"]; ?></td>
                  <td id="tb1-col4">
                    <?php echo $rep["sup_curr"] . " " . number_format($rep["sup_val"]) ; ?>
                  </td>
                  <td id="tb1-col5">
                    <div class="<?php echo dueStatus($rep["shp_eta"])[0];?>">
                      <span><?php echo dueStatus($rep["shp_eta"])[1];?></span>
                    </div>
                  </td>
                  <td id="tb1-col6"><a href="reports.php?select-import=<?php echo $rep["rep_no"];?>">Select</a></td>
                </tr>
              <?php endwhile;?>
              </table>
            </div>
            <a href="reports.php?extract-import=<?php echo $impPharQ;?>" id="export-btn" class="custom-link font-md left-item">
              <img src="img/icons/export.svg" alt="" />
              <span>Export to excel</span>
            </a>
            <?php else:?>
            <div class="default-vector left-item">
              <img src="img/vectors/pending-clear.svg" alt="">
              <p class="font-md">Looks like we don't have any pending reports</p>
            </div>
            <?php endif;?>
          </div>
          <!-- Export Chemicals Table -->
          <div id="expChemTb" style="display: none;">
            <?php if($expChemSum > 0):?>
            <div id="custom-table-1" class="left-item font-sm table-records">
              <table class="custom-table">
              <?php while ($rep = $expChem->fetch_assoc()):?>
                <tr>
                  <td id="tb1-col1"><?php echo $rep["shp_aju"]; ?></td>
                  <td id="tb1-col2"><?php echo $rep["shp_hawb"]; ?></td>
                  <td id="tb1-col3"><?php echo $rep["inv_no"]; ?></td>
                  <td id="tb1-col4">
                    <?php echo $rep["inv_curr"] . " " . number_format($rep["inv_val"]) ; ?>
                  </td>
                  <td id="tb1-col5">
                    <div class="<?php echo dueStatus($rep["shp_eta"])[0];?>">
                      <span><?php echo dueStatus($rep["shp_eta"])[1];?></span>
                    </div>
                  </td>
                  <td id="tb1-col6"><a href="reports.php?select-export=<?php echo $rep["rep_no"];?>">Select</a></td>
                </tr>
              <?php endwhile;?>
              </table>
            </div>
            <a href="reports.php?extract-export=<?php echo $expChemQ;?>" id="export-btn" class="custom-link font-md left-item">
              <img src="img/icons/export.svg" alt="" />
              <span>Export to excel</span>
            </a>
            <?php else:?>
            <div class="default-vector left-item">
              <img src="img/vectors/pending-clear.svg" alt="">
              <p class="font-md">Looks like we don't have any pending reports</p>
            </div>
            <?php endif;?>
          </div>
          <!-- Export Pharma Table -->
          <div id="expPharTb" style="display: none;">
            <?php if($expPharSum > 0):?>
            <div id="custom-table-1" class="left-item font-sm table-records">
              <table class="custom-table">
              <?php while ($rep = $expPhar->fetch_assoc()):?>
                <tr>
                  <td id="tb1-col1"><?php echo $rep["shp_aju"]; ?></td>
                  <td id="tb1-col2"><?php echo $rep["shp_hawb"]; ?></td>
                  <td id="tb1-col3"><?php echo $rep["inv_no"]; ?></td>
                  <td id="tb1-col4">
                    <?php echo $rep["inv_curr"] . " " . number_format($rep["inv_val"]) ; ?>
                  </td>
                  <td id="tb1-col5">
                    <div class="<?php echo dueStatus($rep["shp_eta"])[0];?>">
                      <span><?php echo dueStatus($rep["shp_eta"])[1];?></span>
                    </div>
                  </td>
                  <td id="tb1-col6"><a href="reports.php?select-export=<?php echo $rep["rep_no"];?>">Select</a></td>
                </tr>
              <?php endwhile;?>
              </table>
            </div>
            <a href="reports.php?extract-export=<?php echo $expPharQ;?>" id="export-btn" class="custom-link font-md left-item">
              <img src="img/icons/export.svg" alt="" />
              <span>Export to excel</span>
            </a>
            <?php else:?>
            <div class="default-vector left-item">
              <img src="img/vectors/pending-clear.svg" alt="">
              <p class="font-md">Looks like we don't have any pending reports</p>
            </div>
            <?php endif;?>
          </div>
            <?php endif;?>
        </div>
      </div>
      <!-- Box 3 -->
      <div id="box3" class="container-box layer-1">
        <div id="header">
          <h5 class="font-md header-left">Selected Report</h5>
        </div>
        <div id="sub-content">
          <?php if($reportState == "import" || $reportState == "export"):?>
          <div id="selected-info">
            <div id="info" class="custom-record short">
              <p>Sector</p>
              <span><?php echo $busSector;?></span>
            </div>
            <div id="info" class="custom-record short">
              <p>Period (ETA)</p>
              <span><?php echo convertDate($shpEta);?></span>
            </div>
            <div id="info" class="custom-record short">
              <p>HAWB/HABL</p>
              <span><?php echo $shpHawb;?></span>
            </div>
            <div id="info" class="custom-record short">
              <p>MAWB/RWBL</p>
              <span><?php val($shpMawb);?></span>
            </div>
            <div id="info" class="custom-record long">
              <p>Flight no / vessel</p>
              <span><?php val($shpFlve);?></span>
            </div>
            <div id="info" class="custom-record short">
              <p>C.B. Agent</p>
              <span><?php echo val($cstmBrkr);?></span>
            </div>
            <div id="info" class="custom-record short">
              <p>No. Aju</p>
              <span><?php echo val($shpAju);?></span>
            </div>
            <div id="info" class="custom-record short">
              <p>Invoice</p>
              <?php if($reportState == "import"):?>
              <span><?php echo val($supInvNo);?></span>
              <?php else:?>
              <span><?php echo val($invNo);?></span>
              <?php endif;?>
            </div>
            <div id="info" class="custom-record short">
              <p>Value of goods</p>
              <?php if($reportState == "import"):?>
              <span><?php echo $supCurr . " " . number_format($supVal);?></span>
              <?php else:?>
              <span><?php echo $invCurr . " " . number_format($invVal);?></span>
              <?php endif;?>
            </div>
          </div>
            <?php if($reportState == "import"):?>
              <a class="cyan-btn font-md layer-2 left-item"
                id="download1-btn"
                href="includes/download-pdf.php?download_pdf=<?php echo $shpHawb;?>">
                Download Summary (PDF)
              </a>
            <?php endif;?>
          <?php else:?>
          <div class="default-form layer-1">
            <p class="font-sm">No report were selected yet..</p>
          </div>
          <?php endif;?>    
        </div>
      </div>
      <!-- Box 4 -->
      <div id="box4" class="container-box layer-1">
        <div id="header">
          <h5 class="font-md header-left">Report Detail</h5>
          <?php if($reportState == "import" || $reportState == "export"):?>
          <div class="custom-select header-right">
            <select name="info" id="select-info" onchange="selectInfo();">
              <option value="0">Shipping Info</option>
              <option value="1">Licenses</option>
              <option value="2">PIB</option>
              <option value="3">SKEP</option>
              <option value="4">Inspection</option>
              <option value="5">Supplier</option>
              <option value="6">SPPB</option>
              <option value="7">Release</option>
              <option value="8">Custom</option>
              <option value="9">Storage</option>
              <option value="10">Valuation</option>
              <option value="11">Charges</option>
              <option value="12">Historical</option>
            </select>
          </div>
          <?php endif;?>
        </div>
        <div id="sub-content">
          <?php if($reportState == "import" || $reportState == "export"):?>
          <!-- Shipping Info -->
          <?php if($reportState == "import"):?>
          <div id="shipping" class="custom-info" style="display: block;">
            <table class="left-item">
              <tr>
                <td class="info-label">HAWB / HABL</td>
                <td class="info"><?php val($shpHawb);?></td>
              </tr>
              <tr>
                <td class="info-label">MAWB / RWBL</td>
                <td class="info"><?php val($shpMawb);?></td>
              </tr>
              <tr>
                <td class="info-label">AF / SF</td>
                <td class="info"><?php val($shpAfsf);?></td>
              </tr>
              <tr>
                <td class="info-label">Flight no / Vessel</td>
                <td class="info"><?php val($shpFlve);?></td>
              </tr>
              <tr>
                <td class="info-label">Shipper name</td>
                <td class="info"><?php val($shpShpr);?></td>
              </tr>
              <tr>
                <td class="info-label">Aju no</td>
                <td class="info"><?php val($shpAju);?></td>
              </tr>
              <tr>
                <td class="info-label">Qty items</td>
                <td class="info"><?php val($shpQty);?></td>
              </tr>
              <tr>
                <td class="info-label">Total pkgs</td>
                <td class="info"><?php val($shpPkgs);?></td>
              </tr>
              <tr>
                <td class="info-label">Total weight (kg)</td>
                <td class="info"><?php val($shpWght);?></td>
              </tr>
              <tr>
                <td class="info-label">Cbm</td>
                <td class="info"><?php val($shpCbm);?></td>
              </tr>
              <tr>
                <td class="info-label">Forwarder agent</td>
                <td class="info"><?php val($shpFwdr);?></td>
              </tr>
              <tr>
                <td class="info-label">LCL 20” 40” 40”HC</td>
                <td class="info"><?php val($shpLcl);?></td>
              </tr>
            </table>
            <table class="left-item">
              <tr>
                <td class="info-label">ETD</td>
                <td class="info"><?php echo convDateSQL($shpEtd);?></td>
              </tr>
              <tr>
                <td class="info-label">ETA</td>
                <td class="info"><?php echo convDateSQL($shpEta);?></td>
              </tr>
              <tr>
                <td class="info-label">ATA (Date)</td>
                <td class="info"><?php echo convDateSQL($shpArrDate);?></td>
              </tr>
              <tr>
                <td class="info-label">ATA (Day)</td>
                <td class="info"><?php val($shpArrDay);?></td>
              </tr>
              <tr>
                <td class="info-label">NOA Recieved</td>
                <td class="info"><?php echo convDateSQL($shpNoa);?></td>
              </tr>
              <tr>
                <td class="info-label">App. Letter BC1.1</td>
                <td class="info"><?php echo convDateSQL($shpApp);?></td>
              </tr>
              <tr>
                <td class="info-label">BC1.1 at PDE Manifest</td>
                <td class="info"><?php echo convDateSQL($shpPde);?></td>
              </tr>
            </table>
          </div>
          <?php else:?>
          <div id="shipping" class="custom-info" style="display: block;">
            <table class="left-item">
              <tr>
                <td class="info-label">HAWB / HABL</td>
                <td class="info"><?php echo val($shpHawb);?></td>
              </tr>
              <tr>
                <td class="info-label">MAWB / RWBL</td>
                <td class="info"><?php echo val($shpMawb);?></td>
              </tr>
              <tr>
                <td class="info-label">AF / SF</td>
                <td class="info"><?php echo val($shpAfsf);?></td>
              </tr>
              <tr>
                <td class="info-label">Flight no / Vessel</td>
                <td class="info"><?php echo val($shpFlve);?></td>
              </tr>
              <tr>
                <td class="info-label">Shipper name</td>
                <td class="info"><?php echo val($shpCons);?></td>
              </tr>
              <tr>
                <td class="info-label">Aju no</td>
                <td class="info"><?php echo val($shpAju);?></td>
              </tr>
              <tr>
                <td class="info-label">Qty items</td>
                <td class="info"><?php echo val($shpQty);?></td>
              </tr>
              <tr>
                <td class="info-label">Total pkgs</td>
                <td class="info"><?php echo val($shpPkgs);?></td>
              </tr>
              <tr>
                <td class="info-label">Total weight (kg)</td>
                <td class="info"><?php echo val($shpWght);?></td>
              </tr>
              <tr>
                <td class="info-label">Cbm</td>
                <td class="info"><?php echo val($shpCbm);?></td>
              </tr>
              <tr>
                <td class="info-label">Forwarder agent</td>
                <td class="info"><?php echo val($shpFwdr);?></td>
              </tr>
              <tr>
                <td class="info-label">LCL 20” 40” 40”HC</td>
                <td class="info"><?php echo val($shpLcl);?></td>
              </tr>
            </table>
            <table class="left-item">
              <tr>
                <td class="info-label">ETD</td>
                <td class="info"><?php echo convDateSQL($shpEtd);?></td>
              </tr>
              <tr>
                <td class="info-label">ETA</td>
                <td class="info"><?php echo convDateSQL($shpEta);?></td>
              </tr>
              <tr>
                <td class="info-label">ATA (Date)</td>
                <td class="info"><?php echo convDateSQL($shpArrDate);?></td>
              </tr>
              <tr>
                <td class="info-label">ATA (Day)</td>
                <td class="info"><?php echo val($shpArrDay);?></td>
              </tr>
            </table>
          </div>
          <?php endif;?>
          <!-- Licenses -->
          <?php if($reportState == "import"):?>
          <div id="licenses" class="custom-info" style="display: none;">
            <table class="item-left">
              <tr>
                <td class="info-label">Required (from)</td>
                <td class="info"><?php val($lcsReq);?></td>
              </tr>
              <tr>
                <td class="info-label">BPOM Complete Date</td>
                <td class="info"><?php echo convDateSQL($lcsBpom);?></td>
              </tr>
              <tr>
                <td class="info-label">COO Recieved Date</td>
                <td class="info"><?php echo convDateSQL($lcsCoo);?></td>
              </tr>
              <tr>
                <td class="info-label">KH Date</td>
                <td class="info"><?php echo convDateSQL($lcsKh);?></td>
              </tr>
              <tr>
                <td class="info-label">Complete Doc Date</td>
                <td class="info"><?php echo convDateSQL($lcsCompDoc);?></td>
              </tr>
              <tr>
                <td class="info-label">Licenses Complete Date</td>
                <td class="info"><?php echo convDateSQL($lcsComp);?></td>
              </tr>
            </table>
          </div>
          <?php else:?>
          <div id="licenses" class="custom-info" style="display: none;">
            <table class="item-left">
              <tr>
                <td class="info-label">Required (from)</td>
                <td class="info"><?php val($lcsReq);?></td>
              </tr>
              <tr>
                <td class="info-label">BPOM Complete Date</td>
                <td class="info"><?php val($lcsBpom);?></td>
              </tr>
              <tr>
                <td class="info-label">COO Recieved Date</td>
                <td class="info"><?php val($lcsCoo);?></td>
              </tr>
              <tr>
                <td class="info-label">Complete Doc Date</td>
                <td class="info"><?php val($lcsCompDoc);?></td>
              </tr>
              <tr>
                <td class="info-label">Licenses Complete Date</td>
                <td class="info"><?php val($lcsComp);?></td>
              </tr>
            </table>
          </div>
          <?php endif;?>
          <!-- PIB / PEB -->
          <?php if($reportState == "import"):?>
          <div id="pib" class="custom-info" style="display: none;">
            <table class="left-item">
              <tr>
                <td class="info-label">PIB Issued</td>
                <td class="info"><?php echo convDateSQL($pibIssd);?></td>
              </tr>
              <tr>
                <td class="info-label">PIB Confirm</td>
                <td class="info"><?php echo convDateSQL($pibConf);?></td>
              </tr>
              <tr>
                <td class="info-label">PIB Remarks</td>
                <td class="info"><?php val($pibRmrk);?></td>
              </tr>
              <tr>
                <td class="info-label">PIB Billing Date</td>
                <td class="info"><?php echo convDateSQL($pibBill);?></td>
              </tr>
              <tr>
                <td class="info-label">PIB Paid / BPN</td>
                <td class="info"><?php echo convDateSQL($pibPaid);?></td>
              </tr>
              <tr>
                <td class="info-label">PIB Transfer</td>
                <td class="info"><?php echo convDateSQL($pibTrf);?></td>
              </tr>
            </table>
          </div>
          <?php else:?>
          <div id="pib" class="custom-info" style="display: none;">
            <table class="left-item">
              <tr>
                <td class="info-label">PEB Issued</td>
                <td class="info"><?php echo convDateSQL($pebIssd);?></td>
              </tr>
              <tr>
                <td class="info-label">PEB Confirm</td>
                <td class="info"><?php echo convDateSQL($pebConf);?></td>
              </tr>
              <tr>
                <td class="info-label">PEB Remarks</td>
                <td class="info"><?php val($pebRmrk);?></td>
              </tr>
              <tr>
                <td class="info-label">PEB Transfer</td>
                <td class="info"><?php echo convDateSQL($pebTrf);?></td>
              </tr>
            </table>
          </div>
          <?php endif;?>
          <!-- SKEP Larangan -->
          <div id="skep" class="custom-info" style="display: none;">
            <table class="left-item">
              <tr>
                <td class="info-label">Date</td>
                <td class="info"><?php echo convDateSQL($skepDate);?></td>
              </tr>
              <tr>
                <td class="info-label">Remarks</td>
                <td class="info"><?php val($skepRmrk);?></td>
              </tr>
            </table>
          </div>
          <!-- Inspection -->
          <div id="inspection" class="custom-info" style="display: none;">
            <table class="left-item">
              <tr>
                <td class="info-label">Date</td>
                <td class="info"><?php echo convDateSQL($inspDate);?></td>
              </tr>
              <tr>
                <td class="info-label">Reasons</td>
                <td class="info"><?php val($inspRsn);?></td>
              </tr>
            </table>
          </div>
          <!-- Supplier / Invoice -->
          <?php if($reportState == "import"):?>
          <div id="supplier" class="custom-info" style="display: none;">
            <table class="left-item">
              <tr>
                <td class="info-label">Order no</td>
                <td class="info"><?php val($supOrdr);?></td>
              </tr>
              <tr>
                <td class="info-label">Invoice no</td>
                <td class="info"><?php val($supInvNo);?></td>
              </tr>
              <tr>
                <td class="info-label">Invoice date</td>
                <td class="info"><?php echo convDateSQL($supInvDate);?></td>
              </tr>
              <tr>
                <td class="info-label">Currency</td>
                <td class="info"><?php val($supCurr);?></td>
              </tr>
              <tr>
                <td class="info-label">Value of goods</td>
                <td class="info"><?php val(number_format($supVal));?></td>
              </tr>
              <tr>
                <td class="info-label">Freight</td>
                <td class="info"><?php val(number_format($supFrgt));?></td>
              </tr>
              <tr>
                <td class="info-label">Total</td>
                <td class="info"><?php val(number_format($supTot));?></td>
              </tr>
              <tr>
                <td class="info-label">Collect/Pre</td>
                <td class="info"><?php val($supOrdr);?></td>
              </tr>
            </table>
          </div>
          <?php else:?>
          <div id="supplier" class="custom-info" style="display: none;">
            <table class="left-item">
              <tr>
                <td class="info-label">Order no</td>
                <td class="info"><?php val($invOrdr);?></td>
              </tr>
              <tr>
                <td class="info-label">Invoice no</td>
                <td class="info"><?php val($invNo);?></td>
              </tr>
              <tr>
                <td class="info-label">Invoice date</td>
                <td class="info"><?php echo convDateSQL($invDate);?></td>
              </tr>
              <tr>
                <td class="info-label">Currency</td>
                <td class="info"><?php val($invCurr);?></td>
              </tr>
              <tr>
                <td class="info-label">Value of goods</td>
                <td class="info"><?php val(number_format($invVal));?></td>
              </tr>
              <tr>
                <td class="info-label">Freight</td>
                <td class="info"><?php val(number_format($invFrgt));?></td>
              </tr>
              <tr>
                <td class="info-label">Total</td>
                <td class="info"><?php val(number_format($invTot));?></td>
              </tr>
              <tr>
                <td class="info-label">Collect/Pre</td>
                <td class="info"><?php val($invOrdr);?></td>
              </tr>
            </table>
          </div>
          <?php endif;?>
          <!-- SPPB / NPE Green Lane -->
          <?php if($reportState == "import"):?>
          <div id="sppb" class="custom-info" style="display: none;">
            <table class="left-item">
              <tr>
                <td class="info-label">SPPB Date</td>
                <td class="info"><?php echo convDateSQL($sppbDate);?></td>
              </tr>
            </table>
          </div>
          <?php else:?>
          <div id="sppb" class="custom-info" style="display: none;">
            <table class="left-item">
              <tr>
                <td class="info-label">NPE Date</td>
                <td class="info"><?php echo convDateSQL($npeDate);?></td>
              </tr>
            </table>
          </div>
          <?php endif;?>
          <!-- Release / Recieved -->
          <?php if($reportState == "import"):?>
          <div id="release" class="custom-info" style="display: none;">
            <table class="left-item">
              <tr>
                <td class="info-label">Delivery</td>
                <td class="info"><?php echo convDateSQL($rlsDlv);?></td>
              </tr>
              <tr>
                <td class="info-label">GRN Date</td>
                <td class="info"><?php echo convDateSQL($rlsGrn);?></td>
              </tr>
              <tr>
                <td class="info-label">Clearence LT</td>
                <td class="info"><?php val($rlsClrLt);?></td>
              </tr>
              <tr>
                <td class="info-label">Delivery LT</td>
                <td class="info"><?php val($rlsDlvLt);?></td>
              </tr>
              <tr>
                <td class="info-label">GRN LT</td>
                <td class="info"><?php val($rlsGrnLt);?></td>
              </tr>
            </table>
          </div>
          <?php else:?>
          <div id="release" class="custom-info" style="display: none;">
            <table class="left-item">
              <tr>
                <td class="info-label">Delivery</td>
                <td class="info"><?php echo convDateSQL($rcvdDlv);?></td>
              </tr>
              <tr>
                <td class="info-label">GRN Date</td>
                <td class="info"><?php echo convDateSQL($rcvdGrn);?></td>
              </tr>
              <tr>
                <td class="info-label">Clearence LT</td>
                <td class="info"><?php val($rcvdClrLt);?></td>
              </tr>
              <tr>
                <td class="info-label">Delivery LT</td>
                <td class="info"><?php val($rcvdDlvLt);?></td>
              </tr>
              <tr>
                <td class="info-label">GRN LT</td>
                <td class="info"><?php val($rcvdGrnLt);?></td>
              </tr>
            </table>
          </div>
          <?php endif;?>
          <!-- Custom Brokerages -->
          <div id="custom" class="custom-info" style="display: none;">
            <table class="left-item">
              <tr>
                <td class="info-label">Custom Brokerages Agent</td>
                <td class="info"><?php val($cstmBrkr);?></td>
              </tr>
              <tr>
                <td class="info-label">Invoice no</td>
                <td class="info"><?php val($cstmInvNo);?></td>
              </tr>
              <tr>
                <td class="info-label">Invoice recieved date</td>
                <td class="info"><?php val($cstmRcvd);?></td>
              </tr>
            </table>
          </div>
          <!-- Storage -->
          <div id="storage" class="custom-info" style="display: none;">
            <table class="left-item">
              <tr>
                <td class="info-label">IN</td>
                <td class="info"><?php echo convDateSQL($strgIn);?></td>
              </tr>
              <tr>
                <td class="info-label">OUT</td>
                <td class="info"><?php echo convDateSQL($strgOut);?></td>
              </tr>
              <tr>
                <td class="info-label">Num Days</td>
                <td class="info"><?php val($strgDays);?></td>
              </tr>
            </table>
          </div>
          <!-- Valuation -->
          <div id="valuation" class="custom-info" style="display: none;">
            <table class="left-item">
              <tr>
                <td class="info-label">Date</td>
                <td class="info"><?php echo convDateSQL($valDate);?></td>
              </tr>
              <tr>
                <td class="info-label">Remarks</td>
                <td class="info"><?php val($valRmrk);?></td>
              </tr>
            </table>
          </div>
          <!-- Charges -->
          <?php if($reportState == "import"):?>
          <div id="charges" class="custom-info" style="display: none;">
            <table class="left-item">
              <tr>
                <td class="info-label">Freight</td>
                <td class="info"><?php val($chrgFrgt);?></td>
              </tr>
              <tr>
                <td class="info-label">Import Duty</td>
                <td class="info"><?php val($chrgDuty);?></td>
              </tr>
              <tr>
                <td class="info-label">BM Duty</td>
                <td class="info"><?php val($chrgBm);?></td>
              </tr>
              <tr>
                <td class="info-label">Duty & Tax</td>
                <td class="info"><?php val($chrgDuty);?></td>
              </tr>
              <tr>
                <td class="info-label">WH Tax</td>
                <td class="info"><?php val($chrgWh);?></td>
              </tr>
              <tr>
                <td class="info-label">VAT</td>
                <td class="info"><?php val($chrgVat);?></td>
              </tr>
              <tr>
                <td class="info-label">Storage</td>
                <td class="info"><?php val($chrgStrg);?></td>
              </tr>
              <tr>
                <td class="info-label">
                  Delivery Charges <br />/ Local Transport
                </td>
                <td class="info"><?php val($chrgDlv);?></td>
              </tr>
              <tr>
                <td class="info-label">Others</td>
                <td class="info"><?php val($chrgOthr);?></td>
              </tr>
              <tr>
                <td class="info-label">Total (w/o duty_tax)</td>
                <td class="info"><?php val($chrgWoTax);?></td>
              </tr>
              <tr>
                <td class="info-label">% BM</td>
                <td class="info"><?php val($chrgPBm);?></td>
              </tr>
            </table>
            <table class="left-item">
              <tr>
                <td class="info-label">% Total</td>
                <td class="info"><?php val($chrgPTot);?></td>
              </tr>
              <tr>
                <td class="info-label">Remarks</td>
                <td class="info"><?php val($chrgRmrk);?></td>
              </tr>
            </table>
          </div>
          <?php else:?>
          <div id="charges" class="custom-info" style="display: none;">
            <table class="left-item">
              <tr>
                <td class="info-label">Freight</td>
                <td class="info"><?php val($chrgFrgt);?></td>
              </tr>
              <tr>
                <td class="info-label">Storage</td>
                <td class="info"><?php val($chrgStrg);?></td>
              </tr>
              <tr>
                <td class="info-label">Others</td>
                <td class="info"><?php val($chrgOthr);?></td>
              </tr>
              <tr>
                <td class="info-label">Total</td>
                <td class="info"><?php val($chrgTot);?></td>
              </tr>
              <tr>
                <td class="info-label">Remarks</td>
                <td class="info"><?php val($chrgRmrk);?></td>
              </tr>
            </table>
          </div>
          <?php endif;?>
          <!-- Historical Background -->
          <div id="historical" class="custom-info" style="display: none;">
            <table>
              <tr>
                <td class="info-label">Historical Background</td>
              </tr>
              <tr>
                <td class="info">
                  <textarea name="" id="" cols="30" rows="10" readonly><?php echo $histBg;?></textarea
                  >
                </td>
              </tr>
            </table>
          </div>
          <?php else:?>
          <div class="default-form layer-1">
            <p class="font-sm">No report were selected yet..</p>
          </div>
          <?php endif;?> 
        </div>
      </div>
      <!-- Box 5 -->
      <div id="box5" class="container-box layer-1">
        <div id="header">
          <h5 class="font-md header-left">Attached Files</h5>
        </div>
        <div id="sub-content">
          <?php if($reportState == "import" || $reportState == "export"):?>
          <div id="custom-table-2" class="left-item font-sm">
            <table class="custom-table">
              <?php
                // Fetch files
                $attFile = $conn->query("SELECT * FROM `files` WHERE `file_aju` = '$shpAju'");
              ?>
              <tr>
                <th id="tb2-col1">
                  Files
                </th>
                <th id="tb2-col2"></th>
              </tr>
              <?php while ($file = $attFile->fetch_assoc()):?>
              <tr>
                <td id="tb2-col1">
                  <?php echo $file['file_name'];?>
                </td>
                <td id="tb2-col2">
                  <a href="uploads/<?php echo $file['file_name'];?>" download="" class="save-btn">
                    <img src="img/icons/download.svg" alt="" />
                  </a>
                </td>
              </tr>
              <?php endwhile;?>
            </table>
          </div>
          <?php else:?>
          <div class="default-form layer-1">
            <p class="font-sm">No report were selected yet..</p>
          </div>
          <?php endif;?>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Script -->
<script type="text/javascript" src="js/select-info.js"></script>
<script type="text/javascript" src="js/reports-action.js"></script>
<!-- Footer -->
<?php include 'includes/footer.php' ?>
