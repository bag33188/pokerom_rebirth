<?php

/*
 * Validation Pattern Regular Expressions
 */

/** rom filename regular expression */
const ROM_FILENAME_PATTERN = /** @lang RegExp */
"/^([\w\d\-_]{3,32})\.(3ds|xci|nds|gbc|gb|gba)$/i";
/** game name regular expression */
const GAME_NAME_PATTERN = /** @lang RegExp */
"/^Pokemon\s.+$/";
/** rom name regular expression */
const ROM_NAME_PATTERN = /** @lang RegExp */
"/^[\w_-]+$/i";
/** Detects the `time` part of a DateTime string */
const TIME_STRING = /** @lang RegExp */
'/\s?[0-2][0-4]:[0-5]\d:[0-5]\d$/';