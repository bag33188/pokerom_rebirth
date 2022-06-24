<?php

namespace App\Http\Livewire\Roms;

use App\Models\Rom;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use RomRepo;

class Show extends Component
{
    private Rom $rom;
    private int $romId;

    public function mount(int $romId)
    {
        $this->romId = $romId;
        $this->rom = RomRepo::getSingleRomWithGameAndFileInfo($romId);
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.roms.show', ['rom' => $this->rom, 'romId' => $this->romId]);
    }
}
