<?php

namespace Utils\Modules\GridFS;

use Illuminate\Http\UploadedFile;
use Jenssegers\Mongodb\Eloquent\Model;

abstract class AbstractGridFsBucket extends FileBucket implements GridFileResourcing
{
    /** @var int Size of chunks interval(s) to download */
    protected const DOWNLOAD_CHUNK_SIZE = 0x3FC00;


    abstract public function upload(string $filename): void;

    /**
     * Download File from GridFS
     *
     * @param string $fileId
     * @return void
     */
    abstract public function download(string $fileId): void;

    /**
     * Delete GridFS File Data
     *
     * @param Model $file
     * @return void
     */
    abstract public function delete(Model $file): void;
}
