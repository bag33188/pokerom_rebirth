<?php

namespace App\Jobs;

use GfsRomFile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Utils\Modules\FileMethods;

class ProcessRomFileUpload implements ShouldQueue
{
    use Dispatchable, Queueable;


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
        $stream = fopen(FileMethods::makeFilepathFromFilename($this->filename), 'rb');
        GfsRomFile::getBucket()->uploadFromStream($this->filename, $stream);
        fclose($stream);
    }
}
