<?php

namespace App\Http\Livewire\Rom;

use App\Http\Requests\StoreRomRequest;
use App\Models\Rom;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;

class Create extends Component
{
    public function render(): Factory|View|Application
    {
        return view('livewire.rom.create');
    }

    public function store(StoreRomRequest $request): RedirectResponse
    {
        Rom::create($request->all());
        return redirect()->route('roms.index')->banner("$request->rom_name created!");
    }
}
