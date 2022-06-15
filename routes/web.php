<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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

Route::get('lang/{locale}', function ($locale) {
    $locale = strtolower($locale);
    if (!in_array($locale, ['en', 'kh'])) {
        abort(400);
    }

    Session::put('locale', $locale);
    return redirect()->back();
});

Route::get('theme/{color}', function ($color) {
    $color = strtolower($color);
    if (!in_array($color, ['dark', 'light'])) {
        abort(400);
    }

    Session::put('theme', $color);
    return redirect()->back();
});

Route::redirect('/', '/admin');

Route::get('{page}/{subs?}', ['uses' => '\App\Http\Controllers\PageController@index'])
    ->where(['page' => '^(((?=(?!admin))(?=(?!\/)).))*$', 'subs' => '.*']);
