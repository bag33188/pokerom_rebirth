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
        //
        $this->fileRepository = $fileRepository;
    }

    /**
     * Handle the event.
     *
     * @param \App\Events\FileUploaded $event
     * @return void
     */
    public function handle(FileUploaded $event)
    {
        $rom = $this->fileRepository->searchForRomMatchingFile($event->file->getAttributeValue('_id'))->first();
        if (isset($rom)) {
            $rom['has_file'] = true;
            $rom['file_id'] = $event->file->getAttributeValue('_id');
            $rom->saveQuietly();
        }
    }
}
