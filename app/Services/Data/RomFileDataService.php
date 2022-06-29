<?php

namespace App\Services\Data;

use App\Enums\FileTypesEnum as FileTypes;
use App\Events\FileDeleted;
use App\Events\FileUploaded;
use App\Interfaces\RomFileDataServiceInterface;
use App\Jobs\DeleteRomFile;
use App\Jobs\DownloadRomFile;
use App\Jobs\UploadRomFile;
use App\Models\RomFile;
use RomFileRepo;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Utils\Classes\JsonDataResponse;

class RomFileDataService implements RomFileDataServiceInterface
{
    public function downloadFile(RomFile $file): StreamedResponse
    {
        return new StreamedResponse(function () use ($file) {
            DownloadRomFile::dispatch($file->getKey());
        }, ResponseAlias::HTTP_ACCEPTED, array(
            'Content-Type' => FileTypes::OCTET_STREAM->value,
            'Content-Transfer-Encoding' => 'chunked',
            'Content-Disposition' => "attachment; filename=\"$file->filename\""));
    }

    public function uploadFile(string $filename): JsonDataResponse
    {
        UploadRomFile::dispatch($filename);
        $fileDoc = RomFileRepo::getFileByFilename($filename);
        FileUploaded::dispatch($fileDoc);
        return new JsonDataResponse(['message' => "file '" . $fileDoc->filename . "' created!"], ResponseAlias::HTTP_CREATED, ['X-Content-Transfer-Type', FileTypes::X_BINARY->value]);
    }

    public function deleteFile(RomFile $file): JsonDataResponse
    {
        FileDeleted::dispatch($file);
        DeleteRomFile::dispatch($file->getKey());
        return new JsonDataResponse(['message' => "$file->filename deleted!"], ResponseAlias::HTTP_OK);
    }
}
