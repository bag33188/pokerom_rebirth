<?php

namespace App\Http\Livewire\Game;

use App\Http\Validators\GameValidationRulesTrait;
use App\Interfaces\Service\GameServiceInterface;
use App\Models\Game;
use Exception;
use GameRepo;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\{Foundation\Application, View\Factory, View\View};
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use JetBrains\PhpStorm\ArrayShape;
use Livewire\Component;

class Create extends Component
{
    use GameValidationRulesTrait, AuthorizesRequests;

    // props
    public $availableRoms;
    public $romsAreAvailable;

    // wire models
    public $game_name;
    public $game_type;
    public $generation;
    public $date_released;
    public $region;
    public $rom_id;

    public function boot()
    {
        // add select placeholder
        $this->region = REGIONS[0];
//        $this->game_type = GAME_TYPES[0];
        $this->rom_id = 0;
    }

    public function mount()
    {
        $this->availableRoms = GameRepo::getAllRomsWithNoGame();
        $this->romsAreAvailable = count($this->availableRoms) > 0;
        if ($this->romsAreAvailable) {
            $this->rom_id = $this->availableRoms[0]->id;
        }
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

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }


    /**
     * @throws AuthorizationException
     */
    public function store(GameServiceInterface $gameService)
    {
        $this->authorize('create', Game::class);

        $this->validate();
        try {
            $gameService->createGameFromRomId($this->rom_id, [
                'game_name' => $this->game_name,
                'game_type' => $this->game_type,
                'region' => $this->region,
                'date_released' => $this->date_released,
                'generation' => $this->generation
            ]);
            $this->reset();
            $this->redirect(route('games.index'));

        } catch (Exception $e) {
            session()->flash('message', $e->getMessage());
        }
    }
}
