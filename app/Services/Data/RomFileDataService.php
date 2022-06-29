<?php

namespace App\Services\Data;

use App\Enums\FileTypesEnum as FileTypes;
use App\Events\FileDeleted;
use App\Events\FileUploaded;
use App\Interfaces\RomFileDataServiceInterface;
use App\Jobs\ProcessRomFileDownload;
use App\Jobs\ProcessRomFileUpload;
use App\Models\RomFile;
use GfsRomFile;
use RomFileRepo;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Utils\Classes\JsonDataResponse;
use Utils\Modules\GridFsMethods;

class RomFileDataService implements RomFileDataServiceInterface
{
    public function downloadFile(RomFile $file): StreamedResponse
    {
        return new StreamedResponse(function () use ($file) {
            ProcessRomFileDownload::dispatch($file->getKey());
        }, ResponseAlias::HTTP_ACCEPTED, array(
            'Content-Type' => FileTypes::OCTET_STREAM->value,
            'Content-Transfer-Encoding' => 'chunked',
            'Content-Disposition' => "attachment; filename=\"$file->filename\""));
    }

    public function uploadFile(string $filename): JsonDataResponse
    {
        ProcessRomFileUpload::dispatch($filename);
        $fileDoc = RomFileRepo::getFileByFilename($filename);
        FileUploaded::dispatch($fileDoc);
        return new JsonDataResponse(['message' => "file '" . $fileDoc->filename . "' created!"], ResponseAlias::HTTP_CREATED, ['X-Content-Transfer-Type', FileTypes::X_BINARY->value]);
    }

    public function deleteFile(RomFile $file): JsonDataResponse
    {
        FileDeleted::dispatch($file);
        GfsRomFile::getBucket()->delete(GridFsMethods::parseObjectId($file->getKey()));
        return new JsonDataResponse(['message' => "$file->filename deleted!"], ResponseAlias::HTTP_OK);
    }
}
