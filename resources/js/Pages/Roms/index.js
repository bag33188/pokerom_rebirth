async function getApiVersion() {
    const apiUrl = "http://pokerom_rebirth.test/api";
    const response = await fetch(`${apiUrl}/version`);
    if (!response.ok) {
        throw new Error(`An error has occurred: ${response.status}`);
    }
    return response.json();
}

const apiVersionResponse = async () => await getApiVersion();

apiVersionResponse()
    .then(({ version: apiVersion }) => {
        const romsContainer = document.getElementById("roms-container");
        let attrData = ["data-api-version", apiVersion];
        romsContainer.setAttribute(...attrData);
    })
    .catch((e) => console.error(e));
