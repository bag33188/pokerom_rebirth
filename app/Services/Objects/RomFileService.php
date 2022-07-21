<?php

namespace App\Services\Objects;

use App\Actions\RomFile\NormalizeFilenameTrait as NormalizeFilenameAction;
use App\Events\RomFileCreated;
use App\Events\RomFileDeleting;
use App\Interfaces\Service\RomFileServiceInterface;
use App\Jobs\ProcessRomFileDeletion;
use App\Jobs\ProcessRomFileDownload;
use App\Jobs\ProcessRomFileUpload;
use App\Models\RomFile;
use RomFileRepo;

class RomFileService implements RomFileServiceInterface
{
    use NormalizeFilenameAction {
        normalize as protected normalizeRomFilename;
    }

    public function downloadRomFile(RomFile $romFile): RomFile
    {
        $romFileId = $romFile->getObjectId();
        ProcessRomFileDownload::dispatchSync($romFileId);
        return $romFile;
    }

    /**
     * Only pass in the filename as rom files are already need to be stored on the system.
     *
     * _Cannot use {@see \Illuminate\Http\UploadedFile `UploadedFile`} object_
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
        $romFileClone = $romFile->replicateQuietly(); // mute extraneous events when cloning
        RomFileDeleting::dispatch($romFile);
        ProcessRomFileDeletion::dispatchSync($romFile->getObjectId());
        return $romFileClone;
    }
}
