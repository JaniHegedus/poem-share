<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Poem;
use App\Policies\PoemPolicy;

class AppServiceProvider extends ServiceProvider
{
    protected array $policies = [
        Poem::class => PoemPolicy::class,
    ];
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
        //
    }
}
