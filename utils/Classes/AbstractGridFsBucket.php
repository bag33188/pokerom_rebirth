<?php

namespace Utils\Classes;

use Illuminate\Http\UploadedFile;
use Jenssegers\Mongodb\Eloquent\Model;
use Utils\Modules\GridFS\FileBucket;
use Utils\Modules\GridFS\FileResourcing;

abstract class AbstractGridFsBucket extends FileBucket implements FileResourcing
{
    protected const DOWNLOAD_CHUNK_SIZE = 0x3FC00;

    abstract public function getFilename(): string;

    abstract public function getFileDocument(): Model;

    abstract public function upload(UploadedFile $file): void;

    abstract public function download(string $fileId): void;

    abstract public function destroy(Model $file): void;
}
