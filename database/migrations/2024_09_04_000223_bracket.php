<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bears', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('slug')->unique();
            $table->string('profile_image')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();

            $table->string('label');
            $table->string('slug')->unique();

            $table->datetime('registration_opens_at');
            $table->datetime('registration_closes_at');

            $table->boolean('archived')->default(false);
            $table->tinyInteger('order_index');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('tournament_matches', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tournament_id')->index();

            $table->date('match_date');
            $table->tinyInteger('sequence');
            $table->boolean('is_bye');

            $table->foreignId('first_prior_tournament_match_id')->nullable()->index();
            $table->foreignId('first_bear_id')->nullable()->index();

            $table->foreignId('second_prior_tournament_match_id')->nullable()->index();
            $table->foreignId('second_bear_id')->nullable()->index();

            $table->foreignId('winning_bear_id')->nullable()->index();

            $table->timestamps();
            $table->softDeletes();
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
