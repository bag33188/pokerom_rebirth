<?php

/*
 * Application Entity Values
 */

/** directory that contains all bin rom files */
const ROM_FILES_DIRNAME = 'rom_files';
/** the key name for sanctum personal access token */
const API_TOKEN_KEY = 'auth_token';
/** size of chunks for streaming downloads */
const CONTENT_TRANSFER_SIZE = 0xFF000;
/** concat: Pok, &eacute; ... output: Pok&eacute; */
const POKE_EACUTE = "Pok" . _EACUTE;
/** <span style="color:yellow;">`1024`</span> @var int */
const DATA_BYTE_FACTOR = 0b010000000000; // 1024
/** pacific standard timezone (`PST, GMT-7`) */
const TIME_ZONE_PST = 'PST8PDT';
/** date format string literals */
const DATE_FORMATS = [
    'upload_date_format' => 'm-d-Y, h:i:s A (T, I)',
    'machine_dt_format' => 'Y-m-d G:i',
    'readable_date_format' => 'F jS, Y',
    'readable_date_format_with_day' => 'l, F jS, Y'
];
