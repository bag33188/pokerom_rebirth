<?php

/*
 * GridFS Vendor Config
 */

namespace Utils\Modules\GridFS\Vendor;

$template = <<<'php'
return [
    'driver' => 'mongodb',
    'connection' => [
        'host' => env('DB_HOST_SECOND', 'localhost'),
        'port' => env('DB_PORT_SECOND', 27017),
        'database' => env('DB_DATABASE_SECOND', 'my_database'),
        'username' => env('DB_USERNAME_SECOND', 'username'),
        'password' => env('DB_PASSWORD_SECOND', 'secret'),
        'auth' => [
            'source' => env('DB_AUTHENTICATION_DATABASE', 'admin'),
            'mechanism' => env('DB_AUTHENTICATION_MECHANISM', null)
        ]
    ],
    'bucketName' => env('DB_GFS_BUCKET_NAME', 'fs'),
    'chunkSize' => intval(env('DB_GFS_CHUNK_SIZE', 0x3FC00), 16),
    'fileUploadPath' => storage_path(env('SERVER_FILES_UPLOAD_PATH', 'app/files'))
];
php;

return $template;