<?php

namespace App\Http\Livewire\Rom;

use App\Models\Rom;
use Illuminate\Contracts\{Foundation\Application, View\Factory, View\View};
use Livewire\Component;
use RomFileRepo;
use RomRepo;

class Index extends Component
{
    /** @var Rom[] */
    public $roms;

    // props
    public $romsTableColumns;

    public function boot()
    {
        $this->roms = RomRepo::getRomsWithGameAndFileInfo();
    }

    public function booted()
    {
        $this->romsTableColumns = array('ROM Name', 'ROM Size', 'ROM Type', 'Game Name', 'Download', 'Information');
    }

    public function render(): Factory|View|Application
    {
        $romFileSizeSum = RomFileRepo::getTotalSizeOfAllRomFiles();
        return view('livewire.rom.index', ['roms_total_size' => $romFileSizeSum]);
    }

    public function show(int $romId)
    {
        $this->redirect(route('roms.show', $romId));
    }
}
