<?php

namespace App\Http\Livewire\Rom;

use App\Actions\Validators\RomValidationRulesTrait;
use App\Models\Rom;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use JetBrains\PhpStorm\ArrayShape;
use Livewire\Component;

class Create extends Component
{
    use RomValidationRulesTrait;

    public $rom_name;
    public $rom_size;
    public $rom_type = ROM_TYPES[0];

    #[ArrayShape(['rom_name' => "array", 'rom_type' => "array", 'rom_size' => "array"])]
    protected function rules(): array
    {
        return [
            'rom_name' => $this->romNameRules(),
            'rom_type' => $this->romTypeRules(),
            'rom_size' => $this->romSizeRules(),
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.rom.create');
    }

    public function submit()
    {
        $this->validate();
        try {
            Rom::create([
                'rom_name' => $this->rom_name,
                'rom_size' => $this->rom_size,
                'rom_type' => $this->rom_type
            ]);

            $this->redirect(route('roms.index'));
        } catch (Exception $e) {
            session()->flash('message', $e->getMessage());
        }
    }
}
