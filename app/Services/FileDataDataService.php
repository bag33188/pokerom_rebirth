<?php

namespace App\Services;

use App\Enums\FileTypesEnum as FileTypes;
use App\Events\FileDeleted;
use App\Events\FileUploaded;
use App\Interfaces\FileDataServiceInterface;
use App\Models\File;
use Utils\Classes\JsonDataResponse;
use Illuminate\Http\UploadedFile;
use RomFile;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileDataDataService implements FileDataServiceInterface
{
    public function downloadFile(File $file): StreamedResponse
    {
        return new StreamedResponse(function () use ($file) {
            RomFile::download($file->getKey());
        }, ResponseAlias::HTTP_ACCEPTED, array(
            'Content-Type' => FileTypes::OCTET_STREAM->value,
            'Content-Transfer-Encoding' => 'chunked',
            'Content-Disposition' => "attachment; filename=\"$file->filename\""));
    }

    public function uploadFile(UploadedFile $file): JsonDataResponse
    {
        RomFile::upload($file);
        event(new FileUploaded(RomFile::getFileDocument()));
        return new JsonDataResponse(['message' => "file '" . RomFile::getFilename() . "' created!"], ResponseAlias::HTTP_CREATED, ['X-Content-Transfer-Type', FileTypes::X_BINARY->value]);
    }

    public function deleteFile(File $file): JsonDataResponse
    {
        event(new FileDeleted($file));
        RomFile::destroy($file->getKey());
        return new JsonDataResponse(['message' => "$file->filename deleted!"], ResponseAlias::HTTP_OK);
    }
}
