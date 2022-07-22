$(document).ready(function () {
    let uploadBtn = document.querySelector("button[data-name=submit-rom-file]");
    const romFilenameField =
        document.forms["create-rom-file-form"]["rom_filename"];
    document.forms["create-rom-file-form"].addEventListener(
        "submit",
        function () {
            const _CRLF = "\r\n";
            uploadBtn.classList.add("white-space-pre");
            uploadBtn.disabled = true;
            uploadBtn.textContent =
                `PLEASE WAIT....${_CRLF}THIS COULD TAKE A WHILE`.capitalize(
                    new CapitalizationOptions(true, _CRLF)
                );
            romFilenameField.classList.add(
                "no-pointer-events",
                "bg-html-white-smoke"
            );
        }
    );
});
