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
        $this->registerAuthGuard();
        $this->registerPublishing();

        $this->loadViewsFrom(
            __DIR__.'/../resources/views', 'reliqui'
        );
    }

    /**
     * Register the reliqui routes.
     *
     * @return void
     */
    private function registerRoutes()
    {
        $path = config('reliqui.path');

        Route::namespace('Reliqui\Ambulatory\Http\Controllers\Auth')
            ->middleware(['web', RedirectIfAuthenticated::class])
            ->as('reliqui.')
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
            ->as('reliqui.')
            ->prefix($path)
            ->group(function () {
                $this->loadRoutesFrom(__DIR__.'/Http/routes.php');
            });
    }

    /**
     * Register reliqui authentication guard.
     *
     * @return void
     */
    private function registerAuthGuard()
    {
        $this->app['config']->set('auth.providers.reliqui_users', [
            'driver' => 'eloquent',
            'model'  => ReliquiUsers::class,
        ]);

        $this->app['config']->set('auth.guards.reliqui', [
            'driver'   => 'session',
            'provider' => 'reliqui_users',
        ]);
    }

    /**
     * Register the reliqui resources.
     *
     * @return void
     */
    private function registerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../public' => public_path('vendor/reliqui'),
            ], 'reliqui-assets');

            $this->publishes([
                __DIR__.'/../config/ambulatory.php' => config_path('reliqui.php'),
            ], 'reliqui-config');
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
            __DIR__.'/../config/ambulatory.php', 'reliqui'
        );

        $this->commands([
            Console\InstallCommand::class,
            Console\MigrateCommand::class,
        ]);
    }
}
