function selectGraph() {
  var graph = document.getElementById("select-graph");
  var selectedGraph = graph.options[graph.selectedIndex].text;
  // Options Variable
  var param = document.getElementById("dayParam");
  // Logic
  switch (selectedGraph) {
    case "% Delivery LT":
      param.style.visibility = "visible";
      break;
    case "% Clearence LT":
      param.style.visibility = "visible";
      break;
    case "Avg. Delivery LT":
      param.style.visibility = "hidden";
      break;
    case "Avg. Clearence LT":
      param.style.visibility = "hidden";
      break;
    case "Local Charge & Avg.%":
      param.style.visibility = "hidden";
      break;
    case "Import Duty & Avg.%":
      param.style.visibility = "hidden";
      break;
    case "Cost / Kg":
      param.style.visibility = "hidden";
      break;
    default:
      param.style.visibility = "visible";
      break;
  }
}
