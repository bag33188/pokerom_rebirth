<?php

namespace App\Services;

use App\Enums\FileTypesEnum as FileTypes;
use App\Events\FileDeleted;
use App\Events\FileUploaded;
use App\Interfaces\FileServiceInterface;
use App\Models\File;
use RomFile;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileService implements FileServiceInterface
{
    public function downloadFile(string $fileId, string $filename): StreamedResponse
    {
        return new StreamedResponse(function () use ($fileId, $filename) {
            RomFile::download($fileId);
        }, $filename, array(
            'Content-Type' => FileTypes::OCTET_STREAM->value,
            'Content-Transfer-Encoding' => 'chunked',
            'Content-Disposition' => "attachment; filename=\"$filename\""));
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
