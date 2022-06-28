<?php

namespace App\Http\Livewire\Game;

use App\Actions\Validators\GameValidationRulesTrait;
use App\Models\Game;
use Exception;
use GameRepo;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use JetBrains\PhpStorm\ArrayShape;
use Livewire\Component;

class Edit extends Component
{
    use GameValidationRulesTrait;

    /** @var Game */
    public $game;
    public $gameId;
    public $game_name;
    public $game_type;
    public $generation;
    public $date_released;
    public $region;

    public function mount(int $gameId)
    {
        $this->gameId = $gameId;
        $this->game = GameRepo::findGameIfExists($gameId);
        $this->fill([
            'date_released' => preg_replace(TIME_STRING, '', $this->game->date_released),
            'generation' => $this->game->generation,
            'region' => strtolower($this->game->region),
            'game_type' => $this->game->game_type,
            'game_name' => ununicode_poke($this->game->game_name)
        ]);
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.game.edit');
    }

    public function cancel(int $gameId)
    {
        $this->redirect(route('games.show', $gameId));
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

    public function update()
    {
        $this->validate();
        try {
            $this->game->update([
                'game_name' => $this->game_name,
                'game_type' => $this->game_type,
                'region' => $this->region,
                'date_released' => $this->date_released,
                'generation' => $this->generation
            ]);
            return redirect()->to(route('games.show', $this->gameId));

        } catch (Exception $e) {
            session()->flash('message', $e->getMessage());
        }
    }
}
