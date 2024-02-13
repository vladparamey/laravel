<?php

namespace App\Providers;

use App\Contracts\Auth\Authentication;
use App\Services\AuthenticationServiceResolver;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(Authentication::class, function ($app) {
            $resolver = new AuthenticationServiceResolver($app->make(Request::class));

            return $resolver->resolve();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
