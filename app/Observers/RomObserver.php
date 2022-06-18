<?php

namespace App\Observers;

use App\Interfaces\RomServiceInterface;
use App\Models\Rom;

class RomObserver
{
    private RomServiceInterface $romService;

    /** @var bool Use database relationships to update models */
    private const USE_DB_LOGIC = true;

    public function __construct(RomServiceInterface $romService)
    {
        $this->romService = $romService;
    }

    public bool $afterCommit = false;

    public function created(Rom $rom): void
    {
        $this->romService->linkRomToFileIfExists($rom);
    }

    public function updated(Rom $rom): void
    {
        if (!$rom->has_file || $rom->file_id == null) {
            $this->romService->linkRomToFileIfExists($rom);
        }
    }

    public function deleting(Rom $rom): void
    {
        // for unique constraint purposes
        $rom['file_id'] = null;
    }

    public function deleted(Rom $rom): void
    {
        if (self::USE_DB_LOGIC === false) {
            $rom->game()->delete();
        }
    }
}
