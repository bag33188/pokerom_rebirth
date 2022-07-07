<?php

/*
 * MongoDB Connection Vendor Config
 */

namespace Utils\Modules\GridFS\Vendor;

$template = <<<'php'
'connections' => [
    'mongodb' => [
        'driver' => 'mongodb',
        'host' => env('DB_HOST_SECOND', 'localhost'),
        'port' => env('DB_PORT_SECOND', 27017),
        'database' => env('DB_DATABASE_SECOND'),
        'username' => env('DB_USERNAME_SECOND', 'brock'),
        'password' => env('DB_PASSWORD_SECOND', 'secret'),
        'options' => [
            'database' => env('DB_AUTHENTICATION_DATABASE', 'admin'),
            'authMechanism' => env('DB_AUTHENTICATION_MECHANISM'),
            'authSource' => env('DB_AUTHENTICATION_DATABASE'),
        ],
    ],
]
php;

return $template;
