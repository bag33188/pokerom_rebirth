/**
 * {@link /scripts/helpers/aggregations.js}
 */
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

db.createCollection("rom_files_data");

db.rom_files_data.insertMany([
    {
        filename: "00040000001B5100_v00.3ds",
        length: 4294967295,

        md5: "d9e4a3be78d9c96f4a0720137e562c6a",
    },
    {
        filename: "0100000011D90000.xci",
        length: 4997734912,

        md5: "f67caf72e3c9003442b5fa2f37e4655d",
    },
    {
        filename: "POKEMON_SAPPAXPE01.gba",
        length: 16777216,

        md5: "3a32fd98b065283d09eeba1ce0542888",
    },
    {
        filename: "POKEMON_PL_CPUE01.nds",
        length: 134217728,

        md5: "f8905424f7d8aea299c51ec7580b33d8",
    },
    {
        filename: "0100ABF008968000.xci",
        length: 15971909632,

        md5: "cc435fd0a6f0d3998c68a4fa788ded83",
    },
    {
        filename: "01008DB008C2C000.xci",
        length: 15971909632,

        md5: "0349941d294e3981e982b8c4945e16a9",
    },
    {
        filename: "00040000001B5000_v00.3ds",
        length: 4294967295,

        md5: "4cddff7ff0c10ce6a988373f1698d548",
    },
    {
        filename: "0100187003A36000.xci",
        length: 4468491264,

        md5: "f7f1d1953595b13ef74e43057427d1b4",
    },
    {
        filename: "POKEMON_RUBYAXVE01.gba",
        length: 16777216,

        md5: "e0503182a2e699678bcf25a6897a24d6",
    },
    {
        filename: "POKEMON_YELLOW01.gb",
        length: 1048576,

        md5: "d9290db87b1f0a23b89f99ee4469e34b",
    },
    {
        filename: "POKEMON_P_APAE.nds",
        length: 67108864,

        md5: "e5da92c8cfabedd0d037ff33a2f2b6ba",
    },
    {
        filename: "POKEMON_EMERBPEE01.gba",
        length: 16777216,

        md5: "605b89b67018abcea91e693a4dd25be3",
    },
    {
        filename: "000400000011C500_v00.3ds",
        length: 2147483648,

        md5: "18a93bea3dda74d7f5337d336d2491dd",
    },
    {
        filename: "000400000011C400_v00.3ds",
        length: 2147483648,

        md5: "3de786d75125137669c6e59d16b065d8",
    },
    {
        filename: "010018E011D92000.xci",
        length: 7985954816,

        md5: "413a114c1198dd3f85eace41dbdb4523",
    },
    {
        filename: "0004000000175E00_v00.3ds",
        length: 4294967295,

        md5: "a91327128187650d415313aa80b5236e",
    },
    {
        filename: "0004000000164800_v00.3ds",
        length: 4294967295,

        md5: "5b5132f209942e696d5c07f58cdcd8d3",
    },
    {
        filename: "0004000000055E00_v00.3ds",
        length: 2147483648,

        md5: "af10001ee09ef09d9ae29de056276196",
    },
    {
        filename: "0004000000055D00_v00.3ds",
        length: 2147483648,

        md5: "3935b44824d2b2e679ec4020d2241ade",
    },
    {
        filename: "010003F003A34000.xci",
        length: 4851431936,

        md5: "1081a3174abc14e16f1bc7669194ed51",
    },
    {
        filename: "POKEMON_W2_IRDO01.nds",
        length: 536870912,

        md5: "fa7f9772c2d51866185b3fc3fce3acdc",
    },
    {
        filename: "POKEMON_B2_IREO01.nds",
        length: 536870912,

        md5: "603583dc6e1b86f786dfe971c5641e85",
    },
    {
        filename: "POKEMON_SS_IPGE01.nds",
        length: 134217728,

        md5: "545aa550bafeebdd71ee0256d4c122a0",
    },
    {
        filename: "POKEMON_HG_IPKE01.nds",
        length: 134217728,

        md5: "ae2a483d0a5e8130d39f44f41a86df57",
    },
    {
        filename: "POKEMON_D_ADAE01.nds",
        length: 67108864,

        md5: "e53d7a96aa6f3a57b2967d79cc4343c6",
    },
    {
        filename: "POKEMON_BLUE01.gb",
        length: 1048576,

        md5: "50927e843568814f7ed45ec4f944bd8b",
    },
    {
        filename: "POKEMON_GREEN01.gb",
        length: 1048576,

        md5: "5114bfa60b50a37ed530e607ee7ea74b",
    },
    {
        filename: "POKEMON_RED01.gb",
        length: 1048576,

        md5: "3d45c1ee9abd5738df46d2bdda8b57dc",
    },
    {
        filename: "POKEMON_W_IRAO01.nds",
        length: 268435456,

        md5: "da6b09652cced64d9df877a8741db33e",
    },
    {
        filename: "RenegadePlatinum.nds",
        length: 104923028,

        md5: "4cbf654b4735760f8efd64a8a41415ca",
    },
    {
        filename: "POKEMON_B_IRBO01.nds",
        length: 268435456,

        md5: "f45fd94bb761721e30bd3a0a4fde124a",
    },
    {
        filename: "Pokemon_Ash_Gray_4-5-3.gba",
        length: 16777216,

        md5: "92262059190c05a5615be6b98612fb14",
    },
    {
        filename: "POKEMON_GLDAAUE01.gbc",
        length: 2097152,

        md5: "a6924ce1f9ad2228e1c6580779b23878",
    },
    {
        filename: "PM_CRYSTAL_BYTE01.gbc",
        length: 2097152,

        md5: "301899b8087289a6436b0a241fbbb474",
    },
    {
        filename: "POKEMON_FIREBPRE01.gba",
        length: 16777216,

        md5: "51901a6e40661b3914aa333c802e24e8",
    },
    {
        filename: "POKEMON_LEAFBPGE01.gba",
        length: 16777216,

        md5: "9d33a02159e018d09073e700e1fd10fd",
    },
    {
        filename: "pokeprism.gbc",
        length: 2097152,

        md5: "3cd828587eb8d3fe818d57f99b3a3c95",
    },
    {
        filename: "genesis-final-2019-08-23.gba",
        length: 16777216,

        md5: "cb0d9b6407cde2bc5043d2f7cfc2216c",
    },
    {
        filename: "POKEMON_SLVAAXE01.gbc",
        length: 2097152,

        md5: "2ac166169354e84d0e2d7cf4cb40b312",
    },
    {
        filename: "pokemon_brown_2014-red_hack.gb",
        length: 2097152,

        md5: "854390c4a18d0a1744fb437037b4a531",
    },
]);
