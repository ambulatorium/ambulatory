<?php

namespace Reliqui\Ambulatory;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Reliqui\Ambulatory\Http\Middleware\Authenticate;
use Reliqui\Ambulatory\Http\Middleware\RedirectIfAuthenticated;

class AmbulatoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerRoutes();
        $this->registerMigrations();
        $this->registerAuthGuard();
        $this->registerPublishing();

        $this->loadViewsFrom(
            __DIR__.'/../resources/views', 'ambulatory'
        );
    }

    /**
     * Register ambulatory routes.
     *
     * @return void
     */
    private function registerRoutes()
    {
        $path = config('ambulatory.path');

        Route::namespace('Reliqui\Ambulatory\Http\Controllers\Auth')
            ->middleware(['web', RedirectIfAuthenticated::class])
            ->as('ambulatory.')
            ->prefix($path)
            ->group(function () {
                Route::get('/login', 'LoginController@showLoginForm')->name('auth.login');
                Route::post('/login', 'LoginController@login')->name('auth.attempt');

                Route::get('/register', 'RegisterController@showRegistrationForm')->name('auth.register');
                Route::post('/register', 'RegisterController@register')->name('auth.register.post');

                Route::get('/password/forgot', 'ForgotPasswordController@showResetRequestForm')->name('password.forgot');
                Route::post('/password/forgot', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
                Route::get('/password/reset/{token}', 'ForgotPasswordController@showNewPassword')->name('password.reset');

                Route::get('/invitation/{token}', 'AcceptInvitationController@show')->name('accept.invitation.show');
            });

        Route::namespace('Reliqui\Ambulatory\Http\Controllers')
            ->middleware(['web', Authenticate::class])
            ->as('ambulatory.')
            ->prefix($path)
            ->group(function () {
                $this->loadRoutesFrom(__DIR__.'/Http/routes.php');
            });
    }

    /**
     * Register ambulatory migrations.
     *
     * @return void
     */
    private function registerMigrations()
    {
        $this->loadMigrationsFrom(
            __DIR__.'/Migrations'
        );
    }

    /**
     * Register ambulatory authentication guard.
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
     * Register ambulatory resources.
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
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/ambulatory.php', 'ambulatory'
        );

        $this->commands([
            Console\InstallCommand::class,
            Console\MigrateCommand::class,
        ]);
    }
}
