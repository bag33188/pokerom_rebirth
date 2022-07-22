const disableDownloadFunction = (key) => {
    document.getElementById(`download-${key}`).disabled = true;
    document.getElementById(`download-${key}`).style.cursor = "not-allowed";
    document.getElementById(`download-${key}`).style.backgroundColor =
        "#808080";
};
function loadDeleteButtonSafeguards(key) {
    console.log(document.getElementById(`download-${key}`));

    let deleteRomFileForm = document.getElementById(`delete-${key}`);
    let deleteRomFileBtn = document.getElementById(`delete-${key}-btn`);
    deleteRomFileForm.addEventListener("submit", function () {
        document.getElementById(`delete-${key}-text`).textContent =
            "please wait!".toUpperCase();
        deleteRomFileBtn.disabled = true;
        deleteRomFileBtn.style.cursor = "not-allowed";
        disableDownloadFunction(key);
    });
}

window.loadDeleteButtonSafeguards = loadDeleteButtonSafeguards;
