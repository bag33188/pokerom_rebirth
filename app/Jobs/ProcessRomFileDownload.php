<?php

namespace App\Jobs;

use GfsRomFile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use MongoDB\BSON\ObjectId;

class ProcessRomFileDownload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private ObjectId $fileId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ObjectId $fileId)
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
        GfsRomFile::download($this->fileId, 0xFF000);
    }
}
