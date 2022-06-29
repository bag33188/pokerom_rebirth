<?php

//--- GLOBAL HELPER FUNCTIONS ---//

$functions_path = 'functions'; // preg_replace("/\\\+/", "/", join('/', [__DIR__, 'functions']));

require_once "$functions_path/str_capitalize.php";
require_once "$functions_path/parse_date_as_readable_string.php";
require_once "$functions_path/string_to_bool.php";
require_once "$functions_path/jsondata.php";
require_once "$functions_path/number_to_roman.php";
require_once "$functions_path/unicode_poke.php";

//--- END GLOBAL HELPER FUNCTIONS ---//
