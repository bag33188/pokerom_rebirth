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
            'source' => env('DB_AUTHENTICATION_DATABASE', 'admin'),
            'mechanism' => env('DB_AUTHENTICATION_MECHANISM')
        ]
    ],
    'bucketName' => env('DB_GFS_BUCKET_NAME', 'fs'),
    'chunkSize' => intval(env('DB_GFS_CHUNK_SIZE', 0x3FC00), 16),
    'fileUploadPath' => storage_path(env('GFS_UPLOAD_PATH', 'app/grid_files'))
];
