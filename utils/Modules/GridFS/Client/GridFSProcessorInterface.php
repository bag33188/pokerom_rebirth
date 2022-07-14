<?php

namespace GridFS\Client;

use MongoDB\BSON\ObjectId;

interface GridFSProcessorInterface
{
    public function upload(string $filename): void;

    public function download(ObjectId $fileId): void;

    public function delete(ObjectId $fileId): void;
}
