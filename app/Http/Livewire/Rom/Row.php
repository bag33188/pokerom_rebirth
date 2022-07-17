<?php

namespace App\Http\Livewire\Rom;

use App\Models\Rom;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Row extends Component
{
    public Rom $rom;

    public function render(): Factory|View|Application
    {
        return view('livewire.rom.row');
    }
}
