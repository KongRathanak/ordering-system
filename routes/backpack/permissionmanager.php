<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserCrudController;

/*
|--------------------------------------------------------------------------
| Backpack\PermissionManager Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are
| handled by the Backpack\PermissionManager package.
|
*/

Route::group([
    'namespace'  => 'App\Http\Controllers\Admin',
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', backpack_middleware()],
], function () {
    Route::crud('permission', 'PermissionCrudController');
    Route::crud('role', 'RoleCrudController');
    Route::crud('user', 'UserCrudController');
    Route::post('user/{id}/restore', [UserCrudController::class, 'restore'])->name('user.restore');
});
