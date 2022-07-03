async function getApiVersion() {
    const apiUrl = "http://pokerom_rebirth.test/public/api/version";
    const response = await fetch(apiUrl);
    if (!response.ok) {
        throw new Error(`An error has occurred: ${response.status}`);
    }
    return response.json();
}

const loadApiVersionAttr = async () => {
    const { version: apiVersion } = await getApiVersion();
    const romsContainer = document.getElementById("roms-container");
    romsContainer.setAttribute("data-api-version", apiVersion);
};

loadApiVersionAttr().catch((e) => console.error(e));
