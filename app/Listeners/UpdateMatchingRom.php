<?php

namespace App\Listeners;

use App\Events\FileUploaded;
use App\Models\Rom;
use RomFileRepo;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateMatchingRom implements ShouldQueue
{
    use InteractsWithQueue;

    public bool $afterCommit = true;

    /**
     * Needs to be static since RomFile bucket connection is singleton
     *
     * @var Rom
     */
    private static Rom $matchingRom;

    public function shouldQueue(FileUploaded $event): bool
    {
        $this->setMatchingRom(RomFileRepo::searchForRomMatchingFile($event->file->getKey()));
        return !$event->file->rom()->exists() && isset(self::$matchingRom);
    }

    /**
     * be sure to rap in an instance method since even has multiple instances
     *
     * @param Rom $rom
     * @return void
     */
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
