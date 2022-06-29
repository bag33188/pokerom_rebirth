<?php

namespace App\Jobs;

use GfsRomFile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Utils\Modules\GfsMethods;

class ProcessRomFileUpload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    private string $filename;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $filename)
    {
        $this->filename = $filename;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $stream = fopen(GfsMethods::makeFilepathFromFilename($this->filename), 'rb');
        GfsRomFile::gfsBucket()->uploadFromStream($this->filename, $stream);
        fclose($stream);
    }
}