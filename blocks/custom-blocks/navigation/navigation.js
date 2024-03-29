import { mediaQueryAllMobile } from "../../../src/js/base/globals.js";

export function mobileMenu() {
  const menuToggle = document.getElementById("menuToggle");
  if (menuToggle) {
    menuToggle.addEventListener("click", function () {
      const mobileMenu = document.getElementById("mobile-menu");
      const zenfse_barboneHeader = document.querySelector(".zenfse_barbone-header");
      mobileMenu.classList.toggle("open-menu");
      zenfse_barboneHeader.classList.toggle("open-menu");

      if (mediaQueryAllMobile) {
        document.body.classList.toggle("fixed");
      }
    });
  }
}
mobileMenu();

if (document.querySelector(".zenfse_barbone-header")) {
  window.addEventListener("scroll", menuPadding);
  function menuPadding() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
      if (!mediaQueryAllMobile) {
        document.querySelector(".zenfse_barbone-header").style.paddingTop = "0.5rem";
      }
    } else {
      if (!mediaQueryAllMobile) {
        document.querySelector(".zenfse_barbone-header").style.paddingTop = "2rem";
      }
    }
  }
}
