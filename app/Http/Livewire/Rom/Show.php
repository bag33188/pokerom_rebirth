<?php

namespace App\Http\Livewire\Rom;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use RomRepo;

class Show extends Component
{
    public $rom;
    public $romId;

    public function mount(int $romId)
    {
        $this->romId = $romId;
        $this->rom = RomRepo::getSingleRomWithGameInfo($romId);
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.rom.show');
    }

    public function edit(int $romId)
    {
        $this->redirect(route('roms.edit', $romId));
    }
}
