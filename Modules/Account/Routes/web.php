<?php

use Modules\Audits\Http\Controllers\AuditsController;
use Modules\Account\Http\Controllers\AccountCrudController;
use Modules\Account\Http\Controllers\ContactCrudController;
use Modules\Account\Http\Controllers\Admin\ContactController;

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

Route::prefix('admin')->middleware(
    array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ))->group(function() {
    Route::crud('account', 'AccountCrudController');
    Route::crud('contact', 'ContactCrudController');
    Route::post('account/{id}/restore', [AccountCrudController::class, 'restore'])->name('account.restore');
    Route::post('contact/{id}/restore', [ContactCrudController::class, 'restore'])->name('contact.restore');
    Route::get('ajax-nested', 'AccountCrudController@ajaxNested')->name('web-api.ajax-nested');
    Route::post('contact-to-user', [ContactController::class, 'convertContactToUser'])->name('contact.to.user');
});

