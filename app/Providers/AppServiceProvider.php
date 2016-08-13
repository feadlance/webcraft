<?php

namespace Webcraft\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Validator::extend('minecraft_username', function($attribute, $value, $parameters, $validator) {
            return preg_match("/^[a-zA-Z0-9_]+$/", $value) == 1;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
      $this->app->singleton(\Webcraft\Helpers\Websend\Websend::class, function ($app) {
          return new \Websend(config('minecraft'));
      });
    }
}
