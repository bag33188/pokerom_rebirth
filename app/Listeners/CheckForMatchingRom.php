<?php

namespace App\Listeners;

use App\Events\FileUploaded;
use App\Interfaces\FileRepositoryInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CheckForMatchingRom
{
    private FileRepositoryInterface $fileRepository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(FileRepositoryInterface $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }

    /**
     * Handle the event.
     *
     * @param FileUploaded $event
     * @return void
     */
    public function handle(FileUploaded $event): void
    {
        $rom = $this->fileRepository->searchForRomMatchingFile($event->file->getKey())->first();
        if (isset($rom)) {
            $rom['has_file'] = true;
            $rom['file_id'] = $event->file->getKey();
            $rom->saveQuietly();
        }
    }
}
