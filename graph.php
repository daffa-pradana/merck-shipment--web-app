<?php $page = "graph"; //Set Page ?>
<?php include 'includes/header.php'; // Header ?>
<?php include 'includes/config.php'; // Config ?>
<?php include 'includes/graph-action.php'; // Action ?>
<!-- Container -->
<div id="container">
  <div id="main">
    <!-- Content -->
    <div id="content">
      <!-- Box 1 -->
      <div id="box1" class="container-box layer-1">
        <div id="header">
          <h5 class="font-md header-left">Preferences</h5>
        </div>
        <div id="sub-content">
          <form method="get" action="graph.php" autocomplete="off">
            <div class="custom-field">
              <span class="field-label font-md">Period (ETA)</span>
              <div class="field">
                <select name="select-year" id="select-year" class="font-sm" required="required">
                  <?php
                    // Populate options based on year parameter
                    $new_period = date("Y");
                    $count_period = $conn->query("SELECT COUNT(`shp_eta`) AS 'sum_p' FROM import");
                    $sum_period = mysqli_fetch_assoc($count_period);
                    if ($sum_period['sum_p'] > 0){
                      $old_query = $conn->query("SELECT MIN(YEAR(`shp_eta`)) AS 'oldest' FROM import");
                      $row = mysqli_fetch_assoc($old_query);
                      $old_period = $row['oldest'];
                      for ($i = $new_period; $i >= $old_period; $i--){
                        echo "<option value='".$i."'>".$i."</option>";
                      }
                    } else {
                      echo "<option value='".$new_period."'>".$new_period."</option>";
                    }   
                  ?>
                </select>
              </div>
            </div>
            <div class="custom-field">
              <span class="field-label font-md">Sector</span>
              <div class="field">
                <select name="select-sector" id="select-sector" class="font-sm" required="required">
                  <option value="MCLS">Chemicals</option>
                  <option value="BRA">Pharma</option>
                </select>
              </div>
            </div>
            <div class="custom-field">
              <span class="field-label font-md">Graph</span>
              <div class="field">
                <select name="select-graph" id="select-graph" class="font-sm" onchange="selectGraph();" required="required">
                  <option value="per_dlv_lt">% Delivery LT</option>
                  <option value="per_clr_lt">% Clearence LT</option>
                  <option value="avg_dlv_lt">Avg. Delivery LT</option>
                  <option value="avg_clr_lt">Avg. Clearence LT</option>
                  <option value="avg_loc_chrg">Avg. Local Charge</option>
                  <option value="avg_imp_duty">Avg. Import Duty</option>
                  <option value="cost_per_kg">Cost / Kg</option>
                </select>
              </div>
            </div>
            <div class="custom-field">
              <span class="field-label font-md">Custom Agent</span>
              <div class="field">
                <select name="select-agent" id="select-agent" class="font-sm" required="required">
                  <option value="Schenker">Schenker</option>
                  <option value="Speedmark">Speedmark</option>
                  <option value="Schenker & Speedmark">Schenker & Speedmark</option>
                </select>
              </div>
            </div>
            <div id="dayParam" class="custom-field" style="visibility: visible">
              <span class="field-label font-md">Parameter (Days)</span>
              <div class="field">
                <input type="number" name="parameter" id="">
              </div>
            </div>
            <button name="set-graph" id="set-btn" type="submit" class="cyan-btn font-md layer-2">
              Set
            </button>
          </form>
        </div>
      </div>
      <!-- Box 2 -->
      <div id="box2" class="container-box layer-1">
        <div id="header">
          <h5 class="font-md header-left">Graph</h5>
          <?php if ($agent != ""):?>
            <div id="custom-breadcrumb" class="custom-breadcrumb font-sm left-item">
              <span>
                Graph: &nbsp;<?php sectorInd($sector); echo " > "; graphInd($graph); echo " > " . $year . " > " . $agent ?>
              </span>
            </div>
            <a href="graph.php?unset-graph=" id="unset-graph" class="custom-link font-md left-item">
              <span>Unset graph</span>
            </a>
          <?php endif;?>
        </div>
        <div id="sub-content">
          <?php if($agent != ""):?>
            <div class="graph-container left-item">
              <canvas id="graphBar" aria-label="accessible-graph" role="img"></canvas>
            </div>
              <?php if($agent == "Schenker" || $agent == "Schenker"):?>
                <div class="legend-container left-item">
                  <img class="legend" src="img/icons/label-yellow.svg" alt="">
                  <span class="legend font-sm"><?php graphInd($graph);?></span>
                </div>
              <?php else:?>
                <div class="legend-container left-item">
                  <img class="legend" src="img/icons/label-yellow.svg" alt="">
                  <span class="legend font-sm">Speedmark</span>
                  <img class="legend" src="img/icons/label-purple.svg" alt="">
                  <span class="legend font-sm">Schenker</span>
                </div>
              <?php endif;?>
          <?php else:?>
            <!-- Graph not isn't set -->
            <div class="default-vector left-item">
              <img src="img/vectors/not-set.svg" alt="">
              <p class="font-md">Please set graph preferences to see the graph</p>
            </div>
          <?php endif;?>
        </div>
      </div>
      <!-- Box 3 -->
      <div id="box3" class="container-hidden"></div>
      <!-- Box 4 -->     
      <div id="box4" class="container-box layer-1">
        <div id="header">
          <h5 class="font-md header-left">Data</h5>
        </div>
        <div id="sub-content">
        <?php if($agent == "Schenker" || $agent == "Schenker"):?>
          <!-- Single Bar Table -->
          <div id="custom-table-1" class="left-item font-sm">
            <table class="custom-table">
              <tr>
                <th id="tb1-col1"><?php graphInd($graph);?></th>
                <th id="tb1-col2">Jan</th>
                <th id="tb1-col3">Feb</th>
                <th id="tb1-col4">Mar</th>
                <th id="tb1-col5">Apr</th>
                <th id="tb1-col6">May</th>
                <th id="tb1-col7">Jun</th>
                <th id="tb1-col8">Jul</th>
                <th id="tb1-col9">Aug</th>
                <th id="tb1-col10">Sep</th>
                <th id="tb1-col11">Oct</th>
                <th id="tb1-col12">Nov</th>
                <th id="tb1-col13">Dec</th>
              </tr>
              <tr>
                <th id="tb1-col1"></th>
                <td id="tb1-col2"><?php echo $jan;?></th>
                <td id="tb1-col3"><?php echo $feb;?></th>
                <td id="tb1-col4"><?php echo $mar;?></th>
                <td id="tb1-col5"><?php echo $apr;?></th>
                <td id="tb1-col6"><?php echo $may;?></th>
                <td id="tb1-col7"><?php echo $jun;?></th>
                <td id="tb1-col8"><?php echo $jul;?></th>
                <td id="tb1-col9"><?php echo $aug;?></th>
                <td id="tb1-col10"><?php echo $sep;?></th>
                <td id="tb1-col11"><?php echo $oct;?></th>
                <td id="tb1-col12"><?php echo $nov;?></th>
                <td id="tb1-col13"><?php echo $dec;?></th>
              </tr>
            </table>
          </div>
        <?php elseif($agent == "Schenker & Speedmark"):?>
          <!-- Two Bar Table -->
          <div id="custom-table-1" class="left-item font-sm">
            <table class="custom-table">
              <tr>
                <th id="tb1-col1"><?php graphInd($graph);?></th>
                <th id="tb1-col2">Jan</th>
                <th id="tb1-col3">Feb</th>
                <th id="tb1-col4">Mar</th>
                <th id="tb1-col5">Apr</th>
                <th id="tb1-col6">May</th>
                <th id="tb1-col7">Jun</th>
                <th id="tb1-col8">Jul</th>
                <th id="tb1-col9">Aug</th>
                <th id="tb1-col10">Sep</th>
                <th id="tb1-col11">Oct</th>
                <th id="tb1-col12">Nov</th>
                <th id="tb1-col13">Dec</th>
              </tr>
              <tr>
                <th id="tb1-col1">Speedmark</th>
                <td id="tb1-col2"><?php echo $jan1;?></th>
                <td id="tb1-col3"><?php echo $feb1;?></th>
                <td id="tb1-col4"><?php echo $mar1;?></th>
                <td id="tb1-col5"><?php echo $apr1;?></th>
                <td id="tb1-col6"><?php echo $may1;?></th>
                <td id="tb1-col7"><?php echo $jun1;?></th>
                <td id="tb1-col8"><?php echo $jul1;?></th>
                <td id="tb1-col9"><?php echo $aug1;?></th>
                <td id="tb1-col10"><?php echo $sep1;?></th>
                <td id="tb1-col11"><?php echo $oct1;?></th>
                <td id="tb1-col12"><?php echo $nov1;?></th>
                <td id="tb1-col13"><?php echo $dec1;?></th>
              </tr>
              <tr>
                <th id="tb1-col1">Schenker</th>
                <td id="tb1-col2"><?php echo $jan2;?></th>
                <td id="tb1-col3"><?php echo $feb2;?></th>
                <td id="tb1-col4"><?php echo $mar2;?></th>
                <td id="tb1-col5"><?php echo $apr2;?></th>
                <td id="tb1-col6"><?php echo $may2;?></th>
                <td id="tb1-col7"><?php echo $jun2;?></th>
                <td id="tb1-col8"><?php echo $jul2;?></th>
                <td id="tb1-col9"><?php echo $aug2;?></th>
                <td id="tb1-col10"><?php echo $sep2;?></th>
                <td id="tb1-col11"><?php echo $oct2;?></th>
                <td id="tb1-col12"><?php echo $nov2;?></th>
                <td id="tb1-col13"><?php echo $dec2;?></th>
              </tr>
            </table>
          </div>
        <?php else:?>
          <!-- Null Form -->
          <div class="default-form layer-1">
            <p class="font-sm">You haven't set the graph preferences yet</p>
          </div>
        <?php endif;?>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Script -->
<script type="text/javascript" src="js/graph-action.js"></script>
<script type="text/javascript" src="js/Chart.js"></script>
<script type="text/javascript" src="js/alert.js"></script>
<!-- Chart Script -->
<?php if($agent == "Schenker" || $agent == "Schenker"):?>
  <!-- Single Bar Chart -->
  <script type="text/javascript">
  var ctx = document.getElementById('graphBar').getContext('2d');
  var graphBar = new Chart(ctx, {
      type: 'bar',
      data: {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
          datasets: [
            {
              label: 'Average CC Agent',
              data: [<?php echo $jan;?>,
                    <?php echo $feb;?>,
                    <?php echo $mar;?>,
                    <?php echo $apr;?>,
                    <?php echo $may;?>,
                    <?php echo $jun;?>,
                    <?php echo $jul;?>,
                    <?php echo $aug;?>,
                    <?php echo $sep;?>,
                    <?php echo $oct;?>,
                    <?php echo $nov;?>,
                    <?php echo $dec;?>],
              backgroundColor: [
                  'rgba(255,200,50,1)',
                  'rgba(255,200,50,1)',
                  'rgba(255,200,50,1)',
                  'rgba(255,200,50,1)',
                  'rgba(255,200,50,1)',
                  'rgba(255,200,50,1)',
                  'rgba(255,200,50,1)',
                  'rgba(255,200,50,1)',
                  'rgba(255,200,50,1)',
                  'rgba(255,200,50,1)',
                  'rgba(255,200,50,1)',
                  'rgba(255,200,50,1)'
              ],
              borderColor: [
                  'rgba(255,200,50,1)',
                  'rgba(255,200,50,1)',
                  'rgba(255,200,50,1)',
                  'rgba(255,200,50,1)',
                  'rgba(255,200,50,1)',
                  'rgba(255,200,50,1)',
                  'rgba(255,200,50,1)',
                  'rgba(255,200,50,1)',
                  'rgba(255,200,50,1)',
                  'rgba(255,200,50,1)',
                  'rgba(255,200,50,1)',
                  'rgba(255,200,50,1)'
              ],
              maxBarThickness: 20,
              borderWidth: 0
          }
        ]
      },
      options: {
          responsive: true,
          maintainAspectRatio: false,
          tooltips: {mode: 'index'},
          legend: {display: false},
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero: true
                  }
              }],
              xAxes: [{gridLines: {display: false}}]
          }
      }
  });
  </script>
<?php elseif($agent == "Schenker & Speedmark"):?>
  <!-- Two Bar Chart -->
  <script type="text/javascript">
    var ctx = document.getElementById('graphBar').getContext('2d');
    var graphBar = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [
          {
            // First Bar (Speedmark)
            label: 'Speedmark',
            data: [<?php echo $jan1;?>,
                  <?php echo $feb1;?>,
                  <?php echo $mar1;?>,
                  <?php echo $apr1;?>,
                  <?php echo $may1;?>,
                  <?php echo $jun1;?>,
                  <?php echo $jul1;?>,
                  <?php echo $aug1;?>,
                  <?php echo $sep1;?>,
                  <?php echo $oct1;?>,
                  <?php echo $nov1;?>,
                  <?php echo $dec1;?>],
            backgroundColor: [
                'rgba(255,200,50,1)',
                'rgba(255,200,50,1)',
                'rgba(255,200,50,1)',
                'rgba(255,200,50,1)',
                'rgba(255,200,50,1)',
                'rgba(255,200,50,1)',
                'rgba(255,200,50,1)',
                'rgba(255,200,50,1)',
                'rgba(255,200,50,1)',
                'rgba(255,200,50,1)',
                'rgba(255,200,50,1)',
                'rgba(255,200,50,1)'
            ],
            borderColor: [
                'rgba(255,200,50,1)',
                'rgba(255,200,50,1)',
                'rgba(255,200,50,1)',
                'rgba(255,200,50,1)',
                'rgba(255,200,50,1)',
                'rgba(255,200,50,1)',
                'rgba(255,200,50,1)',
                'rgba(255,200,50,1)',
                'rgba(255,200,50,1)',
                'rgba(255,200,50,1)',
                'rgba(255,200,50,1)',
                'rgba(255,200,50,1)'
            ],
            maxBarThickness: 20,
            borderWidth: 0
          },
          {
            // Second Bar (Schenker)
            label: 'Schenker',
            data: [<?php echo $jan2;?>,
                  <?php echo $feb2;?>,
                  <?php echo $mar2;?>,
                  <?php echo $apr2;?>,
                  <?php echo $may2;?>,
                  <?php echo $jun2;?>,
                  <?php echo $jul2;?>,
                  <?php echo $aug2;?>,
                  <?php echo $sep2;?>,
                  <?php echo $oct2;?>,
                  <?php echo $nov2;?>,
                  <?php echo $dec2;?>],
            backgroundColor: [
                'rgba(80, 50, 145, 1)',
                'rgba(80, 50, 145, 1)',
                'rgba(80, 50, 145, 1)',
                'rgba(80, 50, 145, 1)',
                'rgba(80, 50, 145, 1)',
                'rgba(80, 50, 145, 1)',
                'rgba(80, 50, 145, 1)',
                'rgba(80, 50, 145, 1)',
                'rgba(80, 50, 145, 1)',
                'rgba(80, 50, 145, 1)',
                'rgba(80, 50, 145, 1)',
                'rgba(80, 50, 145, 1)'
            ],
            borderColor: [
                'rgba(80, 50, 145, 1)',
                'rgba(80, 50, 145, 1)',
                'rgba(80, 50, 145, 1)',
                'rgba(80, 50, 145, 1)',
                'rgba(80, 50, 145, 1)',
                'rgba(80, 50, 145, 1)',
                'rgba(80, 50, 145, 1)',
                'rgba(80, 50, 145, 1)',
                'rgba(80, 50, 145, 1)',
                'rgba(80, 50, 145, 1)',
                'rgba(80, 50, 145, 1)',
                'rgba(80, 50, 145, 1)'
            ],
            maxBarThickness: 20,
            borderWidth: 0
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        tooltips: {mode: 'index'},
        legend: {display: false},
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }],
            xAxes: [{gridLines: {display: false}}]
        }
      }
    });
  </script>
<?php else:?>
  NULL
<?php endif;?>
<!-- Footer -->
<?php include 'includes/footer.php' ?>
