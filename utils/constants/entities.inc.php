<?php

/*
 * Application Entity Values
 *
 * Notes:
 *  + Loads `chars.php` as a dependency
 */

// load `chars.php` constants
include_once "chars.inc.php";

// General Entities //

/** directory that contains all bin rom files */
const ROM_FILES_DIRNAME = 'rom_files';
/** the key name for sanctum personal access token */
const API_TOKEN_KEY = 'auth_token';
/** size of chunks for streaming downloads */
const CONTENT_TRANSFER_SIZE = 0xFF000;
/** concat: Pok, &eacute; ... output: Pok&eacute; */
const POKE_EACUTE = "Pok" . _EACUTE;
