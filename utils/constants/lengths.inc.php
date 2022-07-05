<?php

/*
 * Validation Length Values
 */

// Validation //

const MAX_GAME_NAME = 40;
const MIN_GAME_NAME = 7;
const MAX_GAME_TYPE = 8;
const MIN_GAME_TYPE = 4;
const MAX_GAME_REGION = 8;
const MIN_GAME_REGION = 4;


const MAX_ROM_NAME = 30;
const MIN_ROM_NAME = 3;
const MAX_ROM_TYPE = 4;
const MIN_ROM_TYPE = 2;


const MAX_USER_NAME = 45;
const MIN_USER_NAME = 1;
const MAX_USER_EMAIL = 35;
const MIN_USER_EMAIL = null;
const MAX_USER_PASSWORD = 50;
const MIN_USER_PASSWORD = 8;

// Database //

const BCRYPT_PASSWORD_LENGTH = 60;
const OBJECT_ID_LENGTH = 24;
const SESSION_ID_LENGTH = 40;
const IP_ADDRESS_LENGTH = 45;
const PERSONAL_ACCESS_TOKEN_LENGTH = 64;
const PERSONAL_ACCESS_TOKEN_NAME_LENGTH = 20;
const PROFILE_PHOTO_URI_LENGTH = 2048;
const PASSWORD_RESET_TOKEN_LENGTH = 60;
