<?php

namespace App\Http\Livewire\Roms;

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
        $this->roms = Rom::with(['game', 'file'])->get();
        $sql = /** @lang MariaDB */
            "CALL GetTotalSizeOfAllRoms;";
        $sum_total_size = DB::selectOne($sql);
        return view('livewire.roms.index', ['roms_total_size' => $sum_total_size->total_size]);
    }

    public function getRomDownloadUrl(string $fileId, bool $dev = false): string
    {
        $baseUrl = "/public/api";
        $baseFilesEndpoint = "files/$fileId/download";
        if ($dev) return "$baseUrl/dev/$baseFilesEndpoint";
        return "$baseUrl/$baseFilesEndpoint";
    }
}
