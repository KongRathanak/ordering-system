<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Backpack\NewsCRUD Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are
| handled by the Backpack\NewsCRUD package.
|
*/

Route::group([
    'namespace' => 'App\Http\Controllers\Admin',
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', 'admin'],
], function () {
    Route::crud('article', 'ArticleCrudController');
    Route::post('article/{id}/restore', [ArticleCrudController::class, 'restore'])->name('article.restore');
    Route::crud('category', 'CategoryCrudController');
    Route::post('category/{id}/restore', [CategoryCrudController::class, 'restore'])->name('category.restore');
    Route::crud('tag', 'TagCrudController');
    Route::post('tag/{id}/restore', [TagCrudController::class, 'restore'])->name('tag.restore');
});
