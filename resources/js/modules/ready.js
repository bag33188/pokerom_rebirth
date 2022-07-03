var $ = function (documentObject) {
    var ready = function (callback) {
        let a = documentObject;
        if (typeof a !== "object") {
            a = document;
        }
        if (a.readyState !== "loading") {
            callback();
        } else if (
            a.addEventListener !== null &&
            a.addEventListener !== undefined
        ) {
            a.addEventListener(
                "DOMContentLoaded",
                callback,
                false
            );
        } else {
            a.attachEvent("onreadystatechange", function () {
                if (a.readyState === "complete") {
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

window.$ = $;
