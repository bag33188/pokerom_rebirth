<?php

namespace App\Services\Data;

use App\Enums\FileTypesEnum as FileTypes;
use App\Events\FileDeleted;
use App\Interfaces\FileDataServiceInterface;
use App\Models\File;
use Illuminate\Http\UploadedFile;
use RomFile;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Utils\Modules\JsonDataResponse;

class FileDataService implements FileDataServiceInterface
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
        FileDeleted::dispatch(RomFile::getFileDocument());
        return new JsonDataResponse(['message' => "file '" . RomFile::getFilename() . "' created!"], ResponseAlias::HTTP_CREATED, ['X-Content-Transfer-Type', FileTypes::X_BINARY->value]);
    }

    public function deleteFile(File $file): JsonDataResponse
    {
        FileDeleted::dispatch($file);
        RomFile::destroy($file);
        return new JsonDataResponse(['message' => "$file->filename deleted!"], ResponseAlias::HTTP_OK);
    }
}