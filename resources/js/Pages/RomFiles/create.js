$(document).ready(function () {
    let uploadBtn;
    Array.prototype.slice
        .call(document.getElementById("submit-rom-file-btn").childNodes)
        .forEach((e) => {
            const BUTTON_NODE_NAME = "BUTTON";
            if (e.nodeName === BUTTON_NODE_NAME) uploadBtn = e;
        });
    const selectRomFilename = document.querySelector(
        "select[name=rom_filename]"
    );
    document
        .getElementById("rom-file-create-form")
        .addEventListener("submit", function () {
            uploadBtn.disabled = true;
            uploadBtn.textContent = "PLEASE WAIT....THIS COULD TAKE A WHILE";
            selectRomFilename.style.pointerEvents = "none";
            selectRomFilename.style.backgroundColor = "#F5F5F5"; // HTML WhiteSmoke
        });
});
