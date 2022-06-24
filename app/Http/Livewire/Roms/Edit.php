<?php

namespace App\Http\Livewire\Roms;

use App\Http\Requests\UpdateRomRequest;
use App\Models\Rom;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;
use RomRepo;

class Edit extends Component
{

    public Rom $rom;
    private int $romId;

    public function mount(int $romId)
    {
        $this->romId = $romId;
        $this->rom = RomRepo::findRomIfExists($romId);
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.roms.edit', ['romId' => $this->romId]);
    }

    public function update(UpdateRomRequest $request, int $romId): RedirectResponse
    {
        $this->rom = RomRepo::findRomIfExists($romId);
        $this->rom->update($request->all());
        return redirect()->route('roms.show', $romId)->banner('Rom Updated successfully.');
    }
}
