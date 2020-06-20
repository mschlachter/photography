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
        // Load our dynamic user-configurable settings
        if(\Schema::hasTable('settings')) {
            $settings = cache()->remember('settings', 24*60, function() {
                return \App\Setting::pluck('value', 'key')->toArray();
            });

            foreach ($settings as $key => $value) {
                config()->set('settings.' . $key, $value);
            }
        }
    }
}
