const disableDownloadFunctions = (key) => {
    document.getElementById(`download-${key}`).disabled = true;
    document.getElementById(`download-${key}`).style.cursor = "not-allowed";
    document.getElementById(`download-${key}`).style.backgroundColor =
        "#888888";
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
