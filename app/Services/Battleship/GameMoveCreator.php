<?php

namespace App\Services\Battleship;

use App\Http\Requests\MoveRequest;
use App\Models\Game;
use App\Models\GameBoard;
use App\Models\GameMove;
use App\Models\User;
use App\Exceptions\RuntimeException;

class GameMoveCreator
{
    public function __construct(private NextMoveAssigner $assigner, private GameOverChecker $game_over_checker)
    {
    }

    public function createGameMove(Game $game, User $user, MoveRequest $request)
    {
        if (!($game->owner->id === $user->id || $game->companion->id === $user->id)) {
            throw new RuntimeException('This is not your game.');
        }

        $filled_boards = $game->boards->filter(fn(GameBoard $board) => count($board->board_data));

        if ($filled_boards->count() !== 2) {
            throw new RuntimeException('Game boards is not setup for a game.');
        }

        if ($game->current_turn !== $user->id) {
            throw new RuntimeException('This is not your turn to shot.');
        }

        if ($game->winner) {
            throw new RuntimeException('This is game is over. Winner is user id :' . $game->winner);
        }

        $move_exits = GameMove::query()->where([
            'user_id' => $user->id,
            'game_id' => $game->id,
            'column' => $request->column,
            'row' => $request->row,
        ])->exists();

        if ($move_exits) {
            throw new RuntimeException('This move is already exist, please select another cell.');
        }

        $defender = $game->current_turn === $game->owner->id ? $game->companion->id : $game->owner->id;

        $game_board = $game->boards->where('user_id', $defender)->first();

        $game_move = match ($game_board->board_data[$request->row][$request->column]) {
            UserBoardSetupCreator::FREE_SPOT => $this->createMove($user, $game, GameMove::FIELD_RESULT_MISS, $request->row, $request->column),
            UserBoardSetupCreator::SHIP_SPOT => $this->createMove($user, $game, GameMove::FIELD_RESULT_HIT, $request->row, $request->column)
        };

        return $this->game_over_checker->checkGameOver($this->assigner->assignNextMove($game_move));
    }


    private function createMove(User $user, Game $game, string $result, int $row, int $column): GameMove
    {
        $move = new GameMove();
        $move->row = $row;
        $move->column = $column;
        $move->result = $result;
        $move->user()->associate($user);
        $move->game()->associate($game);
        $move->save();

        return $move;
    }
}