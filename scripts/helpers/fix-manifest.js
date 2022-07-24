const fs = require("fs");
const path = require("path");

try {
    const __basedir__ = __dirname.replace(
        /([\/\\]scripts)([\/\\]helpers)/i,
        ""
    );

    let manifest = path.join(__basedir__, "public", "build", "manifest.json");
    const data = fs.readFileSync(manifest, { encoding: "utf8", flag: "r" });

    fs.writeFileSync(manifest, data.replace(/\\\\/g, "/"));
} catch (e) {
    console.log(e);
}
