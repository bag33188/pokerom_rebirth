const disableDownloadFunctions = (romFileKey) => {
    const downloadRomFileBtn = document.getElementById(
        `download-${romFileKey}-btn`
    );
    downloadRomFileBtn.disabled = true;
    downloadRomFileBtn.classList.add("not-allowed", "bg-html-silver");
};

function loadDeleteButtonSafeguards(romFileKey) {
    const deleteRomFileBtn = document.getElementById(
        `delete-${romFileKey}-btn`
    );
    document.forms[`delete-${romFileKey}-form`].addEventListener(
        "submit",
        function () {
            deleteRomFileBtn.firstElementChild.textContent =
                "please wait!".toUpperCase();
            deleteRomFileBtn.disabled = true;
            deleteRomFileBtn.classList.add("not-allowed");
            // needs to its own function, logic will not be applied otherwise
            disableDownloadFunctions(romFileKey);
        }
    );
}

window.loadDeleteButtonSafeguards = loadDeleteButtonSafeguards;
