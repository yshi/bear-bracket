<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_brackets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->index();
            $table->foreignId('tournament_id')->index();

            $table->boolean('completed_selections')->default(false);
            $table->tinyInteger('score')->default(0);

            $table->timestamps();
            $table->unique(['user_id', 'tournament_id']);
        });

        Schema::create('user_bracket_matches', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_bracket_id')->index();
            $table->foreignId('tournament_match_id')->index();

            $table->foreignId('selected_bear_id')->index();

            $table->timestamps();
            $table->unique(['user_bracket_id', 'tournament_match_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        throw new Exception('No rolling back');
    }
};
