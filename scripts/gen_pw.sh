#!/usr/bin/env bash

# ========================
# Generate Password Script
# ========================

:<< --MULTILINE-COMMENT--
Permissions (Unix)
------------------

add to current permissions
$ cd scripts
$ chmod +x ./gen_pw.sh

set current permissions
$ cd scripts
$ chmod 755 ./gen_pw.sh
--MULTILINE-COMMENT--

gen_pw() {
  export NODE_ENV=development
  target_PWD=$(readlink -f .)
  current_folder="${target_PWD##*/}"
  if [[ "$current_folder" = "scripts" ]]; then
    cd ..
  fi
  pw_gen_script_location="./utils/password-generator.js"
  salt_val=$1
  node $pw_gen_script_location --salt="$salt_val"
  exit 0
}

gen_pw "$@"
