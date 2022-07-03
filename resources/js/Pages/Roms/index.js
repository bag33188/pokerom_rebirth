const apiUrl = "http://pokerom_rebirth.test/public/api/version";
const romsContainer = document.getElementById("roms-container");
fetch(apiUrl)
    .then((response) => response.json())
    .then((data) => {
        $(() => {
            const apiVersion = data.version;
            romsContainer.setAttribute("data-version", apiVersion);
        });
    })
    .catch((e) => console.error(e));
