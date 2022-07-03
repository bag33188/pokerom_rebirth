const loadWelcomeContent = (username) => {
    const welcomeUsername = document.getElementById("welcome-username");
    const jsInsertHtmlComment = welcomeUsername.childNodes[0];
    const welcomeMessage = `welcome, ${username}!`;
    const capOpts = new CapitalizationOptions(true);
    let welcomeText = document.createTextNode(
        welcomeMessage.capitalize(capOpts)
    );
    if (jsInsertHtmlComment.nodeType === 8) {
        welcomeUsername.replaceChild(welcomeText, jsInsertHtmlComment);
    } else {
        welcomeUsername.appendChild(welcomeText);
    }
};

window.loadWelcomeContent = loadWelcomeContent;
