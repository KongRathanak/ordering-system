<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => config('backpack.base.web_middleware', 'web'),
], function () {
    Route::group([
        'namespace'  => 'App\Http\Controllers\Auth',
    ], function () {
        // Authentication Routes...
        Route::get('login', 'LoginController@showLoginForm')->name('backpack.auth.login');
        Route::post('login', 'LoginController@login');
        Route::get('logout', 'LoginController@logout')->name('backpack.auth.logout');
        Route::post('logout', 'LoginController@logout');
    });

    Route::group([
        'middleware' => config('backpack.base.middleware_key', 'admin')
    ], function() {

        Route::group([
            'namespace'  => 'App\Http\Controllers\Admin',
        ], function () {
            Route::crud('article', 'ArticleCrudController');
            Route::group([
                'middleware' => 'check.superadmin'
            ], function () {
                Route::get('log', 'LogController@index')->name('log.index');
                Route::get('log/preview/{file_name}', 'LogController@preview')->name('log.show');
                Route::get('log/download/{file_name}', 'LogController@download')->name('log.download');
                Route::delete('log/delete/{file_name}', 'LogController@delete')->name('log.destroy');
                Route::get('log/delete_all', 'LogController@deleteAll')->name('log.delete_all');
            });
        });

        Route::group([
            'namespace' => 'JoeDixon\\Translation\\Http\\Controllers'
        ], function ($router) {
            $router->get(config('translation.ui_url'), 'LanguageController@index')
                ->name('languages.index');

            $router->get(config('translation.ui_url').'/create', 'LanguageController@create')
                ->name('languages.create');

            $router->post(config('translation.ui_url'), 'LanguageController@store')
                ->name('languages.store');

            $router->get(config('translation.ui_url').'/{language}/translations', 'LanguageTranslationController@index')
                ->name('languages.translations.index');

            $router->post(config('translation.ui_url').'/{language}', 'LanguageTranslationController@update')
                ->name('languages.translations.update');

            $router->get(config('translation.ui_url').'/{language}/translations/create', 'LanguageTranslationController@create')
                ->name('languages.translations.create');

            $router->post(config('translation.ui_url').'/{language}/translations', 'LanguageTranslationController@store')
                ->name('languages.translations.store');
        });
    });
});
