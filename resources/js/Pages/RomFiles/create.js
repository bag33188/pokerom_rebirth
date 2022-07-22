$(document).ready(function () {
    let uploadBtn;
    Array.prototype.slice
        .call(document.getElementById("submit-rom-file-btn").childNodes)
        .forEach((e) => {
            const BUTTON_NODE_NAME = "BUTTON";
            if (e.nodeName === BUTTON_NODE_NAME) uploadBtn = e;
        });
    document
        .getElementById("rom-file-create-form")
        .addEventListener("submit", function () {
            uploadBtn.disabled = true;
            uploadBtn.textContent = "PLEASE WAIT....THIS COULD TAKE A WHILE";
            document.getElementById("romFile").style.pointerEvents = "none";
        });
});
