<?php

namespace App\Services\Battleship;

use App\Models\Game;
use App\Models\User;
use App\Exceptions\RuntimeException;

class GameUserAssigner
{
    public function __construct(private GameBoardPopulator $populator)
    {
    }

    public function assignUserToGame(User $user, Game $game): Game
    {
        if ($user->id === $game->owner->id) {
            throw new RuntimeException('User is already is this game.');
        }

        if ($game->user_2_id) {
            throw new RuntimeException('Max players length reached.');
        }

        $game->companion()->associate($user)->save();

        $this->populator->populateGameBoards($game);

        return $game;
    }
}