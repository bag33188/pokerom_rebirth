const checkIfNodeIsComment = (node) => {
    const COMMENT_NODE_TYPE = 8;
    return node.nodeType === COMMENT_NODE_TYPE;
};

const createWelcomeMessage = (text) => {
    const capOpts = new CapitalizationOptions(true);
    return document.createTextNode(text.capitalize(capOpts));
};

const loadWelcomeContent = (username) => {
    const welcomeUsername = document.getElementById("welcome-username");
    const jsInsertHtmlComment = welcomeUsername.childNodes[0];
    const welcomeMessage = `welcome, ${username}!`;
    const welcomeText = createWelcomeMessage(welcomeMessage);
    if (checkIfNodeIsComment(jsInsertHtmlComment)) {
        welcomeUsername.replaceChild(welcomeText, jsInsertHtmlComment);
    } else {
        welcomeUsername.appendChild(welcomeText);
    }
};

window.loadWelcomeContent = loadWelcomeContent;
