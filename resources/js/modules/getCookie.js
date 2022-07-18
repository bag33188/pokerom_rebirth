/**
 * Get a specified cookie
 * @param {string} cookieName
 * @returns {string}
 */
function getCookie(cookieName) {
    let name = `${cookieName}=`,
        decodedCookie = decodeURIComponent(document.cookie),
        cookieParts = decodedCookie.split(";");
    for (let i = 0; i < cookieParts.length; i++) {
        let cookiePart = cookieParts[i];
        while (cookiePart.charAt(0) === "\u0020") {
            cookiePart = cookiePart.substring(1);
        }
        if (cookiePart.indexOf(name) === 0) {
            return cookiePart.substring(name.length, cookiePart.length);
        }
    }
    return "";
}

// export function
window.getCookie = getCookie;
