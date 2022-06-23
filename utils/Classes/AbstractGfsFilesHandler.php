<?php

namespace Utils\Classes;

use Illuminate\Http\UploadedFile;
use Jenssegers\Mongodb\Eloquent\Model;
use Utils\Modules\GridFS;

abstract class AbstractGfsFilesHandler extends GridFS
{
    protected UploadedFile $file;
    protected string $filename;
    protected string $filepath;
    protected static string $serverUploadFilePath;

    abstract public function getFilename(): string;

    public abstract function getFileDocument(): Model;

    public abstract function upload(UploadedFile $file): void;

    public abstract function download(string $fileId): void;

    public abstract function destroy(string $fileId): void;
}
