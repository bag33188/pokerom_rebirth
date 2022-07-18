/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!***********************************************!*\
  !*** ./resources/js/Pages/Dashboard/index.js ***!
  \***********************************************/
var checkIfNodeIsComment = function checkIfNodeIsComment(node) {
  var COMMENT_NODE_TYPE = 8;
  return node.nodeType === COMMENT_NODE_TYPE;
};

var createWelcomeMessage = function createWelcomeMessage(text) {
  var capOpts = new CapitalizationOptions(true);
  return document.createTextNode(text.capitalize(capOpts));
};

var loadWelcomeContent = function loadWelcomeContent(username) {
  var welcomeUsername = document.getElementById("welcome-username");
  var jsInsertHtmlComment = welcomeUsername.childNodes[0];
  var welcomeMessage = "welcome, ".concat(username, "!");
  var welcomeText = createWelcomeMessage(welcomeMessage);

  if (checkIfNodeIsComment(jsInsertHtmlComment)) {
    welcomeUsername.replaceChild(welcomeText, jsInsertHtmlComment);
  } else {
    welcomeUsername.appendChild(welcomeText);
  }
};

window.loadWelcomeContent = loadWelcomeContent;
/******/ })()
;