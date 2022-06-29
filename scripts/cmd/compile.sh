#!/usr/bin/env bash

# ==============
# Compile Script
# ==============

:<< --MULTILINE-COMMENT--
Permissions (Unix)
------------------

add to current permissions
$ cd scripts/cmd
$ chmod +x ./compile.sh

set current permissions
$ cd scripts/cmd
$ chmod 755 ./compile.sh
--MULTILINE-COMMENT--

compile() {
    target_PWD=$(readlink -f .)
    current_folder="${target_PWD##*/}"
    if [[ "$current_folder" = "scripts" ]]; then
        cd ..
    fi
    if [[ "$current_folder" = "cmd" ]]; then
        cd ../..
    fi
    composer install && composer update
    npm run development
    git status
    git add . && git commit -m "update code base" && git push

    echo finished!
}

compile
