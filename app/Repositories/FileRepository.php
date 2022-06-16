<?php

namespace App\Repositories;

use App\Exceptions\NotFoundException;
use App\Interfaces\FileRepositoryInterface;
use App\Models\File;
use App\Models\Rom;
use Illuminate\Http\UploadedFile;
use JetBrains\PhpStorm\ArrayShape;
use Modules\FileDownloader;
use Modules\FileHandler;

class FileRepository implements FileRepositoryInterface
{


    /**
     * @throws NotFoundException
     */
    public function showAssociatedRom($file): Rom
    {
        $associatedRom = $file->rom()->first();
        return $associatedRom ?? throw new NotFoundException('no rom is associated with this file');
    }
}
