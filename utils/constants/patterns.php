<?php

/** file name regular expression */
const FILENAME_PATTERN = /** @lang RegExp */
"/^([\w\d\-_]{3,32})\.(3ds|xci|nds|gbc|gb|gba)$/i";
/** game name regular expression */
const GAME_NAME_PATTERN = "/^Pokemon\s.+$/";
/** rom name regular expression */
const ROM_NAME_PATTERN = "/^[\w_-]+$/i";
