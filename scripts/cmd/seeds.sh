#!/usr/bin/env bash

# =====================
# Generate Seeds Script
# =====================

:<< --MULTILINE-COMMENT--
Permissions (Unix)
------------------

add to current permissions
$ cd scripts/cmd
$ chmod +x ./seeds.sh

set current permissions
$ cd scripts/cmd
$ chmod 755 ./seeds.sh
--MULTILINE-COMMENT--

seeds() {
    target_PWD=$(readlink -f .)
    current_folder="${target_PWD##*/}"
    if [[ "$current_folder" = "scripts" ]]; then
        cd ..
    fi
    if [[ "$current_folder" = "cmd" ]]; then
        cd ../..
    fi

    script_path="./scripts/helpers"

    node $script_path/seeds.test.js
}

seeds

exit 0;
