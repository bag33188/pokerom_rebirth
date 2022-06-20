<?php

namespace App\Services;

use App\Events\FileDeleted;
use App\Events\FileUploaded;
use App\Interfaces\FileServiceInterface;
use App\Models\File;
use GridFS;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class FileService implements FileServiceInterface
{
    public function downloadFile(string $fileId)
    {
        GridFS::download($fileId);
    }

    public function uploadFile(UploadedFile $file): JsonServiceResponse
    {
        GridFS::upload($file);
        $fileDoc = GridFS::getFileDocument();
        event(new FileUploaded($fileDoc));
        return new JsonServiceResponse(['message' => "file '" . $fileDoc['filename'] . "' created!"], ResponseAlias::HTTP_CREATED);
    }

    public function deleteFile(File $file): JsonServiceResponse
    {
        event(new FileDeleted($file));
        GridFS::destroy($file->getKey());
        return new JsonServiceResponse(['message' => "{$file['filename']} deleted!"], ResponseAlias::HTTP_OK);
    }
}
