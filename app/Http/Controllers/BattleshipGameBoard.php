<?php

namespace App\Http\Controllers;

use App\Exceptions\RuntimeException;
use App\Http\Requests\SetupGameRequest;
use App\Http\Resources\GameBoardResource;
use App\Models\GameBoard;
use App\Services\Battleship\UserBoardSetupCreator;
use Illuminate\Support\Facades\Auth;

class BattleshipGameBoard extends Controller
{
    public function __construct(private UserBoardSetupCreator $creator)
    {
    }

    public function index(string $game_id)
    {
        $game_board = GameBoard::query()->where('game_id', $game_id)
            ->where('user_id', Auth::user()->id)
            ->get();

        return new GameBoardResource($game_board);
    }

    public function store(string $game_id, SetupGameRequest $request)
    {

        $game_board = GameBoard::query()->where('game_id', $game_id)
            ->where('user_id', Auth::user()->id)
            ->first();

        if (!$game_board) {
            throw new RuntimeException('Game board not found.');
        }

        return new GameBoardResource($this->creator->setupBoard($request, $game_board));
    }
}
