<?php

namespace App\Observers;

use App\Interfaces\Action\RomActionsInterface;
use App\Models\Rom;

class RomObserver
{
    /** @var bool Use database relationships to update models */
    private const USE_DB_LOGIC = true;


    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public bool $afterCommit = false;


    public function __construct(private readonly RomActionsInterface $romActions)
    {
    }

    private function currentRequestIsLivewireRequest(): bool
    {
        $livewireHttpHeader = request()->header('X-Livewire');
        return !empty($livewireHttpHeader);
    }

    public function created(Rom $rom): void
    {
        $this->romActions->linkRomToRomFileIfExists($rom);
    }

    public function updated(Rom $rom): void
    {
        if (!$this->currentRequestIsLivewireRequest()) {
            if (!$rom->has_file) {
                $this->romActions->linkRomToRomFileIfExists($rom);
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
        if (self::USE_DB_LOGIC === false) {
            $rom->game()->delete();
        }
    }
}
