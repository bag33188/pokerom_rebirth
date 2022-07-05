<?php

namespace Utils\Modules\GridFS;

use MongoDB\BSON\ObjectId;

interface GridFSBucketMethodsInterface
{
    public function upload(string $filename): void;

    public function download(ObjectId $fileId, int $downloadTransferSize): void;

    public function delete(ObjectId $fileId): void;
}
