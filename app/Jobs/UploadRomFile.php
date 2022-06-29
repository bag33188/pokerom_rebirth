<?php

namespace App\Jobs;

use GfsRomFile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use MongoDB\Client as MongoClient;

class UploadRomFile implements ShouldQueue
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
    public function handle()
    {

        $stream = fopen(sprintf("%s/%s", Config::get('gridfs.fileUploadPath'), $this->filename), 'rb');
        GfsRomFile::$gfsBucket->uploadFromStream($this->filename, $stream);
        fclose($stream);
    }
}
