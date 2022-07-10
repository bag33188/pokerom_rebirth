<?php

//--- GLOBAL HELPER FUNCTIONS ---//

$functions_path = __DIR__ . '/functions';

if (!isDirEmpty($functions_path)) {
    require_once $functions_path . "/parse_date_as_readable_string.php";
    require_once $functions_path . "/json_data.php";
    require_once $functions_path . "/number_to_roman.php";
    require_once $functions_path . "/normalize_object_from_stdclass_or_array.php";
    require_once $functions_path . "/str_to_bool.php";
    require_once $functions_path . "/str_capitalize.php";
}

//--- END GLOBAL HELPER FUNCTIONS ---//
