/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!********************************************!*\
  !*** ./resources/js/modules/capitalize.js ***!
  \********************************************/
/**
 * Capitalization Options Object Type Definition (JSDoc)
 * @typedef {{deep: boolean, depth: number, separator: string}} capitalizationOptions
 */

/**
 * Space Character Unicode Entity
 * @type {string}
 */
var spaceChar = " ";
/**
 * @summary Capitalizes a string
 * @description By default this method capitalizes only the first word in a string.
 * @param {capitalizationOptions} options
 * @returns {string|null} capitalized string
 */

String.prototype.capitalize = function () {
  var options = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {
    deep: false,
    depth: 0,
    separator: spaceChar
  };
  var deep = options.deep,
      depth = options.depth,
      separator = options.separator;
  var strVal = this.trim();
  if (!strVal.length) return null;
  var strArr = strVal.split(separator);

  if (deep === true && depth > 0) {
    var strWordCount = strArr.length;
    if (depth > strWordCount) depth = strWordCount;
    var i = 0;

    do {
      strArr[i] = strArr[i][0].toUpperCase() + strArr[i].slice(1).toLowerCase();
      i++;
    } while (i < depth);

    return strArr.join(separator);
  } else if (deep === true && depth === 0) {
    return strArr.map(function (word) {
      return word[0].toUpperCase() + word.slice(1).toLowerCase();
    }).join(separator);
  } else {
    return strVal[0].toUpperCase() + strVal.slice(1).toLowerCase();
  }
};
/**
 * @summary Capitalization Options Object
 * @description Use this ES5 function/class to make a new options object for the **capitalize** function.
 * @param {boolean} [deep] whether to capitalize all words in the string or not (defaults to false).
 * @param {number} [depth] amount of words to capitalize in string
 * @param {string} [separator] Set to any string value if you wish to distinguish the words in your string by a character other than space (default: space char)
 * @returns {capitalizationOptions}
 * @constructor
 */


var CapitalizationOptions = function CapitalizationOptions() {
  var deep = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : false;
  var depth = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 0;
  var separator = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : spaceChar;
  this.deep = deep;
  this.depth = depth;
  this.separator = separator;
  return {
    deep: this.deep,
    depth: this.depth,
    separator: this.separator
  };
}; // export prototype class


window.CapitalizationOptions = CapitalizationOptions;
/******/ })()
;