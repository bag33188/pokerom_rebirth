<?php

namespace Utils\Classes;

use MongoDB\BSON\ObjectId;

interface GridFSBucketMethods
{
    public function upload(string $filename): void;

    public function download(ObjectId $fileId, int $downloadTransferSize): void;

    public function delete(ObjectId $fileId): void;
}
