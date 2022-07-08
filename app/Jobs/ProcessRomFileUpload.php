<?php

namespace App\Jobs;

use GfsRomFile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessRomFileUpload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * Rom Filename Instance
     *
     * @var string
     */
    public string $romFilename;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $romFilename)
    {
        $this->romFilename = $romFilename;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        GfsRomFile::actions()->upload($this->romFilename);
    }
}
