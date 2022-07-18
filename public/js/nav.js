/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!************************************************!*\
  !*** ./resources/js/Pages/Navigation/index.js ***!
  \************************************************/
var getApiVersion = function getApiVersion() {
  fetch("http://pokerom_rebirth.test/public/api/version").then(function (response) {
    return response.json();
  }).then(function (data) {
    return console.log(data);
  })["catch"](function (e) {
    return console.error(e);
  });
};

getApiVersion();
/******/ })()
;