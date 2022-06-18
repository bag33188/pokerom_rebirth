<?php

namespace App\Observers;

use App\Interfaces\RomRepositoryInterface;
use App\Interfaces\RomServiceInterface;
use App\Models\Rom;
use DB;

class RomObserver
{
    private RomServiceInterface $romService;

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
        $rom->game()->delete();
    }
}
