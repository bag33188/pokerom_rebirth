<?php

namespace App\Services;

use App\Enums\FileTypesEnum as FileTypes;
use App\Events\FileDeleted;
use App\Events\FileUploaded;
use App\Interfaces\FileServiceInterface;
use App\Models\File;
use Classes\JsonDataServiceResponse;
use Illuminate\Http\UploadedFile;
use RomFile;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileDataService implements FileServiceInterface
{
    public function downloadFile(File $file): StreamedResponse
    {
        return new StreamedResponse(function () use ($file) {
            RomFile::download($file->getKey());
        }, ResponseAlias::HTTP_ACCEPTED, array(
            'Content-Type' => FileTypes::OCTET_STREAM->value,
            'Content-Transfer-Encoding' => 'chunked',
            'Content-Disposition' => "attachment; filename=\"{$file->filename}\""));
    }

    public function uploadFile(UploadedFile $file): JsonDataServiceResponse
    {
        RomFile::upload($file);
        event(new FileUploaded(RomFile::getFileDocument()));
        return new JsonDataServiceResponse(['message' => "file '" . RomFile::getFilename() . "' created!"], ResponseAlias::HTTP_CREATED);
    }

    public function deleteFile(File $file): JsonDataServiceResponse
    {
        event(new FileDeleted($file));
        RomFile::destroy($file->getKey());
        return new JsonDataServiceResponse(['message' => "{$file->filename} deleted!"], ResponseAlias::HTTP_OK);
    }
}
