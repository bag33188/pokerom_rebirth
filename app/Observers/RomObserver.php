<?php

namespace App\Observers;

use App\Interfaces\Action\RomActionsInterface;
use App\Interfaces\Service\RomServiceInterface;
use App\Models\Rom;
use Request;

class RomObserver
{
    /** @var bool Use database relationships to update models */
    private static bool $_USE_DB_LOGIC = true;


    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public bool $afterCommit = false;


    public function __construct(private readonly RomServiceInterface $romService)
    {
    }

    private function currentRequestIsNotLivewireRequest(): bool
    {
        $livewireHttpHeader = Request::header('X-Livewire');
        return empty($livewireHttpHeader);
    }

    public function created(Rom $rom): void
    {
        $this->romService->linkRomToRomFileIfExists($rom);
    }

    public function updated(Rom $rom): void
    {
        if ($this->currentRequestIsNotLivewireRequest()) {
            if ($rom->has_file === FALSE) {
                $this->romService->linkRomToRomFileIfExists($rom);
            }
        }
    }

    public function deleting(Rom $rom): void
    {
        // for unique constraint purposes
        $rom->file_id = NULL;
    }

    public function deleted(Rom $rom): void
    {
        if (self::$_USE_DB_LOGIC === false) {
            $rom->game()->delete();
        }
    }
}
