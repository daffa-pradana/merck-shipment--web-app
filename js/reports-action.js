// Pending Reports Indicator
var impChemSum = document.getElementById("imp-chem-sum").innerText;
var impPharSum = document.getElementById("imp-phar-sum").innerText;
var expChemSum = document.getElementById("exp-chem-sum").innerText;
var expPharSum = document.getElementById("exp-phar-sum").innerText;
// Indicator Default
document.getElementById("pending-indicator").innerText = impChemSum;

// Business Sector Table
const impChem = document.getElementById("impChemTb");
const impPhar = document.getElementById("impPharTb");
const expChem = document.getElementById("expChemTb");
const expPhar = document.getElementById("expPharTb");

// Table State
let tableState = document.getElementById("table-state").value;
if (tableState != "search") {
  // Pending Reports Indicator
  var impChemSum = document.getElementById("imp-chem-sum").innerText;
  var impPharSum = document.getElementById("imp-phar-sum").innerText;
  var expChemSum = document.getElementById("exp-chem-sum").innerText;
  var expPharSum = document.getElementById("exp-phar-sum").innerText;
  // Indicator Default
  document.getElementById("pending-indicator").innerText = impChemSum;
}

function selectSector() {
  // Business Sector Select
  const selSec = document.getElementById("select-sector");
  let selectedSec = selSec.options[selSec.selectedIndex].text;

  // Logic
  switch (selectedSec) {
    case "Chemical - Import":
      impChem.style.display = "block";
      impPhar.style.display = "none";
      expChem.style.display = "none";
      expPhar.style.display = "none";
      document.getElementById("pending-indicator").innerText = impChemSum;
      //   document.getElementById("search-in").value = "Chemical - Import";
      break;
    case "Chemical - Export":
      impChem.style.display = "none";
      impPhar.style.display = "none";
      expChem.style.display = "block";
      expPhar.style.display = "none";
      document.getElementById("pending-indicator").innerText = expChemSum;
      //   document.getElementById("search-in").value = "Chemical - Export";
      break;
    case "Pharma - Import":
      impChem.style.display = "none";
      impPhar.style.display = "block";
      expChem.style.display = "none";
      expPhar.style.display = "none";
      document.getElementById("pending-indicator").innerText = impPharSum;
      //   document.getElementById("search-in").value = "Pharma - Import";
      break;
    case "Pharma - Export":
      impChem.style.display = "none";
      impPhar.style.display = "none";
      expChem.style.display = "none";
      expPhar.style.display = "block";
      document.getElementById("pending-indicator").innerText = expPharSum;
      //   document.getElementById("search-in").value = "Pharma - Export";
      break;
    default:
      impChem.style.display = "block";
      document.getElementById("pending-indicator").innerText = impChemSum;
      document.getElementById("search-in").value = "Chemical - Import";
      break;
  }
}
