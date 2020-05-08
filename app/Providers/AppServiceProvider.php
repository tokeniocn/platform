<?php

namespace App\Providers;

use Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Sets third party service providers that are only needed on local/testing environments
        if ($this->app->environment() !== 'production') {
            /**
             * Loader for registering facades.
             */
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();

            // Load third party local aliases
            $loader->alias('Debugbar', \Barryvdh\Debugbar\Facade::class);
        }

        // 开启sql日志监控,  `tail -f storage/logs/laravel.sql`可实时观察sql
        if (env('LOG_QUERY', false)) {
            \DB::listen(function($query) {
                $tmp = str_replace('?', '"'.'%s'.'"', $query->sql);
                $tmp = vsprintf($tmp, $query->bindings);
                $tmp = str_replace("\\","",$tmp);
                \Log::debug(' execution time: '.$query->time.'ms; '.$tmp."\n\n\t");
            });
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }
}
