<?php

namespace App\Providers;

use App\Models\User;
use App\Observers\UserObserver;
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

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (env('APP_ENV') == 'production') {
            $this->app['request']->server->set('HTTPS', true);
        }

        User::observe(UserObserver::class);
        $this->overrideConfigValues();
    }

    protected function overrideConfigValues()
    {
        $config = [];
        if (config('settings.project_name')) {
            $config['backpack.base.project_name'] = config('settings.project_name');
        }
        if (config('settings.project_logo')) {
            $config['backpack.base.project_logo'] = config('settings.project_logo');
        }
        if (config('settings.browser_tab_logo')) {
            $config['backpack.base.browser_tab_logo'] = config('settings.browser_tab_logo');
        }
        config($config);
    }
}
