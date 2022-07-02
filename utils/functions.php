<?php

//--- GLOBAL HELPER FUNCTIONS ---//

$functions_path = __DIR__ . '/functions';

if (!empty($functions_path)) {
    require_once $functions_path . "/parse_date_as_readable_string.php";
    require_once $functions_path . "/string_to_bool.php";
    require_once $functions_path . "/jsondata.php";
    require_once $functions_path . "/number_to_roman.php";
    require_once $functions_path . "/eacute_poke_conversion.php";
    require_once $functions_path . "/str_capitalize.php";
}

//--- END GLOBAL HELPER FUNCTIONS ---//
