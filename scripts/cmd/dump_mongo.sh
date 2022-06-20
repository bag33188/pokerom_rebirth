#!/usr/bin/env bash


# =========================
# Dump MongoDB File(s) Data
# =========================

:<< --MULTILINE-COMMENT--
Permissions (Unix)
------------------

add to current permissions
$ cd scripts
$ chmod +x ./dump_mongo.sh

set current permissions
$ cd scripts
$ chmod 755 ./dump_mongo.sh
--MULTILINE-COMMENT--

dump_mongo() {
    target_PWD=$(readlink -f .)
    current_folder="${target_PWD##*/}"
    if [[ "$current_folder" = "scripts" ]]; then
        cd ..
    fi
    if [[ "$current_folder" = "cmd" ]]; then
        cd ../..
    fi
    database="pokerom_files"
    collection="roms.files"

    mongoexport -d $database -c $collection --jsonArray --pretty -o misc/data/dump/roms.files.json
    # mongoexport --db=$database --collection=$collection --type=csv --fields=filename,length --out=data/dump/file_info.csv
}

dump_mongo
