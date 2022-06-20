<?php

namespace App\Listeners;

use App\Events\FileUploaded;
use App\Models\Rom;
use FileRepo;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateMatchingRom implements ShouldQueue
{
    use InteractsWithQueue;


    public bool $afterCommit = true;

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
            $rom = FileRepo::searchForRomMatchingFile($fileId);
            if (isset($rom)) {
                $rom['has_file'] = true;
                $rom['file_id'] = $fileId;
                $rom->save();
            }
        });
    }
}
