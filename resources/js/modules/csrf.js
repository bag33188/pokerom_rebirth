function getCookie(cname) {
    let name = `${cname}=`;
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(";");
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) === " ") {
            c = c.substring(1);
        }
        if (c.indexOf(name) === 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

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
