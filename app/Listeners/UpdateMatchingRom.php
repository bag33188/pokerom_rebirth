<?php

namespace App\Listeners;

use App\Events\RomFileCreated;
use App\Http\Resources\RomResource;
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
    public static ?Rom $matchingRom;

    public function shouldQueue(RomFileCreated $event): bool
    {
        $rom = RomFileRepo::searchForRomMatchingFile($event->romFile->filename);
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
     * @param RomFileCreated $event
     * @return void
     */
    public function handle(RomFileCreated $event): void
    {
        Rom::withoutEvents(function () use ($event) {
            $romFileId = $event->romFile->getKey();
            self::$matchingRom->has_file = true;
            self::$matchingRom->file_id = $romFileId;
            self::$matchingRom->rom_size = ceil($event->romFile->length / 1024);
            self::$matchingRom->save();
        });
    }
}
