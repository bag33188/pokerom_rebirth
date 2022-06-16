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

    private File $file;

    public function __construct(File $file)
    {
        $this->file = $file;
    }

    /**
     * @throws NotFoundException
     */
    public function showAssociatedRom($fileId): Rom
    {
        $associatedRom = $this->file->findOrFail($fileId)->rom()->first();
        return $associatedRom ?? throw new NotFoundException('no rom is associated with this file');
    }
}
