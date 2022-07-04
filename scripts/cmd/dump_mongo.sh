#!/usr/bin/env bash

# =========================
# Dump MongoDB File(s) Data
# =========================

:<< --MULTILINE-COMMENT--
Permissions (Unix)
------------------

add to current permissions
$ cd scripts/cmd
$ chmod +x ./dump_mongo.sh

set current permissions
$ cd scripts/cmd
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
    output_dir="misc/data/dump/roms.files.json"

    mongoexport -d $database -c $collection --jsonArray --jsonFormat=relaxed --pretty --fields length,filename,chunkSize -o $output_dir
}

dump_mongo
# /("_id"\:)([\s\t\n\v]*)(\{[\s\t\n\v]*)(\"\$oid"\:)([\s\t\n\v]*)(\"[\w\d]+\")([\s\t\n\v]*)(\})([\s\t\n\v]*)(,?)/gim
