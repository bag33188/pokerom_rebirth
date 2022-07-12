<?php

namespace App\Listeners;

use App\Events\RomFileDeleted;
use App\Models\Rom;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UnsetRomFileDataFromRom implements ShouldQueue
{
    use InteractsWithQueue;

    public bool $afterCommit = false;

    public function shouldQueue(RomFileDeleted $event): bool
    {
        return $event->romFile->rom()->exists();
    }

    /**
     * Handle the event.
     *
     * @param RomFileDeleted $event
     * @return void
     */
    public function handle(RomFileDeleted $event): void
    {
        Rom::withoutEvents(function () use ($event) {
            $rom = $event->romFile->rom()->first();
            $rom->has_file = FALSE;
            $rom->file_id = NULL;
            $rom->save();
        });
    }
}
