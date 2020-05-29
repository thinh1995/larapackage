<?php

namespace lucifer\Press;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use lucifer\Press\Facades\Press;

class PressBaseServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->registerPublishing();
        }

        $this->registerResources();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            Console\ProcessCommand::class,
        ]);
    }

    private function registerResources()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'press');

        $this->registerFacades();
        $this->registerRoutes();
    }

    private function registerPublishing()
    {
        $this->publishes([
            __DIR__.'/../config/press.php' => config_path('press.php'),
        ], 'press-config');
    }

    protected function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
           $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }

    private function routeConfiguration()
    {
        return [
            'prefix' => Press::path(),
        ];
    }

    protected function registerFacades()
    {
        $this->app->singleton('Press', function($app) {
            return new \lucifer\Press\Press();
        });
    }
}