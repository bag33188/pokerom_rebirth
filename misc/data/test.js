let gamesData = require("./dump/games.json");
gamesData = gamesData.map((e) => {
    delete e["id"];
    delete e["created_at"];
    delete e["updated_at"];
    delete e["slug"];
    delete e["rom_id"];
    e["region"] = e["region"].toLowerCase();
    e["game_type"] = e["game_type"].toLowerCase();
    e["game_name"] = e["game_name"].replace("Pok\xE9mon", "Pokemon");
    e["date_released"] = e["date_released"].replace(
        /T[0-2][0-4]:[0-5]\d:[0-5]\d\.\d+Z/i,
        ""
    );
    return e;
});

let romsData = require("./dump/roms.json");
romsData = romsData.map((e) => {
    delete e["id"];
    delete e["created_at"];
    delete e["updated_at"];
    delete e["game_id"];
    delete e["file_id"];
    delete e["has_game"];
    delete e["has_file"];
    e["rom_type"] = e["rom_type"].toLowerCase();
    return e;
});

let romFilesData = require("./dump/rom_files.json");
romFilesData = romFilesData.valueOf().map((e) => {
    delete e["_id"];
    return e;
});

const fs = require("fs");
fs.writeFileSync(
    "seeds.json",
    JSON.stringify({ roms: romsData, games: gamesData, romFiles: romFilesData })
);
