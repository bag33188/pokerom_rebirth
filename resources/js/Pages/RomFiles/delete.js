const disableDownloadFunctions = (key) => {
    let downloadRomFileBtn = document.getElementById(`download-${key}`);
    downloadRomFileBtn.disabled = true;
    downloadRomFileBtn.style.cursor = "not-allowed";
    downloadRomFileBtn.style.backgroundColor = "#888888";
};

function loadDeleteButtonSafeguards(key) {
    let deleteRomFileForm = document.getElementById(`delete-${key}`);
    let deleteRomFileBtn = document.getElementById(`delete-${key}-btn`);
    deleteRomFileForm.addEventListener("submit", function () {
        document.getElementById(`delete-${key}-text`).textContent =
            "please wait!".toUpperCase();
        deleteRomFileBtn.disabled = true;
        deleteRomFileBtn.style.cursor = "not-allowed";
        // needs to its own function, logic will not be applied otherwise
        disableDownloadFunctions(key);
    });
}

window.loadDeleteButtonSafeguards = loadDeleteButtonSafeguards;
