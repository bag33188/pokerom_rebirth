<?php

/*
 * Database Enum Values
 */

/** array of valid game types */
const GAME_TYPES = array('core', 'spin-off', 'hack');
/** array of valid game regions */
const REGIONS = array(
    'kanto',
    'johto',
    'hoenn',
    'sinnoh',
    'unova',
    'kalos',
    'alola',
    'galar',
    'other'
);
/** array of valid rom types */
const ROM_TYPES = array('gb', 'gbc', 'gba', 'nds', '3ds', 'xci');
/** array of valid user roles */
const USER_ROLES = array('user', 'admin', 'guest');
/** array of valid file extensions */
const FILE_EXTENSIONS = array('.gb', '.gbc', '.gba', '.nds', '.3ds', '.xci');
/** options for cascade operations in RDBMS */
const CASCADE_OPTIONS = array(
    'NO_ACTION' => 'NO ACTION',
    'DELETE' => 'DELETE',
    'SET_NULL' => 'SET NULL',
    'RESTRICT' => 'RESTRICT'
);
