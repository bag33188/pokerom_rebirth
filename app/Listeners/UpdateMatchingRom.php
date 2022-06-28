<?php

namespace App\Listeners;

use App\Events\FileUploaded;
use App\Models\Rom;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use RomFileRepo;

class UpdateMatchingRom implements ShouldQueue
{
    use InteractsWithQueue;

    public bool $afterCommit = true;

    /**
     * Needs to be static since RomFile bucket connection is scoped singleton
     *
     * @var Rom
     */
    private static Rom $matchingRom;

    public function shouldQueue(FileUploaded $event): bool
    {
        $rom = RomFileRepo::searchForRomMatchingFile($event->file->getKey());
        $this->setMatchingRom($rom);
        return !$event->file->rom()->exists() && $this->matchingRomExists();
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

    private function matchingRomExists(): bool
    {
        return isset(self::$matchingRom);
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
