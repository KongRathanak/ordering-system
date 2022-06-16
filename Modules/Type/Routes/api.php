<?php

use Modules\Type\Http\Controllers\API\TypeAPIController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['service.token']], function () {
    Route::get('get-wallet-types', [TypeAPIController::class, 'getWalletTypes']);
});
