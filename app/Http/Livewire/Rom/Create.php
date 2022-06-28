<?php

namespace App\Http\Livewire\Rom;

use App\Actions\Validators\RomValidationRulesTrait;
use App\Models\Rom;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;

class Create extends Component
{
    use RomValidationRulesTrait;

    public $rom_name;
    public $rom_size;
    public $rom_type;

    protected function rules()
    {
        return [
            'rom_name' => $this->romNameRules(),
            'rom_type' => $this->romTypeRules(),
            'rom_size' => $this->romSizeRules(),
        ];
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.rom.create');
    }

    public function submit()
    {
        $this->validate();
        Rom::create([
            'rom_name' => $this->rom_name,
            'rom_size' => $this->rom_size,
            'rom_type' => $this->rom_type
        ]);
    }
}
