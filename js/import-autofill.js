// Shipper Ajax
$(document).ready(function () {
  $("#shp_shpr").keyup(function () {
    var impShpr = $(this).val();
    if (impShpr != "") {
      $.ajax({
        url: "includes/imp_shpr.php",
        method: "POST",
        data: { import_shipper: impShpr },
        success: function (data) {
          $("#impShprList").fadeIn();
          $("#impShprList").html(data);
        },
      });
    }
  });
  $(document).on("click", "#imprShprVal", function () {
    $("#shp_shpr").val($(this).text());
    $("#impShprList").fadeOut();
  });
});

// Forwarder Ajax
$(document).ready(function () {
  $("#shp_fwdr").keyup(function () {
    var impFwdr = $(this).val();
    if (impFwdr != "") {
      $.ajax({
        url: "includes/imp_fwdr.php",
        method: "POST",
        data: { import_forwarder: impFwdr },
        success: function (data) {
          $("#impFwdrList").fadeIn();
          $("#impFwdrList").html(data);
        },
      });
    }
  });
  $(document).on("click", "#imprFwdrVal", function () {
    $("#shp_fwdr").val($(this).text());
    $("#impFwdrList").fadeOut();
  });
});

// Get Arrival Day
function getArrDay() {
  var arrivalDate = document.getElementById("shp_arr_date").value;
  var dateFormat = new Date(arrivalDate);
  var day = dateFormat.getDay();
  var dayName = "";
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

// Get Supplier Total
function getSuppTot() {
  var total, a, b;
  a = document.getElementById("sup_val").value;
  b = document.getElementById("sup_frgt").value;
  if (a == "") {
    a = 0;
  } else {
    a = parseInt(a);
  }
  if (b == "") {
    b = 0;
  } else {
    b = parseInt(b);
  }
  total = a + b;
  document.getElementById("sup_tot").value = total;
}

// Get Duty & Tax
function getDutyTax() {
  var total, bmNum, whNum, vatNum;
  const bm = document.getElementById("chrg_bm").value;
  const wh = document.getElementById("chrg_wh").value;
  const vat = document.getElementById("chrg_vat").value;
  bmNum = parseInt(bm);
  whNum = parseInt(wh);
  vatNum = parseInt(vat);
  if (!isNaN(bmNum) && !isNaN(whNum) && !isNaN(vatNum)) {
    total = bmNum + whNum + vatNum;
  }
  document.getElementById("chrg_duty").value = total;
}

// Total (w/o duty_tax)
function getTotWoDuty() {
  var total, perTotal, strg, dlv, othr, val, totFloat, valFloat;
  val = document.getElementById("sup_val").value;
  strg = document.getElementById("chrg_strg").value;
  dlv = document.getElementById("chrg_dlv").value;
  othr = document.getElementById("chrg_othr").value;
  // strg value
  if (strg == "") {
    strg = 0;
  } else {
    strg = parseInt(strg);
  }
  // dlv value
  if (dlv == "") {
    dlv = 0;
  } else {
    dlv = parseInt(dlv);
  }
  // othr value
  if (othr == "") {
    othr = 0;
  } else {
    othr = parseInt(othr);
  }
  // Total value
  total = strg + dlv + othr;
  document.getElementById("chrg_wo_tax").value = total;
  // % Total value
  totFloat = parseFloat(total);
  valFloat = parseFloat(val);
  if (!isNaN(totFloat) && !isNaN(valFloat)) {
    result = (totFloat / valFloat) * 100;
    perTotal = result.toFixed(2);
  }
  document.getElementById("chrg_p_tot").value = perTotal;
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
  var sppbDate, ataDate, numDays;
  var sppb = document.getElementById("sppb_date").value;
  var ata = document.getElementById("shp_arr_date").value;
  sppbDate = intoDate(sppb);
  ataDate = intoDate(ata);
  if (!isNaN(ataDate) && !isNaN(sppbDate)) {
    numDays = days_between(sppbDate, ataDate);
    document.getElementById("rls_clr_lt").value = numDays;
  }
}

// Get Delivery LT
function getDlvLT() {
  var dlvDate, ataDate, numDays;
  var dlv = document.getElementById("rls_dlv").value;
  var ata = document.getElementById("shp_arr_date").value;
  dlvDate = intoDate(dlv);
  ataDate = intoDate(ata);
  if (!isNaN(ataDate) && !isNaN(dlvDate)) {
    numDays = days_between(dlvDate, ataDate);
    document.getElementById("rls_dlv_lt").value = numDays;
  }
}

// Get GRN LT
function getGRNLT() {
  var grnDate, dlvDate, numDays;
  var dlv = document.getElementById("rls_dlv").value;
  var grn = document.getElementById("rls_grn").value;
  dlvDate = intoDate(dlv);
  grnDate = intoDate(grn);
  if (!isNaN(grnDate) && !isNaN(dlvDate)) {
    numDays = days_between(grnDate, dlvDate);
    document.getElementById("rls_grn_lt").value = numDays;
  }
}

// Get Storage IN
function getIn() {
  var ataDate = document.getElementById("shp_arr_date").value;
  document.getElementById("strg_in").value = ataDate;
}

// Get Storage OUT
function getOut() {
  var dlv = document.getElementById("rls_dlv").value;
  document.getElementById("strg_out").value = dlv;
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

// Get % BM
function getPerBM() {
  var result, bmNum, valNum, fixedResult;
  const bm = document.getElementById("chrg_bm").value;
  const val = document.getElementById("sup_val").value;
  bmNum = parseFloat(bm);
  valNum = parseFloat(val);
  if (!isNaN(bmNum) && !isNaN(valNum)) {
    result = (bmNum / valNum) * 100;
    fixedResult = result.toFixed(2);
  }
  document.getElementById("chrg_p_bm").value = fixedResult;
}

// Value of Goods
function valOGHandler() {
  getSuppTot();
  getPerBM();
  getTotWoDuty();
}

// Freight Handler
function frgtHandler() {
  getSuppTot();
}

// Storage Cost Handler
function strgCHandler() {
  getTotWoDuty();
}

// Delivery Cost Handler
function dlvCHandler() {
  getTotWoDuty();
}

// Others Handler
function othrHandler() {
  getTotWoDuty();
}

// BM Handler
function bmHandler() {
  getDutyTax();
  getPerBM();
}

// WH Handler
function whHandler() {
  getDutyTax();
}

// VAT Handler
function vatHandler() {
  getDutyTax();
}

// ATA Handler
function ataHandler() {
  getArrDay();
  getClrLT();
  getDlvLT();
  getIn();
  getNumDays();
}

// SPPB Handler
function sppbHandler() {
  getClrLT();
}

// GRN Handler
function grnHandler() {
  getGRNLT();
}

// Delivery Handler
function dlvHandler() {
  getGRNLT();
  getDlvLT();
  getOut();
  getNumDays();
}
