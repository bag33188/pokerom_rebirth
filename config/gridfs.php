<?php

return [
    'driver' => 'mongodb',
    'connection' => [
        'host' => env('DB_HOST_SECOND', 'localhost'),
        'port' => env('DB_PORT_SECOND', 27017),
        'database' => env('DB_DATABASE_SECOND'),
        'username' => env('DB_USERNAME_SECOND', 'brock'),
        'password' => env('DB_PASSWORD_SECOND', 'secret'),
        'auth' => [
            'source' => env('DB_AUTHENTICATION_DATABASE'),
            'mechanism' => env('DB_AUTHENTICATION_MECHANISM')
        ]
    ],
    'bucketName' => env('DB_GFS_BUCKET_NAME'),
    'chunkSize' => intval(env('DB_GFS_CHUNK_SIZE'), 16),
];
