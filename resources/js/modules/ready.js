var $ = function (documentObject) {
    try {
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
            ready(documentObject);
        }
    } catch (err) {
        throw err;
    }
};
