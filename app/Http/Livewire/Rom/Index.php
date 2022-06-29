<?php

namespace App\Http\Livewire\Rom;

use App\Models\Rom;
use Illuminate\Contracts\{Foundation\Application, View\Factory, View\View};
use Illuminate\Support\Facades\DB;
use Livewire\Component;

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
        $sql = /** @lang MariaDB */
            "CALL GetTotalSizeOfAllRoms;";
        $sum_total_size = DB::selectOne($sql);
        return view('livewire.rom.index', ['roms_total_size' => $sum_total_size->total_size]);
    }

    public function getRomDownloadUrl(string $fileId, bool $dev = false): string
    {
        $baseUrl = "/public/api";
        $baseFilesEndpoint = "files/grid/$fileId/download";
        if ($dev) return "$baseUrl/dev/$baseFilesEndpoint";
        return "$baseUrl/$baseFilesEndpoint";
    }

    public function show(int $romId)
    {
        $this->redirect(route('roms.show', $romId));
    }
}
