<?php

namespace Utils\Modules\GridFS;

use Jenssegers\Mongodb\Eloquent\Model;

interface FileResourcing
{
    public function getFilename(): string;

    public function getFileExt(): string;

    public function getFileDocument(): Model;
}
