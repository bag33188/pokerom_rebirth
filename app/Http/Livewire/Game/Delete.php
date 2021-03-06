<?php

namespace App\Http\Livewire\Game;

use GameRepo;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Delete extends Component
{
    use AuthorizesRequests;

    // route params
    public $gameId;

    public function mount(int $gameId)
    {
        $this->gameId = $gameId;
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.game.delete');
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(int $gameId): void
    {
        $game = GameRepo::findGameIfExists($gameId);
        $this->authorize('delete', $game);
        $game->delete();
        $this->redirect(route('games.index'));
    }
}
