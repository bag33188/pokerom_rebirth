<?php

namespace App\Http\Livewire\Roms;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;
use RomRepo;

class Delete extends Component
{
    use AuthorizesRequests;

    public int $romId;

    public function mount(int $romId)
    {
        $this->romId = $romId;
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.roms.delete', ['romId' => $this->romId]);
    }

    /**
     * @throws AuthorizationException
     */
    public function delete(int $romId): RedirectResponse
    {
        $rom = RomRepo::findRomIfExists($romId);
        $this->authorize('delete', $rom);
        $rom->delete();
        return redirect()->route('roms.index')->banner($rom->rom_name . " successfully deleted!");
    }
}
