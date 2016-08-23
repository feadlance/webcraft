<?php

namespace Webcraft\Providers;

use Validator;
use Carbon\Carbon;

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
        Validator::extend('minecraft_username', function($attribute, $value, $parameters, $validator) {
            return preg_match("/^[a-zA-Z0-9_]+$/", $value) == 1;
        });

        Carbon::setLocale(config('app.locale'));
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
      $this->app->singleton(\Webcraft\Helpers\Minecraft\Query::class, function ($app) {
          return new \MinecraftQuery(config('minecraft'));
      });

      $this->app->singleton(\Webcraft\Helpers\Minecraft\Rcon::class, function ($app) {
          return new \MinecraftRcon(config('minecraft'));
      });
    }
}
