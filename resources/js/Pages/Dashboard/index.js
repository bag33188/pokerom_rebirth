/**
 * @name checkIfNodeIsComment
 * @description Checks if a given HTML node or child node is an HTML Comment
 *
 * @param {ChildNode|Node} node HTML node or child node
 * @returns {boolean} If the node or child node passed in is of type HTML Comment
 */
const checkIfNodeIsComment = (node) => {
    const COMMENT_NODE_TYPE = 8;
    return node.nodeType === COMMENT_NODE_TYPE;
};

/**
 * @name createHtmlTextNode
 * @summary Creates a document text node for page
 * @description Creates an html document text node from the text passed in.
 *
 * @param {string} text message to pass in for creating document text node
 * @returns {Text} Capitalized string from message (Capitalizes each word in the string)
 */
const createHtmlTextNode = (text) => {
    const capOpts = new CapitalizationOptions(true);
    return document.createTextNode(text.capitalize(capOpts));
};

/**
 * @name loadWelcomeContent
 * @summary Loads welcome content onto html page
 * @description Loads welcome message content on page
 *
 * @param {string} username Username to include in welcome message
 * @returns {void} `Welcome, ${username}`;
 */
let loadWelcomeContent = (username) => {
    const welcomeUsername = document.getElementById("welcome-username");
    const jsInsertHtmlComment = welcomeUsername.childNodes[0];
    const welcomeMessage = `welcome, ${username.capitalize()}!`;
    const welcomeText = createHtmlTextNode(welcomeMessage);
    if (checkIfNodeIsComment(jsInsertHtmlComment)) {
        welcomeUsername.replaceChild(welcomeText, jsInsertHtmlComment);
    } else {
        welcomeUsername.appendChild(welcomeText);
    }
};

/**
 * @name loadCopyrightYear
 * @description Loads the current year (dynamically) for the copyright statement.
 * @summary Get current year for copyright statement on page
 *
 * @returns {void}
 */
let loadCopyrightYear = () => {
    const copyrightYearElement = document.getElementById("copyright-year");
    const now = new Date();
    let currentYear = now.getFullYear();
    copyrightYearElement.textContent = currentYear.toString();
};

let loadEmulatorLinks = () => {
    let emulatorLinksList = document.getElementById("emulator-links");
    const anchorClasses = ["underline", "text-blue-400", "hover:text-blue-500"];
    /** @type {{href: string, text: string, name: string, target: '_blank'}[]} */
    const emulators = [
        {
            href: "https://desmume.org/",
            text: "DeSmuME",
            name: "desmume",
            target: "_blank",
        },
        {
            href: "https://www.emulator-zone.com/doc.php/gba/vboyadvance.html",
            text: "Visual Boy Advanced",
            name: "vba",
            target: "_blank",
        },
        {
            href: "https://citra-emu.org/",
            text: "Citra",
            name: "citra",
            target: "_blank",
        },
    ];
    emulators.forEach((emulator, index) => {
        let listItemElement = document.createElement("li");
        listItemElement.id = `emulator-${index + 1}`;
        let emulatorLinkElement = document.createElement("a");
        emulatorLinkElement.id = `${emulator.name}-emu`;
        emulatorLinkElement.href = emulator.href;
        emulatorLinkElement.text = emulator.text;
        emulatorLinkElement.target = emulator.target;
        emulatorLinkElement.classList.add(...anchorClasses);
        emulatorLinkElement.setAttribute("rel", "noreferrer");
        listItemElement.appendChild(emulatorLinkElement);
        emulatorLinksList.appendChild(listItemElement);
    });
};

// export functions
window.loadWelcomeContent = loadWelcomeContent;
window.loadCopyrightYear = loadCopyrightYear;
window.loadEmulatorLinks = loadEmulatorLinks;
