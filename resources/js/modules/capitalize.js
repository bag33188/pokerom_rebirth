/**
 * Capitalization Options Object Type Definition (JSDoc)
 * @typedef {{deep: boolean, depth: number, separator: string}} capitalizationOptions
 */

/**
 * Space Character Unicode Entity
 * @type {string}
 */
const spaceChar = "\u0020";

/**
 * @summary Capitalizes a string
 * @description By default this method capitalizes only the first word in a string.
 * @param {capitalizationOptions} options
 * @returns {string|null} capitalized string
 */
String.prototype.capitalize = function (
    options = {
        deep: false,
        separator: spaceChar,
        depth: 0,
    }
) {
    let { deep, separator, depth } = options;
    let strVal = this.trim();
    if (!strVal.length) return null;
    let strArr = strVal.split(separator);
    if (deep === true && depth > 0) {
        let strWordCount = strArr.length;
        if (depth > strWordCount) depth = strWordCount;
        let i = 0;
        do {
            strArr[i] =
                strArr[i][0].toUpperCase() + strArr[i].slice(1).toLowerCase();
            i++;
        } while (i < depth);
        return strArr.join(separator);
    } else if (deep === true && depth === 0) {
        return strArr
            .map((word) => word[0].toUpperCase() + word.slice(1).toLowerCase())
            .join(separator);
    } else {
        return strVal[0].toUpperCase() + strVal.slice(1).toLowerCase();
    }
};

/**
 * @summary Capitalization Options Object
 * @description Use this ES5 function/class to make a new options object for the **capitalize** function.
 * @param {boolean} [deep] whether to capitalize all words in the string or not (defaults to false).
 * @param {string} [separator] Set to any string value if you wish to distinguish the words in your string by a character other than space (default: space char)
 * @param {number} [depth] amount of words to capitalize in string
 * @returns {capitalizationOptions}
 * @constructor
 */
let CapitalizationOptions = function (
    deep = false,
    separator = spaceChar,
    depth = 0
) {
    this.deep = deep;
    this.depth = depth;
    this.separator = separator;
    return {
        deep: this.deep,
        depth: this.depth,
        separator: this.separator,
    };
};

// export prototype class
window.CapitalizationOptions = CapitalizationOptions;
