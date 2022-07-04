const fs = require("fs");

const filePath = "../../misc/data/dump/roms.files.json";

let data;

try {
    data = fs.readFileSync(filePath);
} catch (err) {
    console.error(err);
}

const [objectIdPattern, lengthPattern, chunkSizePattern] = [
    /("_id":)([\s\t\n\v]*)(\{[\s\t\n\v]*)("\$oid":)([\s\t\n\v]*)("[\w\d]+")([\s\t\n\v]*)(})([\s\t\n\v]*)(,?)/gim,
    /("length":)([\s\t\n\v]*)/gim,
    /("chunkSize":)([\s\t\n\v]*)(\d+)(,?)/gim,
];

let newData = data
    .valueOf()
    .toString()
    .replace(objectIdPattern, "")
    .replace(lengthPattern, '"filesize": ')
    .replace(chunkSizePattern, "");

try {
    fs.writeFileSync(filePath, newData);
} catch (err) {
    console.error(err);
}
