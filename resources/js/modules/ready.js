var $ = function (documentObject) {
    var ready = function (callback) {
        if (documentObject.readyState !== "loading") {
            callback();
        } else if (
            documentObject.addEventListener !== null &&
            documentObject.addEventListener !== undefined
        ) {
            documentObject.addEventListener(
                "DOMContentLoaded",
                callback,
                false
            );
        } else {
            documentObject.attachEvent("onreadystatechange", function () {
                if (documentObject.readyState === "complete") {
                    callback();
                }
            });
        }
    };
    if (typeof documentObject === "object") {
        return {
            ready: ready,
        };
    } else {
        console.log('hi')

        return ready(documentObject);
    }
};
console.log('hi')

window.$ = $;
