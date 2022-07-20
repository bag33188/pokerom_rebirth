<?php

namespace App\Services\Object;

use App\Actions\RomFile\FilenameActionsTrait as RomFilenameActions;
use App\Enums\FileContentTypeEnum as ContentType;
use App\Events\RomFileCreated;
use App\Events\RomFileDeleted;
use App\Interfaces\Service\RomFileServiceInterface;
use App\Jobs\ProcessRomFileDeletion;
use App\Jobs\ProcessRomFileDownload;
use App\Jobs\ProcessRomFileUpload;
use App\Models\RomFile;
use RomFileRepo;
use Symfony\Component\HttpFoundation\Response as HttpStatus;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RomFileService implements RomFileServiceInterface
{
    use RomFilenameActions {
        normalize as normalizeRomFilename;
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
     * @return RomFile
     */
    public function uploadRomFile(string $romFilename): RomFile
    {
        $this->normalizeRomFilename($romFilename);
        ProcessRomFileUpload::dispatchSync($romFilename);
        $romFile = RomFileRepo::findRomFileByFilename($romFilename);
        RomFileCreated::dispatch($romFile);
        return $romFile;
    }

    public function deleteRomFile(RomFile $romFile): RomFile
    {
        $romFileClone = $romFile->replicateQuietly(); // or regular replication
        RomFileDeleted::dispatch($romFile);
        ProcessRomFileDeletion::dispatchSync($romFile->getObjectId());
        return $romFileClone;
    }
}
