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

const payButton = document.getElementById("payButton");
if (payButton) {
  payButton.addEventListener("click", function () {
  if (typeof orderData === "undefined") {
    alert("Error: orderData is undefined!");
    return;
  }

  const targetUrl = BASE_URL + "save-order";

  fetch(targetUrl, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(orderData),
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.status === "success") {
        alert("Successfully ordered!");
        window.location.href = BASE_URL;
      } else {
        alert("Error: " + data.message);
      }
    })
    .catch((err) => console.error("Error: ", err));
  });
}

const cancelButton = document.getElementById("cancelButton");
if (cancelButton) {
  cancelButton.addEventListener("click", function () {
    if (confirm("Are you sure you want to cancel your order?")) {
      window.location.href = BASE_URL;
    }
  });
}
