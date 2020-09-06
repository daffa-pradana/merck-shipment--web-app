// Consignee Ajax
$(document).ready(function () {
  $("#shp_cons").keyup(function () {
    var shpCons = $(this).val();
    if (shpCons != "") {
      $.ajax({
        url: "includes/exp_cons.php",
        method: "POST",
        data: { export_consignee: shpCons },
        success: function (data) {
          $("#expConsList").fadeIn();
          $("#expConsList").html(data);
        },
      });
    }
  });
  $(document).on("click", "#expConsVal", function () {
    $("#shp_cons").val($(this).text());
    $("#expConsList").fadeOut();
  });
});

// Forwarder Ajax
$(document).ready(function () {
  $("#shp_fwdr").keyup(function () {
    var shpFwdr = $(this).val();
    if (shpFwdr != "") {
      $.ajax({
        url: "includes/exp_fwdr.php",
        method: "POST",
        data: { export_forwarder: shpFwdr },
        success: function (data) {
          $("#expFwdrList").fadeIn();
          $("#expFwdrList").html(data);
        },
      });
    }
  });
  $(document).on("click", "#expFwdrVal", function () {
    $("#shp_fwdr").val($(this).text());
    $("#expFwdrList").fadeOut();
  });
});

// Get Arrival Day
function getArrDay() {
  var arrivalDate = document.getElementById("shp_arr_date").value;
  var dateFormat = new Date(arrivalDate);
  var day = dateFormat.getDay();
  var dayName = "";
  //
  switch (day) {
    case 0:
      dayName = "Sunday";
      break;
    case 1:
      dayName = "Monday";
      break;
    case 2:
      dayName = "Tuesday";
      break;
    case 3:
      dayName = "Wednesday";
      break;
    case 4:
      dayName = "Thursday";
      break;
    case 5:
      dayName = "Friday";
      break;
    case 6:
      dayName = "Saturday";
      break;
    default:
      dayName = "";
  }
  document.getElementById("shp_arr_day").value = dayName;
}

// Into Date Functions
function intoDate(dateIn) {
  var dateOut = new Date(dateIn);
  return dateOut;
}

// Count Days Function
function days_between(date1, date2) {
  const ONE_DAY = 1000 * 60 * 60 * 24;
  const differenceMs = Math.abs(date1 - date2);
  return Math.floor(differenceMs / ONE_DAY);
}

// Get Clearence LT
function getClrLT() {
  var npeDate, compDate, numDays;
  var npe = document.getElementById("npe_date").value;
  var comp = document.getElementById("lcs_comp_doc").value;
  npeDate = intoDate(npe);
  compDate = intoDate(comp);
  if (!isNaN(npeDate) && !isNaN(compDate)) {
    numDays = days_between(npeDate, compDate);
    document.getElementById("rcvd_clr_lt").value = numDays;
  }
}

// Get Delivery LT
function getDlvLT() {
  var dlvDate, compDate, numDays;
  var dlv = document.getElementById("rcvd_dlv").value;
  var comp = document.getElementById("lcs_comp_doc").value;
  dlvDate = intoDate(dlv);
  compDate = intoDate(comp);
  if (!isNaN(compDate) && !isNaN(dlvDate)) {
    numDays = days_between(dlvDate, compDate);
    document.getElementById("rcvd_dlv_lt").value = numDays;
  }
}

// Get GRN LT
function getGRNLT() {
  var grnDate, dlvDate, numDays;
  var dlv = document.getElementById("rcvd_dlv").value;
  var grn = document.getElementById("rcvd_grn").value;
  dlvDate = intoDate(dlv);
  grnDate = intoDate(grn);
  if (!isNaN(grnDate) && !isNaN(dlvDate)) {
    numDays = days_between(grnDate, dlvDate);
    document.getElementById("rcvd_grn_lt").value = numDays;
  }
}

// Get Storage IN
function getIn() {
  var pick = document.getElementById("shp_pick").value;
  document.getElementById("strg_in").value = pick;
}

// Get Storage OUT
function getOut() {
  var etd = document.getElementById("shp_etd").value;
  document.getElementById("strg_out").value = etd;
}

// Get Storage Num Days
function getNumDays() {
  var inDate, outDate, numDays;
  var strgIn = document.getElementById("strg_in").value;
  var strgOut = document.getElementById("strg_out").value;
  inDate = intoDate(strgIn);
  outDate = intoDate(strgOut);
  if (!isNaN(inDate) && !isNaN(outDate)) {
    numDays = days_between(outDate, inDate);
    document.getElementById("strg_days").value = numDays;
  }
}

// Get Charge Total
function getTot() {
  var total, frgt, strg, othr;
  frgt = document.getElementById("chrg_frgt").value;
  strg = document.getElementById("chrg_strg").value;
  othr = document.getElementById("chrg_othr").value;
  if (frgt == "") {
    frgt = 0;
  } else {
    frgt = parseInt(frgt);
  }
  if (strg == "") {
    strg = 0;
  } else {
    strg = parseInt(strg);
  }
  if (othr == "") {
    othr = 0;
  } else {
    othr = parseInt(othr);
  }
  total = frgt + strg + othr;
  document.getElementById("chrg_tot").value = total;
}

// Get Invoice Total
function getInvTot() {
  var total, val, frgt;
  val = document.getElementById("inv_val").value;
  frgt = document.getElementById("inv_frgt").value;
  if (val == "") {
    val = 0;
  } else {
    val = parseInt(val);
  }
  if (frgt == "") {
    frgt = 0;
  } else {
    frgt = parseInt(frgt);
  }
  total = val + frgt;
  document.getElementById("inv_tot").value = total;
}

// ATA Handler
function ataHandler() {
  getArrDay();
}

// NPE Handler
function npeHandler() {
  getClrLT();
}

// Complete Doc Handler
function compHandler() {
  getClrLT();
  getDlvLT();
}

// Delivery Handler
function dlvHandler() {
  getDlvLT();
  getGRNLT();
}

// GRN hHandler
function grnHandler() {
  getGRNLT();
}

// Pickup Handler
function pickHandler() {
  getIn();
  getNumDays();
}

// ETD Handler
function etdHandler() {
  getOut();
  getNumDays();
}

// Freight Handler
function frgtHandler() {
  getTot();
}

// Storage Handler
function strgHandler() {
  getTot();
}

// Others Handler
function othrHandler() {
  getTot();
}

function valOGHandler() {
  getInvTot();
}

function invFrgtHandler() {
  getInvTot();
}
