<?php

namespace App\Listeners;

use App\Events\FileDeleted;
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
        $rom = $event->file->rom()->first();
        if (isset($rom)) {
            $rom['has_file'] = false;
            $rom['file_id'] = null;
            $rom->saveQuietly();
        }
    }
}
