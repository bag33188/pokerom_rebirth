<?php

namespace App\Observers;

use App\Interfaces\RomActionsInterface;
use App\Models\Rom;

class RomObserver
{
    private RomActionsInterface $romActions;

    /** @var bool Use database relationships to update models */
    private static bool $USE_DATABASE_LOGIC = true;

    public function __construct(RomActionsInterface $romActions)
    {
        $this->romActions = $romActions;
    }

    public bool $afterCommit = false;

    public function created(Rom $rom): void
    {
        $this->romActions->linkRomToFileIfExists($rom);
    }

    public function updated(Rom $rom): void
    {
        if (!$rom->has_file || $rom->file_id == null) {
            $this->romActions->linkRomToFileIfExists($rom);
        }
    }

    public function deleting(Rom $rom): void
    {
        // for unique constraint purposes
        $rom['file_id'] = null;
    }

    public function deleted(Rom $rom): void
    {
        if (self::$USE_DATABASE_LOGIC === false) {
            $rom->game()->delete();
        }
    }
}
