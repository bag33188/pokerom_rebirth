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

    public function shouldQueue(FileUploaded $event): bool
    {
        $fileId = $event->file->getKey();
        $rom = FileRepo::searchForRomMatchingFile($fileId);
        return isset($rom);
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
            $rom = $event->file->rom()->first();
            $rom['has_file'] = true;
            $rom['file_id'] = $event->file->_id;
            $rom->save();
        });
    }
}
