<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use App\Services\AppearanceService;

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
        Gate::before(fn (User $user, string $ability) => $user->role === 'owner' ? true : null);
        Gate::define('access-admin', fn (User $user): bool => $user->isAdmin() || $user->canNexus('admin.access'));
        RateLimiter::for('login', fn (Request $request) => Limit::perMinute(5)->by(strtolower((string) $request->input('email')).'|'.$request->ip()));
        View::composer('*', function ($view): void {
            $view->with('nexusAppearance', app(AppearanceService::class)->all());
        });
    }
}
