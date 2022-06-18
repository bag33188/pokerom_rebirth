<?php

namespace App\Listeners;

use App\Events\FileUploaded;
use App\Interfaces\FileRepositoryInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateMatchingRom
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
        $fileId = $event->file->getKey();
        $rom = $this->fileRepository->searchForRomMatchingFile($fileId)->first();
        if (isset($rom)) {
            $rom['has_file'] = true;
            $rom['file_id'] = $fileId;
            $rom->saveQuietly();
        }
    }
}