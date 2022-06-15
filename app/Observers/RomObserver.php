<?php

namespace App\Observers;

use App\Models\Rom;

class RomObserver
{
    /**
     * Handle the Rom "created" event.
     *
     * @param  \App\Models\Rom  $rom
     * @return void
     */
    public function created(Rom $rom)
    {
        //
    }

    /**
     * Handle the Rom "updated" event.
     *
     * @param  \App\Models\Rom  $rom
     * @return void
     */
    public function updated(Rom $rom)
    {
        //
    }

    /**
     * Handle the Rom "deleted" event.
     *
     * @param  \App\Models\Rom  $rom
     * @return void
     */
    public function deleted(Rom $rom)
    {
        //
    }

    /**
     * Handle the Rom "restored" event.
     *
     * @param  \App\Models\Rom  $rom
     * @return void
     */
    public function restored(Rom $rom)
    {
        //
    }

    /**
     * Handle the Rom "force deleted" event.
     *
     * @param  \App\Models\Rom  $rom
     * @return void
     */
    public function forceDeleted(Rom $rom)
    {
        //
    }
}
