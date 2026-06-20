document.addEventListener("DOMContentLoaded", () => {

const btn =
    document.getElementById("notificationBtn");

const panel =
    document.getElementById("notificationPanel");

if (!btn || !panel) return;

btn.addEventListener("click", () => {

    panel.classList.toggle("show");

});

});
