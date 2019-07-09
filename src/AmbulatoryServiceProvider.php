<?php

namespace Ambulatory\Ambulatory;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Ambulatory\Ambulatory\Http\Middleware\Authenticate;
use Ambulatory\Ambulatory\Http\Middleware\RedirectIfAuthenticated;

class AmbulatoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot(Ambulatory $ambulatory)
    {
        $this->registerRoutes();
        $this->registerMigrations();
        $this->registerAuthGuard();
        $this->registerPublishing();
        $this->registerResourceViews();

        $ambulatory->registerPolicies();
    }

    /**
     * Register the package routes.
     *
     * @return void
     */
    private function registerRoutes()
    {
        $path = config('ambulatory.path');

        Route::namespace('Ambulatory\Ambulatory\Http\Controllers\Auth')
            ->middleware(['web', RedirectIfAuthenticated::class])
            ->as('ambulatory.')
            ->prefix($path)
            ->group(function () {
                $this->loadRoutesFrom(__DIR__.'/../routes/auth.php');
            });

        Route::namespace('Ambulatory\Ambulatory\Http\Controllers')
            ->middleware(['web', Authenticate::class])
            ->as('ambulatory.')
            ->prefix($path)
            ->group(function () {
                $this->loadRoutesFrom(__DIR__.'/../routes/dashboard.php');
            });
    }

    /**
     * Register the package's migrations.
     *
     * @return void
     */
    private function registerMigrations()
    {
        $this->loadMigrationsFrom(__DIR__.'/Migrations');
    }

    /**
     * Register the package's authentication guard.
     *
     * @return void
     */
    private function registerAuthGuard()
    {
        $this->app['config']->set('auth.providers.ambulatory_users', [
            'driver' => 'eloquent',
            'model'  => User::class,
        ]);

        $this->app['config']->set('auth.guards.ambulatory', [
            'driver'   => 'session',
            'provider' => 'ambulatory_users',
        ]);
    }

    /**
     * Register the package's publishable resources.
     *
     * @return void
     */
    private function registerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../public' => public_path('vendor/ambulatory'),
            ], 'ambulatory-assets');

            $this->publishes([
                __DIR__.'/../config/ambulatory.php' => config_path('ambulatory.php'),
            ], 'ambulatory-config');
        }
    }

    /**
     * Register the package resource views.
     *
     * @return void
     */
    public function registerResourceViews()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'ambulatory');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/ambulatory.php', 'ambulatory');

        $this->commands([
            Console\InstallCommand::class,
            Console\MigrateCommand::class,
        ]);
    }
}
