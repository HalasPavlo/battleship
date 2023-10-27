<?php

namespace App\Services\Battleship;

use App\Models\GameMove;
use Carbon\Carbon;

class GameOverChecker
{
    const GAME_OVER_NUMBER = 12;

    public function checkGameOver(GameMove $move): GameMove
    {
        return match ($move->result) {
            GameMove::FIELD_RESULT_HIT => $this->processGameOver($move),
            default => $move
        };
    }

    private function processGameOver(GameMove $move): GameMove
    {
        $count = GameMove::query()->where('game_id', $move->game_id)
            ->where('user_id', $move->user_id)
            ->where('result', GameMove::FIELD_RESULT_HIT)
            ->count();

        if ($count === self::GAME_OVER_NUMBER) {
            $move->game->winner = $move->user_id;
            $move->game->end_at = Carbon::now();
            $move->game->save();
        }

        return $move;
    }
}