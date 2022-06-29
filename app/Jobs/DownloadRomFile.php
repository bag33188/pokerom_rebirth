<?php

namespace App\Jobs;

use GfsRomFile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use MongoDB\BSON\ObjectId;
use Utils\Modules\FileFactory\FileDownloader;

class DownloadRomFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
    public function handle()
    {
       $stream= GfsRomFile::gfsBucket()->openDownloadStream(new ObjectId($this->fileId));
        $fileDownloader = new FileDownloader($stream, self::DOWNLOAD_CHUNK_SIZE);
        $fileDownloader->downloadFile();
    }
}
