<?php

namespace App\Providers;

use App\View\Composers\AuthenticatedLayoutComposer;
use Illuminate\Support\Facades\View;
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
        View::composer('components.dashboard.admin', fn ($view) => $view->with('calendarios', \App\Models\Semestre::orderByDesc('id')->get()));
        View::composer('layouts.app', AuthenticatedLayoutComposer::class);
    }
}
