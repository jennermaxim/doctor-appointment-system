let profile = document.getElementById("profile");
let img = document.getElementById("img");
let inputFile = document.getElementById("inputFile");
let addProfile = document.querySelector(".add-profile");
let close = document.querySelector(".close");

profile.addEventListener("click", () => {
  addProfile.style.display = "block";
});

close.addEventListener("click", () => {
  addProfile.style.display = "none";
});

img.addEventListener("click", () => {
  inputFile.click();
});

inputFile.addEventListener("change", () => {
  img.src = URL.createObjectURL(inputFile.files[0]);
});
