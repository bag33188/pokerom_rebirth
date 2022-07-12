<?php

/*
 * GridFS Vendor Env
 */

namespace GridFS\Vendor;

$template = <<<'env'
DB_CONNECTION_SECOND=mongodb
DB_HOST_SECOND=127.0.0.1
DB_PORT_SECOND=27017
DB_DATABASE_SECOND=my_database_name
DB_USERNAME_SECOND=username
DB_PASSWORD_SECOND=password
DB_AUTHENTICATION_DATABASE=admin
DB_AUTHENTICATION_MECHANISM=SCRAM-SHA-256
DB_GFS_CHUNK_SIZE=0x3FC00
DB_GFS_BUCKET_NAME=fs
env;

return $template;
