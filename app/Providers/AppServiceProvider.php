<?php

namespace App\Providers;

use App\Actions\Tournament\Scoring\ScoringTable;
use App\Actions\Tournament\Scoring\ScoringTableInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();
        Model::preventLazyLoading();

        Gate::define('admin-panel', fn (User $user) => $user->is_admin);

        $this->app->bind(ScoringTableInterface::class, ScoringTable::class);
    }
}
