/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*******************************************!*\
  !*** ./resources/js/modules/getCookie.js ***!
  \*******************************************/
/**
 * Get a specified cookie
 * @param {string} cookieName
 * @returns {string}
 */
function getCookie(cookieName) {
  var name = "".concat(cookieName, "="),
      decodedCookie = decodeURIComponent(document.cookie),
      cookieParts = decodedCookie.split(";");

  for (var i = 0; i < cookieParts.length; i++) {
    var cookiePart = cookieParts[i];

    while (cookiePart.charAt(0) === " ") {
      cookiePart = cookiePart.substring(1);
    }

    if (cookiePart.indexOf(name) === 0) {
      return cookiePart.substring(name.length, cookiePart.length);
    }
  }

  return "";
} // export function


window.getCookie = getCookie;
/******/ })()
;