<?php

namespace App\Listeners;

use App\Events\RomFileCreated;
use App\Models\Rom;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use RomRepo;

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

    public function shouldQueue(RomFileCreated $event): bool
    {
        $possibleRomThatMatchesRomFileInstance = RomRepo::searchForRomMatchingRomFile($event->romFile);
        $this->setMatchingRom($possibleRomThatMatchesRomFileInstance);
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
     * @param RomFileCreated $event
     * @return void
     */
    public function handle(RomFileCreated $event): void
    {
        Rom::withoutEvents(function () use ($event) {
            self::$matchingRom->has_file = TRUE;
            self::$matchingRom->file_id = $event->romFile->_id;
            self::$matchingRom->rom_size = $event->romFile->calculateRomSizeFromLength();
            self::$matchingRom->save();
        });
    }
}
