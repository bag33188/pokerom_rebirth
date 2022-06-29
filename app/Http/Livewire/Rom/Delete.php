<?php

namespace App\Http\Livewire\Rom;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use RomRepo;

class Delete extends Component
{
    use AuthorizesRequests;

    public $romId;

    public function mount(int $romId)
    {
        $this->romId = $romId;
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.rom.delete');
    }


    /**
     * @throws AuthorizationException
     */
    public function destroy(int $romId)
    {
        $rom = RomRepo::findRomIfExists($romId);
        $this->authorize('delete', $rom);
        $rom->delete();
        $this->redirect(route('roms.index'));
    }
}
