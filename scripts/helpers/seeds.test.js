const fs = require("fs");
const path = require("path");

console.log("Generating seeds...");

const baseDir = __dirname.replace(/([\/\\]scripts)([\/\\]helpers)/i, "");
const dumpDir = path.join(baseDir, "misc", "data", "dump");
const seedFilePath = path.resolve(
    path.join(baseDir, "misc", "data"),
    "seeds.json"
);
const seedData = {
    gamesData: require(path.resolve(dumpDir, "games.json")),
    romsData: require(path.resolve(dumpDir, "roms.json")),
    romFilesData: require(path.resolve(dumpDir, "rom_files.json")),
};

let { gamesData, romsData, romFilesData } = seedData;

gamesData = gamesData.valueOf().map((gameData) => {
    delete gameData["id"];
    delete gameData["created_at"];
    delete gameData["updated_at"];
    delete gameData["slug"];
    delete gameData["rom_id"];
    gameData["region"] = gameData["region"].toLowerCase();
    gameData["game_type"] = gameData["game_type"].toLowerCase();
    gameData["game_name"] = gameData["game_name"].replace(
        /^Pok\xE9mon/i,
        "Pokemon"
    );
    gameData["date_released"] = gameData["date_released"].replace(
        /T[0-2][0-4]:[0-5]\d:[0-5]\d\.\d{6}Z$/i,
        ""
    );
    return gameData;
});

romsData = romsData.valueOf().map((romData) => {
    delete romData["id"];
    delete romData["created_at"];
    delete romData["updated_at"];
    delete romData["game_id"];
    delete romData["file_id"];
    delete romData["has_game"];
    delete romData["has_file"];
    romData["rom_type"] = romData["rom_type"].toLowerCase();
    return romData;
});

romFilesData = romFilesData.valueOf().map((romFileData) => {
    delete romFileData["_id"];
    return romFileData;
});

fs.writeFileSync(
    seedFilePath,
    JSON.stringify({ roms: romsData, games: gamesData, romFiles: romFilesData })
);

console.log("Seeds generated!");
