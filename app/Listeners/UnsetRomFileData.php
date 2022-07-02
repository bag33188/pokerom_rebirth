<?php

namespace App\Listeners;

use App\Events\FileDeleted;
use App\Models\Rom;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UnsetRomFileData implements ShouldQueue
{
    use InteractsWithQueue;

    public bool $afterCommit = false;

    public function shouldQueue(FileDeleted $event): bool
    {
        return $event->romFile->rom()->exists();
    }

    /**
     * Handle the event.
     *
     * @param FileDeleted $event
     * @return void
     */
    public function handle(FileDeleted $event): void
    {
        Rom::withoutEvents(function () use ($event) {
            $rom = $event->romFile->rom()->first();
            $rom['has_file'] = false;
            $rom['file_id'] = null;
            $rom->save();
        });
    }
}
