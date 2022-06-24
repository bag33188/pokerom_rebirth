<?php

namespace App\Http\Livewire\Roms;

use App\Models\Rom;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use RomRepo;

class Edit extends Component
{
    use AuthorizesRequests;

    public Rom $rom;

    public function mount(int $id)
    {
        RomRepo::findRomIfExists($id);
    }

    public function render()
    {
        return view('livewire.roms.edit');
    }

    public function update()
    {
        $this->authorize('update', $this->rom);
    }
}
