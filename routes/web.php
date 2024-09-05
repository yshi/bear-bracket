<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', Controllers\DashboardController::class)->name('dashboard');
    Route::get('/help', fn () => view('help'))->name('help');

    Route::get('tournament/{tournament}', [Controllers\BracketController::class, 'index'])->name('tournament');
    Route::get('tournament/{tournament}/bracket/{bracket}', [Controllers\BracketController::class, 'show'])->name('bracket');

    Route::get('tournament/{tournament}/scoreboard/{division}', [Controllers\ScoreboardController::class, 'show'])->name('scoreboard.division');
    Route::get('tournament/{tournament}/scoreboard', [Controllers\ScoreboardController::class, 'index'])->name('scoreboard.overall');
});
