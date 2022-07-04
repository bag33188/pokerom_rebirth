<?php

//--- GLOBAL CONSTANTS ---//

$constants_path = __DIR__ . "/constants";

if (!empty($constants_path)) {
    require_once $constants_path . "/entities.php"; // loads `chars.php` as a dependency
    require_once $constants_path . "/enums.php";
    require_once $constants_path . "/sizes.php";
    require_once $constants_path . "/lengths.php";
    require_once $constants_path . "/patterns.php";
}

//--- END GLOBAL CONSTANTS ---//
