<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Utils\Modules\GridFsMethods;

class ProcessRomFileDeletion implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $fileId;

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
        $bsonObjectId = GridFsMethods::parseObjectId($this->fileId);
        GfsRomFile::getBucket()->delete($bsonObjectId);
    }
}
