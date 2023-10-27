<?php

namespace App\Services\Battleship;

use App\Models\GameMove;

class NextMoveAssigner
{
    public function assignNextMove(GameMove $game_move): GameMove
    {

        return match ($game_move->result) {
            GameMove::FIELD_RESULT_MISS => $this->assignOpponent($game_move),
            default => $game_move,
        };
    }


    private function assignOpponent(GameMove $game_move): GameMove
    {
        $game_move->game->current_turn = $game_move->game->owner->id === $game_move->user_id ? $game_move->game->companion->id : $game_move->game->owner->id;
        $game_move->game->save();

        return $game_move;
    }
}