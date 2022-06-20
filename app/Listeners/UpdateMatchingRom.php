<?php

namespace App\Listeners;

use App\Events\FileUploaded;
use App\Interfaces\FileRepositoryInterface;
use App\Models\Rom;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateMatchingRom implements ShouldQueue
{
    use InteractsWithQueue;

    private FileRepositoryInterface $fileRepository;

    public bool $afterCommit = true;

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
        Rom::withoutEvents(function () use ($event) {
            $fileId = $event->file->getKey();
            $rom = $this->fileRepository->searchForRomMatchingFile($fileId);
            if (isset($rom)) {
                $rom['has_file'] = true;
                $rom['file_id'] = $fileId;
                $rom->save();
            }
        });
    }
}
