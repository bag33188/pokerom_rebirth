<?php

/** rom filename regular expression */
const ROM_FILE_NAME_PATTERN = /** @lang RegExp */
"/^([\w\d\-_]{3,32})\.(3ds|xci|nds|gbc|gb|gba)$/i";
/** rom file extension regular expression */
const ROM_FILE_TYPES_PATTERN = /** @lang RegExp */
"/\.(gba|gbc|gb|nds|xci|3ds)$/i";
/** game name regular expression */
const GAME_NAME_PATTERN = /** @lang RegExp */
"/^Pokemon\s.+$/";
/** rom name regular expression */
const ROM_NAME_PATTERN = /** @lang RegExp */
"/^[\w_-]+$/i";
