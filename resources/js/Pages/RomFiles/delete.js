const disableDownloadFunctions = (key) => {
    const downloadRomFileBtn = document.getElementById(`download-${key}-btn`);
    downloadRomFileBtn.disabled = true;
    downloadRomFileBtn.style.cursor = "not-allowed";
    downloadRomFileBtn.style.backgroundColor = "#C0C0C0"; // HTML silver
};

function loadDeleteButtonSafeguards(key) {
    const deleteRomFileForm = document.getElementById(`delete-${key}`);
    const deleteRomFileBtn = document.getElementById(`delete-${key}-btn`);
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
