<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameBoard extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'user_id',
    ];

    protected $casts = [
        'board_data' => 'array',
    ];

    public function game()
    {
        return $this->hasOne(Game::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
