<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers',
], function () {
    // custom admin routes
    Route::group([
        'namespace'  => 'Admin\\',
    ], function () {
        Route::crud('job', 'JobCrudController');
        Route::crud('failed_job', 'FailedJobCrudController');
        Route::crud('products', 'ProductsCrudController');
        Route::crud('orders', 'OrdersCrudController');
    });


});
