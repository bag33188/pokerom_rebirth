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
                        "filename can only have 1 period, and no spaces. only hyphens and underscores allowed...along with numbers and letters",
                },
                uploadDate: {
                    bsonType: "date",
                },
                chunkSize: {
                    bsonType: "int",
                    minimum: 261120,
                },
                length: {
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

/*! AGGREGATIONS */
let aggregations = {
    "Proper Files Sort": [
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
    "Find 3DS ROMs": [
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
    "Calc Total File Size Bytes": [
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
                    $concat: ["$total_size", "\u0020", "Bytes"],
                },
            },
        },
        {
            $limit: 1,
        },
    ],
    "Show Rom Sizes (KB)": [
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
                        "\u0020",
                        "KB",
                    ],
                },
            },
        },
    ],
};

const pipeline = [
    aggregations["Proper Files Sort"],
    aggregations["Show Rom Sizes (KB)"],
    aggregations["Calc Total File Size Bytes"],
    aggregations["Find 3DS ROMs"],
];

db.roms.files.aggregate([...pipeline[0], ...pipeline[1]]);
