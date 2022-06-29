<?php

namespace App\Jobs;

use GfsRomFile;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use MongoDB\BSON\ObjectId;
use Utils\Modules\FileDownloader;
use Utils\Modules\GfsMethods;

class ProcessRomFileDownload implements ShouldQueue
{
    use Dispatchable;

    private string $fileId;
    protected const DOWNLOAD_CHUNK_SIZE = 0xFF000;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $fileId)
    {
        $this->fileId = $fileId;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $stream = GfsRomFile::gfsBucket()->openDownloadStream(GfsMethods::parseObjectId($this->fileId));
        $fileDownloader = new FileDownloader($stream, self::DOWNLOAD_CHUNK_SIZE);
        $fileDownloader->downloadFile();
    }
}
