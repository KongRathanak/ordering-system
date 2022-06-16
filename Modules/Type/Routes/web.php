<?php

use Modules\Type\Http\Controllers\TypeCrudController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('admin')
    ->middleware([
        config('backpack.base.web_middleware', 'web'),
        config('backpack.base.middleware_key', 'admin')
    ])
    ->group(function () {
        Route::crud('type', 'TypeCrudController');
        Route::post('type/{id}/restore', [TypeCrudController::class, 'restore'])->name('type.restore');
    });
