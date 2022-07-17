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
    /** @var string[] */
    public $romsTableColumns;

    /** @var int */
    public $romFileSizeSum;
    /** @var int */
    public $totalRomsCount;

    /** @var string[] */
    protected $listeners = ['show'];

    public function boot()
    {
        $this->romsTableColumns = array('ROM Name', 'ROM Size', 'ROM Type', 'Game Name', 'Download', 'Information');
    }

    public function booted()
    {
        $this->romFileSizeSum = RomFileRepo::getTotalSizeOfAllRomFiles();
        $this->totalRomsCount = RomRepo::getRomsCount();
    }

    public function mount()
    {
        $this->roms = RomRepo::getRomsWithGameAndFileInfo();
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.rom.index');
    }

    public function show(int $romId)
    {
        $this->redirect(route('roms.show', $romId));
    }
}
