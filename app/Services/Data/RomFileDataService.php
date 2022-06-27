<?php

namespace App\Services\Data;

use App\Enums\FileTypesEnum as FileTypes;
use App\Events\FileDeleted;
use App\Events\FileUploaded;
use App\Interfaces\RomFileDataServiceInterface;
use App\Models\RomFile;
use Illuminate\Http\UploadedFile;
use GfsRomFile;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Utils\Classes\JsonDataResponse;

class RomFileDataService implements RomFileDataServiceInterface
{
    public function downloadFile(RomFile $file): StreamedResponse
    {
        return new StreamedResponse(function () use ($file) {
            GfsRomFile::download($file->getKey());
        }, ResponseAlias::HTTP_ACCEPTED, array(
            'Content-Type' => FileTypes::OCTET_STREAM->value,
            'Content-Transfer-Encoding' => 'chunked',
            'Content-Disposition' => "attachment; filename=\"$file->filename\""));
    }

    public function uploadFile(UploadedFile $file): JsonDataResponse
    {
        GfsRomFile::upload($file);
        FileUploaded::dispatch(GfsRomFile::getFileDocument());
        return new JsonDataResponse(['message' => "file '" . GfsRomFile::getFilename() . "' created!"], ResponseAlias::HTTP_CREATED, ['X-Content-Transfer-Type', FileTypes::X_BINARY->value]);
    }

    public function deleteFile(RomFile $file): JsonDataResponse
    {
        FileDeleted::dispatch($file);
        GfsRomFile::destroy($file);
        return new JsonDataResponse(['message' => "$file->filename deleted!"], ResponseAlias::HTTP_OK);
    }
}
