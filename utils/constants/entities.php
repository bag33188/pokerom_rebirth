<?php

// required as a dependency for these definitions
include_once "chars.php";

/** directory that contains all bin rom files */
const ROM_FILES_DIRNAME = 'rom_files';
/** the key name for sanctum personal access token */
const API_TOKEN_KEY = 'auth_token';
/** size of chunks for streaming downloads */
const CONTENT_TRANSFER_SIZE = 0xFF000;
/** concat: Pok, &eacute; ... output: Pok&eacute; */
const POKE_EACUTE = "Pok" . _EACUTE;

// Date Formatting entities

/** ex. _Monday, September 28th, 1998_ */
const WITH_DAY_NAME = 'l, F jS, Y';
/** ex. _September 28th, 1998_ */
const WITHOUT_DAY_NAME = 'F jS, Y';

