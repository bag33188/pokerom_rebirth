<?php

namespace App\Http\Livewire\Rom;

use App\Enums\SessionMessageTypeEnum as SessionMessageType;
use App\Interfaces\Action\RomActionsInterface;
use App\Interfaces\Service\RomServiceInterface;
use App\Models\Rom;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use RomRepo;

class Show extends Component
{
    /** @var Rom */
    public $rom;

    // route params
    public $romId;

    public function mount(int $romId)
    {
        $this->romId = $romId;
        $this->rom = RomRepo::getSingleRomWithGameInfo($romId);
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.rom.show');
    }

    public function edit(int $romId)
    {
        $this->redirect(route('roms.edit', $romId));
    }

    public function attemptToLinkRomToRomFile(RomServiceInterface $romService)
    {
        $stmt = $romService->linkRomToRomFileIfExists($this->rom);
        $this->redirect(route('roms.show', $this->romId));
        $this->rom->refresh();
        if ($stmt === false) {
            session()->flash('message', "No matching ROM File found with name of {$this->rom->getRomFileName()}");
            session()->flash('message-type', SessionMessageType::ERROR);
        } else {
            session()->flash('message', "ROM File found and linked! File ID: {$this->rom->file_id}");
            session()->flash('message-type', SessionMessageType::SUCCESS);
        }
    }
}
