<?php

namespace GridFS\Support;

use MongoDB\BSON\ObjectId;

interface GridFSProcessorInterface
{
    public function upload(string $filename): void;

    public function download(ObjectId $fileId, int $downloadTransferSize): void;

    public function delete(ObjectId $fileId): void;
}
