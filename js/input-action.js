// Submit Input
function saveImport() {
  const submitImport = document.getElementById("submit-import");
  submitImport.click();
}
function saveExport() {
  const submitExport = document.getElementById("submit-export");
  submitExport.click();
}
// Submit Update
function updateImport() {
  const updateImport = document.getElementById("update-import");
  updateImport.click();
}
function updateExport() {
  const updateExport = document.getElementById("update-export");
  updateExport.click();
}

// Import Data (Excel)
const importData = document.getElementById("import-data");
const importReport = document.getElementById("import-report");
importReport.addEventListener("click", function () {
  importData.style.display = "block";
});

// Close Floating Box
function closeFloat() {
  importData.style.display = "none";
}

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
  // Search-in Default
  document.getElementById("search-in").value = "Chemical - Import";
  // Import data sector Default
  document.getElementById("import-sector").value = "import";
  document.getElementById("sec-indicator").innerHTML =
    "Import - ( Import Document )";
}

// Business Sector
function selectSector() {
  // Business Sector Select
  const selSec = document.getElementById("select-sector");
  let selectedSec = selSec.options[selSec.selectedIndex].text;
  // Business Sector Table
  const impChem = document.getElementById("impChemTb");
  const impPhar = document.getElementById("impPharTb");
  const expChem = document.getElementById("expChemTb");
  const expPhar = document.getElementById("expPharTb");
  // New Report State
  // const addImport = document.getElementById("add-import");
  // const addExport = document.getElementById("add-export");
  const addImpChem = document.getElementById("add-imp-chem");
  const addImpPhar = document.getElementById("add-imp-phar");
  const addExpChem = document.getElementById("add-exp-chem");
  const addExpPhar = document.getElementById("add-exp-phar");
  // Logic
  switch (selectedSec) {
    case "Chemical - Import":
      impChem.style.display = "block";
      impPhar.style.display = "none";
      expChem.style.display = "none";
      expPhar.style.display = "none";
      document.getElementById("pending-indicator").innerText = impChemSum;
      document.getElementById("search-in").value = "Chemical - Import";
      document.getElementById("import-sector").value = "import";
      document.getElementById("sec-indicator").innerHTML =
        "Import - ( Import Document )";
      // addImport.style.display = "block";
      // addExport.style.display = "none";
      addImpChem.style.display = "block";
      addImpPhar.style.display = "none";
      addExpChem.style.display = "none";
      addExpPhar.style.display = "none";
      break;
    case "Chemical - Export":
      impChem.style.display = "none";
      impPhar.style.display = "none";
      expChem.style.display = "block";
      expPhar.style.display = "none";
      document.getElementById("pending-indicator").innerText = expChemSum;
      document.getElementById("search-in").value = "Chemical - Export";
      document.getElementById("import-sector").value = "export";
      document.getElementById("sec-indicator").innerHTML =
        "Import - ( Export Document )";
      // addImport.style.display = "none";
      // addExport.style.display = "block";
      addImpChem.style.display = "none";
      addImpPhar.style.display = "none";
      addExpChem.style.display = "block";
      addExpPhar.style.display = "none";
      break;
    case "Pharma - Import":
      impChem.style.display = "none";
      impPhar.style.display = "block";
      expChem.style.display = "none";
      expPhar.style.display = "none";
      document.getElementById("pending-indicator").innerText = impPharSum;
      document.getElementById("search-in").value = "Pharma - Import";
      document.getElementById("import-sector").value = "import";
      document.getElementById("sec-indicator").innerHTML =
        "Import - ( Import Document )";
      // addImport.style.display = "block";
      // addExport.style.display = "none";
      addImpChem.style.display = "none";
      addImpPhar.style.display = "block";
      addExpChem.style.display = "none";
      addExpPhar.style.display = "none";
      break;
    case "Pharma - Export":
      impChem.style.display = "none";
      impPhar.style.display = "none";
      expChem.style.display = "none";
      expPhar.style.display = "block";
      document.getElementById("pending-indicator").innerText = expPharSum;
      document.getElementById("search-in").value = "Pharma - Export";
      document.getElementById("import-sector").value = "export";
      document.getElementById("sec-indicator").innerHTML =
        "Import - ( Export Document )";
      // addImport.style.display = "none";
      // addExport.style.display = "block";
      addImpChem.style.display = "none";
      addImpPhar.style.display = "none";
      addExpChem.style.display = "none";
      addExpPhar.style.display = "block";
      break;
    default:
      impChem.style.display = "block";
      document.getElementById("pending-indicator").innerText = impChemSum;
      document.getElementById("search-in").value = "Chemical - Import";
      document.getElementById("import-sector").value = "import";
      document.getElementById("sec-indicator").innerHTML =
        "Import - ( Import Document )";
      // addImport.style.display = "block";
      addImpChem.style.display = "block";
      addImpPhar.style.display = "none";
      addExpChem.style.display = "none";
      addExpPhar.style.display = "none";
      break;
  }
}
