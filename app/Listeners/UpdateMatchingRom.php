<?php

namespace App\Listeners;

use App\Events\RomFileUploaded;
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
     * @var Rom|null
     */
    private static ?Rom $matchingRom;

    public function shouldQueue(RomFileUploaded $event): bool
    {
        $rom = RomFileRepo::searchForRomMatchingFile($event->romFile->getKey());
        $this->setMatchingRom($rom);
        return !$event->romFile->rom()->exists() && $this->matchingRomExists();
    }

    /**
     * be sure to rap in an instance method since even has multiple instances
     *
     * @param Rom|null $rom
     * @return void
     */
    private function setMatchingRom(?Rom $rom): void
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
     * @param RomFileUploaded $event
     * @return void
     */
    public function handle(RomFileUploaded $event): void
    {
        Rom::withoutEvents(function () use ($event) {
            $fileId = $event->romFile->getKey();
            self::$matchingRom->has_file = true;
            self::$matchingRom->file_id = $fileId;
            self::$matchingRom->save();
        });
    }
}
