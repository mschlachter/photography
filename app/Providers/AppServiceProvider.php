<?php

namespace App\Providers;

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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $settings = cache()->remember('settings', 24*60, function() {
            return \App\Setting::pluck('value', 'key')->toArray();
        });

        foreach ($settings as $key => $value) {
            config()->set('settings.' . $key, $value);
        }
    }
}
