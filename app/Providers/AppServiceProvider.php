<?php

namespace App\Providers;

use Exception;
use App\Models\User;
use App\Traits\LogError;
use App\Observers\UserObserver;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;


class AppServiceProvider extends ServiceProvider
{
    use LogError;
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
        Validator::extend('phone_number', function ($attribute, $phone) {
            try {
                preg_match('/^[+]([\/+0-9])+$/', $phone, $isValidNumber);
                $splitPhone = strlen(substr($phone, 4));

                if ($isValidNumber && (mb_substr($phone, 0, 4) == '+855' && ($splitPhone >= 7 && $splitPhone <= 9))) {
                    $res =  true;
                } else {
                    $res = '';
                }

                return $res;
            } catch (Exception $e) {
                $this->logError($attribute, get_class($this), __FUNCTION__);
                $this->logError($e, get_class($this), __FUNCTION__);
                return false;
            }
        });
        Validator::replacer('phone_number', function () {
            return 'invalid format, this is allowed charactor: + 0-9';
        });
        Validator::extend('unique_combo', function ($attribute, $value, $parameters, $validator) {
            $query = DB::table($parameters[0])
                ->where($attribute, $value)
                ->where($parameters[1], request($parameters[1]));

            if (isset($parameters[2])) {
                $query = $query->where('id', '<>', $parameters[2]);
            }

            $validator->addReplacer('unique_combo', function($message, $attribute) {
                return str_replace(':attribute', $attribute, $message);
            });


            return ($query->count() <= 0);
        }, 'The two fields must be unique! :attribute');
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
