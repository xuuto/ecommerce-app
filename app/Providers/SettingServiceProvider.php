<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

class SettingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('settings', function ($app) {
            return new Setting();
        });
        $loader = AliasLoader::getInstance();
        $loader->alias('Setting', Setting::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (!App::runningInConsole() && count(Schema::getColumnListing('settings'))) {
            $settings = Setting::all();
            foreach ($settings as $key => $setting) {
                // Config::set('settings.'.$setting->key, $setting->value);
                Config::set('settings.' . $setting->key, $setting->value);
            }
        }
    }
}
