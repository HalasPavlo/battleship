<?php

namespace App\Http\Controllers;

use App\Http\Requests\MoveRequest;
use App\Http\Resources\GameMoveResource;
use App\Models\Game;
use App\Models\GameMove;
use App\Services\Battleship\GameMoveCreator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BattleshipGameMove extends Controller
{
    public function __construct(private GameMoveCreator $creator)
    {
    }

    public function index(string $game_id)
    {
        $game_moves = GameMove::query()->where('game_id', $game_id)
            ->where('user_id', Auth::user()->id)
            ->orderBy('id', 'desc')
            ->paginate(20);

        return new GameMoveResource($game_moves);
    }

    public function store(string $game_id, MoveRequest $request)
    {
        $game = Game::where('id', $game_id)
            ->firstOrFail();

        $game_move = $this->creator->createGameMove($game, Auth::user(), $request);

        return new GameMoveResource($game_move);
    }
}
