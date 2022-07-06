<?php

namespace App\Http\Livewire\Rom;

use App\Models\Rom;
use Illuminate\Contracts\{Foundation\Application, View\Factory, View\View};
use Livewire\Component;
use RomFileRepo;

class Index extends Component
{
    public $roms;
    public $romsTableColumns;

    public function mount()
    {
        $this->romsTableColumns = array('ROM Name', 'ROM Size', 'ROM Type', 'Game Name', 'Download', 'Information');
    }

    public function render(): Factory|View|Application
    {
        $this->roms = Rom::with(['game', 'romFile'])->get();

        return view('livewire.rom.index', ['roms_total_size' => RomFileRepo::getTotalSizeOfAllRomFiles()]);
    }

    public function show(int $romId)
    {
        $this->redirect(route('roms.show', $romId));
    }
}
