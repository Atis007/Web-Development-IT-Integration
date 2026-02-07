const acc = document.getElementsByClassName("accordion");

for (let i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function () {
    this.classList.toggle("active");

    let panel = this.nextElementSibling;
    if (panel.style.display === "block") {
      panel.style.display = "none";
    } else {
      panel.style.display = "block";
    }
  });
}

document.getElementById("payButton").addEventListener("click", function () {
  alert("Thank you for your order!");
  window.location.href = BASE_URL;
});

document.getElementById("cancelButton").addEventListener("click", function () {
  if(confirm("Are you sure you want to cancel your order?")) {
    window.location.href = BASE_URL;
  }
});
