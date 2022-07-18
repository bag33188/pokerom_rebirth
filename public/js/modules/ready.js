/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!***************************************!*\
  !*** ./resources/js/modules/ready.js ***!
  \***************************************/
 // syntax: ES5

function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }

var $ = function $(callbackDocumentObj) {
  var ready = function ready(callback) {
    var docObj = callbackDocumentObj; // distinguish between $(function(){}) and $(document).ready(function(){})

    if (_typeof(docObj) !== "object") docObj = document;

    if (docObj.readyState !== "loading") {
      callback();
    } else if (docObj.addEventListener !== null && docObj.addEventListener !== undefined) {
      docObj.addEventListener("DOMContentLoaded", callback, false);
    } else {
      docObj.attachEvent("onreadystatechange", function () {
        if (docObj.readyState === "complete") {
          callback();
        }
      });
    }
  };

  if (_typeof(callbackDocumentObj) === "object") {
    return {
      ready: ready
    };
  } else {
    return ready(callbackDocumentObj);
  }
}; // export function


window.$ = $;
/******/ })()
;