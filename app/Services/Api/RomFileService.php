<?php

namespace App\Services\Api;

use App\Enums\FileContentTypeEnum as ContentType;
use App\Events\RomFileCreated;
use App\Events\RomFileDeleted;
use App\Interfaces\Action\RomFileActionsInterface;
use App\Interfaces\Service\RomFileServiceInterface;
use App\Jobs\ProcessRomFileDeletion;
use App\Jobs\ProcessRomFileDownload;
use App\Jobs\ProcessRomFileUpload;
use App\Models\RomFile;
use RomFileRepo;
use Symfony\Component\HttpFoundation\Response as HttpStatus;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Utils\Modules\JsonDataResponse;

class RomFileService implements RomFileServiceInterface
{
    public function __construct(private readonly RomFileActionsInterface $romFileActions)
    {
    }

    public function downloadRomFile(RomFile $romFile): StreamedResponse
    {
        return new StreamedResponse(function () use ($romFile) {
            $romFileBsonId = $romFile->getObjectId();
            ProcessRomFileDownload::dispatch($romFileBsonId);
        }, HttpStatus::HTTP_ACCEPTED, array(
                'Content-Type' => ContentType::OCTET_STREAM->value,
                'Content-Transfer-Encoding' => 'chunked',
                'Content-Disposition' => 'attachment; filename="' . $romFile->filename . '"')
        );
    }

    /**
     * Only pass in the filename as rom files are already need to be stored on the system.
     *
     * @param string $romFilename
     * @return JsonDataResponse
     */
    public function uploadRomFile(string $romFilename): JsonDataResponse
    {
        $this->romFileActions->normalizeRomFilename($romFilename);
        ProcessRomFileUpload::dispatchSync($romFilename);
        $romFile = RomFileRepo::findRomFileByFilename($romFilename);
        RomFileCreated::dispatch($romFile);
        return new JsonDataResponse(
            ['message' => "file '" . $romFile->filename . "' created!"],
            HttpStatus::HTTP_CREATED,
            ['X-Content-Transfer-Type', ContentType::OCTET_STREAM->value]
        );
    }

    public function deleteRomFile(RomFile $romFile): JsonDataResponse
    {
        RomFileDeleted::dispatch($romFile);
        ProcessRomFileDeletion::dispatch($romFile->getObjectId());
        return new JsonDataResponse(
            ['message' => "file '" . $romFile->filename . "' deleted!"],
            HttpStatus::HTTP_OK
        );
    }
}
