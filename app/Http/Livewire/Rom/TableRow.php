<?php

namespace App\Http\Livewire\Rom;

use App\Models\Rom;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class TableRow extends Component
{
    public Rom $rom;
    public int $index;

    public function getInfo(int $romId): void
    {
        $this->emitUp('show', $romId);
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.rom.table-row');
    }
}
