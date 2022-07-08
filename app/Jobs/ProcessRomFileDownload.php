<?php

namespace App\Jobs;

use App\Services\GridFS\RomFilesConnection as RomFileProcessor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use MongoDB\BSON\ObjectId;

class ProcessRomFileDownload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Rom File Object ID Instance
     *
     * @var ObjectId
     */
    public ObjectId $romFileId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ObjectId $romFileId)
    {
        $this->romFileId = $romFileId;
    }

    /**
     * Execute the job.
     *
     * @param RomFileProcessor $romFileProcessor
     * @return void
     */
    public function handle(RomFileProcessor $romFileProcessor): void
    {
        $romFileProcessor->actions()->download($this->romFileId, CONTENT_TRANSFER_SIZE);
    }
}
