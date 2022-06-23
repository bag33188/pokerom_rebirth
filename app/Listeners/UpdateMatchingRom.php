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

    private ?Rom $matchingRom;

    public function shouldQueue(FileUploaded $event): bool
    {
        $rom = FileRepo::searchForRomMatchingFile($event->file->getKey());
        if (isset($rom)) $this->matchingRom = $rom;
        return !$event->file->rom()->exists() && isset($rom);
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
            $this->matchingRom['has_file'] = true;
            $this->matchingRom['file_id'] = $fileId;
            $this->matchingRom->save();
        });
    }
}
