<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    const FK_USER_1_ID = 'fk_games_user_1_id';
    const FK_USER_2_ID = 'fk_games_user_2_id';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_1_id')->nullable();
            $table->unsignedBigInteger('user_2_id')->nullable();
            $table->unsignedBigInteger('current_turn');
            $table->unsignedBigInteger('winner')->nullable();
            $table->timestamp('end_at')->nullable();
            $table->timestamps();

            $table->foreign('user_1_id', self::FK_USER_1_ID)
                ->references('id')
                ->on('users');

            $table->foreign('user_2_id', self::FK_USER_2_ID)
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('games', function (Blueprint $table) {
//            SQLLite doesn't support foreign key drop
//            $table->dropForeign(self::FK_USER_1_ID);
//            $table->dropForeign(self::FK_USER_2_ID);
        });

        Schema::dropIfExists('games');
    }
};
