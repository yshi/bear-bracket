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

    Route::get('tournament/{tournament:slug}', [Controllers\BracketController::class, 'index'])->name('tournament');
    Route::get('tournament/{tournament:slug}/bracket/{bracket}', [Controllers\BracketController::class, 'show'])->name('bracket');

    Route::get('tournament/{tournament:slug}/scoreboard/{division:slug}', [Controllers\ScoreboardController::class, 'show'])->name('scoreboard.division');
    Route::get('tournament/{tournament:slug}/scoreboard', [Controllers\ScoreboardController::class, 'index'])->name('scoreboard.overall');
});
