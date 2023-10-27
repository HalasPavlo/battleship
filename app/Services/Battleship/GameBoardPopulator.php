<?php

namespace App\Services\Battleship;

use App\Models\Game;
use App\Models\GameBoard;
use Carbon\Carbon;

class GameBoardPopulator
{
    public function populateGameBoards(Game $game)
    {
        return GameBoard::insert([
            [
                'user_id' => $game->owner->id,
                'game_id' => $game->id,
                'board_data' => '{}',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => $game->companion->id,
                'game_id' => $game->id,
                'board_data' => '{}',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}