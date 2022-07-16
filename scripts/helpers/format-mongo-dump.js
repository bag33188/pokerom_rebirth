/**
 * @name format-mongo-dump
 * @description Format's output JSON file from dumped MongoDB `pokerom_files`.`rom.files` data
 */

const fs = require("fs");
const path = require("path");

console.log("formatting mongo dump...");

const [dirnamePattern, objectIdPattern, lengthPattern, chunkSizePattern] = [
    /([\/\\]scripts)([\/\\]helpers)/i,
    /("_id":)([\s\t\n\v]*)(\{[\s\t\n\v]*)("\$oid":)([\s\t\n\v]*)("[\da-fA-F]+")([\s\t\n\v]*)(})([\s\t\n\v]*)(,?)/gi,
    /("length":)([\s\t\n\v]*)/gi,
    /("chunkSize":)([\s\t\n\v]*)(\d+)(,?)/gi,
];

const filePath = path.join(
    __dirname.replace(dirnamePattern, ""),
    "misc",
    "data",
    "dump",
    "rom.files.json"
);

let data;

try {
    data = fs.readFileSync(filePath);
    console.log("file read successfully!");
} catch (err) {
    console.error(err);
}

let formattedData = data
    .valueOf()
    .toString()
    .replace(objectIdPattern, "")
    .replace(lengthPattern, '"filesize": ')
    .replace(chunkSizePattern, "")
    .replace(/\n\t/g, "");

try {
    fs.writeFileSync(filePath, formattedData);
    console.log("file written successfully!");
} catch (err) {
    console.error(err);
}
