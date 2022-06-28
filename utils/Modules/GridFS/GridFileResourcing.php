<?php

namespace Utils\Modules\GridFS;

use Jenssegers\Mongodb\Eloquent\Model;

interface GridFileResourcing
{
    /**
     * Get filename string
     *
     * @return string
     */
    public function getFilename(): string;

    /**
     * Get extension of file name
     *
     * @return string
     */
    public function getFileExt(): string;

    /**
     * Get file resource model (non-gfs)
     *
     * @return Model
     */
    public function getFileDocument(): Model;
}
