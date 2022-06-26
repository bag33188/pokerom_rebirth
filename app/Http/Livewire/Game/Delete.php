<?php

namespace App\Http\Livewire\Game;

use GameRepo;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;

class Delete extends Component
{
    use AuthorizesRequests;

    public int $gameId;

    public function mount(int $gameId)
    {
        $this->gameId = $gameId;
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.game.delete', ['gameId' => $this->gameId]);
    }

    /**
     * @throws AuthorizationException
     */
    public function delete(int $gameId): RedirectResponse
    {
        $game = GameRepo::findGameIfExists($gameId);
        $this->authorize('delete', $game);
        $game->delete();
        return redirect()->route('games.index')->banner("$game->game_name successfully deleted!");
    }
}
