<?php

namespace App\Http\Livewire\Rom;

use App\Actions\Validators\RomValidationRulesTrait;
use App\Models\Rom;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use JetBrains\PhpStorm\ArrayShape;
use Livewire\Component;
use RomRepo;

class Edit extends Component
{
    use RomValidationRulesTrait;

    /** @var Rom */
    public $rom;
    public $romId;
    public $rom_name;
    public $rom_size;
    public $rom_type;

    #[ArrayShape(['rom_name' => "array", 'rom_type' => "array", 'rom_size' => "array"])]
    public function rules(): array
    {
        return [
            'rom_name' => $this->romNameRules(),
            'rom_type' => $this->romTypeRules(),
            'rom_size' => $this->romSizeRules(),
        ];
    }

    public function mount(int $romId)
    {
        $this->romId = $romId;
        $this->rom = RomRepo::findRomIfExists($romId);
        $this->fill(
            [
                'rom_type' => $this->rom->rom_type,
                'rom_name' => $this->rom->rom_name,
                'rom_size' => $this->rom->rom_size
            ]
        );
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.rom.edit');
    }

    public function update()
    {
        $this->validate();
        $this->rom = RomRepo::findRomIfExists($this->romId);
        $this->rom->update([
            'rom_type' => $this->rom_type,
            'rom_name' => $this->rom_name,
            'rom_size' => $this->rom_size
        ]);
//        return redirect()->route('roms.show', ['romId' => $this->romId])->banner('Rom Updated successfully.');
    }
}
