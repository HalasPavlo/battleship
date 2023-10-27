<?php

namespace App\Http\Controllers;

use App\Http\Resources\GameResource;
use App\Models\Game;
use App\Services\Battleship\GameCreator;
use App\Services\Battleship\GameUserAssigner;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class BattleshipGame extends Controller
{
    public function __construct(private GameCreator $game_creator, private GameUserAssigner $assigner)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResource
    {
        return new GameResource(Game::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(): JsonResource
    {
        return new GameResource($this->game_creator->createGame(Auth::user()));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResource
    {
        $user_id = Auth::user()->id;
        $game = Game::query()->where('id', $id)->where(function ($query) use ($user_id) {
            $query->where('user_1_id', $user_id)
                ->orWhere('user_2_id', $user_id);
        })
            ->firstOrFail();

        return new GameResource($game);
    }

    public function update(Request $request, string $id): JsonResource
    {
        $user = Auth::user();

        $game = Game::findOrFail($id);

        return new GameResource($this->assigner->assignUserToGame($user, $game));
    }
}
