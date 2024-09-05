<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use Illuminate\Http\RedirectResponse;

class DashboardController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        $tournament = Tournament::active()->first();
        if (! $tournament) {
            return redirect(route('help'));
        }

        return redirect(route('tournament', $tournament));
    }
}
