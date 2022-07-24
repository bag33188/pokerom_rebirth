const fs = require("fs");
const path = require("path");

try {
    console.log("correcting manifest file");
    const __basedir__ = __dirname.replace(
        /([\x2F\x5C]scripts)([\x2F\x5C]helpers)/i,
        ""
    );

    let manifest = path.join(__basedir__, "public", "build", "manifest.json");
    const data = fs.readFileSync(manifest, { encoding: "utf8", flag: "r" });
    const correctedData = data.replace(/\x5C\u005C/g, "/");
    fs.writeFileSync(manifest, correctedData, { encoding: "utf8", flag: "w" });

    console.log("correction completed!");
} catch (e) {
    console.error(e);
}
