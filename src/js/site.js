import { mediaQueryAllMobile } from "./base/globals.js";

// Reload on resize

if (
  !mediaQueryAllMobile &&
  !document.body.classList.contains("wp-admin") &&
  !document.body.classList.contains("trp-editor-body") &&
  !document.body.classList.contains("login")
) {
  window.onresize = function () {
    location.reload();
  };
}

/* Open document ready */

document.addEventListener("DOMContentLoaded", function () {
  // Put your code here
}); // Close document ready
