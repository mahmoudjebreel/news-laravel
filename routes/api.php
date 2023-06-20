<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->namespace('API')->group(function () {
    Route::post('login', 'UserApiAuthController@login');
    Route::post('register', 'UserApiAuthController@register');
});

Route::prefix('auth')->namespace('API')->middleware('auth:api')->group(function () {
    Route::get('logout', 'UserApiAuthController@logout');
});

Route::prefix('categories/')->namespace('API')->group(function () {
    Route::get('', 'CategoryController@index');
    Route::get('{id}/articles', 'CategoryController@showArticles');
});
