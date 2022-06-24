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

    private static Rom $matchingRom;

    public function shouldQueue(FileUploaded $event): bool
    {
        $this->setMatchingRom(FileRepo::searchForRomMatchingFile($event->file->getKey()));
        return !$event->file->rom()->exists() && isset(self::$matchingRom);
    }

    private function setMatchingRom(Rom $rom): void
    {
        self::$matchingRom = $rom;
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
            self::$matchingRom->has_file = true;
            self::$matchingRom->file_id = $fileId;
            self::$matchingRom->save();
        });
    }
}
