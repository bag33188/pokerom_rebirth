<?php

namespace App\Observers;

use App\Interfaces\RomDataServiceInterface;
use App\Models\Rom;

class RomObserver
{
    private RomDataServiceInterface $romDataService;

    /** @var bool Use database relationships to update models */
    private static bool $use_db_logic = true;

    public function __construct(RomDataServiceInterface $romDataService)
    {
        $this->romDataService = $romDataService;
    }

    public bool $afterCommit = false;

    public function created(Rom $rom): void
    {
        $this->romDataService->linkRomToFileIfExists($rom);
    }

    public function updated(Rom $rom): void
    {
        if (!$rom->has_file || $rom->file_id == null) {
            $this->romDataService->linkRomToFileIfExists($rom);
        }
    }

    public function deleting(Rom $rom): void
    {
        // for unique constraint purposes
        $rom['file_id'] = null;
    }

    public function deleted(Rom $rom): void
    {
        if (self::$use_db_logic === false) {
            $rom->game()->delete();
        }
    }
}
