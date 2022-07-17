async function fetchCsrfToken() {
    const appUrl = "http://pokerom_rebirth.test/public";

    return await fetch(`${appUrl}/sanctum/csrf-cookie`, {
        method: "GET",
    });
}

let invokeToken = () => {
    fetchCsrfToken()
        .then((data) => {
            const token = getCookie("XSRF-TOKEN");
            if (token.length > 0) {
                window.csrfToken = token;
                // console.log(token);
            }
        })
        .catch((err) => console.error(err));
};

window.invokeToken = invokeToken;
