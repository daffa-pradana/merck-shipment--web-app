<?php $page = "input"; //Set page ?>
<?php include 'includes/header.php'; //Header ?>
<?php include 'includes/config.php'; //Config ?>
<?php include 'includes/input-action.php'; //Action ?>
<?php include 'includes/duedate.php'; //Duedate Func ?>
<?php include 'includes/date-convert.php'; //Convert Date Func ?>
<?php include 'includes/import_data.php'; //Import Data Action ?>
<?php include 'includes/upload.php'; //Upload file ?>
<!-- Container -->
    <div id="container">
      <div id="main">
        <!-- Floating Box -->
        <div id="import-data" class="layer-2" style="display: none;">
          <div class="float-header">
            <span id="sec-indicator" class="font-md left-item"></span>
            <a href="javascript:closeFloat();" class="close-btn right-item">
              <img src="img/icons/close-cyan.svg" alt="">
            </a>
          </div>
          <form method="post" enctype="multipart/form-data" action="input.php">
            <input type="text" id="import-sector" name="import-sector" style="display: none">
            <input name="excel_file" type="file" required="required">
            <button type="submit" class="submit-import">Import</button>
          </form>
        </div>
        <!-- Content -->
        <div id="content">
          <!-- Box 1 -->
          <div id="box1" class="container-box layer-1">
            <div id="header">
              <h5 class="font-md header-left">Business Sector</h5>
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
              <?php if($tableState == "search"):?>
              <div id="custom-breadcrumb" class="custom-breadcrumb font-sm left-item">
                <span>
                  Search: &nbsp;<?php echo $searchIn . " > " . $searchBy . " > " . $search ?>
                </span>
              </div>
              <a href="input.php?unset-search=show" id="unset-search" class="custom-link font-md left-item">
                <span>Unset search</span>
              </a>
              <?php else:?>
              <div id="custom-search" class="custom-search left-item">
                <form action="input.php" method="get" autocomplete="off">
                  <input type="text" id="search-in" name="search-in" style="display: none;">
                  <select id="search-by" name="search-by" class="font-sm">
                    <option value="hawb">No.HAWB/BL</option>
                    <option value="mawb">No.MAWB/BL</option>
                    <option value="aju">No.Aju</option>
                    <option value="inv">No.Invoice</option>
                    <option value="eta">Period(ETA)</option>
                  </select>
                  <input
                    id="search-field"
                    class="custom-input font-sm"
                    name="search"
                    type="text"
                    placeholder="Search.."
                  />
                  <button id="search-btn" class="right-item" type="submit" name="set-search">
                    <img src="img/icons/search.svg" alt="" />
                  </button>
                </form>
              </div>
              <!-- Links to add a report for all sector -->
              <a href="input.php?add-report=import/chemical" id="add-imp-chem" class="custom-link font-md left-item" name="add-imp-chem">
                <img src="img/icons/plus.svg" alt="" />
                <span>Add new report</span>
              </a>
              <a href="input.php?add-report=import/pharma" id="add-imp-phar" class="custom-link font-md left-item" name="add-imp-phar" style="display: none;">
                <img src="img/icons/plus.svg" alt="" />
                <span>Add new report</span>
              </a>
              <a href="input.php?add-report=export/chemical" id="add-exp-chem" class="custom-link font-md left-item" name="add-exp-chem" style="display: none;">
                <img src="img/icons/plus.svg" alt="" />
                <span>Add new report</span>
              </a>
              <a href="input.php?add-report=export/pharma" id="add-exp-phar" class="custom-link font-md left-item" name="add-exp-phar" style="display: none;">
                <img src="img/icons/plus.svg" alt="" />
                <span>Add new report</span>
              </a>
              <a
                href="#"
                id="import-report"
                class="custom-link font-md left-item"
                ><img src="img/icons/import.svg" alt="" />
                <span>Import data (.xlsx)</span>
              </a>
              <?php endif;?>
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
                  <?php if($searchIn == "Chemical - Import" || $searchIn == "Pharma - Import"):?>
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
                      <td id="tb1-col6"><a href="input.php?select-import=<?php echo $rep["rep_no"];?>">Select</a></td>
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
                      <td id="tb1-col6"><a href="input.php?select-export=<?php echo $rep["rep_no"];?>">Select</a></td>
                    </tr>
                  <?php endwhile;?>
                  </table>
                  <?php endif;?>
                </div>
                <?php else:?>
                <!-- Search Result Not Found -->
                <div class="default-vector left-item">
                  <img src="img/vectors/cant-found.svg" alt="">
                  <p class="font-md">Sorry, we couldn't find the report you search for</p>
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
                      <td id="tb1-col6"><a href="input.php?select-import=<?php echo $rep["rep_no"];?>">Select</a></td>
                    </tr>
                  <?php endwhile;?>
                  </table>
                </div>
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
                      <td id="tb1-col6"><a href="input.php?select-import=<?php echo $rep["rep_no"];?>">Select</a></td>
                    </tr>
                  <?php endwhile;?>
                  </table>
                </div>
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
                      <td id="tb1-col6"><a href="input.php?select-export=<?php echo $rep["rep_no"];?>">Select</a></td>
                    </tr>
                  <?php endwhile;?>
                  </table>
                </div>
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
                      <td id="tb1-col6"><a href="input.php?select-export=<?php echo $rep["rep_no"];?>">Select</a></td>
                    </tr>
                  <?php endwhile;?>
                  </table>
                </div>
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
          <!-- Box 2 -->
          <div id="box2" class="container-box layer-1">
            <div id="header">
              <h5 class="font-md header-left">Selected Report</h5>
            </div>
            <div id="sub-content">
              <?php if($formState == "import" || $formState == "export"):?>
              <div id="selected-info">
                <div id="info" class="custom-record">
                  <p>Sector</p>
                  <span>
                    <?php
                      if(isset($secState)){
                        echo $busSector."-".$secState;
                      } else {
                        echo $busSector;
                      }
                    ?>
                  <span>
                </div>
                <div id="info" class="custom-record">
                  <p>Period(ETA)</p>
                  <span><?php if($shpEta == ""){echo "-";}else{echo convDateSQL($shpEta);}?><span>
                </div>
                <div id="info" class="custom-record">
                  <p>HAWB/HABL</p>
                  <span><?php if($shpHawb == ""){echo "-";}else{echo $shpHawb;}?><span>
                </div>
                <div id="info" class="custom-record">
                  <p>MAWB/RWBL</p>
                  <span><?php if($shpMawb == ""){echo "-";}else{echo $shpMawb;}?><span>
                </div>
                <div id="info" class="custom-record">
                  <p>Custom Agent</p>
                  <span><?php if($cstmBrkr == ""){echo "-";}else{echo $cstmBrkr;}?><span>
                </div>
                <div id="info" class="custom-record">
                  <p>AF/SF</p>
                  <span><?php if($shpAfsf == ""){echo "-";}else{echo $shpAfsf;}?><span>
                </div>
                <div id="info" class="custom-record">
                  <p>Created by</p>
                  <span><?php if($crtdBy == ""){echo "-";}else{echo $crtdBy;}?><span>
                </div>
                <div id="info" class="custom-record">
                  <p>Created in</p>
                  <span><?php if($crtdTime == ""){echo "-";}else{echo convDateTimeSQL($crtdTime);}?><span>
                </div>
                <div id="info" class="custom-record">
                  <p>Last modifed by</p>
                  <span><?php if($modBy == ""){echo "-";}else{echo $modBy;}?><span>
                </div>
                <div id="info" class="custom-record">
                  <p>Modified in</p>
                  <span><?php if($modTime == ""){echo "-";}else{echo convDateTimeSQL($modTime);}?><span>
                </div>
              </div>
              <div id="selected-action">
                <?php if($submitState == "add"):?>
                <a id="save-btn" href="<?php if($formState == 'import'){echo 'javascript:saveImport();';}else{echo 'javascript:saveExport();';}?>" class="cyan-btn font-md layer-2">
                  <img src="img/icons/plus-white.svg" alt="">
                  <span>Create report</span>
                </a>
                <?php else:?>
                <a id="save-btn" href="<?php if($formState == 'import'){echo 'javascript:updateImport();';}else{echo 'javascript:updateExport();';}?>" class="cyan-btn font-md layer-2">
                  <img src="img/icons/save.svg" alt="">
                  <span>Save changes</span>
                </a>
                <a id="delete-btn" href="input.php?delete-<?php echo $formState . '=' . $repNo;?>" class="delete-btn font-md layer-2">
                  <img src="img/icons/trash.svg" alt="">
                  <span>Delete report</span>
                </a>
                <?php endif;?>
              </div>
              <?php else:?>
              <div class="default-form layer-1">
                <p class="font-sm">No report were selected yet..</p>
              </div>
              <?php endif;?>
            </div>
          </div>
          <!-- Box 3 -->
          <div id="box3" class="container-box layer-1">
            <div id="header">
              <h5 class="font-md header-left">Shipment Report</h5>
            </div>
            <div id="sub-content">
            <?php if($formState == "import"):?>
              <!-- Import Form -->
              <form id="shipping-report" method="post" action="input.php" autocomplete="off">
                <!-- Hidden input -->
                <input type="text" name="crt_by" id="crt_by" value="<?php echo $userData['user_name']?>" style="display: none;">
                <?php if($submitState == "edit"):?>
                <input type="text" name="rep_no" id="rep_no" value="<?php echo $repNo;?>" style="display: none;">
                <?php endif;?>
                <div id="left-col" class="shipping-col">
                  <!-- Shipping Info -->
                  <div id="shipping" class="form-section layer-1">
                    <div id="section-header" class="font-md">
                      <span>Shipping Info</span>
                    </div>
                    <table class="custom-form">
                      <tr>
                        <td class="input-label">MAWB/BL No.</td>
                        <td class="input"><input type="text" name="shp_mawb" id="shp_mawb" value="<?php echo $shpMawb;?>"></td>
                      </tr>
                      <tr>
                        <td class="input-label">HAWB<span class="mandatory">&nbsp;&nbsp;*</span></td>
                        <td class="input"><input type="text" name="shp_hawb" id="shp_hawb" value="<?php echo $shpHawb;?>" required="required"></td>
                      </tr>
                      <tr>
                        <td class="input-label">AF/SF</td>
                        <td class="input">
                          <select name="shp_afsf" id="shp_afsf">
                            <option value="AF" <?php if($shpAfsf == "AF"){ echo "selected";} ?>>AF</option>
                            <option value="SF" <?php if($shpAfsf == "SF"){ echo "selected";} ?>>SF</option>
                            <option value="Courier" <?php if($shpAfsf == "Courier"){ echo "selected";} ?>>Courier</option>
                            <option value="SF/CD" <?php if($shpAfsf == "SF/CD"){ echo "selected";} ?>>SF/CD</option>
                            <option value="AF/CD" <?php if($shpAfsf == "AF/CD"){ echo "selected";} ?>>AF/CD</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Flight No / Vessel</td>
                        <td class="input"><input type="text" name="shp_flve" id="shp_flve" value="<?php echo $shpFlve;?>"></td>
                      </tr>
                      <tr>
                        <td class="input-label">Shipper name</td>
                        <td class="input">
                          <input type="text" name="shp_shpr" id="shp_shpr" value="<?php echo $shpShpr;?>">
                          <div class="autofill-box layer-2" id="impShprList"></div>
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Aju no</td>
                        <td class="input"><input type="text" name="shp_aju" id="shp_aju" value="<?php echo $shpAju;?>"></td>
                      </tr>
                      <tr>
                        <td class="input-label">Qty Items</td>
                        <td class="input"><input type="text" name="shp_qty" id="shp_qty" value="<?php echo $shpQty;?>"></td>
                      </tr>
                      <tr>
                        <td class="input-label">Total pkgs</td>
                        <td class="input"><input type="text" name="shp_pkgs" id="shp_pkgs" value="<?php echo $shpPkgs;?>"></td>
                      </tr>
                      <tr>
                        <td class="input-label">Total weight (kg)</td>
                        <td class="input"><input type="text" name="shp_wght" id="shp_wght" value="<?php echo $shpWght;?>"></td>
                      </tr>
                      <tr>
                        <td class="input-label">Cbm</td>
                        <td class="input"><input type="text" name="shp_cbm" id="shp_cbm" value="<?php echo $shpCbm;?>"></td>
                      </tr>
                      <tr>
                        <td class="input-label">Forwarder agent<span class="mandatory">&nbsp;&nbsp;*</span></td>
                        <td class="input">
                          <input type="text" name="shp_fwdr" id="shp_fwdr" value="<?php echo $shpFwdr;?>" required="required">
                          <div class="autofill-box layer-2" id="impFwdrList"></div>
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">LCL 20"40"40"HC</td>
                        <td class="input">
                          <select name="shp_lcl" id="shp_lcl">
                            <option value='' <?php if($shpLcl == ''){ echo "selected";} ?>>-</option>
                            <option value='20"' <?php if($shpLcl == '20"'){ echo "selected";} ?>>20"</option>
                            <option value='40"' <?php if($shpLcl == '40"'){ echo "selected";} ?>>40"</option>
                            <option value='40"HC' <?php if($shpLcl == '40"HC'){ echo "selected";} ?>>40"HC</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">ETD</td>
                        <td class="input"><input type="date" name="shp_etd" id="shp_etd" value="<?php echo $shpEtd;?>"></td>
                      </tr>
                      <tr>
                        <td class="input-label">ETA</td>
                        <td class="input"><input type="date" name="shp_eta" id="shp_eta" value="<?php echo $shpEta;?>"></td>
                      </tr>
                      <tr>
                        <td class="input-label">Actual Arrival Date</td>
                        <td class="input"><input type="date" name="shp_arr_date" id="shp_arr_date" value="<?php echo $shpArrDate;?>" onchange="ataHandler();"></td>
                      </tr>
                      <tr>
                        <td class="input-label">Arrival Day</td>
                        <td class="input"><input type="text" name="shp_arr_day" id="shp_arr_day" value="<?php echo $shpArrDay;?>" readonly="readonly"></td>
                      </tr>
                      <tr>
                        <td class="input-label">NOA Recieved Date</td>
                        <td class="input"><input type="date" name="shp_noa" id="shp_noa" value="<?php echo $shpNoa;?>"></td>
                      </tr>
                      <tr>
                        <td class="input-label">App. LetterBC1.1 Date</td>
                        <td class="input"><input type="date" name="shp_app" id="shp_app" value="<?php echo $shpApp;?>"></td>
                      </tr>
                      <tr>
                        <td class="input-label">BC1.1 at PDE Manifest Date</td>
                        <td class="input"><input type="date" name="shp_pde" id="shp_pde" value="<?php echo $shpPde;?>"></td>
                      </tr>
                    </table>      
                  </div>
                  <!-- Supplier -->
                  <div id="supplier" class="form-section layer-1">
                    <div id="section-header" class="font-md">Supplier</div>
                    <table class="custom-form">
                      <tr>
                        <td class="input-label">Order no<span class="mandatory">&nbsp;&nbsp;*</span></td>
                        <td class="input">
                          <input type="text" name="sup_ordr" id="sup_ordr" value="<?php echo $supOrdr;?>" required="required">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Invoice no<span class="mandatory">&nbsp;&nbsp;*</span></td>
                        <td class="input">
                          <textarea name="sup_inv_no" id="sup_inv_no" cols="30" rows="5" required="required"><?php echo $supInvNo;?></textarea>
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Invoice Date</td>
                        <td class="input">
                          <input type="date" name="sup_inv_date" id="sup_inv_date" value="<?php echo $supInvDate;?>">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Currency<span class="mandatory">&nbsp;&nbsp;*</span></td>
                        <td class="input">
                          <select name="sup_curr" id="sup_curr">
                            <?php if($supCurr == ""):?>
                              <option value="" selected>-</option>
                            <?php else:?>
                              <option value="<?php echo $supCurr;?>" selected ><?php echo $supCurr;?></option>
                            <?php endif;?>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Value of Goods<span class="mandatory">&nbsp;&nbsp;*</span></td>
                        <td class="input">
                          <input type="number" name="sup_val" id="sup_val" value="<?php echo $supVal;?>" onkeyup="valOGHandler();" required="required">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Freight</td>
                        <td class="input">
                          <input type="number" name="sup_frgt" id="sup_frgt" value="<?php echo $supFrgt;?>" onkeyup="frgtHandler();">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Total</td>
                        <td class="input">
                          <input type="text" name="sup_tot" id="sup_tot" value="<?php echo $supTot;?>" readonly="readonly">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Collect</td>
                        <td class="input">
                          <select name="sup_coll" id="sup_coll">
                            <option value="Prepaid" <?php if($supColl == "Prepaid"){ echo "selected";} ?>>Prepaid</option>
                            <option value="Collect" <?php if($supColl == "Collect"){ echo "selected";} ?>>Collect</option>
                          </select>
                        </td>
                      </tr>
                    </table>
                  </div>
                  <!-- Customs Brokerages -->
                  <div id="customs" class="form-section layer-1">
                    <div id="section-header" class="font-md">Customs Brokerages</div>
                    <table class="custom-form">
                      <tr>
                        <td class="input-label">Customs Broker Agent</td>
                        <td class="input">
                          <select name="cstm_brkr" id="cstm_brkr">
                            <?php if($userData['user_auth'] == '(3rd)Speedmark'):?>
                              <option value="Speedmark">Speedmark</option>
                            <?php else:?>
                              <option value="" <?php if($cstmBrkr == ""){ echo "selected";} ?>>-</option>
                              <option value="Schenker" <?php if($cstmBrkr == "Schenker"){ echo "selected";} ?>>Schenker</option>
                              <option value="Speedmark" <?php if($cstmBrkr == "Speedmark"){ echo "selected";} ?>>Speedmark</option>
                            <?php endif;?>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Invoice No</td>
                        <td class="input">
                          <textarea name="cstm_inv_no" id="cstm_inv_no" cols="30" rows="3" style="overflow-y: auto"><?php echo $cstmInvNo;?></textarea>
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Invoice Recieved Date</td>
                        <td class="input">
                        <textarea name="cstm_rcvd" id="cstm_rcvd" cols="30" rows="3" style="overflow-y: auto;" placeholder="mm/dd/yyyy"><?php echo $cstmRcvd;?></textarea>
                        </td>
                      </tr>
                    </table>
                  </div>
                  <!-- Charges -->
                  <div id="charges" class="form-section layer-1">
                    <div id="section-header" class="font-md">Charges</div>
                    <table class="custom-form">
                      <tr>
                        <td class="input-label">Freight Cost</td>
                        <td class="input">
                          <input type="number" id="chrg_frgt" name="chrg_frgt" value="<?php echo $chrgFrgt;?>">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Import Duty</td>
                        <td class="input">
                          <input type="number" id="chrg_impr" name="chrg_impr" value="<?php echo $chrgImpr;?>">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">BM Duty</td>
                        <td class="input">
                          <input type="number" id="chrg_bm" name="chrg_bm" value="<?php echo $chrgBm;?>" onkeyup="bmHandler();">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Duty & Tax</td>
                        <td class="input">
                          <input type="number" id="chrg_duty" name="chrg_duty" value="<?php echo $chrgDuty;?>" readonly="readonly">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">WH Tax</td>
                        <td class="input">
                          <input type="number" id="chrg_wh" name="chrg_wh" value="<?php echo $chrgWh;?>" onkeyup="whHandler();">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">VAT</td>
                        <td class="input">
                          <input type="number" id="chrg_vat" name="chrg_vat" value="<?php echo $chrgVat;?>" onkeyup="vatHandler();">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Storage Cost</td>
                        <td class="input">
                          <input type="number" id="chrg_strg" name="chrg_strg" value="<?php echo $chrgStrg;?>" onkeyup="strgCHandler();">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Delivery Charges / Local Transport</td>
                        <td class="input">
                          <input type="number" id="chrg_dlv" name="chrg_dlv" value="<?php echo $chrgDlv;?>" onkeyup="dlvCHandler();">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Others</td>
                        <td class="input">
                          <input type="number" id="chrg_othr" name="chrg_othr" value="<?php echo $chrgOthr;?>" onkeyup="othrHandler();">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Total(w/o duty_tax)</td>
                        <td class="input">
                          <input type="number" id="chrg_wo_tax" name="chrg_wo_tax" value="<?php echo $chrgWoTax;?>" readonly="readonly">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">% BM</td>
                        <td class="input">
                          <input type="number" id="chrg_p_bm" name="chrg_p_bm" value="<?php echo $chrgPBm;?>" readonly="readonly">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">% Total</td>
                        <td class="input">
                          <input type="number" id="chrg_p_tot" name="chrg_p_tot" value="<?php echo $chrgPTot;?>" readonly="readonly">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Remarks</td>
                        <td class="input">
                          <select class="charge-remarks layer-1" id="chrg_rmrk" name="chrg_rmrk">
                              <?php if ((isset($secState)) && ($secState == "chemical")) :?>
                                <option value="MCLS" >MCLS</option>
                              <?php elseif ((isset($secState)) && ($secState == "pharma")) :?>
                                <option value="BRA" >BRA</option>
                              <?php elseif ((!isset($secState)) && ($chrgRmrk == "MCLS")) :?>
                                <option value="MCLS" >MCLS</option>
                              <?php elseif ((!isset($secState)) && ($chrgRmrk == "BRA")) :?>
                                <option value="BRA" >BRA</option>  
                              <?php else :?>
                                <option value="" >-</option>  
                              <?php endif;?>
                          </select>
                        </td>
                      </tr>
                    </table>
                  </div>
                </div>
                <div id="right-col" class="shipping-col">
                  <!-- Licenses -->
                  <div id="licenses" class="form-section layer-1">
                    <div id="section-header" class="font-md">Licenses</div>
                    <table class="custom-form">
                      <tr>
                        <td class="input-label">Required(from)</td>
                        <td class="input">
                          <input type="text" id="lcs_req" name="lcs_req" value="<?php echo $lcsReq;?>">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">BPOM Complete Date</td>
                        <td class="input">
                          <input type="date" name="lcs_bpom" id="lcs_bpom" value="<?php echo $lcsBpom;?>">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">COO Recieved Date</td>
                        <td class="input">
                          <input type="date" name="lcs_coo" id="lcs_coo" value="<?php echo $lcsCoo;?>">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">KH Date</td>
                        <td class="input">
                          <input type="date" name="lcs_kh" id="lcs_kh" value="<?php echo $lcsKh;?>">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Complete Doc Date</td>
                        <td class="input">
                          <input type="date" name="lcs_comp_doc" id="lcs_comp_doc" value="<?php echo $lcsCompDoc;?>">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Licenses Complete Date</td>
                        <td class="input">
                          <input type="date" name="lcs_comp" id="lcs_comp" value="<?php echo $lcsComp;?>">
                        </td>
                      </tr>
                    </table>
                  </div>
                  <!-- PIB -->
                  <div id="pib" class="form-section layer-1">
                    <div id="section-header" class="font-md">PIB</div>
                    <table class="custom-form">
                      <tr>
                        <td class="input-label">Issued</td>
                        <td class="input">
                          <input type="date" name="pib_issd" id="pib_issd" value="<?php echo $pibIssd;?>">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Confirm</td>
                        <td class="input">
                          <input type="date" name="pib_conf" id="pib_conf" value="<?php echo $pibConf;?>">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Remark</td>
                        <td class="input">
                          <input type="text" name="pib_rmrk" id="pib_rmrk" value="<?php echo $pibRmrk;?>">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Billing Date</td>
                        <td class="input">
                          <input type="date" name="pib_bill" id="pib_bill" value="<?php echo $pibBill;?>">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Paid / BPN</td>
                        <td class="input">
                          <input type="date" name="pib_paid" id="pib_paid" value="<?php echo $pibPaid;?>">
                        </td>
                      <tr>
                        <td class="input-label">Transfer</td>
                        <td class="input">
                          <input type="date" name="pib_trf" id="pib_trf" value="<?php echo $pibTrf;?>">
                        </td>
                      </tr>
                    </table>
                  </div>
                  <!-- SKEP Larangan -->
                  <div id="skep" class="form-section layer-1">
                    <div id="section-header" class="font-md">SKEP Larangan</div>
                    <table class="custom-form">
                      <tr>
                        <td class="input-label">Date</td>
                        <td class="input">
                          <input type="date" name="skep_date" id="skep_date" value="<?php echo $skepDate;?>">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Remarks</td>
                        <td class="input">
                          <input type="text" name="skep_rmrk" id="skep_rmrk" value="<?php echo $skepRmrk;?>">
                        </td>
                      </tr>
                    </table>
                  </div>
                  <!-- Inspection -->
                  <div id="inspection" class="form-section layer-1">
                    <div id="section-header" class="font-md">Inspection</div>
                    <table class="custom-form">
                      <tr>
                        <td class="input-label">Inspection</td>
                        <td class="input">
                          <input type="date" name="insp_date" id="insp_date" value="<?php echo $inspDate;?>">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Reasons</td>
                        <td class="input">
                          <input type="text" name="insp_rsn" id="insp_rsn" value="<?php echo $inspRsn;?>">
                        </td>
                      </tr>
                    </table>
                  </div>
                  <!-- SPPB Green Lane -->
                  <div id="sppb" class="form-section layer-1">
                    <div id="section-header" class="font-md">SPPB Green Lane</div>
                    <table class="custom-form">
                      <tr>
                        <td class="input-label">Date</td>
                        <td class="input">
                          <input type="date" name="sppb_date" id="sppb_date" value="<?php echo $sppbDate;?>" onchange="sppbHandler();">
                        </td>
                      </tr>
                    </table>
                  </div>
                  <!-- Release -->
                  <div id="release" class="form-section layer-1">
                    <div id="section-header" class="font-md">Release</div>
                    <table class="custom-form">
                      <tr>
                        <td class="input-label">Delivery</td>
                        <td class="input">
                          <input type="date" name="rls_dlv" id="rls_dlv" value="<?php echo $rlsDlv;?>" onchange="dlvHandler();">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">GRN Date</td>
                        <td class="input">
                          <input type="date" name="rls_grn" id="rls_grn" value="<?php echo $rlsGrn;?>" onchange="grnHandler();">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Clearence LT</td>
                        <td class="input">
                          <input type="text" name="rls_clr_lt" id="rls_clr_lt" value="<?php echo $rlsClrLt;?>" readonly="readonly">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Delivery LT</td>
                        <td class="input">
                          <input type="text" name="rls_dlv_lt" id="rls_dlv_lt" value="<?php echo $rlsDlvLt;?>" readonly="readonly">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">GRN LT</td>
                        <td class="input">
                          <input type="text" name="rls_grn_lt" id="rls_grn_lt" value="<?php echo $rlsGrnLt;?>" readonly="readonly">
                        </td>
                      </tr>
                    </table>
                  </div>
                  <!-- Storage -->
                  <div id="storage" class="form-section layer-1">
                    <div id="section-header" class="font-md">Storage</div>
                    <table class="custom-form">
                      <tr>
                        <td class="input-label">IN</td>
                        <td class="input">
                          <input type="date" name="strg_in" id="strg_in" value="<?php echo $strgIn;?>" readonly="readonly">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">OUT</td>
                        <td class="input">
                          <input type="date" name="strg_out" id="strg_out" value="<?php echo $strgOut;?>" readonly="readonly">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Num Days</td>
                        <td class="input">
                          <input type="number" name="strg_days" id="strg_days" value="<?php echo $strgDays;?>" readonly="readonly">
                        </td>
                      </tr>
                    </table>
                  </div>
                  <!-- Valuation -->
                  <div id="valuation" class="form-section layer-1">
                    <div id="section-header" class="font-md">Valuation</div>
                    <table class="custom-form">
                      <tr>
                        <td class="input-label">Date</td>
                        <td class="input">
                          <input type="date" name="val_date" id="val_date" value="<?php echo $valDate;?>">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Remark</td>
                        <td class="input">
                          <input type="text" name="val_rmrk" id="val_rmrk" value="<?php echo $valRmrk;?>">
                        </td>
                      </tr>
                    </table>
                  </div>
                  <!-- Historical Background -->
                  <div id="historical" class="form-section layer-1">
                    <div id="section-header" class="font-md">Historical Background</div>
                    <table class="custom-form">
                      <tr>
                        <td class="input">
                          <textarea name="hist_bg" id="hist_bg" cols="30" rows="10"><?php echo $histBg;?></textarea>
                        </td>
                      </tr>
                    </table>
                  </div>
                </div>
                <!-- Hidden Submit -->
                <?php if($submitState == "add"):?>
                <input type="submit" id="submit-import" name="submit-import" style="display: none;">
                <?php else:?>
                <input type="submit" id="update-import" name="update-import" style="display: none;">
                <?php endif;?>
              </form>
            <?php elseif($formState == "export"):?>
              <!-- Export Form -->
              <form id="shipping-report" method="post" action="input.php" autocomplete="off">
                <!-- Hidden input -->
                <input type="text" name="crt_by" id="crt_by" value="<?php echo $userData['user_name']?>" style="display: none;">
                <?php if($submitState == "edit"):?>
                <input type="text" name="rep_no" id="rep_no" value="<?php echo $repNo;?>" style="display: none;">
                <?php endif;?>
                <div id="left-col" class="shipping-col">
                  <!-- Shipping Info -->
                  <div id="shipping" class="form-section layer-1">
                    <div id="section-header" class="font-md">
                      <span>Shipping Info</span>
                      <div class="line"></div>
                    </div>
                    <table class="custom-form">
                      <tr>
                        <td class="input-label">MAWB/BL No.</td>
                        <td class="input"><input type="text" name="shp_mawb" id="shp_mawb" value="<?php echo $shpMawb; ?>"></td>
                      </tr>
                      <tr>
                        <td class="input-label">HAWB<span class="mandatory">&nbsp;&nbsp;*</span></td>
                        <td class="input"><input type="text" name="shp_hawb" id="shp_hawb" value="<?php echo $shpHawb; ?>" required="required"></td>
                      </tr>
                      <tr>
                        <td class="input-label">AF/SF</td>
                        <td class="input">
                          <select name="shp_afsf" id="shp_afsf">
                            <option value="AF" <?php if($shpAfsf == "AF"){echo "selected";}?>>AF</option>
                            <option value="SF" <?php if($shpAfsf == "SF"){echo "selected";}?>>SF</option>
                            <option value="Courier" <?php if($shpAfsf == "Courier"){echo "selected";}?>>Courier</option>
                            <option value="SF/CD" <?php if($shpAfsf == "SF/CD"){echo "selected";}?>>SF/CD</option>
                            <option value="AF/CD" <?php if($shpAfsf == "AF/CD"){echo "selected";}?>>AF/CD</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Flight No / Vessel</td>
                        <td class="input"><input type="text" name="shp_flve" id="shp_flve" value="<?php echo $shpFlve; ?>"></td>
                      </tr>
                      <tr>
                        <td class="input-label">Consignee<span class="mandatory">&nbsp;&nbsp;*</span></td>
                        <td class="input">
                          <input type="text" name="shp_cons" id="shp_cons" value="<?php echo $shpCons;?>" required="required">
                          <div class="autofill-box layer-2" id="expConsList"></div>
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Aju no</td>
                        <td class="input"><input type="text" name="shp_aju" id="shp_aju" value="<?php echo $shpAju; ?>"></td>
                      </tr>
                      <tr>
                        <td class="input-label">Qty Items</td>
                        <td class="input"><input type="text" name="shp_qty" id="shp_qty" value="<?php echo $shpQty; ?>"></td>
                      </tr>
                      <tr>
                        <td class="input-label">Total pkgs</td>
                        <td class="input"><input type="text" name="shp_pkgs" id="shp_pkgs" value="<?php echo $shpPkgs; ?>"></td>
                      </tr>
                      <tr>
                        <td class="input-label">Total weight (kg)</td>
                        <td class="input"><input type="text" name="shp_wght" id="shp_wght" value="<?php echo $shpWght; ?>"></td>
                      </tr>
                      <tr>
                        <td class="input-label">Cbm</td>
                        <td class="input"><input type="text" name="shp_cbm" id="shp_cbm" value="<?php echo $shpCbm; ?>"></td>
                      </tr>
                      <tr>
                        <td class="input-label">Forwarder agent</td>
                        <td class="input">
                          <input type="text" name="shp_fwdr" id="shp_fwdr" value="<?php echo $shpFwdr;?>">
                          <div class="autofill-box layer-2" id="expFwdrList"></div>
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">LCL 20"40"40"HC</td>
                        <td class="input">
                          <select name="shp_lcl" id="shp_lcl">
                            <option value='' <?php if($shpLcl == ''){echo "selected";}?>>-</option>
                            <option value='20"' <?php if($shpLcl == '20"'){echo "selected";}?>>20"</option>
                            <option value='40"' <?php if($shpLcl == '40"'){echo "selected";}?>>40"</option>
                            <option value='40"HC' <?php if($shpLcl == '40"HC'){echo "selected";}?>>40"HC</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Stuffing / Pickup</td>
                        <td class="input"><input type="date" name="shp_pick" id="shp_pick"  value="<?php echo $shpPick; ?>" onchange="pickHandler();"></td>
                      </tr>
                      <tr>
                        <td class="input-label">ETD</td>
                        <td class="input"><input type="date" name="shp_etd" id="shp_etd" value="<?php echo $shpEtd; ?>" onchange="etdHandler();"></td>
                      </tr>
                      <tr>
                        <td class="input-label">ETA</td>
                        <td class="input"><input type="date" name="shp_eta" id="shp_eta" value="<?php echo $shpEta; ?>"></td>
                      </tr>
                      <tr>
                        <td class="input-label">Actual Arrival Date</td>
                        <td class="input"><input type="date" name="shp_arr_date" id="shp_arr_date" value="<?php echo $shpArrDate; ?>" onchange="ataHandler();"></td>
                      </tr>
                      <tr>
                        <td class="input-label">Arrival Day</td>
                        <td class="input"><input type="text" name="shp_arr_day" id="shp_arr_day" value="<?php echo $shpArrDay; ?>" readonly="readonly"></td>
                      </tr>
                    </table>      
                  </div>
                  <!-- Invoice -->
                  <div id="invoice" class="form-section layer-1">
                    <div id="section-header" class="font-md">Invoice</div>
                    <table class="custom-form">
                      <tr>
                        <td class="input-label">Order no<span class="mandatory">&nbsp;&nbsp;*</span></td>
                        <td class="input">
                          <input type="text" name="inv_ordr" id="inv_ordr" value="<?php echo $invOrdr; ?>" required="required">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Invoice no<span class="mandatory">&nbsp;&nbsp;*</span></td>
                        <td class="input">
                          <textarea name="inv_no" id="inv_no" cols="30" rows="5" required="required"><?php echo $invNo;?></textarea>
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Invoice Date</td>
                        <td class="input">
                          <input type="date" name="inv_date" id="inv_date" value="<?php echo $invDate; ?>">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Currency<span class="mandatory">&nbsp;&nbsp;*</span></td>
                        <td class="input">
                          <select name="inv_curr" id="inv_curr">
                            <?php if($invCurr == ""):?>
                              <option value="" selected>-</option>
                            <?php else:?>
                              <option value="<?php echo $invCurr;?>" selected ><?php echo $invCurr;?></option>
                            <?php endif;?>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Value of Goods<span class="mandatory">&nbsp;&nbsp;*</span></td>
                        <td class="input">
                          <input type="number" name="inv_val" id="inv_val" value="<?php echo $invVal; ?>" onkeyup="valOGHandler();" required="required">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Freight</td>
                        <td class="input">
                          <input type="number" name="inv_frgt" id="inv_frgt" value="<?php echo $invFrgt; ?>" onkeyup="invFrgtHandler();">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Total</td>
                        <td class="input">
                          <input type="text" name="inv_tot" id="inv_tot"  value="<?php echo $invTot; ?>" readonly="readonly">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Collect</td>
                        <td class="input">
                          <select name="inv_coll" id="inv_coll">
                            <option value="Prepaid" <?php if($invColl == "Prepaid"){echo "selected";}?>>Prepaid</option>
                            <option value="Collect" <?php if($invColl == "Collect"){echo "selected";}?>>Collect</option>
                          </select>
                        </td>
                      </tr>
                    </table>
                  </div>
                  <!-- Customs Brokerages -->
                  <div id="customs" class="form-section layer-1">
                    <div id="section-header" class="font-md">Customs Brokerages</div>
                    <table class="custom-form">
                      <tr>
                        <td class="input-label">Customs Broker Agent</td>
                        <td class="input">
                          <select name="cstm_brkr" id="cstm_brkr">
                            <option value="Schenker" <?php if($cstmBrkr == "Schenker"){echo "selected";}?>>Schenker</option>
                            <option value="Speedmark" <?php if($cstmBrkr == "Speedmark"){echo "selected";}?>>Speedmark</option>
                            <option value="" <?php if($cstmBrkr == ""){echo "selected";}?>>-</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Invoice No</td>
                        <td class="input">
                          <textarea name="cstm_inv_no" id="cstm_inv_no" cols="30" rows="3" style="overflow-y: auto;"><?php echo $cstmInvNo; ?></textarea>
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Invoice Recieved Date</td>
                        <td class="input">
                        <textarea name="cstm_rcvd" id="cstm_rcvd" cols="30" rows="3" style="overflow-y: auto;" placeholder="mm/dd/yyyy"><?php echo $cstmRcvd; ?></textarea>
                        </td>
                      </tr>
                    </table>
                  </div>
                  <!-- Charges -->
                  <div id="charges" class="form-section layer-1">
                    <div id="section-header" class="font-md">Charges</div>
                    <table class="custom-form">
                      <tr>
                        <td class="input-label">Freight Cost</td>
                        <td class="input">
                          <input type="number" id="chrg_frgt" name="chrg_frgt" value="<?php echo $chrgFrgt; ?>" onkeyup="frgtHandler();">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Storage Cost</td>
                        <td class="input">
                          <input type="number" id="chrg_strg" name="chrg_strg" value="<?php echo $chrgStrg; ?>" onkeyup="strgHandler();">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Others</td>
                        <td class="input">
                          <input type="number" id="chrg_othr" name="chrg_othr" value="<?php echo $chrgOthr; ?>" onkeyup="othrHandler();">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Total</td>
                        <td class="input">
                          <input type="number" id="chrg_tot" name="chrg_tot" value="<?php echo $chrgTot; ?>" readonly="readonly">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Remarks</td>
                        <td class="input">
                          <select class="charge-remarks layer-1" id="chrg_rmrk" name="chrg_rmrk">
                              <?php if ((isset($secState)) && ($secState == "chemical")) :?>
                                <option value="MCLS" >MCLS</option>
                              <?php elseif ((isset($secState)) && ($secState == "pharma")) :?>
                                <option value="BRA" >BRA</option>
                              <?php elseif ((!isset($secState)) && ($chrgRmrk == "MCLS")) :?>
                                <option value="MCLS" >MCLS</option>
                              <?php elseif ((!isset($secState)) && ($chrgRmrk == "BRA")) :?>
                                <option value="BRA" >BRA</option>  
                              <?php else :?>
                                <option value="" >-</option>  
                              <?php endif;?>
                          </select>
                        </td>
                      </tr>
                    </table>
                  </div>
                </div>
                <div id="right-col" class="shipping-col">
                  <!-- Licenses -->
                  <div id="licenses" class="form-section layer-1">
                    <div id="section-header" class="font-md">Licenses</div>
                    <table class="custom-form">
                      <tr>
                        <td class="input-label">Required(from)</td>
                        <td class="input">
                          <input type="text" name="lcs_req" id="lcs_req" value="<?php echo $lcsReq; ?>">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">BPOM Complete Date</td>
                        <td class="input">
                          <input type="date" name="lcs_bpom" id="lcs_bpom" value="<?php echo $lcsBpom; ?>">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">COO Recieved Date</td>
                        <td class="input">
                          <input type="date" name="lcs_coo" id="lcs_coo" value="<?php echo $lcsCoo; ?>">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Complete Doc Date</td>
                        <td class="input">
                          <input type="date" name="lcs_comp_doc" id="lcs_comp_doc" value="<?php echo $lcsCompDoc; ?>" onchange="compHandler();">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Licenses Complete Date</td>
                        <td class="input">
                          <input type="date" name="lcs_comp" id="lcs_comp" value="<?php echo $lcsComp; ?>">
                        </td>
                      </tr>
                    </table>
                  </div>
                  <!-- PEB -->
                  <div id="peb" class="form-section layer-1">
                    <div id="section-header" class="font-md">PEB</div>
                    <table class="custom-form">
                      <tr>
                        <td class="input-label">Issued</td>
                        <td class="input">
                          <input type="date" name="peb_issd" id="peb_issd" value="<?php echo $pebIssd; ?>">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Confirm</td>
                        <td class="input">
                          <input type="date" name="peb_conf" id="peb_conf" value="<?php echo $pebConf; ?>">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Remark</td>
                        <td class="input">
                          <input type="text" name="peb_rmrk" id="peb_rmrk" value="<?php echo $pebRmrk; ?>">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Transfer</td>
                        <td class="input">
                          <input type="date" name="peb_trf" id="peb_trf" value="<?php echo $pebTrf; ?>">
                        </td>
                      </tr>
                    </table>
                  </div>
                  <!-- SKEP Larangan -->
                  <div id="skep" class="form-section layer-1">
                    <div id="section-header" class="font-md">SKEP Larangan</div>
                    <table class="custom-form">
                      <tr>
                        <td class="input-label">Date</td>
                        <td class="input">
                          <input type="date" name="skep_date" id="skep_date" value="<?php echo $skepDate; ?>">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Remarks</td>
                        <td class="input">
                          <input type="text" name="skep_rmrk" id="skep_rmrk" value="<?php echo $skepRmrk; ?>">
                        </td>
                      </tr>
                    </table>
                  </div>
                  <!-- Inspection -->
                  <div id="inspection" class="form-section layer-1">
                    <div id="section-header" class="font-md">Inspection</div>
                    <table class="custom-form">
                      <tr>
                        <td class="input-label">Date</td>
                        <td class="input">
                          <input type="date" name="insp_date" id="insp_date" value="<?php echo $inspDate; ?>">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Reasons</td>
                        <td class="input">
                          <input type="text" name="insp_rsn" id="insp_rsn" value="<?php echo $inspRsn; ?>">
                        </td>
                      </tr>
                    </table>
                  </div>
                  <!-- NPE Green Lane -->
                  <div id="npe" class="form-section layer-1">
                    <div id="section-header" class="font-md">NPE Green Lane</div>
                    <table class="custom-form">
                      <tr>
                        <td class="input-label">Date</td>
                        <td class="input">
                          <input type="date" name="npe_date" id="npe_date" value="<?php echo $npeDate; ?>" onchange="npeHandler();">
                        </td>
                      </tr>
                    </table>
                  </div>
                  <!-- Recieved -->
                  <div id="recieved" class="form-section layer-1">
                    <div id="section-header" class="font-md">Recieved</div>
                    <table class="custom-form">
                      <tr>
                        <td class="input-label">Delivery</td>
                        <td class="input">
                          <input type="date" name="rcvd_dlv" id="rcvd_dlv" value="<?php echo $rcvdDlv; ?>" onchange="dlvHandler();">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">GRN Date</td>
                        <td class="input">
                          <input type="date" name="rcvd_grn" id="rcvd_grn" value="<?php echo $rcvdGrn; ?>" onchange="grnHandler();">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Clearence LT</td>
                        <td class="input">
                          <input type="text" name="rcvd_clr_lt" id="rcvd_clr_lt" value="<?php echo $rcvdClrLt; ?>" readonly="readonly">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Delivery LT</td>
                        <td class="input">
                          <input type="text" name="rcvd_dlv_lt" id="rcvd_dlv_lt" value="<?php echo $rcvdDlvLt; ?>" readonly="readonly">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">GRN LT</td>
                        <td class="input">
                          <input type="text" name="rcvd_grn_lt" id="rcvd_grn_lt" value="<?php echo $rcvdGrnLt; ?>" readonly="readonly">
                        </td>
                      </tr>
                    </table>
                  </div>
                  <!-- Storage -->
                  <div id="storage" class="form-section layer-1">
                    <div id="section-header" class="font-md">Storage</div>
                    <table class="custom-form">
                      <tr>
                        <td class="input-label">IN</td>
                        <td class="input">
                          <input type="date" name="strg_in" id="strg_in" value="<?php echo $strgIn; ?>" readonly="readonly">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">OUT</td>
                        <td class="input">
                          <input type="date" name="strg_out" id="strg_out" value="<?php echo $strgOut; ?>" readonly="readonly">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Num Days</td>
                        <td class="input">
                          <input type="number" name="strg_days" id="strg_days" value="<?php echo $strgDays; ?>" readonly="readonly">
                        </td>
                      </tr>
                    </table>
                  </div>
                  <!-- Valuation -->
                  <div id="valuation" class="form-section layer-1">
                    <div id="section-header" class="font-md">Valuation</div>
                    <table class="custom-form">
                      <tr>
                        <td class="input-label">Date</td>
                        <td class="input">
                          <input type="date" name="val_date" id="val_date" value="<?php echo $valDate; ?>">
                        </td>
                      </tr>
                      <tr>
                        <td class="input-label">Remark</td>
                        <td class="input">
                          <input type="text" name="val_rmrk" id="val_rmrk" value="<?php echo $valRmrk; ?>">
                        </td>
                      </tr>
                    </table>
                  </div>
                  <!-- Historical Background -->
                  <div id="historical" class="form-section layer-1">
                    <div id="section-header" class="font-md">Historical Background</div>
                    <table class="custom-form">
                      <tr>
                        <td class="input">
                          <textarea name="hist_bg" id="hist_bg" cols="30" rows="10"><?php echo $histBg; ?></textarea>
                        </td>
                      </tr>
                    </table>
                  </div>
                </div>
                <!-- Hidden Submit -->
                <?php if($submitState == "add"):?>
                <input type="submit" id="submit-export" name="submit-export" style="display: none;">
                <?php else:?>
                <input type="submit" id="update-export" name="update-export" value="test" style="display: none;">
                <?php endif;?>
              </form>
            <?php else :?>
              <!-- Null Form -->
              <div class="default-form layer-1">
                <p class="font-sm">You haven't requested an action on any report yet..</p>
              </div>
            <?php endif;?>
            </div>
          </div>
          <!-- Box 4 -->
          <div id="box4" class="container-box layer-1">
            <div id="header">
              <h5 class="font-md header-left">Attached Files</h5>
            </div>
            <div id="sub-content">
              <?php if( ($formState == "import" && $shpHawb != "" ) || ($formState == "export" && $shpHawb != "") ):?>
              <div id="custom-table-2" class="left-item font-sm">
                <table class="custom-table">
                  <?php
                    // Fetch files
                    $attFile = $conn->query("SELECT * FROM `files` WHERE `file_hawb` = '$shpHawb'");
                  ?>
                  <tr>
                    <th id="tb2-col1">File name</th>
                    <th id="tb2-col2">Attached by</th>
                    <th id="tb2-col3"></th>
                  </tr>
                  <?php while ($file = $attFile->fetch_assoc()):?>
                  <tr>
                    <td id="tb2-col1"><?php echo $file['file_name'];?></td>
                    <td id="tb2-col2"><?php echo $file['file_by'];?></td>
                    <td id="tb2-col3">
                    <a href="input.php?delete-file=<?php echo $repNo; ?>/<?php echo $shpHawb;?>/<?php echo $file['file_name'];?>/<?php echo $formState?>" class="cross-btn">
                      <img src="img/icons/cross.svg" alt="">
                    </a></td>
                  </tr>
                  <?php endwhile;?>
                </table>
              </div>
              <div class="upload-container left-item layer-2">
                <form action="input.php" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="rep_no" value="<?=$repNo;?>"/>
                  <input type="hidden" name="file_sector" value="<?=$formState;?>"/>
                  <input type="text" name="file_aju" id="file_aju" value="<?php echo $shpAju;?>" style="display: none;">
                  <input type="text" name="file_hawb" id="file_hawb" value="<?php echo $shpHawb;?>" style="display: none;">
                  <input type="text" name="user_name" id="user_name" value="<?php echo $userData['user_name'];?>" style="display: none;">
                  <input type="file" name="upload-file" id="upload-file" hidden="hidden">
                  <button type="button" id="upload-btn"><span id="upload-text">Choose a file..</span></button>
                  <input type="submit" id="upload-submit" name="submit-upload" value="">
                </form>
              </div>
              <?php else:?>
              <div class="default-form layer-1">
                <p class="font-sm">No file selected</p>
              </div>
              <?php endif;?>
            </div>
          </div>
        </div>
      </div>
    </div>
<!-- Script -->
<script type="text/javascript" src="js/upload-btn.js"></script>
<script type="text/javascript" src="js/input-action.js"></script>
<script type="text/javascript" src="js/alert.js"></script>
<script type="text/javascript" src="js/curr-array.js"></script>
<?php if($formState == "import"):?>
  <script type="text/javascript" src="js/import-autofill.js"></script> 
<?php else:?>
  <script type="text/javascript" src="js/export-autofill.js"></script>
<?php endif;?>
<!-- Footer -->
<?php include 'includes/footer.php' ?>
