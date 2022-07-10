<?php

namespace App\Http\Livewire\Rom;

use App\Http\Validators\RomValidationRulesTrait;
use App\Models\Rom;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use JetBrains\PhpStorm\ArrayShape;
use Livewire\Component;
use RomRepo;

class Edit extends Component
{
    use RomValidationRulesTrait, AuthorizesRequests;

    /** @var Rom */
    public $rom;

    // route params
    public $romId;

    // wire models
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
                'rom_type' => strtolower($this->rom->rom_type),
                'rom_name' => $this->rom->rom_name,
                'rom_size' => $this->rom->rom_size
            ]
        );
    }

    public function cancel(int $romId)
    {
        $this->redirect(route('roms.show', $romId));
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.rom.edit');
    }

    /**
     * @throws AuthorizationException
     */
    public function update()
    {
        $this->authorize('update', $this->rom);
        $this->validate();
        try {
            $this->rom->update([
                'rom_type' => $this->rom_type,
                'rom_name' => $this->rom_name,
                'rom_size' => $this->rom_size
            ]);
            $this->redirect(route('roms.show', $this->romId));
        } catch (Exception $e) {
            session()->flash('message', $e->getMessage());
        }
    }
}
