<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_1_id',
        'user_2_id',
        'current_turn',
        'ends_at'
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_1_id', 'id');
    }

    public function companion(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_2_id', 'id');
    }

    public function boards(): hasMany
    {
        return $this->hasMany(GameBoard::class);
    }
}
