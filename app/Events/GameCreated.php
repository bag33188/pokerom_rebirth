<?php

namespace App\Events;

use App\Models\Game;
use App\Models\Rom;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GameCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Game $game;
    public Rom $rom;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Game $game, Rom $rom)
    {
        $this->game = $game;
        $this->rom = $rom;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|PrivateChannel|array
     */
    public function broadcastOn(): Channel|PrivateChannel|array
    {
        return new PrivateChannel('channel-name');
    }
}
