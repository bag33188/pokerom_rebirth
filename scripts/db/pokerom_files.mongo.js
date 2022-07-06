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
                    minimum: 1044480, // 1020 Kibibytes
                    maximum: 18253611008, // 17 Gibibytes
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
                filename: {
                    bsonType: "string",
                },
                filesize: {
                    bsonType: ["int", "long"],
                    description: "Size of file measured in raw Bytes",
                },
            },
        },
    },
    validationLevel: "moderate",
    validationAction: "warn",
});
db.rom_files_data.createIndex({ filename: -1 }, { unique: true });

let aggregations = [
    {
        name: "Calc Total File Size Bytes",
        pipeline: [
            {
                $group: {
                    _id: null,
                    total_length: {
                        $sum: "$length",
                    },
                },
            },
            {
                $addFields: {
                    total_size: {
                        $toString: {
                            $toLong: "$total_length",
                        },
                    },
                },
            },
            {
                $project: {
                    _id: 0,
                    total_length: 1,
                    total_size: {
                        $concat: ["$total_size", " ", "Bytes"],
                    },
                },
            },
            {
                $limit: 1,
            },
        ],
    },
    {
        name: "Calc Total File Size Gibibytes",
        pipeline: [
            {
                $group: {
                    _id: null,
                    total_length: {
                        $sum: "$length",
                    },
                },
            },
            {
                $addFields: {
                    total_size: {
                        $toString: {
                            $round: [
                                {
                                    $toDouble: {
                                        $divide: [
                                            "$total_length",
                                            {
                                                $pow: [1024, 3],
                                            },
                                        ],
                                    },
                                },
                                2,
                            ],
                        },
                    },
                },
            },
            {
                $project: {
                    _id: 0,
                    total_length: {
                        $toDecimal: {
                            $divide: [
                                "$total_length",
                                {
                                    $pow: [1024, 3],
                                },
                            ],
                        },
                    },
                    total_size: {
                        $concat: ["$total_size", " ", "Gibibytes"],
                    },
                },
            },
            {
                $limit: 1,
            },
        ],
    },
    {
        name: "Find 3DS ROMs",
        pipeline: [
            {
                $sort: {
                    length: -1,
                    filename: 1,
                    uploadDate: 1,
                },
            },
            {
                $match: {
                    filename: {
                        $regex: "^[\\w\\d\\-_]+\\.3ds$",
                        $options: "i",
                    },
                },
            },
        ],
    },
    {
        name: "Find GB ROMs",
        pipeline: [
            {
                $sort: {
                    length: -1,
                    filename: 1,
                    uploadDate: 1,
                },
            },
            {
                $match: {
                    filename: {
                        $regex: "^[\\w\\d\\-_]+\\.gb$",
                        $options: "i",
                    },
                },
            },
        ],
    },
    {
        name: "Find GBA ROMs",
        pipeline: [
            {
                $sort: {
                    length: -1,
                    filename: 1,
                    uploadDate: 1,
                },
            },
            {
                $match: {
                    filename: {
                        $regex: "^[\\w\\d\\-_]+\\.gba$",
                        $options: "i",
                    },
                },
            },
        ],
    },
    {
        name: "Find GBC ROMs",
        pipeline: [
            {
                $sort: {
                    length: -1,
                    filename: 1,
                    uploadDate: 1,
                },
            },
            {
                $match: {
                    filename: {
                        $regex: "^[\\w\\d\\-_]+\\.gbc$",
                        $options: "i",
                    },
                },
            },
        ],
    },
    {
        name: "Find NDS ROMs",
        pipeline: [
            {
                $sort: {
                    length: -1,
                    filename: 1,
                    uploadDate: 1,
                },
            },
            {
                $match: {
                    filename: {
                        $regex: "^[\\w\\d\\-_]+\\.nds$",
                        $options: "i",
                    },
                },
            },
        ],
    },
    {
        name: "Find XCI ROMs",
        pipeline: [
            {
                $sort: {
                    length: -1,
                    filename: 1,
                    uploadDate: 1,
                },
            },
            {
                $match: {
                    filename: {
                        $regex: "^[\\w\\d\\-_]+\\.xci$",
                        $options: "i",
                    },
                },
            },
        ],
    },
    {
        name: "Proper Rom Files Sort",
        pipeline: [
            {
                $addFields: {
                    field_length: {
                        $strLenCP: "$filename",
                    },
                },
            },
            {
                $sort: {
                    length: 1,
                    field_length: 1,
                },
            },
            {
                $unset: "field_length",
            },
        ],
    },
    {
        name: "Show Rom Sizes (KB)",
        pipeline: [
            {
                $addFields: {
                    rom_size: {
                        $ceil: {
                            $divide: ["$length", 1024],
                        },
                    },
                },
            },
            {
                $project: {
                    filename: 1,
                    length: 1,
                    chunkSize: 1,
                    uploadDate: 1,
                    md5: 1,
                    rom_size: {
                        $concat: [
                            {
                                $toString: {
                                    $toLong: "$rom_size",
                                },
                            },
                            " ",
                            "KB",
                        ],
                    },
                },
            },
        ],
    },
];

let seeds = [
    {
        filename: "0100ABF008968000.xci",
        filesize: 15971909632,
    },
    {
        filename: "01008DB008C2C000.xci",
        filesize: 15971909632,
    },
    {
        filename: "010018E011D92000.xci",
        filesize: 7985954816,
    },
    {
        filename: "0100000011D90000.xci",
        filesize: 4997734912,
    },
    {
        filename: "010003F003A34000.xci",
        filesize: 4851431936,
    },
    {
        filename: "0100187003A36000.xci",
        filesize: 4468491264,
    },
    {
        filename: "00040000001B5000_v00.3ds",
        filesize: 4294967295,
    },
    {
        filename: "00040000001B5100_v00.3ds",
        filesize: 4294967295,
    },
    {
        filename: "0004000000175E00_v00.3ds",
        filesize: 4294967295,
    },
    {
        filename: "0004000000164800_v00.3ds",
        filesize: 4294967295,
    },
    {
        filename: "000400000011C400_v00.3ds",
        filesize: 2147483648,
    },
    {
        filename: "000400000011C500_v00.3ds",
        filesize: 2147483648,
    },
    {
        filename: "0004000000055D00_v00.3ds",
        filesize: 2147483648,
    },
    {
        filename: "0004000000055E00_v00.3ds",
        filesize: 2147483648,
    },
    {
        filename: "POKEMON_B2_IREO01.nds",
        filesize: 536870912,
    },
    {
        filename: "POKEMON_W2_IRDO01.nds",
        filesize: 536870912,
    },
    {
        filename: "POKEMON_B_IRBO01.nds",
        filesize: 268435456,
    },
    {
        filename: "POKEMON_W_IRAO01.nds",
        filesize: 268435456,
    },
    {
        filename: "POKEMON_HG_IPKE01.nds",
        filesize: 134217728,
    },
    {
        filename: "POKEMON_SS_IPGE01.nds",
        filesize: 134217728,
    },
    {
        filename: "POKEMON_PL_CPUE01.nds",
        filesize: 134217728,
    },
    {
        filename: "POKEMON_D_ADAE01.nds",
        filesize: 67108864,
    },
    {
        filename: "POKEMON_P_APAE.nds",
        filesize: 67108864,
    },
    {
        filename: "POKEMON_EMERBPEE01.gba",
        filesize: 16777216,
    },
    {
        filename: "POKEMON_FIREBPRE01.gba",
        filesize: 16777216,
    },
    {
        filename: "POKEMON_LEAFBPGE01.gba",
        filesize: 16777216,
    },
    {
        filename: "POKEMON_RUBYAXVE01.gba",
        filesize: 16777216,
    },
    {
        filename: "POKEMON_SAPPAXPE01.gba",
        filesize: 16777216,
    },
    {
        filename: "PM_CRYSTAL_BYTE01.gbc",
        filesize: 2097152,
    },
    {
        filename: "POKEMON_GLDAAUE01.gbc",
        filesize: 2097152,
    },
    {
        filename: "POKEMON_SLVAAXE01.gbc",
        filesize: 2097152,
    },
    {
        filename: "POKEMON_YELLOW01.gb",
        filesize: 1048576,
    },
    {
        filename: "POKEMON_GREEN01.gb",
        filesize: 1048576,
    },
    {
        filename: "POKEMON_BLUE01.gb",
        filesize: 1048576,
    },
    {
        filename: "POKEMON_RED01.gb",
        filesize: 1048576,
    },
    {
        filename: "pokeprism.gbc",
        filesize: 2097152,
    },
    {
        filename: "pokemon_brown_2014-red_hack.gb",
        filesize: 2097152,
    },
    {
        filename: "genesis-final-2019-08-23.gba",
        filesize: 16777216,
    },
    {
        filename: "Pokemon_Ash_Gray_4-5-3.gba",
        filesize: 16777216,
    },
    {
        filename: "RenegadePlatinum.nds",
        filesize: 104923028,
    },
];

db.rom_files_data.insertMany(seeds);

db.roms.files.aggregate([...aggregations[0].pipeline]);
