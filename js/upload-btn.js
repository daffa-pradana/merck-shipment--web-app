const uploadFile = document.getElementById("upload-file");
const uploadBtn = document.getElementById("upload-btn");
const uploadTxt = document.getElementById("upload-text");
const uploadSub = document.getElementById("upload-submit");
// Event Listener
uploadBtn.addEventListener("click", function () {
  uploadFile.click();
});
// Change Span
uploadFile.addEventListener("change", function () {
  if (uploadFile.value) {
    var fileSize = this.files[0].size / 1024 / 1024;
    if (fileSize > 8) {
      uploadSub.style.pointerEvents = "none";
      uploadTxt.innerHTML = "Can't upload more than 8 MB";
      uploadTxt.style.color = "#e61e50";
    } else {
      uploadSub.style.pointerEvents = "auto";
      uploadTxt.innerHTML = uploadFile.value.match(
        /[\/\\]([\w\d\s\.\-\(\)]+)$/
      )[1];
      uploadTxt.style.color = "#7d7d89";
    }
  } else {
    uploadTxt.innerHTML = "Choose a file..";
  }
});
