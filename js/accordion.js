// JavaScript for Simple FAQ Accordion plugin
// Handles the toggle behavior of FAQ accordion items using click events.

document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".sfaq-accordion-item").forEach(function (item) {
    var title = item.querySelector(".sfaq-accordion-title");
    var icon = title.querySelector(".sfaq-icon");
    var content = item.querySelector(".sfaq-accordion-content");
    title.addEventListener("click", function () {
      var active = title.classList.toggle("active");
      icon.textContent = active ? "–" : "+";
      content.style.display = active ? "block" : "none";
    });
  });
});
