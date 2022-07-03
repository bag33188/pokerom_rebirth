const apiUrl = "http://pokerom_rebirth.test/public/api/version";
fetch(apiUrl)
    .then((response) => response.json())
    .then((data) => {
        $(() => {
            const apiVersion = data.version;
            const romsContainer = document.getElementById("roms-container");
            romsContainer.setAttribute("data-version", apiVersion);
        });
    })
    .catch((e) => console.error(e));
