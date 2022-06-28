<?php

namespace App\Http\Livewire\Game;

use App\Actions\Validators\GameValidationRulesTrait;
use App\Interfaces\GameDataServiceInterface;
use GameRepo;
use Illuminate\Contracts\{Foundation\Application, View\Factory, View\View};
use JetBrains\PhpStorm\ArrayShape;
use Livewire\Component;

class Create extends Component
{
    use GameValidationRulesTrait;

    public $availableRoms = [];
    public $availableRomsCount = 0;
    public $game_name;
    public $game_type = GAME_TYPES[0];
    public $generation;
    public $date_released;
    public $region = REGIONS[0];
    public $rom_id;

    public function boot()
    {
        $this->availableRoms = GameRepo::getAllRomsWithNoGame();
        $this->availableRomsCount = count($this->availableRoms);
        $this->rom_id = $this->availableRomsCount > 0 ? $this->availableRoms[0]->id : 0;
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.game.create');
    }

    #[ArrayShape(['game_name' => "array", 'date_released' => "array", 'game_type' => "array", 'region' => "array", 'generation' => "array"])]
    public function rules(): array
    {
        return [
            'game_name' => $this->gameNameRules(),
            'date_released' => $this->dateReleasedRules(),
            'game_type' => $this->gameTypeRules(),
            'region' => $this->gameRegionRules(),
            'generation' => $this->gameGenerationRules(),
        ];
    }

    public function submit(GameDataServiceInterface $gameDataService)
    {
        $this->validate();
        $gameDataService->createGameFromRomId($this->rom_id, [
            'game_name' => $this->game_name,
            'game_type' => $this->game_type,
            'region' => $this->region,
            'date_released' => $this->date_released,
            'generation' => $this->generation
        ]);
    }
}
