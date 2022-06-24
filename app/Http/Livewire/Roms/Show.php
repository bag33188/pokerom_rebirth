<?php

namespace App\Http\Livewire\Roms;

use App\Models\Rom;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use RomRepo;

class Show extends Component
{
    private Rom $rom;

    public function mount(int $id)
    {
        $this->rom = RomRepo::findRomIfExists($id);
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.roms.show', ['rom' => $this->rom]);
    }
    public function getRomReadableSize(int $size)
    {
        $sql = /** @lang MariaDB */
            "SELECT CalcReadableRomSize(?) AS readable_size;";
        return DB::selectOne($sql, [$size])->readable_size;
    }
}
