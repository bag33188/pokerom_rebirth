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
        $this->romsTableColumns = array('ROM Name', 'ROM Size', 'ROM Type', 'Game Name', 'Download');
    }

    public function render(): Factory|View|Application
    {
        $this->roms = Rom::with(['game', 'file'])->get();
        $sum_total_size = DB::selectOne(/** @lang MariaDB */ "CALL GetTotalSizeOfAllRoms;");
        return view('livewire.roms.index', ['roms_total_size' => $sum_total_size->total_size]);
    }

    public function getRomReadableSize(int $size)
    {
        $sql = /** @lang MariaDB */
            "SELECT CalcReadableRomSize(?) AS readable_size;";
        return DB::selectOne($sql, [$size])->readable_size;
    }

    public function getRomDownloadUrl(string $fileId, bool $dev = false): string
    {
        $baseUrl = "/public/api";
        $baseFilesEndpoint = "files/$fileId/download";
        if ($dev) return "$baseUrl/dev/$baseFilesEndpoint";
        return "$baseUrl/$baseFilesEndpoint";
    }
}
