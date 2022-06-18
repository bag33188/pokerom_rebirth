<?php

namespace App\Listeners;

use App\Events\FileDeleted;
use App\Models\Rom;
use Illuminate\Contracts\Queue\ShouldQueue;

class UnsetRomFileData implements ShouldQueue
{

    public function shouldQueue(FileDeleted $event): bool
    {
        return $event->file->rom()->exists();
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
            $rom = $event->file->rom()->first();
            $rom['has_file'] = false;
            $rom['file_id'] = null;
            $rom->save();
        });
    }
}
