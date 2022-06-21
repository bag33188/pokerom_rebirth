/*! MongoDB Aggregations */

let aggregations = {
    "Proper Rom Files Sort": [
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
    "Find GB ROMs": [
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
    "Find GBC ROMs": [
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
    "Find GBA ROMs": [
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
    "Find NDS ROMs": [
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
    "Find XCI ROMs": [
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
    "Calc Total File Size GigaBytes": [
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
                    $concat: ["$total_size", "\u0020", "Gibibytes"],
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

let pipeline = [
    // aggregations["Proper Rom Files Sort"],
    // aggregations["Show Rom Sizes (KB)"],
    // aggregations["Calc Total File Size Bytes"],
];

Object.keys(aggregations)
    .sort((a, b) => {
        return a.length - b.length;
    })
    .forEach((aggregate) => {
        pipeline.push(aggregations[aggregate]);
    });

console.log(pipeline);

module.exports = {
    aggregations,
    pipeline,
};
