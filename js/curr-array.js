if (document.body.contains(document.getElementById("sup_curr"))) {
  var selectCurr = document.getElementById("sup_curr");
} else {
  var selectCurr = document.getElementById("inv_curr");
}

const curr = [
  "AUD",
  "CAD",
  "CHF",
  "EUR",
  "EURO",
  "GBP",
  "ICR",
  "IDR",
  "INR",
  "JPY",
  "LCL",
  "MYR",
  "RM",
  "SEK",
  "SGD",
  "THB",
  "UIDR",
  "USD",
];
for (var i = 0; i < curr.length; i++) {
  var listCurr = document.createElement("option");
  var txtCurr = document.createTextNode(curr[i]);
  listCurr.appendChild(txtCurr);
  listCurr.value = curr[i];
  selectCurr.insertBefore(listCurr, selectCurr.lastChild);
}
