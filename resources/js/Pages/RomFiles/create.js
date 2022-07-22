$(document).ready(function () {
    let uploadBtn = document.querySelector("button[data-name=submit-rom-file]");
    const romFilenameField =
        document.forms["create-rom-file-form"]["rom_filename"];
    document.forms["create-rom-file-form"].addEventListener(
        "submit",
        function () {
            uploadBtn.style.whiteSpace = "pre";
            uploadBtn.disabled = true;
            uploadBtn.textContent =
                "PLEASE WAIT....\r\nTHIS COULD TAKE A WHILE".capitalize(
                    new CapitalizationOptions(true, "\r\n")
                );
            romFilenameField.style.pointerEvents = "none";
            romFilenameField.style.backgroundColor = "#F5F5F5"; // HTML WhiteSmoke
        }
    );
});
