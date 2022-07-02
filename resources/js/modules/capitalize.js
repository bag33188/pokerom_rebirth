/**
 * @summary Capitalizes a string
 * @description By default this method capitalizes only the first word in a string.
 * @param {boolean} [deep] whether to capitalize all words in the string or not (defaults to false).
 * @param {number} [depth] amount of words to capitalize in string
 * @param {string|null} [separator] Set to any string value if you wish to distinguish the words in your string by a character other than space
 * @returns {string|null} capitalized string
 */
String.prototype.capitalize = function (
    deep = false,
    depth = 0,
    separator = null
) {
    let strVal = this.trim();
    if (!strVal.length) return null;
    const wordsSeparator = separator ? separator : " ";
    let strArr = strVal.split(wordsSeparator);
    if (deep === true && depth > 0) {
        let strWordCount = strArr.length;
        if (depth > strWordCount) depth = strWordCount;
        let i = 0;
        do {
            strArr[i] =
                strArr[i][0].toUpperCase() + strArr[i].slice(1).toLowerCase();
            i++;
        } while (i < depth);
        return strArr.join(wordsSeparator);
    } else if (deep === true && depth === 0) {
        return strArr
            .map((word) => word[0].toUpperCase() + word.slice(1).toLowerCase())
            .join(wordsSeparator);
    } else {
        return strVal[0].toUpperCase() + strVal.slice(1).toLowerCase();
    }
};
