<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    const FK_GAME_BOARD_USER = 'fk_game_board_user';
    const FK_GAME_BOARD_GAME = 'fk_game_board_game';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('game_boards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('game_id');
            $table->json('board_data');
            $table->timestamps();

            $table->foreign('user_id', self::FK_GAME_BOARD_USER)->references('id')->on('users');
            $table->foreign('game_id', self::FK_GAME_BOARD_GAME)->references('id')->on('games');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('game_boards', function (Blueprint $table) {
//            SQLLite doesn't support foreign key drop
//            $table->dropForeign(self::FK_GAME_BOARD_USER);
//            $table->dropForeign(self::FK_GAME_BOARD_GAME);
        });

        Schema::dropIfExists('game_boards');
    }
};
