<?php

namespace App\Http\Livewire\Game;

use App\Enums\SessionMessageTypeEnum as SessionMessageType;
use App\Http\Validators\GameValidationRulesTrait;
use App\Interfaces\Service\GameServiceInterface;
use App\Models\Game;
use Date;
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

    public function mount()
    {
        $this->availableRoms = GameRepo::getAllRomsWithNoGame();
        $this->romsAreAvailable = count($this->availableRoms) > 0;
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.game.create');
    }

    #[ArrayShape(['rom_id' => "string", 'game_name' => "array", 'date_released' => "array", 'game_type' => "array", 'region' => "array", 'generation' => "array"])]
    public function rules(): array
    {
        return [
            'rom_id' => 'required|integer',
            'game_name' => $this->gameNameRules(),
            'date_released' => $this->dateReleasedRules(),
            'game_type' => $this->gameTypeRules(),
            'region' => $this->gameRegionRules(),
            'generation' => $this->gameGenerationRules(),
        ];
    }

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }


    /**
     * @throws AuthorizationException
     */
    public function store(GameServiceInterface $gameService): void
    {
        $this->authorize('create', Game::class);

        $this->validate();
        try {
            $gameService->createGameFromRomId($this->rom_id, [
                'game_name' => $this->game_name,
                'game_type' => $this->game_type,
                'region' => $this->region,
                'date_released' => Date::create($this->date_released),
                'generation' => (int)$this->generation
            ]);
            $this->reset();
            $this->redirect(route('games.index'));

        } catch (Exception $e) {
            session()->flash('message', $e->getMessage());
            session()->flash('message-type', SessionMessageType::ERROR);
        }
    }
}
