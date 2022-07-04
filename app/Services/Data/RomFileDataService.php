<?php

namespace App\Services\Data;

use App\Enums\FileTypesEnum as FileTypes;
use App\Events\FileDeleted;
use App\Events\FileUploaded;
use App\Interfaces\Service\RomFileDataServiceInterface;
use App\Jobs\ProcessRomFileDeletion;
use App\Jobs\ProcessRomFileDownload;
use App\Jobs\ProcessRomFileUpload;
use App\Models\RomFile;
use RomFileRepo;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Utils\Modules\JsonDataResponse;

class RomFileDataService implements RomFileDataServiceInterface
{
    public function downloadRomFile(RomFile $romFile): StreamedResponse
    {
        return new StreamedResponse(function () use ($romFile) {
            ProcessRomFileDownload::dispatch($romFile->getObjectId());
        }, ResponseAlias::HTTP_ACCEPTED, array(
            'Content-Type' => FileTypes::OCTET_STREAM->value,
            'Content-Transfer-Encoding' => 'chunked',
            'Content-Disposition' => "attachment; filename=\"$romFile->filename\""));
    }

    public function uploadRomFile(string $filename): JsonDataResponse
    {
        ProcessRomFileUpload::dispatch($filename);
        $fileDoc = RomFileRepo::getFileByFilename($filename);
        FileUploaded::dispatch($fileDoc);
        return new JsonDataResponse(['message' => "file '" . $fileDoc->filename . "' created!"], ResponseAlias::HTTP_CREATED, ['X-Content-Transfer-Type', FileTypes::X_BINARY->value]);
    }

    public function deleteRomFile(RomFile $romFile): JsonDataResponse
    {
        FileDeleted::dispatch($romFile);
        ProcessRomFileDeletion::dispatch($romFile->getObjectId());
        return new JsonDataResponse(['message' => "$romFile->filename deleted!"], ResponseAlias::HTTP_OK);
    }
}
