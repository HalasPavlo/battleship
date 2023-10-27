<?php

namespace App\Services\Battleship;

use App\Models\Game;
use App\Models\User;

class GameCreator
{
    public function createGame(User $user): Game
    {
        return Game::create([
            'user_1_id' => $user->id,
            'current_turn' => $user->id
        ]);
    }
}