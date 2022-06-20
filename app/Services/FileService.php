<?php

namespace App\Services;

use App\Events\FileDeleted;
use App\Events\FileUploaded;
use App\Interfaces\FileServiceInterface;
use App\Models\File;
use RomFile;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class FileService implements FileServiceInterface
{
    public function downloadFile(string $fileId)
    {
        RomFile::download($fileId);
    }

    public function uploadFile(UploadedFile $file): JsonServiceResponse
    {
        RomFile::upload($file);
        event(new FileUploaded(RomFile::getFileDocument()));
        return new JsonServiceResponse(['message' => "file '" . RomFile::getFilename() . "' created!"], ResponseAlias::HTTP_CREATED);
    }

    public function deleteFile(File $file): JsonServiceResponse
    {
        event(new FileDeleted($file));
        RomFile::destroy($file->getKey());
        return new JsonServiceResponse(['message' => "{$file['filename']} deleted!"], ResponseAlias::HTTP_OK);
    }
}
