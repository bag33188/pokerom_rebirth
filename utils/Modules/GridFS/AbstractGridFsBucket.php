<?php

namespace Utils\Modules\GridFS;

use Illuminate\Http\UploadedFile;
use Jenssegers\Mongodb\Eloquent\Model;

abstract class AbstractGridFsBucket extends FileBucket implements GridFileResourcing
{
    protected const DOWNLOAD_CHUNK_SIZE = 0x3FC00;

    abstract public function upload(UploadedFile $file): void;

    abstract public function download(string $fileId): void;

    abstract public function destroy(Model $file): void;
}
