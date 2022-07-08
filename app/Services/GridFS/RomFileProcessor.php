<?php

namespace App\Services\GridFS;

use MongoDB\GridFS\Bucket;
use Utils\Modules\GridFS\Support\GridFSBucketMethods;

class RomFileProcessor extends GridFSBucketMethods
{
    public function __construct(Bucket $bucket)
    {
        parent::__construct($bucket);
    }
}
