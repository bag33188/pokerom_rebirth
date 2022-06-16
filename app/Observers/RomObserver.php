<?php

namespace App\Observers;

use App\Interfaces\RomRepositoryInterface;
use App\Models\Rom;
use DB;

class RomObserver
{
    private RomRepositoryInterface $romRepository;

    public function __construct(RomRepositoryInterface $romRepository)
    {
        $this->romRepository = $romRepository;
    }

    public bool $afterCommit = false;

    public function created(Rom $rom): void
    {
        $file = $this->romRepository->searchForFileMatchingRom($rom->id)->first();
        if (isset($file)) {
            DB::statement(/** @lang MariaDB */
                "CALL LinkRomToFile(:fileId, :romSize, :romId);", [
                'fileId' => $file['_id'],
                'romSize' => $file->length,
                'romId' => $rom->id
            ]);
            $rom->refresh();
        }
    }

    public function updating(Rom $rom): void
    {
        if (!$rom->has_file || $rom->file_id == null) {
            $file = $this->romRepository->searchForFileMatchingRom($rom->id)->first();
            if (isset($file)) {
                DB::statement(/** @lang MariaDB */ "CALL LinkRomToFile(:fileId, :romSize, :romId);", [
                    'fileId' => $file['_id'],
                    'romSize' => $file->length,
                    'romId' => $rom->id
                ]);
                $rom->refresh();
            }
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
