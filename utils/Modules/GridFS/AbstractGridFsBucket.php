<?php

namespace Utils\Modules\GridFS;

use Illuminate\Http\UploadedFile;
use Jenssegers\Mongodb\Eloquent\Model;

abstract class AbstractGridFsBucket extends FileBucket implements GridFileResourcing
{
    /**
     * Size of chunks interval(s) to download
     *
     * @var int
     */
    protected const DOWNLOAD_CHUNK_SIZE = 0x3FC00;

    /**
     * Upload file to GridFS
     *
     * @param UploadedFile $file
     * @return void
     */
    abstract public function upload(UploadedFile $file): void;

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
    abstract public function destroy(Model $file): void;
}
