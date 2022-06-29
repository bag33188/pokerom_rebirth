/** {@link /scripts/helpers/aggregations.js} */
conn = new Mongo("localhost:27017");

db = conn.getDB("admin");
db.createUser({
    user: "brock",
    pwd: "3931Sunflower!", // passwordPrompt()
    roles: [{ role: "dbAdmin", db: "pokerom_files" }],
});

db = db.getSiblingDb("pokerom_files");

db.createCollection("roms.files", {
    validator: {
        $jsonSchema: {
            bsonType: "object",
            required: ["filename", "length", "chunkSize", "uploadDate", "md5"],
            properties: {
                _id: {
                    bsonType: "objectId",
                    minLength: 24,
                    maxLength: 24,
                },
                filename: {
                    bsonType: "string",
                    pattern:
                        "^([\\w\\d\\-_]{3,32})(?:\\.)(3ds|xci|nds|gbc|gb|gba)$",
                    minLength: 3,
                    maxLength: 32,
                    description:
                        "Filename must be: between 3 and 32 characters and only contain letters, numbers, hyphens and/or underscores. File extension must be one of: .gb, .gbc, .gba, .nds, .3ds, .xci.",
                },
                uploadDate: {
                    bsonType: "date",
                },
                chunkSize: {
                    bsonType: "int",
                    minimum: 261120,
                },
                filesize: {
                    bsonType: ["int", "long"],
                    minimum: 1044480, // 1020 KiB
                    maximum: 18253611008, // 17 GiB
                },
                md5: {
                    bsonType: "string",
                    minLength: 32,
                    maxLength: 32,
                },
            },
        },
    },
    validationLevel: "strict",
    validationAction: "error",
});
db.roms.files.createIndex({ filename: 1, uploadDate: 1 });
db.roms.files.createIndex(
    { filename: 1 },
    { unique: true, partialFilterExpression: { filename: { $exists: true } } }
);

db.createCollection("roms.chunks", {
    validator: {
        $jsonSchema: {
            bsonType: "object",
            /* required: ["files_id", "n", "data"], */
            properties: {
                _id: {
                    bsonType: "objectId",
                },
                files_id: {
                    bsonType: "objectId",
                },
                data: {
                    bsonType: "binData",
                },
                n: {
                    bsonType: "int",
                },
            },
        },
    },
    validationLevel: "off",
    validationAction: "warn",
});
db.roms.chunks.createIndex({ files_id: 1, n: 1 }, { unique: true });

db.createCollection("rom_files_data", {
    validator: {
        $jsonSchema: {
            bsonType: "object",
            properties: {
                filesize: {
                    bsonType: "long",
                },
                filename: {
                    bsonType: "string",
                },
            },
        },
    },
    validationLevel: "strict",
    validationAction: "moderate",
});
db.rom_files_data.createIndex({ filename: -1 });

db.rom_files_data.insertMany([
    {
        filename: "00040000001B5100_v00.3ds",
        filesize: NumberLong("4294967295"),
    },
    {
        filename: "0100000011D90000.xci",
        filesize: NumberLong("4997734912"),
    },
    {
        filename: "POKEMON_SAPPAXPE01.gba",
        filesize: NumberLong("16777216"),
    },
    {
        filename: "POKEMON_PL_CPUE01.nds",
        filesize: NumberLong("134217728"),
    },
    {
        filename: "0100ABF008968000.xci",
        filesize: NumberLong("15971909632"),
    },
    {
        filename: "01008DB008C2C000.xci",
        filesize: NumberLong("15971909632"),
    },
    {
        filename: "00040000001B5000_v00.3ds",
        filesize: NumberLong("4294967295"),
    },
    {
        filename: "0100187003A36000.xci",
        filesize: NumberLong("4468491264"),
    },
    {
        filename: "POKEMON_RUBYAXVE01.gba",
        filesize: NumberLong("16777216"),
    },
    {
        filename: "POKEMON_YELLOW01.gb",
        filesize: NumberLong("1048576"),
    },
    {
        filename: "POKEMON_P_APAE.nds",
        filesize: NumberLong("67108864"),
    },
    {
        filename: "POKEMON_EMERBPEE01.gba",
        filesize: NumberLong("16777216"),
    },
    {
        filename: "000400000011C500_v00.3ds",
        filesize: NumberLong("2147483648"),
    },
    {
        filename: "000400000011C400_v00.3ds",
        filesize: NumberLong("2147483648"),
    },
    {
        filename: "010018E011D92000.xci",
        filesize: NumberLong("7985954816"),
    },
    {
        filename: "0004000000175E00_v00.3ds",
        filesize: NumberLong("4294967295"),
    },
    {
        filename: "0004000000164800_v00.3ds",
        filesize: NumberLong("4294967295"),
    },
    {
        filename: "0004000000055E00_v00.3ds",
        filesize: NumberLong("2147483648"),
    },
    {
        filename: "0004000000055D00_v00.3ds",
        filesize: NumberLong("2147483648"),
    },
    {
        filename: "010003F003A34000.xci",
        filesize: NumberLong("4851431936"),
    },
    {
        filename: "POKEMON_W2_IRDO01.nds",
        filesize: NumberLong("536870912"),
    },
    {
        filename: "POKEMON_B2_IREO01.nds",
        filesize: NumberLong("536870912"),
    },
    {
        filename: "POKEMON_SS_IPGE01.nds",
        filesize: NumberLong("134217728"),
    },
    {
        filename: "POKEMON_HG_IPKE01.nds",
        filesize: NumberLong("134217728"),
    },
    {
        filename: "POKEMON_D_ADAE01.nds",
        filesize: NumberLong("67108864"),
    },
    {
        filename: "POKEMON_BLUE01.gb",
        filesize: NumberLong("1048576"),
    },
    {
        filename: "POKEMON_GREEN01.gb",
        filesize: NumberLong("1048576"),
    },
    {
        filename: "POKEMON_RED01.gb",
        filesize: NumberLong("1048576"),
    },
    {
        filename: "POKEMON_W_IRAO01.nds",
        filesize: NumberLong("268435456"),
    },
    {
        filename: "RenegadePlatinum.nds",
        filesize: NumberLong("104923028"),
    },
    {
        filename: "POKEMON_B_IRBO01.nds",
        filesize: NumberLong("268435456"),
    },
    {
        filename: "Pokemon_Ash_Gray_4-5-3.gba",
        filesize: NumberLong("16777216"),
    },
    {
        filename: "POKEMON_GLDAAUE01.gbc",
        filesize: NumberLong("2097152"),
    },
    {
        filename: "PM_CRYSTAL_BYTE01.gbc",
        filesize: NumberLong("2097152"),
    },
    {
        filename: "POKEMON_FIREBPRE01.gba",
        filesize: NumberLong("16777216"),
    },
    {
        filename: "POKEMON_LEAFBPGE01.gba",
        filesize: NumberLong("16777216"),
    },
    {
        filename: "pokeprism.gbc",
        filesize: NumberLong("2097152"),
    },
    {
        filename: "genesis-final-2019-08-23.gba",
        filesize: NumberLong("16777216"),
    },
    {
        filename: "POKEMON_SLVAAXE01.gbc",
        filesize: NumberLong("2097152"),
    },
    {
        filename: "pokemon_brown_2014-red_hack.gb",
        filesize: NumberLong("2097152"),
    },
]);
